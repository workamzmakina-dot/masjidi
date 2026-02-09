<?php

namespace App\Models;

class Campaign extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'title', 'description', 'goal_amount', 'current_amount',
        'is_active', 'starts_at', 'ends_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
