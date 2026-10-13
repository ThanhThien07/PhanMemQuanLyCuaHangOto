<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBaoDaKenh extends Model
{
    protected $table = 'thong_bao_da_kenh';

    protected $fillable = [
        'ma_thong_bao',
        'loai_kenh',
        'muc_dich',
        'nguoi_nhan',
        'sdt_email',
        'tieu_de',
        'noi_dung',
        'trang_thai',
        'thoi_gian_gui',
    ];

    protected $casts = [
        'thoi_gian_gui' => 'datetime',
    ];
}
