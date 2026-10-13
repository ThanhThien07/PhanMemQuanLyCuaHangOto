<?php

namespace Tests\Feature;

use App\Models\SepayTransaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DownPaymentTest extends TestCase
{
    use DatabaseMigrations;

    public function test_down_payment_page_loads_with_gateway_info(): void
    {
        $response = $this->get('/thanh-toan-tra-truoc');
        $response->assertStatus(200);
        $response->assertSee('Thanh Toán Online');
        $response->assertSee('MBBank');
        $response->assertSee('VietQR');
    }

    public function test_api_gateway_info_returns_expected_json(): void
    {
        $response = $this->getJson('/api/payment/gateway-info');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
        ]);
    }

    public function test_api_create_down_payment_returns_correct_response(): void
    {
        $payload = [
            'car_id' => 'car-01',
            'car_name' => 'Mercedes-Maybach S 680',
            'car_price' => 15990000000,
            'percent' => 30,
            'customer_name' => 'Test Customer',
            'customer_phone' => '0901234567',
        ];

        $response = $this->postJson('/api/payment/create-downpayment', $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
            'down_payment_percent' => 30,
        ]);
        $response->assertJsonStructure([
            'status',
            'id',
            'transaction_id',
            'qr_url',
            'transfer_content',
            'down_payment_amount',
        ]);
    }

    public function test_api_check_payment_status_returns_success(): void
    {
        SepayTransaction::create([
            'code' => 'PLDP2610138901',
            'status' => SepayTransaction::STATUS_VERIFIED,
            'transfer_amount' => 100000000,
        ]);

        $response = $this->postJson('/api/payment/check-status', [
            'transaction_id' => 'PLDP2610138901',
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
            'payment_status' => 'PAID',
        ]);
    }

    public function test_car_detail_page_includes_down_payment_and_gateway(): void
    {
        $response = $this->get('/cars/car-01');
        $response->assertStatus(200);
        $response->assertSee('Thanh Toán Trả Trước Online');
        $response->assertSee('MBBank');
    }

    public function test_invoice_page_includes_down_payment_tab(): void
    {
        $response = $this->get('/hoadon');
        $response->assertStatus(200);
        $response->assertSee('Thanh Toán Online Trả Trước');
        $response->assertSee('MBBank');
    }
}
