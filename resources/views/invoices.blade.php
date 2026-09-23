@extends('layouts.client')

@section('title', 'Tra Cứu Hóa Đơn & Thanh Toán - PrimeLux Auto')

@section('content')
<!-- HÓA ĐƠN & THANH TOÁN (HOADON, THANHTOAN, KHACHHANG, DIEMTHUONG) -->
<div class="container py-5">
    <div class="max-w-800 mx-auto p-4 p-md-5 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="text-center mb-4">
            <span class="section-tag"><i class="fa-solid fa-receipt text-info"></i> Dành Cho Khách Hàng Vãng Lai (Chưa Tạo Tài Khoản Web)</span>
            <h2 class="fw-bold">Tra Cứu Hóa Đơn Mua Xe (Khách Vãng Lai)</h2>
            <p class="text-secondary">Khách hàng vãng lai không đăng ký tài khoản web có thể nhập trực tiếp Mã Hóa Đơn (HD0001, HD0002) hoặc Số Điện Thoại để kiểm tra thông tin xe, thời hạn bảo hành và tình trạng thanh toán.</p>
        </div>

        <form id="searchInvoiceForm" class="mb-4">
            <div class="input-group input-group-lg">
                <input type="text" id="invQuery" class="form-control form-control-custom" placeholder="Nhập mã HD0001 hoặc SĐT mua hàng (ví dụ: 0901234567)..." required>
                <button type="submit" class="btn btn-accent"><i class="fa-solid fa-magnifying-glass me-1"></i> Tra Cứu Ngay</button>
            </div>
            <div class="mt-2 text-secondary small">
                <i class="fa-solid fa-lightbulb text-warning me-1"></i> Gợi ý tra cứu: Nhập mã <code>HD0001</code> hoặc SĐT <code>0901234567</code>, mã <code>HD0002</code> hoặc SĐT <code>0912987654</code>.
            </div>
        </form>

        <div id="invoiceResult" class="d-none">
            <div class="p-4 rounded-3 border border-secondary bg-dark text-white">
                <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom border-secondary pb-3 mb-3 gap-2">
                    <div>
                        <span class="badge bg-success mb-1"><i class="fa-solid fa-circle-check me-1"></i> ĐÃ THANH TOÁN TOÀN BỘ</span>
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
            points: '+1,551 Điểm'
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
            points: '+1,551 Điểm'
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
            points: '+945 Điểm'
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
            points: '+945 Điểm'
        }
    };

    document.getElementById("searchInvoiceForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const rawQuery = document.getElementById("invQuery").value.trim();
        const query = rawQuery.toUpperCase();

        const inv = sampleInvoices[query] || sampleInvoices[rawQuery] || (query.startsWith('HD') ? sampleInvoices['HD0001'] : null);

        const resBox = document.getElementById("invoiceResult");
        const notFoundBox = document.getElementById("invoiceNotFound");

        if (inv) {
            notFoundBox.classList.add("d-none");
            resBox.classList.remove("d-none");

            document.getElementById("res-inv-code").textContent = "Mã Hóa Đơn: " + inv.code;
            document.getElementById("res-inv-date").textContent = inv.date;
            document.getElementById("res-cust-name").textContent = inv.customer;
            document.getElementById("res-cust-phone").textContent = "SĐT: " + inv.phone;
            
            const tierEl = document.getElementById("res-cust-tier");
            tierEl.className = 'badge bg-' + inv.tierBadge + ' px-3 py-1.5 fs-6 mt-1';
            tierEl.innerHTML = '<i class="fa-solid fa-crown me-1 text-warning"></i> ' + inv.tier;

            document.getElementById("res-points-earned").innerHTML = '<i class="fa-solid fa-coins me-1"></i> Điểm thưởng tích lũy đơn này: <b>' + inv.points + '</b>';
            document.getElementById("res-car-name").textContent = inv.car;
            document.getElementById("res-car-price").textContent = inv.price;
            document.getElementById("res-tier-discount").textContent = inv.discount;
            document.getElementById("res-total").textContent = inv.total;
        } else {
            resBox.classList.add("d-none");
            notFoundBox.classList.remove("d-none");
        }
    });
</script>
@endpush
