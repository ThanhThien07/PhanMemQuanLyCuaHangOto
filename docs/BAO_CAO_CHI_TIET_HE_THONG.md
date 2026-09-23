# BÁO CÁO CHI TIẾT HỆ THỐNG
## PHẦN MỀM QUẢN LÝ CỬA HÀNG ÔTÔ PRIMELUX AUTO
### Phân tích – Thiết kế – Xây dựng – Tài liệu kỹ thuật đầy đủ

---

## MỤC LỤC

1. Tổng quan dự án
2. Kiến trúc hệ thống
3. Công nghệ & Thư viện sử dụng
4. Cấu trúc thư mục dự án
5. Cơ sở dữ liệu
6. Routes - Đường dẫn URL
7. Controllers - Bộ điều khiển
8. Models - Mô hình dữ liệu
9. Views - Giao diện người dùng
10. Chức năng hệ thống chi tiết
11. API Endpoints
12. Phân quyền người dùng
13. Luồng xử lý nghiệp vụ

---

## 1. TỔNG QUAN DỰ ÁN

| Thông tin             | Chi tiết                                        |
|-----------------------|-------------------------------------------------|
| Tên hệ thống          | PrimeLux Auto – Phần mềm Quản lý Cửa hàng Ôtô |
| Loại ứng dụng         | Web Application (MVC)                           |
| Framework             | Laravel 13.x (PHP 8.3+)                         |
| Giao diện             | Blade Template + Tailwind CSS v4 + Vanilla JS   |
| Database              | SQLite (phát triển) / MySQL (production)        |
| Build Tool            | Vite 8.x                                        |
| Ngôn ngữ              | PHP 8.3 / JavaScript ES Modules / CSS           |

### Mục tiêu hệ thống:
- Quản lý kho xe ôtô hạng sang (inventory)
- Quản lý khách hàng VIP và chương trình tích điểm thành viên
- Đặt lịch lái thử xe trực tuyến
- Tra cứu hóa đơn và thanh toán
- So sánh giá xe đa sàn thị trường
- Tư vấn trực tuyến realtime giữa khách hàng và chuyên viên
- Dashboard quản trị toàn hệ thống

---

## 2. KIẾN TRÚC HỆ THỐNG (MVC)

Hệ thống sử dụng mô hình MVC (Model-View-Controller):
- Model: Đại diện cho dữ liệu và logic nghiệp vụ, tương tác trực tiếp với database thông qua Eloquent ORM
- View: Giao diện người dùng, sử dụng Blade Template Engine của Laravel
- Controller: Xử lý request từ người dùng, gọi Model lấy dữ liệu, trả về View

Phân hệ người dùng:
- Admin Portal (/admin, /quantri)
- Advisor Desk (/consultant, /tuvanvien)
- Customer Portal (/loyalty, /test-drive, /cars...)

---

## 3. CÔNG NGHỆ & THƯ VIỆN SỬ DỤNG

### Backend:
- PHP ^8.3 – Ngôn ngữ lập trình server-side chính
- Laravel Framework ^13.17 – PHP Framework MVC
- Laravel Tinker ^3.0 – REPL tương tác với Eloquent ORM
- Faker PHP ^1.23 – Tạo dữ liệu giả cho seeding/testing
- Laravel Pail ^1.2.5 – Xem log realtime trong terminal
- Laravel Pint ^1.27 – PHP Code Style Fixer
- PHPUnit ^12.5.12 – Framework unit testing

### Frontend:
- Vite ^8.0.0 – Build tool / Dev server tốc độ cao
- Tailwind CSS ^4.0.0 – Utility-first CSS Framework
- @tailwindcss/vite ^4.0.0 – Plugin tích hợp Tailwind với Vite
- laravel-vite-plugin ^3.1 – Plugin tích hợp Vite với Laravel
- @laravel/multiplex ^0.4.1 – WebSocket multiplexing (realtime)
- concurrently ^10.0.3 – Chạy nhiều lệnh song song khi dev

### Database:
- SQLite – Database mặc định khi phát triển (database/database.sqlite)
- MySQL – Database production (cấu hình trong .env)
- Eloquent ORM – Object-Relational Mapping của Laravel

