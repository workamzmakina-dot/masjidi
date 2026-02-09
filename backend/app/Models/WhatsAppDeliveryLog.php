<?php

namespace App\Models;

class WhatsAppDeliveryLog extends BaseTenantModel
{
    protected $table = 'whatsapp_delivery_logs';
    
    protected $fillable = [
        'mosque_id', 
        'message_id', 
        'provider_event', 
        'provider_payload', 
        'occurred_at'
    ];

    protected $casts = [
        'provider_payload' => 'array', 
        'occurred_at' => 'datetime'
    ];

    public function message()
    {
        return $this->belongsTo(WhatsAppMessage::class, 'message_id');
    }
}