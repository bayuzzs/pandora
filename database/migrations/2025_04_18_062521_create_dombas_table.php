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
        Schema::create('domba', function (Blueprint $table) {
            $table->id('id_domba');
            $table->string('nomor_tag', 50)->unique();
            $table->enum('jenis_kelamin', ['Jantan', 'Betina']);
            $table->decimal('berat', 5, 2);
            $table->unsignedBigInteger('id_kandang');
            $table->foreign('id_kandang')->references('id_kandang')->on('kandang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domba');
    }
};
