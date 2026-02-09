<?php

return [
    'wish_money' => [
        'base_url' => env('WISH_MONEY_BASE_URL', 'https://api.wishmoney.com'),
        'callback_url' => env('WISH_MONEY_CALLBACK_URL', 'http://localhost:8000/api/public/{slug}/payments/wish/webhook'),
    ],
];
