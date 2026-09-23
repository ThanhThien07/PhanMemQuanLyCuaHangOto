<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class All_table extends Seeder
{
    private const MOC_DU_LIEU = '2026-09-11 09:00:00';

    public function run(): void
    {
        $tables = ['khoa', 'nganh', 'lop', 'sinhvien', 'giangvien', 'monhoc', 'lophocphan', 'dangkyhoc'];

        DB::transaction(function () use ($tables) {
            foreach ($tables as $table) {
                if (DB::table($table)->exists()) {
                    throw new RuntimeException("Bảng {$table} đã có dữ liệu. Seeder chỉ dùng khi cả 8 bảng rỗng; không có dữ liệu nào bị xóa hoặc ghi đè.");
                }
            }

            // Mỗi khoa: 2 ngành, 6 giảng viên. Mỗi ngành: 6 môn theo thứ tự học.
            $catalog = [
                ['CNTT', 'Công nghệ thông tin', [
                    ['UDPM', 'Ứng dụng phần mềm', [
                        ['Tin học cơ sở', 3], ['Nhập môn lập trình', 3],
                        ['Cơ sở dữ liệu', 3], ['Lập trình hướng đối tượng', 3],
                        ['Lập trình Web với Laravel', 4], ['Kiểm thử phần mềm', 3],
                    ]],
                    ['QTM', 'Quản trị mạng máy tính', [
                        ['Kiến trúc máy tính', 3], ['Nhập môn mạng máy tính', 3],
                        ['Mạng máy tính', 3], ['Hệ điều hành Linux', 3],
                        ['Quản trị Windows Server', 4], ['An toàn mạng', 3],
                    ]],
                ]],
                ['KT', 'Kinh tế', [
                    ['KTDN', 'Kế toán doanh nghiệp', [
                        ['Kinh tế vi mô', 3], ['Nguyên lý kế toán', 3],
                        ['Kế toán tài chính 1', 3], ['Thống kê doanh nghiệp', 3],
                        ['Kế toán tài chính 2', 4], ['Thực hành kế toán máy', 3],
                    ]],
                    ['QTKD', 'Quản trị kinh doanh', [
                        ['Nhập môn kinh doanh', 3], ['Quản trị học', 3],
                        ['Marketing căn bản', 3], ['Kinh tế doanh nghiệp', 3],
                        ['Quản trị nhân lực', 3], ['Quản trị bán hàng', 3],
                    ]],
                ]],
                ['DL', 'Du lịch và dịch vụ', [
                    ['QTKS', 'Quản trị khách sạn', [
                        ['Tổng quan du lịch', 2], ['Giao tiếp trong dịch vụ', 2],
                        ['Nghiệp vụ lễ tân', 3], ['Nghiệp vụ buồng', 3],
                        ['Quản trị lưu trú', 3], ['Quản trị chất lượng dịch vụ', 3],
                    ]],
                    ['HDDL', 'Hướng dẫn du lịch', [
                        ['Cơ sở văn hóa Việt Nam', 3], ['Địa lý du lịch Việt Nam', 3],
                        ['Tâm lý khách du lịch', 2], ['Nghiệp vụ hướng dẫn', 4],
                        ['Thiết kế chương trình du lịch', 3], ['Điều hành du lịch', 3],
                    ]],
                ]],
                ['CKDT', 'Cơ khí và điện tử', [
                    ['CNOTO', 'Công nghệ ô tô', [
                        ['Vẽ kỹ thuật', 3], ['Cơ kỹ thuật', 3],
                        ['Cấu tạo động cơ ô tô', 3], ['Hệ thống điện ô tô', 3],
                        ['Chẩn đoán kỹ thuật ô tô', 4], ['Bảo dưỡng và sửa chữa ô tô', 4],
                    ]],
                    ['DDT', 'Điện công nghiệp', [
                        ['An toàn điện', 2], ['Mạch điện cơ bản', 3],
                        ['Máy điện', 3], ['Khí cụ điện', 3],
                        ['Điều khiển lập trình PLC', 4], ['Trang bị điện công nghiệp', 3],
                    ]],
                ]],
            ];

            $sttNganh = 0;
            foreach ($catalog as $ki => [$maKhoa, $tenKhoa, $nganhList]) {
                $khoaId = $this->them('khoa', ['ma_khoa' => $maKhoa, 'ten_khoa' => $tenKhoa], '2024-07-01 08:00:00');
                $gvIds = [];
                for ($g = 1; $g <= 6; $g++) {
                    $maGV = sprintf('GV%03d', $ki * 6 + $g);
                    $gvIds[] = $this->them('giangvien', [
                        'khoa_id' => $khoaId,
                        'ma_giangvien' => $maGV,
                        'ho_ten' => $this->hoTen($maGV, $g % 2 === 0 ? 'nu' : 'nam'),
                        'email' => strtolower($maGV).'@example.com',
                    ], '2024-07-01 08:00:00');
                }

                foreach ($nganhList as $ni => [$maNganh, $tenNganh, $monList]) {
                    $sttNganh++;
                    $nganhId = $this->them('nganh', [
                        'khoa_id' => $khoaId, 'ma_nganh' => $maNganh, 'ten_nganh' => $tenNganh,
                    ], '2024-07-01 08:00:00');
                    $monIds = [];
                    foreach ($monList as $mi => [$tenMon, $tinChi]) {
                        $monIds[] = $this->them('monhoc', [
                            'ma_monhoc' => sprintf('%s%02d', $maNganh, $mi + 1),
                            'ten_monhoc' => $tenMon, 'so_tin_chi' => $tinChi,
                        ], '2024-07-01 08:00:00');
                    }

                    foreach ([2024, 2025, 2026] as $namNhapHoc) {
                        $maLop = $maNganh.$namNhapHoc.'A';
                        $ngayNhapHoc = $namNhapHoc.'-08-15 08:00:00';
                        $lopId = $this->them('lop', [
                            'nganh_id' => $nganhId, 'ma_lop' => $maLop,
                            'ten_lop' => $tenNganh.' '.$namNhapHoc.' - Lớp A',
                            'khoa_hoc' => $namNhapHoc.'-'.($namNhapHoc + 3),
                        ], $ngayNhapHoc);
                        $svIds = [];
                        for ($s = 1; $s <= 35; $s++) {
                            $maSV = sprintf('%d%02d%03d', $namNhapHoc, $sttNganh, $s);
                            $gioiTinh = $this->so($maSV.'gt', 0, 1) === 0 ? 'nam' : 'nu';
                            $namSinh = $namNhapHoc - $this->so($maSV.'tuoi', 18, 20);
                            $svIds[] = $this->them('sinhvien', [
                                'lop_id' => $lopId, 'ma_sinhvien' => $maSV,
                                'ho_ten' => $this->hoTen($maSV, $gioiTinh),
                                'ngay_sinh' => sprintf('%d-%02d-%02d', $namSinh, $this->so($maSV.'thang', 1, 12), $this->so($maSV.'ngay', 1, 28)),
                                'gioi_tinh' => $gioiTinh,
                                'email' => 'sv'.$maSV.'@example.com',
                            ], $ngayNhapHoc);
                        }

                        // Chỉ mô phỏng một phần kế hoạch học tập, không phải toàn bộ CTĐT.
                        // Khóa 2024: môn 3-4 đã học; môn 5-6 đang học.
                        // Khóa 2025: môn 1-2 đã học; môn 3-4 đang học.
                        // Khóa 2026: chỉ môn 1-2 đang học, không có lịch sử trước nhập học.
                        $keHoach = $namNhapHoc === 2024
                            ? [[2, true], [3, true], [4, false], [5, false]]
                            : ($namNhapHoc === 2025
                                ? [[0, true], [1, true], [2, false], [3, false]]
                                : [[0, false], [1, false]]);

                        foreach ($keHoach as [$mi, $daKetThuc]) {
                            $namHoc = $daKetThuc ? '2025-2026' : '2026-2027';
                            $hocKy = $daKetThuc ? 2 : 1;
                            $maLHP = sprintf('%s%02d-%s-%d-%dA', $maNganh, $mi + 1, substr($namHoc, 0, 4), $hocKy, $namNhapHoc);
                            $ngayMo = $daKetThuc ? '2025-12-01 08:00:00' : '2026-08-16 08:00:00';
                            $lhpId = $this->them('lophocphan', [
                                'monhoc_id' => $monIds[$mi],
                                'giangvien_id' => $gvIds[$ni * 3 + ($mi % 3)],
                                'ma_lophocphan' => $maLHP, 'hoc_ky' => $hocKy,
                                'nam_hoc' => $namHoc, 'si_so_toi_da' => 40,
                            ], $ngayMo);

                            foreach ($svIds as $si => $svId) {
                                $key = $maLHP.'-'.($si + 1);
                                $huy = $this->so($key.'huy', 1, 100) <= 5;
                                $trangThai = $huy ? 'da_huy' : ($daKetThuc ? 'hoan_thanh' : 'da_dang_ky');
                                $ngayDangKy = ($daKetThuc ? '2025-12-' : '2026-08-')
                                    .sprintf('%02d', $this->so($key.'dk', 20, 28)).' 09:00:00';
                                // Điểm tập trung quanh 7; vẫn có điểm thấp để luyện truy vấn.
                                $diem = null;
                                if ($trangThai === 'hoan_thanh') {
                                    $diem = $this->so($key.'truot', 1, 100) <= 12
                                        ? $this->so($key.'diem', 20, 49) / 10
                                        : round(($this->so($key.'d1', 50, 100) + $this->so($key.'d2', 50, 100)) / 20, 1);
                                }
                                $this->them('dangkyhoc', [
                                    'sinhvien_id' => $svId, 'lophocphan_id' => $lhpId,
                                    'ngay_dang_ky' => $ngayDangKy, 'trang_thai' => $trangThai,
                                    'diem_tong_ket' => $diem,
                                ], $ngayDangKy, $huy
                                    ? ($daKetThuc ? '2026-01-05 10:00:00' : '2026-09-03 10:00:00')
                                    : ($daKetThuc ? '2026-06-20 15:00:00' : $ngayDangKy));
                            }
                        }
                    }
                }
            }

            $expected = [4, 8, 24, 840, 24, 48, 80, 2800];
            foreach ($tables as $i => $table) {
                if (DB::table($table)->count() !== $expected[$i]) {
                    throw new RuntimeException("Số bản ghi bảng {$table} không đúng dự kiến; hoàn tác lần nạp.");
                }
            }
        });

        if ($this->command) {
            $this->command->info('Đã nạp dữ liệu giả lập, mốc '.self::MOC_DU_LIEU);
            $this->command->table(['Bảng', 'Số bản ghi'], array_map(function ($table) {
                return [$table, DB::table($table)->count()];
            }, $tables));
        }
    }

    private function them(string $table, array $data, string $created, ?string $updated = null): int
    {
        return (int) DB::table($table)->insertGetId(array_merge($data, [
            'created_at' => $created, 'updated_at' => $updated ?? $created,
        ]));
    }

    // Tạo số cố định từ khóa: cùng dữ liệu đầu vào luôn cho cùng kết quả.
    private function so(string $key, int $min, int $max): int
    {
        return $min + ((int) hexdec(substr(hash('sha256', $key), 0, 7)) % ($max - $min + 1));
    }

    private function hoTen(string $key, string $gioiTinh): string
    {
        $ho = ['Nguyễn', 'Nguyễn', 'Trần', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Đinh'];
        $nam = ['Minh Anh', 'Quốc Bảo', 'Tuấn Kiệt', 'Đức Anh', 'Hoàng Nam', 'Gia Huy', 'Minh Khang', 'Đăng Khoa', 'Nhật Minh', 'Thành Đạt', 'Trung Hiếu', 'Quang Huy', 'Đức Phúc', 'Bảo Long', 'Anh Tuấn', 'Hữu Nghĩa', 'Tiến Dũng', 'Thanh Tùng', 'Minh Quân', 'Công Thành', 'Văn Hưng', 'Hoài Phong', 'Đình Khôi', 'Quốc Thịnh'];
        $nu = ['Ngọc Anh', 'Phương Anh', 'Thảo Nguyên', 'Khánh Linh', 'Minh Thư', 'Ngọc Hân', 'Thanh Trúc', 'Bảo Ngọc', 'Quỳnh Như', 'Thu Hà', 'Mỹ Duyên', 'Hồng Nhung', 'Kim Ngân', 'Phương Thảo', 'Hoài An', 'Thanh Mai', 'Diễm My', 'Ngọc Ánh', 'Thùy Trang', 'Trúc Linh', 'Bích Ngọc', 'Hải Yến', 'Tường Vy', 'Gia Hân'];
        $ten = $gioiTinh === 'nu' ? $nu : $nam;
        return $ho[$this->so($key.'ho', 0, count($ho) - 1)].' '.$ten[$this->so($key.'ten', 0, count($ten) - 1)];
    }
}
