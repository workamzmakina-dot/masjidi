<?php

namespace App\Models;

class FatwaQuestion extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'category_id', 'user_name', 'user_contact', 
        'question', 'answer', 'answered_by', 'status', 'is_public', 'answered_at'
    ];

    public function category() {
        return $this->belongsTo(FatwaCategory::class);
    }
}