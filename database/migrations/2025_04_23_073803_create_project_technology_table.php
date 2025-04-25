<?php
// database/migrations/2025_04_23_000600_create_project_technology_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTechnologyTable extends Migration
{
    public function up()
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id', 'technology_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_technology');
    }
}