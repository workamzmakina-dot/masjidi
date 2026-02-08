<?php

namespace App\Models;

class Donation extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'campaign_id', 'donor_name', 'donor_phone', 'donor_email',
        'amount', 'currency', 'status', 'reference', 'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2'
    ];

    public function campaign() 
    { 
        return $this->belongsTo(Campaign::class); 
    }

    public function transactions() 
    { 
        return $this->hasMany(DonationTransaction::class); 
    }

    public function receipt() 
    { 
        return $this->hasOne(DonationReceipt::class); 
    }
}
