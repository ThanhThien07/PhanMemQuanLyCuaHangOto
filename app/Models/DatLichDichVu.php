<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatLichDichVu extends Model
{
    use HasFactory;

    protected $table = 'dat_lich_dich_vu';

    protected $fillable = [
        'ma_dat_lich',
        'ho_ten',
        'sdt',
        'email',
        'bien_so',
        'ten_xe',
        'showroom',
        'loai_dich_vu',
        'ten_dich_vu_cu_the',
        'thoi_gian_hen',
        'vi_tri_cuu_ho',
        'ghi_chu',
        'trang_thai',
    ];

    /**
     * Lấy badge trạng thái đặt lịch
     */
    public function getTrangThaiBadgeAttribute()
    {
        return match ($this->trang_thai) {
            'Đang chờ tiếp nhận' => ['label' => 'Đang Chờ Tiếp Nhận', 'class' => 'bg-warning text-dark'],
            'Đã xác nhận' => ['label' => 'Đã Xác Nhận', 'class' => 'bg-info text-dark'],
            'Đang xử lý' => ['label' => 'Đang Tiến Hành', 'class' => 'bg-primary'],
            'Hoàn tất' => ['label' => 'Hoàn Tất', 'class' => 'bg-success'],
            'Đã hủy' => ['label' => 'Đã Hủy', 'class' => 'bg-danger'],
            default => ['label' => $this->trang_thai, 'class' => 'bg-secondary'],
        };
    }
}
