<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    public function domba() {
        return $this->hasMany(Domba::class, 'id_kandang');
    }
    protected $fillable = ['nama_kandang', 'lokasi', 'kapasitas'];
    protected $table = 'kandang'; 
    public $timestamps = false;
    
}
