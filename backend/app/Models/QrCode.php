<?php

namespace App\Models;

class QrCode extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'label', 'payload', 'image_path'];
}
