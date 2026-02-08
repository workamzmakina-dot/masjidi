<?php

namespace App\Models;

class DonationReceipt extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'donation_id', 'receipt_number', 'pdf_path', 'issued_at'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