### Công cụ phát triển:
- Laragon – Môi trường phát triển local (PHP + MySQL + Nginx)
- Composer – Quản lý package PHP
- NPM – Quản lý package Node.js
- Artisan CLI – Command-line tool của Laravel

---

## 4. CẤU TRÚC THƯ MỤC DỰ ÁN

PhanMemQuanLyCuaHangOto/
|-- app/
|   |-- Http/
|   |   |-- Controllers/       (20 Controllers)
|   |       |-- AdminController.php         # Dashboard quản trị
|   |       |-- AuthController.php          # Xác thực (tiếng Anh)
|   |       |-- CarComparisonController.php # So sánh xe
|   |       |-- CarController.php           # Quản lý xe
|   |       |-- ConsultantController.php    # Tư vấn & chatbot
|   |       |-- Controller.php              # Base Controller
|   |       |-- DangNhapController.php      # Đăng nhập/xuất
|   |       |-- HoaDonController.php        # Hóa đơn (alias)
|   |       |-- HomeController.php          # Trang chủ
|   |       |-- InvoiceController.php       # Hóa đơn
|   |       |-- KhoaController.php          # Legacy
|   |       |-- LaiThuController.php        # Đặt lịch lái thử
|   |       |-- LoyaltyController.php       # Loyalty
|   |       |-- QuanTriController.php       # Quản trị (TV)
|   |       |-- SoSanhGiaController.php     # So sánh giá xe
|   |       |-- TestDriveController.php     # Lái thử
|   |       |-- TichDiemController.php      # Tích điểm
|   |       |-- TrangChuController.php      # Trang chủ
|   |       |-- TuVanVienController.php     # Tư vấn viên
|   |       |-- XeController.php            # Danh sách xe
|   |-- Models/                (27 Models Eloquent)
|   |-- Providers/
|-- database/
|   |-- migrations/            (5 migration files)
|   |-- seeders/
|   |-- factories/
|   |-- database.sqlite        # SQLite database file
|   |-- qly_cuahangoto.sql     # MySQL schema export
|-- resources/
|   |-- css/app.css            # CSS chính + Tailwind
|   |-- js/app.js              # JavaScript chính
|   |-- views/                 # Blade Templates
|       |-- admin/             # Admin dashboard
|       |-- consultant/        # Tư vấn viên
|       |-- dangnhap/          # Đăng nhập
|       |-- layouts/           # Layout chính
|       |-- loyalty/           # Loyalty
|       |-- quantri/           # Quản trị
|       |-- tichdiem/          # Tích điểm
|       |-- tuvanvien/         # Tư vấn viên (TV)
|       |-- xe/                # Xe + so sánh giá
|       |-- welcome.blade.php  # Landing page
|       |-- laithu.blade.php   # Đặt lịch lái thử
|       |-- hoadon.blade.php   # Hóa đơn
|-- routes/
|   |-- web.php                # 37 URL routes
|   |-- console.php
|-- docs/                      # Tài liệu dự án
|-- composer.json              # PHP dependencies
|-- package.json               # Node.js dependencies
|-- vite.config.js             # Cấu hình Vite
|-- .env                       # Cấu hình môi trường

---

## 5. CƠ SỞ DỮ LIỆU – 10 BẢNG CHÍNH

### Bảng 1: thuong_hieu (Thương hiệu xe)
- id, ma_th (UNIQUE), ten_th, xuat_xu, badge, mo_ta, timestamps

### Bảng 2: loai_xe (Kiểu dáng xe)
- id, ma_loai (UNIQUE), ten_loai, mo_ta, timestamps

### Bảng 3: hang_thanh_vien (Hạng thành viên Loyalty)
- id, ma_hang: SILVER/GOLD/PLATINUM/DIAMOND
- ten_hang, diem_toi_thieu (0/1000/5000/10000)
- ti_le_chiet_khau (0%/1%/2%/3%)
- dac_quyen, mau_badge

### Bảng 4: khach_hang (Khách hàng)
- id, ma_kh, ho_ten, sdt (UNIQUE), email, dia_chi, ngay_sinh
- mat_khau, diem_tich_luy, tong_chi_tieu, ma_hang (FK)

