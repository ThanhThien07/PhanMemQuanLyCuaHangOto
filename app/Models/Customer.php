<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'khach_hang';

    protected $fillable = [
        'ma_kh',
        'ho_ten',
        'sdt',
        'email',
        'dia_chi',
        'ngay_sinh',
        'mat_khau',
        'diem_tich_luy',
        'tong_chi_tieu',
        'ma_hang',
    ];

    public function tier()
    {
        return $this->belongsTo(LoyaltyTier::class, 'ma_hang', 'ma_hang');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'ma_kh', 'ma_kh');
    }

    public function pointsHistory()
    {
        return $this->hasMany(PointsHistory::class, 'ma_kh', 'ma_kh')->orderBy('ngay_tao', 'desc');
    }
}
