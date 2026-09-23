<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            $table->string('sdt_khach', 20)->nullable()->after('nguoi_gui');
            $table->string('loai_cau_hoi', 50)->default('cau_hoi_rieng')->after('noi_dung');
            $table->string('trang_thai', 50)->default('Chờ phản hồi')->after('phan_hoi_bot');
            $table->text('tra_loi_tu_van')->nullable()->after('trang_thai');
            $table->string('ten_tu_van', 100)->nullable()->after('tra_loi_tu_van');
            $table->dateTime('thoi_gian_tra_loi')->nullable()->after('ten_tu_van');
        });
    }

    public function down(): void
    {
        Schema::table('chat_logs', function (Blueprint $table) {
            $table->dropColumn(['sdt_khach', 'loai_cau_hoi', 'trang_thai', 'tra_loi_tu_van', 'ten_tu_van', 'thoi_gian_tra_loi']);
        });
    }
};
