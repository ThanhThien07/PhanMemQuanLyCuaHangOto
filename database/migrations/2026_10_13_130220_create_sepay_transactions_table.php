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
        Schema::create('sepay_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sepay_id', 50)->nullable()->index();
            $table->string('gateway', 50)->default('MBBank');
            $table->string('bank_account_id', 100)->default('ba_0VXvtCFwZHBJL8Lb7GYukenOW9B')->index();
            $table->dateTime('transaction_date')->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('sub_account', 50)->nullable();
            $table->string('transfer_type', 20)->default('in'); // 'in': Tiền vào, 'out': Tiền ra
            $table->decimal('transfer_amount', 18, 2)->default(0);
            $table->decimal('accumulated', 18, 2)->default(0);
            $table->string('code', 50)->nullable()->index(); // Mã đơn/mã thanh toán: PLDP...
            $table->text('content')->nullable(); // Nội dung chuyển khoản
            $table->string('reference_code', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('car_id', 50)->nullable();
            $table->string('car_name', 150)->nullable();
            $table->string('customer_name', 100)->nullable();
            $table->string('customer_phone', 30)->nullable();
            $table->string('status', 50)->default('CHUA_THANH_TOAN'); // CHUA_THANH_TOAN, XAC_MINH_THANH_CONG, SUCCESS, MATCHED
            $table->boolean('is_notified_admin')->default(false);
            $table->json('raw_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sepay_transactions');
    }
};
