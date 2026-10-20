@extends('layouts.giaodien')

@section('title', 'Tra Cứu Hóa Đơn Mua Xe - PrimeLux Auto Showroom')
@section('meta_description', 'Tra cứu hóa đơn mua xe chính hãng, thời hạn bảo hành điện tử và thông tin thanh toán tại PrimeLux Auto.')

@section('content')
<!-- TRANG CHUYÊN BIỆT: TRA CỨU HÓA ĐƠN MUA XE -->
<div class="container py-5">
    <div class="max-w-900 mx-auto p-4 p-md-5 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <!-- TIÊU ĐỀ TRANG -->
        <div class="text-center mb-4">
            <span class="section-tag"><i class="fa-solid fa-receipt text-warning me-1"></i> Dành Cho Khách Hàng</span>
            <h2 class="fw-bold text-white mb-2">Tra Cứu Hóa Đơn Mua Xe Trực Tuyến</h2>
            <p class="text-secondary max-w-700 mx-auto small">
                Khách hàng có thể nhập trực tiếp <strong>Mã Hóa Đơn</strong> hoặc <strong>Số Điện Thoại</strong> để tra cứu hợp đồng mua xe thực tế, thời hạn bảo hành chính hãng và tiến độ thanh toán.
            </p>
        </div>

        <!-- FORM TRA CỨU HÓA ĐƠN -->
        <form id="searchInvoiceForm" class="mb-4">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-dark border-secondary text-secondary">
                    <i class="fa-solid fa-file-invoice"></i>
                </span>
                <input type="text" id="invQuery" class="form-control form-control-custom text-white" 
                       placeholder="Nhập Mã Hóa Đơn hoặc Số Điện Thoại khách mua xe..." 
                       value="{{ request('code') ?? request('phone') ?? session('user.phone') ?? '' }}" required>
                <button type="submit" class="btn btn-accent px-4 fw-bold">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Tra Cứu Ngay
                </button>
            </div>
            <div class="mt-2 text-secondary small d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <i class="fa-solid fa-database text-warning me-1"></i> Dữ liệu tra cứu đồng bộ trực tiếp từ hệ thống giao dịch CSDL PrimeLux.
                </div>
                <div>
                    <a href="{{ url('/thanh-toan-tra-truoc') }}" class="text-warning text-decoration-none">
                        <i class="fa-solid fa-credit-card me-1"></i> Cần thanh toán trả trước? Bấm vào đây
                    </a>
                </div>
            </div>
        </form>

        <!-- KẾT QUẢ TRA CỨU HÓA ĐƠN -->
        <div id="invoiceResult" class="d-none">
            <div class="p-4 rounded-3 border border-secondary bg-dark text-white shadow-lg">
                <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom border-secondary pb-3 mb-3 gap-2">
                    <div>
                        <span class="badge mb-1" id="res-inv-status-badge"><i class="fa-solid fa-circle-check me-1"></i> ĐÃ THANH TOÁN TOÀN BỘ</span>
                        <h4 class="fw-bold mb-0 text-white" id="res-inv-code">Mã Hóa Đơn: HD0001</h4>
                    </div>
                    <div class="text-end">
                        <small class="text-secondary d-block">Ngày Lập Hóa Đơn</small>
                        <strong id="res-inv-date" class="text-light">16/09/2026</strong>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Khách Hàng Mua Xe:</small>
                        <strong class="fs-5 text-white" id="res-cust-name">Khách hàng</strong>
                        <div class="small text-secondary" id="res-cust-phone">SĐT: 0901234567</div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-secondary d-block">Hạng Hội Viên & Đặc Quyền:</small>
                        <span class="badge bg-primary px-3 py-1.5 fs-6 mt-1" id="res-cust-tier">
                            <i class="fa-solid fa-crown me-1 text-warning"></i> Hội Viên VIP
                        </span>
                        <div class="small text-warning mt-1" id="res-points-earned">
                            <i class="fa-solid fa-coins me-1"></i> Điểm thưởng tích lũy đơn này: <b>+0 Điểm</b>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-dark table-striped mb-0 align-middle">
                        <thead>
                            <tr class="text-secondary border-secondary">
                                <th>Mẫu Xe Sang</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-end">Đơn Giá Niêm Yết</th>
                                <th class="text-end">Ưu Đãi Hội Viên</th>
                                <th class="text-end">Tổng Thanh Toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="res-car-name" class="fw-bold text-white">Mercedes-Maybach S 680 4MATIC</td>
                                <td class="text-center">1</td>
                                <td class="text-end text-light" id="res-car-price">15,990,000,000 VNĐ</td>
                                <td class="text-end text-success fw-bold" id="res-tier-discount">0 VNĐ</td>
                                <td class="text-end text-warning fw-bold fs-5" id="res-total">15,990,000,000 VNĐ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- KHỐI HÀNH ĐỘNG NẾU ĐƠN NÀY ĐANG CHỜ THANH TOÁN TRẢ TRƯỚC -->
                <div id="res-downpayment-action-box" class="d-none p-3.5 rounded-3 mb-3 border border-warning bg-warning bg-opacity-10">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <div class="text-warning fw-bold fs-6">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> Hóa Đơn Này Đang Chờ Thanh Toán Tiền Trả Trước
                            </div>
                            <small class="text-secondary">
                                Số tiền trả trước quy định để showroom khóa xe và vận chuyển: <strong class="text-white" id="res-downpayment-amount-text">4.797.000.000 VNĐ</strong>
                            </small>
                        </div>
                        <div>
                            <a href="{{ url('/thanh-toan-tra-truoc') }}" class="btn btn-warning text-dark fw-bold btn-sm py-2 px-3 shadow">
                                <i class="fa-solid fa-credit-card me-1"></i> Thanh Toán Trả Trước Online Ngay
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top border-secondary gap-2">
                    <div class="small text-secondary">
                        <i class="fa-solid fa-shield-halved text-success me-1"></i> Đã kích hoạt Sổ bảo hành điện tử chính hãng 36 tháng
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-light btn-sm" onclick="window.print()">
                            <i class="fa-solid fa-print me-1"></i> In Hóa Đơn
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRƯỜNG HỢP KHÔNG TÌM THẤY HÓA ĐƠN -->
        <div id="invoiceNotFound" class="d-none text-center p-5 rounded-3 border border-secondary bg-dark text-secondary">
            <i class="fa-solid fa-magnifying-glass fa-3x mb-3 text-secondary opacity-50"></i>
            <h5 class="fw-bold text-white mb-2">Không Tìm Thấy Thông Tin Hóa Đơn</h5>
            <p class="small text-secondary max-w-500 mx-auto mb-3">
                Chưa có hóa đơn nào khớp với thông tin vừa nhập. Khi Quý khách thao tác mua xe hoặc thanh toán trả trước thành công, hóa đơn điện tử sẽ được cập nhật tại đây.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ url('/thanh-toan-tra-truoc') }}" class="btn btn-outline-warning btn-sm">
                    <i class="fa-solid fa-credit-card me-1"></i> Cổng Thanh Toán Online Trả Trước
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // XỬ LÝ TRA CỨU HÓA ĐƠN THỰC TẾ QUA API CSDL
    document.getElementById("searchInvoiceForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        const rawQuery = document.getElementById("invQuery").value.trim();
        if (!rawQuery) return;

        const resBox = document.getElementById("invoiceResult");
        const notFoundBox = document.getElementById("invoiceNotFound");
        const downBox = document.getElementById("res-downpayment-action-box");
        const submitBtn = e.target.querySelector('button[type="submit"]');

        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Đang tra cứu...';

        try {
            const res = await fetch('/api/invoices/lookup?query=' + encodeURIComponent(rawQuery));
            const data = await res.json();

            if (data.success && data.invoice) {
                const inv = data.invoice;
                notFoundBox.classList.add("d-none");
                resBox.classList.remove("d-none");

                document.getElementById("res-inv-code").textContent = "Mã Hóa Đơn: " + inv.code;
                document.getElementById("res-inv-date").textContent = inv.date;
                document.getElementById("res-cust-name").textContent = inv.customer;
                document.getElementById("res-cust-phone").textContent = "SĐT: " + inv.phone;
                
                const statusBadge = document.getElementById("res-inv-status-badge");
                statusBadge.className = 'badge bg-' + (inv.statusBadge || 'success') + ' mb-1';
                statusBadge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> ' + (inv.statusText || 'ĐÃ XÁC NHẬN');

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
                    document.getElementById("res-downpayment-amount-text").textContent = inv.downPaymentAmount || 'Chờ xác nhận';
                } else {
                    downBox.classList.add("d-none");
                }
            } else {
                resBox.classList.add("d-none");
                notFoundBox.classList.remove("d-none");
                const notFoundMsg = notFoundBox.querySelector('p');
                if (notFoundMsg && data.message) {
                    notFoundMsg.textContent = data.message;
                }
            }
        } catch (err) {
            console.error("Lỗi tra cứu hóa đơn:", err);
            resBox.classList.add("d-none");
            notFoundBox.classList.remove("d-none");
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    // Tự động tìm kiếm nếu đã có sẵn giá trị trong ô tìm kiếm (từ session hoặc URL query)
    if (document.getElementById("invQuery").value.trim()) {
        document.getElementById("searchInvoiceForm").dispatchEvent(new Event('submit'));
    }
</script>
@endpush
