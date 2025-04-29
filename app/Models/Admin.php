<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = ['username', 'password', 'nama'];

    // Hash password otomatis saat diset
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}

