<?php
// database/migrations/2025_04_23_000000_create_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 100);
            $table->string('name_ar', 100);
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
        Schema::dropIfExists('categories');
    }
}