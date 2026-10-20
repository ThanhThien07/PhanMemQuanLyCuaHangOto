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

            return $dbDrives->map(fn ($d) => self::formatBooking($d))->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function getDefaultBookings(): array
    {
        return [];
    }
}
