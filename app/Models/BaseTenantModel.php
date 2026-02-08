<?php

namespace App\Models;

use App\Services\TenantContext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseTenantModel extends Model
{
    /**
     * The attributes that are NOT mass assignable.
     * Hardened to prevent mosque_id spoofing during $request->all() injection.
     */
    protected $guarded = ['mosque_id', 'id'];

    protected static function booted()
    {
        static::addGlobalScope('mosque_isolation', function (Builder $builder) {
            $context = app(TenantContext::class);
            if ($context->id()) {
                $builder->where($builder->getQuery()->from . '.mosque_id', $context->id());
            }
        });

        static::creating(function ($model) {
            $context = app(TenantContext::class);
            if ($context->id()) {
                // Force the mosque_id from the verified context, ignoring any request input
                $model->mosque_id = $context->id();
            }
        });
    }

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
