<?php

use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\KhoaController;
use App\Http\Controllers\LaiThuController;
use App\Http\Controllers\QuanTriController;
use App\Http\Controllers\SepayWebhookController;
use App\Http\Controllers\SoSanhGiaController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\TichDiemController;
use App\Http\Controllers\TradeInController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\TuVanVienController;
use App\Http\Controllers\XeController;
use App\Services\AiConsultantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Hệ Thống Quản Lý Showroom Ô Tô PrimeLux Auto
| Đầy đủ các trang người dùng & quản trị theo chuẩn yêu cầu
|--------------------------------------------------------------------------
*/

// 1. TRANG CHỦ (Home & index.html)
Route::get('/', [TrangChuController::class, 'index'])->name('home');
Route::get('/home', [TrangChuController::class, 'index']);
Route::get('/trangchu', [TrangChuController::class, 'index'])->name('trangchu');
Route::get('/index.html', [TrangChuController::class, 'index']);
Route::get('/Index.html', [TrangChuController::class, 'index']);
Route::get('/Home.html', [TrangChuController::class, 'index']);

// 2. DANH SÁCH XE (Cars & cars.html)
Route::get('/cars', [XeController::class, 'index'])->name('cars.index');
Route::get('/xe', [XeController::class, 'index'])->name('xe.index');
Route::get('/cars.html', [XeController::class, 'index']);
Route::get('/xe.html', [XeController::class, 'index']);

// 3. CHI TIẾT XE (Car Detail & car-detail.html)
Route::get('/cars/{id}', [XeController::class, 'show'])->name('cars.show');
Route::get('/xe/{id}', [XeController::class, 'show'])->name('xe.show');
Route::get('/car-detail.html', [XeController::class, 'show'])->name('cars.detail');
Route::get('/car-detail', [XeController::class, 'show']);
Route::get('/item', [XeController::class, 'show'])->name('cars.item');
Route::get('/Item.html', [XeController::class, 'show']);

// 4. SO SÁNH GIÁ XE ĐA SÀN THỊ TRƯỜNG (PO PRICE COMPARISON)
Route::get('/compare', [SoSanhGiaController::class, 'index'])->name('cars.compare.index');
Route::get('/sosanh', [SoSanhGiaController::class, 'index'])->name('xe.sosanh.index');
Route::get('/cars/{id}/compare', [SoSanhGiaController::class, 'compare'])->name('cars.compare');
Route::get('/xe/{id}/sosanh', [SoSanhGiaController::class, 'compare'])->name('xe.sosanh');
Route::post('/api/cars/{id}/refresh-prices', [SoSanhGiaController::class, 'refresh'])->name('cars.compare.refresh');

// 5. ĐĂNG KÝ LÁI THỬ VIP (Test Drive & test-drive.html)
Route::get('/test-drive', [LaiThuController::class, 'index'])->name('test-drive');
Route::get('/laithu', [LaiThuController::class, 'index'])->name('laithu');
Route::get('/test-drive.html', [LaiThuController::class, 'index']);
Route::post('/test-drive', [LaiThuController::class, 'store'])->name('test-drive.store');
Route::post('/laithu', [LaiThuController::class, 'store'])->name('laithu.store');

// 6. TRA CỨU HÓA ĐƠN & THANH TOÁN (Invoices)
Route::get('/invoices', [HoaDonController::class, 'index'])->name('invoices');
Route::get('/hoadon', [HoaDonController::class, 'index'])->name('hoadon');
Route::get('/invoices.html', [HoaDonController::class, 'index']);

// 7. PRIMELUX CLUB - TÍCH ĐIỂM & ƯU ĐÃI HỘI VIÊN VIP (Loyalty)
Route::get('/loyalty', [TichDiemController::class, 'index'])->name('loyalty');
Route::get('/tichdiem', [TichDiemController::class, 'index'])->name('tichdiem');
Route::get('/loyalty.html', [TichDiemController::class, 'index']);
Route::get('/api/loyalty/check', [TichDiemController::class, 'check'])->name('api.loyalty.check');

// 8. ĐĂNG NHẬP & ĐĂNG XUẤT HỆ THỐNG (Auth)
Route::get('/login', [DangNhapController::class, 'index'])->name('login');
Route::get('/dangnhap', [DangNhapController::class, 'index'])->name('dangnhap');
Route::get('/login.html', [DangNhapController::class, 'index']);
Route::post('/login', [DangNhapController::class, 'login'])->name('login.submit');
Route::post('/dangnhap', [DangNhapController::class, 'login'])->name('dangnhap.submit');
Route::get('/logout', [DangNhapController::class, 'logout'])->name('logout');
Route::get('/dangxuat', [DangNhapController::class, 'logout'])->name('dangxuat');
Route::post('/logout', [DangNhapController::class, 'logout'])->name('logout.post');

