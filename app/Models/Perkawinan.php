<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perkawinan extends Model
{
   protected $table = 'perkawinan';
    protected $primaryKey = 'id_perkawinan';
    public $timestamps = false;

    protected $fillable = ['id_domba_jantan', 'id_domba_betina', 'tanggal_perkawinan', 'status'];

    public function dombaJantan() {
        return $this->belongsTo(Domba::class, 'id_domba_jantan');
    }

    public function dombaBetina() {
        return $this->belongsTo(Domba::class, 'id_domba_betina');
    }
}
 