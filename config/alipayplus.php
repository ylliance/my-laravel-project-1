<?php

return [
    'host' => env('ALIPAYPLUS_HOST', 'https://open-sea.alipayplus.com'),
    'client_id' => env('ALIPAYPLUS_CLIENT_ID', ''),
    'key_version' => (int) env('ALIPAYPLUS_KEY_VERSION', 1),
    'private_key' => env('ALIPAYPLUS_PRIVATE_KEY', ''),
    'alipay_public_key' => env('ALIPAYPLUS_PUBLIC_KEY', ''),
    'payment_notify_url' => env('ALIPAYPLUS_PAYMENT_NOTIFY_URL', ''),
    'payment_redirect_base' => env('ALIPAYPLUS_PAYMENT_REDIRECT_BASE', ''),
    'settlement_currency' => env('ALIPAYPLUS_SETTLEMENT_CURRENCY', null),
    'user_region' => env('ALIPAYPLUS_USER_REGION', 'HK'),
];