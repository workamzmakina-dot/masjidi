<?php

namespace App\Console;

use App\Models\Mosque;
use App\Models\MosqueSubscription;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppSubscriber;
use App\Services\TenantContext;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            MosqueSubscription::whereNotNull('ends_at')
                ->where('ends_at', '<', now())
                ->update(['ends_at' => now()]);
        })->daily();

        $schedule->call(function () {
            $context = app(TenantContext::class);

            Mosque::chunk(50, function ($mosques) use ($context) {
                foreach ($mosques as $mosque) {
                    $context->set($mosque);
                    app()->instance(Mosque::class, $mosque);

                    $total = WhatsAppSubscriber::where('status', 'active')->count();

                    WhatsAppMessage::create([
                        'to_phone_e164' => null,
                        'body' => "Weekly reminder prepared for {$total} subscribers.",
                        'status' => 'logged',
                        'scheduled_at' => now(),
                    ]);
                }
            });
        })->weekly();
    }
}
