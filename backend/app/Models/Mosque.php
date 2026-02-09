<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    protected $fillable = ['name', 'slug', 'custom_domain', 'plan_id', 'settings', 'status'];
    protected $casts = ['settings' => 'array'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function users()
    {
        return $this->hasMany(MosqueUser::class);
    }

    public function featureOverrides()
    {
        return $this->hasMany(MosqueFeatureOverride::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(MosqueSubscription::class);
    }
}
