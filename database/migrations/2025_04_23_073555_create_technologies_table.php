<?php
// database/migrations/2025_04_23_000100_create_technologies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnologiesTable extends Migration
{
    public function up()
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 100);
            $table->string('name_ar', 100);
            $table->string('logo', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('technologies');
    }
}