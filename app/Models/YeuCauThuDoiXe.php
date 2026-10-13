<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuCauThuDoiXe extends Model
{
    protected $table = 'yeu_cau_thu_doi_xe';

    protected $fillable = [
        'ma_yeu_cau',
        'ho_ten',
        'sdt',
        'email',
        'hang_xe',
        'dong_xe',
        'nam_sx',
        'so_km',
        'tinh_trang',
        'xe_du_dinh_doi',
        'gia_dinh_gia_so_bo',
        'gia_chot',
        'hinh_anh',
        'ghi_chu',
        'trang_thai',
    ];

    protected $casts = [
        'gia_dinh_gia_so_bo' => 'float',
        'gia_chot' => 'float',
    ];
}
