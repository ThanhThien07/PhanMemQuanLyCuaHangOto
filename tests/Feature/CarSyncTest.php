<?php

namespace Tests\Feature;

use App\Models\Xe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CarSyncTest extends TestCase
{
    use DatabaseMigrations;

    public function test_api_cars_index_returns_all_cars(): void
    {
        $response = $this->getJson('/api/cars');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'version',
                'cars',
                'total',
            ])
            ->assertJson(['success' => true]);
    }

    public function test_api_cars_feed_handles_smart_polling(): void
    {
        // 1. Lần đầu fetch không có last_sync -> updated = true
        $res1 = $this->getJson('/api/cars/feed');
        $res1->assertStatus(200)
            ->assertJson(['success' => true, 'updated' => true])
            ->assertJsonStructure(['version', 'cars']);

        $version = $res1->json('version');

        // 2. Fetch lần 2 với last_sync trùng khớp -> updated = false (siêu nhẹ)
        $res2 = $this->getJson('/api/cars/feed?last_sync='.$version);
        $res2->assertStatus(200)
            ->assertJson([
                'success' => true,
                'updated' => false,
                'version' => $version,
            ]);
    }

    public function test_admin_car_crud_and_realtime_stats_flow(): void
    {
        // 1. Thêm xe mới vào kho
        $payload = [
            'ten_xe' => 'Porsche 911 GT3 RS',
            'ma_th' => 'Porsche',
            'ma_loai' => 'Sedan',
            'gia_niem_yet' => 17990000000,
            'nam_sx' => 2026,
            'nhien_lieu' => 'Xăng thể thao',
            'cong_suat' => '525 Mã lực',
            'so_cho' => '2 Chỗ',
            'so_luong_kho' => 1,
            'trang_thai' => 'Sẵn sàng giao',
            'nhan_tag' => 'Mới Về',
            'hinh_anh' => 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=800',
            'mo_ta' => 'Siêu phẩm đường đua hợp pháp lăn bánh đường phố.',
        ];

        // Chưa đăng nhập bị chặn (trả về 403 Forbidden cho JSON request)
        $unauthStore = $this->postJson('/admin/cars/store', $payload);
        $unauthStore->assertStatus(403);

        // Đăng nhập Admin thực hiện thành công
        $storeRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson('/admin/cars/store', $payload);
        $storeRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'message',
                'car' => ['id', 'name', 'price', 'brand'],
                'stats' => ['totalCars', 'inStockCount', 'totalWarehouseValue'],
            ]);

        $newCar = $storeRes->json('car');
        $carId = $newCar['id'];

        // 2. Cập nhật thông tin xe
        $updatePayload = array_merge($payload, [
            'ten_xe' => 'Porsche 911 GT3 RS Carbon Edition',
            'gia_niem_yet' => 19500000000,
            'nhan_tag' => 'HOT',
        ]);

        $updateRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson("/admin/cars/{$carId}/update", $updatePayload);
        $updateRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('car.name', 'Porsche 911 GT3 RS Carbon Edition')
            ->assertJsonStructure(['stats']);

        // 3. Đổi trạng thái xe 1-click
        $statusRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson("/admin/cars/{$carId}/status", [
                'trang_thai' => 'Đã đặt cọc',
            ]);
        $statusRes->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'Đã đặt cọc',
            ])
            ->assertJsonStructure(['stats']);

        // 4. Xóa xe khỏi kho
        $deleteRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson("/admin/cars/{$carId}/delete");
        $deleteRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['stats']);
    }

    public function test_test_drive_booking_returns_stats_and_updates_status(): void
    {
        // 1. Khách hàng đặt lịch lái thử
        $bookingPayload = [
            'ho_ten' => 'Nguyễn Văn Test',
            'sdt' => '0987654321',
            'email' => 'test@primelux.vn',
            'ten_xe' => 'Mercedes-Maybach S680',
            'showroom' => 'Showroom Quận 7, TP.HCM',
            'thoi_gian' => '2026-11-01 09:00:00',
            'ghi_chu' => 'Lái thử buổi sáng',
        ];

        $res = $this->postJson('/test-drive', $bookingPayload);
        $res->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['id', 'code', 'ho_ten', 'sdt', 'ten_xe', 'showroom', 'thoi_gian'],
                'stats' => ['total', 'pending', 'contacted', 'completed'],
            ]);

        $driveId = $res->json('data.id');

        // 2. Admin cập nhật trạng thái lịch hẹn 1-click
        $statusRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson("/admin/test-drives/{$driveId}/status", [
                'trang_thai' => 'Đã liên hệ',
            ]);
        $statusRes->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'Đã liên hệ',
            ])
            ->assertJsonStructure(['stats']);

        // 3. Admin xóa lịch hẹn
        $deleteRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->postJson("/admin/test-drives/{$driveId}/delete");
        $deleteRes->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['stats']);
    }
}
