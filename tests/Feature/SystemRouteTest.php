<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SystemRouteTest extends TestCase
{
    use DatabaseMigrations;

    public function test_all_major_routes_return_ok(): void
    {
        $routes = [
            '/',
            '/trangchu',
            '/home',
            '/xe',
            '/cars',
            '/xe/1',
            '/sosanh',
            '/compare',
            '/laithu',
            '/test-drive',
            '/hoadon',
            '/invoices',
            '/tichdiem',
            '/loyalty',
            '/dangnhap',
            '/login',
            '/quantri',
            '/admin',
            '/tuvanvien',
            '/consultant',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $this->assertContains($response->getStatusCode(), [200, 302], "Failed on route: $route");
        }
    }

    public function test_test_drive_booking_submission(): void
    {
        $payload = [
            'ho_ten'    => 'Nguyễn Văn Test',
            'sdt'       => '0988776655',
            'email'     => 'test@example.com',
            'ten_xe'    => 'Mercedes-Maybach S 680',
            'showroom'  => 'Showroom 1 - Quận 1 TP.HCM',
            'thoi_gian' => '2026-10-01 09:00:00',
            'ghi_chu'   => 'Lái thử trải nghiệm xe mới',
        ];

        $response = $this->post('/laithu', $payload);
        $this->assertContains($response->getStatusCode(), [200, 302]);
    }

    public function test_loyalty_check_api(): void
    {
        $response = $this->get('/api/loyalty/check?q=0909123456');
        $this->assertContains($response->getStatusCode(), [200, 404]);
    }

    public function test_consultant_question_submit_api(): void
    {
        $payload = [
            'nguoi_gui' => 'Khách VIP Demo',
            'sdt_khach' => '0912345678',
            'noi_dung'  => 'Tư vấn giúp tôi chương trình khuyến mãi tháng này',
        ];

        $response = $this->postJson('/api/consultant/submit-question', $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
