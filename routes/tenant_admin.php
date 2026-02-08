<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\WhatsAppDashboardController;
use App\Http\Controllers\Tenant\WhatsAppSubscribersController;
use App\Http\Controllers\Tenant\WhatsAppSegmentsController;
use App\Http\Controllers\Tenant\WhatsAppTemplatesController;
use App\Http\Controllers\Tenant\WhatsAppBroadcastController;
use App\Http\Controllers\Tenant\WhatsAppProviderSettingsController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('module:lectures')->group(function() {
    Route::resource('lectures', App\Http\Controllers\Tenant\LectureManagerController::class);
    Route::resource('speakers', App\Http\Controllers\Tenant\SpeakerManagerController::class);
});

Route::middleware('module:donations')->group(function() {
    Route::resource('campaigns', App\Http\Controllers\Tenant\CampaignManagerController::class);
    Route::get('/donations/report', [App\Http\Controllers\Tenant\DonationReportController::class, 'index'])->name('donations.report');
});

Route::middleware('module:fatwas')->group(function() {
    Route::get('/fatwas/pending', [App\Http\Controllers\Tenant\FatwaModeratorController::class, 'pending'])->name('fatwas.pending');
    Route::post('/fatwas/{id}/answer', [App\Http\Controllers\Tenant\FatwaModeratorController::class, 'answer'])->name('fatwas.answer');
});

// WhatsApp Module Routes
Route::middleware('module:whatsapp_notifications')->prefix('whatsapp')->name('whatsapp.')->group(function() {
    Route::get('/', [WhatsAppDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('subscribers', WhatsAppSubscribersController::class)->only(['index', 'destroy']);
    Route::post('subscribers/import', [WhatsAppSubscribersController::class, 'import'])->name('subscribers.import');
    Route::post('subscribers/{subscriber}/block', [WhatsAppSubscribersController::class, 'block'])->name('subscribers.block');
    Route::post('subscribers/{subscriber}/unblock', [WhatsAppSubscribersController::class, 'unblock'])->name('subscribers.unblock');

    Route::resource('segments', WhatsAppSegmentsController::class);
    Route::post('segments/{segment}/sync', [WhatsAppSegmentsController::class, 'syncAll'])->name('segments.sync');

    Route::resource('templates', WhatsAppTemplatesController::class);

    // Admin/Finance Only Routes for Broadcast and Provider
    Route::middleware('can:manage-finance')->group(function() {
        Route::get('broadcast', [WhatsAppBroadcastController::class, 'create'])->name('broadcast.create');
        Route::post('broadcast', [WhatsAppBroadcastController::class, 'store'])->name('broadcast.store');
        Route::get('outbox', [WhatsAppBroadcastController::class, 'index'])->name('outbox.index');
        Route::get('outbox/{message}', [WhatsAppBroadcastController::class, 'show'])->name('outbox.show');
        
        Route::get('provider', [WhatsAppProviderSettingsController::class, 'edit'])->name('provider.edit');
        Route::put('provider', [WhatsAppProviderSettingsController::class, 'update'])->name('provider.update');
        Route::post('provider/test', [WhatsAppProviderSettingsController::class, 'test'])->name('provider.test');
    });
});
