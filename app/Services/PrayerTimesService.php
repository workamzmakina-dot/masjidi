<?php

namespace App\Services;

use App\Models\Mosque;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PrayerTimesService
{
    /**
     * Get Daily Prayer Times for a Mosque
     */
    public function getTimesForDate(Mosque $mosque, Carbon $date)
    {
        $cacheKey = "prayer_times_{$mosque->id}_{$date->format('Y-m-d')}";

        return Cache::remember($cacheKey, 3600, function () use ($mosque, $date) {
            $settings = $mosque->prayerSetting;
            
            // Core Logic Placeholder for Adhan Calculation
            // In production, we'd use a package like 'gen-net/adhan-php'
            // Here we return a calculated structure based on $settings->method
            $baseTimes = $this->calculateBaseTimes($settings, $date);
            
            $adjustedTimes = [];
            $manual = $settings->manual_adjustments ?? [];
            $iqama = $settings->iqama_offsets ?? [];

            foreach ($baseTimes as $key => $time) {
                $carbonTime = Carbon::parse($time);
                
                // Add manual adjustment
                if (isset($manual[$key])) {
                    $carbonTime->addMinutes($manual[$key]);
                }
                
                $adjustedTimes[$key] = [
                    'adhan' => $carbonTime->format('H:i'),
                    'iqama' => $settings->use_iqama_static_times 
                        ? ($settings->iqama_static_times[$key] ?? '--:--')
                        : $carbonTime->copy()->addMinutes($iqama[$key] ?? 10)->format('H:i')
                ];
            }

            return $adjustedTimes;
        });
    }

    private function calculateBaseTimes($settings, $date)
    {
        // Mocking astronomical calculation based on Lat/Long/Method
        // Normally returns: Fajr, Sunrise, Dhuhr, Asr, Maghrib, Isha
        return [
            'fajr' => '05:15',
            'sunrise' => '06:40',
            'dhuhr' => '12:10',
            'asr' => '15:35',
            'maghrib' => '18:05',
            'isha' => '19:30',
        ];
    }
}