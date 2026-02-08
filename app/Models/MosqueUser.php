<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MosqueUser extends Authenticatable
{
    protected $fillable = ['mosque_id', 'name', 'email', 'password'];
    protected $hidden = ['password'];

    public function mosque() {
        return $this->belongsTo(Mosque.class);
    }
}
