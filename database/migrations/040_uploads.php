<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  function up()
  {
    Schema::create('uploads', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained();
      $table->string('file_path');
      $table->string('original_name');
      $table->string('display_name', 100);
      $table->enum('category', ['doctor', 'neurology', 'psychology', 'therapy', 'alternative', 'other']);
      $table->text('comment')->nullable();
      $table->string('mime_type');
      $table->unsignedInteger('size');
      $table->boolean('is_public')->default(false);
      $table->timestamps();
    });
  }

  function down()
  {
    Schema::dropIfExists('uploads');
  }
};
