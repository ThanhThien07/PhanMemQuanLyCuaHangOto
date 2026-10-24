# DANH SÁCH FILES & ĐƯỜNG DẪN TOÀN BỘ HỆ THỐNG
# PrimeLux Auto – Phần Mềm Quản Lý Showroom Ô Tô Cao Cấp
# Cập nhật chuẩn hóa: Tháng 10/2026
# ============================================================

## 1. ROOT FILES (Thư Mục Gốc)

| File / Thư mục        | Kích thước | Mô tả / Tác dụng                                                              |
|-----------------------|------------|-------------------------------------------------------------------------------|
| `artisan`             | 425 B      | Laravel CLI entry point – chạy lệnh artisan                                   |
| `composer.json`       | 2.7 KB     | Khai báo cấu hình PHP dependencies & PSR-4 autoload                           |
| `composer.lock`       | 325 KB     | Khóa phiên bản cụ thể của toàn bộ thư viện PHP vendor                         |
| `package.json`        | 524 B      | Khai báo Node.js dependencies (Vite, Axios, Tailwind...)                      |
| `package-lock.json`   | 94 KB      | Khóa phiên bản chi tiết các package Node.js                                   |
| `vite.config.js`      | 632 B      | File cấu hình Vite build tool cho CSS & JavaScript                            |
| `.env`                | 1.3 KB     | Biến môi trường hoạt động (DB MySQL/SQLite, App Key, URL, Mail, Session...)  |
| `.env.example`        | 1.1 KB     | Mẫu cấu hình môi trường cho nhà phát triển mới                                |
| `.gitignore`          | 341 B      | Danh sách file / thư mục bỏ qua khi commit Git                                |
| `.editorconfig`       | 275 B      | Cấu hình quy chuẩn soạn thảo code cho IDE                                     |
| `.npmrc`              | 31 B       | Cấu hình NPM registry & package flags                                         |
| `.gitattributes`      | 186 B      | Cấu hình định dạng dòng lệnh Git (LF / CRLF)                                  |
| `phpunit.xml`         | 1.3 KB     | Cấu hình môi trường thực thi bộ kiểm thử tự động PHPUnit                     |
| `AGENTS.md`           | 9.2 KB     | Quy chuẩn phát triển Laravel Boost dành cho AI & Developer                    |
| `CLAUDE.md`           | 1.4 KB     | Hướng dẫn thiết lập môi trường và quy tắc coding                              |
| `README.md`           | 3.7 KB     | Tài liệu tổng quan giới thiệu dự án PrimeLux Auto                             |
| `PROGRESS_CHECKPOINT.md` | 24 KB   | Báo cáo vết tiến độ chi tiết qua từng giai đoạn phát triển                    |
| `qly_cuahangoto.sql`  | 82 KB      | Bản sao lưu CSDL MySQL gốc phục vụ import nhanh                               |
| `Dockerfile`          | 1.7 KB     | Cấu hình containerization Docker triển khai hệ thống                          |
| `docker-entrypoint.sh`| 596 B      | Script khởi động container tự động chạy migrate và PHP-FPM                     |
| `render.yaml`         | 925 B      | Cấu hình blueprint triển khai đám mây (PaaS Render/Cloud)                     |

---

## 2. ROUTES (routes/)

| File                 | Số dòng | Mô tả chức năng                                                              |
|----------------------|---------|------------------------------------------------------------------------------|
| `routes/web.php`     | 225     | 122 URL endpoints: Phục vụ Web MVC, API nội bộ, SSE Realtime, Webhook SePay |
| `routes/console.php` | 10      | Khai báo tác vụ dòng lệnh artisan console định kỳ                           |

---

## 3. CONTROLLERS (app/Http/Controllers/)

