<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'thuong_hieu';

    protected $fillable = [
        'ma_th',
        'ten_th',
        'xuat_xu',
        'badge',
        'mo_ta',
    ];
}
