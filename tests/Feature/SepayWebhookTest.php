<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SepayWebhookTest extends TestCase
{
    use DatabaseMigrations;

    public function test_admin_payments_page_loads_successfully(): void
    {
        // Khách vãng lai bị chặn bởi AdminAuth
        $this->get('/admin/payments')->assertStatus(302);

        // Quản trị viên truy cập thành công
        $response = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->get('/admin/payments');
        $response->assertStatus(200);
        $response->assertSee('Quản Lý Thanh Toán & SePay Webhook');
        $response->assertSee('hooks/sepay-payment');
        $response->assertSee('ba_0VXvtCFwZHBJL8Lb7GYukenOW9B');
    }

    public function test_sepay_webhook_endpoint_receives_transaction_successfully(): void
    {
        $payload = [
            'id' => 998811,
            'gateway' => 'MBBank',
            'transactionDate' => '2026-10-13 20:00:00',
            'accountNumber' => '0338929013',
            'subAccount' => null,
            'code' => 'PLDP2610137788',
            'content' => 'PLDP2610137788 0988776655 CAR-01',
            'transferType' => 'in',
            'description' => 'Thanh toan tien tra truoc Maybach',
            'transferAmount' => 4797000000,
            'referenceCode' => 'MB2610139911',
            'accumulated' => 4797000000,
        ];

        $response = $this->postJson('/hooks/sepay-payment', $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('sepay_transactions', [
            'code' => 'PLDP2610137788',
            'transfer_amount' => 4797000000,
            'account_number' => '0338929013',
        ]);
    }

    public function test_sepay_api_webhook_alias_also_works(): void
    {
        $payload = [
            'id' => 998812,
            'gateway' => 'MBBank',
            'transactionDate' => '2026-10-13 20:05:00',
            'accountNumber' => '0338929013',
            'code' => 'PLDP2610136655',
            'content' => 'PLDP2610136655 0912987654 CAR-02',
            'transferType' => 'in',
            'transferAmount' => 100000000,
            'referenceCode' => 'MB2610139922',
        ];

        $response = $this->postJson('/api/sepay/webhook', $payload);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_create_downpayment_initial_status_is_chua_thanh_toan(): void
    {
        $response = $this->postJson('/api/payment/create-downpayment', [
            'car_id' => 'car-01',
            'car_name' => 'Mercedes-Maybach S 680',
            'car_price' => 15990000000,
            'percent' => 30,
            'customer_name' => 'Khách Hàng Mới',
            'customer_phone' => '0988112233',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'payment_status' => 'CHUA_THANH_TOAN',
            'status_label' => 'Chưa thanh toán',
        ]);

        $transCode = $response->json('transaction_id');
        $this->assertDatabaseHas('sepay_transactions', [
            'code' => $transCode,
            'status' => 'CHUA_THANH_TOAN',
        ]);
    }

    public function test_web_request_verify_sepay_updates_status_to_xac_minh_thanh_cong(): void
    {
        // 1. Tạo đơn cọc ở trạng thái Chưa thanh toán
        $createRes = $this->postJson('/api/payment/create-downpayment', [
            'car_id' => 'car-02',
            'car_name' => 'Porsche Taycan',
            'car_price' => 9500000000,
            'percent' => 30,
            'customer_name' => 'Trần Văn Verified',
            'customer_phone' => '0912345678',
        ]);
        $transCode = $createRes->json('transaction_id');

        // 2. Gửi Web Request xác thực SePay
        $verifyRes = $this->postJson('/api/payment/verify-sepay', [
            'transaction_id' => $transCode,
            'force_confirm' => true,
        ]);

        $verifyRes->assertStatus(200);
        $verifyRes->assertJson([
            'success' => true,
            'payment_status' => 'XAC_MINH_THANH_CONG',
            'status_label' => 'Xác minh thành công',
        ]);

        // Kiểm tra trong DB đã đổi sang Xác minh thành công
        $this->assertDatabaseHas('sepay_transactions', [
            'code' => $transCode,
            'status' => 'XAC_MINH_THANH_CONG',
            'is_notified_admin' => false,
        ]);

        // 3. Admin polling bắt được giao dịch này để hiện Form Popup góc phải
        $adminSession = ['user' => ['role' => 'admin', 'name' => 'Admin']];
        $notifRes = $this->withSession($adminSession)->getJson('/admin/payments/latest-notification');
        $notifRes->assertStatus(200);
        $notifRes->assertJson([
            'has_new' => true,
            'transaction' => [
                'code' => $transCode,
                'status_label' => 'Xác minh thành công',
            ],
        ]);

        // 4. Admin đánh dấu đã xem thông báo
        $markRes = $this->withSession($adminSession)->postJson('/admin/payments/mark-notified', [
            'code' => $transCode,
        ]);
        $markRes->assertStatus(200);
        $markRes->assertJson(['success' => true]);

        // Sau khi đánh dấu thì không còn popup lặp lại
        $notifRes2 = $this->withSession($adminSession)->getJson('/admin/payments/latest-notification');
        $notifRes2->assertJson(['has_new' => false]);
    }
}
