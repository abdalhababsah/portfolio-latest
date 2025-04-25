<?php
// database/migrations/2025_04_23_001300_create_testimonials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('role', 100)->nullable();
            $table->string('image', 255)->nullable();
            $table->tinyInteger('rating')->unsigned()->nullable();
            $table->text('message_en')->nullable();
            $table->text('message_ar')->nullable();
            $table->date('date_given')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}