// 9. QUẢN TRỊ HỆ THỐNG (Admin Portal & Dashboard & admin/dashboard.html)
Route::get('/admin', [QuanTriController::class, 'index'])->name('admin.dashboard');
Route::get('/quantri', [QuanTriController::class, 'index'])->name('quantri.dashboard');
Route::get('/admin/dashboard', [QuanTriController::class, 'index']);
Route::get('/admin/dashboard.html', [QuanTriController::class, 'index']);
Route::post('/admin/customers/adjust-points', [QuanTriController::class, 'adjustPoints'])->name('admin.customers.adjust-points');

// 10. QUẢN LÝ KHO XE (admin/cars-management.html)
Route::get('/admin/cars-management.html', [QuanTriController::class, 'carsManagement'])->name('admin.cars.management');
Route::get('/admin/cars-management', [QuanTriController::class, 'carsManagement']);
Route::get('/admin/cars', [QuanTriController::class, 'carsManagement']);
Route::post('/admin/cars/store', [QuanTriController::class, 'storeCar'])->name('admin.cars.store');
Route::post('/admin/cars/{id}/update', [QuanTriController::class, 'updateCar'])->name('admin.cars.update');
Route::post('/admin/cars/{id}/delete', [QuanTriController::class, 'deleteCar'])->name('admin.cars.delete');
Route::post('/admin/cars/{id}/status', [QuanTriController::class, 'updateCarStatus'])->name('admin.cars.status');

// 11. QUẢN LÝ LỊCH LÁI THỬ (admin/test-drive-list.html)
Route::get('/admin/test-drive-list.html', [QuanTriController::class, 'testDriveList'])->name('admin.testdrives.list');
Route::get('/admin/test-drive-list', [QuanTriController::class, 'testDriveList']);
Route::get('/admin/test-drives', [QuanTriController::class, 'testDriveList']);
Route::post('/admin/test-drives/{id}/status', [LaiThuController::class, 'updateStatus'])->name('admin.test-drives.status');
Route::post('/admin/test-drives/{id}/delete', [LaiThuController::class, 'destroy'])->name('admin.test-drives.destroy');

// 12. CỔNG CHUYÊN VIÊN TƯ VẤN (Live Advisor & Support Desk)
Route::get('/consultant', [TuVanVienController::class, 'index'])->name('consultant.index');
Route::get('/tuvanvien', [TuVanVienController::class, 'index'])->name('tuvanvien.index');
Route::get('/consultant.html', [TuVanVienController::class, 'index']);
Route::post('/consultant/reply', [TuVanVienController::class, 'reply'])->name('consultant.reply');
Route::post('/consultant/status', [TuVanVienController::class, 'updateStatus'])->name('consultant.status');
Route::post('/api/consultant/submit-question', [TuVanVienController::class, 'submitQuestion'])->name('api.consultant.submit-question');
Route::get('/api/consultant/check-reply', [TuVanVienController::class, 'checkReply'])->name('api.consultant.check-reply');
Route::get('/api/consultant/realtime-feed', [TuVanVienController::class, 'getRealtimeFeed'])->name('api.consultant.realtime-feed');
Route::get('/api/consultant/sse-stream', [TuVanVienController::class, 'sseStream'])->name('api.consultant.sse-stream');

// 13. DỊCH VỤ - BẢO TRÌ, BẢO HIỂM, CỨU HỘ 24/7 (Services)
Route::get('/dich-vu', [DichVuController::class, 'index'])->name('dichvu.index');
Route::get('/dichvu', [DichVuController::class, 'index']);
Route::get('/services', [DichVuController::class, 'index'])->name('services.index');
Route::post('/dich-vu/dat-lich', [DichVuController::class, 'storeBooking'])->name('dichvu.datlich');
Route::post('/dich-vu/cuu-ho-khan-cap', [DichVuController::class, 'storeEmergency'])->name('dichvu.cuuho');
Route::get('/api/dich-vu/tra-cuu', [DichVuController::class, 'traCuu'])->name('api.dichvu.tracuu');
Route::post('/admin/services/update-status/{id}', [DichVuController::class, 'updateStatus'])->name('admin.services.update-status');

// 14. Legacy Routes
Route::get('/danhsachkhoa', function () {
    return view('layouts.app');
});
Route::get('/khoa', [KhoaController::class, 'index']);

