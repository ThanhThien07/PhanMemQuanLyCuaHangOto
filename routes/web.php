<?php

use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\KhoaController;
use App\Http\Controllers\LaiThuController;
use App\Http\Controllers\QuanTriController;
use App\Http\Controllers\SoSanhGiaController;
use App\Http\Controllers\TichDiemController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\TuVanVienController;
use App\Http\Controllers\XeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Hệ Thống Quản Lý Showroom Ô Tô PrimeLux Auto
| Đã chuyển đổi toàn bộ tên Controller & View sang Tiếng Việt
|--------------------------------------------------------------------------
*/

// 1. TRANG CHỦ (Home)
Route::get('/', [TrangChuController::class, 'index'])->name('home');
Route::get('/home', [TrangChuController::class, 'index']);
Route::get('/trangchu', [TrangChuController::class, 'index'])->name('trangchu');
Route::get('/Index.html', [TrangChuController::class, 'index']);
Route::get('/Home.html', [TrangChuController::class, 'index']);

// 2. DANH SÁCH XE & CHI TIẾT XE (Cars)
Route::get('/cars', [XeController::class, 'index'])->name('cars.index');
Route::get('/xe', [XeController::class, 'index'])->name('xe.index');
Route::get('/cars.html', [XeController::class, 'index']);
Route::get('/cars/{id}', [XeController::class, 'show'])->name('cars.show');
Route::get('/xe/{id}', [XeController::class, 'show'])->name('xe.show');
Route::get('/item', [XeController::class, 'show'])->name('cars.item');
Route::get('/Item.html', [XeController::class, 'show']);

// 3. SO SÁNH GIÁ XE ĐA SÀN THỊ TRƯỜNG (PO PRICE COMPARISON)
Route::get('/compare', [SoSanhGiaController::class, 'index'])->name('cars.compare.index');
Route::get('/sosanh', [SoSanhGiaController::class, 'index'])->name('xe.sosanh.index');
Route::get('/cars/{id}/compare', [SoSanhGiaController::class, 'compare'])->name('cars.compare');
Route::get('/xe/{id}/sosanh', [SoSanhGiaController::class, 'compare'])->name('xe.sosanh');
Route::post('/api/cars/{id}/refresh-prices', [SoSanhGiaController::class, 'refresh'])->name('cars.compare.refresh');

// 4. ĐĂNG KÝ LÁI THỬ VIP (Test Drive)
Route::get('/test-drive', [LaiThuController::class, 'index'])->name('test-drive');
Route::get('/laithu', [LaiThuController::class, 'index'])->name('laithu');
Route::get('/test-drive.html', [LaiThuController::class, 'index']);
Route::post('/test-drive', [LaiThuController::class, 'store'])->name('test-drive.store');
Route::post('/laithu', [LaiThuController::class, 'store'])->name('laithu.store');

// 5. TRA CỨU HÓA ĐƠN & THANH TOÁN (Invoices)
Route::get('/invoices', [HoaDonController::class, 'index'])->name('invoices');
Route::get('/hoadon', [HoaDonController::class, 'index'])->name('hoadon');
Route::get('/invoices.html', [HoaDonController::class, 'index']);

// 6. PRIMELUX CLUB - TÍCH ĐIỂM & ƯU ĐÃI HỘI VIÊN VIP (Loyalty)
Route::get('/loyalty', [TichDiemController::class, 'index'])->name('loyalty');
Route::get('/tichdiem', [TichDiemController::class, 'index'])->name('tichdiem');
Route::get('/loyalty.html', [TichDiemController::class, 'index']);
Route::get('/api/loyalty/check', [TichDiemController::class, 'check'])->name('api.loyalty.check');

// 7. ĐĂNG NHẬP & ĐĂNG XUẤT HỆ THỐNG (Auth)
Route::get('/login', [DangNhapController::class, 'index'])->name('login');
Route::get('/dangnhap', [DangNhapController::class, 'index'])->name('dangnhap');
Route::get('/login.html', [DangNhapController::class, 'index']);
Route::post('/login', [DangNhapController::class, 'login'])->name('login.submit');
Route::post('/dangnhap', [DangNhapController::class, 'login'])->name('dangnhap.submit');
Route::get('/logout', [DangNhapController::class, 'logout'])->name('logout');
Route::get('/dangxuat', [DangNhapController::class, 'logout'])->name('dangxuat');
Route::post('/logout', [DangNhapController::class, 'logout'])->name('logout.post');

// 8. QUẢN TRỊ HỆ THỐNG (Admin Portal & Dashboard)
Route::get('/admin', [QuanTriController::class, 'index'])->name('admin.dashboard');
Route::get('/quantri', [QuanTriController::class, 'index'])->name('quantri.dashboard');
Route::get('/admin/dashboard', [QuanTriController::class, 'index']);
Route::get('/admin/dashboard.html', [QuanTriController::class, 'index']);
Route::post('/admin/customers/adjust-points', [QuanTriController::class, 'adjustPoints'])->name('admin.customers.adjust-points');
Route::post('/admin/test-drives/{id}/status', [LaiThuController::class, 'updateStatus'])->name('admin.test-drives.status');

// 9. CỔNG CHUYÊN VIÊN TƯ VẤN (Live Advisor & Support Desk)
Route::get('/consultant', [TuVanVienController::class, 'index'])->name('consultant.index');
Route::get('/tuvanvien', [TuVanVienController::class, 'index'])->name('tuvanvien.index');
Route::get('/consultant.html', [TuVanVienController::class, 'index']);
Route::post('/consultant/reply', [TuVanVienController::class, 'reply'])->name('consultant.reply');
Route::post('/consultant/status', [TuVanVienController::class, 'updateStatus'])->name('consultant.status');
Route::post('/api/consultant/submit-question', [TuVanVienController::class, 'submitQuestion'])->name('api.consultant.submit-question');
Route::get('/api/consultant/check-reply', [TuVanVienController::class, 'checkReply'])->name('api.consultant.check-reply');
Route::get('/api/consultant/realtime-feed', [TuVanVienController::class, 'getRealtimeFeed'])->name('api.consultant.realtime-feed');
Route::get('/api/consultant/sse-stream', [TuVanVienController::class, 'sseStream'])->name('api.consultant.sse-stream');

// 10. Legacy Routes
Route::get('/danhsachkhoa', function () {
    return view('layouts.app');
});
Route::get('/khoa', [KhoaController::class, 'index']);
