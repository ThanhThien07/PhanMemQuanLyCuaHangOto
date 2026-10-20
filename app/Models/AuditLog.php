<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'user_name',
        'user_role',
        'action',
        'details',
        'ip_address',
    ];

    /**
     * Bootstrap model events
     * Áp dụng chính sách bảo mật: Miễn trừ Super Admin khỏi bị theo dõi / ghi nhật ký.
     */
    protected static function booted(): void
    {
        static::creating(function (AuditLog $log) {
            $currentRole = session('user.role');
            $currentName = session('user.name', '');
            $currentEmail = session('user.email', '');

            // Nếu người thực hiện là Super Admin -> Không ghi lại nhật ký
            if ($currentRole === 'superadmin'
                || stripos($currentName, 'Super Admin') !== false
                || $currentEmail === 'superadmin'
                || stripos((string) $log->user_role, 'Super Admin') !== false
                || stripos((string) $log->user_name, 'Super Admin') !== false) {
                return false; // Hủy ghi log vào CSDL
            }
        });
    }

    /**
     * Ghi nhận nhật ký an toàn
     */
    public static function logAction(array $data): ?self
    {
        return self::create($data);
    }
}
