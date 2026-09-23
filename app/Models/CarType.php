<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $table = 'loai_xe';

    protected $fillable = [
        'ma_loai',
        'ten_loai',
        'mo_ta',
    ];
}
