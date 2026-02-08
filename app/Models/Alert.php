<?php

namespace App\Models;

class Alert extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'message', 'type', 'starts_at', 'ends_at', 'is_active'];
}