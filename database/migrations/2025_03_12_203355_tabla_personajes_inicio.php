<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::create('characters', function (Blueprint $table) {
      $table->id(); // INT UNSIGNED PRIMARY KEY (equivalente a auto-incremental)
      $table->unsignedInteger('id_externo');
      $table->string('name', 64);
      $table->string('status', 64);
      $table->string('species', 64);
      $table->string('type', 32)->nullable(); // Puede ser NULL si no siempre tiene valor
      $table->string('gender', 32);
      $table->tinyText('origin'); // tinytext
      $table->string('image', 32);
      $table->dateTime('created_at')->nullable();
      $table->string('created_by', 16);
      $table->dateTime('updated_at')->nullable();
      $table->string('updated_by', 16);
    });
  }

  public function down(): void {
    Schema::dropIfExists('characters');
  }
};
