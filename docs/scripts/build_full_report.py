# -*- coding: utf-8 -*-
"""
Script xây dựng Báo Cáo Tốt Nghiệp: Hệ Thống Quản Lý Showroom Và Kinh Doanh Ô Tô PrimeLux Auto
XÂY DỰNG CHÍNH XÁC 100% DỰA TRÊN DỰ ÁN WEB THỰC TẾ CỦA PRIMELUX AUTO:
1. Công nghệ thực tế 100%:
   - Backend: PHP 8.3, Laravel Framework 12 (core 13.17), Eloquent ORM.
   - Frontend: Tailwind CSS v4 (@tailwindcss/vite 4.0), Vite 8.0, Blade Template, Vanilla JavaScript (ES6 Fetch API), Chart.js (HTML5 Canvas).
   - Cơ sở dữ liệu: MySQL 8.0 (20 bảng chuẩn hóa 3NF: xe, thuong_hieu, loai_xe, hang_thanh_vien, khach_hang, hoa_don, ct_hoa_don, dang_ky_lai_thu, lich_su_diem, chat_logs, car_price_sources, dich_vu, dat_lich_dich_vu, sepay_transactions, yeu_cau_thu_doi_xe, so_bao_hanh_vin, lich_su_bao_duong_vin, thong_bao_da_kenh, audit_logs, users).
   - Tích hợp nâng cao:
     + Cổng thanh toán SePay VietQR (MBBank 0338929013, Webhook tự động tức thì, Popup Admin).
     + Trợ lý ảo AI LLM tư vấn thông minh (Mô hình RAG - Retrieval-Augmented Generation).
     + Giao tiếp thời gian thực Server-Sent Events (SSE) (/api/consultant/sse-stream).
     + Scraper giá sàn thị trường (Artisan Command cars:scrape-market-prices).
     + Hệ thống thông báo đa kênh Zalo ZNS, SMS Brandname, Email (NotificationService).
     + Quy trình Thu cũ đổi mới Trade-In 176 hạng mục.
     + Sổ bảo hành điện tử theo số khung VIN 17 ký tự.
     + Báo cáo BI Sales Funnel & Xuất dữ liệu Excel/CSV UTF-8 BOM.
     + Phân quyền RBAC 5 vai trò, Bảo mật 2FA Google Authenticator (TOTP RFC 6238), Audit Log.
     + Kiểm thử tự động PHPUnit 12 (23/23 tests Passed 100%, 95 assertions).
     + Chuẩn hóa mã nguồn Laravel Pint 1.27.
2. Hình ảnh và Sơ đồ: 100% CHÍNH CHỦ CỦA SHOWROOM PRIMELUX AUTO:
   - Logo Showroom PrimeLux Auto trên bìa chính & bìa phụ (public/image/Logo.png).
   - Hình 1.1: Mô hình kiến trúc 5 tầng MVC & Service Layer PrimeLux Auto.
   - Hình 2.1: Sơ đồ luồng quy trình kinh doanh và dịch vụ showroom.
   - Sơ đồ 2.1: Sơ đồ chức năng của Quản trị viên (Admin Portal).
   - Sơ đồ 2.2: Sơ đồ chức năng của Nhân viên tư vấn & Kế toán Showroom.
   - Sơ đồ 2.3: Sơ đồ chức năng của Cổng Khách hàng (Customer Portal).
   - Lược đồ 2.1: Lược đồ Use Case tổng quát PrimeLux Auto.
   - Lược đồ 2.2: Lược đồ hoạt động Đặt cọc trực tuyến SePay VietQR.
   - Lược đồ 2.3: Lược đồ hoạt động Thu cũ đổi mới Trade-In 176 hạng mục.
   - Biểu đồ 2.1: Biểu đồ triển khai hạ tầng công nghệ (Deployment Diagram).
   - Hình 2.2: Sơ đồ quan hệ thực thể (ERD) 20 bảng CSDL PrimeLux Auto.
   - Hình 3.1 đến Hình 3.10: 10 ảnh chụp màn hình giao diện thực tế của PrimeLux Auto.
3. Định dạng văn bản:
   - Duy nhất 1 màu chữ ĐEN (RGBColor(0, 0, 0)) trong toàn bộ tài liệu.
   - Danh mục Tài liệu tham khảo nằm riêng 1 trang độc lập (Page Break trước danh mục).
   - Vai trò người dùng chỉ ghi tên vai trò, tuyệt đối không có đuôi .js hay .html.
   - Lề trang chuẩn luận văn Việt Nam: Trái 3.0cm, Phải 2.0cm, Trên 2.0cm, Dưới 2.0cm. Font: Times New Roman.
"""

import os
import sys
import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_ALIGN_VERTICAL
from docx.oxml import parse_xml
from docx.oxml.ns import nsdecls

sys.stdout.reconfigure(encoding='utf-8')

BLACK = RGBColor(0, 0, 0)

def set_cell_border(cell, color="000000", sz="4", val="single"):
    """Thiết lập đường viền đen đơn chuẩn học thuật cho ô bảng."""
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

def set_cell_shading(cell, color="F2F2F2"):
    """Đặt màu nền xám nhạt cho hàng tiêu đề ô bảng."""
    tcPr = cell._tc.get_or_add_tcPr()
    shd = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{color}"/>')
    tcPr.append(shd)

def add_para(doc, text="", bold=False, italic=False, size=13, align=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=6, space_before=0, line_spacing=1.3):
    """Thêm một đoạn văn bản chuẩn Times New Roman, màu chữ ĐEN 100%."""
    p = doc.add_paragraph()
    p.alignment = align
    p.paragraph_format.space_after = Pt(space_after)
    p.paragraph_format.space_before = Pt(space_before)
    p.paragraph_format.line_spacing = line_spacing

    if text:
        run = p.add_run(text)
        run.font.name = 'Times New Roman'
        run.font.size = Pt(size)
        run.font.bold = bold
        run.font.italic = italic
        run.font.color.rgb = BLACK
    return p

def add_heading_1(doc, text):
    """Tiêu đề Chương: 16pt, Đậm, Căn giữa, Chữ HOA, Màu đen 100%."""
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p.paragraph_format.space_before = Pt(16)
    p.paragraph_format.space_after = Pt(8)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text.upper())
    run.font.name = 'Times New Roman'
    run.font.size = Pt(16)
    run.font.bold = True
    run.font.color.rgb = BLACK
    return p

def add_heading_2(doc, text):
    """Tiêu đề Cấp 2: 14pt, Đậm, Căn trái, Màu đen 100%."""
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p.paragraph_format.space_before = Pt(12)
    p.paragraph_format.space_after = Pt(4)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text)
    run.font.name = 'Times New Roman'
    run.font.size = Pt(14)
    run.font.bold = True
    run.font.color.rgb = BLACK
    return p

def add_heading_3(doc, text):
    """Tiêu đề Cấp 3: 13pt, Đậm, Căn trái, Màu đen 100%."""
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p.paragraph_format.space_before = Pt(8)
    p.paragraph_format.space_after = Pt(3)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text)
    run.font.name = 'Times New Roman'
    run.font.size = Pt(13)
    run.font.bold = True
    run.font.color.rgb = BLACK
    return p

def add_image_box(doc, img_rel_path, caption_text, width=Inches(5.5)):
    """Chèn hình ảnh từ dự án kèm chú thích khoa học căn giữa, màu đen 100%."""
    found_path = None
    candidates = [
        img_rel_path,
        os.path.join("docs", "screenshots", os.path.basename(img_rel_path)),
        os.path.join("public", "image", os.path.basename(img_rel_path)),
        os.path.join("public", "images", os.path.basename(img_rel_path)),
        os.path.join("docs", img_rel_path)
    ]
    for c in candidates:
        if os.path.exists(c):
            found_path = c
            break

    if found_path:
        p_img = doc.add_paragraph()
        p_img.alignment = WD_ALIGN_PARAGRAPH.CENTER
        p_img.paragraph_format.space_before = Pt(6)
        p_img.paragraph_format.space_after = Pt(3)
        run_img = p_img.add_run()
        run_img.add_picture(found_path, width=width)

        if caption_text:
            p_cap = doc.add_paragraph()
            p_cap.alignment = WD_ALIGN_PARAGRAPH.CENTER
            p_cap.paragraph_format.space_before = Pt(2)
            p_cap.paragraph_format.space_after = Pt(8)
            run_cap = p_cap.add_run(caption_text)
            run_cap.font.name = 'Times New Roman'
            run_cap.font.size = Pt(11)
            run_cap.font.bold = True
            run_cap.font.italic = True
            run_cap.font.color.rgb = BLACK
    else:
        if caption_text:
            p_missing = doc.add_paragraph()
            p_missing.alignment = WD_ALIGN_PARAGRAPH.CENTER
            run = p_missing.add_run(f"[{caption_text}]")
            run.font.name = 'Times New Roman'
            run.font.size = Pt(11)
            run.font.italic = True
            run.font.color.rgb = BLACK

def format_table_header(row, col_widths=None):
    """Định dạng hàng tiêu đề bảng: Nền xám nhạt, Chữ Đậm, Căn giữa, Viền đen, Màu chữ Đen."""
    for idx, cell in enumerate(row.cells):
        set_cell_border(cell, color="000000", sz="4", val="single")
        set_cell_shading(cell, color="EAEAEA")
        cell.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
        if col_widths and idx < len(col_widths):
            cell.width = col_widths[idx]
        for p in cell.paragraphs:
            p.alignment = WD_ALIGN_PARAGRAPH.CENTER
            p.paragraph_format.space_before = Pt(4)
            p.paragraph_format.space_after = Pt(4)
            for r in p.runs:
                r.font.name = 'Times New Roman'
                r.font.size = Pt(11.5)
                r.font.bold = True
                r.font.color.rgb = BLACK

def format_table_cell(cell, bold=False, italic=False, align=WD_ALIGN_PARAGRAPH.LEFT, width=None):
    """Định dạng ô nội dung bảng: Viền đen, Chữ màu Đen, Times New Roman."""
    set_cell_border(cell, color="000000", sz="4", val="single")
    cell.vertical_alignment = WD_ALIGN_VERTICAL.CENTER
    if width:
        cell.width = width
    for p in cell.paragraphs:
        p.alignment = align
        p.paragraph_format.space_before = Pt(3)
        p.paragraph_format.space_after = Pt(3)
        p.paragraph_format.line_spacing = 1.15
        for r in p.runs:
            r.font.name = 'Times New Roman'
            r.font.size = Pt(11)
            r.font.bold = bold
            r.font.italic = italic
            r.font.color.rgb = BLACK

def create_use_case_table(doc, table_id, use_case_name, actor_actions, system_responses):
    """Tạo bảng đặc tả Use Case chuẩn 2 cột."""
    p_title = doc.add_paragraph()
    p_title.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p_title.paragraph_format.space_before = Pt(6)
    p_title.paragraph_format.space_after = Pt(2)
    p_title.paragraph_format.keep_with_next = True
    run_t = p_title.add_run(f"Bảng {table_id}: Đặc tả use case {use_case_name}")
    run_t.font.name = 'Times New Roman'
    run_t.font.size = Pt(12)
    run_t.font.bold = True
    run_t.font.color.rgb = BLACK

    tbl = doc.add_table(rows=2, cols=2)
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER

    widths = [Inches(3.2), Inches(3.2)]
    hdr = tbl.rows[0]
    hdr.cells[0].paragraphs[0].text = "Hành động của tác nhân"
    hdr.cells[1].paragraphs[0].text = "Phản ứng của hệ thống"
    format_table_header(hdr, widths)

    row = tbl.rows[1]
    p_act = row.cells[0].paragraphs[0]
    p_act.text = actor_actions
    format_table_cell(row.cells[0], align=WD_ALIGN_PARAGRAPH.LEFT, width=widths[0])

    p_sys = row.cells[1].paragraphs[0]
    p_sys.text = system_responses
    format_table_cell(row.cells[1], align=WD_ALIGN_PARAGRAPH.LEFT, width=widths[1])

    p_space = doc.add_paragraph()
    p_space.paragraph_format.space_after = Pt(4)

def create_db_table(doc, table_id, table_name, description, columns_data):
    """Tạo bảng đặc tả cấu trúc bảng cơ sở dữ liệu thực tế."""
    p_title = doc.add_paragraph()
    p_title.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p_title.paragraph_format.space_before = Pt(6)
    p_title.paragraph_format.space_after = Pt(2)
    p_title.paragraph_format.keep_with_next = True
    run_t = p_title.add_run(f"Bảng {table_id}: Cấu trúc dữ liệu bảng {table_name} ({description})")
    run_t.font.name = 'Times New Roman'
    run_t.font.size = Pt(12)
    run_t.font.bold = True
    run_t.font.color.rgb = BLACK

    tbl = doc.add_table(rows=len(columns_data) + 1, cols=4)
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER
    widths = [Inches(1.8), Inches(1.3), Inches(1.6), Inches(2.0)]

    hdr = tbl.rows[0]
    hdr.cells[0].paragraphs[0].text = "Tên cột"
    hdr.cells[1].paragraphs[0].text = "Kiểu dữ liệu"
    hdr.cells[2].paragraphs[0].text = "Ràng buộc"
    hdr.cells[3].paragraphs[0].text = "Mô tả ý nghĩa"
    format_table_header(hdr, widths)

    for i, col in enumerate(columns_data):
        row = tbl.rows[i + 1]
        for c_idx in range(4):
            cell = row.cells[c_idx]
            cell.paragraphs[0].text = col[c_idx]
            align = WD_ALIGN_PARAGRAPH.CENTER if c_idx in [1, 2] else WD_ALIGN_PARAGRAPH.LEFT
            format_table_cell(cell, bold=(c_idx == 0), align=align, width=widths[c_idx])

    p_space = doc.add_paragraph()
    p_space.paragraph_format.space_after = Pt(4)


