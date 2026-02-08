<?php

namespace App\Models;

class FatwaCategory extends BaseTenantModel
{
    protected $fillable = ['mosque_id', 'name'];
}