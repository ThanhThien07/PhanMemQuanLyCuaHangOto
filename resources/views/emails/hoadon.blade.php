<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Mua Xe - PrimeLux Auto Showroom</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #0b0f19;
            color: #f8fafc;
            margin: 0;
            padding: 20px 0;
        }
        .container {
            max-width: 650px;
            margin: 0 auto;
            background: #111827;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        }
        .header {
            background: linear-gradient(135deg, #06080e 0%, #1e293b 100%);
            padding: 30px;
            border-bottom: 2px solid #eab308;
            text-align: center;
        }
        .logo-text {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #ffffff;
            margin: 0;
        }
        .logo-badge {
            color: #eab308;
            font-size: 13px;
            letter-spacing: 3px;
            display: block;
            margin-top: 4px;
            text-transform: uppercase;
        }
        .content {
            padding: 30px;
        }
        .badge-success {
            display: inline-block;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid #22c55e;
            color: #4ade80;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .invoice-card {
            background: #1f2937;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .label {
            color: #94a3b8;
        }
        .value {
            font-weight: 600;
            color: #ffffff;
            text-align: right;
        }
        .car-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        .car-table th {
            background: rgba(255, 255, 255, 0.05);
            padding: 12px;
            text-align: left;
            color: #94a3b8;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .car-table td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .total-box {
            background: rgba(234, 179, 8, 0.08);
            border: 1px solid rgba(234, 179, 8, 0.3);
            border-radius: 10px;
            padding: 18px;
            margin-top: 20px;
        }
        .footer {
            background: #090d16;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        .btn-portal {
            display: inline-block;
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
            color: #0b0f19 !important;
            font-weight: bold;
            padding: 12px 28px;
            border-radius: 30px;
            text-decoration: none;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1 class="logo-text">PRIMELUX AUTO</h1>
            <span class="logo-badge">Luxury & Supercar Showroom</span>
            <p style="color: #94a3b8; font-size: 13px; margin: 10px 0 0 0;">
                Hệ Thống Phân Phối Siêu Xe Chuẩn Châu Âu Hàng Đầu Việt Nam
            </p>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <div style="text-align: center;">
                <span class="badge-success">
                    ✓ HÓA ĐƠN ĐÃ ĐƯỢC XÁC THỰC THÀNH CÔNG
                </span>
                <h2 style="margin: 0 0 10px 0; color: #ffffff; font-size: 22px;">
                    Cảm ơn Quý Khách Đã Mua Xe Tại PrimeLux Auto!
                </h2>
                <p style="color: #94a3b8; font-size: 14px; margin-bottom: 25px;">
                    Hóa đơn mua xe và thông tin bảo hành chính hãng của Quý khách đã được lưu trữ vĩnh viễn trên hệ thống PrimeLux VIP.
                </p>
            </div>

            <!-- THÔNG TIN HÓA ĐƠN -->
            <div class="invoice-card">
                <div class="row">
                    <span class="label">Mã Hóa Đơn:</span>
                    <span class="value" style="color: #facc15;">#{{ is_array($invoice) ? ($invoice['ma_hd'] ?? 'HD0001') : ($invoice->ma_hd ?? 'HD0001') }}</span>
                </div>
                <div class="row">
                    <span class="label">Ngày Xuất Hóa Đơn:</span>
                    <span class="value">{{ is_array($invoice) ? ($invoice['ngay_lap'] ?? date('d/m/Y')) : ($invoice->ngay_lap ?? date('d/m/Y')) }}</span>
                </div>
                <div class="row">
                    <span class="label">Họ và Tên Khách Hàng:</span>
                    <span class="value">{{ $extraData['customer_name'] ?? (is_array($invoice) ? ($invoice['customer_name'] ?? 'Quý Khách Hàng') : ($invoice->customer->ho_ten ?? 'Quý Khách Hàng')) }}</span>
                </div>
                <div class="row">
                    <span class="label">Số Điện Thoại:</span>
                    <span class="value">{{ $extraData['customer_phone'] ?? (is_array($invoice) ? ($invoice['customer_phone'] ?? '') : ($invoice->customer->sdt ?? '')) }}</span>
                </div>
                <div class="row">
                    <span class="label">Email Nhận Hóa Đơn:</span>
                    <span class="value" style="color: #60a5fa;">{{ $extraData['customer_email'] ?? (is_array($invoice) ? ($invoice['customer_email'] ?? '') : ($invoice->customer->email ?? '')) }}</span>
                </div>
                <div class="row">
                    <span class="label">Phương Thức Thanh Toán:</span>
                    <span class="value">{{ is_array($invoice) ? ($invoice['phuong_thuc_tt'] ?? 'Chuyển khoản SePay / VietQR') : ($invoice->phuong_thuc_tt ?? 'Chuyển khoản SePay / VietQR') }}</span>
                </div>
                <div class="row">
                    <span class="label">Trạng Thái:</span>
                    <span class="value" style="color: #4ade80;">{{ is_array($invoice) ? ($invoice['trang_thai'] ?? 'Đã thanh toán') : ($invoice->trang_thai ?? 'Đã thanh toán') }}</span>
                </div>
            </div>

            <!-- BẢNG MẪU XE ĐÃ MUA -->
            <table class="car-table">
                <thead>
                    <tr>
                        <th>Mẫu Xe Sang</th>
                        <th style="text-align: center;">SL</th>
                        <th style="text-align: right;">Đơn Giá Niêm Yết</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong style="color: #ffffff;">{{ $extraData['car_name'] ?? (is_array($invoice) ? ($invoice['car_name'] ?? 'Mercedes-Maybach S 680') : ($invoice->details->first()->car->ten_xe ?? 'Mercedes-Maybach S 680')) }}</strong>
                            <div style="color: #94a3b8; font-size: 12px; margin-top: 3px;">
                                Gói bảo hành chính hãng: {{ is_array($invoice) ? ($invoice['thoi_gian_bh'] ?? '36 tháng') : ($invoice->thoi_gian_bh ?? '36 tháng') }}
                            </div>
                        </td>
                        <td style="text-align: center; color: #ffffff;">1</td>
                        <td style="text-align: right; color: #facc15; font-weight: bold;">
                            {{ number_format(is_array($invoice) ? ($invoice['tong_tien_goc'] ?? 0) : ($invoice->tong_tien_goc ?? 0), 0, ',', '.') }} VNĐ
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- TỔNG KẾT TÀI CHÍNH -->
            <div class="total-box">
                <div class="row">
                    <span class="label">Tổng Giá Trị Xe:</span>
                    <span class="value">{{ number_format(is_array($invoice) ? ($invoice['tong_tien_goc'] ?? 0) : ($invoice->tong_tien_goc ?? 0), 0, ',', '.') }} VNĐ</span>
                </div>
                @php
                    $discount = is_array($invoice) ? ($invoice['giam_gia_hang'] ?? 0) : ($invoice->giam_gia_hang ?? 0);
                    $total = is_array($invoice) ? ($invoice['tong_tien_thanh_toan'] ?? 0) : ($invoice->tong_tien_thanh_toan ?? 0);
                    $paid = $extraData['paid_amount'] ?? $total;
                    $remaining = max(0, $total - $paid);
                @endphp
                @if($discount > 0)
                <div class="row">
                    <span class="label">Ưu Đãi Hội Viên PrimeLux VIP:</span>
                    <span class="value" style="color: #4ade80;">-{{ number_format($discount, 0, ',', '.') }} VNĐ</span>
                </div>
                @endif
                <div class="row" style="border-top: 1px solid rgba(234, 179, 8, 0.2); padding-top: 8px; margin-top: 8px;">
                    <span class="label" style="font-weight: bold; color: #facc15;">Số Tiền Đã Thanh Toán/Cọc:</span>
                    <span class="value" style="font-size: 16px; color: #4ade80;">
                        {{ number_format($paid, 0, ',', '.') }} VNĐ
                    </span>
                </div>
                @if($remaining > 0)
                <div class="row">
                    <span class="label">Số Tiền Còn Lại Khi Bàn Giao:</span>
                    <span class="value" style="color: #f87171;">
                        {{ number_format($remaining, 0, ',', '.') }} VNĐ
                    </span>
                </div>
                @endif
            </div>

            <!-- LỜI DẶN VÀ ĐẶC QUYỀN -->
            <div style="margin-top: 25px; padding: 15px; background: rgba(37, 99, 235, 0.08); border: 1px solid rgba(37, 99, 235, 0.25); border-radius: 10px; font-size: 13px; color: #cbd5e1;">
                <strong style="color: #60a5fa;">Đặc Quyền Bàn Giao Xe Chuẩn 5 Sao:</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px; line-height: 1.6;">
                    <li>Lễ bàn giao xe tại Showroom Flagship hoặc tận tư gia của Quý khách kèm tiệc rượu vang và hoa tươi.</li>
                    <li>Tặng gói bảo dưỡng miễn phí Service A trong 12 tháng đầu tiên.</li>
                    <li>Cứu hộ khẩn cấp 24/7 bằng xe chuyên dụng PrimeLux Rescue trên toàn quốc.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ url('/invoices') }}" class="btn-portal" target="_blank">
                    Tra Cứu Lại Hóa Đơn Trực Tuyến
                </a>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p style="margin: 0 0 5px 0;"><strong>HỆ THỐNG SHOWROOM PRIMELUX AUTO VIỆT NAM</strong></p>
            <p style="margin: 0 0 5px 0;">Showroom TP.HCM: 123 Nguyễn Văn Linh, P. Tân Phong, Quận 7, TP.HCM</p>
            <p style="margin: 0 0 5px 0;">Showroom Hà Nội: KĐT Vinhomes Riverside, P. Phúc Lợi, Q. Long Biên, Hà Nội</p>
            <p style="margin: 0;">Hotline CSKH VIP 24/7: <strong>0338 929 013</strong> | Email: cskh@primelux.vn</p>
        </div>
    </div>
</body>
</html>
