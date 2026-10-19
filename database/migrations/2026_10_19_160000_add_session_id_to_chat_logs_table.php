<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('chat_logs', 'session_id')) {
                $table->string('session_id', 60)->nullable()->after('id');
            }
            if (! Schema::hasColumn('chat_logs', 'sender_type')) {
                $table->string('sender_type', 20)->default('customer')->after('nguoi_gui');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            if (Schema::hasColumn('chat_logs', 'session_id')) {
                $table->dropColumn('session_id');
            }
            if (Schema::hasColumn('chat_logs', 'sender_type')) {
                $table->dropColumn('sender_type');
            }
        });
    }
};
