<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Platform\MosqueController;
use App\Http\Controllers\Api\Platform\PlanController;
use App\Http\Controllers\Api\Platform\SubscriptionController;
use App\Http\Controllers\Api\Platform\FeatureOverrideController;
use App\Http\Controllers\Api\Platform\AuditLogController;
use App\Http\Controllers\Api\Platform\FeatureController;

Route::get('features', [FeatureController::class, 'index']);
Route::apiResource('mosques', MosqueController::class);
Route::apiResource('plans', PlanController::class);
Route::get('subscriptions', [SubscriptionController::class, 'index']);
Route::post('subscriptions', [SubscriptionController::class, 'store']);
Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update']);

Route::get('feature-overrides', [FeatureOverrideController::class, 'index']);
Route::post('feature-overrides', [FeatureOverrideController::class, 'store']);
Route::put('feature-overrides/{override}', [FeatureOverrideController::class, 'update']);

Route::get('audit-logs', [AuditLogController::class, 'index']);
