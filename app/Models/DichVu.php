<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    use HasFactory;

    protected $table = 'dich_vu';

    protected $fillable = [
        'ma_dv',
        'loai_dv',
        'ten_loai_dv',
        'ten_dv',
        'tieu_de',
        'gia_tham_khao',
        'hinh_anh',
        'mo_ta',
        'quy_trinh',
        'dac_quyen',
        'trang_thai',
    ];

    /**
     * Lấy tên hiển thị loại dịch vụ
     */
    public function getLoaiDvBadgeAttribute()
    {
        return match ($this->loai_dv) {
            'bao_tri'  => ['label' => 'Bảo Trì Định Kỳ', 'class' => 'bg-primary'],
            'bao_hiem' => ['label' => 'Bảo Hiểm Thân Vỏ', 'class' => 'bg-info text-dark'],
            'cuu_ho'   => ['label' => 'Hỗ Trợ & Cứu Hộ 24/7', 'class' => 'bg-danger'],
            'sua_chua' => ['label' => 'Sửa Chữa & Sơn Hấp', 'class' => 'bg-warning text-dark'],
            'uu_dai'   => ['label' => 'Ưu Đãi Khách Hàng VIP', 'class' => 'bg-success'],
            default    => ['label' => 'Dịch Vụ Khác', 'class' => 'bg-secondary'],
        };
    }
}
