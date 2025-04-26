<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_view_aggregates', function (Blueprint $table) {
            $table->id();
            $table->string('route_name')->index();
            $table->date('view_date')->index();
            $table->unsignedBigInteger('hits')->default(0);
            $table->timestamps();

            $table->unique(['route_name', 'view_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_view_aggregates');
    }
};
