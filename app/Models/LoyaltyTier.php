<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTier extends Model
{
    protected $table = 'hang_thanh_vien';

    protected $fillable = [
        'ma_hang',
        'ten_hang',
        'diem_toi_thieu',
        'ti_le_chiet_khau',
        'dac_quyen',
        'mau_badge',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'ma_hang', 'ma_hang');
    }
}