### A. Controllers Nghiệp Vụ Chính (Core Controllers)
| File                          | Dung lượng | Vai trò nghiệp vụ                                                            |
|-------------------------------|------------|------------------------------------------------------------------------------|
| `Controller.php`              | 0.1 KB     | Base Controller kế thừa bởi mọi Controller trong hệ thống                    |
| `TrangChuController.php`      | 0.3 KB     | Điều khiển Trang chủ: tải 6 siêu xe tiêu biểu, sự kiện HOT & Banner VIP      |
| `XeController.php`            | 2.2 KB     | Danh mục xe, bộ lọc đa tiêu chí, chi tiết xe chuẩn SEO & API nạp dữ liệu    |
| `SoSanhGiaController.php`     | 6.5 KB     | So sánh giá xe 4 sàn ngoài (Oto, Bonbanh, Carmudi, Chợ Tốt) & Biểu đồ Chart |
| `LaiThuController.php`        | 5.4 KB     | Đặt lịch lái thử VIP, thông báo tự động Zalo ZNS/SMS & duyệt lịch            |
| `HoaDonController.php`        | 3.6 KB     | Tra cứu hóa đơn điện tử cho khách hàng và xem chi tiết thanh toán            |
| `TichDiemController.php`      | 3.0 KB     | PrimeLux Club: Tra cứu điểm thưởng, tiến độ thăng hạng VIP & API check       |
| `DangNhapController.php`      | 11.5 KB    | Xác thực đa vai trò, Đăng ký thành viên, Google OAuth 2.0 & bảo mật Cache    |
| `QuanTriController.php`       | 28.5 KB    | Quản trị Admin: KPI Dashboard, Kho xe, Hóa đơn email, Báo cáo BI, Audit Log  |
| `ConsultantController.php`    | 16.5 KB    | Bàn trực tư vấn: Luồng SSE realtime, hàng đợi tin nhắn khách, gửi câu trả lời|
| `DichVuController.php`        | 10.8 KB    | Đặt lịch bảo dưỡng định kỳ, cứu hộ khẩn cấp 24/7 & Tra cứu bảo hành VIN      |
| `ThanhToanController.php`     | 18.6 KB    | Cổng thanh toán trực tuyến tiền trả trước (VietQR / MBBank) & tạo hóa đơn    |
| `SepayWebhookController.php`  | 16.7 KB    | Webhook ngân hàng SePay: xác thực giao dịch, khớp hóa đơn, gửi email tự động |
| `TradeInController.php`       | 7.3 KB     | Chương trình Thu cũ đổi mới: định giá xe cũ tự động và tiếp nhận hồ sơ       |

### B. Controllers Tương Thích & Alias (Clean Inheritance Proxies)
| File                          | Dung lượng | Kế thừa từ class chính | Tác dụng                                             |
|-------------------------------|------------|------------------------|------------------------------------------------------|
| `HomeController.php`          | 0.2 KB     | `TrangChuController`   | Alias tiếng Anh tương thích chuẩn route `/home`      |
| `CarController.php`           | 0.2 KB     | `XeController`         | Alias tiếng Anh tương thích chuẩn route `/cars`      |
| `CarComparisonController.php` | 0.2 KB     | `SoSanhGiaController`  | Alias tiếng Anh tương thích chuẩn route `/compare`   |
| `TestDriveController.php`     | 0.2 KB     | `LaiThuController`     | Alias tiếng Anh tương thích chuẩn route `/test-drive`|
| `InvoiceController.php`       | 0.2 KB     | `HoaDonController`     | Alias tiếng Anh tương thích chuẩn route `/invoices`  |
| `LoyaltyController.php`       | 0.2 KB     | `TichDiemController`   | Alias tiếng Anh tương thích chuẩn route `/loyalty`   |
| `AuthController.php`          | 0.2 KB     | `DangNhapController`   | Alias tiếng Anh tương thích xác thực tài khoản       |
| `AdminController.php`         | 0.2 KB     | `QuanTriController`    | Alias tiếng Anh tương thích trang quản trị admin     |
| `TuVanVienController.php`     | 0.2 KB     | `ConsultantController` | Wrapper tiếng Việt tương thích route `/tuvanvien`    |

---

## 4. MIDDLEWARE (app/Http/Middleware/)

| File                 | Vai trò bảo mật                                                              |
|----------------------|------------------------------------------------------------------------------|
| `AdminAuth.php`      | Chặn khách vãng lai, chỉ cho phép role `admin` vào phân hệ Quản trị Admin    |
| `AdvisorAuth.php`    | Chặn khách vãng lai, chỉ cho phép role `advisor` và `admin` vào Bàn Tư Vấn   |

---

## 5. SERVICES, MAILS & COMMANDS

| File / Thư mục                                 | Mô tả chức năng                                                              |
|------------------------------------------------|------------------------------------------------------------------------------|
| `app/Services/AiConsultantService.php`         | Trợ lý AI 24/7 tự động phân tích câu hỏi xe, giá bán, gói vay & trả lời     |
| `app/Services/NotificationService.php`         | Dịch vụ gửi thông báo tự động đa kênh qua Zalo ZNS và tin nhắn SMS Brandname |
| `app/Mail/HoaDonXacNhanMail.php`               | Mailable tạo và gửi email hóa đơn xe điện tử kèm tem bảo hành 36 tháng       |
| `app/Console/Commands/ScrapeMarketPricesCommand.php` | Lệnh quét dữ liệu giá thị trường từ các sàn ô tô ngoài theo chu kỳ cronjob |

