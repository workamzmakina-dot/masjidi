<?php

namespace App\Models;

class WhatsAppMessage extends BaseTenantModel
{
    /**
     * The table associated with the model.
     */
    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'mosque_id', 
        'subscriber_id', 
        'segment_id', 
        'template_id', 
        'to_phone_e164',
        'body', 
        'status', 
        'scheduled_at', 
        'sent_at', 
        'provider_name',
        'provider_message_id', 
        'error_code', 
        'error_message', 
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'status' => 'string'
    ];

    /**
     * Relationships
     */
    public function subscriber() 
    { 
        return $this->belongsTo(WhatsAppSubscriber::class); 
    }

    public function segment() 
    { 
        return $this->belongsTo(WhatsAppSegment::class); 
    }

    public function template() 
    { 
        return $this->belongsTo(WhatsAppTemplate::class); 
    }

    public function deliveryLogs()
    {
        return $this->hasMany(WhatsAppDeliveryLog::class, 'message_id');
    }
}