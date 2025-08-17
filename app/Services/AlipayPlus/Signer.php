<?php
namespace App\Services\AlipayPlus;

class Signer
{
    /** @var string */
    private $clientId;
    /** @var string */
    private $privateKeyPem;
    /** @var string */
    private $alipayPublicKeyPem;
    /** @var int */
    private $keyVersion;

    /**
     * @param string $clientId
     * @param string $privateKeyPem
     * @param string $alipayPublicKeyPem
     * @param int    $keyVersion
     */
    public function __construct($clientId, $privateKeyPem, $alipayPublicKeyPem, $keyVersion)
    {
        $this->clientId = (string) $clientId;
        $this->privateKeyPem = (string) $privateKeyPem;
        $this->alipayPublicKeyPem = (string) $alipayPublicKeyPem;
        $this->keyVersion = (int) $keyVersion;
    }

    /** Build signature header value for request. */
    public function signRequest(string $method, string $requestUri, string $requestTimeIso8601, array $body): string
    {
        $bodyJson = $this->minifiedJson($body);
        $content = sprintf("%s %s\n%s.%s.%s",
            strtoupper($method),
            $requestUri,
            $this->clientId,
            $requestTimeIso8601,
            $bodyJson
        );
        $signature = $this->rsaSha256($content);
        return sprintf('algorithm=RSA256,keyVersion=%d,signature=%s', $this->keyVersion, $signature);
    }

    /** Verify response/webhook signature. */
    public function verifySignature(string $method, string $requestOrResponseUri, string $clientId, string $timeIso8601, string $bodyJson, string $signatureB64Url): bool
    {
        $content = sprintf("%s %s\n%s.%s.%s",
            strtoupper($method),
            $requestOrResponseUri,
            $clientId,
            $timeIso8601,
            $bodyJson
        );
        $binarySig = $this->base64UrlDecode($signatureB64Url);
        $pub = openssl_pkey_get_public($this->alipayPublicKeyPem);
        if (!$pub) {
            throw new \RuntimeException('Invalid Alipay+ public key');
        }
        $ok = openssl_verify($content, $binarySig, $pub, OPENSSL_ALGO_SHA256) === 1;
        openssl_free_key($pub);
        return $ok;
    }

    /** Sign our webhook response to Alipay+. */
    public function signResponse(string $method, string $responseUri, string $responseTimeIso, array $body): string
    {
        $bodyJson = $this->minifiedJson($body);
        $content = sprintf("%s %s\n%s.%s.%s",
            strtoupper($method),
            $responseUri,
            $this->clientId,
            $responseTimeIso,
            $bodyJson
        );
        $signature = $this->rsaSha256($content);
        return sprintf('algorithm=RSA256,keyVersion=%d,signature=%s', $this->keyVersion, $signature);
    }

    /** Extract signature parts from Signature header. */
    public static function parseSignatureHeader(string $header): array
    {
        $parts = [];
        foreach (explode(',', $header) as $chunk) {
            $pair = explode('=', $chunk, 2);
            if (count($pair) === 2) {
                $k = trim($pair[0]);
                $v = trim($pair[1]);
                $parts[strtolower($k)] = $v;
            }
        }
        return [
            'algorithm' => isset($parts['algorithm']) ? $parts['algorithm'] : null,
            'keyVersion' => isset($parts['keyversion']) ? (int) $parts['keyversion'] : null,
            'signature' => isset($parts['signature']) ? $parts['signature'] : null,
        ];
    }

    private function rsaSha256(string $content): string
    {
        $priv = openssl_pkey_get_private($this->privateKeyPem);
        if (!$priv) {
            throw new \RuntimeException('Invalid private key');
        }
        $sig = '';
        $ok = openssl_sign($content, $sig, $priv, OPENSSL_ALGO_SHA256);
        openssl_free_key($priv);
        if (!$ok) {
            throw new \RuntimeException('OpenSSL signing failed');
        }
        return $this->base64UrlEncode($sig);
    }

    private function minifiedJson(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        $decoded = base64_decode(strtr($data, '-_', '+/'));
        return $decoded === false ? '' : $decoded;
    }
}