---

## 6. MODELS (app/Models/)

### A. Models Bảng Cơ Sở Dữ Liệu Chính
| Model File            | Bảng CSDL             | Chức năng chính                                                              |
|-----------------------|-----------------------|------------------------------------------------------------------------------|
| `User.php`            | `users`               | Tài khoản người dùng hệ thống                                                |
| `Car.php`             | `xe`                  | Quản lý kho xe: formatCar, getAllCars, lọc thương hiệu & kiểu dáng          |
| `Brand.php`           | `thuong_hieu`         | Thương hiệu xe sang (Mercedes, Porsche, BMW, Audi, Lexus, Land Rover)        |
| `CarType.php`         | `loai_xe`             | Phân loại xe: Sedan, SUV, Xe điện EV                                         |
| `CarPriceSource.php`  | `car_price_sources`   | Dữ liệu giá thị trường thu thập từ Oto.com.vn, Bonbanh, Carmudi, Chợ Tốt Xe  |
| `Customer.php`        | `khach_hang`          | Hồ sơ khách hàng, chi tiêu tích lũy và liên kết hạng VIP                     |
| `LoyaltyTier.php`     | `hang_thanh_vien`     | 4 hạng hội viên PrimeLux Club: Bạc, Vàng, Bạch Kim, Kim Cương               |
| `PointsHistory.php`   | `lich_su_diem`        | Nhật ký biến động điểm thưởng (+/-) và lý do cộng trừ điểm                   |
| `Invoice.php`         | `hoa_don`             | Hóa đơn bán xe: mã HĐ, khách hàng, phương thức thanh toán, chiết khấu VIP   |
| `InvoiceDetail.php`   | `ct_hoa_don`          | Dòng chi tiết xe trong từng hóa đơn bán                                      |
| `TestDrive.php`       | `dang_ky_lai_thu`     | Lịch hẹn lái thử: người đặt, xe chọn, showroom, thời gian, trạng thái duyệt  |
| `ChatLog.php`         | `chat_logs`           | Lịch sử tin nhắn tư vấn trực tuyến giữa khách hàng và chuyên viên            |
| `DatLichDichVu.php`   | `dat_lich_dich_vu`    | Lịch đặt dịch vụ bảo dưỡng, sửa chữa và cứu hộ xe khẩn cấp                   |
| `DichVu.php`          | `dich_vu`             | Danh mục các gói dịch vụ showroom cung cấp                                   |
| `SoBaoHanhVin.php`    | `so_bao_hanh_vin`     | Sổ bảo hành điện tử chính hãng gắn theo số khung VIN độc nhất của từng xe     |
| `LichSuBaoDuongVin.php`| `lich_su_bao_duong_vin`| Nhật ký chi tiết từng mốc km bảo dưỡng định kỳ theo số khung VIN            |
| `SepayTransaction.php`| `sepay_transactions`  | Giao dịch ngân hàng nhận từ Webhook SePay (số tiền, nội dung CK, trạng thái) |
| `AuditLog.php`        | `audit_logs`          | Nhật ký kiểm toán hành động hệ thống (miễn trừ Super Admin)                  |
| `ThongBaoDaKenh.php`  | `thong_bao_da_kenh`   | Lịch sử gửi thông báo đa kênh Zalo ZNS / SMS                                 |
| `YeuCauThuDoiXe.php`  | `yeu_cau_thu_doi_xe`  | Hồ sơ thẩm định thu cũ đổi mới (Trade-In)                                    |

### B. Models Tiếng Việt Kế Thừa (Vietnamese Proxy Models)
| Model File            | Model kế thừa         | Bảng CSDL             |
|-----------------------|-----------------------|-----------------------|
| `Xe.php`              | `Car`                 | `xe`                  |
| `ThuongHieu.php`      | `Brand`               | `thuong_hieu`         |
| `LoaiXe.php`          | `CarType`             | `loai_xe`             |
| `SoSanhGiaXe.php`     | `CarPriceSource`      | `car_price_sources`   |
| `KhachHang.php`       | `Customer`            | `khach_hang`          |
| `HangThanhVien.php`   | `LoyaltyTier`         | `hang_thanh_vien`     |
| `LichSuDiem.php`      | `PointsHistory`       | `lich_su_diem`        |
| `HoaDon.php`          | `Invoice`             | `hoa_don`             |
| `ChiTietHoaDon.php`   | `InvoiceDetail`       | `ct_hoa_don`          |
| `LaiThu.php`          | `TestDrive`           | `dang_ky_lai_thu`     |
| `NhatKyChat.php`      | `ChatLog`             | `chat_logs`           |

