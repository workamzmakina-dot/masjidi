<?php

namespace App\Models;

class Event extends BaseTenantModel
{
    protected $fillable = [
        'mosque_id', 'title', 'description', 'location', 
        'start_at', 'end_at', 'recurrence', 'image_path'
    ];
}