### Bảng 5: xe (Kho xe)
- id, ma_xe, ten_xe, ma_th (FK), ma_loai (FK)
- gia_niem_yet, gia_chu, nhien_lieu, cong_suat, so_cho
- nam_sx, nhan_tag, tag_class, hinh_anh, mo_ta
- so_luong_kho, trang_thai

### Bảng 6: hoa_don (Hóa đơn bán xe)
- id, ma_hd, ma_kh (FK), ngay_lap
- tong_tien_goc, giam_gia_hang, tong_tien_thanh_toan
- diem_thuong_nhan, phuong_thuc_tt, thoi_gian_bh, trang_thai

### Bảng 7: ct_hoa_don (Chi tiết hóa đơn)
- id, ma_hd (FK), ma_xe (FK)
- so_luong, don_gia, thanh_tien

### Bảng 8: dang_ky_lai_thu (Lịch lái thử xe)
- id, ma_lich (TD-XXXXX), ho_ten, sdt, email
- ten_xe, showroom, thoi_gian, ghi_chu
- trang_thai: Đang chờ duyệt/Đã xác nhận/Đã hoàn thành/Đã hủy

### Bảng 9: lich_su_diem (Lịch sử tích/tiêu điểm)
- id, ma_kh (FK), ma_hd (FK nullable)
- so_diem (+/- điểm), hanh_dong, ngay_tao

### Bảng 10: chat_logs (Nhật ký tư vấn chatbot)
- id, ma_tin (MSG-XXXXX), thoi_gian, nguoi_gui
- sdt_khach, noi_dung, phan_hoi_bot
- tra_loi_tu_van, ten_tu_van, thoi_gian_tra_loi
- trang_thai: Chờ phản hồi/Đang tư vấn/Đã trả lời
- loai_cau_hoi

---

## 6. ROUTES – 37 ĐƯỜNG DẪN URL (routes/web.php)

01. GET  /                              → TrangChuController@index       (home)
02. GET  /home                          → TrangChuController@index
03. GET  /trangchu                      → TrangChuController@index       (trangchu)
04. GET  /cars                          → XeController@index             (cars.index)
05. GET  /xe                            → XeController@index             (xe.index)
06. GET  /cars/{id}                     → XeController@show              (cars.show)
07. GET  /xe/{id}                       → XeController@show              (xe.show)
08. GET  /compare                       → SoSanhGiaController@index      (cars.compare.index)
09. GET  /sosanh                        → SoSanhGiaController@index      (xe.sosanh.index)
10. GET  /cars/{id}/compare             → SoSanhGiaController@compare    (cars.compare)
11. GET  /xe/{id}/sosanh                → SoSanhGiaController@compare    (xe.sosanh)
12. POST /api/cars/{id}/refresh-prices  → SoSanhGiaController@refresh    (cars.compare.refresh)
13. GET  /test-drive                    → LaiThuController@index         (test-drive)
14. GET  /laithu                        → LaiThuController@index         (laithu)
15. POST /test-drive                    → LaiThuController@store         (test-drive.store)
16. POST /laithu                        → LaiThuController@store         (laithu.store)
17. GET  /invoices                      → HoaDonController@index         (invoices)
18. GET  /hoadon                        → HoaDonController@index         (hoadon)
19. GET  /loyalty                       → TichDiemController@index       (loyalty)
20. GET  /tichdiem                      → TichDiemController@index       (tichdiem)
21. GET  /api/loyalty/check             → TichDiemController@check       (api.loyalty.check)
22. GET  /login                         → DangNhapController@index       (login)
23. GET  /dangnhap                      → DangNhapController@index       (dangnhap)
24. POST /login                         → DangNhapController@login       (login.submit)
25. POST /dangnhap                      → DangNhapController@login       (dangnhap.submit)
26. GET  /logout                        → DangNhapController@logout      (logout)
27. GET  /admin                         → QuanTriController@index        (admin.dashboard)
28. GET  /quantri                       → QuanTriController@index        (quantri.dashboard)
29. POST /admin/customers/adjust-points → QuanTriController@adjustPoints (admin.customers.adjust-points)
30. GET  /consultant                    → TuVanVienController@index      (consultant.index)
31. GET  /tuvanvien                     → TuVanVienController@index      (tuvanvien.index)
32. POST /consultant/reply              → TuVanVienController@reply      (consultant.reply)
33. POST /consultant/status             → TuVanVienController@updateStatus (consultant.status)
34. POST /api/consultant/submit-question → ConsultantController@submitQuestion
35. GET  /api/consultant/check-reply    → ConsultantController@checkReply
36. GET  /api/consultant/realtime-feed  → ConsultantController@getRealtimeFeed
37. GET  /api/consultant/sse-stream     → ConsultantController@sseStream