---

## 7. MIGRATIONS & DATABASE (database/)

### A. Migrations (database/migrations/)
| Migration File                                                | Mô tả bảng tạo                                               |
|---------------------------------------------------------------|--------------------------------------------------------------|
| `0001_01_01_000000_create_users_table.php`                    | Bảng `users`, `password_reset_tokens`, `sessions`            |
| `0001_01_01_000001_create_cache_table.php`                    | Bảng cache hệ thống `cache`, `cache_locks`                   |
| `0001_01_01_000002_create_jobs_table.php`                     | Bảng hàng đợi `jobs`, `job_batches`, `failed_jobs`            |
| `2026_09_23_000001_create_dealership_tables.php`              | 10 bảng cốt lõi showroom xe (xe, khách, hóa đơn, lái thử...) |
| `2026_09_23_000002_add_advisor_fields_to_chat_logs_table.php` | Bổ sung các trường phản hồi chuyên viên vào `chat_logs`      |
| `2026_09_23_000003_create_car_price_sources_table.php`        | Bảng quét giá thị trường `car_price_sources`                 |
| `2026_09_30_000001_create_services_tables.php`                | Bảng dịch vụ bảo trì và đặt lịch hẹn `dat_lich_dich_vu`      |
| `2026_10_13_130220_create_sepay_transactions_table.php`       | Bảng ghi nhận webhook chuyển khoản ngân hàng SePay           |
| `2026_10_13_131744_add_is_notified_admin_to_sepay_transactions_table.php` | Đánh dấu trạng thái thông báo Admin              |
| `2026_10_13_153733_create_extended_roadmap_tables.php`        | Bảng Sổ bảo hành VIN, Trade-In, Cứu hộ, Audit Log, Zalo ZNS  |
| `2026_10_19_160000_add_session_id_to_chat_logs_table.php`     | Bổ sung session ID phục vụ theo dõi luồng chat realtime      |

### B. Seeders (database/seeders/)
| Seeder File                   | Mô tả                                                                        |
|-------------------------------|------------------------------------------------------------------------------|
| `DatabaseSeeder.php`          | Seeder tổng: nạp 6 thương hiệu, 3 loại xe, 4 hạng VIP, 6 xe sang và gọi con  |
| `CarPriceSourceSeeder.php`    | Nạp 18 nguồn giá thị trường đối chiếu thực tế từ các sàn ô tô Việt Nam       |
| `ServiceSeeder.php`           | Nạp danh mục gói bảo dưỡng, bảo hiểm thân vỏ và cứu hộ xe                     |
| `RoadmapDataSeeder.php`       | Nạp sổ bảo hành điện tử VIN mẫu, lịch bảo dưỡng, hồ sơ Trade-In & Audit Log |
| `RevenueSeeder.php`           | Seeder doanh thu trống sạch phục vụ thao tác demo thanh toán thực tế          |

---

## 8. VIEWS (resources/views/)

