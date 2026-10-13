@extends('layouts.client')

@section('title', 'Tra Cứu Hóa Đơn & Thanh Toán Online Trả Trước - PrimeLux Auto')

@section('content')
<!-- HÓA ĐƠN & THANH TOÁN (HOADON, THANHTOAN, KHACHHANG, DIEMTHUONG) -->
<div class="container py-5">
    <div class="max-w-900 mx-auto p-4 p-md-5 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <!-- TABS CHUYỂN ĐỔI: TRA CỨU HÓA ĐƠN / THANH TOÁN ONLINE TRẢ TRƯỚC -->
        <ul class="nav nav-pills nav-fill mb-4 p-1.5 rounded-pill border border-secondary bg-dark" id="invoicePaymentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill fw-bold" id="tab-search-btn" data-bs-toggle="pill" data-bs-target="#tab-search" type="button" role="tab">
                    <i class="fa-solid fa-receipt me-1.5"></i> 1. Tra Cứu Hóa Đơn Mua Xe
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-bold text-warning" id="tab-downpayment-btn" data-bs-toggle="pill" data-bs-target="#tab-downpayment" type="button" role="tab">
                    <i class="fa-solid fa-credit-card me-1.5"></i> 2. Thanh Toán Online Trả Trước
                </button>
            </li>
        </ul>

        <div class="tab-content" id="invoicePaymentTabContent">
            <!-- TAB 1: TRA CỨU HÓA ĐƠN -->
            <div class="tab-pane fade show active" id="tab-search" role="tabpanel">
                <div class="text-center mb-4">
                    <span class="section-tag"><i class="fa-solid fa-receipt text-info"></i> Dành Cho Khách Hàng Vãng Lai (Chưa Tạo Tài Khoản Web)</span>
                    <h2 class="fw-bold">Tra Cứu Hóa Đơn Mua Xe (Khách Vãng Lai)</h2>
                    <p class="text-secondary">Khách hàng vãng lai không đăng ký tài khoản web có thể nhập trực tiếp Mã Hóa Đơn (HD0001, HD0002, HD0003) hoặc Số Điện Thoại để kiểm tra thông tin xe, thời hạn bảo hành và tình trạng thanh toán trả trước.</p>
                </div>

                <form id="searchInvoiceForm" class="mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" id="invQuery" class="form-control form-control-custom" placeholder="Nhập mã HD0001, HD0003 hoặc SĐT (0901234567, 0988776655)..." required>
                        <button type="submit" class="btn btn-accent"><i class="fa-solid fa-magnifying-glass me-1"></i> Tra Cứu Ngay</button>
                    </div>
                    <div class="mt-2 text-secondary small">
                        <i class="fa-solid fa-lightbulb text-warning me-1"></i> Gợi ý tra cứu: Nhập <code>HD0001</code> (Đã thanh toán), <code>HD0002</code> (Porsche), hoặc <code>HD0003</code> / SĐT <code>0988776655</code> (Đang chờ thanh toán online tiền trả trước).
                    </div>
                </form>

                <div id="invoiceResult" class="d-none">
                    <div class="p-4 rounded-3 border border-secondary bg-dark text-white">
                        <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom border-secondary pb-3 mb-3 gap-2">
                            <div>
                                <span class="badge mb-1" id="res-inv-status-badge"><i class="fa-solid fa-circle-check me-1"></i> ĐÃ THANH TOÁN TOÀN BỘ</span>
                                <h4 class="fw-bold mb-0" id="res-inv-code">Mã Hóa Đơn: HD0001</h4>
                            </div>
                            <div class="text-end">
                                <small class="text-secondary d-block">Ngày Lập Hóa Đơn</small>
                                <strong id="res-inv-date">16/09/2026</strong>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <small class="text-secondary d-block">Khách Hàng Mua Xe:</small>
                                <strong class="fs-5" id="res-cust-name">Nguyễn Văn A</strong>
                                <div class="small text-secondary" id="res-cust-phone">SĐT: 0901234567</div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-secondary d-block">Hạng Hội Viên & Đặc Quyền:</small>
                                <span class="badge bg-primary px-3 py-1.5 fs-6 mt-1" id="res-cust-tier">
                                    <i class="fa-solid fa-crown me-1 text-warning"></i> Hạng Kim Cương (Diamond VIP)
                                </span>
                                <div class="small text-warning mt-1" id="res-points-earned">
                                    <i class="fa-solid fa-coins me-1"></i> Điểm thưởng tích lũy đơn này: <b>+1,551 Điểm</b>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table table-dark table-striped mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th>Mẫu Xe Sang</th>
                                        <th class="text-center">Số Lượng</th>
                                        <th class="text-end">Đơn Giá Niêm Yết</th>
                                        <th class="text-end">Ưu Đãi Hội Viên</th>
                                        <th class="text-end">Tổng Thanh Toán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="res-car-name" class="fw-bold">Mercedes-Maybach S 680 4MATIC</td>
                                        <td class="text-center">1</td>
                                        <td class="text-end" id="res-car-price">15,990,000,000 VNĐ</td>
                                        <td class="text-end text-success fw-bold" id="res-tier-discount">-479,700,000 VNĐ (-3%)</td>
                                        <td class="text-end text-warning fw-bold fs-5" id="res-total">15,510,300,000 VNĐ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- KHỐI HÀNH ĐỘNG NẾU CẦN THANH TOÁN TRẢ TRƯỚC -->
                        <div id="res-downpayment-action-box" class="d-none p-3 rounded-3 mb-3 border border-warning bg-warning bg-opacity-10">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <div class="text-warning fw-bold fs-6">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> Hóa đơn đang chờ thanh toán khoản trả trước (30%):
                                    </div>
                                    <div class="text-white fs-5 fw-extrabold mt-1" id="res-downpayment-amount-text">4.797.000.000 VNĐ</div>
                                    <small class="text-secondary">Cổng thanh toán thụ hưởng: <strong class="text-warning">MBBank &mdash; 0338929013</strong> (PRIMELUX AUTO SHOWROOM)</small>
                                </div>
                                <button type="button" class="btn btn-warning text-dark fw-bold px-4 py-2 shadow" id="btnPayDownNow">
                                    <i class="fa-solid fa-qrcode me-1"></i> Thanh Toán Online Trả Trước Ngay
                                </button>
                            </div>
                        </div>

                        <div class="p-3 rounded bg-secondary bg-opacity-10 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <i class="fa-solid fa-shield-halved text-success me-2 fs-5"></i> Thời hạn bảo hành chính hãng: <strong>36 Tháng (Không giới hạn km)</strong>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/loyalty') }}" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-crown me-1"></i> Xem Điểm Hội Viên</a>
                                <button class="btn btn-outline-light btn-sm" onclick="window.print()"><i class="fa-solid fa-print me-1"></i> In Hóa Đơn</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="invoiceNotFound" class="d-none text-center py-4">
                    <i class="fa-solid fa-circle-exclamation text-warning fa-3x mb-3"></i>
                    <h5 class="text-white">Không tìm thấy hóa đơn phù hợp</h5>
                    <p class="text-secondary small">Vui lòng kiểm tra lại Mã hóa đơn hoặc Số điện thoại mua hàng.</p>
                </div>
            </div>

            <!-- TAB 2: THANH TOÁN ONLINE CHO PHẦN TRẢ TRƯỚC -->
            <div class="tab-pane fade" id="tab-downpayment" role="tabpanel">
                <div class="text-center mb-4">
                    <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold rounded-pill mb-2">
                        <i class="fa-solid fa-shield-halved me-1"></i> CỔNG THANH TOÁN TRỰC TUYẾN 24/7
                    </span>
                    <h2 class="fw-bold">Thanh Toán Online Khoản Trả Trước / Đặt Cọc</h2>
                    <p class="text-secondary">Thanh toán trực tiếp khoản trả trước (20% - 80%) hoặc đặt cọc giữ xe với Cổng thanh toán liên kết PrimeLux Pay & VietQR Open Banking.</p>
                    <div class="d-inline-flex align-items-center gap-2 p-2 px-3 rounded-pill bg-dark border border-secondary small">
                        <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Online</span>
                        <span>Ngân hàng: <strong class="text-warning fw-bold">MBBank &mdash; 0338929013</strong></span>
                        <span class="text-secondary">| PRIMELUX AUTO SHOWROOM</span>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- FORM NHẬP THÔNG TIN TRẢ TRƯỚC -->
                    <div class="col-md-6">
                        <div class="p-3.5 rounded-3 bg-dark bg-opacity-50 border border-secondary">
                            <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-file-invoice-dollar text-warning me-2"></i> Thông Tin Khoản Trả Trước</h5>
                            
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Mã Hợp Đồng Hoặc Mã Hóa Đơn (Nếu Có):</label>
                                <input type="text" id="tabInvCode" class="form-control form-control-custom text-white" placeholder="Ví dụ: HD0003 hoặc PLDP-101..." value="HD0003">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Mẫu Xe Muốn Trả Trước:</label>
                                <select id="tabCarSelect" class="form-select form-select-custom text-white">
                                    <option value="15990000000" data-name="Mercedes-Maybach S 680 4MATIC" selected>Mercedes-Maybach S 680 4MATIC — 15.990.000.000 VNĐ</option>
                                    <option value="9550000000" data-name="Porsche Taycan Turbo S">Porsche Taycan Turbo S — 9.550.000.000 VNĐ</option>
                                    <option value="5499000000" data-name="BMW 740i Pure Excellence">BMW 740i Pure Excellence — 5.499.000.000 VNĐ</option>
                                    <option value="16500000000" data-name="Lamborghini Urus S">Lamborghini Urus S — 16.500.000.000 VNĐ</option>
                                    <option value="3990000000" data-name="Mercedes-Benz E 300 AMG">Mercedes-Benz E 300 AMG — 3.990.000.000 VNĐ</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label text-secondary small fw-bold mb-0">Tỷ Lệ Trả Trước Ban Đầu:</label>
                                    <span class="badge bg-warning text-dark fw-bold" id="tabPercentBadge">30%</span>
                                </div>
                                <select id="tabPercentSelect" class="form-select form-select-custom text-white">
                                    <option value="20">Trả trước 20%</option>
                                    <option value="30" selected>Trả trước 30% (Khuyên dùng)</option>
                                    <option value="40">Trả trước 40%</option>
                                    <option value="50">Trả trước 50%</option>
                                    <option value="70">Trả trước 70%</option>
                                    <option value="deposit">Đặt cọc giữ xe trước 100.000.000 VNĐ</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Số Tiền Trả Trước Tương Ứng:</label>
                                <div class="input-group">
                                    <input type="text" id="tabAmountDisplay" class="form-control form-control-custom text-warning fw-bold fs-5" value="4.797.000.000 VNĐ" readonly>
                                    <span class="input-group-text bg-dark border-secondary text-secondary">VNĐ</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-warning text-dark fw-bold py-2.5 shadow" id="btnTabGenerateQr">
                                    <i class="fa-solid fa-qrcode me-2"></i> Tạo Mã VietQR Thanh Toán Ngay
                                </button>
                                <a href="{{ url('/thanh-toan-tra-truoc') }}" class="btn btn-outline-info btn-sm py-2">
                                    <i class="fa-solid fa-calculator me-1"></i> Mở Trang Kế Hoạch Trả Góp Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- MÃ QR & THÔNG TIN THANH TOÁN -->
                    <div class="col-md-6">
                        <div class="p-3.5 rounded-3 bg-dark border border-secondary text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-white mb-2"><i class="fa-solid fa-qrcode text-success me-1"></i> Quét Mã VietQR Chuyển Khoản</h5>
                                <div class="p-2 rounded-3 bg-white d-inline-block shadow my-2" style="max-width: 190px;">
                                    <img id="tabQrImage" 
                                         src="https://img.vietqr.io/image/MB-0338929013-compact2.png?amount=4797000000&addInfo=PLDP-HD0003&accountName=PRIMELUX+AUTO+SHOWROOM" 
                                         class="img-fluid rounded" 
                                         alt="VietQR thanh toán online trả trước">
                                </div>
                                <div class="text-secondary small mt-1">Hỗ trợ quét qua tất cả ứng dụng Ngân hàng Việt Nam (NAPAS 24/7)</div>

                                <div class="p-2.5 rounded-3 bg-dark border border-secondary text-start small mt-3">
                                    <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                                        <span class="text-secondary">Cổng Thanh Toán:</span>
                                        <strong class="text-success fw-bold">MBBank &mdash; Chính Thức</strong>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                                        <span class="text-secondary">Ngân Hàng:</span>
                                        <strong class="text-white">MBBank</strong>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                                        <span class="text-secondary">Số Tài Khoản:</span>
                                        <strong class="text-warning">0338929013</strong>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                                        <span class="text-secondary">Chủ Tài Khoản:</span>
                                        <strong class="text-light">PRIMELUX AUTO SHOWROOM</strong>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-secondary">Nội Dung:</span>
                                        <strong class="text-info" id="tabDispContent">PLDP-HD0003</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div id="tabSuccessNotice" class="d-none alert alert-success text-center p-2 mb-2 small">
                                    <i class="fa-solid fa-circle-check text-success me-1"></i> Xác nhận đã nhận tiền trả trước qua PrimeLux Pay &mdash; MBBank!
                                </div>
                                <button type="button" class="btn btn-success fw-bold w-100 py-2 shadow" id="btnTabVerify">
                                    <i class="fa-solid fa-arrows-rotate me-1"></i> Tôi Đã Thanh Toán — Kiểm Tra Đối Soát
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const sampleInvoices = {
        'HD0001': {
            code: 'HD0001',
            date: '16/09/2026',
            customer: 'Nguyễn Văn A',
            phone: '0901234567',
            tier: 'Hạng Kim Cương (Diamond VIP)',
            tierBadge: 'primary',
            car: 'Mercedes-Maybach S 680 4MATIC',
            price: '15,990,000,000 VNĐ',
            discount: '-479,700,000 VNĐ (-3%)',
            total: '15,510,300,000 VNĐ',
            points: '+1,551 Điểm',
            statusText: 'ĐÃ THANH TOÁN TOÀN BỘ',
            statusBadge: 'success',
            hasDownPaymentWaiting: false
        },
        '0901234567': {
            code: 'HD0001',
            date: '16/09/2026',
            customer: 'Nguyễn Văn A',
            phone: '0901234567',
            tier: 'Hạng Kim Cương (Diamond VIP)',
            tierBadge: 'primary',
            car: 'Mercedes-Maybach S 680 4MATIC',
            price: '15,990,000,000 VNĐ',
            discount: '-479,700,000 VNĐ (-3%)',
            total: '15,510,300,000 VNĐ',
            points: '+1,551 Điểm',
            statusText: 'ĐÃ THANH TOÁN TOÀN BỘ',
            statusBadge: 'success',
            hasDownPaymentWaiting: false
        },
        'HD0002': {
            code: 'HD0002',
            date: '18/09/2026',
            customer: 'Trần Thị Mai',
            phone: '0912987654',
            tier: 'Hạng Vàng (Gold Member)',
            tierBadge: 'warning',
            car: 'Porsche Taycan Turbo S',
            price: '9,550,000,000 VNĐ',
            discount: '-95,500,000 VNĐ (-1%)',
            total: '9,454,500,000 VNĐ',
            points: '+945 Điểm',
            statusText: 'ĐÃ THANH TOÁN TOÀN BỘ',
            statusBadge: 'success',
            hasDownPaymentWaiting: false
        },
        '0912987654': {
            code: 'HD0002',
            date: '18/09/2026',
            customer: 'Trần Thị Mai',
            phone: '0912987654',
            tier: 'Hạng Vàng (Gold Member)',
            tierBadge: 'warning',
            car: 'Porsche Taycan Turbo S',
            price: '9,550,000,000 VNĐ',
            discount: '-95,500,000 VNĐ (-1%)',
            total: '9,454,500,000 VNĐ',
            points: '+945 Điểm',
            statusText: 'ĐÃ THANH TOÁN TOÀN BỘ',
            statusBadge: 'success',
            hasDownPaymentWaiting: false
        },
        'HD0003': {
            code: 'HD0003',
            date: '13/10/2026',
            customer: 'Lê Hoàng Long',
            phone: '0988776655',
            tier: 'Hạng Vàng (Gold Member)',
            tierBadge: 'warning',
            car: 'Mercedes-Maybach S 680 4MATIC',
            price: '15,990,000,000 VNĐ',
            discount: '-0 VNĐ (Chờ duyệt)',
            total: '15,990,000,000 VNĐ',
            points: '+1,599 Điểm (Dự kiến)',
            statusText: 'CHỜ THANH TOÁN TIỀN TRẢ TRƯỚC (30%)',
            statusBadge: 'warning text-dark',
            hasDownPaymentWaiting: true,
            downPaymentAmount: '4.797.000.000 VNĐ'
        },
        '0988776655': {
            code: 'HD0003',
            date: '13/10/2026',
            customer: 'Lê Hoàng Long',
            phone: '0988776655',
            tier: 'Hạng Vàng (Gold Member)',
            tierBadge: 'warning',
            car: 'Mercedes-Maybach S 680 4MATIC',
            price: '15,990,000,000 VNĐ',
            discount: '-0 VNĐ (Chờ duyệt)',
            total: '15,990,000,000 VNĐ',
            points: '+1,599 Điểm (Dự kiến)',
            statusText: 'CHỜ THANH TOÁN TIỀN TRẢ TRƯỚC (30%)',
            statusBadge: 'warning text-dark',
            hasDownPaymentWaiting: true,
            downPaymentAmount: '4.797.000.000 VNĐ'
        }
    };

    function formatVnd(num) {
        return new Intl.NumberFormat('vi-VN').format(Math.round(num)) + ' VNĐ';
    }

    // TRA CỨU HÓA ĐƠN
    document.getElementById("searchInvoiceForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const rawQuery = document.getElementById("invQuery").value.trim();
        const query = rawQuery.toUpperCase();

        const inv = sampleInvoices[query] || sampleInvoices[rawQuery] || (query.startsWith('HD') ? sampleInvoices['HD0001'] : null);

        const resBox = document.getElementById("invoiceResult");
        const notFoundBox = document.getElementById("invoiceNotFound");
        const downBox = document.getElementById("res-downpayment-action-box");

        if (inv) {
            notFoundBox.classList.add("d-none");
            resBox.classList.remove("d-none");

            document.getElementById("res-inv-code").textContent = "Mã Hóa Đơn: " + inv.code;
            document.getElementById("res-inv-date").textContent = inv.date;
            document.getElementById("res-cust-name").textContent = inv.customer;
            document.getElementById("res-cust-phone").textContent = "SĐT: " + inv.phone;
            
            const statusBadge = document.getElementById("res-inv-status-badge");
            statusBadge.className = 'badge bg-' + (inv.statusBadge || 'success') + ' mb-1';
            statusBadge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> ' + (inv.statusText || 'ĐÃ THANH TOÁN TOÀN BỘ');

            const tierEl = document.getElementById("res-cust-tier");
            tierEl.className = 'badge bg-' + inv.tierBadge + ' px-3 py-1.5 fs-6 mt-1';
            tierEl.innerHTML = '<i class="fa-solid fa-crown me-1 text-warning"></i> ' + inv.tier;

            document.getElementById("res-points-earned").innerHTML = '<i class="fa-solid fa-coins me-1"></i> Điểm thưởng tích lũy đơn này: <b>' + inv.points + '</b>';
            document.getElementById("res-car-name").textContent = inv.car;
            document.getElementById("res-car-price").textContent = inv.price;
            document.getElementById("res-tier-discount").textContent = inv.discount;
            document.getElementById("res-total").textContent = inv.total;

            if (inv.hasDownPaymentWaiting) {
                downBox.classList.remove("d-none");
                document.getElementById("res-downpayment-amount-text").textContent = inv.downPaymentAmount || '4.797.000.000 VNĐ';
            } else {
                downBox.classList.add("d-none");
            }
        } else {
            resBox.classList.add("d-none");
            notFoundBox.classList.remove("d-none");
        }
    });

    // NÚT CHUYỂN NHANH SANG TAB THANH TOÁN TRẢ TRƯỚC
    const btnPayDown = document.getElementById("btnPayDownNow");
    if (btnPayDown) {
        btnPayDown.addEventListener("click", () => {
            const tabBtn = document.getElementById("tab-downpayment-btn");
            if (tabBtn) tabBtn.click();
        });
    }

    // TAB 2: TÍNH TOÁN & CỔNG THANH TOÁN ONLINE TRẢ TRƯỚC
    const tabCarSelect = document.getElementById("tabCarSelect");
    const tabPercentSelect = document.getElementById("tabPercentSelect");
    const tabPercentBadge = document.getElementById("tabPercentBadge");
    const tabAmountDisplay = document.getElementById("tabAmountDisplay");
    let tabCurrentAmount = 4797000000;

    function updateTabDownPayment() {
        const carPrice = parseFloat(tabCarSelect.value) || 0;
        const pVal = tabPercentSelect.value;
        let amount = 0;

        if (pVal === 'deposit') {
            amount = 100000000;
            tabPercentBadge.textContent = 'Đặt Cọc 100TR';
        } else {
            const pct = parseInt(pVal) || 30;
            amount = carPrice * (pct / 100);
            tabPercentBadge.textContent = pct + '%';
        }

        tabCurrentAmount = amount;
        tabAmountDisplay.value = formatVnd(amount);

        const invCode = document.getElementById("tabInvCode").value.trim() || 'HD0003';
        const content = 'PLDP-' + invCode.replace(/[^a-zA-Z0-9]/g, '');
        document.getElementById("tabDispContent").textContent = content;

        // Cập nhật VietQR URL
        const qrUrl = `https://img.vietqr.io/image/MB-0338929013-compact2.png?amount=${Math.round(amount)}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent('PRIMELUX AUTO SHOWROOM')}`;
        document.getElementById("tabQrImage").src = qrUrl;
    }

    if (tabCarSelect) tabCarSelect.addEventListener("change", updateTabDownPayment);
    if (tabPercentSelect) tabPercentSelect.addEventListener("change", updateTabDownPayment);
    document.getElementById("btnTabGenerateQr").addEventListener("click", updateTabDownPayment);

    // XÁC NHẬN THANH TOÁN TRÊN TAB 2
    const btnTabVerify = document.getElementById("btnTabVerify");
    if (btnTabVerify) {
        btnTabVerify.addEventListener("click", () => {
            btnTabVerify.disabled = true;
            btnTabVerify.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang kết nối PrimeLux Pay — Đang xác thực...';

            fetch("{{ route('api.payment.check') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    transaction_id: document.getElementById("tabDispContent").textContent
                })
            })
            .then(res => res.json())
            .then(data => {
                setTimeout(() => {
                    btnTabVerify.disabled = false;
                    btnTabVerify.innerHTML = '<i class="fa-solid fa-check me-1"></i> Giao Dịch Thành Công';
                    btnTabVerify.className = 'btn btn-secondary fw-bold w-100 py-2';

                    const successBox = document.getElementById("tabSuccessNotice");
                    successBox.classList.remove("d-none");
                    successBox.innerHTML = `<i class="fa-solid fa-circle-check text-success me-1"></i> Xác nhận thành công khoản tiền trả trước <b>${formatVnd(tabCurrentAmount)}</b> qua cổng <b>${data.id}</b>! (Biên lai: ${data.receipt_number})`;
                }, 1000);
            })
            .catch(err => {
                btnTabVerify.disabled = false;
                btnTabVerify.innerHTML = '<i class="fa-solid fa-arrows-rotate me-1"></i> Tôi Đã Thanh Toán — Kiểm Tra Đối Soát';
                alert("Đã gửi yêu cầu đối soát tới cổng thanh toán.");
            });
        });
    }
</script>
@endpush
