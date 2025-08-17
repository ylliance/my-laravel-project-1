<?php

use App\Services\AlipayPlus\Signer;
use GuzzleHttp\Client as HttpClient;

class Client
{
    /** @var HttpClient */
    private $http;
    /** @var Signer */
    private $signer;
    /** @var string */
    private $host;
    /** @var string */
    private $clientId;

    public function __construct(Signer $signer, string $host, string $clientId)
    {
        $this->signer = $signer;
        $this->host = rtrim($host, '/');
        $this->clientId = $clientId;
        $this->http = new HttpClient([
            'base_uri' => $this->host,
            'timeout' => 20,
        ]);
    }

    /** POST to an Alipay+ endpoint with signed headers and verify response signature. */
    public function post(string $endpoint, array $body): array
    {
        $uri = '/' . ltrim($endpoint, '/');
        // Use RFC3339 UTC without escape sequences
        $time = gmdate('Y-m-d') . 'T' . gmdate('H:i:s') . 'Z';

        $signature = $this->signer->signRequest('POST', $uri, $time, $body);

        $resp = $this->http->post($uri, [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
                'Client-Id' => $this->clientId,
                'Request-Time' => $time,
                'Signature' => $signature,
            ],
            'json' => $body,
        ]);

        $respBody = (string) $resp->getBody();
        $respClientId = $resp->getHeaderLine('Client-Id');
        $respTime = $resp->getHeaderLine('Response-Time');
        $respSignature = $resp->getHeaderLine('Signature');

        $sigParts = Signer::parseSignatureHeader($respSignature);
        $ok = isset($sigParts['signature']) && $this->signer->verifySignature('POST', $uri, $respClientId, $respTime, $respBody, $sigParts['signature']);
        if (!$ok) {
            throw new \RuntimeException('Invalid Alipay+ response signature');
        }

        $json = json_decode($respBody, true);
        return is_array($json) ? $json : [];
    }
}
