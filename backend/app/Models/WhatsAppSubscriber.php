<?php

namespace App\Models;

class WhatsAppSubscriber extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'name', 'phone_e164', 'locale', 'status',
        'source', 'last_opt_in_at', 'last_opt_out_at'
    ];

    protected $casts = [
        'last_opt_in_at' => 'datetime',
        'last_opt_out_at' => 'datetime',
    ];

    public function segments()
    {
        return $this->belongsToMany(WhatsAppSegment::class, 'whatsapp_segment_subscriber', 'subscriber_id', 'segment_id');
    }
}
