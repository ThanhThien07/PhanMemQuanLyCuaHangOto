import os
import sys
import subprocess
import time

sys.stdout.reconfigure(encoding='utf-8')

chrome_path = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
base_url = "http://phanmemquanlycuahangoto.test"

# Tạo các thư mục lưu ảnh
dirs = [
    os.path.join("tai_lieu_bao_cao_doc", "screenshots"),
    os.path.join("docs", "screenshots")
]
for d in dirs:
    os.makedirs(d, exist_ok=True)

pages = [
    ("hinh_3_1_trang_chu.png", "/", "Trang chủ Showroom PrimeLux Auto"),
    ("hinh_3_2_danh_muc_xe.png", "/xe", "Danh mục kho xe và Bộ lọc đa tiêu chí"),
    ("hinh_3_3_chi_tiet_xe.png", "/xe/1", "Chi tiết xe sang và Thông số kỹ thuật chuyên sâu"),
    ("hinh_3_4_so_sanh_gia.png", "/sosanh", "Công cụ So sánh giá xe đa sàn thị trường"),
    ("hinh_3_5_dang_ky_lai_thu.png", "/laithu", "Cổng Đăng ký lái thử xe VIP trực tuyến"),
    ("hinh_3_6_tra_cuu_hoa_don.png", "/hoadon", "Cổng Tra cứu hóa đơn & Chi tiết thanh toán"),
    ("hinh_3_7_primelux_club.png", "/tichdiem", "Cổng Hội viên PrimeLux Club & Tra cứu tích điểm VIP"),
    ("hinh_3_8_ban_tu_van_sse.png", "/tuvanvien", "Bàn Chuyên viên tư vấn & Nhận tin realtime qua SSE"),
    ("hinh_3_9_dashboard_admin.png", "/quantri", "Dashboard Quản trị viên (Admin Portal) điều hành"),
    ("hinh_3_10_dang_nhap.png", "/dangnhap", "Màn hình Đăng nhập hệ thống đa vai trò"),
]

print("=== BẮT ĐẦU CHỤP ẢNH GIAO DIỆN HỆ THỐNG ===")
success_count = 0

for filename, path, desc in pages:
    url = f"{base_url}{path}"
    out1 = os.path.abspath(os.path.join("tai_lieu_bao_cao_doc", "screenshots", filename))
    out2 = os.path.abspath(os.path.join("docs", "screenshots", filename))
    
    cmd = f'cmd.exe /c "\"{chrome_path}\" --headless=new --disable-gpu --window-size=1366,768 --screenshot=\"{out1}\" {url}"'
    
    try:
        res = subprocess.run(cmd, shell=True, capture_output=True, timeout=20)
        time.sleep(1) # Chờ ghi đĩa hoàn tất
        
        if os.path.exists(out1) and os.path.getsize(out1) > 1000:
            # Sao chép sang docs/screenshots/
            with open(out1, 'rb') as f_in, open(out2, 'wb') as f_out:
                f_out.write(f_in.read())
            size_kb = os.path.getsize(out1) // 1024
            print(f"[OK] {filename} ({size_kb} KB) -> {desc}")
            success_count += 1
        else:
            print(f"[FAIL] Không tạo được {filename}")
    except Exception as e:
        print(f"[ERROR] {filename}: {str(e)}")

print(f"\n=== HOÀN TẤT: Đã chụp thành công {success_count}/{len(pages)} màn hình giao diện! ===")
