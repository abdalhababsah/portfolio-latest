<?php
// database/migrations/2025_04_23_001200_create_skills_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 100);
            $table->string('name_ar', 100);
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->integer('level')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('icon', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skills');
    }
}