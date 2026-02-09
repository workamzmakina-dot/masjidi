<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'feature_plan');
    }
}
