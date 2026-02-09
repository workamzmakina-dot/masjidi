<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsageCounter extends Model
{
    protected $fillable = ['mosque_id', 'feature_name', 'current_usage', 'reset_date'];

    protected $casts = [
        'reset_date' => 'date',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
