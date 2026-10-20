<?php

namespace Tests\Feature;

use App\Models\ChatLog;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LiveChatMessengerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_customer_can_send_message_in_session_thread(): void
    {
        $payload = [
            'session_id' => 'SES-TEST-12345',
            'nguoi_gui' => 'Nguyễn Tuấn Khách VIP',
            'sdt_khach' => '0988776655',
            'noi_dung' => 'Maybach S680 màu đen có sẵn giao ngay tuần này không shop?',
            'loai_cau_hoi' => 'live_chat',
        ];

        $response = $this->postJson('/api/consultant/submit-question', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'session_id' => 'SES-TEST-12345',
        ]);

        $this->assertDatabaseHas('chat_logs', [
            'session_id' => 'SES-TEST-12345',
            'sdt_khach' => '0988776655',
            'sender_type' => 'customer',
            'trang_thai' => 'Chờ phản hồi',
        ]);
    }

    public function test_consultant_can_view_thread_messages_and_realtime_feed(): void
    {
        $sessionId = 'SES-STREAM-999';

        ChatLog::create([
            'session_id' => $sessionId,
            'ma_tin' => 'MSG-001',
            'thoi_gian' => '14:30',
            'nguoi_gui' => 'Khách Demo',
            'sender_type' => 'customer',
            'noi_dung' => 'Tư vấn giúp tôi thủ tục trả góp',
            'trang_thai' => 'Chờ phản hồi',
        ]);

        // 1. Thread messages endpoint
        $resThread = $this->getJson("/api/consultant/thread-messages?session_id={$sessionId}");
        $resThread->assertStatus(200);
        $resThread->assertJson([
            'success' => true,
            'count' => 1,
        ]);
        $this->assertEquals('Tư vấn giúp tôi thủ tục trả góp', $resThread->json('messages.0.noi_dung'));

        // 2. Realtime feed endpoint (Bảo mật: khách vãng lai bị chặn 403)
        $resGuest = $this->getJson('/api/consultant/realtime-feed');
        $resGuest->assertStatus(403);

        // 3. Tư vấn viên đã đăng nhập truy cập thành công
        $resFeed = $this->withSession(['user' => ['role' => 'advisor', 'name' => 'Chuyên Viên']])
            ->getJson('/api/consultant/realtime-feed');
        $resFeed->assertStatus(200);
        $resFeed->assertJson([
            'success' => true,
        ]);
        $this->assertGreaterThanOrEqual(1, $resFeed->json('stats.pending'));
    }

    public function test_consultant_reply_appears_immediately_in_customer_thread(): void
    {
        $sessionId = 'SES-REALTIME-777';

        $custMsg = ChatLog::create([
            'session_id' => $sessionId,
            'ma_tin' => 'MSG-777',
            'thoi_gian' => '15:00',
            'nguoi_gui' => 'Bác Hùng VIP',
            'sdt_khach' => '0912345678',
            'sender_type' => 'customer',
            'noi_dung' => 'Bên em có hỗ trợ lái thử Porsche Taycan tận nhà không?',
            'trang_thai' => 'Chờ phản hồi',
        ]);

        // Consultant replies
        $replyPayload = [
            'ma_tin' => 'MSG-777',
            'session_id' => $sessionId,
            'tra_loi' => 'Dạ chào Bác Hùng! PrimeLux mang xe Porsche Taycan tận nhà bác lái thử miễn phí trong chiều nay ạ!',
            'ten_tu_van' => 'Chuyên Viên Hoàng Long',
            'trang_thai' => 'Đã trả lời',
        ];

        // Khách vãng lai không được phép trả lời (bảo vệ bằng AdvisorAuth, trả về 403 Forbidden)
        $unauthReply = $this->postJson('/consultant/reply', $replyPayload);
        $unauthReply->assertStatus(403);

        // Chuyên viên đã đăng nhập thực hiện trả lời thành công
        $replyResponse = $this->withSession(['user' => ['role' => 'advisor', 'name' => 'Chuyên Viên Hoàng Long']])
            ->postJson('/consultant/reply', $replyPayload);
        $replyResponse->assertStatus(200);
        $replyResponse->assertJson(['success' => true]);

        // Customer chatbox checks for reply
        $checkReply = $this->getJson("/api/consultant/check-reply?session_id={$sessionId}");
        $checkReply->assertStatus(200);
        $checkReply->assertJson([
            'success' => true,
            'has_reply' => true,
            'advisor_name' => 'Chuyên Viên Hoàng Long',
        ]);
        $this->assertStringContainsString('Bác Hùng', $checkReply->json('reply'));

        // Verify thread has both customer inquiry and consultant reply
        $thread = $this->getJson("/api/consultant/thread-messages?session_id={$sessionId}");
        $thread->assertStatus(200);
        $this->assertGreaterThanOrEqual(2, $thread->json('count'));
    }

    public function test_consultant_and_tuvanvien_portals_load_ok(): void
    {
        // Khách chưa đăng nhập bị chặn (Yêu cầu 2)
        $guestRes = $this->get('/consultant');
        $guestRes->assertStatus(302);

        // Chuyên viên đã đăng nhập vào thành công
        $res1 = $this->withSession(['user' => ['role' => 'advisor', 'name' => 'Advisor']])->get('/consultant');
        $res1->assertStatus(200);
        $res1->assertSee('PrimeLux');

        $res2 = $this->withSession(['user' => ['role' => 'advisor', 'name' => 'Advisor']])->get('/tuvanvien');
        $res2->assertStatus(200);
        $res2->assertSee('PrimeLux');
    }
}
