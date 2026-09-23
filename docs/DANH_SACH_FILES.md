# DANH SÁCH FILES & ĐƯỜNG DẪN TOÀN DỰ ÁN
# PrimeLux Auto – Phần mềm Quản lý Cửa hàng Ôtô
# Cập nhật: 23/09/2026
# ============================================================

## ROOT FILES

| File                  | Kích thước | Mô tả / Tác dụng                                      |
|-----------------------|------------|-------------------------------------------------------|
| artisan               | 425 B      | Laravel CLI tool – chạy lệnh artisan                 |
| composer.json         | 2.7 KB     | Khai báo PHP dependencies                            |
| composer.lock         | 312 KB     | Lock file version packages PHP                       |
| package.json          | 461 B      | Khai báo Node.js dependencies (Vite, Tailwind)       |
| vite.config.js        | 632 B      | Cấu hình Vite build tool                             |
| .env                  | 1.1 KB     | Biến môi trường (DB, APP_KEY, APP_URL...)            |
| .env.example          | 1.1 KB     | Mẫu biến môi trường                                  |
| .gitignore            | 341 B      | Danh sách file Git bỏ qua                            |
| .editorconfig         | 275 B      | Cấu hình editor (indent, charset...)                 |
| .npmrc                | 31 B       | Cấu hình NPM                                         |
| .gitattributes        | 186 B      | Git attributes (line endings...)                     |
| phpunit.xml           | 1.3 KB     | Cấu hình PHPUnit testing                             |
| AGENTS.md             | 1.4 KB     | Hướng dẫn cài đặt Laravel Boost                     |
| CLAUDE.md             | 1.4 KB     | Cấu hình AI coding assistant                         |
| README.md             | 3.7 KB     | Tài liệu hướng dẫn dự án                            |
| qly_cuahangoto.sql    | 82 KB      | SQL dump database MySQL                              |

## ROUTES

| File              | Dòng | Mô tả                                          |
|-------------------|------|------------------------------------------------|
| routes/web.php    | 96   | 37 URL routes cho toàn bộ hệ thống           |
| routes/console.php| -    | Console/schedule routes                        |

## CONTROLLERS (app/Http/Controllers/)

| File                          | KB   | Vai trò                                        |
|-------------------------------|------|------------------------------------------------|
| Controller.php                | 0.1  | Base Controller abstract class                 |
| TrangChuController.php        | ~0.3 | Trang chủ → view trangchu/welcome              |
| XeController.php              | 0.8  | Danh sách xe + chi tiết xe                    |
| SoSanhGiaController.php       | 2.2  | So sánh giá xe đa sàn + API refresh           |
| LaiThuController.php          | 1.8  | Đặt lịch lái thử + validate + lưu DB          |
| HoaDonController.php          | 0.2  | Tra cứu hóa đơn                               |
| InvoiceController.php         | 0.3  | Invoice (alias tiếng Anh)                     |
| TichDiemController.php        | 2.9  | Tích điểm: tìm KH, progress, API check        |
| LoyaltyController.php         | 3.2  | Loyalty (tiếng Anh) tương đương TichDiem      |
| DangNhapController.php        | 2.9  | Đăng nhập 3 role + đăng xuất                  |
| AuthController.php            | 3.0  | Auth (tiếng Anh)                              |
| QuanTriController.php         | 3.8  | Admin dashboard + adjust points (tiếng Việt)  |
| AdminController.php           | 4.7  | Admin dashboard + adjust points (tiếng Anh)   |
| ConsultantController.php      | 11.4 | Tư vấn realtime: reply, SSE, feed, submit     |
| TuVanVienController.php       | 1.6  | Tư vấn viên (wrapper/alias)                   |
| TestDriveController.php       | 1.8  | Lái thử (tiếng Anh)                          |
| CarController.php             | 0.8  | Xe (tiếng Anh)                               |
| CarComparisonController.php   | 2.6  | So sánh xe (tiếng Anh)                       |
| HomeController.php            | 0.3  | Trang chủ (tiếng Anh)                        |
| KhoaController.php            | 0.3  | Khoa (legacy/unused)                          |

## MODELS (app/Models/)

