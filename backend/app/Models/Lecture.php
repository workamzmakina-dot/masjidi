<?php

namespace App\Models;

class Lecture extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'speaker_id', 'title', 'description', 
        'type', 'media_path', 'external_url', 'is_public', 'recorded_at'
    ];

    public function speaker() {
        return $this->belongsTo(Speaker::class);
    }
}