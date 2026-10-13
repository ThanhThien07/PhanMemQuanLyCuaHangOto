@extends('layouts.admin')

@section('title', 'Quản Lý Thanh Toán & SePay Webhook - PrimeLux Auto Admin')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- TIÊU ĐỀ & HÀNH ĐỘNG -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0">Quản Lý Thanh Toán & SePay Webhook</h2>
                <span class="badge bg-success bg-opacity-20 text-success border border-success">
                    <i class="fa-solid fa-circle-check me-1"></i> SePay Online
                </span>
            </div>
            <p class="text-secondary small mb-0">
                Tự động nhận thông báo biến động số dư tiền vào ngay sau khi khách chuyển khoản qua tài khoản ngân hàng liên kết.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-info text-dark fw-bold btn-sm px-3 shadow" id="btnSyncSepayApi" onclick="syncSepayApiDirect()">
                <i class="fa-solid fa-cloud-arrow-down me-1.5"></i> Request Thông Tin Từ SePay API
            </button>
            <button type="button" class="btn btn-warning text-dark fw-bold btn-sm px-3 shadow" data-bs-toggle="modal" data-bs-target="#simulateWebhookModal">
                <i class="fa-solid fa-bolt me-1.5"></i> Bắn Thử Webhook Giả Lập
            </button>
            <a href="{{ url('/thanh-toan-tra-truoc') }}" target="_blank" class="btn btn-outline-info btn-sm">
                <i class="fa-solid fa-up-right-from-square me-1"></i> Mở Trang Trả Trước Khách Hàng
            </a>
            <button type="button" class="btn btn-outline-light btn-sm" onclick="location.reload()">
                <i class="fa-solid fa-arrows-rotate me-1"></i> Làm Mới
            </button>
        </div>
    </div>

    <!-- 4 THẺ THỐNG KÊ DOANH THU & GIAO DỊCH -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-amber">
                <div>
                    <div class="stat-title text-warning">Tổng Tiền Thu Qua SePay</div>
                    <div class="stat-value text-white revenue-val">{{ number_format($totalRevenue, 0, ',', '.') }} <span class="stat-unit">VNĐ</span></div>
                    <div class="stat-sub text-secondary"><i class="fa-solid fa-arrow-trend-up text-success"></i> Tự động khớp lệnh tức thì</div>
                </div>
                <div class="stat-icon-wrap icon-amber">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-emerald">
                <div>
                    <div class="stat-title text-success">Thu Tiền Trả Trước Hôm Nay</div>
                    <div class="stat-value text-white revenue-val">{{ number_format($todayRevenue, 0, ',', '.') }} <span class="stat-unit">VNĐ</span></div>
                    <div class="stat-sub text-success"><i class="fa-solid fa-calendar-day"></i> {{ $todayTransactions }} giao dịch hôm nay</div>
                </div>
                <div class="stat-icon-wrap icon-emerald">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-blue">
                <div>
                    <div class="stat-title text-primary">Tổng Số Giao Dịch Đã Khớp</div>
                    <div class="stat-value text-white">{{ number_format($totalTransactions) }} <span class="stat-unit">GD</span></div>
                    <div class="stat-sub text-secondary"><i class="fa-solid fa-check-double text-primary"></i> 100% khớp lệnh tự động</div>
                </div>
                <div class="stat-icon-wrap icon-blue">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-cyan">
                <div>
                    <div class="stat-title text-info">Cổng Ngân Hàng SePay</div>
                    <div class="stat-value text-warning fs-6" style="word-break: break-all;">{{ $gateway['id'] ?? 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B' }}</div>
                    <div class="stat-sub text-light"><i class="fa-solid fa-building-columns text-info"></i> {{ $gateway['bank_name'] ?? 'MBBank' }} ({{ $gateway['account_number'] ?? '0338929013' }})</div>
                </div>
                <div class="stat-icon-wrap icon-cyan">
                    <i class="fa-solid fa-network-wired"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- KHỐI HƯỚNG DẪN CẤU HÌNH WEBHOOK & API SEPAY (KHỚP VỚI MODAL SEPAY CỦA USER) -->
    <div class="card bg-dark border-secondary rounded-4 mb-4 shadow-sm overflow-hidden">
        <div class="card-header bg-dark border-secondary p-3.5 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="p-2 rounded bg-primary bg-opacity-20 text-primary">
                    <i class="fa-solid fa-plug-circle-check"></i>
                </span>
                <div>
                    <h5 class="fw-bold text-white mb-0">Cấu Hình Webhook & API SePay (Tự Động Nhận Thông Báo Tiền Vào)</h5>
                    <small class="text-secondary">Điền thông số vào form "Thêm Webhook" trên SePay để nhận biến động số dư tức thì</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success bg-opacity-20 text-success border border-success px-2.5 py-1">
                    <i class="fa-solid fa-key me-1"></i> API Key: <code class="text-warning">Rp.4hxVyw@zA2@p</code>
                </span>
                <a href="https://my.sepay.vn" target="_blank" class="btn btn-outline-warning btn-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Đi Đến my.sepay.vn
                </a>
            </div>
        </div>
        <div class="card-body p-3.5 bg-dark bg-opacity-50">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-secondary small fw-bold mb-1">1. Tên Webhook:</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-custom text-white" value="Xác thực thanh toán" readonly>
                        <button class="btn btn-outline-secondary" onclick="navigator.clipboard.writeText('Xác thực thanh toán'); alert('Đã sao chép Tên webhook!');">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small fw-bold mb-1">2. URL Nhận Webhook (*):</label>
                    <div class="input-group">
                        <input type="text" id="webhookUrlInput" class="form-control form-control-custom text-warning fw-bold" value="{{ $webhookUrl }}" readonly>
                        <button class="btn btn-warning text-dark fw-bold" onclick="copyWebhookUrl()">
                            <i class="fa-regular fa-copy me-1"></i> Chép URL
                        </button>
                    </div>
                    <small class="text-secondary d-block mt-1" style="font-size: 11px;">
                        URL dự phòng: <code>{{ url('/api/sepay/webhook') }}</code>
                    </small>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-secondary small fw-bold mb-1">3. Loại Giao Dịch:</label>
                    <input type="text" class="form-control form-control-custom text-success fw-bold" value="Tiền vào (in)" readonly>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-secondary small fw-bold mb-1">4. SePay API Key / Token:</label>
                    <div class="input-group">
                        <input type="text" id="sepayApiKeyInput" class="form-control form-control-custom text-info fw-bold" value="Rp.4hxVyw@zA2@p" readonly>
                        <button class="btn btn-outline-info" onclick="navigator.clipboard.writeText('Rp.4hxVyw@zA2@p'); alert('Đã sao chép SePay API Key!');">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                    <small class="text-secondary d-block mt-1" style="font-size: 11px;">
                        Định dạng dữ liệu SePay: <b>JSON (application/json)</b>
                    </small>
                </div>
            </div>

            <div class="alert alert-dark border border-secondary p-2.5 mt-3 mb-0 d-flex flex-wrap align-items-center justify-content-between gap-2 small">
                <div class="text-secondary">
                    <i class="fa-solid fa-circle-info text-info me-1"></i> 
                    Server của bạn tự động trả lời HTTP <code>200 OK</code> với <code>{"success": true}</code> theo tiêu chuẩn SePay để xác nhận giao dịch đã được ghi nhận.
                </div>
                <button type="button" class="btn btn-outline-info btn-xs py-1 px-2.5" data-bs-toggle="modal" data-bs-target="#simulateWebhookModal">
                    <i class="fa-solid fa-vial me-1"></i> Kiểm Tra Thử Nghiệm Webhook Ngay
                </button>
            </div>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH GIAO DỊCH TIỀN VÀO TỪ SEPAY -->
    <div class="card bg-dark border-secondary rounded-4 shadow-sm overflow-hidden">
        <div class="card-header bg-dark border-secondary p-3.5 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="p-2 rounded bg-warning bg-opacity-20 text-warning">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </span>
                <div>
                    <h5 class="fw-bold text-white mb-0">Nhật Ký Biến Động Số Dư & Khớp Lệnh Thanh Toán</h5>
                    <small class="text-secondary">Danh sách các giao dịch chuyển khoản tiền vào được SePay thông báo tự động</small>
                </div>
            </div>

            <!-- TÌM KIẾM -->
            <form action="{{ url('/admin/payments') }}" method="GET" class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="width: 280px;">
                    <input type="text" name="keyword" class="form-control form-control-custom text-white" placeholder="Tìm mã đơn PLDP..., SĐT, FT..." value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-warning text-dark"><i class="fa-solid fa-search"></i></button>
                </div>
                @if(request('keyword'))
                    <a href="{{ url('/admin/payments') }}" class="btn btn-outline-secondary btn-sm" title="Xóa tìm kiếm"><i class="fa-solid fa-xmark"></i></a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover align-middle mb-0 small">
                <thead>
                    <tr class="text-secondary text-uppercase border-secondary">
                        <th class="ps-3 py-3">Mã GD SePay</th>
                        <th>Thời Gian</th>
                        <th class="text-end">Số Tiền Vào</th>
                        <th>Ngân Hàng / STK</th>
                        <th>Mã Đơn / Hợp Đồng</th>
                        <th>Nội Dung Chuyển Khoản</th>
                        <th>Xe / Khách Hàng</th>
                        <th class="text-center">Trạng Thái</th>
                        <th class="text-center pe-3">Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td class="ps-3 fw-bold text-warning">
                                #{{ $t->sepay_id ?? $t->id }}
                            </td>
                            <td class="text-secondary">
                                {{ $t->transaction_date ? \Carbon\Carbon::parse($t->transaction_date)->format('d/m/Y H:i:s') : $t->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="text-end fw-extrabold text-success fs-6">
                                +{{ number_format($t->transfer_amount, 0, ',', '.') }} VNĐ
                            </td>
                            <td>
                                <span class="badge bg-dark border border-secondary text-light">
                                    {{ $t->gateway }} — {{ $t->account_number }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-25 text-primary border border-primary fw-bold">
                                    {{ $t->code }}
                                </span>
                            </td>
                            <td class="text-light text-break" style="max-width: 250px;">
                                {{ $t->content }}
                            </td>
                            <td>
                                <div class="fw-bold text-white">{{ $t->car_name }}</div>
                                <div class="text-secondary small">{{ $t->customer_name }} — {{ $t->customer_phone }}</div>
                            </td>
                            <td class="text-center">
                                @if($t->status === 'CHUA_THANH_TOAN' || $t->status === 'PENDING' || $t->status === 'UNPAID')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Chưa thanh toán</span>
                                @elseif($t->isVerified())
                                    <span class="badge bg-success"><i class="fa-solid fa-shield-check me-1"></i> Xác minh thành công</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Chưa thanh toán</span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                <button type="button" class="btn btn-outline-info btn-xs py-1 px-2" onclick="showTransactionDetail({{ json_encode($t) }})">
                                    <i class="fa-solid fa-code me-1"></i> Payload
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-secondary">
                                <i class="fa-solid fa-receipt fa-3x text-secondary mb-3 d-block"></i>
                                Chưa có giao dịch nào được ghi nhận. Hãy bấm nút <b>"Bắn Thử Webhook Giả Lập"</b> để thử nghiệm ngay!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="card-footer bg-dark border-secondary p-3 d-flex justify-content-between align-items-center">
                <span class="text-secondary small">Hiển thị {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} / {{ $transactions->total() }} giao dịch</span>
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>

<!-- MODAL BẮN THỬ WEBHOOK GIẢ LẬP -->
<div class="modal fade" id="simulateWebhookModal" tabindex="-1" aria-labelledby="simulateWebhookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white" style="background: #111827; border: 1px solid #374151;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2" id="simulateWebhookModalLabel">
                    <i class="fa-solid fa-bolt text-warning"></i> Bắn Thử Webhook Giả Lập Từ SePay
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-secondary small mb-3">
                    Chức năng này mô phỏng chính xác gói tin JSON mà SePay sẽ bắn tới URL Webhook của bạn khi có khách chuyển khoản thật.
                </p>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Họ Tên Khách Hàng:</label>
                    <input type="text" id="simCustName" class="form-control form-control-custom text-white" value="Nguyễn Hoàng Khang">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Số Điện Thoại:</label>
                    <input type="tel" id="simCustPhone" class="form-control form-control-custom text-white" value="0988776655">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Số Tiền Chuyển Vào (VNĐ):</label>
                    <input type="number" id="simAmount" class="form-control form-control-custom text-warning fw-bold fs-5" value="100000000" step="10000000">
                    <small class="text-secondary">Ví dụ: 100.000.000 VNĐ đặt cọc giữ xe hoặc 4.797.000.000 VNĐ trả trước 30%</small>
                </div>

                <div id="simResultAlert" class="d-none alert alert-success small mb-0">
                    <i class="fa-solid fa-check me-1"></i> <span id="simResultMsg">Đã gửi thành công!</span>
                </div>
            </div>
            <div class="modal-footer border-secondary justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-warning text-dark fw-bold" id="btnSubmitSimulate">
                    <i class="fa-solid fa-paper-plane me-1"></i> Bắn Webhook Ngay
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL XEM RAW JSON PAYLOAD -->
<div class="modal fade" id="payloadModal" tabindex="-1" aria-labelledby="payloadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content text-white" style="background: #111827; border: 1px solid #374151;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2" id="payloadModalLabel">
                    <i class="fa-solid fa-code text-info"></i> Chi Tiết Webhook Payload JSON
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <pre class="bg-black p-3 rounded-3 text-success small mb-0" id="payloadJsonPre" style="max-height: 400px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyWebhookUrl() {
        const urlInput = document.getElementById("webhookUrlInput");
        navigator.clipboard.writeText(urlInput.value).then(() => {
            alert("Đã sao chép URL Webhook:\n" + urlInput.value + "\n\nBạn hãy dán URL này vào mục 'URL nhận webhook' trên SePay!");
        });
    }

    function showTransactionDetail(trans) {
        const payloadData = trans.raw_data || trans;
        document.getElementById("payloadJsonPre").textContent = JSON.stringify(payloadData, null, 2);
        const modal = new bootstrap.Modal(document.getElementById("payloadModal"));
        modal.show();
    }

    function syncSepayApiDirect() {
        const btn = document.getElementById("btnSyncSepayApi");
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5"></span> Đang kết nối SePay API...';

        fetch("{{ route('admin.payments.sync-sepay') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-cloud-arrow-down me-1.5"></i> Request Thông Tin Từ SePay API';
            alert(data.message || "Đã kiểm tra SePay API thành công!");
            if (data.synced_count > 0) {
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-cloud-arrow-down me-1.5"></i> Request Thông Tin Từ SePay API';
            alert("Lỗi kết nối tới SePay API. Vui lòng kiểm tra lại kết nối mạng!");
        });
    }

    document.getElementById("btnSubmitSimulate").addEventListener("click", function() {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang gửi webhook...';

        fetch("{{ route('admin.payments.simulate') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                customer_name: document.getElementById("simCustName").value,
                phone: document.getElementById("simCustPhone").value,
                amount: document.getElementById("simAmount").value
            })
        })
        .then(res => res.json())
        .then(data => {
            this.disabled = false;
            this.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Bắn Webhook Ngay';

            const alertEl = document.getElementById("simResultAlert");
            alertEl.classList.remove("d-none");
            document.getElementById("simResultMsg").textContent = data.message || "Webhook đã được tiếp nhận và xử lý!";

            // Kích hoạt ngay form popup thông báo nhỏ góc phải màn hình admin
            if (window.showAdminPaymentToast && data.transaction) {
                window.showAdminPaymentToast(data.transaction);
            }

            setTimeout(() => {
                location.reload();
            }, 1800);
        })
        .catch(err => {
            this.disabled = false;
            this.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Bắn Webhook Ngay';
            alert("Lỗi gửi webhook giả lập!");
        });
    });
</script>
@endpush