// 15. THANH TOÁN ONLINE CHO PHẦN TRẢ TRƯỚC (Down Payment Online Checkout - ID ba_0VXvtCFwZHBJL8Lb7GYukenOW9B)
Route::get('/thanh-toan-tra-truoc', [ThanhToanController::class, 'traTruoc'])->name('thanhtoan.tratruoc');
Route::get('/down-payment', [ThanhToanController::class, 'traTruoc'])->name('downpayment');
Route::get('/tra-truoc', [ThanhToanController::class, 'traTruoc']);
Route::post('/api/payment/create-downpayment', [ThanhToanController::class, 'apiCreateDownPayment'])->name('api.payment.downpayment');
Route::post('/api/payment/check-status', [ThanhToanController::class, 'apiCheckPaymentStatus'])->name('api.payment.check');
Route::post('/api/payment/verify-sepay', [ThanhToanController::class, 'apiVerifySepay'])->name('api.payment.verify-sepay');
Route::get('/api/payment/gateway-info', [ThanhToanController::class, 'apiGetGatewayInfo'])->name('api.payment.gateway');

// 16. QUẢN LÝ THANH TOÁN ADMIN & SEPAY WEBHOOK (Xác Thực Chuyển Khoản Tức Thì)
Route::get('/admin/payments', [QuanTriController::class, 'payments'])->name('admin.payments');
Route::get('/admin/payments.html', [QuanTriController::class, 'payments']);
Route::get('/admin/sepay', [QuanTriController::class, 'payments']);
Route::post('/hooks/sepay-payment', [SepayWebhookController::class, 'handleWebhook'])->name('sepay.webhook');
Route::post('/api/sepay/webhook', [SepayWebhookController::class, 'handleWebhook']);
Route::post('/webhook/sepay', [SepayWebhookController::class, 'handleWebhook']);
Route::post('/admin/payments/simulate-webhook', [SepayWebhookController::class, 'simulateWebhook'])->name('admin.payments.simulate');
Route::get('/admin/payments/latest-notification', [SepayWebhookController::class, 'getLatestVerifiedForAdmin'])->name('admin.payments.latest-notification');
Route::post('/admin/payments/mark-notified', [SepayWebhookController::class, 'markNotified'])->name('admin.payments.mark-notified');
Route::post('/admin/payments/sync-sepay', [SepayWebhookController::class, 'syncFromSepayApi'])->name('admin.payments.sync-sepay');

// 17. THẨM ĐỊNH XE CŨ & THU CŨ ĐỔI MỚI (Trade-In Program - Chức năng 7)
Route::get('/trade-in', [TradeInController::class, 'index'])->name('tradein.index');
Route::get('/thu-cu-doi-moi', [TradeInController::class, 'index'])->name('tradein.vietnamese');
Route::post('/trade-in', [TradeInController::class, 'store'])->name('tradein.store');
Route::post('/api/trade-in/calculate', [TradeInController::class, 'calculateValuation'])->name('api.tradein.calculate');
Route::get('/admin/trade-in', [TradeInController::class, 'adminList'])->name('admin.tradein.index');
Route::post('/admin/trade-in/{id}/update', [TradeInController::class, 'updateStatus'])->name('admin.tradein.update');

// 18. SỔ BẢO HÀNH ĐIỆN TỬ THEO SỐ KHUNG VIN (E-Warranty - Chức năng 6)
Route::get('/api/dich-vu/so-bao-hanh-vin', [DichVuController::class, 'traCuuVin'])->name('api.dichvu.vin-warranty');

// 19. TRỢ LÝ ẢO AI TƯ VẤN 24/7 (LLM RAG - Chức năng 4)
Route::post('/api/ai/ask', function (Request $request) {
    $q = $request->input('question', '');
    $phone = $request->input('phone');
    $name = $request->input('name');
    if (empty($q)) {
        return response()->json(['success' => false, 'message' => 'Vui lòng nhập câu hỏi!'], 400);
    }
    $res = AiConsultantService::ask($q, $phone, $name);

    return response()->json($res);
})->name('api.ai.ask');

// 20. BÁO CÁO BI & XUẤT FILE EXCEL / CSV (Chức năng 8)
Route::get('/admin/export/cars', [QuanTriController::class, 'exportCars'])->name('admin.export.cars');
Route::get('/admin/export/test-drives', [QuanTriController::class, 'exportTestDrives'])->name('admin.export.testdrives');
Route::get('/admin/export/invoices', [QuanTriController::class, 'exportInvoices'])->name('admin.export.invoices');

// 21. NHẬT KÝ KIỂM TOÁN & PHÂN QUYỀN RBAC (Chức năng 9)
Route::get('/admin/audit-logs', [QuanTriController::class, 'auditLogs'])->name('admin.audit.logs');
