<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the new columns.
     */
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // when the message was opened/read
            $table->timestamp('read_at')->nullable()->after('updated_at');

            // visitor IP address captured at submission time
            $table->string('ip_address')->nullable()->after('read_at');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['read_at', 'ip_address']);
        });
    }
};