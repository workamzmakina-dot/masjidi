<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Tenant\DashboardController;
use App\Http\Controllers\Api\Tenant\PrayerSettingsController;
use App\Http\Controllers\Api\Tenant\LectureController;
use App\Http\Controllers\Api\Tenant\SpeakerController;
use App\Http\Controllers\Api\Tenant\EventController;
use App\Http\Controllers\Api\Tenant\FatwaController;
use App\Http\Controllers\Api\Tenant\CampaignController;
use App\Http\Controllers\Api\Tenant\DonationController;
use App\Http\Controllers\Api\Tenant\WhatsAppSubscriberController;
use App\Http\Controllers\Api\Tenant\WhatsAppSegmentController;
use App\Http\Controllers\Api\Tenant\WhatsAppTemplateController;
use App\Http\Controllers\Api\Tenant\WhatsAppProviderController;
use App\Http\Controllers\Api\Tenant\WhatsAppBroadcastController;
use App\Http\Controllers\Api\Tenant\RamadanSettingsController;
use App\Http\Controllers\Api\Tenant\AlertController;
use App\Http\Controllers\Api\Tenant\AnnouncementController;
use App\Http\Controllers\Api\Tenant\QrCodeController;
use App\Http\Controllers\Api\Tenant\BrandingController;

Route::get('dashboard', [DashboardController::class, 'index']);

Route::get('prayer-settings', [PrayerSettingsController::class, 'show']);
Route::put('prayer-settings', [PrayerSettingsController::class, 'update']);

Route::apiResource('lectures', LectureController::class);
Route::apiResource('speakers', SpeakerController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('campaigns', CampaignController::class);
Route::get('donations', [DonationController::class, 'index']);

Route::get('fatwas', [FatwaController::class, 'index']);
Route::post('fatwas/{fatwa}/answer', [FatwaController::class, 'answer']);

Route::apiResource('whatsapp/subscribers', WhatsAppSubscriberController::class)->only(['index', 'store', 'destroy']);
Route::post('whatsapp/subscribers/{subscriber}/block', [WhatsAppSubscriberController::class, 'block']);
Route::post('whatsapp/subscribers/{subscriber}/unblock', [WhatsAppSubscriberController::class, 'unblock']);

Route::apiResource('whatsapp/segments', WhatsAppSegmentController::class);
Route::post('whatsapp/segments/{segment}/sync', [WhatsAppSegmentController::class, 'sync']);

Route::apiResource('whatsapp/templates', WhatsAppTemplateController::class);

Route::get('whatsapp/provider', [WhatsAppProviderController::class, 'show']);
Route::put('whatsapp/provider', [WhatsAppProviderController::class, 'update']);

Route::get('whatsapp/broadcasts', [WhatsAppBroadcastController::class, 'index']);
Route::post('whatsapp/broadcasts', [WhatsAppBroadcastController::class, 'store']);

Route::get('ramadan-settings', [RamadanSettingsController::class, 'show']);
Route::put('ramadan-settings', [RamadanSettingsController::class, 'update']);

Route::apiResource('alerts', AlertController::class);
Route::apiResource('announcements', AnnouncementController::class);
Route::apiResource('qr-codes', QrCodeController::class);

Route::get('branding', [BrandingController::class, 'show']);
Route::put('branding', [BrandingController::class, 'update']);
