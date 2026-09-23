<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'xe';

    protected $fillable = [
        'ma_xe',
        'ten_xe',
        'ma_th',
        'ma_loai',
        'gia_niem_yet',
        'gia_chu',
        'nhien_lieu',
        'cong_suat',
        'so_cho',
        'nam_sx',
        'nhan_tag',
        'tag_class',
        'hinh_anh',
        'mo_ta',
        'so_luong_kho',
        'trang_thai',
    ];

    /**
     * Map database row to standard array format
     */
    public static function formatCar($car): array
    {
        return [
            'id' => $car->ma_xe ?? $car['ma_xe'] ?? $car['id'],
            'brand' => $car->ma_th ?? $car['ma_th'] ?? $car['brand'],
            'name' => $car->ten_xe ?? $car['ten_xe'] ?? $car['name'],
            'price' => (float)($car->gia_niem_yet ?? $car['gia_niem_yet'] ?? $car['price']),
            'priceText' => $car->gia_chu ?? $car['gia_chu'] ?? (isset($car->gia_niem_yet) ? number_format($car->gia_niem_yet, 0, ',', '.') . ' VNĐ' : $car['priceText']),
            'type' => $car->ma_loai ?? $car['ma_loai'] ?? $car['type'],
            'fuel' => $car->nhien_lieu ?? $car['nhien_lieu'] ?? $car['fuel'],
            'power' => $car->cong_suat ?? $car['cong_suat'] ?? $car['power'],
            'seats' => $car->so_cho ?? $car['so_cho'] ?? $car['seats'],
            'tag' => $car->nhan_tag ?? $car['nhan_tag'] ?? $car['tag'],
            'tagClass' => $car->tag_class ?? $car['tag_class'] ?? $car['tagClass'],
            'image' => $car->hinh_anh ?? $car['hinh_anh'] ?? $car['image'],
            'desc' => $car->mo_ta ?? $car['mo_ta'] ?? $car['desc'],
        ];
    }

    /**
     * Retrieve all cars from database with fallback
     */
    public static function getAllCars(): array
    {
        try {
            $dbCars = self::orderBy('id', 'asc')->get();
            if ($dbCars->count() > 0) {
                return $dbCars->map(fn($c) => self::formatCar($c))->toArray();
            }
        } catch (\Throwable $e) {
            // Fallback to default
        }
        return self::getDefaultCars();
    }

    public static function getDefaultCars(): array
    {
        return [
            [
                'id' => 'car-01',
                'brand' => 'Mercedes-Benz',
                'name' => 'Mercedes-Maybach S 680 4MATIC',
                'price' => 15990000000,
                'priceText' => '15,990,000,000 VNĐ',
                'type' => 'Sedan',
                'fuel' => 'Xăng (V12 6.0L)',
                'power' => '612 Mã lực',
                'seats' => '4 Chỗ',
                'tag' => 'HOT',
                'tagClass' => 'tag-hot',
                'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Đỉnh cao sự sang trọng và thượng lưu. Mercedes-Maybach S 680 được trang bị động cơ V12 bi-turbo mạnh mẽ, hệ dẫn động 4 bánh toàn thời gian cùng khoang hạng nhất cao cấp.'
            ],
            [
                'id' => 'car-02',
                'brand' => 'Porsche',
                'name' => 'Porsche Taycan Turbo S',
                'price' => 9550000000,
                'priceText' => '9,550,000,000 VNĐ',
                'type' => 'Electric',
                'fuel' => 'Thuần Điện (EV)',
                'power' => '761 Mã lực',
                'seats' => '4 Chỗ',
                'tag' => 'Mới Về',
                'tagClass' => 'tag-new',
                'image' => 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Siêu xe thuần điện với khả năng tăng tốc 0-100km/h trong 2.8 giây. Công nghệ sạc siêu nhanh 800V đẳng cấp thể thao Đức.'
            ],
            [
                'id' => 'car-03',
                'brand' => 'BMW',
                'name' => 'BMW 740i Pure Excellence',
                'price' => 6299000000,
                'priceText' => '6,299,000,000 VNĐ',
                'type' => 'Sedan',
                'fuel' => 'Xăng (I6 Mild-Hybrid)',
                'power' => '381 Mã lực',
                'seats' => '5 Chỗ',
                'tag' => 'Ưu Đãi',
                'tagClass' => 'tag-sale',
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Thiết kế tương lai ấn tượng với lưới tản nhiệt phát sáng Iconic Glow, màn hình rạp chiếu phim Theatre Screen 31 inch phía sau.'
            ],
            [
                'id' => 'car-04',
                'brand' => 'Audi',
                'name' => 'Audi e-tron GT Quattro',
                'price' => 5200000000,
                'priceText' => '5,200,000,000 VNĐ',
                'type' => 'Electric',
                'fuel' => 'Thuần Điện (EV)',
                'power' => '530 Mã lực',
                'seats' => '5 Chỗ',
                'tag' => 'HOT',
                'tagClass' => 'tag-hot',
                'image' => 'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Tuyệt tác thiết kế Gran Turismo điện năng. Sự kết hợp hoàn hảo giữa cảm giác lái thể thao và tính năng tiện nghi hàng ngày.'
            ],
            [
                'id' => 'car-05',
                'brand' => 'Land Rover',
                'name' => 'Range Rover Autobiography LWB',
                'price' => 11699000000,
                'priceText' => '11,699,000,000 VNĐ',
                'type' => 'SUV',
                'fuel' => 'Xăng (V8 4.4L)',
                'power' => '530 Mã lực',
                'seats' => '5 Chỗ',
                'tag' => 'Mới Về',
                'tagClass' => 'tag-new',
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Biểu tượng SUV hạng sang Hoàng gia Anh. Khả năng địa hình vượt trội cùng nội thất tinh tế bậc nhất.'
            ],
            [
                'id' => 'car-06',
                'brand' => 'Lexus',
                'name' => 'Lexus LX 600 VIP 4 Chỗ',
                'price' => 9610000000,
                'priceText' => '9,610,000,000 VNĐ',
                'type' => 'SUV',
                'fuel' => 'Xăng (V6 3.5L Twin-Turbo)',
                'power' => '409 Mã lực',
                'seats' => '4 Chỗ VIP',
                'tag' => 'HOT',
                'tagClass' => 'tag-hot',
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Chuyên cơ mặt đất Nhật Bản dành cho các doanh nhân. Cấu hình 4 ghế thương gia cao cấp tích hợp massage, sưởi và làm mát.'
            ]
        ];
    }
}
