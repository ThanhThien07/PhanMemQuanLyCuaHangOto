# -*- coding: utf-8 -*-
"""
Script sinh các sơ đồ kiến trúc, nghiệp vụ và use case chính xác 100% cho Showroom PrimeLux Auto.
Sử dụng thư viện PIL để vẽ hình ảnh chuẩn học thuật, độ phân giải cao (1400x800).
"""

import os
import sys
from PIL import Image, ImageDraw, ImageFont

sys.stdout.reconfigure(encoding='utf-8')

os.makedirs("docs/screenshots", exist_ok=True)

FONT_PATH = r"C:\Windows\Fonts\segoeui.ttf"
FONT_BOLD_PATH = r"C:\Windows\Fonts\segoeuib.ttf"

def get_font(size=16, bold=False):
    path = FONT_BOLD_PATH if bold else FONT_PATH
    if os.path.exists(path):
        return ImageFont.truetype(path, size)
    return ImageFont.load_default()

def draw_rounded_rect(draw, box, fill="#F8FAFC", outline="#000000", radius=8, width=2):
    draw.rounded_rectangle(box, radius=radius, fill=fill, outline=outline, width=width)

def draw_arrow(draw, start, end, fill="#000000", width=2):
    draw.line([start, end], fill=fill, width=width)
    x1, y1 = start
    x2, y2 = end
    import math
    angle = math.atan2(y2 - y1, x2 - x1)
    arrow_len = 10
    a1 = angle + math.pi * 5 / 6
    a2 = angle - math.pi * 5 / 6
    p1 = (x2 + arrow_len * math.cos(a1), y2 + arrow_len * math.sin(a1))
    p2 = (x2 + arrow_len * math.cos(a2), y2 + arrow_len * math.sin(a2))
    draw.polygon([end, p1, p2], fill=fill)

