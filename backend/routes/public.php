<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\MosqueHomeController;
use App\Http\Controllers\Public\DonationCheckoutController;
use App\Http\Controllers\Public\WishWebhookController;
use App\Http\Controllers\Public\WhatsAppPublicController;

Route::middleware(['tenant.resolve'])->group(function() {
    Route::get('/', [MosqueHomeController::class, 'index'])->name('home');
    Route::get('/prayer-times', [MosqueHomeController::class, 'prayerTimes'])->name('prayer_times');
    
    Route::middleware('module:donations')->group(function() {
        Route::get('/donations', [MosqueHomeController::class, 'donations'])->name('donations');
        Route::get('/campaigns/{campaign}/donate', [DonationCheckoutController::class, 'show'])->name('donations.donate');
        Route::post('/campaigns/{campaign}/donate', [DonationCheckoutController::class, 'process'])->name('donations.process');
        Route::get('/donations/{donation}/success', [DonationCheckoutController::class, 'success'])->name('donations.success');
        Route::get('/donations/{donation}/failed', [DonationCheckoutController::class, 'failed'])->name('donations.failed');
    });

    Route::middleware('module:whatsapp_notifications')->prefix('whatsapp')->name('whatsapp.')->group(function() {
        Route::middleware('throttle:5,1')->group(function() {
            Route::get('/subscribe', [WhatsAppPublicController::class, 'showSubscribe'])->name('subscribe');
            Route::post('/subscribe', [WhatsAppPublicController::class, 'processSubscribe'])->name('subscribe.process');
            Route::get('/unsubscribe', [WhatsAppPublicController::class, 'showUnsubscribe'])->name('unsubscribe');
            Route::post('/unsubscribe', [WhatsAppPublicController::class, 'processUnsubscribe'])->name('unsubscribe.process');
        });
        Route::get('/subscribed', [WhatsAppPublicController::class, 'subscribed'])->name('subscribed');
        Route::get('/unsubscribed', [WhatsAppPublicController::class, 'unsubscribed'])->name('unsubscribed');
    });

    Route::get('/lectures', [MosqueHomeController::class, 'lectures'])->name('lectures');

    Route::post('/payments/wish/webhook', [WishWebhookController::class, 'handle'])
        ->name('api.webhook.wish');
});
