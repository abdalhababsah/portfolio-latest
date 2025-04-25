<?php
// database/migrations/2025_04_23_001100_create_education_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('institution_en');
            $table->string('institution_ar');
            $table->string('degree_en');
            $table->string('degree_ar');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education');
    }
}