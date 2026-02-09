<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'slug', 'price_monthly', 'limits'];

    protected $casts = [
        'limits' => 'array',
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_plan');
    }

    public function mosques()
    {
        return $this->hasMany(Mosque::class);
    }
}
