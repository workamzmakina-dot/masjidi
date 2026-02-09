<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueFeatureOverride extends Model
{
    protected $fillable = ['mosque_id', 'feature_id', 'enabled', 'custom_limits'];

    protected $casts = [
        'custom_limits' => 'array',
        'enabled' => 'boolean',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
