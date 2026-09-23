<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. THƯƠNG HIỆU
        DB::table('thuong_hieu')->insert([
            ['ma_th' => 'MERCEDES', 'ten_th' => 'Mercedes-Benz', 'xuat_xu' => 'Đức', 'badge' => 'MAYBACH', 'mo_ta' => 'Thương hiệu xe sang hàng đầu nước Đức.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_th' => 'PORSCHE', 'ten_th' => 'Porsche', 'xuat_xu' => 'Đức', 'badge' => 'SPORT', 'mo_ta' => 'Biểu tượng xe thể thao và hiệu suất đỉnh cao.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_th' => 'BMW', 'ten_th' => 'BMW', 'xuat_xu' => 'Đức', 'badge' => 'M-POWER', 'mo_ta' => 'Cảm giác lái phấn khích vượt trội.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_th' => 'AUDI', 'ten_th' => 'Audi', 'xuat_xu' => 'Đức', 'badge' => 'QUATTRO', 'mo_ta' => 'Đỉnh cao thiết kế tương lai và công nghệ ánh sáng.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_th' => 'LANDROVER', 'ten_th' => 'Land Rover', 'xuat_xu' => 'Anh Quốc', 'badge' => 'AUTOBIOGRAPHY', 'mo_ta' => 'SUV quý tộc Hoàng gia Anh vượt mọi địa hình.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_th' => 'LEXUS', 'ten_th' => 'Lexus', 'xuat_xu' => 'Nhật Bản', 'badge' => 'VIP', 'mo_ta' => 'Sự êm ái tuyệt đối và độ bền bỉ thượng thừa.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. LOẠI XE
        DB::table('loai_xe')->insert([
            ['ma_loai' => 'Sedan', 'ten_loai' => 'Sedan Sang Trọng', 'mo_ta' => 'Dòng xe 4-5 chỗ dáng dài lịch lãm, cách âm tốt nhất cho doanh nhân.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_loai' => 'SUV', 'ten_loai' => 'SUV Hạng Sang', 'mo_ta' => 'Gầm cao đa dụng, không gian rộng rãi, trang bị dẫn động 4 bánh toàn thời gian.', 'created_at' => now(), 'updated_at' => now()],
            ['ma_loai' => 'Electric', 'ten_loai' => 'Xe Điện (EV)', 'mo_ta' => 'Công nghệ pin thuần điện hiện đại, không khí thải, tăng tốc tức thì.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. HẠNG THÀNH VIÊN & ƯU ĐÃI ĐIỂM THƯỞNG
        DB::table('hang_thanh_vien')->insert([
            [
                'ma_hang' => 'SILVER',
                'ten_hang' => 'Hạng Bạc (Silver)',
                'diem_toi_thieu' => 0,
                'ti_le_chiet_khau' => 0.00,
                'dac_quyen' => 'Tích lũy điểm 1% trên mỗi giao dịch. Miễn phí kiểm tra xe 165 điểm định kỳ. Giảm 5% chi phí phụ kiện chính hãng.',
                'mau_badge' => 'secondary',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_hang' => 'GOLD',
                'ten_hang' => 'Hạng Vàng (Gold)',
                'diem_toi_thieu' => 1000,
                'ti_le_chiet_khau' => 1.00,
                'dac_quyen' => 'Chiết khấu 1% trực tiếp khi mua xe tiếp theo (tiết kiệm đến hàng trăm triệu VNĐ). Tặng 1 năm bảo dưỡng miễn phí. Giảm 10% phụ kiện cao cấp. Ưu tiên bàn giao xe.',
                'mau_badge' => 'warning',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_hang' => 'PLATINUM',
                'ten_hang' => 'Hạng Bạch Kim (Platinum)',
                'diem_toi_thieu' => 5000,
                'ti_le_chiet_khau' => 2.00,
                'dac_quyen' => 'Chiết khấu 2% trực tiếp khi mua xe. Tặng gói Bảo hiểm thân vỏ 1 năm (trị giá lên đến 100.000.000 VNĐ). Giao xe tận nhà bằng xe chuyên dụng VIP. Cứu hộ riêng 24/7 toàn quốc.',
                'mau_badge' => 'info',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_hang' => 'DIAMOND',
                'ten_hang' => 'Hạng Kim Cương (Diamond VIP)',
                'diem_toi_thieu' => 10000,
                'ti_le_chiet_khau' => 3.00,
                'dac_quyen' => 'Đặc quyền chiết khấu 3% giá trị mọi siêu xe. Tặng gói phủ Ceramic cao cấp & dán film cách nhiệt chính hãng. Vé mời VIP tham dự sự kiện ra mắt xe quốc tế. Chăm sóc xe trọn đời tại Flagship.',
                'mau_badge' => 'primary',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 4. KHÁCH HÀNG & ĐIỂM TÍCH LŨY
        DB::table('khach_hang')->insert([
            [
                'ma_kh' => 'KH001',
                'ho_ten' => 'Nguyễn Văn A',
                'sdt' => '0901234567',
                'email' => 'khachhang@gmail.com',
                'dia_chi' => 'Vinhomes Central Park, Bình Thạnh, TP.HCM',
                'ngay_sinh' => '1985-06-15',
                'mat_khau' => bcrypt('123456'),
                'diem_tich_luy' => 12500,
                'tong_chi_tieu' => 31980000000,
                'ma_hang' => 'DIAMOND',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_kh' => 'KH002',
                'ho_ten' => 'Trần Thị Mai',
                'sdt' => '0912987654',
                'email' => 'mai.tran@gmail.com',
                'dia_chi' => 'Vinhomes Riverside, Long Biên, Hà Nội',
                'ngay_sinh' => '1990-11-20',
                'mat_khau' => bcrypt('123456'),
                'diem_tich_luy' => 2800,
                'tong_chi_tieu' => 9550000000,
                'ma_hang' => 'GOLD',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_kh' => 'KH003',
                'ho_ten' => 'Lê Hoàng Long',
                'sdt' => '0933892901',
                'email' => 'long.le@gmail.com',
                'dia_chi' => 'Phú Mỹ Hưng, Quận 7, TP.HCM',
                'ngay_sinh' => '1988-03-08',
                'mat_khau' => bcrypt('123456'),
                'diem_tich_luy' => 6200,
                'tong_chi_tieu' => 17998000000,
                'ma_hang' => 'PLATINUM',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_kh' => 'KH004',
                'ho_ten' => 'Phạm Minh Tuấn',
                'sdt' => '0988777999',
                'email' => 'tuan.pham@gmail.com',
                'dia_chi' => 'Nguyễn Văn Linh, Hải Châu, Đà Nẵng',
                'ngay_sinh' => '1995-09-12',
                'mat_khau' => bcrypt('123456'),
                'diem_tich_luy' => 450,
                'tong_chi_tieu' => 5200000000,
                'ma_hang' => 'SILVER',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 5. MẪU XE
        DB::table('xe')->insert([
            [
                'ma_xe' => 'car-01',
                'ten_xe' => 'Mercedes-Maybach S 680 4MATIC',
                'ma_th' => 'Mercedes-Benz',
                'ma_loai' => 'Sedan',
                'gia_niem_yet' => 15990000000,
                'gia_chu' => '15,990,000,000 VNĐ',
                'nhien_lieu' => 'Xăng (V12 6.0L)',
                'cong_suat' => '612 Mã lực',
                'so_cho' => '4 Chỗ',
                'nam_sx' => 2026,
                'nhan_tag' => 'HOT',
                'tag_class' => 'tag-hot',
                'hinh_anh' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                'mo_ta' => 'Đỉnh cao sự sang trọng và thượng lưu. Mercedes-Maybach S 680 được trang bị động cơ V12 bi-turbo mạnh mẽ, hệ dẫn động 4 bánh toàn thời gian cùng khoang hạng nhất cao cấp.',
                'so_luong_kho' => 3,
                'trang_thai' => 'Sẵn hàng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_xe' => 'car-02',
                'ten_xe' => 'Porsche Taycan Turbo S',
                'ma_th' => 'Porsche',
                'ma_loai' => 'Electric',
                'gia_niem_yet' => 9550000000,
                'gia_chu' => '9,550,000,000 VNĐ',
                'nhien_lieu' => 'Thuần Điện (EV)',
                'cong_suat' => '761 Mã lực',
                'so_cho' => '4 Chỗ',
                'nam_sx' => 2026,
                'nhan_tag' => 'Mới Về',
                'tag_class' => 'tag-new',
                'hinh_anh' => 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                'mo_ta' => 'Siêu xe thuần điện với khả năng tăng tốc 0-100km/h trong 2.8 giây. Công nghệ sạc siêu nhanh 800V đẳng cấp thể thao Đức.',
                'so_luong_kho' => 2,
                'trang_thai' => 'Sẵn hàng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_xe' => 'car-03',
                'ten_xe' => 'BMW 740i Pure Excellence',
                'ma_th' => 'BMW',
                'ma_loai' => 'Sedan',
                'gia_niem_yet' => 6299000000,
                'gia_chu' => '6,299,000,000 VNĐ',
                'nhien_lieu' => 'Xăng (I6 Mild-Hybrid)',
                'cong_suat' => '381 Mã lực',
                'so_cho' => '5 Chỗ',
                'nam_sx' => 2026,
                'nhan_tag' => 'Ưu Đãi',
                'tag_class' => 'tag-sale',
                'hinh_anh' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                'mo_ta' => 'Thiết kế tương lai ấn tượng với lưới tản nhiệt phát sáng Iconic Glow, màn hình rạp chiếu phim Theatre Screen 31 inch phía sau.',
                'so_luong_kho' => 4,
                'trang_thai' => 'Sẵn hàng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_xe' => 'car-04',
                'ten_xe' => 'Audi e-tron GT Quattro',
                'ma_th' => 'Audi',
                'ma_loai' => 'Electric',
                'gia_niem_yet' => 5200000000,
                'gia_chu' => '5,200,000,000 VNĐ',
                'nhien_lieu' => 'Thuần Điện (EV)',
                'cong_suat' => '530 Mã lực',
                'so_cho' => '5 Chỗ',
                'nam_sx' => 2026,
                'nhan_tag' => 'HOT',
                'tag_class' => 'tag-hot',
                'hinh_anh' => 'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop',
                'mo_ta' => 'Tuyệt tác thiết kế Gran Turismo điện năng. Sự kết hợp hoàn hảo giữa cảm giác lái thể thao và tính năng tiện nghi hàng ngày.',
                'so_luong_kho' => 2,
                'trang_thai' => 'Sẵn hàng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_xe' => 'car-05',
                'ten_xe' => 'Range Rover Autobiography LWB',
                'ma_th' => 'Land Rover',
                'ma_loai' => 'SUV',
                'gia_niem_yet' => 11699000000,
                'gia_chu' => '11,699,000,000 VNĐ',
                'nhien_lieu' => 'Xăng (V8 4.4L)',
                'cong_suat' => '530 Mã lực',
                'so_cho' => '5 Chỗ',
                'nam_sx' => 2026,
                'nhan_tag' => 'Mới Về',
                'tag_class' => 'tag-new',
                'hinh_anh' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop',
                'mo_ta' => 'Biểu tượng SUV hạng sang Hoàng gia Anh. Khả năng địa hình vượt trội cùng nội thất tinh tế bậc nhất.',
                'so_luong_kho' => 1,
                'trang_thai' => 'Sẵn hàng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_xe' => 'car-06',
                'ten_xe' => 'Lexus LX 600 VIP 4 Chỗ',
                'ma_th' => 'Lexus',
                'ma_loai' => 'SUV',
                'gia_niem_yet' => 9610000000,
                'gia_chu' => '9,610,000,000 VNĐ',
                'nhien_lieu' => 'Xăng (V6 3.5L Twin-Turbo)',
                'cong_suat' => '409 Mã lực',
                'so_cho' => '4 Chỗ VIP',
                'nam_sx' => 2026,
                'nhan_tag' => 'HOT',
                'tag_class' => 'tag-hot',
                'hinh_anh' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                'mo_ta' => 'Chuyên cơ mặt đất Nhật Bản dành cho các doanh nhân. Cấu hình 4 ghế thương gia cao cấp tích hợp massage, sưởi và làm mát.',
                'so_luong_kho' => 2,
                'trang_thai' => 'Sẵn hàng',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 6. HÓA ĐƠN & CHI TIẾT
        DB::table('hoa_don')->insert([
            [
                'ma_hd' => 'HD0001',
                'ma_kh' => 'KH001',
                'ngay_lap' => '2026-09-16 10:30:00',
                'tong_tien_goc' => 15990000000,
                'giam_gia_hang' => 479700000, // 3% VIP Diamond
                'tong_tien_thanh_toan' => 15510300000,
                'diem_thuong_nhan' => 1551,
                'phuong_thuc_tt' => 'Chuyển khoản Vietcombank VIP',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_hd' => 'HD0002',
                'ma_kh' => 'KH002',
                'ngay_lap' => '2026-09-18 15:45:00',
                'tong_tien_goc' => 9550000000,
                'giam_gia_hang' => 95500000, // 1% Gold
                'tong_tien_thanh_toan' => 9454500000,
                'diem_thuong_nhan' => 945,
                'phuong_thuc_tt' => 'Chuyển khoản MB Bank',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        DB::table('ct_hoa_don')->insert([
            ['ma_hd' => 'HD0001', 'ma_xe' => 'car-01', 'so_luong' => 1, 'don_gia' => 15990000000, 'thanh_tien' => 15990000000, 'created_at' => now(), 'updated_at' => now()],
            ['ma_hd' => 'HD0002', 'ma_xe' => 'car-02', 'so_luong' => 1, 'don_gia' => 9550000000, 'thanh_tien' => 9550000000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 7. LỊCH ĐĂNG KÝ LÁI THỬ
        DB::table('dang_ky_lai_thu')->insert([
            [
                'ma_lich' => 'TD-101',
                'ho_ten' => 'Nguyễn Văn Hùng',
                'sdt' => '0908123456',
                'email' => 'hung.nguyen@gmail.com',
                'ten_xe' => 'Mercedes-Maybach S 680 4MATIC',
                'showroom' => 'Showroom TP. Hồ Chí Minh',
                'thoi_gian' => '2026-09-20 10:00:00',
                'ghi_chu' => 'Yêu cầu mang xe tận nhà trải nghiệm riêng tư.',
                'trang_thai' => 'Đang chờ duyệt',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ma_lich' => 'TD-102',
                'ho_ten' => 'Trần Thị Mai',
                'sdt' => '0912987654',
                'email' => 'mai.tran@gmail.com',
                'ten_xe' => 'Porsche Taycan Turbo S',
                'showroom' => 'Showroom Hà Nội',
                'thoi_gian' => '2026-09-21 14:30:00',
                'ghi_chu' => 'Cần tư vấn thêm gói sạc tại nhà.',
                'trang_thai' => 'Đã xác nhận',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 8. LỊCH SỬ TÍCH ĐIỂM
        DB::table('lich_su_diem')->insert([
            ['ma_kh' => 'KH001', 'ma_hd' => 'HD0001', 'so_diem' => 1551, 'hanh_dong' => 'Mua xe Mercedes-Maybach S 680 tích điểm', 'ngay_tao' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['ma_kh' => 'KH001', 'ma_hd' => null, 'so_diem' => 1000, 'hanh_dong' => 'Thưởng thăng hạng Kim Cương (Diamond VIP)', 'ngay_tao' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['ma_kh' => 'KH002', 'ma_hd' => 'HD0002', 'so_diem' => 945, 'hanh_dong' => 'Mua xe Porsche Taycan Turbo S tích điểm', 'ngay_tao' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 9. NHẬT KÝ CHATBOT & YÊU CẦU TƯ VẤN VIÊN
        DB::table('chat_logs')->truncate();
        DB::table('chat_logs')->insert([
            [
                'ma_tin' => 'MSG-2001',
                'thoi_gian' => '08:45',
                'nguoi_gui' => 'Nguyễn Văn A',
                'sdt_khach' => '0901234567',
                'noi_dung' => 'Xe Mercedes-Maybach S680 bên mình có sẵn màu đen Ruby nội thất Nappa be không? Tôi muốn đặt cọc và giao xe trước Tết tại Quận 2.',
                'loai_cau_hoi' => 'cau_hoi_rieng',
                'phan_hoi_bot' => 'Yêu cầu tùy chọn xe riêng đã được chuyển tới Chuyên viên tư vấn VIP.',
                'trang_thai' => 'Chờ phản hồi',
                'tra_loi_tu_van' => null,
                'ten_tu_van' => null,
                'thoi_gian_tra_loi' => null,
                'created_at' => now()->subMinutes(45),
                'updated_at' => now()->subMinutes(45),
            ],
            [
                'ma_tin' => 'MSG-2002',
                'thoi_gian' => '09:20',
                'nguoi_gui' => 'Trần Thị Mai',
                'sdt_khach' => '0912987654',
                'noi_dung' => 'Tôi đang phân vân giữa Porsche Taycan Turbo S và Audi e-tron GT về thời gian sạc tại nhà và độ bền pin khi đi đường dài. Tư vấn giúp tôi ưu nhược điểm từng dòng.',
                'loai_cau_hoi' => 'cau_hoi_rieng',
                'phan_hoi_bot' => 'Chuyên viên tư vấn xe điện EV đang chuẩn bị bảng so sánh kỹ thuật gửi quý khách.',
                'trang_thai' => 'Đang tư vấn',
                'tra_loi_tu_van' => 'Chào chị Mai! Chuyên viên tư vấn EV PrimeLux xin so sánh nhanh: Taycan Turbo S thiên về cảm giác lái thể thao 750 mã lực, tăng tốc 2.8s; trong khi Audi e-tron GT êm ái hơn và không gian hàng ghế sau rộng rãi hơn. Cả 2 mẫu đều được tặng kèm bộ sạc Wallbox 22kW 3 pha tại nhà và miễn phí sạc 1 năm tại hệ thống trạm đối tác.',
                'ten_tu_van' => 'Lê Tuấn Kiệt (Chuyên viên EV)',
                'thoi_gian_tra_loi' => now()->subMinutes(25),
                'created_at' => now()->subMinutes(35),
                'updated_at' => now()->subMinutes(25),
            ],
            [
                'ma_tin' => 'MSG-2003',
                'thoi_gian' => '10:05',
                'nguoi_gui' => 'Lê Hoàng Long',
                'sdt_khach' => '0933892901',
                'noi_dung' => 'Gói bảo hiểm thân vỏ tặng kèm cho thành viên Bạch Kim có bao gồm bảo hiểm thủy kích ngập nước và mất cắp phụ tùng không?',
                'loai_cau_hoi' => 'cau_hoi_rieng',
                'phan_hoi_bot' => 'Chuyên viên phụ trách bảo hiểm & đặc quyền VIP đang giải đáp.',
                'trang_thai' => 'Đã trả lời',
                'tra_loi_tu_van' => 'Dạ có thưa anh Long! Gói bảo hiểm thân vỏ đặc quyền dành cho Hạng Bạch Kim tại PrimeLux được liên kết cùng Bảo Việt/PVI với điều khoản toàn diện nhất: bao gồm 100% thủy kích ngập nước, bồi thường mất cắp bộ phận và cứu hộ không giới hạn 24/7 trên toàn quốc.',
                'ten_tu_van' => 'Nguyễn Minh Thư (Chuyên viên CSKH VIP)',
                'thoi_gian_tra_loi' => now()->subMinutes(10),
                'created_at' => now()->subMinutes(20),
                'updated_at' => now()->subMinutes(10),
            ],
            [
                'ma_tin' => 'MSG-2004',
                'thoi_gian' => '10:30',
                'nguoi_gui' => 'Hoàng Đức Trọng',
                'sdt_khach' => '0988665544',
                'noi_dung' => 'Showroom có nhận thu cũ đổi mới chiếc Range Rover Vogue 2021 lên bản Autobiography mới không? Quy trình định giá xe cũ tại nhà thế nào?',
                'loai_cau_hoi' => 'cau_hoi_rieng',
                'phan_hoi_bot' => 'Hệ thống đã kết nối bạn với bộ phận Thu cũ đổi mới (Trade-in) PrimeLux.',
                'trang_thai' => 'Chờ phản hồi',
                'tra_loi_tu_van' => null,
                'ten_tu_van' => null,
                'thoi_gian_tra_loi' => null,
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5),
            ]
        ]);

        $this->call(CarPriceSourceSeeder::class);
    }
}
