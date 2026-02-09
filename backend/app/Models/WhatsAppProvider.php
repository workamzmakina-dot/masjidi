<?php

namespace App\Models;

class WhatsAppProvider extends BaseTenantModel
{
    protected $table = 'whatsapp_providers';

    protected $fillable = ['mosque_id', 'provider', 'api_url', 'api_token', 'sender_name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
