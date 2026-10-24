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
                'updated_at' => now(),
            ],
            [
                'ma_hang' => 'GOLD',
                'ten_hang' => 'Hạng Vàng (Gold)',
                'diem_toi_thieu' => 1000,
                'ti_le_chiet_khau' => 1.00,
                'dac_quyen' => 'Chiết khấu 1% trực tiếp khi mua xe tiếp theo (tiết kiệm đến hàng trăm triệu VNĐ). Tặng 1 năm bảo dưỡng miễn phí. Giảm 10% phụ kiện cao cấp. Ưu tiên bàn giao xe.',
                'mau_badge' => 'warning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_hang' => 'PLATINUM',
                'ten_hang' => 'Hạng Bạch Kim (Platinum)',
                'diem_toi_thieu' => 5000,
                'ti_le_chiet_khau' => 2.00,
                'dac_quyen' => 'Chiết khấu 2% trực tiếp khi mua xe. Tặng gói Bảo hiểm thân vỏ 1 năm (trị giá lên đến 100.000.000 VNĐ). Giao xe tận nhà bằng xe chuyên dụng VIP. Cứu hộ riêng 24/7 toàn quốc.',
                'mau_badge' => 'info',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_hang' => 'DIAMOND',
                'ten_hang' => 'Hạng Kim Cương (Diamond VIP)',
                'diem_toi_thieu' => 10000,
                'ti_le_chiet_khau' => 3.00,
                'dac_quyen' => 'Đặc quyền chiết khấu 3% giá trị mọi siêu xe. Tặng gói phủ Ceramic cao cấp & dán film cách nhiệt chính hãng. Vé mời VIP tham dự sự kiện ra mắt xe quốc tế. Chăm sóc xe trọn đời tại Flagship.',
                'mau_badge' => 'primary',
                'created_at' => now(),
                'updated_at' => now(),
            ],
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
                'updated_at' => now(),
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
                'updated_at' => now(),
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
                'updated_at' => now(),
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
                'updated_at' => now(),
            ],
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
                'updated_at' => now(),
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
                'updated_at' => now(),
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
                'updated_at' => now(),
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
                'updated_at' => now(),
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
                'updated_at' => now(),
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
                'updated_at' => now(),
            ],
        ]);

        // 6. HÓA ĐƠN, LÁI THỬ & CHAT LOGS
        // Để trống CSDL sẵn sàng cho người dùng thực hiện các thao tác Demo thực tế.

        $this->call(CarPriceSourceSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(RoadmapDataSeeder::class);
    }
}
