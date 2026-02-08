<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Platform\DashboardController;
use App\Http\Controllers\Platform\MosquesController;
use App\Http\Controllers\Platform\PlansController;
use App\Http\Controllers\Platform\SubscriptionsController;
use App\Http\Controllers\Platform\OverridesController;
use App\Http\Controllers\Platform\LogsController;
use App\Http\Controllers\Platform\ResellersController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Mosque Management
Route::resource('mosques', MosquesController::class);
Route::post('mosques/{mosque}/suspend', [MosquesController::class, 'suspend'])->name('mosques.suspend');
Route::post('mosques/{mosque}/activate', [MosquesController::class, 'activate'])->name('mosques.activate');

// Overrides & Usage
Route::get('mosques/{mosque}/overrides', [OverridesController::class, 'edit'])->name('mosques.overrides.edit');
Route::put('mosques/{mosque}/overrides', [OverridesController::class, 'update'])->name('mosques.overrides.update');

// Subscription Management
Route::get('mosques/{mosque}/subscription', [SubscriptionsController::class, 'edit'])->name('mosques.subscription.edit');
Route::put('mosques/{mosque}/subscription', [SubscriptionsController::class, 'update'])->name('mosques.subscription.update');

// Plans (Super Admin Only)
Route::middleware('can:isSuperAdmin,auth:platform')->group(function() {
    Route::resource('plans', PlansController::class);
    Route::resource('resellers', ResellersController::class);
});

// Logs & Monitoring
Route::get('logs/webhooks', [LogsController::class, 'webhooks'])->name('logs.webhooks');
Route::get('logs/audit', [LogsController::class, 'audit'])->name('logs.audit');
