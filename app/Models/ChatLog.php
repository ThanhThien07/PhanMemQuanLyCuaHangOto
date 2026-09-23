<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $table = 'chat_logs';

    protected $fillable = [
        'ma_tin',
        'thoi_gian',
        'nguoi_gui',
        'sdt_khach',
        'noi_dung',
        'loai_cau_hoi',
        'phan_hoi_bot',
        'trang_thai',
        'tra_loi_tu_van',
        'ten_tu_van',
        'thoi_gian_tra_loi',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'sdt_khach', 'sdt');
    }
}
