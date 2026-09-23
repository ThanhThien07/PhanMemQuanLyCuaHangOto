<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestDrive extends Model
{
    protected $table = 'dang_ky_lai_thu';

    protected $fillable = [
        'ma_lich',
        'ho_ten',
        'sdt',
        'email',
        'ten_xe',
        'showroom',
        'thoi_gian',
        'ghi_chu',
        'trang_thai',
    ];

    public static function formatBooking($b): array
    {
        return [
            'id' => $b->ma_lich ?? $b['ma_lich'] ?? $b['id'],
            'name' => $b->ho_ten ?? $b['ho_ten'] ?? $b['name'],
            'phone' => $b->sdt ?? $b['sdt'] ?? $b['phone'],
            'email' => $b->email ?? $b['email'] ?? 'N/A',
            'carName' => $b->ten_xe ?? $b['ten_xe'] ?? $b['carName'],
            'location' => $b->showroom ?? $b['showroom'] ?? $b['location'],
            'date' => $b->thoi_gian ?? $b['thoi_gian'] ?? $b['date'],
            'status' => $b->trang_thai ?? $b['trang_thai'] ?? $b['status'],
        ];
    }

    public static function getAllBookings(): array
    {
        try {
            $dbDrives = self::orderBy('id', 'desc')->get();
            if ($dbDrives->count() > 0) {
                return $dbDrives->map(fn($d) => self::formatBooking($d))->toArray();
            }
        } catch (\Throwable $e) {}

        return self::getDefaultBookings();
    }

    public static function getDefaultBookings(): array
    {
        return [
            [
                'id' => 'TD-101',
                'name' => 'Nguyễn Văn Hùng',
                'phone' => '0908123456',
                'email' => 'hung.nguyen@gmail.com',
                'carName' => 'Mercedes-Maybach S 680 4MATIC',
                'location' => 'Showroom TP. Hồ Chí Minh',
                'date' => '2026-09-20 10:00:00',
                'status' => 'Đang chờ duyệt'
            ],
            [
                'id' => 'TD-102',
                'name' => 'Trần Thị Mai',
                'phone' => '0912987654',
                'email' => 'mai.tran@gmail.com',
                'carName' => 'Porsche Taycan Turbo S',
                'location' => 'Showroom Hà Nội',
                'date' => '2026-09-21 14:30:00',
                'status' => 'Đã xác nhận'
            ]
        ];
    }
}