# =============================================================================
# 1. SƠ ĐỒ CHỨC NĂNG ADMIN
# =============================================================================
def make_admin_function_diagram():
    im = Image.new("RGB", (1400, 750), "#FFFFFF")
    d = ImageDraw.Draw(im)

    # Tiêu đề
    f_title = get_font(22, bold=True)
    f_header = get_font(18, bold=True)
    f_body = get_font(14, bold=False)
    f_sub = get_font(13, bold=False)

    d.text((700, 30), "SƠ ĐỒ PHÂN RÃ CHỨC NĂNG QUẢN TRỊ VIÊN (ADMIN PORTAL) - PRIMELUX AUTO", fill="#000000", font=f_title, anchor="mm")

    # Khối trung tâm
    draw_rounded_rect(d, (550, 70, 850, 130), fill="#E2E8F0", outline="#000000", width=2)
    d.text((700, 100), "QUẢN TRỊ VIÊN HỆ THỐNG\n(SUPER ADMIN)", fill="#000000", font=f_header, anchor="mm", align="center")

    # 4 Nhóm chức năng chính
    groups = [
        ("1. QUẢN LÝ KHO XE & KINH DOANH", [
            "- Quản lý danh mục phương tiện (CRUD xe)",
            "- Cập nhật ảnh, thông số kỹ thuật, tồn kho",
            "- Điều chỉnh giá niêm yết & khuyến mãi VIP",
            "- Kích hoạt quét giá thị trường 3 sàn ô tô"
        ], 60, 200, 360, 480),
        
        ("2. DUYỆT TRADE-IN & BẢO HÀNH", [
            "- Tiếp nhận hồ sơ Thu cũ đổi mới",
            "- Kiểm định kỹ thuật 176 hạng mục",
            "- Chốt giá thu mua xe cũ cấn trừ hóa đơn",
            "- Quản lý sổ bảo hành điện tử theo VIN"
        ], 390, 200, 690, 480),

        ("3. TÀI CHÍNH & VẬN HÀNH SHOWROOM", [
            "- Quản lý danh sách đơn hàng cọc xe",
            "- Đối soát giao dịch SePay VietQR",
            "- Điều phối lịch lái thử & phân công tư vấn",
            "- Quản lý tin tức bài viết và phản hồi"
        ], 720, 200, 1020, 480),

        ("4. BẢO MẬT & KINH DOANH THÔNG MINH", [
            "- Dashboard KPI & Phễu bán hàng (Sales Funnel)",
            "- Xuất báo cáo Excel/CSV (UTF-8 BOM)",
            "- Giám sát Nhật ký hệ thống (Audit Log)",
            "- Quản lý tài khoản, RBAC và 2FA TOTP"
        ], 1050, 200, 1350, 480)
    ]

    for title, items, x1, y1, x2, y2 in groups:
        draw_arrow(d, (700, 130), ((x1 + x2)//2, y1))
        draw_rounded_rect(d, (x1, y1, x2, y2), fill="#F8FAFC", outline="#000000", width=2)
        # Header nhóm
        draw_rounded_rect(d, (x1, y1, x2, y1 + 45), fill="#E2E8F0", outline="#000000", width=1)
        d.text(((x1 + x2)//2, y1 + 22), title, fill="#000000", font=get_font(13, bold=True), anchor="mm")
        
        # Nội dung
        cur_y = y1 + 60
        for it in items:
            d.text((x1 + 15, cur_y), it, fill="#000000", font=f_sub)
            cur_y += 50

    im.save("docs/screenshots/so_do_2_1_chuc_nang_admin.png", "PNG")
    print("Đã tạo so_do_2_1_chuc_nang_admin.png")

# =============================================================================
# 2. SƠ ĐỒ CHỨC NĂNG NHÂN VIÊN (TƯ VẤN & KẾ TOÁN)
# =============================================================================
def make_staff_function_diagram():
    im = Image.new("RGB", (1400, 700), "#FFFFFF")
    d = ImageDraw.Draw(im)

    f_title = get_font(22, bold=True)
    f_header = get_font(18, bold=True)
    f_sub = get_font(14, bold=False)

    d.text((700, 30), "SƠ ĐỒ PHÂN RÃ CHỨC NĂNG CHUYÊN VIÊN TƯ VẤN & KẾ TOÁN SHOWROOM", fill="#000000", font=f_title, anchor="mm")

    # Nhánh Tư vấn viên (Trái)
    draw_rounded_rect(d, (200, 80, 580, 140), fill="#E2E8F0", outline="#000000", width=2)
    d.text((390, 110), "CHUYÊN VIÊN TƯ VẤN & BÁN HÀNG", fill="#000000", font=f_header, anchor="mm")

    tv_items = [
        ("Tiếp nhận lịch hẹn lái thử", "Xem thông tin khách hàng, địa điểm lái thử, chuẩn bị xe trải nghiệm"),
        ("Tư vấn trực tuyến realtime qua SSE", "Tiếp quản cuộc hội thoại chuyển giao từ Trợ lý ảo AI LLM"),
        ("Tư vấn gói tài chính & Lăn bánh", "Bóc tách biểu phí trước bạ, biển số và lập bảng vay trả góp ngân hàng"),
        ("Hỗ trợ hoàn tất đơn cọc xe", "Hướng dẫn khách quét mã VietQR SePay, theo dõi hợp đồng cọc")
    ]
    cur_y = 180
    for title, desc in tv_items:
        draw_arrow(d, (390, 140 if cur_y == 180 else cur_y - 20), (390, cur_y))
        draw_rounded_rect(d, (100, cur_y, 680, cur_y + 80), fill="#F8FAFC", outline="#000000", width=2)
        d.text((120, cur_y + 20), title, fill="#000000", font=get_font(15, bold=True))
        d.text((120, cur_y + 48), desc, fill="#000000", font=f_sub)
        cur_y += 115

    # Nhánh Kế toán (Phải)
    draw_rounded_rect(d, (820, 80, 1200, 140), fill="#E2E8F0", outline="#000000", width=2)
    d.text((1010, 110), "KẾ TOÁN SHOWROOM PRIMELUX", fill="#000000", font=f_header, anchor="mm")

    kt_items = [
        ("Đối soát giao dịch ngân hàng SePay", "Kiểm tra mã biến động số dư, xác thực Webhook HMAC-SHA256"),
        ("Xác nhận tiền đặt cọc giữ xe", "Đối chiếu cú pháp đơn hàng cọc xe và khóa tình trạng xe trong kho"),
        ("Cấn trừ giá trị Thu cũ đổi mới", "Trừ trực tiếp số tiền thu mua xe cũ Trade-In vào hóa đơn xe mới"),
        ("Xuất báo cáo tài chính & Hóa đơn", "Trích xuất danh sách doanh thu ra tệp Excel/CSV UTF-8 BOM")
    ]
    cur_y = 180
    for title, desc in kt_items:
        draw_arrow(d, (1010, 140 if cur_y == 180 else cur_y - 20), (1010, cur_y))
        draw_rounded_rect(d, (720, cur_y, 1300, cur_y + 80), fill="#F8FAFC", outline="#000000", width=2)
        d.text((740, cur_y + 20), title, fill="#000000", font=get_font(15, bold=True))
        d.text((740, cur_y + 48), desc, fill="#000000", font=f_sub)
        cur_y += 115

    im.save("docs/screenshots/so_do_2_2_chuc_nang_nhan_vien.png", "PNG")
    print("Đã tạo so_do_2_2_chuc_nang_nhan_vien.png")

# =============================================================================
# 3. SƠ ĐỒ CHỨC NĂNG KHÁCH HÀNG
# =============================================================================
def make_customer_function_diagram():
    im = Image.new("RGB", (1400, 750), "#FFFFFF")
    d = ImageDraw.Draw(im)

    f_title = get_font(22, bold=True)
    f_header = get_font(18, bold=True)
    f_sub = get_font(13, bold=False)

    d.text((700, 30), "SƠ ĐỒ PHÂN RÃ CHỨC NĂNG CỔNG KHÁCH HÀNG (CUSTOMER PORTAL) - PRIMELUX AUTO", fill="#000000", font=f_title, anchor="mm")

    # Khối trung tâm
    draw_rounded_rect(d, (520, 70, 880, 130), fill="#E2E8F0", outline="#000000", width=2)
    d.text((700, 100), "KHÁCH HÀNG SHOWROOM\n(VÃNG LAI & HỘI VIÊN VIP)", fill="#000000", font=f_header, anchor="mm", align="center")

    groups = [
        ("1. KHÁM PHÁ & SO SÁNH XE", [
            "- Tìm kiếm và lọc xe đa tiêu chí",
            "- Xem chi tiết thông số xe & ảnh góc rộng",
            "- So sánh thông số kỹ thuật giữa các xe",
            "- Xem biểu đồ biến động giá 6 tháng"
        ], 60, 200, 360, 480),

        ("2. CÔNG CỤ TÀI CHÍNH & CỌC SEPAY", [
            "- Dự toán chi phí lăn bánh theo tỉnh thành",
            "- Bảng tính vay trả góp dư nợ giảm dần",
            "- Đặt cọc giữ xe trực tuyến 24/7",
            "- Quét mã VietQR SePay xác nhận tức thời"
        ], 390, 200, 690, 480),

        ("3. LÁI THỬ & THU CŨ ĐỔI MỚI", [
            "- Đăng ký lịch lái thử xe tại showroom/nhà",
            "- Nhận thông báo tự động Zalo/SMS/Email",
            "- Định giá xe cũ sơ bộ tự động theo ODO",
            "- Nộp hồ sơ Trade-In nâng cấp lên xe mới"
        ], 720, 200, 1020, 480),

        ("4. DỊCH VỤ VIN & HỘI VIÊN VIP", [
            "- Tra cứu sổ bảo hành điện tử theo số VIN",
            "- Xem lịch sử bảo dưỡng và đặt hẹn xưởng",
            "- Tra cứu tích điểm thành viên PrimeLux Club",
            "- Tư vấn thông minh 24/7 cùng Trợ lý ảo AI"
        ], 1050, 200, 1350, 480)
    ]

    for title, items, x1, y1, x2, y2 in groups:
        draw_arrow(d, (700, 130), ((x1 + x2)//2, y1))
        draw_rounded_rect(d, (x1, y1, x2, y2), fill="#F8FAFC", outline="#000000", width=2)
        draw_rounded_rect(d, (x1, y1, x2, y1 + 45), fill="#E2E8F0", outline="#000000", width=1)
        d.text(((x1 + x2)//2, y1 + 22), title, fill="#000000", font=get_font(13, bold=True), anchor="mm")
        cur_y = y1 + 60
        for it in items:
            d.text((x1 + 15, cur_y), it, fill="#000000", font=f_sub)
            cur_y += 50

    im.save("docs/screenshots/so_do_2_3_chuc_nang_khach_hang.png", "PNG")
    print("Đã tạo so_do_2_3_chuc_nang_khach_hang.png")

# =============================================================================
# 4. LƯỢC ĐỒ USE CASE TỔNG QUÁT PRIMELUX AUTO
# =============================================================================
def make_use_case_diagram():
    im = Image.new("RGB", (1400, 850), "#FFFFFF")
    d = ImageDraw.Draw(im)

    d.text((700, 30), "LƯỢC ĐỒ USE CASE TỔNG QUÁT TOÀN HỆ THỐNG PRIMELUX AUTO", fill="#000000", font=get_font(22, bold=True), anchor="mm")

    # Khung ranh giới hệ thống (System Boundary)
    draw_rounded_rect(d, (300, 70, 1100, 810), fill="#FAFAFA", outline="#000000", width=2)
    d.text((700, 95), "HỆ THỐNG QUẢN LÝ SHOWROOM Ô TÔ PRIMELUX AUTO", fill="#000000", font=get_font(16, bold=True), anchor="mm")

    # Actor Khách hàng (Trái)
    draw_rounded_rect(d, (50, 250, 230, 350), fill="#E2E8F0", outline="#000000", width=2)
    d.text((140, 290), "KHÁCH HÀNG\n(GUEST & VIP)", fill="#000000", font=get_font(16, bold=True), anchor="mm", align="center")

    # Actor Nhân viên & Quản trị (Phải)
    draw_rounded_rect(d, (1170, 160, 1350, 250), fill="#E2E8F0", outline="#000000", width=2)
    d.text((1260, 205), "TƯ VẤN VIÊN\n(SALES)", fill="#000000", font=get_font(15, bold=True), anchor="mm", align="center")

    draw_rounded_rect(d, (1170, 360, 1350, 450), fill="#E2E8F0", outline="#000000", width=2)
    d.text((1260, 405), "KẾ TOÁN\n(ACCOUNTANT)", fill="#000000", font=get_font(15, bold=True), anchor="mm", align="center")

    draw_rounded_rect(d, (1170, 580, 1350, 680), fill="#E2E8F0", outline="#000000", width=2)
    d.text((1260, 630), "QUẢN TRỊ VIÊN\n(SUPER ADMIN)", fill="#000000", font=get_font(15, bold=True), anchor="mm", align="center")

    # Danh sách Use Case hình elip bên trong hệ thống
    use_cases = [
        ("UC01: Tra cứu, lọc xe & xem chi tiết", 140),
        ("UC02: Dự toán lăn bánh & Trả góp ngân hàng", 205),
        ("UC03: Đặt cọc trực tuyến SePay VietQR", 270),
        ("UC04: Đăng ký lái thử & Thông báo đa kênh", 335),
        ("UC05: Định giá xe cũ & Nộp hồ sơ Trade-In", 400),
        ("UC06: Tra cứu sổ bảo hành điện tử theo VIN", 465),
        ("UC07: Tư vấn trực tuyến cùng Trợ lý ảo AI", 530),
        ("UC08: Tiếp nhận lái thử & Chat realtime SSE", 595),
        ("UC09: Đối soát SePay & Quản lý đơn cọc", 660),
        ("UC10: Quản lý kho xe, Quét giá thị trường & Audit Log", 725),
        ("UC11: Thẩm định 176 hạng mục Trade-In & Xuất BI", 780)
    ]

    for name, y in use_cases:
        draw_rounded_rect(d, (400, y - 22, 1000, y + 22), fill="#FFFFFF", outline="#000000", radius=18, width=1)
        d.text((700, y), name, fill="#000000", font=get_font(13, bold=True), anchor="mm")

    # Nối đường tương tác Khách hàng
    for y in [140, 205, 270, 335, 400, 465, 530]:
        d.line([(230, 300), (400, y)], fill="#000000", width=1)

    # Nối đường tương tác Tư vấn viên
    for y in [335, 530, 595]:
        d.line([(1170, 205), (1000, y)], fill="#000000", width=1)

    # Nối đường tương tác Kế toán
    for y in [270, 660]:
        d.line([(1170, 405), (1000, y)], fill="#000000", width=1)

    # Nối đường tương tác Admin
    for y in [725, 780, 660]:
        d.line([(1170, 630), (1000, y)], fill="#000000", width=1)

    im.save("docs/screenshots/luoc_do_2_1_use_case_tong_quat.png", "PNG")
    print("Đã tạo luoc_do_2_1_use_case_tong_quat.png")

# =============================================================================
# 5. LƯỢC ĐỒ HOẠT ĐỘNG THANH TOÁN SEPAY
# =============================================================================
def make_activity_sepay_diagram():
    im = Image.new("RGB", (1400, 600), "#FFFFFF")
    d = ImageDraw.Draw(im)

    d.text((700, 30), "LƯỢC ĐỒ HOẠT ĐỘNG (ACTIVITY DIAGRAM) - ĐẶT CỌC SEPAY VIETQR", fill="#000000", font=get_font(22, bold=True), anchor="mm")

    steps = [
        ("Khách hàng nhấn\n'Đặt cọc trực tuyến'", 100),
        ("Hệ thống tạo đơn cọc\nTrạng thái 'pending'", 340),
        ("Sinh mã VietQR SePay\nChứa mã cọc độc nhất", 580),
        ("Khách quét mã qua\nApp Ngân hàng", 820),
        ("SePay gửi Webhook\nHMAC-SHA256 về Server", 1060),
        ("Chuyển trạng thái 'paid'\nKhóa xe & Gửi Email", 1300)
    ]

    for title, center_x in steps:
        draw_rounded_rect(d, (center_x - 90, 240, center_x + 90, 340), fill="#F8FAFC", outline="#000000", radius=10, width=2)
        d.text((center_x, 290), title, fill="#000000", font=get_font(13, bold=True), anchor="mm", align="center")

    # Vẽ mũi tên tuần tự
    for i in range(len(steps) - 1):
        x_from = steps[i][1] + 90
        x_to = steps[i+1][1] - 90
        draw_arrow(d, (x_from, 290), (x_to, 290))

    im.save("docs/screenshots/luoc_do_2_2_activity_sepay.png", "PNG")
    print("Đã tạo luoc_do_2_2_activity_sepay.png")

# =============================================================================
# 6. LƯỢC ĐỒ HOẠT ĐỘNG TRADE-IN
# =============================================================================
def make_activity_tradein_diagram():
    im = Image.new("RGB", (1400, 600), "#FFFFFF")
    d = ImageDraw.Draw(im)

    d.text((700, 30), "LƯỢC ĐỒ HOẠT ĐỘNG (ACTIVITY DIAGRAM) - THU CŨ ĐỔI MỚI (TRADE-IN)", fill="#000000", font=get_font(22, bold=True), anchor="mm")

    steps = [
        ("Khách nhập thông tin xe cũ\nHãng, Đời, ODO, Tình trạng", 100),
        ("Công cụ tính giá sơ bộ\nƯớc tính mức khấu hao", 340),
        ("Nộp hồ sơ Trade-In\nKèm ảnh chụp xe thực tế", 580),
        ("Kỹ thuật viên showroom\nKiểm định 176 hạng mục", 820),
        ("Quản trị duyệt giá chốt\nGửi thông báo cho khách", 1060),
        ("Khấu trừ tiền thu mua xe\nVào hóa đơn nhận xe mới", 1300)
    ]

    for title, center_x in steps:
        draw_rounded_rect(d, (center_x - 95, 240, center_x + 95, 340), fill="#F8FAFC", outline="#000000", radius=10, width=2)
        d.text((center_x, 290), title, fill="#000000", font=get_font(13, bold=True), anchor="mm", align="center")

    for i in range(len(steps) - 1):
        x_from = steps[i][1] + 95
        x_to = steps[i+1][1] - 95
        draw_arrow(d, (x_from, 290), (x_to, 290))

    im.save("docs/screenshots/luoc_do_2_3_activity_tradein.png", "PNG")
    print("Đã tạo luoc_do_2_3_activity_tradein.png")

# =============================================================================
# 7. BIỂU ĐỒ TRIỂN KHAI HẠ TẦNG (DEPLOYMENT DIAGRAM)
# =============================================================================
def make_deployment_diagram():
    im = Image.new("RGB", (1400, 700), "#FFFFFF")
    d = ImageDraw.Draw(im)

    d.text((700, 30), "BIỂU ĐỒ TRIỂN KHAI HẠ TẦNG HỆ THỐNG (DEPLOYMENT DIAGRAM) - PRIMELUX AUTO", fill="#000000", font=get_font(22, bold=True), anchor="mm")

    # 1. Client Node
    draw_rounded_rect(d, (80, 160, 380, 520), fill="#F8FAFC", outline="#000000", width=2)
    draw_rounded_rect(d, (80, 160, 380, 210), fill="#E2E8F0", outline="#000000", width=1)
    d.text((230, 185), "<<device>> Client Tier\n(Desktop / Smartphone)", fill="#000000", font=get_font(14, bold=True), anchor="mm", align="center")
    d.text((100, 240), "- Trình duyệt web hiện đại\n  (Chrome, Edge, Safari, Firefox)\n- Hỗ trợ HTML5 / CSS3 / ES6\n- Responsive Viewport\n- Quét mã VietQR trên App Ngân hàng", fill="#000000", font=get_font(13))

    # 2. Web & App Server Node
    draw_rounded_rect(d, (500, 120, 900, 580), fill="#F8FAFC", outline="#000000", width=2)
    draw_rounded_rect(d, (500, 120, 900, 170), fill="#E2E8F0", outline="#000000", width=1)
    d.text((700, 145), "<<server>> Application Server Tier\n(Nginx + PHP 8.3-FPM)", fill="#000000", font=get_font(14, bold=True), anchor="mm", align="center")
    d.text((520, 200), "- Web Server: Nginx 1.24 / Apache 2.4\n- PHP Engine: PHP 8.3 (JIT Enabled)\n- Laravel 12 Framework MVC Core\n- AiConsultantService (RAG Engine)\n- NotificationService (Zalo, SMS, Mail)\n- ScraperCommand (Cronjob 06:00 AM)\n- Middleware: RBAC, CSRF, Throttle", fill="#000000", font=get_font(13))

    # 3. Database Node
    draw_rounded_rect(d, (1020, 160, 1320, 520), fill="#F8FAFC", outline="#000000", width=2)
    draw_rounded_rect(d, (1020, 160, 1320, 210), fill="#E2E8F0", outline="#000000", width=1)
    d.text((1170, 185), "<<database>> Data Server Tier\n(MySQL 8.0 Community)", fill="#000000", font=get_font(14, bold=True), anchor="mm", align="center")
    d.text((1040, 240), "- Hệ quản trị CSDL MySQL 8.0\n- 16 bảng dữ liệu chuẩn hóa 3NF\n- Chuẩn hóa ACID Transactions\n- Bảng orders, cars, users, audit_logs\n- Sao lưu dữ liệu tự động hàng ngày", fill="#000000", font=get_font(13))

    # Nối mạng
    draw_arrow(d, (380, 340), (500, 340))
    d.text((440, 320), "HTTPS / WSS", fill="#000000", font=get_font(12, bold=True), anchor="mm")

    draw_arrow(d, (900, 340), (1020, 340))
    d.text((960, 320), "TCP : 3306", fill="#000000", font=get_font(12, bold=True), anchor="mm")

    im.save("docs/screenshots/bieu_do_2_2_trien_khai.png", "PNG")
    print("Đã tạo bieu_do_2_2_trien_khai.png")

if __name__ == "__main__":
    make_admin_function_diagram()
    make_staff_function_diagram()
    make_customer_function_diagram()
    make_use_case_diagram()
    make_activity_sepay_diagram()
    make_activity_tradein_diagram()
    make_deployment_diagram()
    print("✅ ĐÃ SINH TOÀN BỘ 7 SƠ ĐỒ CHÍNH XÁC 100% CHO PRIMELUX AUTO!")
