<?php

namespace App\Models;

class WhatsAppSegment extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'name', 'description'];

    public function subscribers()
    {
        return $this->belongsToMany(WhatsAppSubscriber::class, 'whatsapp_segment_subscriber', 'segment_id', 'subscriber_id');
    }
}
