<?php

namespace App\Models;

class DonationTransaction extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'donation_id', 'provider', 'provider_txn_id', 
        'status', 'amount', 'currency', 'request_payload', 
        'response_payload', 'paid_at'
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'paid_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
