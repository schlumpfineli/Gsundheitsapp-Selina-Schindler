<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  function up()
  {
    Schema::create('medications', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('dosage');
      $table->json('time_of_day')->nullable(); // Für mehrere Einnahmezeiten
      $table->text('notes')->nullable();
      $table->foreignId('user_id')->constrained();
      $table->timestamps();
    });
  }

  function down()
  {
    Schema::dropIfExists('medications');
  }
};
