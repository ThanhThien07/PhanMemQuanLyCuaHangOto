<?php

namespace Tests\Feature;

use Database\Seeders\RoadmapDataSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoadmapFeaturesTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoadmapDataSeeder::class);
    }

    public function test_tradein_portal_loads_successfully()
    {
        $response = $this->get('/trade-in');
        $response->assertStatus(200);
        $response->assertSee('Thẩm Định Xe Cũ & Thu Cũ Đổi Mới');
        $response->assertSee('Kiểm Định 176 Hạng Mục');
    }

    public function test_tradein_calculation_api_returns_estimated_price()
    {
        $response = $this->postJson('/api/trade-in/calculate', [
            'hang_xe' => 'Mercedes-Benz',
            'nam_sx' => 2023,
            'so_km' => 25000,
            'tinh_trang' => 'good',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'brand' => 'Mercedes-Benz',
        ]);
        $this->assertNotEmpty($response->json('formatted_price'));
    }

    public function test_vin_warranty_lookup_returns_vehicle_and_service_history()
    {
        $response = $this->getJson('/api/dich-vu/so-bao-hanh-vin?vin=WBA53BJ04RFP98124');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertEquals('Mercedes-Maybach S 680 4MATIC (2026)', $response->json('data.ten_xe'));
        $this->assertNotEmpty($response->json('data.history'));
    }

    public function test_ai_consultant_endpoint_answers_inquiries()
    {
        $response = $this->postJson('/api/ai/ask', [
            'question' => 'Tư vấn cho tôi giá xe Maybach S 680 và chi phí lăn bánh',
            'phone' => '0908889999',
            'name' => 'Nguyễn Thành Nam',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertNotEmpty($response->json('answer'));
        $this->assertNotEmpty($response->json('suggested_questions'));
    }

    public function test_admin_export_endpoints_return_downloadable_files()
    {
        $resCars = $this->get('/admin/export/cars');
        $resCars->assertStatus(200);
        $resCars->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $resDrives = $this->get('/admin/export/test-drives');
        $resDrives->assertStatus(200);
        $resDrives->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $resInvoices = $this->get('/admin/export/invoices');
        $resInvoices->assertStatus(200);
        $resInvoices->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    public function test_admin_tradein_and_audit_log_views_load_successfully()
    {
        $resTradeIn = $this->get('/admin/trade-in');
        $resTradeIn->assertStatus(200);
        $resTradeIn->assertSee('Thu Cũ Đổi Mới');

        $resAudit = $this->get('/admin/audit-logs');
        $resAudit->assertStatus(200);
        $resAudit->assertSee('Nhật Ký Hoạt Động (Audit Log)');
        $resAudit->assertSee('Google Authenticator');
    }
}
