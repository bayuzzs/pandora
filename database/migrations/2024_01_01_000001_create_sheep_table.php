<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('sheep', function (Blueprint $table) {
      $table->id();
      $table->string('uid')->unique()->comment('Nomor tag uid unik');
      $table->string('name');
      $table->enum('gender', ['male', 'female']);
      $table->date('birth_date');
      $table->string('breed');
      $table->decimal('weight', 6, 2)->comment('Berat dalam kg');
      $table->enum('health_status', ['Sehat', 'Sakit', 'Pemulihan', 'Karantina']);
      $table->foreignId('pen_id')->nullable()->constrained('pens')->nullOnDelete();
      $table->date('last_check_date')->nullable();
      $table->date('last_vaccination_date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sheep');
  }
};