<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'ct_hoa_don';

    protected $fillable = [
        'ma_hd',
        'ma_xe',
        'so_luong',
        'don_gia',
        'thanh_tien',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'ma_hd', 'ma_hd');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'ma_xe', 'ma_xe');
    }
}
