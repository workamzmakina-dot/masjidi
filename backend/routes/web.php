<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Mosque SaaS API. Use /api for endpoints.'
    ]);
});
