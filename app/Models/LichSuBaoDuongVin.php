<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichSuBaoDuongVin extends Model
{
    protected $table = 'lich_su_bao_duong_vin';

    protected $fillable = [
        'vin',
        'ngay_bao_duong',
        'moc_km',
        'noi_dung',
        'phu_tung_thay_the',
        'chi_phi',
        'ky_thuat_vien',
        'showroom',
        'diem_tich_luy_nhan',
    ];

    protected $casts = [
        'chi_phi' => 'float',
    ];

    public function warranty()
    {
        return $this->belongsTo(SoBaoHanhVin::class, 'vin', 'vin');
    }
}
