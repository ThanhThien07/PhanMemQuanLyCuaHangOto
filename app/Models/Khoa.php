<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Khoa extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'khoa';

    // Các trường được phép gán qua create(), update(), fill()
    protected $fillable = [
        'ma_khoa',
        'ten_khoa',
    ];

    public function nganhs(): HasMany
    {
        return $this->hasMany(Nganh::class, 'khoa_id', 'id');
    }

    public function giangviens(): HasMany
    {
        return $this->hasMany(GiangVien::class, 'khoa_id', 'id');
    }
}