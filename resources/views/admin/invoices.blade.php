@extends('layouts.admin')

@section('title', 'Quản Lý Hóa Đơn Bán Xe & Doanh Thu - PrimeLux Auto Admin')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- TIÊU ĐỀ & NÚT HÀNH ĐỘNG -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0">Quản Lý Hóa Đơn Bán Xe & Doanh Thu Showroom</h2>
                <span class="badge bg-success bg-opacity-20 text-success border border-success px-3 py-1">
                    <i class="fa-solid fa-receipt me-1"></i> Dữ Liệu Thời Gian Thực
                </span>
            </div>
            <p class="text-secondary small mb-0">
                Theo dõi tình trạng đơn đặt hàng, tiền cọc trả trước, chiết khấu hội viên VIP và xuất hóa đơn điện tử về Gmail khách hàng.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/admin/export/invoices') }}" class="btn btn-outline-success btn-sm">
                <i class="fa-solid fa-file-excel me-1"></i> Xuất Báo Cáo Excel/CSV
            </a>
            <button type="button" class="btn btn-outline-light btn-sm" onclick="location.reload()">
                <i class="fa-solid fa-arrows-rotate me-1"></i> Làm Mới
            </button>
        </div>
    </div>

    {{-- THÔNG BÁO LỖI / THÀNH CÔNG --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.4); color: #86efac;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5;">
            <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 4 THẺ THỐNG KÊ (STAT CARDS) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-emerald">
                <div>
                    <div class="stat-title text-success">Tổng Doanh Thu Hóa Đơn</div>
                    <div class="stat-value text-white revenue-val">{{ number_format($totalRevenue, 0, ',', '.') }} <span class="stat-unit">VNĐ</span></div>
                    <div class="stat-sub text-success"><i class="fa-solid fa-chart-line"></i> Doanh thu thực tế đã ghi nhận</div>
                </div>
                <div class="stat-icon-wrap icon-emerald">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-blue">
                <div>
                    <div class="stat-title text-primary">Tổng Đơn / Hóa Đơn</div>
                    <div class="stat-value text-white">{{ number_format($totalInvoices) }} <span class="stat-unit">giao dịch</span></div>
                    <div class="stat-sub text-secondary"><i class="fa-solid fa-file-invoice"></i> Toàn bộ giao dịch showroom</div>
                </div>
                <div class="stat-icon-wrap icon-blue">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-cyan">
                <div>
                    <div class="stat-title text-info">Đã Hoàn Tất Thanh Toán</div>
                    <div class="stat-value text-white">{{ number_format($paidInvoices) }} <span class="stat-unit">hóa đơn</span></div>
                    <div class="stat-sub text-info"><i class="fa-solid fa-shield-check"></i> Đã cọc hoặc thanh toán 100%</div>
                </div>
                <div class="stat-icon-wrap icon-cyan">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="stat-card-luxury card-amber">
                <div>
                    <div class="stat-title text-warning">Đang Chờ Thanh Toán</div>
                    <div class="stat-value text-white">{{ number_format($pendingInvoices) }} <span class="stat-unit">hóa đơn</span></div>
                    <div class="stat-sub text-warning"><i class="fa-solid fa-clock"></i> Chờ chuyển khoản trả trước</div>
                </div>
                <div class="stat-icon-wrap icon-amber">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- KHỐI BỘ LỌC & TÌM KIẾM -->
    <div class="card bg-dark border-secondary rounded-4 mb-4 shadow-sm">
        <div class="card-body p-3">
            <form action="{{ route('admin.invoices.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control form-control-custom text-white" placeholder="Tìm theo Mã HĐ, Tên khách hàng, SĐT hoặc Email..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('admin.invoices.index', ['status' => 'all', 'search' => $search]) }}" class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">Tất Cả</a>
                        <a href="{{ route('admin.invoices.index', ['status' => 'paid', 'search' => $search]) }}" class="btn btn-sm {{ $status === 'paid' ? 'btn-success' : 'btn-outline-secondary' }}">Đã Thanh Toán</a>
                        <a href="{{ route('admin.invoices.index', ['status' => 'pending', 'search' => $search]) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-outline-secondary' }}">Chờ Thanh Toán</a>
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn btn-accent btn-sm px-3">
                        <i class="fa-solid fa-filter me-1"></i> Áp Dụng Lọc
                    </button>
                    @if(!empty($search) || $status !== 'all')
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-danger btn-sm ms-1">
                            <i class="fa-solid fa-xmark"></i> Bỏ Lọc
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH HÓA ĐƠN -->
    <div class="card bg-dark border-secondary rounded-4 shadow-sm overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover align-middle mb-0 small">
                <thead>
                    <tr class="text-secondary text-uppercase border-secondary">
                        <th class="ps-3 py-3">Mã Hóa Đơn</th>
                        <th>Ngày Lập</th>
                        <th>Khách Hàng & Liên Hệ</th>
                        <th>Hạng VIP</th>
                        <th class="text-end">Giá Gốc</th>
                        <th class="text-end">Giảm Giá VIP</th>
                        <th class="text-end">Tổng Thanh Toán</th>
                        <th>Hình Thức</th>
                        <th class="text-center">Trạng Thái</th>
                        <th class="text-center pe-3">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                        <tr>
                            <td class="ps-3 fw-bold text-warning fs-6">
                                #{{ $inv->ma_hd }}
                            </td>
                            <td class="text-secondary">
                                {{ $inv->ngay_lap ? \Carbon\Carbon::parse($inv->ngay_lap)->format('d/m/Y') : $inv->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="fw-bold text-white">{{ $inv->customer->ho_ten ?? $inv->ma_kh }}</div>
                                <div class="text-secondary small">
                                    <i class="fa-solid fa-phone text-info me-1"></i>{{ $inv->customer->sdt ?? 'N/A' }}
                                    @if(!empty($inv->customer->email))
                                        <span class="ms-1 text-light">| <i class="fa-solid fa-envelope text-warning me-1"></i>{{ $inv->customer->email }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-20 text-primary border border-primary">
                                    {{ $inv->customer->tier->ten_hang ?? 'Silver Member' }}
                                </span>
                            </td>
                            <td class="text-end text-secondary">
                                {{ number_format($inv->tong_tien_goc, 0, ',', '.') }} đ
                            </td>
                            <td class="text-end text-success fw-bold">
                                {{ $inv->giam_gia_hang > 0 ? '-' . number_format($inv->giam_gia_hang, 0, ',', '.') . ' đ' : '0 đ' }}
                            </td>
                            <td class="text-end fw-extrabold text-warning fs-6">
                                {{ number_format($inv->tong_tien_thanh_toan, 0, ',', '.') }} VNĐ
                            </td>
                            <td>
                                <span class="badge bg-dark border border-secondary text-light">
                                    {{ $inv->phuong_thuc_tt ?? 'Chuyển khoản SePay' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if(stripos($inv->trang_thai, 'hoàn tất') !== false || stripos($inv->trang_thai, '100%') !== false)
                                    <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Hoàn tất 100%</span>
                                @elseif(stripos($inv->trang_thai, 'thanh toán') !== false || stripos($inv->trang_thai, 'trả trước') !== false)
                                    <span class="badge bg-info text-dark"><i class="fa-solid fa-shield-check me-1"></i> Đã cọc trả trước</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> {{ $inv->trang_thai ?: 'Chờ thanh toán' }}</span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-info btn-xs py-1 px-2" onclick="openInvoiceModal('{{ $inv->ma_hd }}')" title="Xem chi tiết hóa đơn">
                                        <i class="fa-solid fa-eye me-1"></i> Chi Tiết
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-xs py-1 px-2 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Thao tác</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item text-info" href="javascript:void(0)" onclick="openInvoiceModal('{{ $inv->ma_hd }}')">
                                                <i class="fa-solid fa-file-invoice me-2"></i> Xem & In Hóa Đơn
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.invoices.resend-email', $inv->ma_hd) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-light">
                                                    <i class="fa-solid fa-envelope me-2 text-warning"></i> Gửi lại Email tới Gmail
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><h6 class="dropdown-header text-secondary small">Cập nhật trạng thái:</h6></li>
                                        <li>
                                            <form action="{{ route('admin.invoices.status', $inv->ma_hd) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trang_thai" value="Đã thanh toán 100%">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fa-solid fa-circle-check me-2"></i> Đã thanh toán 100%
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.invoices.status', $inv->ma_hd) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trang_thai" value="Đã thanh toán trả trước (SePay)">
                                                <button type="submit" class="dropdown-item text-info">
                                                    <i class="fa-solid fa-shield-check me-2"></i> Đã cọc trả trước (SePay)
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.invoices.status', $inv->ma_hd) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trang_thai" value="Chờ khách chuyển khoản cọc">
                                                <button type="submit" class="dropdown-item text-warning">
                                                    <i class="fa-solid fa-clock me-2"></i> Đang chờ thanh toán
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-secondary">
                                <i class="fa-solid fa-receipt fa-3x mb-3 text-secondary opacity-50"></i>
                                <div>Chưa có hóa đơn nào phù hợp với điều kiện tìm kiếm.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($invoices->hasPages())
            <div class="card-footer bg-dark border-secondary p-3">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>

<!-- MODAL CHI TIẾT HÓA ĐƠN BÁN XE (LUXURY INVOICE MODAL) -->
<div class="modal fade" id="invoiceDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border border-secondary rounded-4 shadow-lg text-white">
            <div class="modal-header border-secondary p-3.5 bg-dark">
                <div class="d-flex align-items-center gap-2">
                    <span class="p-2 rounded bg-warning bg-opacity-20 text-warning">
                        <i class="fa-solid fa-file-invoice-dollar fs-5"></i>
                    </span>
                    <div>
                        <h5 class="fw-bold text-white mb-0" id="modalInvTitle">Hóa Đơn Bán Xe #HD0001</h5>
                        <small class="text-secondary" id="modalInvDate">Ngày lập: --/--/----</small>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="printInvoice()">
                        <i class="fa-solid fa-print me-1"></i> In Hóa Đơn
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-4" id="printableInvoiceArea">
                <!-- LOGO & BRAND HEADER -->
                <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4">
                    <div>
                        <h4 class="fw-bold mb-0 text-white">PRIMELUX <span class="badge bg-warning text-dark fs-6">AUTO SHOWROOM</span></h4>
                        <small class="text-secondary">Showroom Siêu Xe & Xe Sang Chính Hãng Chuẩn Châu Âu</small>
                        <div class="text-secondary small mt-1">123 Nguyễn Văn Linh, P. Tân Phong, Quận 7, TP.HCM | Hotline: 0338 929 013</div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success bg-opacity-20 text-success border border-success px-3 py-1.5 fs-6" id="modalInvStatus">
                            ĐÃ THANH TOÁN
                        </span>
                        <div class="text-secondary small mt-1">Mã tra cứu: <code class="text-warning" id="modalInvCode">HD0001</code></div>
                    </div>
                </div>

                <!-- THÔNG TIN KHÁCH HÀNG & THÀNH VIÊN -->
                <div class="row g-3 mb-4 p-3 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="col-md-6">
                        <div class="text-secondary small">Khách Hàng Mua Xe:</div>
                        <h5 class="fw-bold text-white mb-1" id="modalCustName">Nguyễn Văn A</h5>
                        <div class="text-light small"><i class="fa-solid fa-phone text-info me-1"></i> <span id="modalCustPhone">0901234567</span></div>
                        <div class="text-light small"><i class="fa-solid fa-envelope text-warning me-1"></i> <span id="modalCustEmail">email@example.com</span></div>
                        <div class="text-secondary small"><i class="fa-solid fa-location-dot text-danger me-1"></i> <span id="modalCustAddress">TP. Hồ Chí Minh</span></div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-secondary small">Hạng Thành Viên & Đặc Quyền:</div>
                        <span class="badge bg-primary px-3 py-1.5 fs-6 mt-1" id="modalCustTier">
                            <i class="fa-solid fa-crown me-1 text-warning"></i> Hạng Kim Cương (Diamond VIP)
                        </span>
                        <div class="small text-secondary mt-2">Bảo hành chính hãng: <strong class="text-white" id="modalWarranty">36 Tháng</strong></div>
                        <div class="small text-secondary">Phương thức: <strong class="text-info" id="modalPaymentMethod">Chuyển khoản SePay</strong></div>
                    </div>
                </div>

                <!-- BẢNG CHI TIẾT SẢN PHẨM MUA -->
                <div class="table-responsive mb-4">
                    <table class="table table-dark table-bordered border-secondary align-middle mb-0">
                        <thead class="bg-secondary bg-opacity-25 text-secondary">
                            <tr>
                                <th>STT</th>
                                <th>Tên Mẫu Xe Sang / Phiên Bản</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-end">Đơn Giá Niêm Yết</th>
                                <th class="text-end">Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>
                                    <strong class="text-white fs-6" id="modalCarName">Mercedes-Maybach S 680 4MATIC</strong>
                                    <div class="text-secondary small" id="modalCarSpecs">Động cơ V12 Biturbo 612HP • Giao ngay trong tuần</div>
                                </td>
                                <td class="text-center">1</td>
                                <td class="text-end text-light" id="modalCarPrice">15.990.000.000 VNĐ</td>
                                <td class="text-end text-white fw-bold" id="modalCarTotal">15.990.000.000 VNĐ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TỔNG KẾT TÀI CHÍNH & CHIẾT KHẤU -->
                <div class="row justify-content-end mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: rgba(234, 179, 8, 0.05); border: 1px solid rgba(234, 179, 8, 0.2);">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Tổng Tiền Gốc:</span>
                                <span class="text-white fw-semibold" id="modalSumPrice">15.990.000.000 VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-success">Chiết Khấu VIP Club:</span>
                                <span class="text-success fw-bold" id="modalDiscount">-479.700.000 VNĐ</span>
                            </div>
                            <hr class="border-secondary my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-white fs-6">Tổng Thanh Toán:</span>
                                <span class="fw-extrabold text-warning fs-5" id="modalFinalTotal">15.510.300.000 VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CHỮ KÝ VÀ DẤU SHOWROOM -->
                <div class="row text-center mt-5 pt-3 border-top border-secondary border-opacity-50 text-secondary">
                    <div class="col-6">
                        <div class="small fw-bold">KHÁCH HÀNG MUA XE</div>
                        <div class="small text-secondary mt-1">(Ký và ghi rõ họ tên)</div>
                        <div style="height: 60px;"></div>
                        <div class="fw-bold text-white" id="modalSignCustName">Nguyễn Văn A</div>
                    </div>
                    <div class="col-6">
                        <div class="small fw-bold">ĐẠI DIỆN SHOWROOM PRIMELUX</div>
                        <div class="small text-secondary mt-1">(Giám đốc Showroom ký duyệt)</div>
                        <div style="height: 60px;"></div>
                        <div class="fw-bold text-warning">Võ Hoàng Long</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary p-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-warning btn-sm fw-bold text-dark" onclick="printInvoice()">
                    <i class="fa-solid fa-print me-1"></i> In Hóa Đơn Ngay
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatVnd(num) {
        return new Intl.NumberFormat('vi-VN').format(num) + ' VNĐ';
    }

    async function openInvoiceModal(invCode) {
        try {
            const res = await fetch(`/admin/invoices/${invCode}`);
            const data = await res.json();
            if (data.success && data.invoice) {
                const inv = data.invoice;
                const cust = inv.customer || {};
                const car = data.car || {};

                document.getElementById('modalInvTitle').innerText = 'Hóa Đơn Bán Xe #' + inv.ma_hd;
                document.getElementById('modalInvCode').innerText = inv.ma_hd;
                document.getElementById('modalInvDate').innerText = 'Ngày lập: ' + (inv.ngay_lap || '--');
                document.getElementById('modalInvStatus').innerText = inv.trang_thai || 'Đã thanh toán';

                document.getElementById('modalCustName').innerText = cust.ho_ten || 'Khách hàng';
                document.getElementById('modalSignCustName').innerText = cust.ho_ten || 'Khách hàng';
                document.getElementById('modalCustPhone').innerText = cust.sdt || 'Chưa cập nhật';
                document.getElementById('modalCustEmail').innerText = cust.email || 'Chưa cập nhật';
                document.getElementById('modalCustAddress').innerText = cust.dia_chi || 'Việt Nam';

                const tierName = (cust.tier && cust.tier.ten_hang) ? cust.tier.ten_hang : 'Silver Member';
                document.getElementById('modalCustTier').innerHTML = `<i class="fa-solid fa-crown me-1 text-warning"></i> ${tierName}`;

                document.getElementById('modalWarranty').innerText = inv.thoi_gian_bh || '36 Tháng';
                document.getElementById('modalPaymentMethod').innerText = inv.phuong_thuc_tt || 'Chuyển khoản SePay';

                const carName = car.name || (inv.details && inv.details[0] && inv.details[0].car ? inv.details[0].car.ten_xe : 'Siêu xe PrimeLux');
                document.getElementById('modalCarName').innerText = carName;
                document.getElementById('modalCarSpecs').innerText = (car.power || '') + ' ' + (car.fuel || '') + ' • Chuẩn kiểm định châu Âu';

                document.getElementById('modalCarPrice').innerText = formatVnd(inv.tong_tien_goc || 0);
                document.getElementById('modalCarTotal').innerText = formatVnd(inv.tong_tien_goc || 0);
                document.getElementById('modalSumPrice').innerText = formatVnd(inv.tong_tien_goc || 0);
                document.getElementById('modalDiscount').innerText = '-' + formatVnd(inv.giam_gia_hang || 0);
                document.getElementById('modalFinalTotal').innerText = formatVnd(inv.tong_tien_thanh_toan || 0);

                const modal = new bootstrap.Modal(document.getElementById('invoiceDetailModal'));
                modal.show();
            }
        } catch (e) {
            alert('Lỗi khi tải chi tiết hóa đơn: ' + e.message);
        }
    }

    function printInvoice() {
        const printContent = document.getElementById('printableInvoiceArea').innerHTML;
        const originalContent = document.body.innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>In Hóa Đơn PrimeLux Auto</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { background: #fff !important; color: #000 !important; font-family: sans-serif; padding: 20px; }
                    .table-dark { color: #000 !important; background: #fff !important; }
                    .table-dark td, .table-dark th { border-color: #dee2e6 !important; color: #000 !important; }
                    .badge { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
                    .text-white { color: #000 !important; }
                    .text-secondary { color: #6c757d !important; }
                    .text-warning { color: #b45309 !important; }
                    .text-success { color: #15803d !important; }
                    .text-light { color: #000 !important; }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>
@endsection
