<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Result</title>
    <style>
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, sans-serif;
            margin: 2rem;
            max-width: 720px
        }
    </style>
</head>

<body>
    <h1>AlipayHK Payment</h1>
    <p><strong>Order:</strong> {{ $orderId }}</p>
    <p><strong>Status:</strong> {{ strtoupper($status) }}</p>
    <p><strong>Amount:</strong> {{ $amount }} {{ $currency }}</p>
    @if($code && $status !== 'succeeded')
    <p><strong>Code:</strong> {{ $code }}</p>
    @endif
    <p><a href="/">Back to shop</a></p>
</body>

</html>