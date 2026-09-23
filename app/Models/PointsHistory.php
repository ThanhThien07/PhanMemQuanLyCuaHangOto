<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsHistory extends Model
{
    protected $table = 'lich_su_diem';

    protected $fillable = [
        'ma_kh',
        'ma_hd',
        'so_diem',
        'hanh_dong',
        'ngay_tao',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'ma_kh', 'ma_kh');
    }
}
