<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenueSeeder extends Seeder
{
    public function run(): void
    {
        // Thêm hóa đơn mẫu phân bổ nhiều tháng để có dữ liệu biểu đồ thống kê
        // Tháng 7/2026
        $extraInvoices = [
            [
                'ma_hd' => 'HD0003', 'ma_kh' => 'KH003',
                'ngay_lap' => '2026-07-05 09:00:00',
                'tong_tien_goc' => 6299000000,
                'giam_gia_hang' => 125980000,
                'tong_tien_thanh_toan' => 6173020000,
                'diem_thuong_nhan' => 617,
                'phuong_thuc_tt' => 'Chuyển khoản BIDV',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-07-05 09:00:00',
                'updated_at' => '2026-07-05 09:00:00'
            ],
            [
                'ma_hd' => 'HD0004', 'ma_kh' => 'KH001',
                'ngay_lap' => '2026-07-12 14:30:00',
                'tong_tien_goc' => 9610000000,
                'giam_gia_hang' => 288300000,
                'tong_tien_thanh_toan' => 9321700000,
                'diem_thuong_nhan' => 932,
                'phuong_thuc_tt' => 'Chuyển khoản Techcombank VIP',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-07-12 14:30:00',
                'updated_at' => '2026-07-12 14:30:00'
            ],
            [
                'ma_hd' => 'HD0005', 'ma_kh' => 'KH004',
                'ngay_lap' => '2026-07-22 11:15:00',
                'tong_tien_goc' => 5200000000,
                'giam_gia_hang' => 0,
                'tong_tien_thanh_toan' => 5200000000,
                'diem_thuong_nhan' => 520,
                'phuong_thuc_tt' => 'Chuyển khoản ACB',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-07-22 11:15:00',
                'updated_at' => '2026-07-22 11:15:00'
            ],
            // Tháng 8/2026
            [
                'ma_hd' => 'HD0006', 'ma_kh' => 'KH002',
                'ngay_lap' => '2026-08-03 10:00:00',
                'tong_tien_goc' => 11699000000,
                'giam_gia_hang' => 116990000,
                'tong_tien_thanh_toan' => 11582010000,
                'diem_thuong_nhan' => 1158,
                'phuong_thuc_tt' => 'Chuyển khoản Vietcombank',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-08-03 10:00:00',
                'updated_at' => '2026-08-03 10:00:00'
            ],
            [
                'ma_hd' => 'HD0007', 'ma_kh' => 'KH003',
                'ngay_lap' => '2026-08-10 16:00:00',
                'tong_tien_goc' => 15990000000,
                'giam_gia_hang' => 319800000,
                'tong_tien_thanh_toan' => 15670200000,
                'diem_thuong_nhan' => 1567,
                'phuong_thuc_tt' => 'Chuyển khoản MB Bank',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-08-10 16:00:00',
                'updated_at' => '2026-08-10 16:00:00'
            ],
            [
                'ma_hd' => 'HD0008', 'ma_kh' => 'KH001',
                'ngay_lap' => '2026-08-18 09:30:00',
                'tong_tien_goc' => 9550000000,
                'giam_gia_hang' => 286500000,
                'tong_tien_thanh_toan' => 9263500000,
                'diem_thuong_nhan' => 926,
                'phuong_thuc_tt' => 'Chuyển khoản Vietcombank VIP',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-08-18 09:30:00',
                'updated_at' => '2026-08-18 09:30:00'
            ],
            [
                'ma_hd' => 'HD0009', 'ma_kh' => 'KH004',
                'ngay_lap' => '2026-08-25 15:00:00',
                'tong_tien_goc' => 6299000000,
                'giam_gia_hang' => 0,
                'tong_tien_thanh_toan' => 6299000000,
                'diem_thuong_nhan' => 630,
                'phuong_thuc_tt' => 'Chuyển khoản Sacombank',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-08-25 15:00:00',
                'updated_at' => '2026-08-25 15:00:00'
            ],
            // Tháng 9/2026 (ngoài 2 hóa đơn HD0001,HD0002 đã có)
            [
                'ma_hd' => 'HD0010', 'ma_kh' => 'KH003',
                'ngay_lap' => '2026-09-08 10:00:00',
                'tong_tien_goc' => 11699000000,
                'giam_gia_hang' => 233980000,
                'tong_tien_thanh_toan' => 11465020000,
                'diem_thuong_nhan' => 1147,
                'phuong_thuc_tt' => 'Chuyển khoản Techcombank',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-09-08 10:00:00',
                'updated_at' => '2026-09-08 10:00:00'
            ],
            [
                'ma_hd' => 'HD0011', 'ma_kh' => 'KH004',
                'ngay_lap' => '2026-09-22 14:00:00',
                'tong_tien_goc' => 9610000000,
                'giam_gia_hang' => 0,
                'tong_tien_thanh_toan' => 9610000000,
                'diem_thuong_nhan' => 961,
                'phuong_thuc_tt' => 'Chuyển khoản ACB',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-09-22 14:00:00',
                'updated_at' => '2026-09-22 14:00:00'
            ],
            [
                'ma_hd' => 'HD0012', 'ma_kh' => 'KH002',
                'ngay_lap' => '2026-09-28 11:00:00',
                'tong_tien_goc' => 5200000000,
                'giam_gia_hang' => 52000000,
                'tong_tien_thanh_toan' => 5148000000,
                'diem_thuong_nhan' => 515,
                'phuong_thuc_tt' => 'Chuyển khoản MB Bank',
                'thoi_gian_bh' => '36 Tháng',
                'trang_thai' => 'Đã thanh toán',
                'created_at' => '2026-09-28 11:00:00',
                'updated_at' => '2026-09-28 11:00:00'
            ],
        ];

        // Chỉ insert khi chưa có
        foreach ($extraInvoices as $inv) {
            if (DB::table('hoa_don')->where('ma_hd', $inv['ma_hd'])->doesntExist()) {
                DB::table('hoa_don')->insert($inv);
            }
        }

        // Chi tiết hóa đơn tương ứng
        $extraDetails = [
            ['ma_hd' => 'HD0003', 'ma_xe' => 'car-03', 'so_luong' => 1, 'don_gia' => 6299000000, 'thanh_tien' => 6299000000],
            ['ma_hd' => 'HD0004', 'ma_xe' => 'car-06', 'so_luong' => 1, 'don_gia' => 9610000000, 'thanh_tien' => 9610000000],
            ['ma_hd' => 'HD0005', 'ma_xe' => 'car-04', 'so_luong' => 1, 'don_gia' => 5200000000, 'thanh_tien' => 5200000000],
            ['ma_hd' => 'HD0006', 'ma_xe' => 'car-05', 'so_luong' => 1, 'don_gia' => 11699000000, 'thanh_tien' => 11699000000],
            ['ma_hd' => 'HD0007', 'ma_xe' => 'car-01', 'so_luong' => 1, 'don_gia' => 15990000000, 'thanh_tien' => 15990000000],
            ['ma_hd' => 'HD0008', 'ma_xe' => 'car-02', 'so_luong' => 1, 'don_gia' => 9550000000, 'thanh_tien' => 9550000000],
            ['ma_hd' => 'HD0009', 'ma_xe' => 'car-03', 'so_luong' => 1, 'don_gia' => 6299000000, 'thanh_tien' => 6299000000],
            ['ma_hd' => 'HD0010', 'ma_xe' => 'car-05', 'so_luong' => 1, 'don_gia' => 11699000000, 'thanh_tien' => 11699000000],
            ['ma_hd' => 'HD0011', 'ma_xe' => 'car-06', 'so_luong' => 1, 'don_gia' => 9610000000, 'thanh_tien' => 9610000000],
            ['ma_hd' => 'HD0012', 'ma_xe' => 'car-04', 'so_luong' => 1, 'don_gia' => 5200000000, 'thanh_tien' => 5200000000],
        ];

        foreach ($extraDetails as $detail) {
            if (DB::table('ct_hoa_don')->where('ma_hd', $detail['ma_hd'])->doesntExist()) {
                DB::table('ct_hoa_don')->insert(array_merge($detail, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
