<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoBaoHanhVin extends Model
{
    protected $table = 'so_bao_hanh_vin';

    protected $fillable = [
        'vin',
        'bien_so',
        'ten_xe',
        'chu_so_huu',
        'sdt_chu_xe',
        'ngay_giao_xe',
        'thoi_han_bao_hanh_nam',
        'ngay_het_han_bh',
        'so_km_hien_tai',
        'goi_bao_hanh',
        'trang_thai',
    ];

    public function serviceHistory()
    {
        return $this->hasMany(LichSuBaoDuongVin::class, 'vin', 'vin')->orderBy('ngay_bao_duong', 'desc');
    }
}
