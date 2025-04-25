<?php
// database/migrations/2025_04_23_000900_create_project_videos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectVideosTable extends Migration
{
    public function up()
    {
        Schema::create('project_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('video_url', 255);
            $table->string('caption_en', 255)->nullable();
            $table->string('caption_ar', 255)->nullable();
            $table->string('thumbnail_path', 255)->nullable();
            $table->string('thumbnail_alt_en', 255)->nullable();
            $table->string('thumbnail_alt_ar', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_videos');
    }
}