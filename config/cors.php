<?php

return [

    'paths' => [
        '/',       // supaya `GET http://127.0.0.1:8000/` dibolehkan CORS
        'api/*',   // semua route di bawah /api/…
    ],

    'allowed_methods' => ['*'], // semua method (GET, POST, PUT, DELETE, OPTIONS)
    
    // Hanya React di port 5173 yang diizinkan
    'allowed_origins' => [
        'http://localhost:5173',
        // tambahkan 'https://localhost:5173' jika pakai HTTPS
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // semua header diizinkan

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false, 
];
