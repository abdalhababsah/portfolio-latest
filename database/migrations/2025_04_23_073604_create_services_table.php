<?php
// database/migrations/2025_04_23_000300_create_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 10);
            $table->string('unit_en', 50)->nullable();
            $table->string('unit_ar', 50)->nullable();
            $table->string('cover_image', 255)->nullable();
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
        Schema::dropIfExists('services');
    }
}