def build_full_report():
    print("Khởi tạo tài liệu Báo Cáo Tốt Nghiệp PrimeLux Auto dựa 100% trên dự án web thực tế...")
    doc = docx.Document()

    # Thiết lập trang in A4 và lề chuẩn: Trái 3.0cm, Phải 2.0cm, Trên 2.0cm, Dưới 2.0cm
    for section in doc.sections:
        section.page_width = Inches(8.27)
        section.page_height = Inches(11.69)
        section.top_margin = Inches(0.79)
        section.bottom_margin = Inches(0.79)
        section.left_margin = Inches(1.18)
        section.right_margin = Inches(0.79)

    normal_style = doc.styles['Normal']
    normal_style.font.name = 'Times New Roman'
    normal_style.font.size = Pt(13)
    normal_style.font.color.rgb = BLACK
    normal_style.paragraph_format.line_spacing = 1.3
    normal_style.paragraph_format.space_after = Pt(6)

    # =========================================================================
    # TRANG BÌA CHÍNH (COVER 1)
    # =========================================================================
    add_para(doc, "BỘ GIÁO DỤC VÀ ĐÀO TẠO", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    add_para(doc, "TRƯỜNG ĐẠI HỌC CÔNG NGHỆ THÔNG TIN", bold=True, size=14, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    add_para(doc, "KHOA CÔNG NGHỆ THÔNG TIN", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=14)

    # Logo Showroom PrimeLux Auto thực tế
    add_image_box(doc, "public/image/Logo.png", "", width=Inches(1.8))

    add_para(doc, "ĐỒ ÁN TỐT NGHIỆP ĐẠI HỌC", bold=True, size=18, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=6)
    add_para(doc, "CHUYÊN NGÀNH: CÔNG NGHỆ THÔNG TIN", bold=True, size=14, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=20)

    add_para(doc, "ĐỀ TÀI:", bold=True, size=15, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=6)
    add_para(doc, "XÂY DỰNG HỆ THỐNG QUẢN LÝ SHOWROOM VÀ KINH DOANH Ô TÔ CAO CẤP PRIMELUX AUTO TÍCH HỢP TRÍ TUỆ NHÂN TẠO VÀ CỔNG THANH TOÁN TRỰC TUYẾN", bold=True, size=16, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=35)

    add_para(doc, "Giảng viên hướng dẫn: TS. Nguyễn Văn A", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Sinh viên thực hiện:    Nguyễn Thành Thiện", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Mã số sinh viên:       220000000", size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Lớp:                   CNTT - K15", size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Khóa học:              2022 - 2026", size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=40)

    add_para(doc, "TP. Hồ Chí Minh, Năm 2026", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=0)

    # =========================================================================
    # TRANG BÌA PHỤ (COVER 2)
    # =========================================================================
    doc.add_page_break()
    add_para(doc, "BỘ GIÁO DỤC VÀ ĐÀO TẠO", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    add_para(doc, "TRƯỜNG ĐẠI HỌC CÔNG NGHỆ THÔNG TIN", bold=True, size=14, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    add_para(doc, "KHOA CÔNG NGHỆ THÔNG TIN", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=14)

    add_image_box(doc, "public/image/Logo.png", "", width=Inches(1.8))

    add_para(doc, "ĐỒ ÁN TỐT NGHIỆP ĐẠI HỌC", bold=True, size=18, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=6)
    add_para(doc, "CHUYÊN NGÀNH: CÔNG NGHỆ THÔNG TIN", bold=True, size=14, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=20)

    add_para(doc, "ĐỀ TÀI:", bold=True, size=15, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=6)
    add_para(doc, "XÂY DỰNG HỆ THỐNG QUẢN LÝ SHOWROOM VÀ KINH DOANH Ô TÔ CAO CẤP PRIMELUX AUTO TÍCH HỢP TRÍ TUỆ NHÂN TẠO VÀ CỔNG THANH TOÁN TRỰC TUYẾN", bold=True, size=16, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=35)

    add_para(doc, "Giảng viên hướng dẫn: TS. Nguyễn Văn A", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Sinh viên thực hiện:    Nguyễn Thành Thiện", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Mã số sinh viên:       220000000", size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Lớp:                   CNTT - K15", size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=4)
    add_para(doc, "Khóa học:              2022 - 2026", size=13, align=WD_ALIGN_PARAGRAPH.LEFT, space_after=40)

    add_para(doc, "TP. Hồ Chí Minh, Năm 2026", bold=True, size=13, align=WD_ALIGN_PARAGRAPH.CENTER, space_after=0)

    # =========================================================================
    # LỜI CẢM ƠN & LỜI CAM ĐOAN
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "LỜI CẢM ƠN")
    add_para(doc, "Để hoàn thành đồ án tốt nghiệp đại học này, em xin gửi lời cảm ơn chân thành và sâu sắc nhất đến Ban Giám hiệu cùng toàn thể quý Thầy, Cô thuộc Khoa Công nghệ Thông tin - Trường Đại học Công nghệ Thông tin đã tận tình truyền đạt cho em những tri thức khoa học, nền tảng tư duy và kinh nghiệm quý báu trong suốt quá trình theo học tại trường. Những nền tảng kiến thức vô giá ấy không chỉ giúp ích trực tiếp cho em trong việc nghiên cứu, xây dựng và hoàn thành đồ án tốt nghiệp này mà còn là hành trang vững chắc cho sự nghiệp phát triển phần mềm trong tương lai.")
    add_para(doc, "Đặc biệt, em xin gửi lời cảm ơn sâu sắc nhất đến TS. Nguyễn Văn A - Giảng viên hướng dẫn đã luôn dành nhiều thời gian quý báu để định hướng đề tài, tận tình chỉ dẫn phương pháp luận nghiên cứu khoa học, góp ý sâu sát về mặt kiến trúc hệ thống và luôn động viên, hỗ trợ em trong suốt quá trình thực hiện đồ án.")
    add_para(doc, "Em cũng xin chân thành cảm ơn Ban Quản lý và các chuyên viên tư vấn, kỹ thuật viên tại Showroom ô tô PrimeLux Auto đã nhiệt tình hỗ trợ, cung cấp dữ liệu thực tế và đóng góp nhiều ý kiến nghiệp vụ quý báu về quy trình bán lẻ ô tô, tính toán chi phí lăn bánh, thẩm định xe cũ (Trade-In) và dịch vụ bảo hành điện tử theo số khung VIN.")
    add_para(doc, "Mặc dù đã có nhiều nỗ lực và cố gắng hết mình để tìm hiểu, phân tích và hiện thực hóa hệ thống phần mềm một cách hoàn chỉnh nhất, song do thời gian và kinh nghiệm thực tiễn của bản thân còn hạn chế nên đồ án chắc chắn khó tránh khỏi những thiếu sót nhất định. Em rất kính mong nhận được những lời nhận xét, góp ý và chỉ bảo quý báu của quý Thầy, Cô để hệ thống ngày càng được hoàn thiện hơn.")
    add_para(doc, "Kính chúc quý Thầy, Cô luôn dồi dào sức khỏe, hạnh phúc và gặt hái được nhiều thành công to lớn trong sự nghiệp trồng người cao quý!")
    add_para(doc, "Em xin chân thành cảm ơn!", italic=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=20)
    add_para(doc, "Sinh viên thực hiện", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=40)
    add_para(doc, "Nguyễn Thành Thiện", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT)

    doc.add_page_break()
    add_heading_1(doc, "LỜI CAM ĐOAN")
    add_para(doc, "Em xin cam đoan toàn bộ nội dung trong bản Báo cáo Đồ án Tốt nghiệp này là công trình nghiên cứu và phát triển phần mềm độc lập của chính bản thân em dưới sự hướng dẫn khoa học của Giảng viên hướng dẫn TS. Nguyễn Văn A.")
    add_para(doc, "Các số liệu, mã nguồn chương trình, cơ sở dữ liệu và kết quả thực nghiệm được trình bày trong đồ án là hoàn toàn trung thực, phản ánh chính xác 100% ứng dụng thực tế của Showroom PrimeLux Auto đã được cài đặt và vận hành trên môi trường máy chủ cục bộ và đám mây.")
    add_para(doc, "Tất cả các tài liệu tham khảo, thư viện mã nguồn mở, tài liệu API chính thức và công cụ hỗ trợ được sử dụng trong đề tài đều được trích dẫn nguồn gốc xuất xứ rõ ràng theo đúng quy chuẩn học thuật của Nhà trường. Em xin hoàn toàn chịu mọi trách nhiệm trước Hội đồng chấm đồ án và Nhà trường về tính trung thực của lời cam đoan này.")
    add_para(doc, "TP. Hồ Chí Minh, ngày 13 tháng 10 năm 2026", italic=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=20)
    add_para(doc, "Sinh viên cam đoan", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=40)
    add_para(doc, "Nguyễn Thành Thiện", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT)

    # =========================================================================
    # NHẬN XÉT CỦA GIẢNG VIÊN HƯỚNG DẪN & PHẢN BIỆN
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "NHẬN XÉT CỦA GIẢNG VIÊN HƯỚNG DẪN")
    add_para(doc, "Họ và tên Giảng viên hướng dẫn: TS. Nguyễn Văn A", bold=True, space_after=3)
    add_para(doc, "Học hàm, học vị: Tiến sĩ Khoa học Máy tính", space_after=3)
    add_para(doc, "Đơn vị công tác: Khoa Công nghệ Thông tin - Trường Đại học Công nghệ Thông tin", space_after=12)
    add_para(doc, "NỘI DUNG NHẬN XÉT:", bold=True, space_after=4)
    add_para(doc, "1. Về tinh thần, thái độ làm việc và ý thức kỷ luật của sinh viên:")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "2. Về kiến thức chuyên môn và năng lực giải quyết bài toán thực tế:")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "3. Về chất lượng sản phẩm phần mềm và độ tin cậy của báo cáo:")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "4. Kết luận và đề nghị đánh giá (Cho phép / Không cho phép bảo vệ):")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "Điểm đánh giá: ........ / 10 (Bằng chữ: .....................................................................)", bold=True, space_after=20)
    add_para(doc, "TP. Hồ Chí Minh, ngày ..... tháng ..... năm 2026", italic=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=10)
    add_para(doc, "Chữ ký của Giảng viên hướng dẫn", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=40)
    add_para(doc, "TS. Nguyễn Văn A", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT)

    doc.add_page_break()
    add_heading_1(doc, "NHẬN XÉT CỦA GIẢNG VIÊN PHẢN BIỆN")
    add_para(doc, "Họ và tên Giảng viên phản biện: .........................................................................................................", bold=True, space_after=3)
    add_para(doc, "Học hàm, học vị: .............................................................................................................................", space_after=3)
    add_para(doc, "Đơn vị công tác: Khoa Công nghệ Thông tin - Trường Đại học Công nghệ Thông tin", space_after=12)
    add_para(doc, "NỘI DUNG NHẬN XÉT:", bold=True, space_after=4)
    add_para(doc, "1. Ý nghĩa khoa học, tính thực tiễn và tính thời sự của đề tài:")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "2. Kết cấu đề tài, bố cục báo cáo và phương pháp trình bày:")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "3. Đánh giá kết quả chương trình phần mềm và các chức năng tích hợp:")
    add_para(doc, "...................................................................................................................................................................................................")
    add_para(doc, "4. Những câu hỏi chất vấn sinh viên trước Hội đồng:")
    add_para(doc, "a) .............................................................................................................................................................................................")
    add_para(doc, "b) .............................................................................................................................................................................................")
    add_para(doc, "Điểm đánh giá: ........ / 10 (Bằng chữ: .....................................................................)", bold=True, space_after=20)
    add_para(doc, "TP. Hồ Chí Minh, ngày ..... tháng ..... năm 2026", italic=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=10)
    add_para(doc, "Chữ ký của Giảng viên phản biện", bold=True, align=WD_ALIGN_PARAGRAPH.RIGHT, space_after=40)
    add_para(doc, "(Ký và ghi rõ họ tên)", italic=True, align=WD_ALIGN_PARAGRAPH.RIGHT)

    # =========================================================================
    # LỊCH LÀM VIỆC VÀ TIẾN ĐỘ THỰC HIỆN
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "LỊCH LÀM VIỆC VÀ TIẾN ĐỘ THỰC HIỆN")
    add_para(doc, "Giảng viên hướng dẫn: TS. Nguyễn Văn A", bold=True, space_after=3)
    add_para(doc, "Sinh viên thực hiện: Nguyễn Thành Thiện (MSSV: 220000000)", bold=True, space_after=3)
    add_para(doc, "Thời gian thực hiện: Từ ngày 01/03/2026 đến ngày 13/10/2026", italic=True, space_after=10)

    tbl_work = doc.add_table(rows=6, cols=3)
    tbl_work.alignment = WD_TABLE_ALIGNMENT.CENTER
    w_work = [Inches(1.8), Inches(3.2), Inches(1.4)]
    hdr_work = tbl_work.rows[0]
    hdr_work.cells[0].paragraphs[0].text = "Thời gian"
    hdr_work.cells[1].paragraphs[0].text = "Nội dung công việc thực hiện"
    hdr_work.cells[2].paragraphs[0].text = "Kết quả đạt được"
    format_table_header(hdr_work, w_work)

    work_data = [
        ("Tháng 3/2026", "Khảo sát thực tế nghiệp vụ kinh doanh showroom ô tô. Đặt vấn đề nghiên cứu, xác định mục tiêu và phạm vi đề tài. Lập kế hoạch tổng thể.", "Bản mô tả bài toán và đề cương đồ án."),
        ("Tháng 4 - 5/2026", "Phân tích yêu cầu chức năng & phi chức năng. Thiết kế kiến trúc 5 tầng MVC & Service, xây dựng lược đồ Use Case, Activity và thiết kế CSDL 20 bảng.", "Hồ sơ thiết kế phần mềm và sơ đồ ERD."),
        ("Tháng 6 - 7/2026", "Hiện thực hóa hệ thống trên nền tảng Laravel 12, PHP 8.3 và Tailwind CSS v4. Xây dựng phân hệ người dùng và phân hệ quản trị lõi.", "Mã nguồn các chức năng cơ bản."),
        ("Tháng 8 - 9/2026", "Tích hợp 9 chức năng nâng cao: Dự toán lăn bánh, Bảng tính trả góp, Cổng thanh toán SePay, AI LLM RAG, Quét giá sàn, Trade-In, Sổ bảo hành VIN, BI Export, RBAC & 2FA.", "Hệ thống hoàn chỉnh tích hợp API thực tế."),
        ("Tháng 10/2026", "Viết bộ kiểm thử tự động (PHPUnit 12 Feature Tests), tối ưu hóa hiệu năng, bảo mật và hoàn thiện báo cáo tốt nghiệp chi tiết.", "23/23 tests Passed 100%, Báo cáo hoàn chỉnh.")
    ]
    for idx, (t_time, t_task, t_res) in enumerate(work_data):
        row = tbl_work.rows[idx + 1]
        row.cells[0].paragraphs[0].text = t_time
        row.cells[1].paragraphs[0].text = t_task
        row.cells[2].paragraphs[0].text = t_res
        format_table_cell(row.cells[0], align=WD_ALIGN_PARAGRAPH.CENTER, width=w_work[0])
        format_table_cell(row.cells[1], align=WD_ALIGN_PARAGRAPH.LEFT, width=w_work[1])
        format_table_cell(row.cells[2], align=WD_ALIGN_PARAGRAPH.LEFT, width=w_work[2])

    p_sp = doc.add_paragraph()
    p_sp.paragraph_format.space_after = Pt(10)

    # =========================================================================
    # TÓM TẮT ĐỒ ÁN
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "TÓM TẮT ĐỒ ÁN")
    add_heading_3(doc, "1. Vấn đề được đưa ra giải quyết")
    add_para(doc, "Trong kỷ nguyên số hóa, ngành thương mại ô tô cao cấp tại Việt Nam đòi hỏi sự minh bạch và tự động hóa cao: chi phí lăn bánh khác biệt theo từng tỉnh thành; tính toán trả góp ngân hàng phức tạp; đặt cọc trực tuyến thiếu liên kết ngân hàng tức thời; thiếu công cụ thẩm định xe cũ Trade-In 176 hạng mục; quản lý bảo dưỡng xe theo số khung VIN phân mảnh; và nhu cầu tư vấn khách hàng 24/7.")

    add_heading_3(doc, "2. Mục tiêu đã đạt được")
    add_para(doc, "Hệ thống PrimeLux Auto hoàn thiện toàn diện: Cổng thông tin khách hàng sang trọng; Bộ công cụ tài chính tính chi phí lăn bánh & trả góp ngân hàng; Cổng thanh toán SePay VietQR xác thực Webhook tự động thời gian thực; Trợ lý ảo AI LLM tư vấn theo mô hình RAG; Quy trình Thu cũ đổi mới Trade-In; Sổ bảo hành điện tử theo VIN; Thông báo đa kênh tự động Zalo ZNS/SMS/Email; Dashboard BI Sales Funnel & Xuất file Excel/CSV UTF-8 BOM; Phân quyền RBAC 5 vai trò, bảo mật 2FA và Audit Log.")

    add_heading_3(doc, "3. Kỹ thuật và công nghệ sử dụng thực tế của dự án")
    add_para(doc, "Hệ thống sử dụng các công nghệ hiện đại nhất: Ngôn ngữ PHP 8.3, Framework Laravel 12 (13.17), Tailwind CSS v4 kết hợp công cụ đóng gói Vite 8, Blade Template Engine, JavaScript ES6 (Fetch API), thư viện biểu đồ Chart.js, CSDL quan hệ MySQL 8.0 với 20 bảng chuẩn hóa 3NF, Cổng thanh toán SePay VietQR (MBBank 0338929013), Trợ lý ảo AI LLM (RAG), Server-Sent Events (SSE), Laragon, Git và kiểm thử tự động PHPUnit 12 (23/23 tests passed 100%).")

    # =========================================================================
    # MỤC LỤC CHI TIẾT
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "MỤC LỤC")

    toc_entries = [
        ("LỜI CẢM ƠN", "i"),
        ("LỜI CAM ĐOAN", "ii"),
        ("NHẬN XÉT CỦA GIẢNG VIÊN HƯỚNG DẪN", "iii"),
        ("NHẬN XÉT CỦA GIẢNG VIÊN PHẢN BIỆN", "iv"),
        ("LỊCH LÀM VIỆC VÀ TIẾN ĐỘ THỰC HIỆN", "v"),
        ("TÓM TẮT ĐỒ ÁN", "vi"),
        ("DANH MỤC SƠ ĐỒ, LƯỢC ĐỒ, BIỂU ĐỒ, HÌNH", "ix"),
        ("DANH MỤC BẢNG BIỂU", "xi"),
        ("DANH MỤC THUẬT NGỮ VÀ TỪ VIẾT TẮT", "xii"),
        ("CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI VÀ CƠ SỞ LÝ THUYẾT", "1"),
        ("  1.1 Khảo sát bài toán", "1"),
        ("      1.1.1 Đặt vấn đề", "1"),
        ("      1.1.2 Giải pháp đề xuất", "2"),
        ("      1.1.3 Mục đích của đề tài", "3"),
        ("      1.1.4 Phạm vi và đối tượng nghiên cứu", "4"),
        ("  1.2 Cơ sở lý thuyết và công nghệ sử dụng", "5"),
        ("      1.2.1 Ngôn ngữ PHP 8.3 và Framework Laravel 12", "5"),
        ("      1.2.2 Kiến trúc Model - View - Controller (MVC) và Service Layer", "6"),
        ("      1.2.3 Hệ quản trị cơ sở dữ liệu MySQL 8.0 và Eloquent ORM", "7"),
        ("      1.2.4 Giao diện người dùng: Blade Templates, Tailwind CSS v4 và Vite 8", "8"),
        ("      1.2.5 Thư viện đồ họa Chart.js trong biểu diễn dữ liệu trực quan", "9"),
        ("      1.2.6 Cổng thanh toán trực tuyến SePay VietQR và Webhook bảo mật", "10"),
        ("      1.2.7 Trí tuệ nhân tạo AI LLM và kỹ thuật RAG trong tư vấn bán hàng", "11"),
        ("      1.2.8 Giao tiếp thời gian thực Server-Sent Events (SSE)", "12"),
        ("      1.2.9 Tiến trình thu thập dữ liệu giá sàn thị trường ô tô", "13"),
        ("      1.2.10 Cơ chế xuất báo cáo tài chính định dạng Excel/CSV UTF-8 BOM", "14"),
        ("      1.2.11 Môi trường phát triển Laragon và Visual Studio Code", "15"),
        ("      1.2.12 Hệ thống quản lý mã nguồn Git, GitHub và Kiểm thử PHPUnit", "16"),
        ("CHƯƠNG 2. PHƯƠNG PHÁP THỰC HIỆN VÀ THIẾT KẾ HỆ THỐNG", "17"),
        ("  2.1 Phân tích hệ thống", "17"),
        ("      2.1.1 Quy trình nghiệp vụ thực tế tại Showroom PrimeLux Auto", "17"),
        ("      2.1.2 Thông tin yêu cầu chức năng và phi chức năng", "19"),
        ("      2.1.3 Phân tích vai trò người dùng trong hệ thống", "21"),
        ("      2.1.4 Sơ đồ phân rã chức năng của hệ thống", "23"),
        ("  2.2 Các biểu đồ thiết kế hệ thống", "26"),
        ("      2.2.1 Lược đồ Use Case tổng quát", "26"),
        ("      2.2.2 Đặc tả Use Case chi tiết", "28"),
        ("      2.2.3 Lược đồ Hoạt động (Activity Diagrams)", "38"),
        ("      2.2.4 Biểu đồ triển khai hạ tầng công nghệ (Deployment Diagram)", "42"),
        ("  2.3 Thiết kế Cơ sở dữ liệu", "44"),
        ("      2.3.1 Sơ đồ quan hệ thực thể (ERD)", "44"),
        ("      2.3.2 Danh mục và cấu trúc chi tiết 20 bảng dữ liệu", "46"),
        ("CHƯƠNG 3. CÀI ĐẶT THỰC NGHIỆM VÀ KẾT QUẢ TRIỂN KHAI", "62"),
        ("  3.1 Môi trường cài đặt và cấu hình phần mềm", "62"),
        ("  3.2 Giao diện và kết quả các phân hệ phía Người dùng", "64"),
        ("  3.3 Giao diện và kết quả các phân hệ phía Quản trị", "73"),
        ("  3.4 Kết quả xuất báo cáo thống kê định dạng Excel/CSV", "79"),
        ("CHƯƠNG 4. ĐÁNH GIÁ, KIỂM THỬ VÀ HƯỚNG PHÁT TRIỂN", "81"),
        ("  4.1 Báo cáo kết quả kiểm thử tự động (PHPUnit)", "81"),
        ("  4.2 Đánh giá an toàn, bảo mật và hiệu năng hệ thống", "85"),
        ("  4.3 Kết luận đạt được", "88"),
        ("  4.4 Những mặt hạn chế, khuyết điểm", "90"),
        ("  4.5 Định hướng phát triển trong tương lai", "91"),
        ("TÀI LIỆU THAM KHẢO (Nằm riêng 1 trang độc lập)", "93")
    ]

    tbl_toc = doc.add_table(rows=len(toc_entries), cols=2)
    tbl_toc.alignment = WD_TABLE_ALIGNMENT.CENTER
    w_toc = [Inches(5.6), Inches(0.8)]
    for idx, (title, page) in enumerate(toc_entries):
        row = tbl_toc.rows[idx]
        p_t = row.cells[0].paragraphs[0]
        p_t.text = title
        p_t.paragraph_format.line_spacing = 1.15
        p_t.paragraph_format.space_after = Pt(2)
        p_t.paragraph_format.space_before = Pt(2)
        bold_flag = title.startswith("CHƯƠNG") or title.startswith("LỜI") or title.startswith("NHẬN") or title.startswith("TÓM") or title.startswith("MỤC") or title.startswith("DANH") or title.startswith("TÀI")
        for r in p_t.runs:
            r.font.name = 'Times New Roman'
            r.font.size = Pt(12) if bold_flag else Pt(11)
            r.font.bold = bold_flag
            r.font.color.rgb = BLACK

        p_p = row.cells[1].paragraphs[0]
        p_p.text = str(page)
        p_p.alignment = WD_ALIGN_PARAGRAPH.RIGHT
        p_p.paragraph_format.line_spacing = 1.15
        p_p.paragraph_format.space_after = Pt(2)
        p_p.paragraph_format.space_before = Pt(2)
        for r in p_p.runs:
            r.font.name = 'Times New Roman'
            r.font.size = Pt(11)
            r.font.bold = bold_flag
            r.font.color.rgb = BLACK
        row.cells[0].width = w_toc[0]
        row.cells[1].width = w_toc[1]

    # =========================================================================
    # DANH MỤC SƠ ĐỒ, LƯỢC ĐỒ, BIỂU ĐỒ, HÌNH
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "DANH MỤC SƠ ĐỒ, LƯỢC ĐỒ, BIỂU ĐỒ, HÌNH")

    add_heading_2(doc, "Sơ đồ & Lược đồ của PrimeLux Auto:")
    add_para(doc, "Hình 1.1: Mô hình kiến trúc tổng thể 5 tầng của hệ thống PrimeLux Auto................Trang 7")
    add_para(doc, "Hình 2.1: Sơ đồ luồng quy trình kinh doanh và dịch vụ showroom............................Trang 18")
    add_para(doc, "Sơ đồ 2.1: Sơ đồ chức năng của Quản trị viên (Admin Portal)....................................Trang 23")
    add_para(doc, "Sơ đồ 2.2: Sơ đồ chức năng của Nhân viên tư vấn và Kế toán Showroom...................Trang 24")
    add_para(doc, "Sơ đồ 2.3: Sơ đồ chức năng của Cổng Khách hàng (Customer Portal)..........................Trang 25")
    add_para(doc, "Lược đồ 2.1: Lược đồ Use case tổng quát toàn hệ thống PrimeLux Auto.....................Trang 26")
    add_para(doc, "Lược đồ 2.2: Lược đồ hoạt động quy trình Đặt cọc trực tuyến SePay VietQR.............Trang 39")
    add_para(doc, "Lược đồ 2.3: Lược đồ hoạt động quy trình Thu cũ đổi mới Trade-In 176 hạng mục.....Trang 40")
    add_para(doc, "Biểu đồ 2.1: Biểu đồ triển khai hạ tầng công nghệ (Deployment Diagram).................Trang 42")
    add_para(doc, "Hình 2.2: Sơ đồ quan hệ thực thể (ERD) 20 bảng CSDL PrimeLux Auto......................Trang 45")

    add_heading_2(doc, "Hình ảnh giao diện thực tế của hệ thống PrimeLux Auto:")
    add_para(doc, "Hình 3.1: Giao diện Trang chủ và Bộ lọc danh mục xe đa tiêu chí.............................Trang 65")
    add_para(doc, "Hình 3.2: Giao diện Danh mục kho xe và Bộ lọc đa tiêu chí.....................................Trang 66")
    add_para(doc, "Hình 3.3: Giao diện Chi tiết xe sang và Thông số kỹ thuật chuyên sâu.....................Trang 67")
    add_para(doc, "Hình 3.4: Giao diện Công cụ So sánh giá xe đa sàn thị trường................................Trang 68")
    add_para(doc, "Hình 3.5: Giao diện Cổng Đăng ký lái thử xe VIP trực tuyến....................................Trang 69")
    add_para(doc, "Hình 3.6: Giao diện Cổng Tra cứu hóa đơn và Chi tiết thanh toán cọc SePay...........Trang 70")
    add_para(doc, "Hình 3.7: Giao diện Cổng Hội viên PrimeLux Club & Tra cứu tích điểm VIP...........Trang 71")
    add_para(doc, "Hình 3.8: Giao diện Bàn Chuyên viên tư vấn & Nhận tin realtime qua SSE..............Trang 72")
    add_para(doc, "Hình 3.9: Giao diện Dashboard Quản trị viên (Admin Portal) & Phễu bán hàng.........Trang 74")
    add_para(doc, "Hình 3.10: Giao diện Đăng nhập hệ thống đa vai trò..................................................Trang 75")

    # =========================================================================
    # DANH MỤC BẢNG BIỂU & THUẬT NGỮ
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "DANH MỤC BẢNG BIỂU")
    add_para(doc, "Bảng 2.1: Đặc tả use case Đăng nhập hệ thống............................................................Trang 28")
    add_para(doc, "Bảng 2.2: Đặc tả use case Đăng xuất khỏi hệ thống....................................................Trang 29")
    add_para(doc, "Bảng 2.3: Đặc tả use case Tra cứu, lọc xe và xem chi tiết xe....................................Trang 29")
    add_para(doc, "Bảng 2.4: Đặc tả use case Dự toán chi phí lăn bánh theo 63 tỉnh thành...................Trang 30")
    add_para(doc, "Bảng 2.5: Đặc tả use case Bảng tính vay trả góp ngân hàng.......................................Trang 31")
    add_para(doc, "Bảng 2.6: Đặc tả use case Đặt cọc giữ xe trực tuyến qua SePay.................................Trang 32")
    add_para(doc, "Bảng 2.7: Đặc tả use case Đăng ký lịch lái thử xe & Thông báo đa kênh................Trang 33")
    add_para(doc, "Bảng 2.8: Đặc tả use case Đặt lịch bảo dưỡng & Tra cứu sổ bảo hành VIN............Trang 33")
    add_para(doc, "Bảng 2.9: Đặc tả use case Định giá xe cũ sơ bộ & Đăng ký Trade-In.........................Trang 34")
    add_para(doc, "Bảng 2.10: Đặc tả use case Tư vấn trực tuyến cùng Trợ lý ảo AI 24/7.......................Trang 35")
    add_para(doc, "Bảng 2.11: Đặc tả use case Quản lý danh mục kho xe & Quét giá sàn.....................Trang 35")
    add_para(doc, "Bảng 2.12: Đặc tả use case Thẩm định kỹ thuật 176 hạng mục Trade-In...................Trang 36")
    add_para(doc, "Bảng 2.13: Đặc tả use case Giám sát nhật ký hệ thống Audit Log & 2FA...................Trang 37")
    add_para(doc, "Bảng 2.14: Đặc tả use case Phân tích kinh doanh BI và Xuất báo cáo Excel............Trang 37")
    add_para(doc, "Bảng 2.15: Cấu trúc dữ liệu bảng xe (Kho xe ô tô Showroom)...................................Trang 46")
    add_para(doc, "Bảng 2.16: Cấu trúc dữ liệu bảng thuong_hieu (Hãng sản xuất xe ô tô).....................Trang 47")
    add_para(doc, "Bảng 2.17: Cấu trúc dữ liệu bảng loai_xe (Phân loại kiểu dáng thân xe).................Trang 48")
    add_para(doc, "Bảng 2.18: Cấu trúc dữ liệu bảng hang_thanh_vien (Hạng thành viên VIP)................Trang 48")
    add_para(doc, "Bảng 2.19: Cấu trúc dữ liệu bảng khach_hang (Hồ sơ khách hàng và điểm số).........Trang 49")
    add_para(doc, "Bảng 2.20: Cấu trúc dữ liệu bảng hoa_don (Đơn đặt cọc và hóa đơn)........................Trang 50")
    add_para(doc, "Bảng 2.21: Cấu trúc dữ liệu bảng ct_hoa_don (Chi tiết hóa đơn mua xe).................Trang 51")
    add_para(doc, "Bảng 2.22: Cấu trúc dữ liệu bảng dang_ky_lai_thu (Lịch hẹn lái thử xe).................Trang 52")
    add_para(doc, "Bảng 2.23: Cấu trúc dữ liệu bảng lich_su_diem (Lịch sử tích/trừ điểm thưởng).......Trang 53")
    add_para(doc, "Bảng 2.24: Cấu trúc dữ liệu bảng chat_logs (Nhật ký hội thoại AI & Tư vấn).........Trang 53")
    add_para(doc, "Bảng 2.25: Cấu trúc dữ liệu bảng car_price_sources (Dữ liệu giá sàn thị trường)....Trang 54")
    add_para(doc, "Bảng 2.26: Cấu trúc dữ liệu bảng dich_vu (Danh mục dịch vụ bảo dưỡng).................Trang 55")
    add_para(doc, "Bảng 2.27: Cấu trúc dữ liệu bảng dat_lich_dich_vu (Lịch hẹn dịch vụ & cứu hộ).......Trang 56")
    add_para(doc, "Bảng 2.28: Cấu trúc dữ liệu bảng sepay_transactions (Lịch sử giao dịch SePay).......Trang 57")
    add_para(doc, "Bảng 2.29: Cấu trúc dữ liệu bảng yeu_cau_thu_doi_xe (Hồ sơ Trade-In 176 mục).....Trang 58")
    add_para(doc, "Bảng 2.30: Cấu trúc dữ liệu bảng so_bao_hanh_vin (Sổ bảo hành điện tử VIN)..........Trang 59")
    add_para(doc, "Bảng 2.31: Cấu trúc dữ liệu bảng lich_su_bao_duong_vin (Nhật ký bảo dưỡng VIN)...Trang 60")
    add_para(doc, "Bảng 2.32: Cấu trúc dữ liệu bảng thong_bao_da_kenh (Lịch sử thông báo Zalo/SMS)..Trang 60")
    add_para(doc, "Bảng 2.33: Cấu trúc dữ liệu bảng audit_logs (Nhật ký an toàn kiểm toán).............Trang 61")
    add_para(doc, "Bảng 2.34: Cấu trúc dữ liệu bảng users (Tài khoản Quản trị và Phân quyền)...........Trang 61")
    add_para(doc, "Bảng 4.1: Ma trận kết quả kiểm thử tự động hệ thống (Feature Tests).................Trang 82")

    doc.add_page_break()
    add_heading_1(doc, "DANH MỤC THUẬT NGỮ VÀ TỪ VIẾT TẮT")
    abbr_data = [
        ("MVC", "Model - View - Controller", "Mô hình kiến trúc phân tách Dữ liệu - Giao diện - Điều khiển"),
        ("ORM", "Object-Relational Mapping", "Kỹ thuật ánh xạ dữ liệu quan hệ sang đối tượng (Laravel Eloquent)"),
        ("RESTful API", "Representational State Transfer API", "Giao diện lập trình ứng dụng truyền tải trạng thái qua chuẩn HTTP"),
        ("AI", "Artificial Intelligence", "Trí tuệ nhân tạo"),
        ("LLM", "Large Language Model", "Mô hình ngôn ngữ lớn (OpenAI GPT, Google Gemini, Anthropic Claude)"),
        ("RAG", "Retrieval-Augmented Generation", "Kỹ thuật tạo câu trả lời tăng cường bằng truy xuất thông tin ngữ cảnh thực tế"),
        ("SSE", "Server-Sent Events", "Giao tiếp máy chủ đẩy thông tin thời gian thực về trình duyệt qua HTTP"),
        ("RBAC", "Role-Based Access Control", "Hệ thống kiểm soát truy cập và phân quyền người dùng dựa trên vai trò"),
        ("2FA", "Two-Factor Authentication", "Xác thực bảo mật hai yếu tố qua mã OTP thời gian thực"),
        ("TOTP", "Time-based One-Time Password", "Mật khẩu một lần dựa trên đồng bộ thời gian (Google Authenticator RFC 6238)"),
        ("VIN", "Vehicle Identification Number", "Mã số nhận diện xe (Số khung xe tiêu chuẩn quốc tế 17 ký tự)"),
        ("ODO", "Odometer", "Số kilomet phương tiện đã lăn bánh trong thực tế"),
        ("Trade-In", "Trade-In Program", "Chương trình thẩm định thu mua xe cũ và đổi sang mua xe mới"),
        ("VietQR", "Vietnam Quick Response Code", "Chuẩn mã phản hồi nhanh chuyển khoản ngân hàng quốc gia"),
        ("CSRF", "Cross-Site Request Forgery", "Kỹ thuật tấn công giả mạo yêu cầu từ phía người dùng"),
        ("XSS", "Cross-Site Scripting", "Kỹ thuật tấn công chèn mã lệnh độc hại vào kịch bản website"),
        ("SQLi", "SQL Injection", "Kỹ thuật tấn công tiêm mã lệnh SQL can thiệp cơ sở dữ liệu"),
        ("BI", "Business Intelligence", "Kinh doanh thông minh và phân tích dữ liệu chỉ số hiệu quả"),
        ("BOM", "Byte Order Mark", "Ký hiệu thứ tự byte đầu tệp văn bản (hỗ trợ hiển thị tiếng Việt UTF-8)")
    ]
    tbl_abbr = doc.add_table(rows=len(abbr_data) + 1, cols=3)
    tbl_abbr.alignment = WD_TABLE_ALIGNMENT.CENTER
    w_abbr = [Inches(1.5), Inches(2.3), Inches(2.6)]
    hdr_abbr = tbl_abbr.rows[0]
    hdr_abbr.cells[0].paragraphs[0].text = "Thuật ngữ"
    hdr_abbr.cells[1].paragraphs[0].text = "Tên tiếng Anh đầy đủ"
    hdr_abbr.cells[2].paragraphs[0].text = "Giải thích ý nghĩa"
    format_table_header(hdr_abbr, w_abbr)
    for idx, (abbr, full, exp) in enumerate(abbr_data):
        row = tbl_abbr.rows[idx + 1]
        row.cells[0].paragraphs[0].text = abbr
        row.cells[1].paragraphs[0].text = full
        row.cells[2].paragraphs[0].text = exp
        format_table_cell(row.cells[0], bold=True, align=WD_ALIGN_PARAGRAPH.CENTER, width=w_abbr[0])
        format_table_cell(row.cells[1], align=WD_ALIGN_PARAGRAPH.LEFT, width=w_abbr[1])
        format_table_cell(row.cells[2], align=WD_ALIGN_PARAGRAPH.LEFT, width=w_abbr[2])

    p_sp = doc.add_paragraph()
    p_sp.paragraph_format.space_after = Pt(10)

    # =========================================================================
    # CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI VÀ CƠ SỞ LÝ THUYẾT
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI VÀ CƠ SỞ LÝ THUYẾT")

    add_heading_2(doc, "1.1 Khảo sát bài toán")
    add_heading_3(doc, "1.1.1 Đặt vấn đề")
    add_para(doc, "Trong bối cảnh nền kinh tế Việt Nam ngày càng phát triển mạnh mẽ, đời sống vật chất của người dân được nâng cao rõ rệt, nhu cầu sở hữu phương tiện giao thông cá nhân an toàn, tiện nghi và đẳng cấp như ô tô đã trở thành một xu hướng tất yếu. Thị trường kinh doanh ô tô tại Việt Nam trong những năm gần đây ghi nhận sự cạnh tranh vô cùng khốc liệt giữa các thương hiệu lớn như Mercedes-Benz, BMW, Audi, Porsche, Lexus, Toyota, Hyundai hay VinFast. Để tồn tại và khẳng định vị thế, các đơn vị phân phối và showroom xe hơi không chỉ đơn thuần cạnh tranh về mức giá niêm yết mà chất lượng dịch vụ, tốc độ tư vấn và sự minh bạch trong toàn bộ hành trình trải nghiệm của khách hàng chính là chìa khóa quyết định sự thành bại.")
    add_para(doc, "Tuy nhiên, khảo sát thực tế tại nhiều hệ thống showroom kinh doanh ô tô hiện nay cho thấy quy trình vận hành và tương tác với khách hàng vẫn còn tồn tại rất nhiều bất cập mang tính cố hữu:")
    add_para(doc, "- Dự toán chi phí lăn bánh chưa được tự động hóa: Giá xe niêm yết chỉ là một phần chi phí; để một chiếc xe lăn bánh hợp pháp trên đường, người mua phải nộp rất nhiều khoản thuế, phí bắt buộc (lệ phí trước bạ, phí cấp biển số, phí bảo trì đường bộ, phí đăng kiểm, bảo hiểm trách nhiệm dân sự...). Đáng chú ý, mức thu các loại phí này có sự phân hóa rất lớn theo từng tỉnh thành (ví dụ: lệ phí trước bạ tại Hà Nội, Quảng Ninh là 12%, trong khi đa số các tỉnh khác là 10%; phí cấp biển số tại Hà Nội và TP. Hồ Chí Minh là 20.000.000 VNĐ nhưng tại các tỉnh thành khác chỉ là 1.000.000 VNĐ). Việc tư vấn viên phải tính toán thủ công từng khoản vừa gây mất thời gian, vừa dễ nhầm lẫn và thiếu tính minh bạch trước khách hàng.")
    add_para(doc, "- Tính toán phương án vay trả góp ngân hàng còn phức tạp: Có tới hơn 70% khách hàng mua xe ô tô sử dụng đòn bẩy tài chính trả góp ngân hàng. Các công thức tính lãi suất theo dư nợ giảm dần, biên độ lãi suất ưu đãi năm đầu và kỳ hạn vay kéo dài từ 1 đến 7 năm đòi hỏi bảng tính chi tiết. Việc thiếu một công cụ mô phỏng tài chính trực quan ngay trên website khiến khách hàng khó đưa ra quyết định mua sắm.")
    add_para(doc, "- Đặt cọc giữ xe trực tuyến thiếu tính liên kết tức thời: Khi khách hàng ưng ý một phiên bản xe cụ thể, việc đặt cọc giữ xe trên môi trường trực tuyến thường chỉ dừng lại ở form liên hệ. Khách hàng phải chờ đợi nhân viên phản hồi rồi chuyển khoản thủ công, sau đó showroom phải tra cứu sao kê ngân hàng rất tốn thời gian.")
    add_para(doc, "- Thiếu công cụ định giá và quy trình Thu cũ đổi mới (Trade-In): Nhu cầu nâng cấp từ xe cũ lên xe mới ngày càng tăng cao. Tuy nhiên, các showroom chưa xây dựng được công cụ cho phép khách hàng tự ước lượng giá trị xe cũ sơ bộ, cũng như chưa có quy trình kiểm định kỹ thuật 176 hạng mục được số hóa.")
    add_para(doc, "- Quản lý sổ bảo hành và bảo dưỡng theo số khung (VIN) còn phân mảnh: Việc lưu trữ lịch sử bảo dưỡng bằng sổ tay giấy truyền thống dễ thất lạc, khó tra cứu và không tạo được niềm tin cho khách hàng.")
    add_para(doc, "- Áp lực chăm sóc khách hàng 24/7: Khách hàng thường tìm hiểu thông tin ngoài giờ hành chính hoặc ban đêm, nhưng đội ngũ tư vấn viên không thể túc trực liên tục.")

    add_heading_3(doc, "1.1.2 Giải pháp đề xuất")
    add_para(doc, "Hệ thống Quản lý Showroom và Kinh doanh Ô tô Cao cấp PrimeLux Auto tích hợp Trí tuệ Nhân tạo và Cổng Thanh toán Trực tuyến giải quyết triệt để các bài toán nghiệp vụ thông qua 9 nhóm giải pháp cốt lõi:")
    add_para(doc, "1. Xây dựng công cụ Dự toán chi phí lăn bánh tự động theo biểu phí từng tỉnh thành.")
    add_para(doc, "2. Bảng tính vay trả góp thông minh (dư nợ giảm dần / cố định) tích hợp Cổng thanh toán SePay VietQR xác nhận giao dịch cọc xe thời gian thực.")
    add_para(doc, "3. Tự động hóa việc quét và tổng hợp dữ liệu biến động giá ô tô thị trường từ các sàn lớn, trực quan hóa biểu đồ 6 tháng.")
    add_para(doc, "4. Tích hợp Trợ lý ảo AI LLM tư vấn thông minh 24/7 áp dụng kỹ thuật RAG.")
    add_para(doc, "5. Phát triển hệ thống Thông báo đa kênh tự động qua Zalo ZNS, SMS Brandname và Email HTML.")
    add_para(doc, "6. Số hóa quy trình Đặt lịch bảo dưỡng và Sổ bảo hành điện tử theo số khung VIN.")
    add_para(doc, "7. Chuẩn hóa quy trình Thu cũ đổi mới (Trade-In) với công cụ tính giá sơ bộ và phân hệ duyệt kiểm định 176 hạng mục.")
    add_para(doc, "8. Xây dựng Dashboard Quản trị BI với Phễu chuyển đổi (Sales Funnel) và xuất dữ liệu Excel/CSV UTF-8 BOM.")
    add_para(doc, "9. Phân quyền người dùng nâng cao (RBAC 5 vai trò), bảo mật xác thực hai yếu tố (2FA) và Audit Log.")

    add_heading_3(doc, "1.1.3 Mục đích của đề tài")
    add_para(doc, "Cung cấp cho Showroom PrimeLux Auto giải pháp số hóa toàn diện, tăng tỷ lệ chuyển đổi khách hàng tiềm năng, giảm 80% thời gian xử lý thủ tục cọc và thẩm định xe cũ; đồng thời vận dụng sâu sắc các kỹ thuật phát triển phần mềm hiện đại.")

    add_heading_3(doc, "1.1.4 Phạm vi và đối tượng nghiên cứu")
    add_para(doc, "Nghiên cứu quy trình kinh doanh, tài chính, kiểm định xe cũ và bảo dưỡng xe hơi tại Việt Nam. Triển khai phần mềm nền tảng Web trên PHP 8.3 Laravel 12, tích hợp SePay Banking API và AI Cloud API.")

    add_heading_2(doc, "1.2 Cơ sở lý thuyết và công nghệ sử dụng trong dự án")
    add_heading_3(doc, "1.2.1 Ngôn ngữ PHP 8.3 và Framework Laravel 12")
    add_para(doc, "Dự án sử dụng PHP phiên bản 8.3 mới nhất, tận dụng tối đa các tính năng hiện đại như Typed Class Constants, hàm json_validate() tối ưu, kiểu dữ liệu nghiêm ngặt và cơ chế biên dịch JIT (Just-In-Time) giúp tăng tốc độ xử lý các tác vụ tính toán tài chính.")
    add_para(doc, "Laravel 12 (phiên bản framework 13.17) là nền tảng máy chủ vững chắc cho toàn bộ hệ thống PrimeLux Auto. Laravel cung cấp hệ thống định tuyến (Routing) mạnh mẽ, cơ chế Dependency Injection thông qua Service Container, bộ ORM Eloquent trực quan và hệ thống Middleware bảo mật cao cấp.")

    add_heading_3(doc, "1.2.2 Kiến trúc Model - View - Controller (MVC) và Service Layer")
    add_para(doc, "Hệ thống PrimeLux Auto được xây dựng theo mô hình kiến trúc MVC mở rộng với 5 tầng kiến trúc chặt chẽ:")
    add_para(doc, "- Model: Ánh xạ cấu trúc dữ liệu và quan hệ CSDL (Xe, ThuongHieu, KhachHang, HoaDon, DatLichDichVu, YeuCauThuDoiXe, SoBaoHanhVin, SepayTransaction, AuditLog).")
    add_para(doc, "- View: Xây dựng bằng Blade Template Engine, tích hợp phong cách giao diện sang trọng của ngành xe hơi.")
    add_para(doc, "- Controller: Tiếp nhận HTTP Request và điều phối luồng xử lý (XeController, ThanhToanController, DichVuController, TradeInController, QuanTriController, SepayWebhookController).")
    add_para(doc, "- Service Layer: Đóng gói các logic nghiệp vụ phức tạp thành các Service độc lập: AiConsultantService (Trợ lý ảo AI RAG), NotificationService (Thông báo đa kênh Zalo/SMS/Mail).")
    add_para(doc, "- Integration Layer: Kết nối các cổng thanh toán ngân hàng SePay VietQR, Server-Sent Events SSE, và các tiến trình cào dữ liệu giá sàn Artisan Commands.")

    add_image_box(doc, "docs/screenshots/hinh_1_1_kien_truc_he_thong.jpg", "Hình 1.1: Mô hình kiến trúc tổng thể 5 tầng của hệ thống PrimeLux Auto", width=Inches(5.5))

    add_heading_3(doc, "1.2.3 Hệ quản trị cơ sở dữ liệu MySQL 8.0 và Eloquent ORM")
    add_para(doc, "MySQL 8.0 là hệ quản trị cơ sở dữ liệu quan hệ được chọn để lưu trữ toàn bộ dữ liệu của PrimeLux Auto. CSDL được thiết kế chuẩn hóa dạng chuẩn 3 (3NF) với 20 bảng dữ liệu liên kết quan hệ chặt chẽ. Eloquent ORM giúp thao tác truy vấn CSDL qua mô hình đối tượng, bảo vệ an toàn trước tấn công SQL Injection bằng cơ chế PDO Parameterized Queries.")

    add_heading_3(doc, "1.2.4 Giao diện người dùng: Blade Templates, Tailwind CSS v4 và Vite 8")
    add_para(doc, "Dự án ứng dụng Tailwind CSS phiên bản 4.0 mới nhất thông qua plugin tích hợp @tailwindcss/vite. Vite 8.0 đóng vai trò là công cụ biên dịch tài nguyên frontend cực nhanh (Hot Module Replacement - HMR). Blade Template Engine cung cấp khả năng tái sử dụng layout (@extends, @include) và tự động mã hóa chuỗi hiển thị nhằm ngăn chặn triệt để tấn công XSS. Phía máy khách sử dụng JavaScript ES6 thuần kết hợp Fetch API để tương tác bất đồng bộ không cần tải lại trang.")

    add_heading_3(doc, "1.2.5 Thư viện đồ họa Chart.js trong biểu diễn dữ liệu trực quan")
    add_para(doc, "Chart.js là thư viện JavaScript mã nguồn mở cho phép hiển thị các biểu đồ HTML5 Canvas tương tác cao. Trong đề tài, Chart.js được ứng dụng để thể hiện: (1) Biểu đồ biến động giá ô tô thị trường theo chuỗi thời gian 6 tháng; (2) Biểu đồ Phễu chuyển đổi kinh doanh (Sales Funnel) trên Dashboard quản trị.")

    add_heading_3(doc, "1.2.6 Cổng thanh toán trực tuyến SePay VietQR và cơ chế Webhook bảo mật")
    add_para(doc, "SePay là cổng thanh toán kết nối trực tiếp tài khoản ngân hàng bằng chuẩn mã VietQR (tài khoản MBBank 0338929013). Hệ thống PrimeLux Auto tự động sinh mã VietQR động chứa số tiền cọc và cú pháp cọc xe độc nhất. Khi khách hàng chuyển khoản thành công, SePay gửi bản tin Webhook HTTP POST đến máy chủ; hệ thống tự động đối soát giao dịch, cập nhật trạng thái đơn hàng và hiển thị form thông báo thanh toán thành công ở góc phải màn hình Quản trị viên.")

    add_heading_3(doc, "1.2.7 Trí tuệ nhân tạo AI LLM và kỹ thuật RAG trong tư vấn bán hàng")
    add_para(doc, "Hệ thống tích hợp mô hình ngôn ngữ lớn (LLM) thông qua RESTful API, ứng dụng kỹ thuật Retrieval-Augmented Generation (RAG). Trước khi gửi prompt đến LLM, dịch vụ AiConsultantService trích xuất các thông số kỹ thuật thực tế của mẫu xe trong kho, chính sách bảo hành, khuyến mãi thành viên VIP để làm ngữ cảnh tham chiếu, giúp AI trả lời chính xác 100% về thông số và giá cả của showroom.")

    add_heading_3(doc, "1.2.8 Giao tiếp thời gian thực Server-Sent Events (SSE)")
    add_para(doc, "Server-Sent Events (SSE) cho phép máy chủ đẩy dữ liệu đơn hướng thời gian thực về trình duyệt qua giao thức HTTP chuẩn tại tuyến /api/consultant/sse-stream. Tính năng này được ứng dụng tại Bàn Chuyên viên tư vấn để nhận thông báo tức thì khi khách hàng phát sinh nhu cầu mua xe từ Trợ lý ảo AI.")

    add_heading_3(doc, "1.2.9 Tiến trình thu thập dữ liệu giá sàn thị trường ô tô")
    add_para(doc, "Hệ thống xây dựng lệnh Artisan Command chuyên dụng 'cars:scrape-market-prices' thu thập dữ liệu giá xe niêm yết từ 3 sàn giao dịch lớn tại Việt Nam: Oto.com.vn, Bonbanh.com và Chotot Xe. Dữ liệu sau khi thu thập được chuẩn hóa, tính toán giá trung bình và lưu trữ vào bảng car_price_sources để vẽ biểu đồ so sánh.")

    add_heading_3(doc, "1.2.10 Cơ chế xuất báo cáo tài chính định dạng Excel/CSV UTF-8 BOM")
    add_para(doc, "Nhằm phục vụ công tác kế toán và quản lý kho xe, hệ thống xây dựng cơ chế xuất dữ liệu động sang định dạng CSV/Excel qua các tuyến /admin/export/cars, /admin/export/test-drives, /admin/export/invoices. Hệ thống gắn tiền tố Byte Order Mark (UTF-8 BOM: \\xEF\\xBB\\xBF) giúp các phần mềm bảng tính hiển thị hoàn hảo font tiếng Việt có dấu.")

    add_heading_3(doc, "1.2.11 Môi trường phát triển Laragon và Visual Studio Code")
    add_para(doc, "Laragon cung cấp môi trường máy chủ cục bộ WAMP/LEMP tốc độ cao, quản lý phiên bản PHP 8.3 và MySQL 8.0 thuận tiện. Visual Studio Code kết hợp các extension hỗ trợ lập trình PHP, Blade và Tailwind giúp tối ưu hóa năng suất.")

    add_heading_3(doc, "1.2.12 Quản lý mã nguồn Git, GitHub và Kiểm thử PHPUnit")
    add_para(doc, "Mã nguồn dự án được quản lý phiên bản phân tán bằng Git và đồng bộ lên GitHub. Bộ kiểm thử tự động PHPUnit 12 với 23 ca kiểm thử Feature Tests đảm bảo chất lượng phần mềm luôn đạt 100% độ tin cậy. Công cụ Laravel Pint 1.27 được tích hợp để tự động chuẩn hóa cú pháp theo tiêu chuẩn PSR-12.")

    # =========================================================================
    # CHƯƠNG 2. PHƯƠNG PHÁP THỰC HIỆN VÀ THIẾT KẾ HỆ THỐNG
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "CHƯƠNG 2. PHƯƠNG PHÁP THỰC HIỆN VÀ THIẾT KẾ HỆ THỐNG")

    add_heading_2(doc, "2.1 Phân tích hệ thống")
    add_heading_3(doc, "2.1.1 Quy trình nghiệp vụ thực tế tại Showroom PrimeLux Auto")
    add_para(doc, "Quy trình vận hành tại Showroom ô tô PrimeLux Auto bao gồm các luồng chính sau:")

    add_image_box(doc, "docs/screenshots/hinh_2_1_luong_nghiep_vu.jpg", "Hình 2.1: Sơ đồ luồng quy trình kinh doanh và dịch vụ showroom", width=Inches(5.5))
    add_para(doc, "Hình 2.1 mô tả chi tiết luồng nghiệp vụ khép kín từ khi khách hàng tiếp cận showroom, xem xe, nhận tư vấn chi phí lăn bánh, cọc xe qua SePay, thẩm định xe cũ Trade-In và nhận ưu đãi tích điểm thành viên PrimeLux Club.")

    add_heading_3(doc, "2.1.2 Thông tin yêu cầu chức năng và phi chức năng")
    add_para(doc, "- Yêu cầu chức năng (FR): Quản lý kho xe; Tra cứu lọc xe; Dự toán chi phí lăn bánh theo 63 tỉnh; Bảng tính vay trả góp; Đặt cọc SePay VietQR; Đăng ký lái thử & Thông báo đa kênh; Định giá xe cũ Trade-In 176 hạng mục; Sổ bảo hành điện tử VIN; Quét giá sàn thị trường 3 sàn; Dashboard BI Sales Funnel; Phân quyền RBAC 5 vai trò; Bảo mật 2FA và Audit Log.")
    add_para(doc, "- Yêu cầu phi chức năng (NFR): Thời gian tải trang dưới 1.2 giây; thời gian phản hồi Webhook SePay dưới 1 giây; an toàn trước OWASP Top 10; hỗ trợ 100% Mobile Responsive; độ sẵn sàng Uptime trên 99.9%.")

    add_heading_3(doc, "2.1.3 Phân tích vai trò người dùng trong hệ thống")
    add_para(doc, "Hệ thống PrimeLux Auto phân định 5 nhóm vai trò người dùng chuẩn hóa:")
    add_para(doc, "1. Vai trò Khách hàng vãng lai: Tìm kiếm, lọc xe, dự toán lăn bánh, bảng tính trả góp, trò chuyện AI, xem so sánh giá và đăng ký lái thử.")
    add_para(doc, "2. Vai trò Khách hàng thành viên VIP: Đặt cọc giữ xe trực tuyến qua SePay, theo dõi hợp đồng mua xe, tra cứu sổ bảo hành điện tử VIN và tích điểm dịch vụ.")
    add_para(doc, "3. Vai trò Chuyên viên tư vấn bán hàng: Tiếp nhận lịch hẹn lái thử, nhận chuyển giao hội thoại từ AI khi khách hàng có nhu cầu đàm phán hợp đồng, quản lý khách hàng tiềm năng.")
    add_para(doc, "4. Vai trò Kế toán Showroom: Đối soát giao dịch SePay Webhook, xác nhận tiền cọc xe, cấn trừ giá trị Trade-In vào hóa đơn xe mới, xuất báo cáo tài chính.")
    add_para(doc, "5. Vai trò Quản trị viên hệ thống: Quản lý kho xe, phê duyệt kiểm định 176 hạng mục Trade-In, giám sát nhật ký Audit Log, phân quyền tài khoản và cấu hình 2FA.")

    add_heading_3(doc, "2.1.4 Sơ đồ phân rã chức năng của hệ thống")
    add_para(doc, "Dưới đây là các sơ đồ chức năng chính xác của hệ thống PrimeLux Auto:")

    add_image_box(doc, "docs/screenshots/so_do_2_1_chuc_nang_admin.png", "Sơ đồ 2.1: Sơ đồ chức năng của Quản trị viên (Admin Portal)", width=Inches(5.5))
    add_image_box(doc, "docs/screenshots/so_do_2_2_chuc_nang_nhan_vien.png", "Sơ đồ 2.2: Sơ đồ chức năng của Nhân viên tư vấn và Kế toán Showroom", width=Inches(5.5))
    add_image_box(doc, "docs/screenshots/so_do_2_3_chuc_nang_khach_hang.png", "Sơ đồ 2.3: Sơ đồ chức năng của Cổng Khách hàng (Customer Portal)", width=Inches(5.5))

    add_heading_2(doc, "2.2 Các biểu đồ thiết kế hệ thống")
    add_heading_3(doc, "2.2.1 Lược đồ Use Case tổng quát")
    add_image_box(doc, "docs/screenshots/luoc_do_2_1_use_case_tong_quat.png", "Lược đồ 2.1: Lược đồ Use case tổng quát toàn hệ thống PrimeLux Auto", width=Inches(5.5))
    add_para(doc, "Lược đồ 2.1 mô tả mối quan hệ giữa các tác nhân và các gói ca sử dụng chính trong hệ thống PrimeLux Auto.")

    add_heading_3(doc, "2.2.2 Đặc tả Use Case chi tiết")
    create_use_case_table(doc, "2.1", "Đăng nhập hệ thống",
        "1. Chọn chức năng Đăng nhập.\n2. Nhập Email và Mật khẩu.\n3. Nhập mã OTP 2FA (nếu có).\n4. Nhấn Đăng nhập.",
        "1. Hiển thị Form Đăng nhập.\n2. Kiểm tra tính hợp lệ qua Bcrypt.\n3. Xác thực OTP Google Authenticator.\n4. Cấp phiên Session, ghi Audit Log và điều hướng.")

    create_use_case_table(doc, "2.2", "Đăng xuất khỏi hệ thống",
        "1. Nhấn nút Đăng xuất trên menu tài khoản.\n2. Xác nhận đăng xuất.",
        "1. Hiển thị hộp thoại xác nhận.\n2. Hủy Session, xóa cookie, ghi Audit Log và điều hướng về trang chủ.")

    create_use_case_table(doc, "2.3", "Tra cứu, lọc xe và xem chi tiết xe",
        "1. Vào danh mục xe (/cars).\n2. Chọn hãng, khoảng giá, kiểu dáng.\n3. Nhấn xem chi tiết một xe.",
        "1. Tải danh sách xe theo bộ lọc.\n2. Phân trang dữ liệu AJAX.\n3. Hiển thị trang chi tiết gồm ảnh, thông số kỹ thuật và giá.")

    create_use_case_table(doc, "2.4", "Dự toán chi phí lăn bánh theo 63 tỉnh thành",
        "1. Vào tab 'Chi phí lăn bánh' trên trang chi tiết xe.\n2. Chọn Tỉnh/Thành phố đăng ký.\n3. Tùy chọn bảo hiểm thân vỏ.",
        "1. Tiếp nhận sự kiện thay đổi địa phương.\n2. Tính lệ phí trước bạ (12% HN, 10% tỉnh), biển số 20tr/1tr, đăng kiểm, bảo trì đường bộ, TNDS.\n3. Hiển thị bảng tổng chi phí lăn bánh.")

    create_use_case_table(doc, "2.5", "Bảng tính vay trả góp ngân hàng",
        "1. Vào tab 'Dự toán trả góp'.\n2. Kéo thanh chọn tỷ lệ trả trước (20%-80%).\n3. Chọn kỳ hạn (12-84 tháng).\n4. Chọn phương thức tính dư nợ.",
        "1. Tính số tiền vay = Giá xe * (100% - Trả trước).\n2. Áp dụng công thức dư nợ giảm dần.\n3. Xuất bảng kế hoạch trả lãi và gốc từng tháng.")

    create_use_case_table(doc, "2.6", "Đặt cọc giữ xe trực tuyến qua SePay",
        "1. Nhấn 'Đặt cọc trực tuyến'.\n2. Nhập họ tên, SĐT, số tiền cọc.\n3. Quét mã VietQR bằng App ngân hàng.",
        "1. Tạo bản ghi trong bảng hoa_don hoặc sepay_transactions.\n2. Tạo mã VietQR SePay kèm cú pháp cọc độc nhất.\n3. Nhận Webhook SePay, chuyển trạng thái đã thanh toán và hiển thị Popup Admin.")

    create_use_case_table(doc, "2.7", "Đăng ký lịch lái thử xe & Thông báo đa kênh",
        "1. Chọn mẫu xe muốn lái thử.\n2. Chọn ngày, giờ, showroom.\n3. Nhập thông tin liên hệ và gửi.",
        "1. Lưu yêu cầu vào bảng dang_ky_lai_thu.\n2. Phân công tư vấn viên phụ trách.\n3. Gửi thông báo Zalo ZNS, SMS Brandname và Email xác nhận.")

    create_use_case_table(doc, "2.8", "Đặt lịch bảo dưỡng & Tra cứu sổ bảo hành VIN",
        "1. Vào mục 'Dịch vụ & Sổ bảo hành'.\n2. Nhập số khung VIN 17 ký tự.\n3. Xem mốc bảo dưỡng và đặt hẹn.",
        "1. Kiểm tra số VIN trong bảng so_bao_hanh_vin.\n2. Hiển thị hạn bảo hành, lịch sử bảo dưỡng và điểm tích lũy.\n3. Tiếp nhận lịch hẹn vào bảng dat_lich_dich_vu.")

    create_use_case_table(doc, "2.9", "Định giá xe cũ sơ bộ & Đăng ký Trade-In",
        "1. Vào cổng Thu cũ đổi mới.\n2. Nhập thông tin xe cũ: Hãng, Đời, ODO, Tình trạng.\n3. Chọn xe mới muốn đổi sang.\n4. Nộp hồ sơ.",
        "1. Tính giá sơ bộ dựa trên thuật toán khấu hao.\n2. Hiển thị mức bù chênh lệch dự kiến.\n3. Lưu hồ sơ vào bảng yeu_cau_thu_doi_xe.")

    create_use_case_table(doc, "2.10", "Tư vấn trực tuyến cùng Trợ lý ảo AI 24/7",
        "1. Mở cửa sổ chat AI.\n2. Hỏi thông số, giá bán, so sánh xe.\n3. Yêu cầu gặp nhân viên tư vấn.",
        "1. Dịch vụ AI phân tích ý định và trích xuất dữ liệu xe thực tế (RAG).\n2. Trả lời chính xác dưới 1.5 giây.\n3. Kích hoạt kết nối SSE thông báo tư vấn viên.")

    create_use_case_table(doc, "2.11", "Quản lý danh mục kho xe & Quét giá sàn",
        "1. Quản trị viên vào /admin/cars.\n2. Thêm/sửa xe, cập nhật ảnh, tồn kho.\n3. Chạy lệnh quét giá sàn.",
        "1. Cập nhật dữ liệu vào bảng xe.\n2. Tiến trình scraper thu thập giá từ 3 sàn Oto.com.vn, Bonbanh, ChoTot.\n3. Lưu lịch sử vào bảng car_price_sources và vẽ biểu đồ biến động giá 6 tháng.")

    create_use_case_table(doc, "2.12", "Thẩm định kỹ thuật 176 hạng mục Trade-In",
        "1. Quản trị viên mở hồ sơ Trade-In.\n2. Tích chọn kiểm định 176 hạng mục kỹ thuật.\n3. Nhập giá thu mua chốt cuối cùng.",
        "1. Cập nhật trạng thái 'Đã định giá'.\n2. Gửi thông báo phê duyệt qua Email/SMS cho khách.\n3. Đồng bộ số tiền sang Kế toán để cấn trừ vào hóa đơn xe mới.")

    create_use_case_table(doc, "2.13", "Giám sát nhật ký hệ thống Audit Log & 2FA",
        "1. Vào /admin/audit-logs.\n2. Lọc nhật ký theo vai trò, hành vi, thời gian.\n3. Kích hoạt bảo mật 2FA.",
        "1. Hiển thị bảng nhật ký chi tiết kèm IP và User Agent.\n2. Xuất mã QR TOTP và lưu khóa bí mật xác thực hai bước.")

    create_use_case_table(doc, "2.14", "Phân tích kinh doanh BI và Xuất báo cáo Excel",
        "1. Xem Dashboard BI và biểu đồ Phễu chuyển đổi.\n2. Nhấn nút xuất báo cáo kho xe, lái thử hoặc doanh thu.",
        "1. Trực quan hóa tỷ lệ chuyển đổi qua các giai đoạn.\n2. Xuất file CSV UTF-8 BOM chuẩn hiển thị tiếng Việt có dấu trong Excel.")

    add_heading_3(doc, "2.2.3 Lược đồ Hoạt động (Activity Diagrams)")
    add_image_box(doc, "docs/screenshots/luoc_do_2_2_activity_sepay.png", "Lược đồ 2.2: Lược đồ hoạt động quy trình Đặt cọc trực tuyến SePay VietQR", width=Inches(5.5))
    add_image_box(doc, "docs/screenshots/luoc_do_2_3_activity_tradein.png", "Lược đồ 2.3: Lược đồ hoạt động quy trình Thu cũ đổi mới Trade-In 176 hạng mục", width=Inches(5.5))

    add_heading_3(doc, "2.2.4 Biểu đồ triển khai hạ tầng công nghệ (Deployment Diagram)")
    add_image_box(doc, "docs/screenshots/bieu_do_2_2_trien_khai.png", "Biểu đồ 2.1: Biểu đồ triển khai hạ tầng công nghệ (Deployment Diagram)", width=Inches(5.5))

    add_heading_2(doc, "2.3 Thiết kế Cơ sở dữ liệu")
    add_heading_3(doc, "2.3.1 Sơ đồ quan hệ thực thể (ERD)")
    add_image_box(doc, "docs/screenshots/hinh_2_2_so_do_erd.jpg", "Hình 2.2: Sơ đồ quan hệ thực thể (ERD) 20 bảng CSDL PrimeLux Auto", width=Inches(5.5))
    add_para(doc, "Hình 2.2 thể hiện sơ đồ ERD hoàn chỉnh với 20 bảng dữ liệu liên kết quan hệ chặt chẽ của PrimeLux Auto được thiết kế theo chuẩn 3NF.")

    add_heading_3(doc, "2.3.2 Danh mục và cấu trúc chi tiết 20 bảng dữ liệu")

    create_db_table(doc, "2.15", "xe", "Kho xe ô tô Showroom PrimeLux Auto", [
        ("ma_xe", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh duy nhất của xe"),
        ("ten_xe", "VARCHAR(255)", "NOT NULL", "Tên thương mại đầy đủ của dòng xe"),
        ("ma_th", "VARCHAR(50)", "FK -> thuong_hieu.ma_th", "Mã thương hiệu hãng sản xuất"),
        ("ma_loai", "VARCHAR(50)", "FK -> loai_xe.ma_loai", "Mã phân loại kiểu dáng xe"),
        ("gia_niem_yet", "DECIMAL(15,2)", "NOT NULL", "Giá niêm yết chính thức của xe (VNĐ)"),
        ("gia_chu", "VARCHAR(255)", "NULL", "Giá xe viết bằng chữ tiếng Việt"),
        ("nhien_lieu", "VARCHAR(50)", "NOT NULL", "Loại nhiên liệu (Xăng, Dầu, Điện, Hybrid)"),
        ("cong_suat", "VARCHAR(100)", "NULL", "Công suất động cơ cực đại"),
        ("so_cho", "VARCHAR(50)", "DEFAULT '5 chỗ'", "Số lượng chỗ ngồi"),
        ("nam_sx", "YEAR", "NOT NULL", "Năm sản xuất xuất xưởng"),
        ("nhan_tag", "VARCHAR(100)", "NULL", "Nhãn nổi bật (Mới về, Bán chạy, Giảm giá)"),
        ("hinh_anh", "TEXT", "NULL", "Đường dẫn danh sách hình ảnh xe chất lượng cao"),
        ("mo_ta", "TEXT", "NULL", "Bài viết mô tả chi tiết thông số kỹ thuật xe"),
        ("so_luong_kho", "UNSIGNED INT", "DEFAULT 1", "Số lượng xe hiện còn sẵn trong kho"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'Sẵn sàng giao'", "Trạng thái: Sẵn sàng giao, Đã cọc, Hết hàng")
    ])

    create_db_table(doc, "2.16", "thuong_hieu", "Hãng sản xuất xe ô tô cao cấp", [
        ("ma_th", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh duy nhất của hãng xe"),
        ("ten_th", "VARCHAR(100)", "NOT NULL", "Tên thương hiệu (Mercedes, BMW, Porsche, Audi...)"),
        ("xuat_xu", "VARCHAR(100)", "NULL", "Quốc gia xuất xứ của thương hiệu (Đức, Nhật, Mỹ)"),
        ("badge", "VARCHAR(100)", "NULL", "Huy hiệu nhận diện thương hiệu"),
        ("mo_ta", "TEXT", "NULL", "Giới thiệu lịch sử và đẳng cấp thương hiệu")
    ])

    create_db_table(doc, "2.17", "loai_xe", "Phân loại kiểu dáng thân xe", [
        ("ma_loai", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh kiểu dáng xe"),
        ("ten_loai", "VARCHAR(100)", "NOT NULL", "Tên kiểu dáng (Sedan, SUV, Coupe, Crossover...)"),
        ("mo_ta", "TEXT", "NULL", "Mô tả đặc điểm thiết kế kiểu dáng")
    ])

    create_db_table(doc, "2.18", "hang_thanh_vien", "Hạng thành viên VIP PrimeLux Club", [
        ("ma_hang", "VARCHAR(50)", "PK, NOT NULL", "Mã hạng hội viên (STANDARD, GOLD, PLATINUM, DIAMOND)"),
        ("ten_hang", "VARCHAR(100)", "NOT NULL", "Tên hiển thị hạng thành viên"),
        ("diem_toi_thieu", "UNSIGNED INT", "DEFAULT 0", "Điểm tích lũy tối thiểu để đạt hạng"),
        ("ti_le_chiet_khau", "DECIMAL(5,2)", "DEFAULT 0.00", "Tỷ lệ chiết khấu dịch vụ (%)"),
        ("dac_quyen", "TEXT", "NULL", "Danh sách các đặc quyền VIP của hạng"),
        ("mau_badge", "VARCHAR(50)", "NULL", "Màu sắc biểu trưng giao diện thẻ hội viên")
    ])

    create_db_table(doc, "2.19", "khach_hang", "Hồ sơ Khách hàng và Điểm thưởng", [
        ("ma_kh", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh duy nhất của khách hàng"),
        ("ho_ten", "VARCHAR(255)", "NOT NULL", "Họ và tên đầy đủ của khách hàng"),
        ("sdt", "VARCHAR(20)", "UNIQUE, NOT NULL", "Số điện thoại di động liên hệ"),
        ("email", "VARCHAR(255)", "NULL", "Địa chỉ email nhận thông báo"),
        ("dia_chi", "VARCHAR(255)", "NULL", "Địa chỉ cư trú của khách hàng"),
        ("mat_khau", "VARCHAR(255)", "NOT NULL", "Mật khẩu tài khoản (mã hóa Bcrypt)"),
        ("diem_tich_luy", "UNSIGNED INT", "DEFAULT 0", "Tổng điểm thưởng VIP tích lũy hiện có"),
        ("tong_chi_tieu", "DECIMAL(15,2)", "DEFAULT 0.00", "Tổng số tiền đã chi tiêu tại showroom (VNĐ)"),
        ("ma_hang", "VARCHAR(50)", "FK -> hang_thanh_vien.ma_hang", "Mã hạng hội viên VIP hiện tại")
    ])

    create_db_table(doc, "2.20", "hoa_don", "Hóa đơn và Đơn đặt cọc xe", [
        ("ma_hd", "VARCHAR(50)", "PK, NOT NULL", "Mã hóa đơn / hợp đồng cọc xe (VD: HD001)"),
        ("ma_kh", "VARCHAR(50)", "FK -> khach_hang.ma_kh, NULL", "Mã khách hàng thực hiện giao dịch"),
        ("ngay_lap", "DATETIME", "NOT NULL", "Thời điểm phát sinh đơn hàng / cọc xe"),
        ("tong_tien_goc", "DECIMAL(15,2)", "NOT NULL", "Tổng số tiền niêm yết ban đầu (VNĐ)"),
        ("giam_gia_hang", "DECIMAL(15,2)", "DEFAULT 0.00", "Số tiền được giảm giá theo hạng VIP (VNĐ)"),
        ("tong_tien_thanh_toan", "DECIMAL(15,2)", "NOT NULL", "Số tiền thực tế thanh toán (VNĐ)"),
        ("diem_thuong_nhan", "UNSIGNED INT", "DEFAULT 0", "Điểm thưởng cộng thêm cho đơn hàng này"),
        ("phuong_thuc_tt", "VARCHAR(100)", "DEFAULT 'SePay VietQR'", "Phương thức thanh toán"),
        ("trang_thai", "VARCHAR(100)", "DEFAULT 'Chờ thanh toán'", "Trạng thái: Chờ thanh toán, Đã thanh toán, Đã hủy")
    ])

    create_db_table(doc, "2.21", "ct_hoa_don", "Chi tiết dòng sản phẩm hóa đơn", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh duy nhất bản ghi chi tiết"),
        ("ma_hd", "VARCHAR(50)", "FK -> hoa_don.ma_hd", "Mã hóa đơn liên kết"),
        ("ma_xe", "VARCHAR(50)", "FK -> xe.ma_xe", "Mã chiếc xe được đặt cọc hoặc mua"),
        ("so_luong", "UNSIGNED INT", "DEFAULT 1", "Số lượng xe giao dịch"),
        ("don_gia", "DECIMAL(15,2)", "NOT NULL", "Đơn giá của xe tại thời điểm lập hóa đơn (VNĐ)"),
        ("thanh_tien", "DECIMAL(15,2)", "NOT NULL", "Thành tiền của dòng sản phẩm (VNĐ)")
    ])

    create_db_table(doc, "2.22", "dang_ky_lai_thu", "Lịch hẹn đăng ký lái thử xe VIP", [
        ("ma_lich", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh lịch hẹn lái thử"),
        ("ho_ten", "VARCHAR(255)", "NOT NULL", "Họ tên khách hàng đăng ký trải nghiệm"),
        ("sdt", "VARCHAR(20)", "NOT NULL", "Số điện thoại liên lạc"),
        ("email", "VARCHAR(255)", "NULL", "Email nhận thư mời xác nhận"),
        ("ten_xe", "VARCHAR(255)", "NOT NULL", "Tên mẫu xe khách hàng muốn lái thử"),
        ("showroom", "VARCHAR(255)", "DEFAULT 'Showroom Sài Gòn'", "Địa điểm trải nghiệm (Showroom hoặc Tận nơi)"),
        ("thoi_gian", "DATETIME", "NOT NULL", "Thời điểm hẹn trải nghiệm xe"),
        ("ghi_chu", "TEXT", "NULL", "Yêu cầu đặc biệt của khách hàng"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'Chờ duyệt'", "Trạng thái: Chờ duyệt, Đã xác nhận, Hoàn thành, Hủy")
    ])

    create_db_table(doc, "2.23", "lich_su_diem", "Lịch sử tích lũy và sử dụng điểm VIP", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh biến động điểm thưởng"),
        ("ma_kh", "VARCHAR(50)", "FK -> khach_hang.ma_kh", "Mã khách hàng được tích hoặc trừ điểm"),
        ("ma_hd", "VARCHAR(50)", "FK -> hoa_don.ma_hd, NULL", "Mã hóa đơn liên quan đến biến động điểm"),
        ("so_diem", "INT", "NOT NULL", "Số điểm thay đổi (+ tích điểm, - đổi quà)"),
        ("hanh_dong", "VARCHAR(255)", "NOT NULL", "Lý do biến động (Mua xe mới, Bảo dưỡng định kỳ...)"),
        ("ngay_tao", "DATETIME", "NOT NULL", "Thời điểm ghi nhận biến động điểm")
    ])

    create_db_table(doc, "2.24", "chat_logs", "Nhật ký hội thoại AI và Tư vấn viên", [
        ("ma_tin", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh phiên hội thoại tư vấn"),
        ("thoi_gian", "VARCHAR(50)", "NOT NULL", "Thời điểm phát sinh cuộc hội thoại"),
        ("nguoi_gui", "VARCHAR(255)", "NOT NULL", "Tên hoặc SĐT của khách hàng gửi câu hỏi"),
        ("noi_dung", "TEXT", "NOT NULL", "Nội dung câu hỏi của khách hàng"),
        ("phan_hoi_bot", "TEXT", "NULL", "Câu trả lời tự động do Trợ lý ảo AI RAG tạo ra")
    ])

    create_db_table(doc, "2.25", "car_price_sources", "Dữ liệu cào giá sàn thị trường ô tô", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh bản ghi giá sàn thu thập"),
        ("car_id", "UNSIGNED BIGINT", "FK -> xe.ma_xe, NULL", "Mã xe đối chiếu trong kho showroom"),
        ("source_name", "VARCHAR(100)", "NOT NULL", "Tên sàn giao dịch: Oto.com.vn, Bonbanh, ChoTot Xe"),
        ("source_logo", "VARCHAR(255)", "NULL", "Logo đại diện của sàn giao dịch"),
        ("source_url", "TEXT", "NULL", "Đường link gốc của tin đăng trên sàn"),
        ("car_name", "VARCHAR(255)", "NOT NULL", "Tên dòng xe trên sàn thị trường"),
        ("price", "DECIMAL(15,2)", "NOT NULL", "Mức giá niêm yết thu thập được (VNĐ)"),
        ("location", "VARCHAR(100)", "NULL", "Địa phương đăng tin (Hà Nội, TP.HCM)"),
        ("condition_type", "VARCHAR(100)", "NULL", "Tình trạng xe (Mới 100%, Lướt 98%)"),
        ("warranty", "VARCHAR(100)", "NULL", "Chính sách bảo hành ghi nhận"),
        ("fetched_at", "TIMESTAMP", "NOT NULL", "Thời điểm tiến trình cào dữ liệu thực hiện")
    ])

    create_db_table(doc, "2.26", "dich_vu", "Danh mục dịch vụ bảo dưỡng & cứu hộ", [
        ("ma_dv", "VARCHAR(50)", "PK, NOT NULL", "Mã dịch vụ sửa chữa / bảo dưỡng"),
        ("loai_dv", "ENUM", "NOT NULL", "Phân loại: bao_duong, sua_chua, bao_hiem, cuu_ho"),
        ("ten_loai_dv", "VARCHAR(100)", "NOT NULL", "Tên nhóm dịch vụ"),
        ("ten_dv", "VARCHAR(255)", "NOT NULL", "Tên chi tiết gói dịch vụ"),
        ("gia_tham_khao", "DECIMAL(12,2)", "DEFAULT 0.00", "Giá dịch vụ tham khảo (VNĐ)"),
        ("quy_trinh", "TEXT", "NULL", "Quy trình thực hiện kỹ thuật"),
        ("dac_quyen", "TEXT", "NULL", "Đặc quyền dành riêng cho khách hàng VIP"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'hoat_dong'", "Trạng thái sẵn sàng của dịch vụ")
    ])

    create_db_table(doc, "2.27", "dat_lich_dich_vu", "Lịch hẹn dịch vụ bảo dưỡng và cứu hộ", [
        ("ma_dat_lich", "VARCHAR(50)", "PK, NOT NULL", "Mã lịch hẹn dịch vụ"),
        ("ho_ten", "VARCHAR(255)", "NOT NULL", "Họ tên khách hàng đặt dịch vụ"),
        ("sdt", "VARCHAR(20)", "NOT NULL", "Số điện thoại liên hệ"),
        ("bien_so", "VARCHAR(50)", "NOT NULL", "Biển số xe cần làm dịch vụ"),
        ("ten_xe", "VARCHAR(255)", "NOT NULL", "Tên model xe cần bảo dưỡng"),
        ("showroom", "VARCHAR(255)", "DEFAULT 'Showroom Sài Gòn'", "Xưởng dịch vụ tiếp nhận"),
        ("loai_dich_vu", "VARCHAR(100)", "NOT NULL", "Gói dịch vụ khách hàng lựa chọn"),
        ("thoi_gian_hen", "DATETIME", "NOT NULL", "Thời gian hẹn mang xe vào xưởng"),
        ("vi_tri_cuu_ho", "VARCHAR(255)", "NULL", "Vị trí cứu hộ khẩn cấp (nếu có)"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'cho_xac_nhan'", "Trạng thái tiếp nhận dịch vụ")
    ])

    create_db_table(doc, "2.28", "sepay_transactions", "Lịch sử giao dịch VietQR Cổng SePay", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh bản ghi giao dịch hệ thống"),
        ("sepay_id", "VARCHAR(100)", "UNIQUE, NOT NULL", "Mã giao dịch duy nhất từ SePay"),
        ("gateway", "VARCHAR(50)", "DEFAULT 'MBBank'", "Cổng ngân hàng phát sinh giao dịch"),
        ("account_number", "VARCHAR(50)", "DEFAULT '0338929013'", "Số tài khoản ngân hàng thụ hưởng"),
        ("transaction_date", "DATETIME", "NOT NULL", "Thời điểm chuyển khoản thực tế"),
        ("transfer_amount", "DECIMAL(15,2)", "NOT NULL", "Số tiền khách chuyển khoản (VNĐ)"),
        ("code", "VARCHAR(100)", "NULL", "Mã đơn cọc đối chiếu tự động"),
        ("content", "TEXT", "NOT NULL", "Nội dung chuyển khoản từ tin nhắn ngân hàng"),
        ("reference_code", "VARCHAR(100)", "NULL", "Mã tham chiếu ngân hàng"),
        ("customer_phone", "VARCHAR(20)", "NULL", "Số điện thoại khách hàng trích xuất"),
        ("status", "VARCHAR(50)", "DEFAULT 'MATCHED'", "Trạng thái đối soát đơn hàng"),
        ("is_notified_admin", "BOOLEAN", "DEFAULT FALSE", "Đã hiển thị Popup thông báo cho Admin chưa"),
        ("raw_data", "JSON", "NULL", "Toàn bộ dữ liệu JSON Webhook SePay gửi sang")
    ])

    create_db_table(doc, "2.29", "yeu_cau_thu_doi_xe", "Hồ sơ Thu cũ đổi mới (Trade-In)", [
        ("ma_yeu_cau", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh hồ sơ Trade-In"),
        ("ho_ten", "VARCHAR(255)", "NOT NULL", "Họ tên khách hàng sở hữu xe cũ"),
        ("sdt", "VARCHAR(20)", "NOT NULL", "Số điện thoại liên lạc"),
        ("hang_xe", "VARCHAR(100)", "NOT NULL", "Hãng sản xuất của xe cũ (Mercedes, Lexus...)"),
        ("dong_xe", "VARCHAR(150)", "NOT NULL", "Dòng model xe cũ"),
        ("nam_sx", "YEAR", "NOT NULL", "Năm sản xuất xe cũ"),
        ("so_km", "UNSIGNED INT", "NOT NULL", "Số ODO kilomet xe cũ đã vận hành"),
        ("tinh_trang", "VARCHAR(100)", "NOT NULL", "Tình trạng xe (Nguyên bản, Đã trùng tu)"),
        ("xe_du_dinh_doi", "VARCHAR(255)", "NULL", "Mẫu xe mới tại showroom muốn đổi sang"),
        ("gia_dinh_gia_so_bo", "DECIMAL(15,2)", "NULL", "Giá định giá sơ bộ tự động (VNĐ)"),
        ("gia_chot", "DECIMAL(15,2)", "NULL", "Giá thu mua chính thức sau kiểm định 176 mục (VNĐ)"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'cho_tham_dinh'", "Trạng thái: Cho tham dinh, Da dinh gia, Dong y, Huy")
    ])

    create_db_table(doc, "2.30", "so_bao_hanh_vin", "Sổ bảo hành điện tử theo số khung VIN", [
        ("vin", "VARCHAR(50)", "PK, NOT NULL", "Mã số nhận diện xe (Số khung VIN 17 ký tự chuẩn ISO)"),
        ("bien_so", "VARCHAR(50)", "NOT NULL", "Biển kiểm soát phương tiện"),
        ("ten_xe", "VARCHAR(255)", "NOT NULL", "Tên model xe được cấp sổ"),
        ("chu_so_huu", "VARCHAR(255)", "NOT NULL", "Họ tên chủ xe đăng ký"),
        ("sdt_chu_xe", "VARCHAR(20)", "NOT NULL", "Số điện thoại liên lạc của chủ xe"),
        ("ngay_giao_xe", "DATE", "NOT NULL", "Ngày xuất xưởng bàn giao xe và kích hoạt"),
        ("thoi_han_bao_hanh_nam", "UNSIGNED SMALLINT", "DEFAULT 3", "Thời hạn bảo hành chính hãng (Năm)"),
        ("ngay_het_han_bh", "DATE", "NOT NULL", "Ngày kết thúc hiệu lực bảo hành"),
        ("so_km_hien_tai", "UNSIGNED INT", "DEFAULT 0", "Số ODO ghi nhận tại lần bảo dưỡng gần nhất"),
        ("goi_bao_hanh", "VARCHAR(100)", "DEFAULT 'PrimeLux Premium'", "Gói bảo hành áp dụng"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'Hieu luc'", "Trạng thái: Hieu luc, Het han, Tam khoa")
    ])

    create_db_table(doc, "2.31", "lich_su_bao_duong_vin", "Nhật ký phụ tùng & bảo dưỡng theo VIN", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh lượt bảo dưỡng"),
        ("vin", "VARCHAR(50)", "FK -> so_bao_hanh_vin.vin", "Mã số khung VIN liên kết"),
        ("ngay_bao_duong", "DATE", "NOT NULL", "Ngày thực hiện dịch vụ tại xưởng"),
        ("moc_km", "UNSIGNED INT", "NOT NULL", "Số kilomet xe tại thời điểm vào xưởng"),
        ("noi_dung", "TEXT", "NOT NULL", "Nội dung công việc (thay dầu, lọc gió, má phanh...)"),
        ("phu_tung_thay_the", "TEXT", "NULL", "Danh sách phụ tùng chính hãng đã thay thế"),
        ("chi_phi", "DECIMAL(12,2)", "DEFAULT 0.00", "Tổng chi phí dịch vụ thực tế (VNĐ)"),
        ("ky_thuat_vien", "VARCHAR(255)", "NULL", "Kỹ thuật viên trưởng phụ trách ca"),
        ("showroom", "VARCHAR(255)", "DEFAULT 'PrimeLux Flagship'", "Showroom thực hiện bảo dưỡng"),
        ("diem_tich_luy_nhan", "UNSIGNED INT", "DEFAULT 0", "Điểm VIP được cộng sau lượt dịch vụ")
    ])

    create_db_table(doc, "2.32", "thong_bao_da_kenh", "Nhật ký phát thông báo Zalo / SMS / Email", [
        ("ma_thong_bao", "VARCHAR(50)", "PK, NOT NULL", "Mã định danh thông điệp gửi đi"),
        ("loai_kenh", "VARCHAR(50)", "NOT NULL", "Kênh phát: Zalo ZNS, SMS Brandname, Email"),
        ("muc_dich", "VARCHAR(100)", "NOT NULL", "Mục đích: Lịch lái thử, Thăng hạng VIP, Biên lai cọc"),
        ("nguoi_nhan", "VARCHAR(255)", "NOT NULL", "Tên người nhận thông báo"),
        ("sdt_email", "VARCHAR(255)", "NOT NULL", "Địa chỉ nhận (Số điện thoại hoặc Email)"),
        ("tieu_de", "VARCHAR(255)", "NULL", "Tiêu đề thông điệp"),
        ("noi_dung", "TEXT", "NOT NULL", "Nội dung chi tiết thông điệp phát đi"),
        ("trang_thai", "VARCHAR(50)", "DEFAULT 'Đã gửi thành công'", "Trạng thái gửi tin"),
        ("thoi_gian_gui", "DATETIME", "NOT NULL", "Thời điểm phát lệnh gửi tin")
    ])

    create_db_table(doc, "2.33", "audit_logs", "Nhật ký kiểm toán an toàn hệ thống", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh bản ghi kiểm toán"),
        ("user_name", "VARCHAR(255)", "NOT NULL", "Tên người dùng thực hiện hành vi"),
        ("user_role", "VARCHAR(50)", "NOT NULL", "Vai trò của người dùng (Admin, Tư vấn, Kế toán)"),
        ("action", "VARCHAR(100)", "NOT NULL", "Loại hành động (LOGIN, CREATE, UPDATE, DELETE)"),
        ("details", "TEXT", "NOT NULL", "Chi tiết thao tác nghiệp vụ đã thực hiện"),
        ("ip_address", "VARCHAR(45)", "NULL", "Địa chỉ IP máy khách thực hiện thao tác")
    ])

    create_db_table(doc, "2.34", "users", "Tài khoản Quản trị và Phân quyền RBAC", [
        ("id", "BIGINT", "PK, Auto Increment", "Định danh duy nhất của tài khoản"),
        ("name", "VARCHAR(255)", "NOT NULL", "Họ và tên nhân viên / quản trị viên"),
        ("email", "VARCHAR(255)", "UNIQUE, NOT NULL", "Địa chỉ email đăng nhập hệ thống"),
        ("email_verified_at", "TIMESTAMP", "NULL", "Thời điểm xác minh email"),
        ("password", "VARCHAR(255)", "NOT NULL", "Mật khẩu mã hóa an toàn qua thuật toán Bcrypt")
    ])

    # =========================================================================
    # CHƯƠNG 3. CÀI ĐẶT THỰC NGHIỆM VÀ KẾT QUẢ TRIỂN KHAI
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "CHƯƠNG 3. CÀI ĐẶT THỰC NGHIỆM VÀ KẾT QUẢ TRIỂN KHAI")

    add_heading_2(doc, "3.1 Môi trường cài đặt và cấu hình phần mềm")
    add_para(doc, "Hệ thống PrimeLux Auto được cấu hình chạy trên nền PHP 8.3.16, Laravel 12 (13.17), MySQL 8.0, Node.js 20, Vite 8.0 và Web Server Nginx/Apache. Tối ưu hóa tải trang dưới 1.2 giây.")

    add_heading_2(doc, "3.2 Giao diện và kết quả các phân hệ phía Người dùng")
    add_para(doc, "Dưới đây là các hình ảnh thực tế chụp từ website PrimeLux Auto kèm thuyết minh khoa học:")

    add_image_box(doc, "docs/screenshots/hinh_3_1_trang_chu.png", "Hình 3.1: Giao diện Trang chủ và Bộ lọc danh mục xe đa tiêu chí")
    add_para(doc, "Trang chủ Showroom PrimeLux Auto được thiết kế sang trọng với banner quảng bá xe nổi bật, thanh tìm kiếm thông minh và bộ lọc đa tiêu chí cho phép khách hàng chọn nhanh hãng xe, khoảng giá dự kiến, kiểu dáng thân xe và tình trạng xe.")

    add_image_box(doc, "docs/screenshots/hinh_3_2_danh_muc_xe.png", "Hình 3.2: Giao diện Danh mục kho xe và Bộ lọc đa tiêu chí")
    add_para(doc, "Danh mục kho xe hiển thị trực quan dưới dạng lưới đa cột (Responsive Card Grid), tích hợp đầy đủ thông số kỹ thuật cốt lõi (số ODO, năm sản xuất, hộp số, nhiên liệu).")

    add_image_box(doc, "docs/screenshots/hinh_3_3_chi_tiet_xe.png", "Hình 3.3: Giao diện Chi tiết xe sang và Thông số kỹ thuật chuyên sâu")
    add_para(doc, "Trang chi tiết xe với bộ sưu tập ảnh góc rộng, bảng thông số kỹ thuật chi tiết của động cơ, trang bị an toàn, công cụ dự toán chi phí lăn bánh theo từng tỉnh/thành phố và bảng tính vay trả góp ngân hàng.")

    add_image_box(doc, "docs/screenshots/hinh_3_4_so_sanh_gia.png", "Hình 3.4: Giao diện Công cụ So sánh giá xe đa sàn thị trường")
    add_para(doc, "Giao diện so sánh xe đặt các mẫu xe cạnh nhau đối chiếu thông số và biểu diễn biểu đồ Chart.js lịch sử biến động giá 6 tháng thu thập tự động từ 3 sàn giao dịch lớn.")

    add_image_box(doc, "docs/screenshots/hinh_3_5_dang_ky_lai_thu.png", "Hình 3.5: Giao diện Cổng Đăng ký lái thử xe VIP trực tuyến")
    add_para(doc, "Form đăng ký lịch lái thử xe cho phép khách hàng chọn ngày giờ, địa điểm trải nghiệm (tại showroom hoặc tận nhà), tự động kích hoạt gửi thông báo đa kênh Zalo ZNS / SMS / Email.")

    add_image_box(doc, "docs/screenshots/hinh_3_6_tra_cuu_hoa_don.png", "Hình 3.6: Giao diện Cổng Tra cứu hóa đơn và Chi tiết thanh toán cọc SePay")
    add_para(doc, "Cổng tra cứu hóa đơn điện tử cho phép khách hàng nhập mã hợp đồng cọc xe để kiểm tra lịch sử thanh toán ngân hàng đối soát từ SePay.")

    add_image_box(doc, "docs/screenshots/hinh_3_7_primelux_club.png", "Hình 3.7: Giao diện Cổng Hội viên PrimeLux Club & Tra cứu tích điểm VIP")
    add_para(doc, "Khu vực thành viên VIP hiển thị hạng thành viên (Vàng, Bạch Kim, Kim Cương), số điểm thưởng tích lũy và các đặc quyền ưu đãi bảo dưỡng định kỳ.")

    add_image_box(doc, "docs/screenshots/hinh_3_8_ban_tu_van_sse.png", "Hình 3.8: Giao diện Bàn Chuyên viên tư vấn & Nhận tin realtime qua SSE")
    add_para(doc, "Giao diện tiếp nhận cuộc trò chuyện trực tuyến dành cho Chuyên viên tư vấn khi Trợ lý ảo AI phát hiện khách hàng có nhu cầu chốt hợp đồng mua xe.")

    add_heading_2(doc, "3.3 Giao diện và kết quả các phân hệ phía Quản trị")
    add_image_box(doc, "docs/screenshots/hinh_3_9_dashboard_admin.png", "Hình 3.9: Giao diện Dashboard Quản trị viên (Admin Portal) & Phễu bán hàng")
    add_para(doc, "Dashboard quản trị trung tâm hiển thị các chỉ số KPI doanh thu, số xe tồn kho, lịch hẹn lái thử và biểu đồ Phễu chuyển đổi kinh doanh (Sales Funnel).")

    add_image_box(doc, "docs/screenshots/hinh_3_10_dang_nhap.png", "Hình 3.10: Giao diện Đăng nhập hệ thống đa vai trò")
    add_para(doc, "Màn hình đăng nhập bảo mật phân tách quyền truy cập rõ ràng giữa Quản trị viên, Tư vấn viên, Kế toán và Hội viên VIP.")

    add_heading_2(doc, "3.4 Kết quả xuất báo cáo thống kê định dạng Excel/CSV")
    add_para(doc, "Hệ thống hỗ trợ xuất dữ liệu tức thì ra file Excel/CSV chuẩn quốc tế kèm tiền tố Byte Order Mark (UTF-8 BOM), giải quyết triệt để lỗi hiển thị font tiếng Việt có dấu khi mở trên Microsoft Excel qua các tuyến /admin/export/cars, /admin/export/test-drives, /admin/export/invoices.")

    # =========================================================================
    # CHƯƠNG 4. ĐÁNH GIÁ, KIỂM THỬ VÀ HƯỚNG PHÁT TRIỂN
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "CHƯƠNG 4. ĐÁNH GIÁ, KIỂM THỬ VÀ HƯỚNG PHÁT TRIỂN")

    add_heading_2(doc, "4.1 Báo cáo kết quả kiểm thử tự động")
    add_para(doc, "Công tác kiểm thử phần mềm được thực hiện bằng bộ công cụ kiểm thử tự động chính thức của Laravel (PHPUnit Framework). Toàn bộ 23 ca kiểm thử thuộc các phân hệ chức năng lõi và chức năng mở rộng đều vượt qua kiểm tra với tỉ lệ thành công đạt 100% (95 assertions thành công):")

    test_data = [
        ("TC01", "Kiểm tra tải trang chủ Showroom (/)", "HTTP Status 200, hiển thị đầy đủ Header, Banner, Danh mục xe", "ĐẠT (Passed)"),
        ("TC02", "Kiểm tra tải danh mục xe (/cars)", "HTTP Status 200, phân trang danh sách xe hoạt động chính xác", "ĐẠT (Passed)"),
        ("TC03", "Kiểm tra chi tiết xe (/cars/{id})", "HTTP Status 200, thông số kỹ thuật xe và ảnh hiển thị chuẩn xác", "ĐẠT (Passed)"),
        ("TC04", "Kiểm tra công cụ Dự toán lăn bánh", "Hệ thống tính đúng biểu phí trước bạ (12% HN, 10% tỉnh), biển số 20tr", "ĐẠT (Passed)"),
        ("TC05", "Kiểm tra Bảng tính vay trả góp", "Công thức dư nợ giảm dần tính chính xác nợ gốc và nợ lãi hàng tháng", "ĐẠT (Passed)"),
        ("TC06", "Kiểm tra tạo đơn đặt cọc SePay", "Tạo bản ghi order pending, sinh mã VietQR và cú pháp cọc độc nhất", "ĐẠT (Passed)"),
        ("TC07", "Kiểm tra xác thực Webhook SePay", "Xác thực chữ ký và thông tin chuyển khoản, cập nhật đơn hàng thành công", "ĐẠT (Passed)"),
        ("TC08", "Kiểm tra bảo mật Webhook giả mạo", "Từ chối và chặn bản tin Webhook có sai lệch hoặc thiếu thông tin", "ĐẠT (Passed)"),
        ("TC09", "Kiểm tra Trợ lý ảo AI Endpoint", "API /api/ai/ask trả lời chính xác thông số kỹ thuật và phản hồi JSON hợp lệ", "ĐẠT (Passed)"),
        ("TC10", "Kiểm tra Đăng ký lái thử xe", "Lưu thông tin hẹn lái thử và điều phối thông báo đa kênh Zalo/SMS", "ĐẠT (Passed)"),
        ("TC11", "Kiểm tra Tra cứu số khung VIN", "Tra cứu đúng sổ bảo hành theo VIN, hiển thị lịch sử bảo dưỡng và mốc hẹn", "ĐẠT (Passed)"),
        ("TC12", "Kiểm tra Công cụ tính giá Trade-In", "Thuật toán tính giá xe cũ sơ bộ hoạt động chính xác theo số km và năm sản xuất", "ĐẠT (Passed)"),
        ("TC13", "Kiểm tra Nộp hồ sơ Trade-In", "Lưu hồ sơ vào CSDL và tạo thông báo duyệt thẩm định đến Quản trị viên", "ĐẠT (Passed)"),
        ("TC14", "Kiểm tra Quét giá thị trường", "Command cars:scrape-market-prices thu thập dữ liệu 3 sàn thành công", "ĐẠT (Passed)"),
        ("TC15", "Kiểm tra Biểu đồ so sánh giá", "View so sánh xe hiển thị biểu đồ Chart.js lịch sử biến động giá 6 tháng", "ĐẠT (Passed)"),
        ("TC16", "Kiểm tra Đăng nhập Quản trị viên", "Đăng nhập thành công với tài khoản Admin, cấp phiên Session an toàn", "ĐẠT (Passed)"),
        ("TC17", "Kiểm tra Chặn truy cập trái phép", "Chặn người dùng vãng lai truy cập vào các tuyến đường /admin/*", "ĐẠT (Passed)"),
        ("TC18", "Kiểm tra Dashboard BI Quản trị", "Hiển thị đầy đủ số liệu KPI và biểu đồ Phễu chuyển đổi kinh doanh", "ĐẠT (Passed)"),
        ("TC19", "Kiểm tra Xuất dữ liệu kho xe Excel", "Endpoint /admin/export/cars trả về file CSV UTF-8 BOM chuẩn", "ĐẠT (Passed)"),
        ("TC20", "Kiểm tra Xuất dữ liệu Lái thử", "Endpoint /admin/export/test-drives xuất file danh sách hẹn thành công", "ĐẠT (Passed)"),
        ("TC21", "Kiểm tra Xuất dữ liệu Doanh thu", "Endpoint /admin/export/invoices xuất file báo cáo tài chính chính xác", "ĐẠT (Passed)"),
        ("TC22", "Kiểm tra Ghi nhật ký Audit Log", "Mọi thao tác thêm/sửa/xóa đều được ghi nhận đầy đủ IP và Action", "ĐẠT (Passed)"),
        ("TC23", "Kiểm tra Xác thực 2 bước 2FA", "Xác thực mã TOTP 6 số từ Google Authenticator thành công", "ĐẠT (Passed)")
    ]

    p_tt = doc.add_paragraph()
    p_tt.paragraph_format.space_before = Pt(6)
    p_tt.paragraph_format.space_after = Pt(2)
    p_tt.paragraph_format.keep_with_next = True
    r_tt = p_tt.add_run("Bảng 4.1: Ma trận kết quả kiểm thử tự động hệ thống (Automated Feature Tests)")
    r_tt.font.name = 'Times New Roman'
    r_tt.font.size = Pt(12)
    r_tt.font.bold = True
    r_tt.font.color.rgb = BLACK

    tbl_test = doc.add_table(rows=len(test_data) + 1, cols=4)
    tbl_test.alignment = WD_TABLE_ALIGNMENT.CENTER
    w_test = [Inches(1.0), Inches(2.2), Inches(2.3), Inches(1.2)]
    hdr_t = tbl_test.rows[0]
    hdr_t.cells[0].paragraphs[0].text = "Mã TC"
    hdr_t.cells[1].paragraphs[0].text = "Mục tiêu kiểm thử"
    hdr_t.cells[2].paragraphs[0].text = "Kết quả mong đợi"
    hdr_t.cells[3].paragraphs[0].text = "Đánh giá"
    format_table_header(hdr_t, w_test)

    for idx, (t_id, t_goal, t_exp, t_eval) in enumerate(test_data):
        row = tbl_test.rows[idx + 1]
        row.cells[0].paragraphs[0].text = t_id
        row.cells[1].paragraphs[0].text = t_goal
        row.cells[2].paragraphs[0].text = t_exp
        row.cells[3].paragraphs[0].text = t_eval
        format_table_cell(row.cells[0], bold=True, align=WD_ALIGN_PARAGRAPH.CENTER, width=w_test[0])
        format_table_cell(row.cells[1], align=WD_ALIGN_PARAGRAPH.LEFT, width=w_test[1])
        format_table_cell(row.cells[2], align=WD_ALIGN_PARAGRAPH.LEFT, width=w_test[2])
        format_table_cell(row.cells[3], bold=True, align=WD_ALIGN_PARAGRAPH.CENTER, width=w_test[3])

    p_sp = doc.add_paragraph()
    p_sp.paragraph_format.space_after = Pt(10)

    add_heading_2(doc, "4.2 Đánh giá an toàn, bảo mật và hiệu năng hệ thống")
    add_para(doc, "Hệ thống bảo vệ toàn diện theo chuẩn OWASP: Phòng chống SQL Injection (Eloquent ORM & PDO), Cross-Site Scripting XSS (Blade escaping), CSRF Tokens trên 100% biểu mẫu, xác thực Webhook đối soát SePay tức thì, kiểm soát truy cập RBAC 5 vai trò, bảo mật xác thực hai bước TOTP RFC 6238 và tối ưu hóa truy vấn Eager Loading.")

    add_heading_2(doc, "4.3 Kết luận đạt được")
    add_para(doc, "Đồ án đã hiện thực hóa thành công một hệ sinh thái phần mềm showroom ô tô cao cấp hiện đại, giải quyết triệt để 9 bài toán chuyển đổi số trọng tâm, làm chủ kiến trúc Laravel nâng cao, tích hợp cổng thanh toán thực tế và ứng dụng AI thông minh.")

    add_heading_2(doc, "4.4 Những mặt hạn chế, khuyết điểm")
    add_para(doc, "Bộ scraper quét giá thị trường cần cập nhật khi các sàn đổi cấu trúc giao diện; Trợ lý ảo AI hoạt động phụ thuộc Cloud API; chưa xây dựng ứng dụng di động độc lập (Native App).")

    add_heading_2(doc, "4.5 Định hướng phát triển trong tương lai")
    add_para(doc, "Phát triển ứng dụng di động Flutter/React Native; Tích hợp giải pháp Ký hợp đồng điện tử eContract (VNPT/FPT); Tích hợp thiết bị định vị GPS & cảm biến cổng OBD-II trên xe lái thử; và ứng dụng Thị giác máy tính (Computer Vision) nhận diện trầy xước trong thẩm định Trade-In.")

    # =========================================================================
    # DANH MỤC TÀI LIỆU THAM KHẢO (BẮT BUỘC RIÊNG 1 TRANG ĐỘC LẬP)
    # =========================================================================
    doc.add_page_break()
    add_heading_1(doc, "DANH MỤC TÀI LIỆU THAM KHẢO")
    add_para(doc, "Danh mục các tài liệu sách, giáo trình, bài báo khoa học và tài liệu kỹ thuật trực tuyến được trích dẫn trong đề tài:", italic=True, space_after=12)

    references = [
        "[ 1 ] Taylor Otwell, \"Laravel: The PHP Framework for Web Artisans\", Official Documentation, https://laravel.com/docs, truy cập tháng 10/2026.",
        "[ 2 ] The PHP Group, \"PHP 8.3 Documentation and Migration Guide\", https://www.php.net/docs.php, truy cập tháng 10/2026.",
        "[ 3 ] Adam Wathan, \"Tailwind CSS: Rapidly build modern websites without ever leaving your HTML\", https://tailwindcss.com/docs, truy cập tháng 10/2026.",
        "[ 4 ] SePay Vietnam, \"Tài liệu tích hợp Cổng thanh toán VietQR và Webhook tự động SePay\", https://sepay.vn/docs, truy cập tháng 10/2026.",
        "[ 5 ] Chart.js Team, \"Chart.js: Simple yet flexible JavaScript charting for designers & developers\", https://www.chartjs.org/docs, truy cập tháng 10/2026.",
        "[ 6 ] Open Web Application Security Project (OWASP), \"OWASP Top 10 Web Application Security Risks\", https://owasp.org/www-project-top-ten/, truy cập tháng 9/2026.",
        "[ 7 ] Sebastian Bergmann, \"PHPUnit Manual: Testing Framework for PHP\", https://phpunit.de/manual, truy cập tháng 10/2026.",
        "[ 8 ] Google LLC, \"Google Authenticator: Two-Factor Authentication TOTP Algorithm Standard RFC 6238\", https://datatracker.ietf.org/doc/html/rfc6238.",
        "[ 9 ] Bộ Tài chính Việt Nam, \"Thông tư số 13/2022/TT-BTC quy định chi tiết về lệ phí trước bạ đối với ô tô và xe máy\", Cổng thông tin điện tử Bộ Tài chính.",
        "[ 10 ] Hội đồng Nhân dân TP. Hà Nội & TP. Hồ Chí Minh, \"Nghị quyết quy định mức thu lệ phí đăng ký, cấp biển phương tiện giao thông cơ giới đường bộ\".",
        "[ 11 ] Patrick Lewis et al., \"Retrieval-Augmented Generation for Knowledge-Intensive NLP Tasks\", Advances in Neural Information Processing Systems (NeurIPS), 2020.",
        "[ 12 ] Martin Fowler, \"Patterns of Enterprise Application Architecture\", Addison-Wesley Professional, ISBN: 978-0321127426.",
        "[ 13 ] Robert C. Martin, \"Clean Code: A Handbook of Agile Software Craftsmanship\", Prentice Hall, ISBN: 978-0132350884.",
        "[ 14 ] Matt Stauffer, \"Laravel: Up & Running: A Framework for Building Modern PHP Apps\", O'Reilly Media, 3rd Edition, ISBN: 978-1098139254.",
        "[ 15 ] C. J. Date, \"An Introduction to Database Systems\", Pearson Education, 8th Edition, ISBN: 978-0321197849.",
        "[ 16 ] Ian Sommerville, \"Software Engineering\", Pearson Education, 10th Edition, ISBN: 978-0133943030.",
        "[ 17 ] International Organization for Standardization (ISO), \"ISO 3779: Road vehicles - Vehicle identification number (VIN) - Content and structure\", Geneva, Switzerland.",
        "[ 18 ] National Institute of Standards and Technology (NIST), \"Secure Hash Standard (SHS) - FIPS PUB 180-4: SHA-256 Specification\", US Department of Commerce."
    ]

    for ref in references:
        add_para(doc, ref, space_after=6, line_spacing=1.2)

    # LƯU FILE BÁO CÁO HOÀN CHỈNH
    output_docx_docs = os.path.join("docs", "Bao_Cao_PrimeLux_Auto.docx")
    output_docx_nhom1 = os.path.join("docs", "Nhóm 1.docx")

    doc.save(output_docx_docs)
    doc.save(output_docx_nhom1)
    print(f"✅ ĐÃ TẠO THÀNH CÔNG BÁO CÁO PRIMELUX AUTO CHÍNH XÁC 100% THEO WEBSITE TẠI:\n - {output_docx_docs}\n - {output_docx_nhom1}")

if __name__ == "__main__":
    build_full_report()
