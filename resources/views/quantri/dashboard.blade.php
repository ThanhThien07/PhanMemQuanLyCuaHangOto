@extends('layouts.admin')

@section('title', 'Trang Tổng Quan Quản Trị - PrimeLux Auto (dashboard.html)')

@section('content')
<div class="container-fluid px-3 px-md-4 py-2">

    <!-- TIÊU ĐỀ TRANG TỔNG QUAN -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold text-white mb-1">
                <i class="fa-solid fa-gauge-high text-primary me-2"></i> Tổng Quan Hoạt Động Showroom
            </h2>
            <p class="text-secondary small mb-0">Theo dõi doanh thu, kho xe, đơn hàng và tiến độ duyệt lịch lái thử thời gian thực</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/admin/cars-management.html') }}" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-boxes-stacked me-1"></i> Kho Xe (cars-management.html)
            </a>
            <a href="{{ url('/admin/test-drive-list.html') }}" class="btn btn-outline-warning btn-sm">
                <i class="fa-solid fa-calendar-check me-1"></i> Lịch Lái Thử (test-drive-list.html)
            </a>
            <a href="{{ url('/admin/payments.html') }}" class="btn btn-outline-info btn-sm">
                <i class="fa-solid fa-credit-card me-1 text-warning"></i> SePay Thanh Toán (payments.html)
            </a>
        </div>
    </div>

    <!-- 4 THẺ THỐNG KÊ CHÍNH (STAT CARDS) - CLICK ĐỂ LỌC NHANH TỪNG PHẦN -->
    <div class="row g-3 mb-3">
        <!-- 1. SỐ LƯỢNG XE -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-blue dash-card" data-filter="cars" role="button" title="Nhấp để chỉ hiển thị danh sách Kho xe">
                <span class="badge bg-primary position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">Số Lượng Xe Trong Kho</div>
                    <div class="stat-value text-white">
                        <span>{{ $totalCars }}</span>
                        <span class="stat-unit">mẫu xe</span>
                    </div>
                    <div class="stat-sub text-success">
                        <i class="fa-solid fa-circle-check"></i> Sẵn sàng bàn giao khách
                    </div>
                </div>
                <div class="stat-icon-wrap icon-blue">
                    <i class="fa-solid fa-car-side"></i>
                </div>
            </div>
        </div>

        <!-- 2. ĐƠN HÀNG MỚI -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-cyan dash-card" data-filter="invoices" role="button" title="Nhấp để chỉ hiển thị danh sách Đơn hàng / Hóa đơn mới">
                <span class="badge bg-info text-dark position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">Đơn Hàng / Hóa Đơn Mới</div>
                    <div class="stat-value text-info">
                        <span>{{ $totalInvoices }}</span>
                        <span class="stat-unit">giao dịch</span>
                    </div>
                    <div class="stat-sub text-info">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Đã thanh toán 100%
                    </div>
                </div>
                <div class="stat-icon-wrap icon-cyan">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>

        <!-- 3. LỊCH LÁI THỬ CHỜ DUYỆT -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-amber dash-card" data-filter="testdrives" role="button" title="Nhấp để chỉ hiển thị Lịch lái thử cần duyệt">
                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">Lịch Lái Thử Chờ Duyệt</div>
                    <div class="stat-value text-warning">
                        <span>{{ $pendingDrives }}</span>
                        <span class="stat-unit">yêu cầu</span>
                    </div>
                    <div class="stat-sub text-warning">
                        <i class="fa-solid fa-bell"></i> Cần chuyên viên liên hệ ngay
                    </div>
                </div>
                <div class="stat-icon-wrap icon-amber">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
        </div>

        <!-- 4. DOANH THU BÁN XE -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-emerald dash-card" data-filter="revenue" role="button" title="Nhấp để chỉ hiển thị Biểu đồ & Doanh thu bán xe">
                <span class="badge bg-success position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">Doanh Thu Bán Xe</div>
                    <div class="stat-value revenue-val text-success">
                        <span>{{ number_format($totalRevenue, 0, ',', '.') }}</span>
                        <span class="stat-unit text-success fw-bold">VNĐ</span>
                    </div>
                    <div class="stat-sub text-secondary">
                        <i class="fa-solid fa-arrow-trend-up text-success"></i> Tăng trưởng vượt mục tiêu
                    </div>
                </div>
                <div class="stat-icon-wrap icon-emerald">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- THANH ĐIỀU HƯỚNG BỘ LỌC TƯƠNG TÁC (ĐỒNG BỘ 2 CHIỀU) -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 p-2 rounded-3" style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08);">
        <div class="btn-group btn-group-sm" role="group" id="dashFilterButtonGroup">
            <button type="button" class="btn btn-primary dash-btn-filter active" data-filter="all">
                <i class="fa-solid fa-border-all me-1"></i> Tất Cả Hoạt Động
            </button>
            <button type="button" class="btn btn-dark border-secondary text-secondary dash-btn-filter" data-filter="cars">
                <i class="fa-solid fa-car-side me-1"></i> Kho Xe Trong Kho ({{ $totalCars }})
            </button>
            <button type="button" class="btn btn-dark border-secondary text-secondary dash-btn-filter" data-filter="invoices">
                <i class="fa-solid fa-file-invoice-dollar me-1"></i> Đơn Hàng Mới ({{ $totalInvoices }})
            </button>
            <button type="button" class="btn btn-dark border-secondary text-secondary dash-btn-filter" data-filter="testdrives">
                <i class="fa-solid fa-calendar-check me-1"></i> Lịch Lái Thử ({{ $pendingDrives }})
            </button>
            <button type="button" class="btn btn-dark border-secondary text-secondary dash-btn-filter" data-filter="revenue">
                <i class="fa-solid fa-chart-line me-1"></i> Doanh Thu Showroom
            </button>
        </div>
        <div id="filterStatusHint" class="text-secondary small">
            <i class="fa-solid fa-hand-pointer text-warning me-1"></i> Nhấp vào từng thẻ thống kê phía trên để lọc nhanh từng phần
        </div>
    </div>

    <!-- SECTION 1: DOANH THU & BIỂU ĐỒ BÁN XE (CHARTS SECTION) -->
    <div class="dash-section mb-4" id="sectionRevenue" data-section="revenue">
        <div class="row g-4">
            <!-- BIỂU ĐỒ 1: DOANH THU THEO THÁNG NĂM 2026 -->
            <div class="col-lg-8">
                <div class="p-4 rounded-4 bg-dark border border-secondary h-100 shadow-sm">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                        <div>
                            <h5 class="fw-bold text-white mb-1">
                                <i class="fa-solid fa-chart-column text-primary me-2"></i> Doanh Thu Bán Xe Theo Tháng (Năm 2026)
                            </h5>
                            <p class="text-secondary small mb-0">Đơn vị: Tỷ VNĐ / Tháng (Tổng kết bán hàng từ Showroom toàn quốc)</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-20 text-primary border border-primary px-3 py-1.5">
                            <i class="fa-solid fa-circle-dot me-1"></i> Dữ liệu tự động cập nhật
                        </span>
                    </div>
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- BIỂU ĐỒ 2: TỶ TRỌNG DOANH SỐ THEO HÃNG XE -->
            <div class="col-lg-4">
                <div class="p-4 rounded-4 bg-dark border border-secondary h-100 shadow-sm">
                    <div class="mb-3">
                        <h5 class="fw-bold text-white mb-1">
                            <i class="fa-solid fa-chart-pie text-warning me-2"></i> Tỷ Trọng Doanh Số Hãng Xe
                        </h5>
                        <p class="text-secondary small mb-0">Phân bố doanh số theo các hãng siêu xe</p>
                    </div>
                    <div style="position: relative; height: 260px; width: 100%;">
                        <canvas id="brandShareChart"></canvas>
                    </div>
                    <div class="d-flex justify-content-around text-center mt-3 pt-2 border-top border-secondary">
                        <div>
                            <div class="small text-secondary">Hạng 1</div>
                            <strong class="text-primary small">Mercedes 35%</strong>
                        </div>
                        <div>
                            <div class="small text-secondary">Hạng 2</div>
                            <strong class="text-warning small">Porsche 25%</strong>
                        </div>
                        <div>
                            <div class="small text-secondary">Hạng 3</div>
                            <strong class="text-info small">BMW 15%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: DANH SÁCH MẪU XE TRONG KHO (KHO XE SHOWROOM) -->
    <div class="dash-section mb-4" id="sectionCars" data-section="cars">
        <div class="p-4 rounded-4 bg-dark border border-secondary shadow-sm">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div>
                    <h5 class="fw-bold text-white mb-1">
                        <i class="fa-solid fa-warehouse text-primary me-2"></i> Danh Sách Mẫu Xe Trong Kho Showroom ({{ $totalCars }} Mẫu)
                    </h5>
                    <p class="text-secondary small mb-0">Các mẫu siêu xe sang sẵn sàng bàn giao và phục vụ khách lái thử</p>
                </div>
                <a href="{{ url('/admin/cars-management.html') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-boxes-stacked me-1"></i> Quản Lý Chi Tiết Kho Xe <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 small">
                    <thead>
                        <tr class="table-active">
                            <th>#</th>
                            <th>Mẫu Xe</th>
                            <th>Thương Hiệu</th>
                            <th>Phân Khúc</th>
                            <th>Giá Niêm Yết</th>
                            <th>Tình Trạng Kho</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $idx => $car)
                        <tr>
                            <td class="text-secondary font-monospace">{{ $idx + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset($car['image'] ?? 'image/cars/maybach.png') }}" alt="{{ $car['name'] }}" class="rounded-2" style="width: 50px; height: 32px; object-fit: cover;" onerror="this.src='{{ asset('image/Logo.png') }}'">
                                    <div>
                                        <strong class="text-white">{{ $car['name'] }}</strong>
                                        <br><small class="text-secondary">{{ $car['year'] ?? 2026 }} • {{ $car['fuel'] ?? 'Xăng cao cấp' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $car['brand'] ?? 'PrimeLux' }}</span></td>
                            <td>{{ $car['type'] ?? 'Sedan Hạng Sang' }} ({{ $car['seats'] ?? 5 }} chỗ)</td>
                            <td class="text-warning fw-bold">{{ $car['price_vnd'] ?? (number_format($car['price'] ?? 0, 0, ',', '.') . ' VNĐ') }}</td>
                            <td>
                                <span class="badge bg-success bg-opacity-20 text-success border border-success">
                                    <i class="fa-solid fa-circle-check me-1"></i> {{ $car['status'] ?? 'Sẵn sàng giao' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ url('/cars/' . ($car['id'] ?? 1)) }}" target="_blank" class="btn btn-outline-info btn-sm py-1 px-2" title="Xem chi tiết xe">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION 3 & 4: ĐƠN HÀNG VÀ LỊCH LÁI THỬ -->
    <div class="row g-4 mb-4" id="rowInvoicesAndTestDrives">
        <!-- ĐƠN HÀNG / HÓA ĐƠN BÁN XE GẦN ĐÂY -->
        <div class="col-lg-7 dash-section-col" id="colInvoices" data-section="invoices">
            <div class="p-4 rounded-4 bg-dark border border-secondary h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-white mb-0">
                            <i class="fa-solid fa-file-invoice-dollar text-success me-2"></i> Đơn Hàng Mới Nhất
                        </h5>
                        <p class="text-secondary small mb-0">Các giao dịch xe sang vừa được xác nhận</p>
                    </div>
                    <a href="{{ url('/invoices') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                        Xem Tất Cả Hóa Đơn <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr class="table-active">
                                <th>Mã HĐ</th>
                                <th>Khách Hàng</th>
                                <th>Mẫu Xe Mua</th>
                                <th>Thanh Toán</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices->take(5) as $inv)
                            <tr>
                                <td class="font-monospace fw-bold text-info">{{ $inv['code'] ?? $inv->ma_hd }}</td>
                                <td>
                                    <strong>{{ $inv['customer_name'] ?? ($inv->customer->ho_ten ?? 'VIP Customer') }}</strong>
                                    <br><small class="text-secondary">{{ $inv['customer_phone'] ?? ($inv->customer->sdt ?? '') }}</small>
                                </td>
                                <td>{{ $inv['car_name'] ?? 'Mercedes-Maybach S 680' }}</td>
                                <td class="text-warning fw-bold">{{ $inv['total_price'] ?? (number_format($inv->tong_tien_thanh_toan, 0, ',', '.') . ' VNĐ') }}</td>
                                <td><span class="badge bg-success">Đã thanh toán</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- LỊCH LÁI THỬ CẦN XỬ LÝ NGAY -->
        <div class="col-lg-5 dash-section-col" id="colTestDrives" data-section="testdrives">
            <div class="p-4 rounded-4 bg-dark border border-secondary h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-white mb-0">
                            <i class="fa-solid fa-clock-rotate-left text-warning me-2"></i> Lịch Lái Thử Cần Duyệt
                        </h5>
                        <p class="text-secondary small mb-0">Yêu cầu từ khách hàng đăng ký trực tuyến</p>
                    </div>
                    <a href="{{ url('/admin/test-drive-list.html') }}" class="btn btn-warning text-dark btn-sm fw-bold">
                        Quản Lý Lịch <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr class="table-active">
                                <th>Khách Hàng</th>
                                <th>Xe Lái Thử</th>
                                <th>Thời Gian</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testDrives->take(5) as $td)
                            <tr>
                                <td>
                                    <strong class="text-white">{{ $td->ho_ten }}</strong>
                                    <br><small class="text-secondary">{{ $td->sdt }}</small>
                                </td>
                                <td class="text-info fw-bold">{{ $td->ten_xe }}</td>
                                <td class="small">{{ substr($td->thoi_gian, 0, 16) }}</td>
                                <td>
                                    <span class="badge {{ $td->trang_thai === 'Đang chờ duyệt' || $td->trang_thai === 'Chờ duyệt' ? 'bg-warning text-dark' : ($td->trang_thai === 'Đã liên hệ' ? 'bg-primary' : 'bg-success') }}">
                                        {{ $td->trang_thai }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // TƯƠNG TÁC LỌC NHANH KHI CLICK VÀO CÁC THẺ THỐNG KÊ (INTERACTIVE FILTERING)
        setupDashboardFiltering();

        // 1. BIỂU ĐỒ DOANH THU THEO THÁNG NĂM 2026 (BAR & LINE COMBO CHART)
        const ctxMonthly = document.getElementById('monthlyRevenueChart');
        if (ctxMonthly) {
            const monthlyData = {!! json_encode($monthlyRevenue['data'] ?? [18.5, 22.1, 15.8, 31.2, 28.6, 35.4, 42.0, 38.5, 52.8, 48.0, 56.5, 68.2]) !!};
            const monthlyLabels = {!! json_encode($monthlyRevenue['labels'] ?? ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12']) !!};

            new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [
                        {
                            type: 'line',
                            label: 'Xu Hướng Tăng Trưởng (Tỷ VNĐ)',
                            data: monthlyData,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderWidth: 3,
                            fill: false,
                            tension: 0.35,
                            pointBackgroundColor: '#f59e0b',
                            pointRadius: 4
                        },
                        {
                            type: 'bar',
                            label: 'Doanh Số Bán Xe (Tỷ VNĐ)',
                            data: monthlyData,
                            backgroundColor: 'rgba(37, 99, 235, 0.75)',
                            hoverBackgroundColor: '#2563eb',
                            borderRadius: 6,
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#94a3b8',
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' Tỷ VNĐ';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#94a3b8' }
                        },
                        y: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#94a3b8',
                                callback: function(val) { return val + ' Tỷ'; }
                            }
                        }
                    }
                }
            });
        }

        // 2. BIỂU ĐỒ TRÒN THỊ PHẦN THEO THƯƠNG HIỆU (DOUGHNUT CHART)
        const ctxBrand = document.getElementById('brandShareChart');
        if (ctxBrand) {
            new Chart(ctxBrand, {
                type: 'doughnut',
                data: {
                    labels: ['Mercedes-Benz', 'Porsche', 'BMW', 'Audi', 'Land Rover', 'Lexus'],
                    datasets: [{
                        data: [35, 25, 15, 10, 10, 5],
                        backgroundColor: [
                            '#2563eb', // Mercedes
                            '#f59e0b', // Porsche
                            '#06b6d4', // BMW
                            '#ef4444', // Audi
                            '#10b981', // Land Rover
                            '#8b5cf6'  // Lexus
                        ],
                        borderWidth: 2,
                        borderColor: '#111827'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#94a3b8',
                                boxWidth: 12,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    });

    // HÀM XỬ LÝ LỌC TƯƠNG TÁC ĐỒNG BỘ CHO CÁC THẺ THỐNG KÊ
    function setupDashboardFiltering() {
        let currentFilter = 'all';

        const cards = document.querySelectorAll('.dash-card');
        const filterBtns = document.querySelectorAll('.dash-btn-filter');
        const hintEl = document.getElementById('filterStatusHint');

        const secRevenue = document.getElementById('sectionRevenue');
        const secCars = document.getElementById('sectionCars');
        const rowInvoicesAndTestDrives = document.getElementById('rowInvoicesAndTestDrives');
        const colInvoices = document.getElementById('colInvoices');
        const colTestDrives = document.getElementById('colTestDrives');

        const filterNames = {
            'all': 'Tất Cả Hoạt Động',
            'cars': 'Kho Xe Trong Kho',
            'invoices': 'Đơn Hàng / Hóa Đơn Mới',
            'testdrives': 'Lịch Lái Thử Cần Duyệt',
            'revenue': 'Biểu Đồ Doanh Thu Bán Xe'
        };

        function applyFilter(filter) {
            // Nhấp lại thẻ đang kích hoạt sẽ quay về hiển thị tất cả
            if (currentFilter === filter && filter !== 'all') {
                filter = 'all';
            }
            currentFilter = filter;

            // 1. Cập nhật trạng thái Active trên 4 Thẻ thống kê
            cards.forEach(card => {
                const cardFilter = card.dataset.filter;
                const pill = card.querySelector('.filter-pill');
                card.classList.remove('active-blue', 'active-cyan', 'active-amber', 'active-emerald');
                if (pill) pill.classList.add('d-none');

                if (cardFilter === filter) {
                    if (cardFilter === 'cars') card.classList.add('active-blue');
                    if (cardFilter === 'invoices') card.classList.add('active-cyan');
                    if (cardFilter === 'testdrives') card.classList.add('active-amber');
                    if (cardFilter === 'revenue') card.classList.add('active-emerald');
                    if (pill) pill.classList.remove('d-none');
                }
            });

            // 2. Cập nhật nút bấm trong thanh bộ lọc
            filterBtns.forEach(btn => {
                const btnFilter = btn.dataset.filter;
                if (btnFilter === filter) {
                    btn.className = 'btn btn-primary dash-btn-filter active';
                } else {
                    btn.className = 'btn btn-dark border-secondary text-secondary dash-btn-filter';
                }
            });

            // 3. Cập nhật thông báo trạng thái lọc
            if (hintEl) {
                if (filter === 'all') {
                    hintEl.innerHTML = '<i class="fa-solid fa-hand-pointer text-warning me-1"></i> Nhấp vào từng thẻ thống kê phía trên để lọc nhanh từng phần';
                } else {
                    hintEl.innerHTML = `<span class="badge bg-warning text-dark me-1"><i class="fa-solid fa-filter me-1"></i>Đang xem: ${filterNames[filter]}</span> <a href="javascript:void(0)" class="text-info text-decoration-underline ms-1" onclick="window.applyDashboardFilter('all')">Xem lại tất cả</a>`;
                }
            }

            // 4. Ẩn / Hiện các phần tương ứng
            if (filter === 'all') {
                if (secRevenue) secRevenue.classList.remove('d-none');
                if (secCars) secCars.classList.remove('d-none');
                if (rowInvoicesAndTestDrives) rowInvoicesAndTestDrives.classList.remove('d-none');
                if (colInvoices) {
                    colInvoices.classList.remove('d-none');
                    colInvoices.className = 'col-lg-7 dash-section-col';
                }
                if (colTestDrives) {
                    colTestDrives.classList.remove('d-none');
                    colTestDrives.className = 'col-lg-5 dash-section-col';
                }
            } else if (filter === 'cars') {
                if (secRevenue) secRevenue.classList.add('d-none');
                if (secCars) secCars.classList.remove('d-none');
                if (rowInvoicesAndTestDrives) rowInvoicesAndTestDrives.classList.add('d-none');
                secCars.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (filter === 'invoices') {
                if (secRevenue) secRevenue.classList.add('d-none');
                if (secCars) secCars.classList.add('d-none');
                if (rowInvoicesAndTestDrives) rowInvoicesAndTestDrives.classList.remove('d-none');
                if (colInvoices) {
                    colInvoices.classList.remove('d-none');
                    colInvoices.className = 'col-12 dash-section-col';
                }
                if (colTestDrives) colTestDrives.classList.add('d-none');
                rowInvoicesAndTestDrives.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (filter === 'testdrives') {
                if (secRevenue) secRevenue.classList.add('d-none');
                if (secCars) secCars.classList.add('d-none');
                if (rowInvoicesAndTestDrives) rowInvoicesAndTestDrives.classList.remove('d-none');
                if (colInvoices) colInvoices.classList.add('d-none');
                if (colTestDrives) {
                    colTestDrives.classList.remove('d-none');
                    colTestDrives.className = 'col-12 dash-section-col';
                }
                rowInvoicesAndTestDrives.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (filter === 'revenue') {
                if (secRevenue) secRevenue.classList.remove('d-none');
                if (secCars) secCars.classList.add('d-none');
                if (rowInvoicesAndTestDrives) rowInvoicesAndTestDrives.classList.add('d-none');
                secRevenue.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Gán sự kiện click cho các thẻ thống kê
        cards.forEach(card => {
            card.addEventListener('click', () => {
                const filter = card.dataset.filter;
                applyFilter(filter);
            });
        });

        // Gán sự kiện click cho các nút lọc
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;
                applyFilter(filter);
            });
        });

        // Export ra window để gọi từ link ngoài
        window.applyDashboardFilter = applyFilter;
    }
</script>
@endpush
