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
        // 1. Bảng Dịch Vụ (Service Catalog / Categories)
        Schema::create('dich_vu', function (Blueprint $table) {
            $table->id();
            $table->string('ma_dv', 30)->unique();
            $table->enum('loai_dv', ['bao_tri', 'bao_hiem', 'cuu_ho', 'sua_chua', 'uu_dai']);
            $table->string('ten_loai_dv', 100);
            $table->string('ten_dv', 150);
            $table->string('tieu_de', 255)->nullable();
            $table->decimal('gia_tham_khao', 18, 2)->default(0);
            $table->string('hinh_anh', 255)->nullable();
            $table->text('mo_ta')->nullable();
            $table->text('quy_trinh')->nullable();
            $table->text('dac_quyen')->nullable();
            $table->string('trang_thai', 50)->default('Đang hoạt động');
            $table->timestamps();
        });

        // 2. Bảng Đặt Lịch Dịch Vụ & Yêu Cầu Cứu Hộ Khẩn Cấp (Service Appointments & Roadside Assistance)
        Schema::create('dat_lich_dich_vu', function (Blueprint $table) {
            $table->id();
            $table->string('ma_dat_lich', 30)->unique(); // SER-1002, RES-5001...
            $table->string('ho_ten', 120);
            $table->string('sdt', 25);
            $table->string('email', 120)->nullable();
            $table->string('bien_so', 30)->nullable(); // Biển số xe (e.g. 51K-999.99)
            $table->string('ten_xe', 150)->nullable();  // Dòng xe (e.g. Mercedes-Maybach S680, S450 4MATIC...)
            $table->string('showroom', 150);
            $table->string('loai_dich_vu', 80); // Bảo trì định kỳ, Cứu hộ 24/7, Sửa chữa thân vỏ, Giám định bảo hiểm...
            $table->string('ten_dich_vu_cu_the', 150)->nullable();
            $table->dateTime('thoi_gian_hen')->nullable();
            $table->string('vi_tri_cuu_ho', 255)->nullable(); // Tọa độ hoặc địa chỉ cứu hộ
            $table->text('ghi_chu')->nullable();
            $table->string('trang_thai', 50)->default('Đang chờ tiếp nhận'); // Đang chờ tiếp nhận, Đã xác nhận, Đang xử lý, Hoàn tất, Đã hủy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dat_lich_dich_vu');
        Schema::dropIfExists('dich_vu');
    }
};