---

## 7. CONTROLLERS – 20 BỘ ĐIỀU KHIỂN

### TrangChuController.php
- index(): Hiển thị landing page / trang chủ PrimeLux Auto

### XeController.php
- index(): Danh sách xe, lọc theo brand/type
- show(): Chi tiết 1 xe theo ID

### SoSanhGiaController.php
- index(): Trang so sánh giá (car_id từ query)
- compare(): So sánh giá xe với các sàn thị trường
- refresh(): API làm mới giá (cập nhật fetched_at)

### LaiThuController.php
- index(): Form đăng ký lái thử + danh sách xe
- store(): Validate + lưu đăng ký vào DB (mã TD-xxxxx)
  Validation: ho_ten, sdt, email(nullable), ten_xe, showroom, thoi_gian, ghi_chu

### HoaDonController.php
- index(): Tra cứu hóa đơn theo mã KH / SĐT

### TichDiemController.php (== LoyaltyController.php)
- index(): Tìm KH theo SĐT/email/mã KH, xem điểm + lịch sử + progress
- check(): API tra cứu nhanh điểm theo SĐT → JSON

### DangNhapController.php
- index(): Form đăng nhập (3 tab role)
- login(): Xử lý đăng nhập: admin→/admin, advisor→/consultant, customer→/loyalty
- logout(): Xóa session, redirect /

### QuanTriController.php (== AdminController.php)
- index(): Dashboard tổng hợp: xe, KH, HĐ, lái thử, chat, stats
- adjustPoints(): Điều chỉnh điểm KH + tự động thăng hạng + ghi lịch sử

### ConsultantController.php (== TuVanVienController.php)
- index(): Dashboard tư vấn viên + filter + canned replies
- reply(): Chuyên viên gửi câu trả lời
- updateStatus(): Cập nhật trạng thái chat
- submitQuestion(): Khách gửi câu hỏi qua chatbox
- getRealtimeFeed(): JSON feed toàn bộ câu hỏi + stats
- sseStream(): SSE realtime stream
- checkReply(): Khách kiểm tra câu trả lời theo ma_tin

---

## 8. MODELS – 27 MÔ HÌNH DỮ LIỆU

Car.php (table: xe)
- formatCar(): Chuẩn hóa object DB → array
- getAllCars(): Lấy từ DB, fallback getDefaultCars()
- getDefaultCars(): 6 xe mẫu hardcode

Xe mẫu (dữ liệu fallback):
1. Mercedes-Maybach S 680 4MATIC  - 15,990,000,000 VNĐ
2. Porsche Taycan Turbo S          - 9,550,000,000 VNĐ
3. BMW 740i Pure Excellence        - 6,299,000,000 VNĐ
4. Audi e-tron GT Quattro          - 5,200,000,000 VNĐ
5. Range Rover Autobiography LWB   - 11,699,000,000 VNĐ
6. Lexus LX 600 VIP 4 Cho          - 9,610,000,000 VNĐ

KhachHang.php / Customer.php – Khách hàng + belongsTo(HangThanhVien)
HangThanhVien.php / LoyaltyTier.php – Hạng thành viên + hasMany(KhachHang)
HoaDon.php / Invoice.php – Hóa đơn + relations
LaiThu.php / TestDrive.php – Lịch lái thử
NhatKyChat.php / ChatLog.php – Nhật ký chat + advisor fields
LichSuDiem.php / PointsHistory.php – Lịch sử điểm
SoSanhGiaXe.php – Giá thị trường

---

## 9. CHỨC NĂNG HỆ THỐNG (10 CHỨC NĂNG CHÍNH)

### 1. Quản lý Kho Xe
- Xem danh sách, lọc brand/type
- Xem chi tiết xe, thông số kỹ thuật, giá
- Fallback data khi DB rỗng
- Tag: HOT / Mới Về / Ưu Đãi

