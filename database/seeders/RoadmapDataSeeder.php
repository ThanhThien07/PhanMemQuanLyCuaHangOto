<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\LichSuBaoDuongVin;
use App\Models\SoBaoHanhVin;
use App\Models\ThongBaoDaKenh;
use App\Models\YeuCauThuDoiXe;
use Illuminate\Database\Seeder;

class RoadmapDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Sổ bảo hành điện tử theo số khung VIN
        if (SoBaoHanhVin::count() === 0) {
            $w1 = SoBaoHanhVin::create([
                'vin' => 'WBA53BJ04RFP98124',
                'bien_so' => '51K-888.88',
                'ten_xe' => 'Mercedes-Maybach S 680 4MATIC (2026)',
                'chu_so_huu' => 'Nguyễn Thành Nam',
                'sdt_chu_xe' => '0908889999',
                'ngay_giao_xe' => '2025-01-15',
                'thoi_han_bao_hanh_nam' => 5,
                'ngay_het_han_bh' => '2030-01-15',
                'so_km_hien_tai' => 12500,
                'goi_bao_hanh' => 'PrimeLux Diamond Executive Care (60 Tháng)',
                'trang_thai' => 'Còn hạn bảo hành',
            ]);

            LichSuBaoDuongVin::create([
                'vin' => 'WBA53BJ04RFP98124',
                'ngay_bao_duong' => '2025-06-20',
                'moc_km' => 5000,
                'noi_dung' => 'Bảo dưỡng định kỳ cấp 1: Thay dầu động cơ Mobil 1 0W-40, kiểm tra hệ thống treo khí nén Airmatic, cân bằng động 4 bánh.',
                'phu_tung_thay_the' => 'Lọc dầu chính hãng Maybach, Dầu động cơ cao cấp Mobil 1 Gold',
                'chi_phi' => 4500000,
                'ky_thuat_vien' => 'Trần Văn Long - Kỹ Sư Trưởng Maybach',
                'showroom' => 'PrimeLux Auto Sài Gòn - Flagship Showroom',
                'diem_tich_luy_nhan' => 450,
            ]);

            LichSuBaoDuongVin::create([
                'vin' => 'WBA53BJ04RFP98124',
                'ngay_bao_duong' => '2025-12-18',
                'moc_km' => 10000,
                'noi_dung' => 'Bảo dưỡng định kỳ cấp 2: Vệ sinh hệ thống nạp khí kép Biturbo, thay lọc gió điều hòa hoạt tính, kiểm tra má phanh gốm Carbon.',
                'phu_tung_thay_the' => 'Lọc gió điều hòa than hoạt tính nano, Nước làm mát chính hãng',
                'chi_phi' => 8200000,
                'ky_thuat_vien' => 'Lê Hoàng Minh - Chuyên gia Động cơ V12',
                'showroom' => 'PrimeLux Auto Sài Gòn - Flagship Showroom',
                'diem_tich_luy_nhan' => 820,
            ]);

            $w2 = SoBaoHanhVin::create([
                'vin' => 'WP0ZZZ99ZTS182931',
                'bien_so' => '30H-999.66',
                'ten_xe' => 'Porsche 911 GT3 RS (2026)',
                'chu_so_huu' => 'Phạm Gia Huy',
                'sdt_chu_xe' => '0912345678',
                'ngay_giao_xe' => '2025-03-10',
                'thoi_han_bao_hanh_nam' => 3,
                'ngay_het_han_bh' => '2028-03-10',
                'so_km_hien_tai' => 7800,
                'goi_bao_hanh' => 'Porsche Approved Motorsport Care',
                'trang_thai' => 'Còn hạn bảo hành',
            ]);

            LichSuBaoDuongVin::create([
                'vin' => 'WP0ZZZ99ZTS182931',
                'ngay_bao_duong' => '2025-09-05',
                'moc_km' => 5000,
                'noi_dung' => 'Bảo dưỡng đường đua Track Pack: Cân chỉnh góc đặt bánh lái camber/toe chuyên sâu, siết ốc khóa tâm mâm xe Center-lock, thay dầu phanh DOT 5.1.',
                'phu_tung_thay_the' => 'Dầu phanh chịu nhiệt cao Castrol SRF, Dầu nhớt Mobil 1 ESP x3 0W-40',
                'chi_phi' => 12500000,
                'ky_thuat_vien' => 'Nguyễn Minh Quân - Chuyên gia Kỹ thuật Porsche Motorsport',
                'showroom' => 'PrimeLux Auto Hà Nội - Motorsport Center',
                'diem_tich_luy_nhan' => 1250,
            ]);
        }

        // 2. Yêu cầu Thu cũ đổi mới (Trade-In)
        if (YeuCauThuDoiXe::count() === 0) {
            YeuCauThuDoiXe::create([
                'ma_yeu_cau' => 'TI-2026-081',
                'ho_ten' => 'Trần Quang Khải',
                'sdt' => '0988776655',
                'email' => 'khaitt@vng.vn',
                'hang_xe' => 'Mercedes-Benz',
                'dong_xe' => 'C 300 AMG',
                'nam_sx' => 2022,
                'so_km' => 32000,
                'tinh_trang' => 'Xe gia đình sử dụng kỹ, bảo dưỡng full lịch sử hãng Mercedes Vietnam Star, sơn zin 98%, không đâm đụng thủy kích.',
                'xe_du_dinh_doi' => 'Porsche Macan GTS (2026)',
                'gia_dinh_gia_so_bo' => 1380000000,
                'gia_chot' => 1350000000,
                'ghi_chu' => 'Khách hàng có nhu cầu đổi sang SUV thể thao giao xe trong tháng.',
                'trang_thai' => 'Đã định giá',
            ]);

            YeuCauThuDoiXe::create([
                'ma_yeu_cau' => 'TI-2026-092',
                'ho_ten' => 'Vũ Thị Minh Thư',
                'sdt' => '0903112233',
                'email' => 'thuvu@saigoninvest.com',
                'hang_xe' => 'BMW',
                'dong_xe' => 'BMW 530i M Sport',
                'nam_sx' => 2023,
                'so_km' => 18000,
                'tinh_trang' => 'Nội thất da Dakota còn như mới, mâm 19 inch không trầy xước, dán phim cách nhiệt 3M Crystalline toàn bộ.',
                'xe_du_dinh_doi' => 'Mercedes-Maybach S 680 4MATIC (2026)',
                'gia_dinh_gia_so_bo' => 2150000000,
                'gia_chot' => null,
                'ghi_chu' => 'Đã xếp lịch kiểm tra 176 hạng mục tại nhà khách vào ngày mai.',
                'trang_thai' => 'Chờ thẩm định',
            ]);
        }

        // 3. Thông báo đa kênh (Zalo ZNS / SMS / Email)
        if (ThongBaoDaKenh::count() === 0) {
            ThongBaoDaKenh::create([
                'ma_thong_bao' => 'TB-ZNS-10492',
                'loai_kenh' => 'Zalo ZNS',
                'muc_dich' => 'Xác nhận Lịch Lái Thử VIP',
                'nguoi_nhan' => 'Lê Hoàng Long',
                'sdt_email' => '0938123456',
                'tieu_de' => 'PrimeLux Auto xác nhận lịch lái thử Maybach S 680',
                'noi_dung' => 'Kính gửi Quý khách Lê Hoàng Long, Showroom PrimeLux Auto Sài Gòn đã xác nhận lịch trải nghiệm mẫu xe Mercedes-Maybach S 680 vào lúc 09:30 ngày 15/10/2026. Chuyên gia tư vấn cấp cao sẽ đón tiếp Quý khách kèm phục vụ tiệc trà thượng hạng.',
                'trang_thai' => 'Đã gửi thành công',
                'thoi_gian_gui' => now()->subHours(3),
            ]);

            ThongBaoDaKenh::create([
                'ma_thong_bao' => 'TB-SMS-20831',
                'loai_kenh' => 'SMS Brandname',
                'muc_dich' => 'Thông báo Thăng hạng Thẻ VIP',
                'nguoi_nhan' => 'Nguyễn Thị Bích Ngọc',
                'sdt_email' => '0918765432',
                'tieu_de' => 'PRIMELUX Chúc mừng nâng hạng Kim Cương VIP',
                'noi_dung' => 'PRIMELUX AUTO: Chuc mung Quy khach thang hang DIAMOND VIP (15.200 diem). Dac quyen giam 3% tat ca dong xe va tang 1 nam cuu ho chuyen dung VIP 24/7.',
                'trang_thai' => 'Đã gửi thành công',
                'thoi_gian_gui' => now()->subDay(),
            ]);

            ThongBaoDaKenh::create([
                'ma_thong_bao' => 'TB-EML-40912',
                'loai_kenh' => 'Email',
                'muc_dich' => 'Hóa đơn Điện tử & Biên lai Cọc xe',
                'nguoi_nhan' => 'Trần Đình Khang',
                'sdt_email' => 'khang.td@vinacapital.com',
                'tieu_de' => 'Hóa Đơn Điện Tử Đặt Cọc Xe PrimeLux #RES-99214',
                'noi_dung' => 'Kính gửi Quý khách, PrimeLux Auto xin gửi Biên lai xác nhận thanh toán trực tuyến số tiền trả trước 100.000.000 VNĐ cho mẫu xe Porsche 911 GT3 RS. Trạng thái xe đã được bảo lưu độc quyền.',
                'trang_thai' => 'Đã gửi thành công',
                'thoi_gian_gui' => now()->subHours(6),
            ]);
        }

        // 4. Audit Log
        if (AuditLog::count() === 0) {
            AuditLog::create([
                'user_name' => 'Nguyễn Hoàng Hưng',
                'user_role' => 'Super Admin',
                'action' => 'Duyệt hồ sơ thẩm định Thu cũ đổi mới',
                'details' => 'Phê duyệt giá mua lại xe Mercedes C 300 AMG mã #TI-2026-081 với mức giá 1.350.000.000 VNĐ để cấn trừ hóa đơn mua Porsche Macan GTS.',
                'ip_address' => '127.0.0.1',
            ]);

            AuditLog::create([
                'user_name' => 'Võ Hoàng Long',
                'user_role' => 'Quản lý bán hàng',
                'action' => 'Cập nhật trạng thái xe kho',
                'details' => 'Chuyển trạng thái xe Mercedes-Maybach S 680 sang "Đã đặt cọc" sau khi nhận xác minh giao dịch trực tuyến SePay 100.000.000 VNĐ.',
                'ip_address' => '127.0.0.1',
            ]);

            AuditLog::create([
                'user_name' => 'Trần Nguyễn Hoàng Ân',
                'user_role' => 'Kế toán',
                'action' => 'Xuất báo cáo doanh thu BI Excel',
                'details' => 'Xuất danh sách hóa đơn bán hàng và tổng hợp doanh thu Q3/2026 định dạng Excel chuẩn kế toán.',
                'ip_address' => '127.0.0.1',
            ]);
        }
    }
}