### A. Giao Diện Người Dùng & Khách Hàng (Customer Front-End)
| View Path                     | Mô tả giao diện                                                              |
|-------------------------------|------------------------------------------------------------------------------|
| `trangchu.blade.php`          | Landing page Showroom PrimeLux: Hero siêu xe, xe mới về, ưu đãi, tin tức     |
| `home.blade.php`              | Alias gọi `@include('trangchu')`                                             |
| `welcome.blade.php`           | Alias gọi `@include('trangchu')`                                             |
| `xe/danhsach.blade.php`       | Kho siêu xe sang trọng, bộ lọc thương hiệu, loại xe, tầm giá                 |
| `xe/chitiet.blade.php`        | Chi tiết xe: Gallery, thông số động cơ, trả góp 80%, cọc VietQR online       |
| `xe/sosanh.blade.php`         | Phân tích so sánh giá đa sàn, biểu đồ Chart.js lịch sử biến động 6 tháng     |
| `cars/` (thư mục alias)       | Chứa `index.blade.php`, `show.blade.php`, `compare.blade.php` gọi sang `xe/` |
| `laithu.blade.php`            | Form đăng ký lịch lái thử xe VIP, chọn showroom và thời gian hẹn             |
| `test-drive.blade.php`        | Alias gọi `@include('laithu')`                                               |
| `hoadon.blade.php`            | Cổng tra cứu hóa đơn bán xe trực tuyến theo mã hóa đơn hoặc số điện thoại     |
| `invoices.blade.php`          | Alias gọi `@include('hoadon')`                                               |
| `tichdiem/index.blade.php`    | Cổng thành viên PrimeLux Club, tra cứu tích điểm và tiến độ nâng hạng VIP    |
| `loyalty/index.blade.php`     | Alias gọi `@include('tichdiem.index')`                                       |
| `dichvu/index.blade.php`      | Cổng dịch vụ: Đặt lịch bảo dưỡng định kỳ, cứu hộ khẩn cấp, tra sổ bảo hành  |
| `thanhtoan/tratruoc.blade.php`| Cổng thanh toán trả trước online qua mã VietQR động tự động nhận diện        |
| `tradein/index.blade.php`     | Cổng định giá xe cũ & nộp hồ sơ Thu cũ đổi mới siêu xe                      |
| `dangnhap/index.blade.php`    | Trang đăng nhập đa vai trò (Khách VIP, Tư vấn viên, Quản trị viên)          |
| `dangnhap/register.blade.php` | Trang đăng ký tài khoản thành viên mới nhận ngay hạng Silver                |
| `auth/login.blade.php`        | Alias gọi `@include('dangnhap.index')`                                       |

### B. Giao Diện Quản Trị & Nội Bộ (Internal Showroom & Admin)
| View Path                     | Mô tả giao diện                                                              |
|-------------------------------|------------------------------------------------------------------------------|
| `admin/dashboard.blade.php`   | Trung tâm chỉ huy: Thống kê KPI, biểu đồ doanh thu 12 tháng, cơ cấu thương hiệu|
| `quantri/dashboard.blade.php` | Alias gọi `@include('admin.dashboard')`                                      |
| `admin/cars-management.blade.php` | Quản lý kho xe: Thêm, sửa thông số, cập nhật giá, xóa và đổi trạng thái xe |
| `admin/test-drive-list.blade.php` | Quản lý lịch lái thử: Duyệt lịch hẹn, gọi điện, cập nhật trạng thái        |
| `admin/invoices.blade.php`    | Quản lý hóa đơn: Lọc tìm kiếm, xem chi tiết hợp đồng, đổi trạng thái, gửi mail|
| `admin/payments.blade.php`    | Quản lý thanh toán SePay: Giả lập webhook, theo dõi biến động số dư thực tế |
| `admin/tradein.blade.php`     | Quản lý hồ sơ thẩm định thu cũ đổi mới từ khách hàng                         |
| `admin/audit.blade.php`       | Nhật ký kiểm toán an ninh hệ thống và thông báo đa kênh Zalo ZNS / SMS       |
| `consultant/index.blade.php`  | Bàn trực tư vấn viên SSE Realtime: tiếp nhận tin nhắn khách, chat trực tiếp  |
| `tuvanvien/index.blade.php`   | Alias gọi `@include('consultant.index')`                                     |
| `emails/hoadon.blade.php`     | Mẫu email hóa đơn siêu sang gửi tự động tới hộp thư Gmail của khách hàng     |

### C. Layouts (resources/views/layouts/)
| Layout File                   | Mô tả                                                                        |
|-------------------------------|------------------------------------------------------------------------------|
| `layouts/giaodien.blade.php`  | Layout chuẩn cho toàn bộ trang Khách Hàng (Navbar, Footer, SEO tags, Chatbox)|
| `layouts/admin.blade.php`     | Layout chuẩn cho phân hệ Quản Trị Viên (Sidebar menu, Topbar, Flash message)|
| `layouts/client.blade.php`    | Alias kế thừa `@extends('layouts.giaodien')`                                 |
| `layouts/app.blade.php`       | Alias kế thừa `@extends('layouts.admin')`                                    |

---

## 9. PUBLIC ASSETS (public/)

