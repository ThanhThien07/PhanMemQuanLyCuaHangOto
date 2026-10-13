<?php

use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\DichVuController;
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
