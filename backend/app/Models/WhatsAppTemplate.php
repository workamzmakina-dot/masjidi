<?php

namespace App\Models;

class WhatsAppTemplate extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'name', 'language', 'content', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
