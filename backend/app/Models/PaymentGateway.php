<?php

namespace App\Models;

class PaymentGateway extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'provider', 'mode', 'merchant_id', 
        'api_key_encrypted', 'api_secret_encrypted', 
        'webhook_secret_encrypted', 'is_enabled'
    ];

    /**
     * Use Laravel 11 encrypted casts for sensitive data.
     */
    protected $casts = [
        'api_key_encrypted' => 'encrypted',
        'api_secret_encrypted' => 'encrypted',
        'webhook_secret_encrypted' => 'encrypted',
        'is_enabled' => 'boolean',
    ];
}
