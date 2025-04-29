<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domba extends Model
{
    public function kandang() {
        return $this->belongsTo(Kandang::class, 'id_kandang');
    }

    public function riwayatKesehatan() {
        return $this->hasMany(Kesehatan::class, 'id_domba');
    }

    public function perkawinanSebagaiJantan() {
        return $this->hasMany(Perkawinan::class, 'id_domba_jantan');
    }

    public function perkawinanSebagaiBetina() {
        return $this->hasMany(Perkawinan::class, 'id_domba_betina');
    }

protected $table = 'Domba'; 
protected $primaryKey = 'id_domba';
protected $fillable = ['nomor_tag', 'jenis_kelamin', 'berat', 'id_domba'];
public $timestamps = false;
}
