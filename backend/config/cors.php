<?php

return [
    'paths' => ['*'], // Allow CORS for all routes (or specify 'users/*' for your routes)
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://blue-bear-390583.hostingersite.com','http://127.0.0.1:8080', 'http://localhost:8080'], // Allow both for flexibility
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];