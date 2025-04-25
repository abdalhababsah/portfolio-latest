<?php
// database/migrations/2025_04_23_001400_create_blogs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('summary_en')->nullable();
            $table->text('summary_ar')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_ar')->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->integer('reading_time')->nullable();
            $table->string('meta_title_en', 255)->nullable();
            $table->string('meta_title_ar', 255)->nullable();
            $table->string('meta_description_en', 255)->nullable();
            $table->string('meta_description_ar', 255)->nullable();
            $table->string('meta_keywords_en', 255)->nullable();
            $table->string('meta_keywords_ar', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}