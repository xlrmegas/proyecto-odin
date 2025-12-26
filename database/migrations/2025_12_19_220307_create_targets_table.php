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
   Schema::create('targets', function (Blueprint $table) {
    $table->id();
    $table->string('name')->default('Captura Online');
    $table->string('ip')->nullable();
    $table->string('user_agent')->nullable();
    $table->text('location')->nullable();
    $table->string('photo_path')->nullable(); // Debe permitir NULL para capturas sin cámara
    $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
