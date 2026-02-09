<?php

namespace App\Models;

class RamadanSetting extends BaseTenantModel
{
    protected $fillable = ['taraweeh_enabled', 'iftar_time', 'suhoor_time', 'announcements'];

    protected $casts = [
        'taraweeh_enabled' => 'boolean',
        'announcements' => 'array',
    ];
}
