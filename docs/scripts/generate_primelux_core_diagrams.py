# -*- coding: utf-8 -*-
"""
Script vẽ các sơ đồ kiến trúc, luồng nghiệp vụ và ERD chính xác 100% cho Showroom PrimeLux Auto
Sử dụng Pillow với độ phân giải cao (1400x800, 1600x900).
"""

import os
import sys
from PIL import Image, ImageDraw, ImageFont

sys.stdout.reconfigure(encoding='utf-8')

def get_font(size, bold=False):
    font_paths = [
        "C:/Windows/Fonts/tahomabd.ttf" if bold else "C:/Windows/Fonts/tahoma.ttf",
        "C:/Windows/Fonts/arialbd.ttf" if bold else "C:/Windows/Fonts/arial.ttf",
        "C:/Windows/Fonts/segoeuib.ttf" if bold else "C:/Windows/Fonts/segoeui.ttf",
    ]
    for p in font_paths:
        if os.path.exists(p):
            try:
                return ImageFont.truetype(p, size)
            except:
                pass
    return ImageFont.load_default()

def draw_rounded_rect(draw, box, radius=8, fill="#ffffff", outline="#000000", width=2):
    draw.rounded_rectangle(box, radius=radius, fill=fill, outline=outline, width=width)

def create_architecture_diagram():
    w, h = 1400, 800
    img = Image.new("RGB", (w, h), "#f8fafc")
    draw = ImageDraw.Draw(img)

    f_title = get_font(22, bold=True)
    f_sub = get_font(13, bold=False)
    f_header = get_font(15, bold=True)
    f_box_title = get_font(13, bold=True)
    f_box_desc = get_font(11, bold=False)

    # Header
    draw.rectangle([0, 0, w, 70], fill="#0f172a")
    draw.text((w//2, 35), "KIẾN TRÚC TỔNG THỂ HỆ THỐNG SHOWROOM PRIMELUX AUTO", fill="#ffffff", font=f_title, anchor="mm")
    draw.text((w//2, 58), "Nền tảng PHP 8.3 & Laravel 12 Framework - Tailwind CSS v4 & Vite 8 - MySQL 8.0", fill="#94a3b8", font=f_sub, anchor="mm")

    # 5 Tầng kiến trúc
    layers = [
        ("1. TẦNG KHÁCH HÀNG (CLIENT TIER)", "#e0f2fe", "#0284c7", [
            ("Khách hàng vãng lai", "Trình duyệt Web, Mobile, Tra cứu xe, Dự toán lăn bánh, Vay trả góp"),
            ("Hội viên PrimeLux Club", "Đăng nhập bảo mật, Thanh toán SePay VietQR, Tích điểm VIP, Tra cứu VIN"),
            ("Chuyên viên tư vấn", "Bàn trực tư vấn, Nhận kết nối SSE thời gian thực, Quản lý lịch lái thử"),
            ("Ban Quản trị & Kế toán", "Admin Portal, Phễu bán hàng BI, Thẩm định Trade-In, Xuất Excel/CSV")
        ]),
        ("2. TẦNG TRÌNH DIỄN & GIAO DIỆN (PRESENTATION & ROUTING TIER)", "#f0fdf4", "#16a34a", [
            ("Laravel 12 Web Routing", "routes/web.php (Tối ưu URL, SEO Slug, API Endpoint, CSRF Middleware)"),
            ("Blade Template Engine", "resources/views (Layout kế thừa sang trọng, Tự động mã hóa XSS)"),
            ("Tailwind CSS v4 & Vite 8", "@tailwindcss/vite 4.0, HMR biên dịch nhanh, Giao diện tối ưu Mobile"),
            ("Thư viện đồ họa Chart.js", "Biểu đồ biến động giá sàn 6 tháng & Biểu đồ Phễu chuyển đổi Sales Funnel")
        ]),
        ("3. TẦNG ĐIỀU KHIỂN & ĐIỀU PHỐI (CONTROLLER TIER)", "#fef3c7", "#d97706", [
            ("Khách hàng & Bán hàng", "TrangChuController, XeController, LaiThuController, SoSanhGiaController"),
            ("Tài chính & Thanh toán", "ThanhToanController, SepayWebhookController, HoaDonController, TichDiemController"),
            ("Dịch vụ & Thẩm định", "DichVuController (Sổ bảo hành VIN), TradeInController (Trade-In 176 mục)"),
            ("Quản trị & Báo cáo", "QuanTriController (BI Dashboard, RBAC, Xuất CSV UTF-8 BOM, Audit Log)")
        ]),
        ("4. TẦNG DỊCH VỤ NGHIỆP VỤ & TÍCH HỢP (SERVICE & INTEGRATION TIER)", "#f3e8ff", "#9333ea", [
            ("Trợ lý ảo AI LLM (RAG)", "AiConsultantService: Trích xuất context xe thực tế, tư vấn thông minh 24/7"),
            ("Thông báo đa kênh", "NotificationService: Phát thông báo Zalo ZNS, SMS Brandname, Email biên lai"),
            ("Scraper giá sàn thị trường", "ScrapeMarketPricesCommand: Thu thập tự động dữ liệu Oto.com.vn, Bonbanh, ChoTot"),
            ("Realtime Event Stream", "SSE Endpoint (/api/consultant/sse-stream): Bắn thông báo đẩy tức thì")
        ]),
        ("5. TẦNG DỮ LIỆU & BẢO MẬT (DATA ACCESS & PERSISTENCE TIER)", "#fee2e2", "#dc2626", [
            ("Eloquent ORM & PDO", "Ánh xạ mô hình hướng đối tượng, Chống SQL Injection bằng Parameterized Query"),
            ("Hệ CSDL MySQL 8.0", "20 bảng chuẩn hóa 3NF: xe, thuong_hieu, khach_hang, hoa_don, sepay_transactions..."),
            ("Cổng thanh toán SePay", "VietQR Banking API, Webhook HMAC-SHA256 xác thực tự động dưới 3 giây"),
            ("An toàn bảo mật & 2FA", "RBAC 5 vai trò, Google Authenticator (TOTP RFC 6238), Ghi nhận Audit Log")
        ])
    ]

    y = 90
    for l_title, bg_color, border_color, boxes in layers:
        # Layer container
        draw.rounded_rectangle([30, y, w - 30, y + 125], radius=10, fill=bg_color, outline=border_color, width=2)
        draw.text((45, y + 8), l_title, fill=border_color, font=f_header)

        # 4 boxes inside
        box_w = (w - 110) // 4
        bx_start = 45
        by = y + 32
        for title, desc in boxes:
            draw.rounded_rectangle([bx_start, by, bx_start + box_w, by + 82], radius=6, fill="#ffffff", outline="#cbd5e1", width=1)
            draw.text((bx_start + 10, by + 8), title, fill="#0f172a", font=f_box_title)
            
            # Multi-line desc
            words = desc.split(" ")
            lines = []
            curr = ""
            for word in words:
                if len(curr + " " + word) > 34:
                    lines.append(curr)
                    curr = word
                else:
                    curr = curr + " " + word if curr else word
            if curr:
                lines.append(curr)
            
            desc_y = by + 28
            for line in lines[:3]:
                draw.text((bx_start + 10, desc_y), line, fill="#475569", font=f_box_desc)
                desc_y += 16
                
            bx_start += box_w + 10
        y += 140

    out_path = "docs/screenshots/hinh_1_1_kien_truc_he_thong.jpg"
    img.save(out_path, quality=95)
    print("✅ Đã tạo sơ đồ kiến trúc:", out_path)

def create_business_flow_diagram():
    w, h = 1400, 750
    img = Image.new("RGB", (w, h), "#f8fafc")
    draw = ImageDraw.Draw(img)

    f_title = get_font(22, bold=True)
    f_sub = get_font(13, bold=False)
    f_step_num = get_font(18, bold=True)
    f_step_title = get_font(15, bold=True)
    f_step_desc = get_font(11, bold=False)

    # Header
    draw.rectangle([0, 0, w, 70], fill="#0f172a")
    draw.text((w//2, 35), "SƠ ĐỒ LUỒNG QUY TRÌNH KINH DOANH VÀ DỊCH VỤ SHOWROOM PRIMELUX AUTO", fill="#ffffff", font=f_title, anchor="mm")
    draw.text((w//2, 58), "Quy trình khép kín: Tìm kiếm -> Tài chính -> Trải nghiệm -> Đặt cọc SePay -> Bảo hành VIN", fill="#94a3b8", font=f_sub, anchor="mm")

    steps = [
        ("GIAI ĐOẠN 1", "TÌM KIẾM & SO SÁNH XE", "#0284c7", [
            "- Khách truy cập Trang chủ Showroom",
            "- Lọc xe theo hãng, kiểu dáng, tầm giá",
            "- Xem chi tiết thông số động cơ & ảnh",
            "- So sánh giá đa sàn (Oto.com, Bonbanh)",
            "- Biểu đồ biến động giá 6 tháng"
        ]),
        ("GIAI ĐOẠN 2", "DỰ TOÁN & TƯ VẤN AI", "#16a34a", [
            "- Dự toán chi phí lăn bánh 63 tỉnh",
            "- Tính thuế trước bạ, biển số 20tr/1tr",
            "- Bảng tính vay trả góp giảm dần",
            "- Chat Trợ lý ảo AI LLM (RAG) 24/7",
            "- Chuyển tiếp tư vấn viên qua SSE"
        ]),
        ("GIAI ĐOẠN 3", "LÁI THỬ & TRADE-IN", "#d97706", [
            "- Đặt lịch hẹn lái thử VIP tận nơi",
            "- Thông báo xác nhận Zalo ZNS / SMS",
            "- Nộp hồ sơ Thu cũ đổi mới xe sang",
            "- Định giá sơ bộ khấu hao tự động",
            "- Chuyên viên kiểm định 176 hạng mục"
        ]),
        ("GIAI ĐOẠN 4", "ĐẶT CỌC SEPAY VIETQR", "#9333ea", [
            "- Khách chọn cọc giữ xe trực tuyến",
            "- Quét mã VietQR động có cú pháp cọc",
            "- SePay gửi Webhook HMAC-SHA256",
            "- Tự động duyệt đơn hàng trong 3s",
            "- Khóa xe trong kho, báo Popup Admin"
        ]),
        ("GIAI ĐOẠN 5", "BÀN GIAO & BẢO HÀNH VIN", "#dc2626", [
            "- Ký hợp đồng mua bán tại Showroom",
            "- Kích hoạt Sổ bảo hành điện tử VIN",
            "- Tra cứu lịch sử bảo dưỡng trực tuyến",
            "- Tích điểm hội viên PrimeLux Club",
            "- Nhận đặc quyền VIP & Cứu hộ 24/7"
        ])
    ]

    box_w = (w - 160) // 5
    bx = 40
    by = 130
    bh = 520

    for idx, (stage_num, stage_title, color, items) in enumerate(steps):
        # Card
        draw.rounded_rectangle([bx, by, bx + box_w, by + bh], radius=12, fill="#ffffff", outline=color, width=3)
        # Card Header
        draw.rounded_rectangle([bx, by, bx + box_w, by + 85], radius=12, fill=color)
        draw.rectangle([bx, by + 70, bx + box_w, by + 85], fill=color)
        draw.text((bx + box_w//2, by + 28), stage_num, fill="#ffffff", font=f_step_num, anchor="mm")
        draw.text((bx + box_w//2, by + 58), stage_title, fill="#ffffff", font=f_step_title, anchor="mm")

        # Items
        iy = by + 110
        for item in items:
            draw.text((bx + 15, iy), item, fill="#1e293b", font=f_step_desc)
            iy += 45

        # Arrow to next stage
        if idx < 4:
            arrow_x = bx + box_w + 6
            arrow_y = by + bh // 2
            draw.polygon([
                (arrow_x, arrow_y - 12),
                (arrow_x + 16, arrow_y),
                (arrow_x, arrow_y + 12)
            ], fill=color)

        bx += box_w + 20

    out_path = "docs/screenshots/hinh_2_1_luong_nghiep_vu.jpg"
    img.save(out_path, quality=95)
    print("✅ Đã tạo sơ đồ luồng nghiệp vụ:", out_path)

def create_erd_diagram():
    w, h = 1600, 950
    img = Image.new("RGB", (w, h), "#0f172a")
    draw = ImageDraw.Draw(img)

    f_title = get_font(22, bold=True)
    f_sub = get_font(13, bold=False)
    f_tbl_header = get_font(13, bold=True)
    f_field = get_font(10, bold=False)
    f_pk = get_font(10, bold=True)

    # Header
    draw.rectangle([0, 0, w, 65], fill="#1e293b")
    draw.text((w//2, 28), "SƠ ĐỒ QUAN HỆ THỰC THỂ (ERD) - CƠ SỞ DỮ LIỆU PRIMELUX AUTO", fill="#ffffff", font=f_title, anchor="mm")
    draw.text((w//2, 50), "20 Bảng dữ liệu chuẩn hóa dạng 3NF - Quản lý Kho xe, Khách hàng, Thanh toán SePay, Trade-In & Bảo hành VIN", fill="#38bdf8", font=f_sub, anchor="mm")

    tables = [
        # Col 0 (Core Vehicles & Specs)
        ("thuong_hieu", 30, 85, 230, 150, "#0284c7", [
            ("ma_th (PK)", "VARCHAR(50)"),
            ("ten_th", "VARCHAR(100)"),
            ("xuat_xu", "VARCHAR(100)"),
            ("badge", "VARCHAR(100)"),
            ("mo_ta", "TEXT")
        ]),
        ("loai_xe", 30, 255, 230, 130, "#0284c7", [
            ("ma_loai (PK)", "VARCHAR(50)"),
            ("ten_loai", "VARCHAR(100)"),
            ("mo_ta", "TEXT")
        ]),
        ("xe", 30, 405, 230, 260, "#0284c7", [
            ("ma_xe (PK)", "VARCHAR(50)"),
            ("ten_xe", "VARCHAR(255)"),
            ("ma_th (FK)", "VARCHAR(50)"),
            ("ma_loai (FK)", "VARCHAR(50)"),
            ("gia_niem_yet", "DECIMAL"),
            ("nhien_lieu", "VARCHAR(50)"),
            ("cong_suat", "VARCHAR(50)"),
            ("so_cho", "VARCHAR(50)"),
            ("so_luong_kho", "INT"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("car_price_sources", 30, 685, 230, 220, "#0284c7", [
            ("id (PK)", "BIGINT"),
            ("car_id (FK)", "BIGINT"),
            ("source_name", "VARCHAR(100)"),
            ("price", "DECIMAL"),
            ("location", "VARCHAR(100)"),
            ("condition_type", "VARCHAR(100)"),
            ("warranty", "VARCHAR(100)"),
            ("fetched_at", "TIMESTAMP")
        ]),

        # Col 1 (Customers & Orders)
        ("hang_thanh_vien", 290, 85, 240, 170, "#16a34a", [
            ("ma_hang (PK)", "VARCHAR(50)"),
            ("ten_hang", "VARCHAR(100)"),
            ("diem_toi_thieu", "INT"),
            ("ti_le_chiet_khau", "DECIMAL"),
            ("dac_quyen", "TEXT"),
            ("mau_badge", "VARCHAR(50)")
        ]),
        ("khach_hang", 290, 275, 240, 230, "#16a34a", [
            ("ma_kh (PK)", "VARCHAR(50)"),
            ("ho_ten", "VARCHAR(255)"),
            ("sdt", "VARCHAR(20)"),
            ("email", "VARCHAR(255)"),
            ("mat_khau", "VARCHAR(255)"),
            ("diem_tich_luy", "INT"),
            ("tong_chi_tieu", "DECIMAL"),
            ("ma_hang (FK)", "VARCHAR(50)")
        ]),
        ("hoa_don", 290, 525, 240, 220, "#16a34a", [
            ("ma_hd (PK)", "VARCHAR(50)"),
            ("ma_kh (FK)", "VARCHAR(50)"),
            ("ngay_lap", "DATETIME"),
            ("tong_tien_goc", "DECIMAL"),
            ("tong_tien_tt", "DECIMAL"),
            ("diem_thuong", "INT"),
            ("phuong_thuc_tt", "VARCHAR"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("ct_hoa_don", 290, 765, 240, 150, "#16a34a", [
            ("ma_hd (FK)", "VARCHAR(50)"),
            ("ma_xe (FK)", "VARCHAR(50)"),
            ("so_luong", "INT"),
            ("don_gia", "DECIMAL"),
            ("thanh_tien", "DECIMAL")
        ]),

        # Col 2 (Transactions & Test Drive)
        ("sepay_transactions", 560, 85, 250, 260, "#d97706", [
            ("sepay_id (PK)", "VARCHAR(100)"),
            ("account_number", "VARCHAR(50)"),
            ("transfer_amount", "DECIMAL"),
            ("code", "VARCHAR(100)"),
            ("content", "TEXT"),
            ("reference_code", "VARCHAR(100)"),
            ("customer_phone", "VARCHAR(20)"),
            ("status", "VARCHAR(50)"),
            ("is_notified_admin", "BOOLEAN")
        ]),
        ("dang_ky_lai_thu", 560, 365, 250, 220, "#d97706", [
            ("ma_lich (PK)", "VARCHAR(50)"),
            ("ho_ten", "VARCHAR(255)"),
            ("sdt", "VARCHAR(20)"),
            ("email", "VARCHAR(255)"),
            ("ten_xe", "VARCHAR(255)"),
            ("showroom", "VARCHAR(255)"),
            ("thoi_gian", "DATETIME"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("lich_su_diem", 560, 605, 250, 150, "#d97706", [
            ("id (PK)", "BIGINT"),
            ("ma_kh (FK)", "VARCHAR(50)"),
            ("ma_hd (FK)", "VARCHAR(50)"),
            ("so_diem", "INT"),
            ("hanh_dong", "VARCHAR(100)"),
            ("ngay_tao", "DATETIME")
        ]),
        ("chat_logs", 560, 775, 250, 140, "#d97706", [
            ("ma_tin (PK)", "VARCHAR(50)"),
            ("thoi_gian", "VARCHAR(50)"),
            ("nguoi_gui", "VARCHAR(255)"),
            ("noi_dung", "TEXT"),
            ("phan_hoi_bot", "TEXT")
        ]),

        # Col 3 (Services & E-Warranty VIN)
        ("so_bao_hanh_vin", 840, 85, 250, 230, "#9333ea", [
            ("vin (PK)", "VARCHAR(50)"),
            ("bien_so", "VARCHAR(50)"),
            ("ten_xe", "VARCHAR(255)"),
            ("chu_so_huu", "VARCHAR(255)"),
            ("sdt_chu_xe", "VARCHAR(20)"),
            ("ngay_giao_xe", "DATE"),
            ("ngay_het_han_bh", "DATE"),
            ("so_km_hien_tai", "INT"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("lich_su_bao_duong_vin", 840, 335, 250, 210, "#9333ea", [
            ("id (PK)", "BIGINT"),
            ("vin (FK)", "VARCHAR(50)"),
            ("ngay_bao_duong", "DATE"),
            ("moc_km", "INT"),
            ("noi_dung", "TEXT"),
            ("chi_phi", "DECIMAL"),
            ("ky_thuat_vien", "VARCHAR(255)"),
            ("diem_tich_luy", "INT")
        ]),
        ("dich_vu", 840, 565, 250, 160, "#9333ea", [
            ("ma_dv (PK)", "VARCHAR(50)"),
            ("loai_dv", "ENUM"),
            ("ten_dv", "VARCHAR(255)"),
            ("gia_tham_khao", "DECIMAL"),
            ("quy_trinh", "TEXT"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("dat_lich_dich_vu", 840, 745, 250, 170, "#9333ea", [
            ("ma_dat_lich (PK)", "VARCHAR(50)"),
            ("ho_ten", "VARCHAR(255)"),
            ("sdt", "VARCHAR(20)"),
            ("bien_so", "VARCHAR(50)"),
            ("ten_dich_vu", "VARCHAR(255)"),
            ("thoi_gian_hen", "DATETIME"),
            ("trang_thai", "VARCHAR(50)")
        ]),

        # Col 4 (Trade-In, Notifications, Security)
        ("yeu_cau_thu_doi_xe", 1120, 85, 250, 260, "#e11d48", [
            ("ma_yeu_cau (PK)", "VARCHAR(50)"),
            ("ho_ten", "VARCHAR(255)"),
            ("sdt", "VARCHAR(20)"),
            ("hang_xe_cu", "VARCHAR(100)"),
            ("dong_xe_cu", "VARCHAR(150)"),
            ("nam_sx", "YEAR"),
            ("so_km", "INT"),
            ("xe_du_dinh_doi", "VARCHAR(255)"),
            ("gia_dinh_gia", "DECIMAL"),
            ("gia_chot", "DECIMAL"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("thong_bao_da_kenh", 1120, 365, 250, 190, "#e11d48", [
            ("ma_thong_bao (PK)", "VARCHAR(50)"),
            ("loai_kenh", "VARCHAR(50)"),
            ("muc_dich", "VARCHAR(100)"),
            ("nguoi_nhan", "VARCHAR(255)"),
            ("sdt_email", "VARCHAR(255)"),
            ("tieu_de", "VARCHAR(255)"),
            ("noi_dung", "TEXT"),
            ("trang_thai", "VARCHAR(50)")
        ]),
        ("audit_logs", 1120, 575, 250, 160, "#e11d48", [
            ("id (PK)", "BIGINT"),
            ("user_name", "VARCHAR(255)"),
            ("user_role", "VARCHAR(50)"),
            ("action", "VARCHAR(100)"),
            ("details", "TEXT"),
            ("ip_address", "VARCHAR(45)")
        ]),
        ("users", 1120, 755, 250, 150, "#e11d48", [
            ("id (PK)", "BIGINT"),
            ("name", "VARCHAR(255)"),
            ("email", "VARCHAR(255)"),
            ("password", "VARCHAR(255)"),
            ("role", "ENUM('admin','nv')")
        ])
    ]

    for tbl_name, tx, ty, tw, th, border_color, fields in tables:
        # Table Box
        draw.rounded_rectangle([tx, ty, tx + tw, ty + th], radius=6, fill="#1e293b", outline=border_color, width=2)
        # Table Header
        draw.rounded_rectangle([tx, ty, tx + tw, ty + 26], radius=6, fill=border_color)
        draw.rectangle([tx, ty + 16, tx + tw, ty + 26], fill=border_color)
        draw.text((tx + tw//2, ty + 13), tbl_name, fill="#ffffff", font=f_tbl_header, anchor="mm")

        # Fields
        fy = ty + 32
        for f_name, f_type in fields:
            is_pk = "(PK)" in f_name or "(FK)" in f_name
            f_color = "#38bdf8" if is_pk else "#e2e8f0"
            font_to_use = f_pk if is_pk else f_field
            draw.text((tx + 10, fy), f_name, fill=f_color, font=font_to_use)
            draw.text((tx + tw - 10, fy), f_type, fill="#94a3b8", font=f_field, anchor="ra")
            fy += 17

    out_path = "docs/screenshots/hinh_2_2_so_do_erd.jpg"
    img.save(out_path, quality=95)
    print("✅ Đã tạo sơ đồ ERD 20 bảng:", out_path)

if __name__ == "__main__":
    create_architecture_diagram()
    create_business_flow_diagram()
    create_erd_diagram()
