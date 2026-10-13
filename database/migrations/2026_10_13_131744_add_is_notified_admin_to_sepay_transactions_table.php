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
        if (! Schema::hasColumn('sepay_transactions', 'is_notified_admin')) {
            Schema::table('sepay_transactions', function (Blueprint $table) {
                $table->boolean('is_notified_admin')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op on rollback for SQLite compatibility
    }
};
