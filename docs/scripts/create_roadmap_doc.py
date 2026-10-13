import os
import sys
import shutil
import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_ALIGN_VERTICAL
from docx.oxml import parse_xml
from docx.oxml.ns import nsdecls

sys.stdout.reconfigure(encoding='utf-8')

def create_roadmap_document():
    doc = docx.Document()

    # 1. Page Margins - Standard A4 (Left 3.0cm, Right 2.0cm, Top 2.0cm, Bottom 2.0cm)
    for section in doc.sections:
        section.page_width = Inches(8.27)
        section.page_height = Inches(11.69)
        section.top_margin = Inches(0.79)    # 2.0 cm
        section.bottom_margin = Inches(0.79) # 2.0 cm
        section.left_margin = Inches(1.18)   # 3.0 cm
        section.right_margin = Inches(0.79)  # 2.0 cm

    # 2. Base Style
    normal = doc.styles['Normal']
    normal.font.name = 'Times New Roman'
    normal.font.size = Pt(12)
    normal.font.color.rgb = RGBColor(30, 41, 59) # Slate 800
    normal.paragraph_format.line_spacing = 1.25
    normal.paragraph_format.space_after = Pt(4)

    # 3. Helper Functions
    def set_cell_shading(cell, color_hex):
        tcPr = cell._tc.get_or_add_tcPr()
        shd = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{color_hex}"/>')
        tcPr.append(shd)

    def set_cell_margins(cell, top=140, bottom=140, left=180, right=180):
        tcPr = cell._tc.get_or_add_tcPr()
        tcMar = parse_xml(
            f'<w:tcMar {nsdecls("w")}>\n'
            f'  <w:top w:w="{top}" w:type="dxa"/>\n'
            f'  <w:bottom w:w="{bottom}" w:type="dxa"/>\n'
            f'  <w:left w:w="{left}" w:type="dxa"/>\n'
            f'  <w:right w:w="{right}" w:type="dxa"/>\n'
            f'</w:tcMar>'
        )
        tcPr.append(tcMar)

    def set_cell_borders(cell, color="CBD5E1", sz="4", val="single"):
        tcPr = cell._tc.get_or_add_tcPr()
        tcBorders = parse_xml(
            f'<w:tcBorders {nsdecls("w")}>\n'
            f'  <w:top w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>\n'
            f'  <w:left w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>\n'
            f'  <w:bottom w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>\n'
            f'  <w:right w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>\n'
            f'</w:tcBorders>'
        )
        tcPr.append(tcBorders)

    def add_title(text):
        p = doc.add_paragraph()
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        p.paragraph_format.space_before = Pt(6)
        p.paragraph_format.space_after = Pt(4)
        run = p.add_run(text)
        run.bold = True
        run.font.size = Pt(16)
        run.font.name = 'Times New Roman'
        run.font.color.rgb = RGBColor(15, 23, 42)

    def add_subtitle(text):
        p = doc.add_paragraph()
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        p.paragraph_format.space_before = Pt(0)
        p.paragraph_format.space_after = Pt(14)
        run = p.add_run(text)
        run.bold = True
        run.font.size = Pt(13)
        run.font.name = 'Times New Roman'
        run.font.color.rgb = RGBColor(30, 58, 138)

    def add_heading1(text):
        p = doc.add_paragraph()
        p.paragraph_format.space_before = Pt(14)
        p.paragraph_format.space_after = Pt(6)
        run = p.add_run(text)
        run.bold = True
        run.font.size = Pt(13.5)
        run.font.name = 'Times New Roman'
        run.font.color.rgb = RGBColor(15, 23, 42)

    def add_p(text, italic=False):
        p = doc.add_paragraph()
        p.paragraph_format.space_after = Pt(6)
        run = p.add_run(text)
        run.font.size = Pt(12)
        run.font.name = 'Times New Roman'
        run.italic = italic

    # --- Header Information ---
    add_title("BỘ TÀI LIỆU PHÂN TÍCH & ĐỊNH HƯỚNG PHÁT TRIỂN HỆ THỐNG")
    add_subtitle("HỆ THỐNG QUẢN LÝ CỬA HÀNG Ô TÔ PRIMELUX AUTO")

    info_box = doc.add_paragraph()
    info_box.paragraph_format.space_before = Pt(4)
    info_box.paragraph_format.space_after = Pt(12)
    r1 = info_box.add_run("Phạm vi & Cơ sở thực hiện: ")
    r1.bold = True
    r2 = info_box.add_run("Tài liệu xác định đúng 9 chức năng trọng tâm cần thiết nhất dựa trên phạm vi hiện tại của website PrimeLux Auto (Laravel, Blade, MySQL/SQLite). Lộ trình phát triển được tinh chỉnh tính theo ")
    r3 = info_box.add_run("NGÀY")
    r3.bold = True
    r4 = info_box.add_run(" nhờ có sự hỗ trợ trực tiếp từ các công cụ Lập trình Trí tuệ Nhân tạo (AI Coding Assistant - Antigravity/Cursor/GitHub Copilot).\n")
    r5 = info_box.add_run("Quy cách cấu trúc: ")
    r5.bold = True
    r6 = info_box.add_run("Bảng danh mục 2 cột gồm ")
    r7 = info_box.add_run("Chức năng")
    r7.bold = True
    r8 = info_box.add_run(" và ")
    r9 = info_box.add_run("Mô tả chi tiết chức năng")
    r9.bold = True
    r10 = info_box.add_run(", kèm theo Bảng kế hoạch tiến độ theo ngày chi tiết.")

    add_heading1("I. BẢNG DANH MỤC 9 CHỨC NĂNG CẦN THIẾT NHẤT (BẢNG 2 CỘT)")
    add_p("Toàn bộ 9 chức năng dưới đây đều được lựa chọn theo nguyên tắc bám sát 100% các trang và controller hiện có của hệ thống (Kho xe, Lái thử, So sánh giá, Hóa đơn, Điểm VIP, Tư vấn SSE và Dashboard Quản trị):")

    # Table 2 columns
    table = doc.add_table(rows=1, cols=2)
    table.alignment = WD_TABLE_ALIGNMENT.CENTER
    table.autofit = False

    # Header Row
    hdr_cells = table.rows[0].cells
    hdr_cells[0].width = Inches(1.9)
    hdr_cells[1].width = Inches(4.4)

    hdr_cells[0].paragraphs[0].text = "Chức năng"
    hdr_cells[1].paragraphs[0].text = "Mô tả chi tiết chức năng"

    for cell in hdr_cells:
        set_cell_shading(cell, "1E3A8A") # Navy Blue
        set_cell_margins(cell, top=160, bottom=160, left=180, right=180)
        set_cell_borders(cell, color="172554", sz="6")
        cell.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
        for p in cell.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.CENTER
            for r in p.runs:
                r.font.name = 'Times New Roman'
                r.font.size = Pt(12)
                r.font.color.rgb = RGBColor(255, 255, 255)
                r.bold = True

    # 9 Features (Discarded #3 and #10)
    features = [
        (
            "1. Dự toán chi phí lăn bánh & Bảng tính vay trả góp ngân hàng\n(On-Road Cost & Loan Calculator)",
            [
                ("Vị trí tích hợp: ", "Tích hợp trực tiếp trên trang Chi tiết xe (/cars/{id} và /xe/{id})."),
                ("Mục tiêu & Nghiệp vụ: ", "Hỗ trợ người mua xe tính toán tức thì toàn bộ chi phí thực tế theo quy định đăng ký của từng địa phương và lập kế hoạch vay trả góp phù hợp với ngân sách."),
                ("Quy trình hoạt động: ", 
                 "• Tính chi phí lăn bánh: Khách hàng chọn tỉnh/thành phố đăng ký biển số (Hà Nội, TP.HCM, các tỉnh khác). Hệ thống tự động áp dụng biểu thuế, phí: Lệ phí trước bạ (10% - 12%), lệ phí cấp biển số (20 triệu tại HN/HCM, 1 triệu tại tỉnh), phí đăng kiểm, phí bảo trì đường bộ 1 năm, bảo hiểm TNDS bắt buộc và bảo hiểm thân vỏ xe.\n"
                 "• Tính toán trả góp vay ngân hàng: Khách hàng kéo thanh chọn số tiền trả trước (20% - 80%), thời gian vay (1 - 8 năm), lãi suất ưu đãi năm đầu và biên độ các năm tiếp theo. Hệ thống tự động sinh bảng tiến độ trả nợ chi tiết (gốc + lãi) theo dư nợ giảm dần hoặc dư nợ gốc đều.\n"
                 "• Nút kêu gọi hành động: Khách hàng có thể nhấn 'Gửi hồ sơ thẩm định vay' để tư vấn viên tài chính liên hệ hỗ trợ."),
                ("Giá trị mang lại: ", "Minh bạch tài chính, giải tỏa tâm lý đắn đo của người mua, tăng tỷ lệ chuyển đổi từ xem xe sang đăng ký lái thử hoặc mua xe.")
            ]
        ),
        (
            "2. Đặt cọc giữ xe trực tuyến & Tích hợp cổng thanh toán\n(Online Car Reservation & Payment Gateway)",
            [
                ("Vị trí tích hợp: ", "Mở rộng từ trang Chi tiết xe và Tra cứu hóa đơn (/invoices, /hoadon)."),
                ("Mục tiêu & Nghiệp vụ: ", "Cho phép khách hàng thực hiện đặt cọc giữ chỗ chiếc xe ưng ý ngay trên website 24/7 mà không sợ người khác mua mất."),
                ("Quy trình hoạt động: ",
                 "• Khách hàng chọn xe, tùy chọn màu sắc và showroom nhận xe, sau đó chọn mức đặt cọc tiêu chuẩn (ví dụ: 20.000.000 VNĐ - 50.000.000 VNĐ).\n"
                 "• Kết nối trực tiếp cổng thanh toán trực tuyến bảo mật chuẩn PCI-DSS (VNPAY-QR, MoMo, ZaloPay, Thẻ ATM nội địa, Visa/Mastercard).\n"
                 "• Sau khi thanh toán thành công qua IPN/Webhook: Hệ thống tự động đổi trạng thái chiếc xe trong cơ sở dữ liệu sang 'Đã đặt cọc' trong thời hạn giữ chỗ quy định (48h - 72h) để tránh bán trùng lặp cho khách khác.\n"
                 "• Tự động tạo bản thỏa thuận đặt cọc điện tử định dạng PDF có mã QR xác thực và gửi về Email/SMS của khách hàng."),
                ("Giá trị mang lại: ", "Khép kín chu trình bán hàng từ online đến offline, giảm tỷ lệ khách hàng đổi ý, số hóa nghiệp vụ thu cọc của showroom.")
            ]
        ),
        (
            "3. Tự động hóa quét dữ liệu giá thị trường thực tế\n(Automated Market Price Scraper & Analytics)",
            [
                ("Vị trí tích hợp: ", "Nâng cấp toàn diện trang So sánh giá xe (/compare, /sosanh, /cars/{id}/compare)."),
                ("Mục tiêu & Nghiệp vụ: ", "Thay thế dữ liệu giá so sánh tĩnh/mô phỏng hiện tại bằng luồng dữ liệu giá thực tế được thu thập tự động từ các sàn thương mại điện tử ô tô lớn nhất Việt Nam."),
                ("Quy trình hoạt động: ",
                 "• Xây dựng bộ thu thập dữ liệu (Web Scraper) bằng Python (Scrapy/Playwright) chạy định kỳ qua Cronjob (mỗi 4 - 6 giờ/lần).\n"
                 "• Tự động quét và trích xuất dữ liệu giá xe, năm sản xuất, phiên bản động cơ từ 3 sàn lớn: Oto.com.vn, Bonbanh.com, Chotot Xe.\n"
                 "• Chuẩn hóa dữ liệu, loại bỏ tin ảo/tin rác, lưu trữ dữ liệu lịch sử giá vào database.\n"
                 "• Hiển thị biểu đồ lịch sử biến động giá xe trong 3 - 6 tháng gần nhất trên giao diện so sánh để người mua thấy rõ mức độ cạnh tranh của giá xe tại PrimeLux Auto.\n"
                 "• Cảnh báo cho Admin khi có biến động giảm giá đột biến của đối thủ trên thị trường."),
                ("Giá trị mang lại: ", "Tạo niềm tin vững chắc cho khách hàng về chính sách giá công khai minh bạch, giúp ban giám đốc có cơ sở điều chỉnh giá bán kịp thời.")
            ]
        ),
        (
            "4. Trợ lý ảo AI tư vấn tự động 24/7 tích hợp LLM\n(LLM-Powered Smart AI Sales Assistant)",
            [
                ("Vị trí tích hợp: ", "Nâng cấp module Tư vấn trực tuyến (/consultant, /tuvanvien) và Widget Chat trên toàn bộ website."),
                ("Mục tiêu & Nghiệp vụ: ", "Giải đáp tự động tức thì các câu hỏi của khách hàng mọi lúc, mọi nơi; giảm tải công việc trực bàn cho chuyên viên tư vấn."),
                ("Quy trình hoạt động: ",
                 "• Tích hợp mô hình AI ngôn ngữ lớn (OpenAI GPT-4o / Claude / DeepSeek) được huấn luyện chuyên sâu (RAG - Retrieval-Augmented Generation) trên dữ liệu nội bộ của PrimeLux: Danh mục thông số kỹ thuật xe, giá bán, bảng so sánh ưu nhược điểm, chính sách bảo hành, ưu đãi hội viên VIP.\n"
                 "• AI có khả năng hiểu câu hỏi tự nhiên bằng tiếng Việt, tư vấn dòng xe phù hợp với ngân sách gia đình, so sánh sự khác nhau giữa các phiên bản xe.\n"
                 "• Khi khách hàng yêu cầu gặp chuyên viên hoặc hỏi câu hỏi đàm phán hợp đồng, AI tự động chuyển cuộc hội thoại sang giao diện Tư vấn viên (Advisor Desk) qua luồng SSE (Server-Sent Events) hiện có, kèm tóm tắt nhu cầu khách hàng.\n"
                 "• Tự động trích xuất thông tin khách hàng (tên, số điện thoại, mẫu xe quan tâm) để tạo dữ liệu khách hàng tiềm năng (Lead) vào hệ thống."),
                ("Giá trị mang lại: ", "Phục vụ khách hàng 24/7 không có độ trễ, tăng tỷ lệ thu thập thông tin khách hàng tiềm năng lên hơn 40%.")
            ]
        ),
        (
            "5. Gửi thông báo tự động đa kênh qua Zalo ZNS, SMS & Email\n(Automated Multi-Channel Notification)",
            [
                ("Vị trí tích hợp: ", "Bổ sung cho Đặt lịch lái thử (/test-drive), Tra cứu hóa đơn (/invoices) và Hội viên VIP (/loyalty)."),
                ("Mục tiêu & Nghiệp vụ: ", "Tự động hóa kênh giao tiếp tương tác với khách hàng, loại bỏ việc nhân viên phải gọi điện thoại/gửi tin nhắn thủ công."),
                ("Quy trình hoạt động: ",
                 "• Thông báo lịch lái thử: Sau khi khách đăng ký lái thử thành công, hệ thống tự động gửi tin nhắn Zalo ZNS (có tích vàng PrimeLux) hoặc SMS xác nhận kèm địa chỉ showroom và đường link Google Maps. Gửi tin nhắn nhắc nhở tự động trước giờ hẹn lái thử 2 tiếng.\n"
                 "• Thông báo thăng hạng điểm thưởng VIP: Gửi tin nhắn chúc mừng khi khách hàng đạt đủ điểm lên hạng Vàng, Bạch Kim, Kim Cương kèm mã voucher ưu đãi riêng.\n"
                 "• Gửi hóa đơn & giấy tờ: Tự động gửi hóa đơn điện tử, phiếu thu tiền cọc và lịch nhắc bảo dưỡng định kỳ qua Email."),
                ("Giá trị mang lại: ", "Nâng tầm tính chuyên nghiệp của showroom chuẩn quốc tế, tỷ lệ khách hàng đến tham gia lái thử đúng hẹn tăng rõ rệt.")
            ]
        ),
        (
            "6. Đặt lịch bảo dưỡng & Sổ bảo hành điện tử theo số khung VIN\n(Service Booking & E-Warranty History by VIN)",
            [
                ("Vị trí tích hợp: ", "Mở rộng phân hệ Dịch vụ sau bán hàng (After-Sales Portal) và Trang Hội viên VIP (/loyalty)."),
                ("Mục tiêu & Nghiệp vụ: ", "Đáp ứng trọn vẹn nghiệp vụ xưởng dịch vụ - nguồn doanh thu bền vững của showroom ô tô sang sau khi giao xe."),
                ("Quy trình hoạt động: ",
                 "• Đặt lịch dịch vụ: Khách hàng nhập biển số xe/số khung (VIN), chọn gói bảo dưỡng (5.000km, 10.000km, 20.000km...), chọn ngày giờ và showroom dịch vụ mong muốn.\n"
                 "• Sổ bảo hành điện tử (E-Warranty): Tra cứu toàn bộ lịch sử các lần bảo dưỡng, hạng mục phụ tùng đã thay thế, hóa đơn dịch vụ tương ứng và thời hạn bảo hành còn lại của xe.\n"
                 "• Tự động tính điểm tích lũy dịch vụ vào tài khoản Loyalty của khách hàng sau mỗi lần thanh toán bảo dưỡng."),
                ("Giá trị mang lại: ", "Gắn kết khách hàng dài hạn sau khi mua xe, minh bạch lịch sử sử dụng xe, gia tăng giá trị bán lại của xe PrimeLux.")
            ]
        ),
        (
            "7. Thẩm định xe cũ & Yêu cầu Thu cũ đổi mới\n(Used Car Valuation & Trade-In Request)",
            [
                ("Vị trí tích hợp: ", "Trang chủ (/home), Trang danh mục xe (/cars) và Chi tiết xe (/cars/{id})."),
                ("Mục tiêu & Nghiệp vụ: ", "Hỗ trợ khách hàng có nhu cầu bán lại chiếc xe đang sử dụng để đổi lấy xe sang mới tại showroom (Trade-In)."),
                ("Quy trình hoạt động: ",
                 "• Khách hàng điền biểu mẫu thẩm định: Hãng xe, dòng xe, năm sản xuất, số ODO đã chạy, tình trạng xe, kèm tải lên 4 - 6 ảnh chụp thực tế và đăng kiểm.\n"
                 "• Hệ thống đưa ra mức giá ước tính sơ bộ dựa trên dữ liệu giá thị trường sẵn có.\n"
                 "• Yêu cầu được chuyển đến trang Admin để kỹ thuật viên showroom liên hệ đặt lịch kiểm tra xe thực tế 176 hạng mục.\n"
                 "• Sau khi thỏa thuận xong, giá trị xe cũ được trừ trực tiếp vào hóa đơn mua xe mới của khách hàng."),
                ("Giá trị mang lại: ", "Kích thích khách hàng đổi xe mới nhanh chóng, tạo nguồn xe lướt chính hãng có bảo hành cho showroom.")
            ]
        ),
        (
            "8. Nâng cấp Dashboard Báo cáo quản trị BI & Xuất file Excel/PDF\n(Advanced Admin Analytics & Report Export)",
            [
                ("Vị trí tích hợp: ", "Phân hệ Quản trị hệ thống (/admin và /quantri)."),
                ("Mục tiêu & Nghiệp vụ: ", "Cung cấp cho ban quản lý số liệu kinh doanh đa chiều, trực quan và hỗ trợ xuất báo cáo kế toán, vận hành."),
                ("Quy trình hoạt động: ",
                 "• Biểu đồ phân tích doanh thu: Thống kê doanh số theo tuần/tháng/quý, phân tích tỷ trọng theo thương hiệu xe (Mercedes, BMW, Porsche...) và theo phân khúc giá.\n"
                 "• Biểu đồ phễu chuyển đổi (Sales Funnel): Lượt truy cập xe -> Đăng ký lái thử -> Lái thử hoàn thành -> Đặt cọc -> Xuất hóa đơn bán hàng.\n"
                 "• Tích hợp thư viện xuất dữ liệu chuyên nghiệp (Laravel Excel / DomPDF): Cho phép xuất danh sách xe tồn kho, danh sách lịch hẹn lái thử, danh sách hóa đơn theo khoảng ngày ra file Excel chuẩn định dạng và file PDF in phiếu thu/hóa đơn bán xe đẹp mắt."),
                ("Giá trị mang lại: ", "Giúp người quản lý nắm bắt tình hình kinh doanh chính xác theo thời gian thực, ra quyết định nhập hàng và marketing hiệu quả.")
            ]
        ),
        (
            "9. Phân quyền nâng cao (RBAC) & Bảo mật xác thực 2 yếu tố (2FA)\n(Granular RBAC & Two-Factor Authentication)",
            [
                ("Vị trí tích hợp: ", "Phân hệ Đăng nhập (/login, /dangnhap) và Cài đặt tài khoản Quản trị (/admin)."),
                ("Mục tiêu & Nghiệp vụ: ", "Bảo vệ an toàn thông tin khách hàng VIP và phân định rõ ràng quyền hạn trách nhiệm giữa các phòng ban."),
                ("Quy trình hoạt động: ",
                 "• Phân quyền theo vai trò (Role-Based Access Control): Thiết lập các vai trò cụ thể: Super Admin (Toàn quyền), Quản lý bán hàng (Quản lý xe, duyệt giá, duyệt cọc), Tư vấn viên (Quản lý lịch lái thử, chat tư vấn), Kế toán (Quản lý hóa đơn, doanh thu, xuất báo cáo).\n"
                 "• Xác thực 2 bước (2FA): Kích hoạt xác thực mã OTP thời gian thực (TOTP qua Google Authenticator / Microsoft Authenticator) khi đăng nhập vào tài khoản quản trị Admin và Tư vấn viên.\n"
                 "• Nhật ký hoạt động (Audit Log): Ghi lại toàn bộ lịch sử chỉnh sửa nhạy cảm (sửa giá xe, thay đổi điểm VIP, xóa lịch lái thử, hủy hóa đơn) kèm thông tin IP và thời gian thao tác."),
                ("Giá trị mang lại: ", "Đảm bảo an toàn thông tin theo tiêu chuẩn bảo mật, phòng chống gian lận và rò rỉ dữ liệu khách hàng nội bộ.")
            ]
        )
    ]

    # Populate table rows
    row_idx = 1
    for name, details in features:
        row = table.add_row()
        cells = row.cells
        cells[0].width = Inches(1.9)
        cells[1].width = Inches(4.4)

        # Format Cell 0 (Chức năng)
        p0 = cells[0].paragraphs[0]
        p0.paragraph_format.space_after = Pt(2)
        r0 = p0.add_run(name)
        r0.font.name = 'Times New Roman'
        r0.font.size = Pt(11.5)
        r0.bold = True
        r0.font.color.rgb = RGBColor(15, 23, 42)

        # Format Cell 1 (Mô tả chi tiết)
        first = True
        for label, content in details:
            if first:
                p1 = cells[1].paragraphs[0]
                first = False
            else:
                p1 = cells[1].add_paragraph()
            p1.paragraph_format.space_after = Pt(4)
            p1.paragraph_format.line_spacing = 1.2

            r_lbl = p1.add_run(label)
            r_lbl.bold = True
            r_lbl.font.name = 'Times New Roman'
            r_lbl.font.size = Pt(11)
            r_lbl.font.color.rgb = RGBColor(30, 58, 138)

            r_txt = p1.add_run(content)
            r_txt.font.name = 'Times New Roman'
            r_txt.font.size = Pt(11)
            r_txt.font.color.rgb = RGBColor(51, 65, 85)

        # Styling
        shd_color = "F8FAFC" if (row_idx % 2 == 1) else "FFFFFF"
        for c in cells:
            set_cell_shading(c, shd_color)
            set_cell_margins(c, top=140, bottom=140, left=160, right=160)
            set_cell_borders(c, color="CBD5E1", sz="4")
            c.vertical_alignment = WD_ALIGN_VERTICAL.TOP

        row_idx += 1

    # --- Section II: Lộ trình phát triển tính theo NGÀY ---
    doc.add_page_break()

    add_heading1("II. LỘ TRÌNH PHÁT TRIỂN HỆ THỐNG TÍNH THEO NGÀY (CÓ AI HỖ TRỢ)")
    add_p("Nhờ sự trợ lực đắc lực từ Trí tuệ Nhân tạo (AI Coding Assistant) trong việc tự động sinh mã nguồn (scaffolding), viết nhanh migration, model, controller, tối ưu giao diện Tailwind và tạo unit test tự động, thời gian phát triển từng tính năng được rút ngắn gấp 5 - 8 lần so với phương pháp truyền thống.")
    add_p("Tổng thời gian thực hiện toàn bộ 9 chức năng được tối ưu chỉ trong 14 ngày làm việc (2 tuần), phân bổ thành 3 Sprint tập trung:")

    # Roadmap Table
    rm_table = doc.add_table(rows=1, cols=4)
    rm_table.alignment = WD_TABLE_ALIGNMENT.CENTER
    rm_table.autofit = False

    rm_hdr = rm_table.rows[0].cells
    rm_hdr[0].width = Inches(1.3)
    rm_hdr[1].width = Inches(1.9)
    rm_hdr[2].width = Inches(2.1)
    rm_hdr[3].width = Inches(1.5)

    rm_hdr[0].paragraphs[0].text = "Giai đoạn (Sprint)"
    rm_hdr[1].paragraphs[0].text = "Chức năng & Nhiệm vụ"
    rm_hdr[2].paragraphs[0].text = "Thời gian & Vai trò của AI"
    rm_hdr[3].paragraphs[0].text = "Kết quả bàn giao"

    for c in rm_hdr:
        set_cell_shading(c, "1E3A8A")
        set_cell_margins(c, top=140, bottom=140, left=140, right=140)
        set_cell_borders(c, color="172554", sz="6")
        c.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
        for p in c.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.CENTER
            for r in p.runs:
                r.font.name = 'Times New Roman'
                r.font.size = Pt(11)
                r.bold = True
                r.font.color.rgb = RGBColor(255, 255, 255)

    phases_days = [
        (
            "Sprint 1\n(Ngày 1 - Ngày 4)\n\nTiện ích Bán hàng & Báo cáo Quản trị",
            "• Chức năng 1: Dự toán lăn bánh & Bảng tính vay trả góp\n"
            "• Chức năng 5: Gửi thông báo đa kênh Zalo ZNS / SMS / Email\n"
            "• Chức năng 8: Nâng cấp Dashboard BI & Xuất file Excel/PDF",
            "• Tổng thời gian: 4 ngày làm việc.\n"
            "• AI hỗ trợ: Sinh thuật toán tính lãi kép theo dư nợ giảm dần; viết nhanh code kết nối API Zalo ZNS; sinh template báo cáo Excel/PDF bằng Blade & PhpSpreadsheet.",
            "• Tính toán lăn bánh chính xác 63 tỉnh thành.\n"
            "• Gửi tin ZNS xác nhận lịch lái thử tức thì.\n"
            "• Xuất file báo cáo doanh thu Excel/PDF trong 2 giây."
        ),
        (
            "Sprint 2\n(Ngày 5 - Ngày 9)\n\nTự động hóa Giao dịch & AI Thông minh",
            "• Chức năng 2: Đặt cọc giữ xe trực tuyến & Cổng thanh toán VNPAY/MoMo\n"
            "• Chức năng 3: Quét tự động giá xe thị trường 3 sàn lớn\n"
            "• Chức năng 4: Trợ lý ảo AI tư vấn tự động 24/7 (LLM Chatbot)",
            "• Tổng thời gian: 5 ngày làm việc.\n"
            "• AI hỗ trợ: Sinh mã tích hợp VNPAY SDK và webhook kiểm tra chữ ký số (Checksum HMAC-SHA512); viết kịch bản Scrapy bóc tách DOM trang web xe; cấu hình Prompt RAG OpenAI/Claude.",
            "• Đặt cọc xe online an toàn 100%, không bị trùng xe.\n"
            "• Cập nhật giá 3 sàn mỗi 6 tiếng tự động.\n"
            "• AI trả lời tự động > 70% câu hỏi xe trong vòng < 1 giây."
        ),
        (
            "Sprint 3\n(Ngày 10 - Ngày 14)\n\nDịch vụ Hậu mãi & Bảo mật Hệ thống",
            "• Chức năng 6: Đặt lịch bảo dưỡng & Sổ bảo hành VIN điện tử\n"
            "• Chức năng 7: Thẩm định xe cũ & Yêu cầu Thu cũ đổi mới (Trade-In)\n"
            "• Chức năng 9: Phân quyền RBAC & Bảo mật xác thực 2 bước (2FA)",
            "• Tổng thời gian: 5 ngày làm việc.\n"
            "• AI hỗ trợ: Sinh CSDL quan hệ tra cứu theo số khung VIN; viết logic tính giá thẩm định xe cũ; cấu hình Middleware bảo mật phân quyền và mã OTP Google Authenticator.",
            "• Khép kín chu trình mua bán và bảo dưỡng xe.\n"
            "• Tiếp nhận đơn thu cũ đổi mới trực tuyến.\n"
            "• Bảo mật an toàn tuyệt đối tài khoản Admin và Advisor bằng 2FA."
        ),
    ]

    for p_name, p_funcs, p_tech, p_kpi in phases_days:
        row = rm_table.add_row()
        cells = row.cells
        cells[0].width = Inches(1.3)
        cells[1].width = Inches(1.9)
        cells[2].width = Inches(2.1)
        cells[3].width = Inches(1.5)

        data = [p_name, p_funcs, p_tech, p_kpi]
        for i, text in enumerate(data):
            cell = cells[i]
            set_cell_shading(cell, "FFFFFF" if "Sprint 1" in p_name else ("F8FAFC" if "Sprint 2" in p_name else "FFFFFF"))
            set_cell_margins(cell, top=140, bottom=140, left=140, right=140)
            set_cell_borders(cell, color="CBD5E1", sz="4")
            cell.vertical_alignment = WD_ALIGN_VERTICAL.TOP

            p = cell.paragraphs[0]
            p.paragraph_format.space_after = Pt(4)
            p.paragraph_format.line_spacing = 1.2
            r = p.add_run(text)
            r.font.name = 'Times New Roman'
            r.font.size = Pt(10.5)
            r.font.color.rgb = RGBColor(30, 41, 59)
            if i == 0:
                r.bold = True
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER

    add_heading1("III. BẢNG TIẾN ĐỘ THỰC HIỆN CHI TIẾT TỪNG NGÀY (DAY-BY-DAY TIMELINE)")
    
    # Day-by-Day Table
    day_table = doc.add_table(rows=1, cols=4)
    day_table.alignment = WD_TABLE_ALIGNMENT.CENTER
    day_table.autofit = False

    d_hdr = day_table.rows[0].cells
    d_hdr[0].width = Inches(1.1)
    d_hdr[1].width = Inches(1.8)
    d_hdr[2].width = Inches(2.5)
    d_hdr[3].width = Inches(1.4)

    d_hdr[0].paragraphs[0].text = "Ngày"
    d_hdr[1].paragraphs[0].text = "Chức năng thực hiện"
    d_hdr[2].paragraphs[0].text = "Nội dung công việc chi tiết"
    d_hdr[3].paragraphs[0].text = "Trạng thái / Output"

    for c in d_hdr:
        set_cell_shading(c, "0F172A") # Slate 900
        set_cell_margins(c, top=140, bottom=140, left=140, right=140)
        set_cell_borders(c, color="020617", sz="6")
        c.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
        for p in c.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.CENTER
            for r in p.runs:
                r.font.name = 'Times New Roman'
                r.font.size = Pt(11)
                r.bold = True
                r.font.color.rgb = RGBColor(255, 255, 255)

    days_data = [
        ("Ngày 1 - 2", "Chức năng 1: Dự toán lăn bánh & Trả góp", "Thiết kế component Blade trên trang /cars/{id}; lập trình JS tính toán trước bạ, biển số và lịch trả nợ.", "Hoàn thành UI & Logic"),
        ("Ngày 2 - 3", "Chức năng 5: Thông báo Zalo ZNS / SMS / Email", "Tích hợp Notification Service; cấu hình mẫu tin Zalo ZNS cho lịch lái thử và thăng hạng VIP.", "Hoàn thành gửi tin tự động"),
        ("Ngày 3 - 4", "Chức năng 8: Dashboard BI & Xuất Excel/PDF", "Xây dựng biểu đồ doanh thu Chart.js trên /admin; tích hợp Laravel Excel và DomPDF xuất báo cáo.", "Hoàn thành báo cáo & xuất file"),
        ("Ngày 5 - 6", "Chức năng 2: Đặt cọc xe & Cổng thanh toán", "Tích hợp API cổng thanh toán VNPAY Sandbox; xử lý IPN cập nhật xe sang trạng thái 'Đã đặt cọc'.", "Hoàn thành luồng thanh toán cọc"),
        ("Ngày 7 - 8", "Chức năng 3: Quét giá thị trường tự động", "Viết script Python scraper bóc tách giá 3 sàn; cấu hình Laravel Command và Task Scheduling chạy định kỳ.", "Hoàn thành tự động quét giá"),
        ("Ngày 8 - 9", "Chức năng 4: Trợ lý ảo AI Chatbot (LLM)", "Kết nối API OpenAI/DeepSeek; huấn luyện Prompt thông số xe; tích hợp vào Widget Chat và bàn trực SSE.", "Hoàn thành Chatbot AI 24/7"),
        ("Ngày 10 - 11", "Chức năng 6: Đặt lịch bảo dưỡng & Sổ VIN", "Tạo migration sổ bảo hành; xây dựng trang đặt lịch bảo dưỡng và tra cứu lịch sử phụ tùng theo VIN.", "Hoàn thành dịch vụ hậu mãi"),
        ("Ngày 12 - 13", "Chức năng 7: Thẩm định xe cũ (Thu cũ đổi mới)", "Xây dựng form gửi ảnh/thông tin xe cũ; lập trình bảng duyệt thẩm định giá xe cũ trên trang Admin.", "Hoàn thành module Trade-In"),
        ("Ngày 13 - 14", "Chức năng 9: Phân quyền RBAC & Bảo mật 2FA", "Phân chia quyền Super Admin / Advisor / Kế toán; tích hợp xác thực 2 bước Google Authenticator.", "Hoàn thành bảo mật & phân quyền"),
    ]

    for d_num, d_fn, d_task, d_out in days_data:
        row = day_table.add_row()
        cells = row.cells
        cells[0].width = Inches(1.1)
        cells[1].width = Inches(1.8)
        cells[2].width = Inches(2.5)
        cells[3].width = Inches(1.4)

        for i, text in enumerate([d_num, d_fn, d_task, d_out]):
            cell = cells[i]
            set_cell_shading(cell, "FFFFFF" if "Ngày 1" in d_num or "Ngày 5" in d_num or "Ngày 10" in d_num else "F8FAFC")
            set_cell_margins(cell, top=120, bottom=120, left=140, right=140)
            set_cell_borders(cell, color="CBD5E1", sz="4")
            cell.vertical_alignment = WD_ALIGN_VERTICAL.CENTER

            p = cell.paragraphs[0]
            p.paragraph_format.space_after = Pt(2)
            r = p.add_run(text)
            r.font.name = 'Times New Roman'
            r.font.size = Pt(10)
            r.font.color.rgb = RGBColor(30, 41, 59)
            if i in [0, 3]:
                r.bold = True
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER

    add_heading1("IV. KẾT LUẬN & ĐÁNH GIÁ TÍNH KHẢ THI")
    add_p("1. Tính khả thi vượt trội: Với 9 chức năng được tinh gọn và tập trung cao độ, việc triển khai hoàn toàn khả thi trong vòng 14 ngày khi có sự phối hợp giữa lập trình viên và công cụ hỗ trợ AI.")
    add_p("2. Không làm gián đoạn hệ thống: Mỗi tính năng đều đóng vai trò như một module độc lập bổ trợ vào các controller và view đã có, kiểm thử tự động sau từng ngày để đảm bảo 100% test case luôn Passed.")
    add_p("3. Giá trị thực tiễn cao: Hệ thống giải quyết trọn vẹn từ khâu tiếp thị bán hàng, chốt cọc trực tuyến, chăm sóc đa kênh đến bảo hành hậu mãi cho chuỗi showroom ô tô hiện đại.")

    # Save to files
    out_docx = os.path.join("docs", "HUONG_PHAT_TRIEN_CHUC_NANG.docx")
    out_doc = os.path.join("docs", "HUONG_PHAT_TRIEN_CHUC_NANG.doc")
    root_docx = "HUONG_PHAT_TRIEN_CHUC_NANG.docx"
    root_doc = "HUONG_PHAT_TRIEN_CHUC_NANG.doc"

    doc.save(out_docx)
    shutil.copy(out_docx, out_doc)
    shutil.copy(out_docx, root_docx)
    shutil.copy(out_docx, root_doc)

    print(f"Successfully generated:")
    print(f" - {out_docx}")
    print(f" - {out_doc}")
    print(f" - {root_docx}")
    print(f" - {root_doc}")

if __name__ == "__main__":
    create_roadmap_document()
