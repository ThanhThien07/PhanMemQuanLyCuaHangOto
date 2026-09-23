<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPriceSource extends Model
{
    protected $table = 'car_price_sources';

    protected $fillable = [
        'car_id',
        'source_name',
        'source_logo',
        'source_url',
        'car_name',
        'version',
        'manufacture_year',
        'price',
        'location',
        'condition_type',
        'warranty',
        'fetched_at',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'manufacture_year' => 'integer',
        'fetched_at' => 'datetime',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
}
