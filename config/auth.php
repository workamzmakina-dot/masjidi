<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        // Platform Super Admin
        'platform' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        // Mosque-specific Admin
        'tenant' => [
            'driver' => 'session',
            'provider' => 'mosque_users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'mosque_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\MosqueUser::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'mosque_users' => [
            'provider' => 'mosque_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
