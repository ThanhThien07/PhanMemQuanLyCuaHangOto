@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển Quản Trị - PrimeLux Auto Admin')

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- THỐNG KÊ TỔNG QUAN -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="p-3 rounded-4 bg-dark border border-secondary d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-bold text-uppercase">Mẫu Xe Trong Kho</div>
                    <div class="fs-2 fw-bold text-white" id="stat-total-cars">{{ $totalCars }}</div>
                </div>
                <div class="p-3 rounded-3 bg-primary bg-opacity-20 text-primary fs-3">
                    <i class="fa-solid fa-car"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="p-3 rounded-4 bg-dark border border-secondary d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-bold text-uppercase">Lịch Lái Thử Mới</div>
                    <div class="fs-2 fw-bold text-warning" id="stat-total-drives">{{ $totalDrives }}</div>
                </div>
                <div class="p-3 rounded-3 bg-warning bg-opacity-20 text-warning fs-3">
                    <i class="fa-solid fa-steering-wheel"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="p-3 rounded-4 bg-dark border border-secondary d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-bold text-uppercase">Hội Viên PrimeLux Club</div>
                    <div class="fs-2 fw-bold text-info" id="stat-total-customers">{{ $totalCustomers }}</div>
                    <div class="text-secondary small">Tích lũy: <span class="text-warning fw-bold">{{ number_format($totalPoints) }} pts</span></div>
                </div>
                <div class="p-3 rounded-3 bg-info bg-opacity-20 text-info fs-3">
                    <i class="fa-solid fa-crown"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="p-3 rounded-4 bg-dark border border-secondary d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-bold text-uppercase">Giá Trị Kho Hàng</div>
                    <div class="fs-4 fw-bold text-success" id="stat-total-val">{{ number_format($totalValue, 0, ',', '.') }} VNĐ</div>
                </div>
                <div class="p-3 rounded-3 bg-success bg-opacity-20 text-success fs-3">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- NAV TABS QUẢN LÝ THEO CƠ SỞ DỮ LIỆU -->
    <ul class="nav nav-tabs border-secondary mb-4" id="adminTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active text-white fw-bold" id="cars-tab" data-bs-toggle="tab" data-bs-target="#cars-panel">
                <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Kho Xe & Danh Mục (XE, THUONGHIEU, LOAIXE)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link text-white fw-bold" id="imports-tab" data-bs-toggle="tab" data-bs-target="#imports-panel">
                <i class="fa-solid fa-file-import text-success me-2"></i> Nhập Hàng (PHIEUNHAP, NHACUNGCAP)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link text-white fw-bold" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices-panel">
                <i class="fa-solid fa-file-invoice-dollar text-warning me-2"></i> Hóa Đơn & Chiết Khấu VIP (HOADON)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link text-white fw-bold" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers-panel">
                <i class="fa-solid fa-users text-info me-2"></i> Khách Hàng & Điểm Thưởng (KHACHHANG)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link text-white fw-bold" id="tiers-tab" data-bs-toggle="tab" data-bs-target="#tiers-panel">
                <i class="fa-solid fa-crown text-warning me-2"></i> Hạng Hội Viên & Cơ Chế Ưu Đãi (HANGTHANHVIEN)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link text-white fw-bold" id="drives-tab" data-bs-toggle="tab" data-bs-target="#drives-panel">
                <i class="fa-solid fa-calendar-check text-warning me-2"></i> Lịch Đăng Ký Lái Thử
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link text-white fw-bold" id="chats-tab" data-bs-toggle="tab" data-bs-target="#chats-panel">
                <i class="fa-solid fa-robot text-info me-2"></i> Lịch Sử Chatbot AI
            </button>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content" id="adminTabsContent">
        
        <!-- TAB 1: QUẢN LÝ KHO XE -->
        <div class="tab-pane fade show active" id="cars-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-white mb-0">Danh Sách Mẫu Xe Trong Kho</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">
                    <i class="fa-solid fa-plus me-1"></i> Thêm Xe Mới
                </button>
            </div>

            <div class="table-responsive rounded-4 border border-secondary">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th>Ảnh</th>
                            <th>Tên Mẫu Xe</th>
                            <th>Thương Hiệu</th>
                            <th>Giá Niêm Yết</th>
                            <th>Động Cơ / Nhiên Liệu</th>
                            <th>Nhãn Tag</th>
                            <th class="text-end">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="admin-cars-tbody"></tbody>
                </table>
            </div>
        </div>

        <!-- TAB 2: NHẬP HÀNG -->
        <div class="tab-pane fade" id="imports-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-white mb-0">Quản Lý Nhập Hàng (PHIEUNHAP & NHACUNGCAP)</h4>
                <button class="btn btn-success btn-sm"><i class="fa-solid fa-plus me-1"></i> Tạo Phiếu Nhập</button>
            </div>
            <div class="table-responsive rounded-4 border border-secondary">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th>Mã Phiếu</th>
                            <th>Nhà Cung Cấp</th>
                            <th>Mẫu Xe Nhập</th>
                            <th>Số Lượng</th>
                            <th>Tổng Tiền Nhập</th>
                            <th>Ngày Nhập</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-monospace">PN001</td>
                            <td>Mercedes-Benz Việt Nam</td>
                            <td>Mercedes-Maybach S 680</td>
                            <td>2</td>
                            <td class="text-success fw-bold">28.000.000.000 VNĐ</td>
                            <td>10/09/2026</td>
                            <td><span class="badge bg-success">Đã nhập kho</span></td>
                        </tr>
                        <tr>
                            <td class="font-monospace">PN002</td>
                            <td>Porsche Center Saigon</td>
                            <td>Porsche Taycan Turbo S</td>
                            <td>1</td>
                            <td class="text-success fw-bold">8.800.000.000 VNĐ</td>
                            <td>15/09/2026</td>
                            <td><span class="badge bg-success">Đã nhập kho</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: HÓA ĐƠN & CHIẾT KHẤU VIP -->
        <div class="tab-pane fade" id="invoices-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-white mb-0">Hóa Đơn Bán Xe & Ưu Đãi Thành Viên (HOADON)</h4>
                <div class="d-flex gap-2">
                    <a href="{{ url('/loyalty') }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-crown me-1"></i> Cổng Hội Viên PrimeLux</a>
                    <a href="{{ url('/invoices') }}" target="_blank" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> Cổng Tra Cứu Hóa Đơn</a>
                </div>
            </div>
            <div class="table-responsive rounded-4 border border-secondary">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th>Mã HĐ</th>
                            <th>Khách Hàng</th>
                            <th>Hạng Thành Viên</th>
                            <th>Mẫu Xe Mua</th>
                            <th>Giá Gốc</th>
                            <th>Chiết Khấu VIP</th>
                            <th>Thanh Toán</th>
                            <th>Điểm Nhận</th>
                            <th>Ngày Lập</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $inv)
                        <tr>
                            <td class="font-monospace fw-bold text-info">{{ $inv['code'] }}</td>
                            <td class="fw-bold">{{ $inv['customer_name'] }}<br><small class="text-secondary">{{ $inv['customer_phone'] }}</small></td>
                            <td><span class="badge bg-{{ $inv['customer_tier_badge'] ?? 'warning' }} text-dark">{{ $inv['customer_tier'] ?? 'Hội viên VIP' }}</span></td>
                            <td>{{ $inv['car_name'] }}</td>
                            <td class="text-secondary">{{ $inv['original_total'] ?? $inv['total_price'] }}</td>
                            <td class="text-danger fw-bold">-{{ $inv['tier_discount'] ?? '0 VNĐ' }}</td>
                            <td class="text-warning fw-bold">{{ $inv['total_price'] }}</td>
                            <td><span class="badge bg-primary">+{{ number_format($inv['points_earned'] ?? 0) }} pts</span></td>
                            <td class="small">{{ $inv['invoice_date'] }}</td>
                            <td><span class="badge bg-success">{{ $inv['status'] }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 4: KHÁCH HÀNG & ĐIỂM THƯỞNG VIP -->
        <div class="tab-pane fade" id="customers-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-white mb-0">Quản Lý Khách Hàng & Điểm Tích Lũy (KHACHHANG)</h4>
                    <p class="text-secondary small mb-0">Hệ thống tự động thăng hạng VIP và áp dụng chiết khấu khi đạt mốc điểm tương ứng.</p>
                </div>
                <a href="{{ url('/loyalty') }}" target="_blank" class="btn btn-outline-warning btn-sm">
                    <i class="fa-solid fa-eye me-1"></i> Xem Trang Hội Viên PrimeLux
                </a>
            </div>

            <div class="table-responsive rounded-4 border border-secondary">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th>Mã KH</th>
                            <th>Họ và Tên</th>
                            <th>Số Điện Thoại</th>
                            <th>Email</th>
                            <th>Hạng Thành Viên</th>
                            <th>Điểm Tích Lũy</th>
                            <th>Ưu Đãi Chiết Khấu</th>
                            <th>Tổng Chi Tiêu</th>
                            <th class="text-end">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $cust)
                        <tr id="cust-row-{{ $cust->ma_kh }}">
                            <td class="font-monospace fw-bold text-info">{{ $cust->ma_kh }}</td>
                            <td class="fw-bold">{{ $cust->ho_ten }}</td>
                            <td>{{ $cust->sdt }}</td>
                            <td class="text-secondary small">{{ $cust->email ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $cust->tier->mau_badge ?? 'secondary' }} text-dark" id="cust-tier-{{ $cust->ma_kh }}">
                                    {{ $cust->tier->ten_hang ?? 'Hạng Bạc' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-warning fs-6" id="cust-pts-{{ $cust->ma_kh }}">
                                    <i class="fa-solid fa-coins text-warning me-1"></i>{{ number_format($cust->diem_tich_luy) }} pts
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success" id="cust-disc-{{ $cust->ma_kh }}">
                                    -{{ $cust->tier->ti_le_chiet_khau ?? 0 }}% khi mua xe
                                </span>
                            </td>
                            <td class="fw-bold text-white">{{ number_format($cust->tong_chi_tieu ?? 0, 0, ',', '.') }} VNĐ</td>
                            <td class="text-end">
                                <button class="btn btn-outline-warning btn-sm" onclick="openAdjustModal('{{ $cust->ma_kh }}', '{{ $cust->ho_ten }}', {{ $cust->diem_tich_luy }})">
                                    <i class="fa-solid fa-sliders me-1"></i> Điều Chỉnh Điểm
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 5: HẠNG HỘI VIÊN & CƠ CHẾ ƯU ĐÃI -->
        <div class="tab-pane fade" id="tiers-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-white mb-0">Hạng Thành Viên & Chính Sách Ưu Đãi (HANGTHANHVIEN)</h4>
                    <p class="text-secondary small mb-0">Quy định mức chiết khấu và đặc quyền độc quyền cho khách hàng mua xe và gắn bó cùng PrimeLux Auto.</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                @foreach($tiers as $tier)
                <div class="col-md-6 col-xl-3">
                    <div class="p-4 rounded-4 bg-dark border border-secondary h-100 position-relative" style="background: linear-gradient(145deg, #161b26, #0e121a);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-{{ $tier->mau_badge ?? 'secondary' }} text-dark fs-6 fw-bold px-3 py-2">
                                <i class="fa-solid fa-gem me-1"></i> {{ $tier->ten_hang }}
                            </span>
                            <span class="font-monospace text-secondary small">{{ $tier->ma_hang }}</span>
                        </div>
                        <div class="mb-3">
                            <div class="text-secondary small">Điểm Yêu Cầu:</div>
                            <div class="fs-4 fw-bold text-warning">{{ number_format($tier->diem_toi_thieu) }} pts</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-secondary small">Chiết Khấu Mua Xe:</div>
                            <div class="fs-3 fw-bold text-success">-{{ $tier->ti_le_chiet_khau }}% <span class="fs-6 text-secondary">trực tiếp</span></div>
                        </div>
                        <hr class="border-secondary">
                        <div class="text-secondary small mb-1 fw-bold">Đặc quyền đi kèm:</div>
                        <p class="text-white small mb-0"><i class="fa-solid fa-check text-warning me-1"></i> {{ $tier->dac_quyen }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="p-4 rounded-4 bg-dark border border-secondary">
                <h5 class="fw-bold text-warning mb-3"><i class="fa-solid fa-circle-info me-2"></i> Nguyên Tắc Vận Hành Cơ Chế Điểm Thưởng (PrimePoints)</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 bg-secondary bg-opacity-10 border border-secondary h-100">
                            <div class="fw-bold text-white mb-1"><i class="fa-solid fa-arrow-trend-up text-success me-2"></i> Tích Lũy Điểm</div>
                            <p class="text-secondary small mb-0">Mỗi <strong>10.000.000 VNĐ</strong> chi tiêu mua xe tại PrimeLux, khách hàng tự động nhận ngay <strong>1 PrimePoint</strong> tích lũy trọn đời.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 bg-secondary bg-opacity-10 border border-secondary h-100">
                            <div class="fw-bold text-white mb-1"><i class="fa-solid fa-bolt text-warning me-2"></i> Nâng Hạng Tự Động</div>
                            <p class="text-secondary small mb-0">Hệ thống kiểm tra tổng điểm tích lũy và tức thời nâng hạng hội viên lên Bạc, Vàng, Bạch Kim hoặc Kim Cương tương ứng.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 bg-secondary bg-opacity-10 border border-secondary h-100">
                            <div class="fw-bold text-white mb-1"><i class="fa-solid fa-percent text-info me-2"></i> Giảm Trừ Ngay Lập Tức</div>
                            <p class="text-secondary small mb-0">Khi khách hàng đặt mua xe tiếp theo, tỉ lệ chiết khấu (1% - 3%) được trừ trực tiếp vào hóa đơn giá trị lăn bánh mà không cần thủ tục phức tạp.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 6: QUẢN LÝ LỊCH LÁI THỬ -->
        <div class="tab-pane fade" id="drives-panel">
            <h4 class="fw-bold text-white mb-3">Danh Sách Khách Hàng Đăng Ký Lái Thử (DANGKYLAITHU)</h4>
            <div class="table-responsive rounded-4 border border-secondary">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th>Mã Lịch</th>
                            <th>Khách Hàng</th>
                            <th>SĐT / Email</th>
                            <th>Xe Lái Thử</th>
                            <th>Showroom</th>
                            <th>Thời Gian</th>
                            <th>Trạng Thái</th>
                            <th class="text-end">Cập Nhật</th>
                        </tr>
                    </thead>
                    <tbody id="admin-drives-tbody"></tbody>
                </table>
            </div>
        </div>

        <!-- TAB 7: LỊCH SỬ CHATBOT & YÊU CẦU TƯ VẤN -->
        <div class="tab-pane fade" id="chats-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-white mb-0">Nhật Ký Chatbot AI & Yêu Cầu Tư Vấn Khách Hàng (CHATLOGS)</h4>
                    <p class="text-secondary small mb-0">Các câu hỏi riêng ngoài mẫu sẽ được chuyển trực tiếp đến Bàn Chuyên Viên Tư Vấn để giải đáp.</p>
                </div>
                <a href="{{ url('/consultant') }}" target="_blank" class="btn btn-warning text-dark fw-bold btn-sm">
                    <i class="fa-solid fa-headset me-1"></i> Mở Bàn Trực Chuyên Viên Tư Vấn
                </a>
            </div>
            <div class="table-responsive rounded-4 border border-secondary">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th>Mã Tin</th>
                            <th>Thời Gian</th>
                            <th>Khách Hàng / SĐT</th>
                            <th>Nội Dung Câu Hỏi</th>
                            <th>Trạng Thái</th>
                            <th>Phản Hồi Của Chuyên Viên</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chatLogs as $chat)
                        <tr>
                            <td class="font-monospace text-info fw-bold">{{ $chat->ma_tin }}</td>
                            <td class="small text-secondary">{{ $chat->thoi_gian }}</td>
                            <td>
                                <strong class="text-white">{{ $chat->nguoi_gui }}</strong>
                                @if($chat->sdt_khach)
                                    <br><small class="text-warning"><i class="fa-solid fa-phone me-1"></i>{{ $chat->sdt_khach }}</small>
                                @endif
                            </td>
                            <td style="max-width: 300px;">{{ $chat->noi_dung }}</td>
                            <td>
                                <span class="badge {{ $chat->trang_thai === 'Chờ phản hồi' ? 'bg-danger' : ($chat->trang_thai === 'Đang tư vấn' ? 'bg-primary' : 'bg-success') }}">
                                    {{ $chat->trang_thai }}
                                </span>
                            </td>
                            <td class="small" style="max-width: 320px;">
                                @if($chat->tra_loi_tu_van)
                                    <span class="text-success"><i class="fa-solid fa-check me-1"></i>{{ $chat->tra_loi_tu_van }}</span>
                                    <br><small class="text-secondary">Bởi: {{ $chat->ten_tu_van ?? 'Tư vấn viên' }}</small>
                                @else
                                    <span class="text-secondary italic">Chưa có phản hồi từ chuyên viên</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL ĐIỀU CHỈNH ĐIỂM THƯỞNG KHÁCH HÀNG -->
<div class="modal fade" id="adjustPointsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-warning">
                    <i class="fa-solid fa-coins me-2"></i> Điều Chỉnh Điểm Tích Lũy Hội Viên
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="adjustPointsForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Mã Khách Hàng</label>
                        <input type="text" id="adjCustCode" class="form-control bg-secondary bg-opacity-20 border-secondary text-white fw-bold" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Họ và Tên Khách Hàng</label>
                        <input type="text" id="adjCustName" class="form-control bg-secondary bg-opacity-20 border-secondary text-white" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Điểm Hiện Tại</label>
                        <input type="text" id="adjCurrentPoints" class="form-control bg-secondary bg-opacity-20 border-secondary text-warning fw-bold fs-5" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Số Điểm Cần Thay Đổi (* Nhập số âm nếu muốn trừ)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary border-secondary text-white">+/-</span>
                            <input type="number" id="adjPointsVal" class="form-control bg-secondary bg-opacity-10 border-secondary text-white fw-bold" required placeholder="Ví dụ: 1000 hoặc -500">
                        </div>
                        <small class="text-secondary">Ví dụ: Mua thêm xe tặng +1000 điểm; hoặc quy đổi quà tặng -500 điểm.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Lý Do Điều Chỉnh (*)</label>
                        <input type="text" id="adjReason" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" required placeholder="Thưởng sinh nhật VIP, hoàn tất giao dịch xe...">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy Bỏ</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark" id="btnSubmitAdjust">
                        <i class="fa-solid fa-check me-1"></i> Xác Nhận Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL THÊM XE MỚI -->
<div class="modal fade" id="addCarModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-plus-circle text-primary me-2"></i> Thêm Mẫu Xe Mới Vào Kho</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCarForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Tên Mẫu Xe (*)</label>
                            <input type="text" id="newCarName" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" required placeholder="Mercedes-Maybach S680">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Thương Hiệu (*)</label>
                            <select id="newCarBrand" class="form-select bg-secondary bg-opacity-10 border-secondary text-white" required>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="Porsche">Porsche</option>
                                <option value="BMW">BMW</option>
                                <option value="Audi">Audi</option>
                                <option value="Land Rover">Land Rover</option>
                                <option value="Lexus">Lexus</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Giá Niêm Yết (VNĐ) (*)</label>
                            <input type="number" id="newCarPrice" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" required placeholder="15990000000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Kiểu Dáng (*)</label>
                            <select id="newCarType" class="form-select bg-secondary bg-opacity-10 border-secondary text-white">
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Electric">Xe Điện (EV)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small">Nhiên Liệu (*)</label>
                            <input type="text" id="newCarFuel" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" placeholder="Xăng V12 / Điện">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small">Công Suất (*)</label>
                            <input type="text" id="newCarPower" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" placeholder="612 Mã lực">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small">Số Chỗ (*)</label>
                            <input type="text" id="newCarSeats" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" placeholder="4 Chỗ">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small">Link Hình Ảnh Xe (URL) (*)</label>
                            <input type="url" id="newCarImg" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" required placeholder="https://images.unsplash.com/...">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small">Mô Tả Nổi Bật</label>
                            <textarea id="newCarDesc" class="form-control bg-secondary bg-opacity-10 border-secondary text-white" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="fa-solid fa-save me-1"></i> Lưu Vào Kho</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Server-side loaded data
    const serverCars = @json($cars);
    const serverDrives = @json($testDrives);

    document.addEventListener("DOMContentLoaded", () => {
        initLocalStorage();
        loadAdminDashboard();

        // XỬ LÝ FORM THÊM XE MỚI
        document.getElementById("addCarForm").addEventListener("submit", (e) => {
            e.preventDefault();
            let cars = JSON.parse(localStorage.getItem("prime_cars")) || serverCars;
            
            const priceVal = parseFloat(document.getElementById("newCarPrice").value);
            const newCar = {
                id: "car-" + Date.now().toString().slice(-4),
                brand: document.getElementById("newCarBrand").value,
                name: document.getElementById("newCarName").value,
                price: priceVal,
                priceText: formatCurrency(priceVal),
                type: document.getElementById("newCarType").value,
                fuel: document.getElementById("newCarFuel").value || "Xăng",
                power: document.getElementById("newCarPower").value || "400 Mã lực",
                seats: document.getElementById("newCarSeats").value || "5 Chỗ",
                tag: "Mới Về",
                tagClass: "tag-new",
                image: document.getElementById("newCarImg").value,
                desc: document.getElementById("newCarDesc").value || "Dòng xe sang ấn tượng vừa cập bến Showroom."
            };

            cars.unshift(newCar);
            localStorage.setItem("prime_cars", JSON.stringify(cars));

            bootstrap.Modal.getInstance(document.getElementById("addCarModal")).hide();
            document.getElementById("addCarForm").reset();
            loadAdminDashboard();
        });

        // XỬ LÝ FORM ĐIỀU CHỈNH ĐIỂM THƯỞNG
        document.getElementById("adjustPointsForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            const btnSubmit = document.getElementById("btnSubmitAdjust");
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Đang cập nhật...';

            const maKh = document.getElementById("adjCustCode").value;
            const pointsVal = parseInt(document.getElementById("adjPointsVal").value);
            const reasonVal = document.getElementById("adjReason").value;

            try {
                const response = await fetch("{{ route('admin.customers.adjust-points') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        ma_kh: maKh,
                        so_diem: pointsVal,
                        ly_do: reasonVal
                    })
                });

                const res = await response.json();
                if (res.success) {
                    alert(`Đã cập nhật điểm thành công cho khách hàng ${maKh}! Số điểm mới: ${res.new_points.toLocaleString('vi-VN')} pts (${res.new_tier})`);
                    
                    // Update DOM
                    const ptsEl = document.getElementById(`cust-pts-${maKh}`);
                    if (ptsEl) ptsEl.innerHTML = `<i class="fa-solid fa-coins text-warning me-1"></i>${res.new_points.toLocaleString('vi-VN')} pts`;

                    const tierEl = document.getElementById(`cust-tier-${maKh}`);
                    if (tierEl) tierEl.textContent = res.new_tier;

                    bootstrap.Modal.getInstance(document.getElementById("adjustPointsModal")).hide();
                    document.getElementById("adjustPointsForm").reset();
                } else {
                    alert("Lỗi: " + (res.message || "Không thể điều chỉnh điểm."));
                }
            } catch (err) {
                console.error(err);
                alert("Đã xảy ra lỗi khi gửi yêu cầu.");
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> Xác Nhận Cập Nhật';
            }
        });
    });

    function openAdjustModal(maKh, hoTen, currentPoints) {
        document.getElementById("adjCustCode").value = maKh;
        document.getElementById("adjCustName").value = hoTen;
        document.getElementById("adjCurrentPoints").value = currentPoints.toLocaleString('vi-VN') + " pts";
        document.getElementById("adjPointsVal").value = "";
        document.getElementById("adjReason").value = "";

        const modal = new bootstrap.Modal(document.getElementById("adjustPointsModal"));
        modal.show();
    }

    function loadAdminDashboard() {
        const cars = JSON.parse(localStorage.getItem("prime_cars")) || serverCars;
        const localDrives = JSON.parse(localStorage.getItem("prime_test_drives")) || [];
        const drives = localDrives.length > 0 ? localDrives : serverDrives;
        const chats = JSON.parse(localStorage.getItem("prime_chat_logs")) || [];

        // Stats
        document.getElementById("stat-total-cars").textContent = cars.length;
        document.getElementById("stat-total-drives").textContent = drives.length;
        
        const totalVal = cars.reduce((acc, curr) => acc + (curr.price || 0), 0);
        document.getElementById("stat-total-val").textContent = formatCurrency(totalVal);

        // Render Table Cars
        const carTbody = document.getElementById("admin-cars-tbody");
        carTbody.innerHTML = cars.map(c => `
            <tr>
                <td><img src="${c.image}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;"></td>
                <td class="fw-bold">${c.name}</td>
                <td><span class="badge bg-secondary">${c.brand}</span></td>
                <td class="text-warning fw-bold">${c.priceText || formatCurrency(c.price)}</td>
                <td class="small text-secondary">${c.fuel || 'Xăng'} - ${c.power || '400 Mã lực'}</td>
                <td><span class="badge ${c.tagClass || 'tag-new'}">${c.tag || 'Mới Về'}</span></td>
                <td class="text-end">
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteCar('${c.id}')"><i class="fa-solid fa-trash"></i> Xóa</button>
                </td>
            </tr>
        `).join('');

        // Render Table Test Drives
        const driveTbody = document.getElementById("admin-drives-tbody");
        driveTbody.innerHTML = drives.map(d => `
            <tr>
                <td class="small font-monospace text-info fw-bold">${d.id}</td>
                <td class="fw-bold">${d.name}</td>
                <td class="small text-secondary">${d.phone}<br>${d.email || ''}</td>
                <td class="text-info font-weight-bold">${d.carName}</td>
                <td class="small">${d.location}</td>
                <td class="small">${d.date}</td>
                <td><span class="badge ${d.status === 'Đã xác nhận' ? 'bg-success' : 'bg-warning text-dark'}">${d.status}</span></td>
                <td class="text-end">
                    <button class="btn btn-outline-success btn-sm me-1" onclick="updateDriveStatus('${d.id}', 'Đã xác nhận')"><i class="fa-solid fa-check"></i> Duyệt</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteDrive('${d.id}')"><i class="fa-solid fa-xmark"></i> Hủy</button>
                </td>
            </tr>
        `).join('');

        // Render Table Chats
        const chatTbody = document.getElementById("admin-chats-tbody");
        chatTbody.innerHTML = chats.map(ch => `
            <tr>
                <td class="small font-monospace text-secondary">${ch.id}</td>
                <td class="small text-muted">${ch.time}</td>
                <td><span class="badge bg-primary">${ch.sender}</span></td>
                <td class="text-white">${ch.text}</td>
            </tr>
        `).join('');
    }

    function deleteCar(id) {
        if (confirm("Bạn có chắc chắn muốn xóa mẫu xe này khỏi kho?")) {
            let cars = JSON.parse(localStorage.getItem("prime_cars")) || serverCars;
            cars = cars.filter(c => c.id !== id);
            localStorage.setItem("prime_cars", JSON.stringify(cars));
            loadAdminDashboard();
        }
    }

    async function updateDriveStatus(id, newStatus) {
        let drives = JSON.parse(localStorage.getItem("prime_test_drives")) || serverDrives;
        const index = drives.findIndex(d => d.id === id);
        if (index !== -1) {
            drives[index].status = newStatus;
            localStorage.setItem("prime_test_drives", JSON.stringify(drives));
            loadAdminDashboard();
        }
        try {
            await fetch(`/admin/test-drives/${id}/status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ trang_thai: newStatus })
            });
        } catch(e) {}
    }

    async function deleteDrive(id) {
        if (confirm("Bạn có chắc muốn hủy lịch hẹn lái thử này?")) {
            let drives = JSON.parse(localStorage.getItem("prime_test_drives")) || serverDrives;
            drives = drives.filter(d => d.id !== id);
            localStorage.setItem("prime_test_drives", JSON.stringify(drives));
            loadAdminDashboard();
            try {
                await fetch(`/admin/test-drives/${id}/status`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ trang_thai: 'Đã hủy' })
                });
            } catch(e) {}
        }
    }
</script>
@endpush
