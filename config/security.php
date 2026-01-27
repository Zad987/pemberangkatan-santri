<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Security Configuration
    |--------------------------------------------------------------------------
    */

    'password_requirements' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_special_chars' => true,
        'special_chars' => '@$!%*?&'
    ],

    'session' => [
        'timeout' => env('SESSION_TIMEOUT', 120), // minutes
        'idle_timeout' => env('IDLE_TIMEOUT', 30), // minutes
        'same_device_only' => true,
    ],

    'rate_limiting' => [
        'login' => [
            'max_attempts' => 5,
            'window_minutes' => 15
        ],
        'api' => [
            'max_requests' => 100,
            'window_minutes' => 60
        ],
        'export' => [
            'max_requests' => 10,
            'window_minutes' => 60
        ],
        'payment' => [
            'max_requests' => 20,
            'window_minutes' => 60
        ]
    ],

    'audit_logging' => [
        'enabled' => true,
        'log_all_requests' => true,
        'log_successful_logins' => true,
        'log_failed_logins' => true,
        'log_password_changes' => true,
        'retention_days' => 90,
    ],

    'two_factor_auth' => [
        'enabled' => env('TWO_FACTOR_AUTH_ENABLED', false),
        'providers' => ['email', 'sms'],
    ],

    'cors' => [
        'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', '*')),
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
    ],
];
