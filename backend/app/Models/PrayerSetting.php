<?php

namespace App\Models;

class PrayerSetting extends BaseTenantModel
{
    protected $fillable = [
        'method', 'timezone', 'latitude', 'longitude',
        'manual_adjustments', 'iqama_offsets', 'use_iqama_static_times', 'iqama_static_times'
    ];

    protected $casts = [
        'manual_adjustments' => 'array',
        'iqama_offsets' => 'array',
        'iqama_static_times' => 'array',
    ];
}