### 2. So Sánh Giá Đa Sàn
- Lấy giá từ so_sanh_gia_xe theo car_id
- Tính min/max/avg thị trường
- So sánh với giá PrimeLux
- Làm mới giá qua API

### 3. Đặt Lịch Lái Thử VIP
- Form trực tuyến, validation server-side
- Mã tự động: TD-xxxxx
- Trạng thái ban đầu: "Đang chờ duyệt"

### 4. Tra Cứu Hóa Đơn
- Tìm theo mã KH / SĐT
- Xem chi tiết xe đã mua, điểm thưởng

### 5. PrimeLux Club – Tích Điểm
- 4 hạng: Silver(0đ)→Gold(1000đ)→Platinum(5000đ)→Diamond(10000đ)
- Chiết khấu: 0%→1%→2%→3%
- Tra cứu điểm, lịch sử, progress bar

### 6. Tư Vấn Realtime
- Khách gửi câu hỏi → MSG-xxxxx
- Chuyên viên trả lời → cập nhật ChatLog
- Khách poll kiểm tra trả lời
- SSE Stream cho tư vấn viên

### 7. Dashboard Quản Trị
- Thống kê: xe/KH/HĐ/lái thử/chat/điểm
- Điều chỉnh điểm + tự động thăng hạng

### 8. Đăng Nhập 3 Vai Trò
- admin → /admin, advisor → /consultant, customer → /loyalty
- Session-based, avatar từ ui-avatars.com

### 9. Canned Replies (5 mẫu)
- Báo giá & giao xe
- Lái thử tận nơi
- Vay trả góp 80%
- Bảo hành VIP
- Thu cũ đổi mới

### 10. Server-Sent Events (SSE)
- /api/consultant/sse-stream
- Headers: text/event-stream, no-cache, keep-alive
- Auto-push data cho tư vấn viên

---

## 10. API ENDPOINTS (7 ENDPOINTS)

GET  /api/loyalty/check?phone={sdt}
     → JSON: {success, customer: {name, code, points, tier_name, discount_percent, badge}}

POST /api/consultant/submit-question
     Body: noi_dung, sdt_khach, nguoi_gui, loai_cau_hoi, phan_hoi_bot
     → JSON: {success, ma_tin, thoi_gian}

GET  /api/consultant/check-reply?ma_tin={code}
     → JSON: {success, has_reply, reply, advisor_name, status, reply_time}

GET  /api/consultant/realtime-feed
     → JSON: {success, timestamp, inquiries[], stats: {total, pending, in_progress, resolved}}

GET  /api/consultant/sse-stream
     → text/event-stream (SSE push)

POST /api/cars/{id}/refresh-prices
     → JSON: {success, message, synced_at}

POST /admin/customers/adjust-points
     Body: ma_kh, so_diem, ly_do
     → JSON: {success, message, new_points, new_tier}

---

## 11. PHÂN QUYỀN

ADMIN (/admin, /quantri):
- Xem tất cả xe, KH, HĐ, lịch lái thử, chat logs
- Điều chỉnh điểm KH, thống kê toàn hệ thống

ADVISOR (/consultant, /tuvanvien):
- Xem câu hỏi chat, trả lời, cập nhật trạng thái
- Xem thông tin VIP của khách

CUSTOMER:
- Xem xe, đặt lịch lái thử, tra cứu điểm, hóa đơn cá nhân
- Gửi câu hỏi qua chatbox

---

## 12. LUỒNG NGHIỆP VỤ

### Luồng Mua Xe:
Khách xem xe → Chi tiết → Chatbox hỏi tư vấn → Advisor trả lời
→ Đặt cọc → Admin tạo HĐ → Cộng điểm → Cập nhật hạng

### Luồng Tích Điểm:
Mua xe → +điểm vào khach_hang → Ghi lich_su_diem
→ Kiểm tra hang_thanh_vien → Thăng hạng nếu đủ điểm

### Luồng Tư Vấn:
Khách POST submit-question → ChatLog (Chờ phản hồi)
→ Advisor reply → ChatLog.tra_loi_tu_van (Đã trả lời)
→ Khách GET check-reply → Nhận câu trả lời

---
Báo cáo tạo ngày: 23/09/2026
Hệ thống: PrimeLux Auto – Phần mềm Quản lý Cửa hàng Ôtô
