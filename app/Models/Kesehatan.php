<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kesehatan extends Model
{
    protected $table = 'kesehatan';
    protected $primaryKey = 'id_riwayatKesehatan';
    public $timestamps = false;

    protected $fillable = ['id_domba', 'tanggal_pemeriksaan', 'jenis_vaksin', 'kondisi_kesehatan', 'catatan_perkembangan'];

    public function domba() {
        return $this->belongsTo(Domba::class, 'id_domba');
    }
}
