<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\HoaDon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserPromptRequirementsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Yêu cầu 1a: Trang đăng ký và đăng nhập riêng biệt cho khách hàng
     */
    public function test_registration_page_loads_and_creates_new_member(): void
    {
        $res = $this->get('/register');
        $res->assertStatus(200);
        $res->assertSee('Đăng Ký Thành Viên PrimeLux Club');
        $res->assertSee('Đăng Ký Nhanh Bằng Tài Khoản Google');

        $registerPayload = [
            'ho_ten' => 'Võ Hoàng Long',
            'sdt' => '0933887766',
            'email' => 'hoanglong@primelux.vn',
            'mat_khau' => '12345678',
            'mat_khau_confirmation' => '12345678',
            'dia_chi' => 'TP. Hồ Chí Minh',
        ];

        $postRes = $this->post('/register', $registerPayload);
        $postRes->assertRedirect(route('loyalty'));

        $this->assertDatabaseHas('khach_hang', [
            'email' => 'hoanglong@primelux.vn',
            'sdt' => '0933887766',
        ]);

        $this->assertEquals('customer', session('user.role'));
    }

    /**
     * Yêu cầu 1b: Đăng nhập nhanh bằng tài khoản Google
     */
    public function test_google_login_flow(): void
    {
        $res = $this->get('/auth/google?email=vip.google@gmail.com&name=VIP+Google+Customer');
        $res->assertRedirect(route('loyalty', ['phone' => urlencode(session('user.phone'))]));

        $this->assertDatabaseHas('khach_hang', [
            'email' => 'vip.google@gmail.com',
        ]);

        $this->assertEquals('vip.google@gmail.com', session('user.email'));
    }

    /**
     * Yêu cầu 2: Cổng bàn trực tư vấn viên phải bảo mật, khách vãng lai không được tự do vào
     */
    public function test_consultant_portal_strictly_guards_against_guests(): void
    {
        // Khách vãng lai truy cập bị chặn và chuyển hướng sang trang đăng nhập
        $guestRes = $this->get('/consultant');
        $guestRes->assertStatus(302);
        $guestRes->assertRedirect(route('dangnhap', ['role' => 'advisor']));

        // Chuyên viên đã đăng nhập được truy cập
        $advisorRes = $this->withSession(['user' => ['role' => 'advisor', 'name' => 'Tư Vấn Viên']])
            ->get('/consultant');
        $advisorRes->assertStatus(200);
    }

    /**
     * Yêu cầu 3: Navbar và Footer giao diện công khai chuẩn VIP, bảo mật và thân thiện
     */
    public function test_navbar_displays_register_and_login_buttons_without_internal_roles_dropdown(): void
    {
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $content = $homeRes->getContent();

        // 1. Phải có 2 nút Đăng Ký và Đăng Nhập cho khách hàng vãng lai
        $this->assertStringContainsString('Đăng Ký', $content);
        $this->assertStringContainsString('Đăng Nhập', $content);
        $this->assertStringContainsString('/register', $content);
        $this->assertStringContainsString('/login', $content);

        // 2. Tuyệt đối không phơi bày dropdown chọn cổng nhân viên/admin trên navbar của khách
        $this->assertStringNotContainsString('Chọn Cổng Đăng Nhập', $content);
        $this->assertStringNotContainsString('Chuyên Viên Tư Vấn', $content);
        $this->assertStringNotContainsString('Quản Trị Admin', $content);

        // 3. Footer đã loại bỏ hoàn toàn khối Liên Kết Nhanh
        $this->assertStringNotContainsString('Liên Kết Nhanh', $content);
        $this->assertStringContainsString('Cam Kết & Đặc Quyền 5 Sao', $content);
        $this->assertStringContainsString('Bảo Hành 36 Tháng', $content);

        // 4. Có cache-busting timestamp chống tình trạng lưu cache cũ ở trình duyệt
        $this->assertMatchesRegularExpression('/trolyao\.js\?v=\d+/', $content);
    }

    public function test_public_pages_do_not_expose_admin_links_in_footer(): void
    {
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $content = $homeRes->getContent();

        // Footer không chứa link admin
        $this->assertStringNotContainsString('href="http://localhost:8000/admin"', $content);
        $this->assertStringNotContainsString('href="/admin"', $content);
        $this->assertStringNotContainsString('href="{{ url(\'/admin\') }}"', $content);
    }

    /**
     * Yêu cầu 4: Nhật ký kiểm toán (Audit Log) không ghi lại hành động của Super Admin
     */
    public function test_superadmin_is_exempted_from_audit_logs(): void
    {
        // 1. Nhân viên bình thường ghi log thành công
        session(['user' => ['role' => 'manager', 'name' => 'Quản Lý Bán Hàng']]);
        $normalLog = AuditLog::create([
            'user_name' => 'Quản Lý Bán Hàng',
            'user_role' => 'manager',
            'action' => 'Duyệt cọc xe',
            'ip_address' => '127.0.0.1',
        ]);
        $this->assertNotNull($normalLog->id);
        $this->assertDatabaseHas('audit_logs', ['action' => 'Duyệt cọc xe']);

        // 2. Super Admin thực hiện thao tác -> Model event tự động chặn (return false)
        session(['user' => ['role' => 'superadmin', 'name' => 'Super Admin']]);
        $superAdminLog = AuditLog::create([
            'user_name' => 'Super Admin',
            'user_role' => 'Super Admin',
            'action' => 'Cấu hình bảo mật hệ thống tối cao',
            'ip_address' => '127.0.0.1',
        ]);

        $this->assertFalse($superAdminLog->exists);
        $this->assertDatabaseMissing('audit_logs', ['action' => 'Cấu hình bảo mật hệ thống tối cao']);
    }

    /**
     * Yêu cầu 5: Khu vực quản lý & chi tiết hóa đơn riêng cho Admin
     */
    public function test_admin_invoices_management_and_detail_view(): void
    {
        $adminSession = ['user' => ['role' => 'admin', 'name' => 'Administrator']];

        // Tạo hóa đơn mẫu để test chi tiết
        HoaDon::create([
            'ma_hd' => 'HD0001',
            'ma_kh' => 'KH001',
            'ngay_lap' => '2026-09-16',
            'tong_tien_goc' => 15990000000,
            'giam_gia_hang' => 479700000,
            'tong_tien_thanh_toan' => 15510300000,
            'phuong_thuc_tt' => 'Chuyển khoản SePay',
            'thoi_gian_bh' => '36 Tháng',
            'trang_thai' => 'Đã thanh toán',
        ]);

        // 1. Danh sách hóa đơn Admin
        $res = $this->withSession($adminSession)->get('/admin/invoices');
        $res->assertStatus(200);
        $res->assertSee('Quản Lý Hóa Đơn Bán Xe');

        // 2. Chi tiết 1 hóa đơn qua JSON API nội bộ Admin
        $detailRes = $this->withSession($adminSession)->get('/admin/invoices/HD0001');
        $detailRes->assertStatus(200);
        $detailRes->assertJson(['success' => true]);
    }

    /**
     * Yêu cầu 6: Bỏ tab thanh toán online duplicate trong tra cứu hóa đơn
     */
    public function test_invoices_page_has_no_duplicate_payment_tab(): void
    {
        $res = $this->get('/invoices');
        $res->assertStatus(200);
        $res->assertSee('Tra Cứu Hóa Đơn Mua Xe');
        $this->assertStringNotContainsString('2. Thanh Toán Online Trả Trước', $res->getContent());
    }

    /**
     * Yêu cầu 7: Chống browser back-button cache sau khi logout
     */
    public function test_logout_clears_session_and_sends_no_cache_headers(): void
    {
        $logoutRes = $this->withSession(['user' => ['role' => 'admin', 'name' => 'Admin']])
            ->get('/logout');

        $logoutRes->assertRedirect(route('home'));
        $cacheControl = (string) $logoutRes->headers->get('Cache-Control');
        $this->assertStringContainsString('no-store', $cacheControl);
        $this->assertStringContainsString('no-cache', $cacheControl);
        $logoutRes->assertHeader('Pragma', 'no-cache');

        $this->assertNull(session('user'));
    }
}
