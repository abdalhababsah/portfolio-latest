<?php
// database/migrations/2025_04_23_000800_create_project_images_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectImagesTable extends Migration
{
    public function up()
    {
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('image_path', 255);
            $table->string('alt_text_en', 255)->nullable();
            $table->string('alt_text_ar', 255)->nullable();
            $table->boolean('is_main')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_images');
    }
}