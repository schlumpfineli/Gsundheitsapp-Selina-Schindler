<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  function up()
  {
    Schema::create('files', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('path');
      $table->string('mime_type');
      $table->integer('size');
      $table->text('comment')->nullable();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->timestamps(); // created_at und updated_at
    });
  }

  function down()
  {
    Schema::dropIfExists('files');
  }
};
