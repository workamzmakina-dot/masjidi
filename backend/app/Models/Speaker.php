<?php

namespace App\Models;

class Speaker extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'name', 'title', 'bio', 'image_path'];

    public function lectures() {
        return $this->hasMany(Lecture::class);
    }
}