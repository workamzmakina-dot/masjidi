<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerSetting extends Model
{
    protected $fillable = [
        'mosque_id', 'method', 'timezone', 'latitude', 'longitude', 
        'manual_adjustments', 'iqama_offsets', 'use_iqama_static_times', 'iqama_static_times'
    ];

    protected $casts = [
        'manual_adjustments' => 'array',
        'iqama_offsets' => 'array',
        'iqama_static_times' => 'array',
    ];

    public function mosque() {
        return $this->belongsTo(Mosque::class);
    }
}