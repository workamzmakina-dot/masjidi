<?php

namespace App\Models;

class WhiteLabelBranding extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'logo_path', 'primary_color', 'secondary_color', 'font_family', 'custom_domain'];
}
