<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Public\MosquePublicController;
use App\Http\Controllers\Api\Public\DonationController;
use App\Http\Controllers\Api\Public\WishWebhookController;
use App\Http\Controllers\Api\Public\WhatsAppPublicController;

Route::get('mosques/{slug}', [MosquePublicController::class, 'show']);
Route::get('mosques/{slug}/prayers', [MosquePublicController::class, 'prayers']);
Route::get('mosques/{slug}/lectures', [MosquePublicController::class, 'lectures']);
Route::get('mosques/{slug}/events', [MosquePublicController::class, 'events']);
Route::get('mosques/{slug}/campaigns', [MosquePublicController::class, 'campaigns']);
Route::get('mosques/{slug}/alerts', [MosquePublicController::class, 'alerts']);
Route::get('mosques/{slug}/announcements', [MosquePublicController::class, 'announcements']);
Route::get('mosques/{slug}/fatwas', [MosquePublicController::class, 'fatwas']);

Route::post('mosques/{slug}/donations', [DonationController::class, 'store']);

Route::post('mosques/{slug}/whatsapp/subscribe', [WhatsAppPublicController::class, 'subscribe']);
Route::post('mosques/{slug}/whatsapp/unsubscribe', [WhatsAppPublicController::class, 'unsubscribe']);

Route::post('mosques/{slug}/payments/wish/webhook', [WishWebhookController::class, 'handle']);
