<?php
// database/migrations/2025_04_23_000700_create_project_tag_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTagTable extends Migration
{
    public function up()
    {
        Schema::create('project_tag', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_tag');
    }
}