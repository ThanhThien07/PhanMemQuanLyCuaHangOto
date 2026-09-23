# HƯỚNG DẪN CÀI ĐẶT VÀ CHẠY DỰ ÁN
## PrimeLux Auto – Phần mềm Quản lý Cửa hàng Ôtô

---

## YÊU CẦU HỆ THỐNG

- PHP >= 8.3
- Composer >= 2.x
- Node.js >= 18.x + NPM
- MySQL 8.x hoặc SQLite (mặc định)
- Laragon / XAMPP / WAMP (Windows)
- Git

---

## CÀI ĐẶT

### Bước 1: Clone repository
`
git clone [URL_REPOSITORY]
cd PhanMemQuanLyCuaHangOto
`

### Bước 2: Cài PHP dependencies
`
composer install
`

### Bước 3: Cài Node.js dependencies
`
npm install
`

### Bước 4: Tạo file môi trường
`
copy .env.example .env
php artisan key:generate
`

### Bước 5: Cấu hình database trong .env

Nếu dùng SQLite (mặc định):
`
DB_CONNECTION=sqlite
# DB_DATABASE sẽ là database/database.sqlite
`

Nếu dùng MySQL:
`
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qly_cuahangoto
DB_USERNAME=root
DB_PASSWORD=
`

### Bước 6: Tạo bảng database

Dùng Migration (SQLite):
`
php artisan migrate
`

Hoặc Import SQL (MySQL):
`
mysql -u root -p qly_cuahangoto < qly_cuahangoto.sql
`

### Bước 7: Build assets frontend
`
npm run build
`

### Bước 8: Chạy ứng dụng
`
php artisan serve
`
Mở browser: http://localhost:8000

---

## CHẠY DEVELOPMENT

`
composer run dev
`
(Chạy đồng thời: Laravel server + Vite HMR)

Hoặc riêng lẻ:
`
Terminal 1: php artisan serve
Terminal 2: npm run dev
`

---

## CẤU HÌNH LARAGON (Khuyến nghị)

1. Đặt project vào: C:\laragon\www\PhanMemQuanLyCuaHangOto
2. Laragon tự tạo virtual host: http://phanmemquanlycuahangoto.test
3. Chỉ cần: composer install && npm run build

---

## TÀI KHOẢN MẶC ĐỊNH

### Admin:
- URL: /login?role=admin hoặc /dangnhap
- Chọn tab "Quản trị viên"
- Nhập bất kỳ email → Đăng nhập
- Redirect: /admin (Dashboard)

### Advisor (Tư vấn viên):
- URL: /login?role=advisor
- Chọn tab "Chuyên viên tư vấn"
- Redirect: /consultant

### Khách hàng:
- URL: /login hoặc /dangnhap
- Chọn tab "Khách hàng VIP"
- Nhập SĐT: 0901234567 (nếu đã seed DB)
- Redirect: /loyalty?phone=0901234567

---

## ARTISAN COMMANDS HỮU ÍCH

`ash
# Xem toàn bộ routes
php artisan route:list

# Tạo bảng DB
php artisan migrate

# Reset và seed lại DB
php artisan migrate:fresh --seed

# Tạo controller mới
php artisan make:controller TenController

# Tạo model mới
php artisan make:model TenModel -m

# Xem logs realtime
php artisan pail

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Kiểm tra DB
php artisan tinker
>>> App\Models\Car::all()->count()
`

---

## CẤU TRÚC .ENV QUAN TRỌNG

`env
APP_NAME="PrimeLux Auto"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# hoặc mysql

LOG_CHANNEL=stack
LOG_LEVEL=debug

SESSION_DRIVER=database
SESSION_LIFETIME=120
`

---

## KIỂM TRA HỆ THỐNG ĐANG HOẠT ĐỘNG

| URL                                    | Kết quả mong đợi           |
|----------------------------------------|----------------------------|
| GET /                                  | Trang chủ PrimeLux         |
| GET /cars                              | Danh sách 6+ xe            |
| GET /test-drive                        | Form đặt lịch lái thử      |
| GET /loyalty                           | Trang tích điểm            |
| GET /login                             | Form đăng nhập             |
| GET /admin (sau khi login admin)       | Dashboard quản trị         |
| GET /consultant (sau khi login advisor)| Cổng tư vấn viên           |
| GET /api/loyalty/check?phone=xxx       | JSON response              |
| GET /api/consultant/realtime-feed      | JSON danh sách câu hỏi     |

---
Hướng dẫn cài đặt: PrimeLux Auto v1.0
Ngày: 23/09/2026
