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
     * Map database row or array to standard enriched format
     */
    public static function formatCar($car): array
    {
        $id = $car->ma_xe ?? $car['ma_xe'] ?? $car['id'] ?? 'car-01';
        $brand = $car->ma_th ?? $car['ma_th'] ?? $car['brand'] ?? 'Mercedes-Benz';
        $name = $car->ten_xe ?? $car['ten_xe'] ?? $car['name'] ?? '';
        $price = (float)($car->gia_niem_yet ?? $car['gia_niem_yet'] ?? $car['price'] ?? 0);
        $priceText = $car->gia_chu ?? $car['gia_chu'] ?? ($price > 0 ? number_format($price, 0, ',', '.') . ' VNĐ' : ($car['priceText'] ?? '0 VNĐ'));
        $type = $car->ma_loai ?? $car['ma_loai'] ?? $car['type'] ?? 'Sedan';
        $fuel = $car->nhien_lieu ?? $car['nhien_lieu'] ?? $car['fuel'] ?? 'Xăng';
        $power = $car->cong_suat ?? $car['cong_suat'] ?? $car['power'] ?? '400 Mã lực';
        $seats = $car->so_cho ?? $car['so_cho'] ?? $car['seats'] ?? '5 Chỗ';
        $tag = $car->nhan_tag ?? $car['nhan_tag'] ?? $car['tag'] ?? 'Mới Về';
        $tagClass = $car->tag_class ?? $car['tag_class'] ?? $car['tagClass'] ?? 'tag-new';
        $image = $car->hinh_anh ?? $car['hinh_anh'] ?? $car['image'] ?? '';
        $desc = $car->mo_ta ?? $car['mo_ta'] ?? $car['desc'] ?? '';
        $year = (int)($car->nam_sx ?? $car['nam_sx'] ?? $car['year'] ?? 2026);
        $stock = (int)($car->so_luong_kho ?? $car['so_luong_kho'] ?? $car['stock'] ?? 3);
        $status = $car->trang_thai ?? $car['trang_thai'] ?? $car['status'] ?? 'Sẵn sàng giao';

        // Lấy thông tin hộp số và specs mặc định theo mã xe nếu DB chưa có cột riêng
        $defaults = self::getCarDefaultsById($id);

        $transmission = $car->hop_so ?? $car['hop_so'] ?? $car['transmission'] ?? $defaults['transmission'] ?? 'Tự động 8 cấp';
        $isNew = isset($car['is_new']) ? (bool)$car['is_new'] : ($tag === 'Mới Về' || in_array($id, ['car-02', 'car-05']));
        $isBestSeller = isset($car['is_best_seller']) ? (bool)$car['is_best_seller'] : ($tag === 'HOT' || in_array($id, ['car-01', 'car-04', 'car-06']));

        $galleryExterior = $car['gallery_exterior'] ?? $defaults['gallery_exterior'] ?? [
            $image,
            'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=800&auto=format&fit=crop'
        ];

        $galleryInterior = $car['gallery_interior'] ?? $defaults['gallery_interior'] ?? [
            'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=800&auto=format&fit=crop'
        ];

        $specs = $car['specs'] ?? $defaults['specs'] ?? [
            'engine' => $fuel,
            'power' => $power,
            'torque' => '650 Nm',
            'transmission' => $transmission,
            'drivetrain' => 'Dẫn động 4 bánh toàn thời gian (AWD)',
            'acceleration' => '4.5 giây (0-100 km/h)',
            'topSpeed' => '250 km/h',
            'dimensions' => '5.200 x 1.950 x 1.500 mm',
            'safety' => [
                'Gói an toàn chủ động cao cấp (Hỗ trợ phanh AEB, giữ làn LKA, giám sát điểm mù BSM)',
                'Hệ thống 11 túi khí bảo vệ toàn diện',
                'Hệ thống camera 360 độ 3D Surround View và cảm biến đỗ xe trước/sau',
                'Hệ thống cân bằng điện tử ESP và hỗ trợ khởi hành ngang dốc'
            ]
        ];

        return [
            'id' => $id,
            'brand' => $brand,
            'name' => $name,
            'price' => $price,
            'priceText' => $priceText,
            'type' => $type,
            'fuel' => $fuel,
            'power' => $power,
            'seats' => $seats,
            'year' => $year,
            'transmission' => $transmission,
            'stock' => $stock,
            'status' => $status,
            'tag' => $tag,
            'tagClass' => $tagClass,
            'is_new' => $isNew,
            'is_best_seller' => $isBestSeller,
            'image' => $image,
            'desc' => $desc,
            'gallery_exterior' => $galleryExterior,
            'gallery_interior' => $galleryInterior,
            'specs' => $specs,
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

    /**
     * Thông tin chi tiết mặc định theo ID xe
     */
    public static function getCarDefaultsById($id): array
    {
        $all = self::getDefaultCars();
        foreach ($all as $c) {
            if ($c['id'] === $id) {
                return $c;
            }
        }
        return $all[0] ?? [];
    }

    /**
     * Bộ dữ liệu xe sang đầy đủ chi tiết
     */
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
                'year' => 2026,
                'transmission' => 'Tự động 9 cấp 9G-TRONIC',
                'stock' => 2,
                'status' => 'Sẵn sàng giao',
                'tag' => 'HOT',
                'tagClass' => 'tag-hot',
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Đỉnh cao sự sang trọng và thượng lưu. Mercedes-Maybach S 680 được trang bị động cơ V12 bi-turbo mạnh mẽ, hệ dẫn động 4 bánh toàn thời gian cùng khoang thương gia hạng nhất bọc da Nappa Exclusive.',
                'gallery_exterior' => [
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop',
                ],
                'gallery_interior' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                ],
                'specs' => [
                    'engine' => 'V12 6.0L Bi-Turbo',
                    'power' => '612 Mã lực @ 5.250 rpm',
                    'torque' => '900 Nm @ 2.000 - 4.000 rpm',
                    'transmission' => 'Tự động 9 cấp 9G-TRONIC',
                    'drivetrain' => 'Dẫn động 4 bánh toàn thời gian 4MATIC',
                    'acceleration' => '4.5 giây (0 - 100 km/h)',
                    'topSpeed' => '250 km/h (Giới hạn điện tử)',
                    'dimensions' => '5.469 x 1.921 x 1.510 mm (Trục cơ sở: 3.396 mm)',
                    'safety' => [
                        'Hệ thống 11 túi khí bao gồm túi khí chính diện hàng ghế sau',
                        'Gói an toàn chủ động Driving Assistance Package Plus cao cấp',
                        'Hệ thống phanh tự động khẩn cấp PRE-SAFE Impulse Side bảo vệ va chạm ngang',
                        'Hệ thống camera 360 độ 3D Surround View sắc nét hỗ trợ đỗ xe tự động',
                        'Hệ thống treo khí nén chủ động AIRMATIC kết hợp công nghệ E-ACTIVE BODY CONTROL',
                        'Đèn pha thông minh DIGITAL LIGHT chiếu hình ảnh hướng dẫn xuống mặt đường'
                    ]
                ]
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
                'year' => 2026,
                'transmission' => 'Tự động 2 cấp thể thao Porsche',
                'stock' => 1,
                'status' => 'Sẵn sàng giao',
                'tag' => 'Mới Về',
                'tagClass' => 'tag-new',
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Siêu xe thuần điện với khả năng tăng tốc 0-100km/h trong 2.8 giây. Công nghệ sạc siêu nhanh 800V đẳng cấp thể thao đường đua từ Stuttgart.',
                'gallery_exterior' => [
                    'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop',
                ],
                'gallery_interior' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                ],
                'specs' => [
                    'engine' => 'Mô-tơ điện kép Dual Permanent Magnet Synchronous',
                    'power' => '761 Mã lực (560 kW khi kích hoạt Launch Control)',
                    'torque' => '1.050 Nm cực đại tức thời',
                    'transmission' => 'Hộp số tự động 2 cấp thể thao trục sau',
                    'drivetrain' => 'Dẫn động 4 bánh toàn phần AWD thông minh',
                    'acceleration' => '2.8 giây (0 - 100 km/h)',
                    'topSpeed' => '260 km/h',
                    'dimensions' => '4.963 x 1.966 x 1.378 mm (Trục cơ sở: 2.900 mm)',
                    'safety' => [
                        'Hệ thống phanh gốm carbon Porsche Ceramic Composite Brake (PCCB)',
                        'Gói Porsche InnoDrive kèm ga tự động thích ứng thông minh',
                        'Hỗ trợ quan sát ban đêm Night Vision Assist với camera hồng ngoại',
                        'Hệ thống hỗ trợ chuyển làn và cảnh báo phương tiện cắt ngang',
                        '8 túi khí bảo vệ thể thao toàn diện quanh cabin',
                        'Hệ thống cân bằng chủ động Porsche Dynamic Chassis Control Sport (PDCC Sport)'
                    ]
                ]
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
                'year' => 2025,
                'transmission' => 'Tự động 8 cấp Steptronic thể thao',
                'stock' => 3,
                'status' => 'Sẵn sàng giao',
                'tag' => 'Ưu Đãi',
                'tagClass' => 'tag-sale',
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Thiết kế tương lai ấn tượng với lưới tản nhiệt phát sáng Iconic Glow, màn hình rạp chiếu phim Theatre Screen 31 inch 8K phía sau cùng nội thất pha lê Crafted Clarity.',
                'gallery_exterior' => [
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                ],
                'gallery_interior' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                ],
                'specs' => [
                    'engine' => 'I6 3.0L TwinPower Turbo kết hợp Mild-Hybrid 48V',
                    'power' => '381 Mã lực @ 5.200 - 6.250 rpm',
                    'torque' => '540 Nm (Boost lên 520 Nm) @ 1.850 - 5.000 rpm',
                    'transmission' => 'Tự động 8 cấp Steptronic thể thao',
                    'drivetrain' => 'Dẫn động cầu sau thể thao (RWD)',
                    'acceleration' => '5.4 giây (0 - 100 km/h)',
                    'topSpeed' => '250 km/h',
                    'dimensions' => '5.391 x 1.950 x 1.544 mm (Trục cơ sở: 3.215 mm)',
                    'safety' => [
                        'Gói hỗ trợ lái chuyên nghiệp Driving Assistant Professional',
                        'Hệ thống đỗ xe tự động từ xa qua điện thoại Parking Assistant Professional',
                        'Cảnh báo va chạm trước và phanh khẩn cấp tự động Active Guard',
                        'Camera 360 Surround View 3D kèm chức năng ghi hình hành trình Drive Recorder',
                        '10 túi khí bảo vệ khoang hành khách',
                        'Hệ thống kiểm soát hành trình chủ động Active Cruise Control với Stop&Go'
                    ]
                ]
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
                'year' => 2025,
                'transmission' => 'Tự động 2 cấp điện tử',
                'stock' => 2,
                'status' => 'Sẵn sàng giao',
                'tag' => 'HOT',
                'tagClass' => 'tag-hot',
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Tuyệt tác thiết kế Gran Turismo điện năng với đường nét khí động học gợi cảm. Hệ thống sạc nhanh 800V cùng cảm giác lái thể thao quattro lừng danh.',
                'gallery_exterior' => [
                    'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                ],
                'gallery_interior' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                ],
                'specs' => [
                    'engine' => 'Mô-tơ điện đồng bộ nam châm vĩnh cửu Dual E-Motors',
                    'power' => '530 Mã lực (khi bật Boost Mode)',
                    'torque' => '640 Nm tức thời',
                    'transmission' => 'Hộp số tự động 2 cấp điện tử trục sau',
                    'drivetrain' => 'Dẫn động 4 bánh toàn thời gian Quattro điện tử',
                    'acceleration' => '4.1 giây (0 - 100 km/h)',
                    'topSpeed' => '245 km/h',
                    'dimensions' => '4.989 x 1.964 x 1.413 mm (Trục cơ sở: 2.898 mm)',
                    'safety' => [
                        'Gói hỗ trợ Tour Assist & City Assist cảnh báo va chạm đa điểm',
                        'Hệ thống phanh khẩn cấp Audi pre sense front & rear',
                        'Cảnh báo điểm mù và cảnh báo phương tiện cắt ngang khi lùi',
                        'Camera 360 độ 3D mô phỏng góc nhìn thực tế ảo',
                        'Hệ thống 8 túi khí quanh xe',
                        'Hệ thống treo khí nén thích ứng 3 buồng Adaptive Air Suspension'
                    ]
                ]
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
                'year' => 2026,
                'transmission' => 'Tự động 8 cấp điện tử ZF',
                'stock' => 1,
                'status' => 'Sẵn sàng giao',
                'tag' => 'Mới Về',
                'tagClass' => 'tag-new',
                'is_new' => true,
                'is_best_seller' => false,
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Biểu tượng SUV hạng sang Hoàng gia Anh. Khả năng địa hình vượt trội cùng nội thất tinh tế bậc nhất với ghế massage đá nóng và kính cách âm 2 lớp.',
                'gallery_exterior' => [
                    'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop',
                ],
                'gallery_interior' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                ],
                'specs' => [
                    'engine' => 'V8 4.4L Twin-Turbocharged',
                    'power' => '530 Mã lực @ 5.500 - 6.000 rpm',
                    'torque' => '750 Nm @ 1.800 - 4.600 rpm',
                    'transmission' => 'Tự động 8 cấp điện tử ZF kèm lẫy chuyển số',
                    'drivetrain' => 'Dẫn động 4 bánh thông minh All-Wheel Drive (AWD)',
                    'acceleration' => '4.6 giây (0 - 100 km/h)',
                    'topSpeed' => '250 km/h',
                    'dimensions' => '5.252 x 2.047 x 1.870 mm (Trục cơ sở dài: 3.197 mm)',
                    'safety' => [
                        'Hệ thống đánh lái 4 bánh toàn phần All-Wheel Steering linh hoạt',
                        'Hệ thống phản ứng địa hình thông minh Terrain Response 2',
                        'Hỗ trợ lội nước sâu tới 900mm với cảm biến Wade Sensing',
                        'Camera 3D vòm toàn cảnh 360 độ ClearSight Ground View',
                        '10 túi khí an toàn cao cấp bao gồm túi khí rèm toàn xe',
                        'Ga tự động thích ứng với tính năng Hỗ trợ đánh lái giữ làn'
                    ]
                ]
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
                'year' => 2024,
                'transmission' => 'Tự động 10 cấp Direct-Shift',
                'stock' => 2,
                'status' => 'Sẵn sàng giao',
                'tag' => 'HOT',
                'tagClass' => 'tag-hot',
                'is_new' => false,
                'is_best_seller' => true,
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Chuyên cơ mặt đất Nhật Bản dành cho các yếu nhân và doanh nhân. Cấu hình 4 ghế thương gia cao cấp ngả 48 độ tích hợp massage 7 chế độ, sưởi và làm mát.',
                'gallery_exterior' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop',
                ],
                'gallery_interior' => [
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                ],
                'specs' => [
                    'engine' => 'V6 3.5L Twin-Turbo (V35A-FTS)',
                    'power' => '409 Mã lực @ 5.200 rpm',
                    'torque' => '650 Nm @ 2.000 - 3.600 rpm',
                    'transmission' => 'Tự động 10 cấp Direct-Shift thông minh',
                    'drivetrain' => 'Dẫn động 4 bánh toàn thời gian 4WD có vi sai Torsen',
                    'acceleration' => '6.9 giây (0 - 100 km/h)',
                    'topSpeed' => '210 km/h',
                    'dimensions' => '5.100 x 1.990 x 1.865 mm (Trục cơ sở: 2.850 mm)',
                    'safety' => [
                        'Gói an toàn chủ động Lexus Safety System+ 2.5 thế hệ mới',
                        'Hệ thống cảnh báo tiền va chạm PCS nhận diện người đi bộ ban đêm',
                        'Kiểm soát hành trình chủ động bằng radar Dynamic Radar Cruise Control mọi dải tốc độ',
                        'Hỗ trợ theo dõi làn đường Lane Tracing Assist và đèn pha tự động BladeScan AHS',
                        '10 túi khí an toàn bao bọc quanh 4 vị trí ghế VIP',
                        'Hệ thống điều chỉnh chiều cao chủ động AHC kết hợp hệ thống treo thích ứng AVS'
                    ]
                ]
            ]
        ];
    }
}
