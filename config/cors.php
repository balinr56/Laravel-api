<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['OPTIONS', 'GET', 'POST', 'PUT', 'DELETE'],
    'allowed_origins' => ['http://localhost:8000'],
    'allowed_headers' => ['*'],
    'supports_credentials' => false,

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
