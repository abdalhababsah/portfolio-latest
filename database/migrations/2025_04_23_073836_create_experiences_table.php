<?php
// database/migrations/2025_04_23_001000_create_experiences_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company_en');
            $table->string('company_ar');
            $table->string('position_en');
            $table->string('position_ar');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experiences');
    }
}