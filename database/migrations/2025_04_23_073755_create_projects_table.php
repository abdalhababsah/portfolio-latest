<?php
// database/migrations/2025_04_23_000500_create_projects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('short_description_en')->nullable();
            $table->text('short_description_ar')->nullable();
            $table->text('full_description_en')->nullable();
            $table->text('full_description_ar')->nullable();
            $table->string('role_en', 255)->nullable();
            $table->string('role_ar', 255)->nullable();
            $table->string('duration_en', 100)->nullable();
            $table->string('duration_ar', 100)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->boolean('featured')->default(false);
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('github_url', 255)->nullable();
            $table->string('demo_url', 255)->nullable();
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
        Schema::dropIfExists('projects');
    }
}