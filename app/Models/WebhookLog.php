<?php

namespace App\Models;

class WebhookLog extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'provider', 'headers', 'payload', 
        'signature', 'verified', 'event_type', 
        'received_at', 'processed_at', 'error_message', 'request_id'
    ];

    protected $casts = [
        'headers' => 'array',
        'payload' => 'array',
        'verified' => 'boolean',
        'received_at' => 'datetime',
        'processed_at' => 'datetime'
    ];
}
