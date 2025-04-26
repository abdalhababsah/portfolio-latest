<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('route_name')->nullable();      // e.g. "projects.show"
            $table->string('method', 10);                  // GET / POST …
            $table->string('url', 2048);

            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();  // if you have auth

            $table->string('ip', 45);                      // IPv4 or IPv6
            $table->string('user_agent', 512)->nullable();
            $table->string('referer', 2048)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