| File                  | KB   | Table          | Vai trò                                     |
|-----------------------|------|----------------|---------------------------------------------|
| User.php              | 0.8  | users          | Người dùng hệ thống Laravel default         |
| Car.php               | 7.1  | xe             | Xe: formatCar, getAllCars, getDefaultCars   |
| Xe.php                | 0.1  | xe             | Xe alias (proxy cho Car)                    |
| Brand.php             | 0.3  | thuong_hieu    | Thương hiệu xe                             |
| ThuongHieu.php        | 0.1  | thuong_hieu    | Thương hiệu (tiếng Việt)                   |
| CarType.php           | 0.2  | loai_xe        | Loại xe (tiếng Anh)                        |
| LoaiXe.php            | 0.1  | loai_xe        | Loại xe (tiếng Việt)                       |
| Customer.php          | 0.7  | khach_hang     | Khách hàng + belongsTo(LoyaltyTier)         |
| KhachHang.php         | 0.1  | khach_hang     | Khách hàng (tiếng Việt)                    |
| LoyaltyTier.php       | 0.4  | hang_thanh_vien| Hạng thành viên (tiếng Anh)                |
| HangThanhVien.php     | 0.1  | hang_thanh_vien| Hạng thành viên (tiếng Việt)               |
| Invoice.php           | 3.6  | hoa_don        | Hóa đơn + relations + getAllInvoices        |
| HoaDon.php            | 0.1  | hoa_don        | Hóa đơn (tiếng Việt)                       |
| InvoiceDetail.php     | 0.5  | ct_hoa_don     | Chi tiết hóa đơn (tiếng Anh)               |
| ChiTietHoaDon.php     | 0.1  | ct_hoa_don     | Chi tiết HĐ (tiếng Việt)                  |
| TestDrive.php         | 2.3  | dang_ky_lai_thu| Lái thử + getAllBookings                    |
| LaiThu.php            | 0.1  | dang_ky_lai_thu| Lái thử (tiếng Việt)                       |
| ChatLog.php           | 0.5  | chat_logs      | Nhật ký chat + advisor fields               |
| NhatKyChat.php        | 0.1  | chat_logs      | Nhật ký chat (tiếng Việt)                  |
| PointsHistory.php     | 0.4  | lich_su_diem   | Lịch sử điểm (tiếng Anh)                  |
| LichSuDiem.php        | 0.1  | lich_su_diem   | Lịch sử điểm (tiếng Việt)                 |
| CarPriceSource.php    | 0.7  | so_sanh_gia_xe | Nguồn giá thị trường                        |
| SoSanhGiaXe.php       | 0.1  | so_sanh_gia_xe | So sánh giá (tiếng Việt)                   |
| GiangVien.php         | 0.1  | -              | Giảng viên (legacy/unused)                 |
| Khoa.php              | 0.6  | -              | Khoa (legacy)                              |
| Nganh.php             | 0.1  | -              | Ngành (legacy)                             |
| NguoiDung.php         | 0.1  | -              | Người dùng (legacy)                        |

## MIGRATIONS (database/migrations/)

| File                                                          | Mô tả                                              |
|---------------------------------------------------------------|----------------------------------------------------|
| 0001_01_01_000000_create_users_table.php                      | Bảng users, password_resets, sessions              |
| 0001_01_01_000001_create_cache_table.php                      | Bảng cache, cache_locks                            |
| 0001_01_01_000002_create_jobs_table.php                       | Bảng jobs, job_batches, failed_jobs                |
| 2026_09_23_000001_create_dealership_tables.php                | 10 bảng chính showroom xe                          |
| 2026_09_23_000002_add_advisor_fields_to_chat_logs_table.php   | Thêm fields advisor vào chat_logs                  |

## VIEWS (resources/views/)

| File / Thư mục                    | Mô tả                                              |
|-----------------------------------|----------------------------------------------------|
| welcome.blade.php                 | 72KB – Landing page đặc biệt (full feature)        |
| home.blade.php                    | 12.7KB – Trang chủ                                |
| trangchu.blade.php                | 12.7KB – Trang chủ (tiếng Việt)                   |
| laithu.blade.php                  | 7.9KB – Trang đặt lịch lái thử                   |
| test-drive.blade.php              | 7.9KB – Lái thử (tiếng Anh)                       |
| hoadon.blade.php                  | 9.9KB – Tra cứu hóa đơn                          |
| invoices.blade.php                | 9.9KB – Hóa đơn (tiếng Anh)                       |
| layouts/app.blade.php             | Layout chính: nav, footer, flash messages          |
| cars/ (thư mục)                   | View xe tiếng Anh                                 |
| xe/ (thư mục)                     | View xe + sosanh (tiếng Việt)                     |
| admin/ (thư mục)                  | Dashboard admin                                   |
| quantri/ (thư mục)                | Dashboard quản trị (tiếng Việt)                   |
| consultant/ (thư mục)             | Tư vấn viên (tiếng Anh)                           |
| tuvanvien/ (thư mục)              | Tư vấn viên (tiếng Việt)                          |
| dangnhap/ (thư mục)               | Trang đăng nhập                                   |
| auth/ (thư mục)                   | Auth (tiếng Anh)                                  |
| loyalty/ (thư mục)                | Loyalty (tiếng Anh)                               |
| tichdiem/ (thư mục)               | Tích điểm (tiếng Việt)                            |
| khoas/ (thư mục)                  | Legacy                                            |

## DATABASE FILES

| File                        | Kích thước | Mô tả                                    |
|-----------------------------|------------|------------------------------------------|
| database/database.sqlite    | 96 KB      | SQLite database file (development)       |
| database/qly_cuahangoto.sql | 82 KB      | MySQL schema + data export               |
| qly_cuahangoto.sql (root)   | 82 KB      | Bản sao SQL ở root directory             |

## DOCS (docs/)

| File                             | Mô tả                                              |
|----------------------------------|----------------------------------------------------|
| BAO_CAO_DO_AN.txt                | Báo cáo đồ án đầy đủ (5 chương)                  |
| BAO_CAO_CHI_TIET_HE_THONG.md    | Tài liệu kỹ thuật chi tiết toàn hệ thống          |
| DANH_SACH_FILES.md               | File này – liệt kê toàn bộ files & đường dẫn      |

## TÓM TẮT SỐ LIỆU

| Chỉ số              | Số lượng |
|---------------------|----------|
| Tổng Controllers    | 20       |
| Tổng Models         | 27       |
| Tổng Routes (URL)   | 37       |
| Tổng bảng DB        | 10       |
| Tổng migration files| 5        |
| Thư mục views       | 12+      |
| API Endpoints       | 7        |
| Vai trò người dùng  | 3        |
| Hạng thành viên     | 4        |
| Xe mẫu (fallback)   | 6        |
