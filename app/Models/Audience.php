<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Audience extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone',  'email', 'username', 'password'];

    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
