<?php

namespace App\Models;

class Announcement extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'title', 'message', 'starts_at', 'ends_at', 'is_active'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
