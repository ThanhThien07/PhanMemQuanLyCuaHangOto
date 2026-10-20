<?php

namespace Tests\Feature;

use App\Models\ChatLog;
use App\Models\Customer;
use App\Models\HoaDon;
use App\Models\SepayTransaction;
use App\Models\TestDrive;
use App\Models\Xe;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RealtimeSyncAndCleanDataTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Kiểm tra database đã được dọn sạch dữ liệu mẫu (nhưng giữ nguyên 6 xe trong showroom)
     */
    public function test_database_has_clean_sample_data_while_keeping_cars(): void
    {
        $this->assertEquals(0, ChatLog::count(), 'ChatLog should have 0 mock records for clean demo.');
        $this->assertEquals(0, HoaDon::count(), 'HoaDon should have 0 mock records for clean demo.');
        $this->assertEquals(0, TestDrive::count(), 'TestDrive should have 0 mock records for clean demo.');
        $this->assertEquals(0, SepayTransaction::count(), 'SepayTransaction should have 0 mock records for clean demo.');
        $this->assertGreaterThanOrEqual(6, Xe::count(), 'Showroom must keep all 6 luxury cars.');
    }

    /**
     * Kiểm tra Tra cứu Hóa đơn: Khi trống trả về not found, khi demo tạo đơn thì tra cứu ra hóa đơn thật
     */
    public function test_invoice_lookup_api_returns_not_found_when_empty_and_real_data_after_order(): void
    {
        // 1. Khi chưa có giao dịch, tra cứu mã bất kỳ phải trả về false
        $response = $this->getJson('/api/invoices/lookup?query=HD0001');
        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
            ]);

        // 2. Demo khách mua xe tạo hóa đơn thực tế
        $customer = Customer::firstOrCreate(
            ['sdt' => '0933889977'],
            [
                'ma_kh' => 'KH-TEST-01',
                'ho_ten' => 'Khách Hàng Demo Realtime',
                'email' => 'demo.realtime@primelux.vn',
                'diem_tich_luy' => 1000,
                'tong_chi_tieu' => 15990000000,
            ]
        );

        $realInvoice = HoaDon::create([
            'ma_hd' => 'HD-DEMO99',
            'ma_kh' => $customer->ma_kh,
            'ngay_lap' => now(),
            'tong_tien_goc' => 15990000000,
            'giam_gia_hang' => 0,
            'tong_tien_thanh_toan' => 15990000000,
            'diem_thuong_nhan' => 1599,
            'phuong_thuc_tt' => 'Chuyển khoản SePay / VietQR',
            'thoi_gian_bh' => '36 Tháng Chính Hãng',
            'trang_thai' => 'Đã thanh toán trả trước (30%)',
        ]);

        // 3. Tra cứu theo Mã Hóa Đơn thật
        $resByCode = $this->getJson('/api/invoices/lookup?query=HD-DEMO99');
        $resByCode->assertStatus(200)
            ->assertJson([
                'success' => true,
                'invoice' => [
                    'code' => 'HD-DEMO99',
                    'customer' => 'Khách Hàng Demo Realtime',
                    'phone' => '0933889977',
                    'statusText' => 'Đã thanh toán trả trước (30%)',
                ],
            ]);

        // 4. Tra cứu theo Số Điện Thoại khách
        $resByPhone = $this->getJson('/api/invoices/lookup?query=0933889977');
        $resByPhone->assertStatus(200)
            ->assertJson([
                'success' => true,
                'invoice' => [
                    'code' => 'HD-DEMO99',
                    'customer' => 'Khách Hàng Demo Realtime',
                ],
            ]);
    }

    /**
     * Kiểm tra Luồng Realtime 2 chiều: Khách hỏi câu riêng -> Nhảy sang Bàn trực -> Tư vấn viên reply -> Nhảy về cho khách
     */
    public function test_two_way_realtime_chat_sync_between_customer_and_advisor(): void
    {
        $testSessionId = 'SES-TEST-'.uniqid();
        $customerQuestion = 'Xe Maybach màu đen nội thất đỏ rượu vang có sẵn giao về Cần Thơ trong tuần này không?';

        // 1. Khách hàng đặt câu hỏi không có sẵn trong nội dung mẫu FAQ qua /api/ai/ask
        $aiAskResponse = $this->postJson('/api/ai/ask', [
            'question' => $customerQuestion,
            'session_id' => $testSessionId,
            'name' => 'Nguyễn Anh Tuấn',
            'phone' => '0911223344',
        ]);

        $aiAskResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'should_escalate' => true,
                'session_id' => $testSessionId,
            ]);

        // Kiểm tra câu hỏi đã tự động lưu vào chat_logs với trạng thái "Chờ phản hồi"
        $createdLog = ChatLog::where('session_id', $testSessionId)->first();
        $this->assertNotNull($createdLog);
        $this->assertEquals('Chờ phản hồi', $createdLog->trang_thai);
        $this->assertEquals($customerQuestion, $createdLog->noi_dung);

        // 2. Bàn trực tư vấn viên polling /api/consultant/realtime-feed (không cần F5)
        $feedResponse = $this->withSession(['user' => ['username' => 'advisor', 'role' => 'advisor', 'fullname' => 'Chuyên Viên Cao Cấp']])
            ->getJson('/api/consultant/realtime-feed');

        $feedResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $inquiries = $feedResponse->json('inquiries');
        $this->assertNotEmpty($inquiries);
        $this->assertEquals($createdLog->id, $inquiries[0]['id']);
        $this->assertEquals('Chờ phản hồi', $inquiries[0]['trang_thai']);

        // 3. Tư vấn viên trả lời câu hỏi trực tiếp trên Bàn trực
        $advisorReplyText = 'Dạ chào anh Tuấn! Xe Maybach S680 nội thất đỏ rượu vang đang có sẵn 1 chiếc tại kho miền Nam, showroom cam kết bàn giao tận nhà tại Cần Thơ trong 48 giờ làm việc ạ!';
        $replyResponse = $this->withSession(['user' => ['username' => 'advisor', 'role' => 'advisor', 'fullname' => 'Chuyên Viên Cao Cấp']])
            ->postJson('/consultant/reply', [
                'session_id' => $testSessionId,
                'ma_tin' => $createdLog->ma_tin,
                'tra_loi' => $advisorReplyText,
                'ten_tu_van' => 'Chuyên Viên Cao Cấp Hoàng Nam',
                'trang_thai' => 'Đã trả lời',
            ]);

        $replyResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // 4. Phía Khách hàng: Chatbox polling /api/consultant/check-reply nhận được câu trả lời tức thì mà không cần F5
        $checkReplyResponse = $this->getJson("/api/consultant/check-reply?session_id={$testSessionId}&after_id={$createdLog->id}");

        $checkReplyResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'has_reply' => true,
            ]);

        $newMessages = $checkReplyResponse->json('new_messages');
        $this->assertNotEmpty($newMessages);
        $this->assertEquals($advisorReplyText, $newMessages[0]['noi_dung']);
        $this->assertEquals('Chuyên Viên Cao Cấp Hoàng Nam', $newMessages[0]['nguoi_gui']);
    }
}
