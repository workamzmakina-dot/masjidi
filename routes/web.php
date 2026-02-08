<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome_platform'); // A generic "Sell your SaaS" landing page
});