| Thư mục / File                | Vai trò                                                                      |
|-------------------------------|------------------------------------------------------------------------------|
| `public/css/giaodien.css`     | Tệp CSS chính thiết kế phong cách siêu xe PrimeLux (Dark Luxury Theme)       |
| `public/css/Style.css`        | Bản sao CSS đồng bộ                                                          |
| `public/css/trolyao.css`      | Tệp CSS tạo kiểu dáng Widget Chatbot tư vấn sang trọng                       |
| `public/css/chatbot.css`      | Bản sao CSS chatbot đồng bộ                                                  |
| `public/js/trangchu.js`       | JavaScript xử lý hiệu ứng, bộ lọc xe và tương tác trang chủ                  |
| `public/js/Index.js`          | Bản sao JavaScript trang chủ đồng bộ                                         |
| `public/js/trolyao.js`        | JavaScript điều khiển Chatbox: AI Assistant + Live Chat realtime 2 chiều     |
| `public/js/chatbot.js`        | Bản sao JavaScript chatbox đồng bộ                                           |
| `public/js/cars-realtime.js`  | Client-side script nhận tín hiệu cập nhật xe thời gian thực                  |
| `public/image/Logo.png`       | Logo chính thức chuẩn độ phân giải cao của Showroom PrimeLux Auto            |
| `public/robots.txt`           | Cấu hình hướng dẫn bot tìm kiếm Google/Bing chuẩn SEO                        |
| `public/sitemap.xml`          | Bản đồ liên kết website chuẩn SEO tự động cập nhật                           |

---

## 10. KIỂM THỬ TỰ ĐỘNG (tests/Feature/)

| File Test Case                                | Chức năng kiểm thử tự động                                                   |
|-----------------------------------------------|------------------------------------------------------------------------------|
| `SystemRouteTest.php`                         | Kiểm tra 20+ URL routes chính, form đặt lịch lái thử, API tích điểm & tư vấn |
| `UserPromptRequirementsTest.php`              | Kiểm tra toàn bộ 8 yêu cầu đề xuất của đồ án                                 |
| `RealtimeSyncAndCleanDataTest.php`            | Kiểm thử luồng chat realtime 2 chiều không cần F5 & làm sạch dữ liệu mẫu     |
| `SepayWebhookTest.php`                        | Kiểm thử tiếp nhận webhook SePay, bảo mật và đồng bộ thanh toán             |
| `DownPaymentTest.php`                         | Kiểm thử tạo yêu cầu cọc online, tính toán tỷ lệ trả trước                   |
| `CarSyncTest.php`                             | Kiểm thử API nạp danh mục xe và cấp feed dữ liệu thời gian thực              |
| `LiveChatMessengerTest.php`                   | Kiểm thử cơ chế trao đổi tin nhắn trực tiếp giữa khách và tư vấn viên        |
| `RoadmapFeaturesTest.php`                     | Kiểm thử tra cứu sổ bảo hành VIN, cứu hộ khẩn cấp và định giá Trade-In      |
| `SeoPerformanceTest.php`                      | Kiểm thử cấu trúc thẻ SEO On-page, OpenGraph, JSON-LD và robots/sitemap      |
| `ExampleTest.php`                             | Kiểm tra cơ bản phản hồi trang chủ                                           |

---

## 11. BẢNG TỔNG HỢP CHỈ SỐ TOÀN BỘ HỆ THỐNG

| Chỉ số hệ thống                    | Số lượng hiện tại | Ghi chú                                                 |
|------------------------------------|:-----------------:|---------------------------------------------------------|
| **Tổng số Routes (URL Endpoints)** | **122**           | Bao gồm 100% nghiệp vụ Showroom, Admin, SSE, Webhook    |
| **Tổng số Controllers**            | **23**            | 14 Core Controllers + 9 Alias Proxies kế thừa sạch      |
| **Tổng số Eloquent Models**        | **31**            | 20 Core Models + 11 Vietnamese Proxy Models             |
| **Tổng số Migrations**             | **11**            | Bao phủ toàn bộ 15 bảng cơ sở dữ liệu quan hệ           |
| **Tổng số Database Seeders**       | **5**             | Khởi tạo 100% dữ liệu chuẩn chỉ với 1 lệnh `db:seed`    |
| **Tổng số Views Blade**            | **32**            | 23 Views chính thống + 9 Alias Views đồng bộ            |
| **Số lượng Layouts**               | **4**             | Chuẩn hóa về 2 layout chính: `giaodien` và `admin`      |
| **Bộ Feature Tests tự động**       | **10 file**       | Thực thi 47 test cases, 291 assertions (100% PASS)       |
| **Tuân thủ chuẩn Code Style**      | **100%**          | Đạt chuẩn PSR-12 / Laravel Pint tự động                 |
