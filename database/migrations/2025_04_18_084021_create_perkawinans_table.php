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
        Schema::create('perkawinan', function (Blueprint $table) {
            $table->id('id_perkawinan'); // INT + AUTO_INCREMENT + PRIMARY KEY
            $table->unsignedBigInteger('id_domba_jantan');
            $table->unsignedBigInteger('id_domba_betina');
            $table->date('tanggal_perkawinan');
            $table->enum('status', ['Berhasil', 'Gagal', 'Dalam Pemantauan']);
            $table->foreign('id_domba_jantan')->references('id_domba')->on('domba');
            $table->foreign('id_domba_betina')->references('id_domba')->on('domba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkawinan');
    }
};
