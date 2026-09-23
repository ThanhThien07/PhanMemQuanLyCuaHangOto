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
        if (!Schema::hasTable('car_price_sources')) {
            Schema::create('car_price_sources', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('car_id');
                $table->string('source_name', 150);
                $table->string('source_logo', 255)->nullable();
                $table->text('source_url');
                $table->string('car_name', 255);
                $table->string('version', 150)->nullable();
                $table->integer('manufacture_year')->nullable();
                $table->decimal('price', 18, 2);
                $table->string('location', 150)->nullable();
                $table->string('condition_type', 50)->nullable();
                $table->string('warranty', 150)->nullable();
                $table->timestamp('fetched_at')->nullable();
                $table->timestamps();

                $table->index(['car_id', 'price'], 'idx_car_price');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_price_sources');
    }
};
