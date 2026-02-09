<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueSubscription extends Model
{
    protected $fillable = ['mosque_id', 'plan_id', 'trial_ends_at', 'ends_at', 'stripe_id'];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
