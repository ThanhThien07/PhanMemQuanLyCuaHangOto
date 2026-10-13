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
        // 1. Bảng Thẩm định & Thu cũ đổi mới (Trade-In Requests)
        Schema::create('yeu_cau_thu_doi_xe', function (Blueprint $table) {
            $table->id();
            $table->string('ma_yeu_cau', 30)->unique();
            $table->string('ho_ten', 120);
            $table->string('sdt', 25);
            $table->string('email', 120)->nullable();
            $table->string('hang_xe', 80);
            $table->string('dong_xe', 120);
            $table->year('nam_sx');
            $table->unsignedInteger('so_km')->default(0);
            $table->string('tinh_trang', 150)->default('Nguyên bản, không tai nạn thủy kích');
            $table->string('xe_du_dinh_doi', 150)->nullable();
            $table->decimal('gia_dinh_gia_so_bo', 18, 2)->default(0);
            $table->decimal('gia_chot', 18, 2)->nullable();
            $table->text('hinh_anh')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->string('trang_thai', 60)->default('Chờ thẩm định'); // Chờ thẩm định, Đã định giá, Đã chốt đổi xe, Đã hủy
            $table->timestamps();
        });

        // 2. Bảng Sổ bảo hành điện tử theo số khung VIN (E-Warranty)
        Schema::create('so_bao_hanh_vin', function (Blueprint $table) {
            $table->id();
            $table->string('vin', 30)->unique();
            $table->string('bien_so', 30)->nullable();
            $table->string('ten_xe', 150);
            $table->string('chu_so_huu', 120);
            $table->string('sdt_chu_xe', 25);
            $table->date('ngay_giao_xe');
            $table->unsignedSmallInteger('thoi_han_bao_hanh_nam')->default(3);
            $table->date('ngay_het_han_bh');
            $table->unsignedInteger('so_km_hien_tai')->default(0);
            $table->string('goi_bao_hanh', 100)->default('PrimeLux Diamond Care (36 Tháng)');
            $table->string('trang_thai', 50)->default('Còn hạn bảo hành');
            $table->timestamps();
        });

        // 3. Bảng Lịch sử bảo dưỡng theo VIN
        Schema::create('lich_su_bao_duong_vin', function (Blueprint $table) {
            $table->id();
            $table->string('vin', 30);
            $table->date('ngay_bao_duong');
            $table->unsignedInteger('moc_km');
            $table->text('noi_dung');
            $table->text('phu_tung_thay_the')->nullable();
            $table->decimal('chi_phi', 18, 2)->default(0);
            $table->string('ky_thuat_vien', 100)->default('Kỹ Sư Trưởng PrimeLux');
            $table->string('showroom', 150)->default('Trung Tâm Dịch Vụ PrimeLux Auto Sài Gòn');
            $table->unsignedInteger('diem_tich_luy_nhan')->default(0);
            $table->timestamps();
        });

        // 4. Bảng Thông báo tự động đa kênh (Zalo ZNS / SMS / Email)
        Schema::create('thong_bao_da_kenh', function (Blueprint $table) {
            $table->id();
            $table->string('ma_thong_bao', 30)->unique();
            $table->string('loai_kenh', 50); // Zalo ZNS, SMS Brandname, Email
            $table->string('muc_dich', 100); // Lái thử VIP, Thăng hạng VIP, Hóa đơn điện tử, Đặt cọc
            $table->string('nguoi_nhan', 120);
            $table->string('sdt_email', 120);
            $table->string('tieu_de', 255);
            $table->text('noi_dung');
            $table->string('trang_thai', 50)->default('Đã gửi thành công');
            $table->dateTime('thoi_gian_gui')->useCurrent();
            $table->timestamps();
        });

        // 5. Bảng Nhật ký kiểm toán & Phân quyền RBAC (Audit Logs)
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 100);
            $table->string('user_role', 60); // Super Admin, Quản lý bán hàng, Tư vấn viên, Kế toán
            $table->string('action', 150);
            $table->text('details')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('thong_bao_da_kenh');
        Schema::dropIfExists('lich_su_bao_duong_vin');
        Schema::dropIfExists('so_bao_hanh_vin');
        Schema::dropIfExists('yeu_cau_thu_doi_xe');
    }
};
