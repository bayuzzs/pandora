<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kesehatan', function (Blueprint $table) {
            $table->id('id_riwayatKesehatan'); // Primary Key & Auto Increment
            $table->unsignedBigInteger('id_domba'); // Foreign Key ke tabel Domba
            $table->date('tanggal_pemeriksaan');
            $table->string('jenis_vaksin', 100)->nullable();
            $table->text('kondisi_kesehatan');
            $table->text('catatan_perkembangan')->nullable();
            $table->foreign('id_domba')->references('id_domba')->on('domba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesehatan');
    }
};
