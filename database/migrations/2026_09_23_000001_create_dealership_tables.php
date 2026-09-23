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
        // 1. Thương hiệu xe (Brands)
        Schema::create('thuong_hieu', function (Blueprint $table) {
            $table->id();
            $table->string('ma_th', 20)->unique();
            $table->string('ten_th', 100);
            $table->string('xuat_xu', 50)->nullable();
            $table->string('badge', 50)->nullable(); // e.g. MAYBACH, M-POWER
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });

        // 2. Kiểu dáng xe (Car Types)
        Schema::create('loai_xe', function (Blueprint $table) {
            $table->id();
            $table->string('ma_loai', 20)->unique();
            $table->string('ten_loai', 100);
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });

        // 3. Hạng thành viên & Chính sách ưu đãi điểm thưởng (Loyalty Tiers)
        Schema::create('hang_thanh_vien', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hang', 20)->unique(); // SILVER, GOLD, PLATINUM, DIAMOND
            $table->string('ten_hang', 100);
            $table->unsignedInteger('diem_toi_thieu')->default(0); // 0, 1000, 5000, 10000
            $table->decimal('ti_le_chiet_khau', 5, 2)->default(0.00); // 0%, 1%, 2%, 3%
            $table->text('dac_quyen'); // Mô tả ưu đãi, quà tặng, dịch vụ riêng
            $table->string('mau_badge', 30)->default('secondary'); // warning, info, primary, success
            $table->timestamps();
        });

        // 4. Khách hàng (Customers & Loyalty Points)
        Schema::create('khach_hang', function (Blueprint $table) {
            $table->id();
            $table->string('ma_kh', 20)->unique();
            $table->string('ho_ten', 100);
            $table->string('sdt', 20)->unique();
            $table->string('email', 100)->nullable();
            $table->string('dia_chi', 255)->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->string('mat_khau')->nullable();
            $table->unsignedInteger('diem_tich_luy')->default(0); // Tổng điểm hiện có
            $table->decimal('tong_chi_tieu', 18, 2)->default(0); // Tổng số tiền đã mua xe & dịch vụ
            $table->string('ma_hang', 20)->default('SILVER');
            $table->timestamps();
        });

        // 5. Mẫu xe trong kho (Cars Inventory)
        Schema::create('xe', function (Blueprint $table) {
            $table->id();
            $table->string('ma_xe', 20)->unique(); // car-01, car-02...
            $table->string('ten_xe', 150);
            $table->string('ma_th', 20);
            $table->string('ma_loai', 20);
            $table->decimal('gia_niem_yet', 18, 2);
            $table->string('gia_chu', 50)->nullable();
            $table->string('nhien_lieu', 100)->nullable();
            $table->string('cong_suat', 100)->nullable();
            $table->string('so_cho', 50)->nullable();
            $table->year('nam_sx')->default(2026);
            $table->string('nhan_tag', 50)->nullable(); // HOT, Mới Về, Ưu Đãi
            $table->string('tag_class', 50)->nullable(); // tag-hot, tag-new, tag-sale
            $table->text('hinh_anh');
            $table->text('mo_ta')->nullable();
            $table->unsignedInteger('so_luong_kho')->default(1);
            $table->string('trang_thai', 50)->default('Sẵn hàng');
            $table->timestamps();
        });

        // 6. Đơn Hàng / Hóa Đơn (Invoices)
        Schema::create('hoa_don', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hd', 20)->unique(); // HD0001...
            $table->string('ma_kh', 20);
            $table->dateTime('ngay_lap')->useCurrent();
            $table->decimal('tong_tien_goc', 18, 2);
            $table->decimal('giam_gia_hang', 18, 2)->default(0); // Chiết khấu theo hạng thành viên
            $table->decimal('tong_tien_thanh_toan', 18, 2);
            $table->unsignedInteger('diem_thuong_nhan')->default(0); // Điểm cộng thêm từ đơn
            $table->string('phuong_thuc_tt', 50)->default('Chuyển khoản ngân hàng');
            $table->string('thoi_gian_bh', 50)->default('36 Tháng');
            $table->string('trang_thai', 50)->default('Đã thanh toán');
            $table->timestamps();
        });

        // 7. Chi tiết Hóa Đơn (Invoice Details)
        Schema::create('ct_hoa_don', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hd', 20);
            $table->string('ma_xe', 20);
            $table->unsignedInteger('so_luong')->default(1);
            $table->decimal('don_gia', 18, 2);
            $table->decimal('thanh_tien', 18, 2);
            $table->timestamps();
        });

        // 8. Đăng ký lái thử xe VIP (Test Drive Bookings)
        Schema::create('dang_ky_lai_thu', function (Blueprint $table) {
            $table->id();
            $table->string('ma_lich', 20)->unique(); // TD-101...
            $table->string('ho_ten', 100);
            $table->string('sdt', 20);
            $table->string('email', 100)->nullable();
            $table->string('ten_xe', 150);
            $table->string('showroom', 150);
            $table->dateTime('thoi_gian');
            $table->text('ghi_chu')->nullable();
            $table->string('trang_thai', 50)->default('Đang chờ duyệt'); // Đang chờ duyệt, Đã xác nhận, Đã hoàn thành, Đã hủy
            $table->timestamps();
        });

        // 9. Lịch sử tích điểm & tiêu điểm của khách hàng (Points Log)
        Schema::create('lich_su_diem', function (Blueprint $table) {
            $table->id();
            $table->string('ma_kh', 20);
            $table->string('ma_hd', 20)->nullable();
            $table->integer('so_diem'); // Dương (+) cộng điểm, Âm (-) đổi điểm
            $table->string('hanh_dong', 150); // Mua xe tích điểm, Thưởng thăng hạng, Đổi quà
            $table->dateTime('ngay_tao')->useCurrent();
            $table->timestamps();
        });

        // 10. Nhật ký tương tác Chatbot AI (Chatbot Logs)
        Schema::create('chat_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_tin', 20);
            $table->string('thoi_gian', 30);
            $table->string('nguoi_gui', 100)->default('Khách hàng Web');
            $table->text('noi_dung');
            $table->text('phan_hoi_bot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_logs');
        Schema::dropIfExists('lich_su_diem');
        Schema::dropIfExists('dang_ky_lai_thu');
        Schema::dropIfExists('ct_hoa_don');
        Schema::dropIfExists('hoa_don');
        Schema::dropIfExists('xe');
        Schema::dropIfExists('khach_hang');
        Schema::dropIfExists('hang_thanh_vien');
        Schema::dropIfExists('loai_xe');
        Schema::dropIfExists('thuong_hieu');
    }
};
