@extends('layouts.client')

@section('title', 'PrimeLux Club - Đặc Quyền & Điểm Thưởng Khách Hàng VIP')

@section('content')
<!-- HERO SECTION -->
<div class="py-5 bg-dark text-center border-bottom border-secondary" style="background: radial-gradient(circle at 50% 30%, rgba(245, 158, 11, 0.12) 0%, rgba(11, 15, 25, 0.95) 75%);">
    <div class="container py-4">
        <span class="section-tag"><i class="fa-solid fa-crown text-warning me-1"></i> PrimeLux Club Membership</span>
        <h1 class="fw-bold display-4 mb-3 text-white">Chương Trình Khách Hàng Thân Thiết</h1>
        <p class="text-secondary max-w-700 mx-auto fs-5">
            Mua xe càng nhiều, đặc quyền càng lớn. Tích lũy điểm thưởng PrimePoints trên mỗi giao dịch để nhận chiết khấu trực tiếp lên đến <span class="text-warning fw-bold">3% giá trị xe</span> cùng gói dịch vụ hậu mãi 5 sao trọn đời.
        </p>
    </div>
</div>

<div class="container py-5">

    <!-- KHU VỰC TRA CỨU ĐIỂM THƯỞNG & THẺ THÀNH VIÊN -->
    <div class="row g-4 mb-5 align-items-center">
        <div class="col-lg-5">
            <div class="p-4 p-md-5 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                <h4 class="fw-bold mb-2 text-white"><i class="fa-solid fa-magnifying-glass text-warning me-2"></i> Tra Cứu Điểm & Hạng VIP</h4>
                <p class="text-secondary small mb-4">Nhập Số điện thoại hoặc Mã hội viên để kiểm tra điểm thưởng và ưu đãi sẵn có.</p>

                <form method="GET" action="{{ url('/loyalty') }}" class="mb-3">
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="phone" class="form-control form-control-custom" placeholder="Ví dụ: 0901234567..." value="{{ $query }}" required>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-3 fw-bold">
                        <i class="fa-solid fa-bolt me-2"></i> Tra Cứu Ngay
                    </button>
                </form>

                <div class="p-3 rounded-3 bg-secondary bg-opacity-10 text-secondary small">
                    <i class="fa-solid fa-circle-info text-info me-1"></i> <b>Số điện thoại mẫu để tra cứu thử:</b><br>
                    • <code>0901234567</code> (Diamond VIP: 12.500 điểm - Giảm 3%)<br>
                    • <code>0912987654</code> (Gold: 2.800 điểm - Giảm 1%)<br>
                    • <code>0933892901</code> (Platinum: 6.200 điểm - Giảm 2%)
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            @if($customer)
            <!-- THẺ THÀNH VIÊN ĐIỆN TỬ HIỂN THỊ KHI TÌM THẤY -->
            <div class="p-4 p-md-5 rounded-4 position-relative overflow-hidden text-white" 
                 style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 2px solid {{ $customer->ma_hang === 'DIAMOND' ? '#f59e0b' : ($customer->ma_hang === 'PLATINUM' ? '#06b6d4' : '#eab308') }}; box-shadow: 0 15px 35px rgba(0,0,0,0.6);">
                
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <span class="badge bg-{{ $customer->tier->mau_badge ?? 'warning' }} text-uppercase px-3 py-2 fs-6 mb-2">
                            <i class="fa-solid fa-crown me-1"></i> {{ $customer->tier->ten_hang ?? 'Hội Viên PrimeLux' }}
                        </span>
                        <h2 class="fw-bold mb-0 text-white">{{ $customer->ho_ten }}</h2>
                        <small class="text-secondary">Mã Hội Viên: <b>{{ $customer->ma_kh }}</b> | SĐT: <b>{{ $customer->sdt }}</b></small>
                    </div>
                    <div class="text-end">
                        <img src="{{ asset('image/Logo.png') }}" alt="Logo" style="height: 40px;" onerror="this.style.display='none'">
                        <div class="small fw-bold text-warning mt-1">PRIMELUX CLUB</div>
                    </div>
                </div>

                <div class="row g-3 py-3 my-2 border-top border-bottom border-secondary">
                    <div class="col-4 text-center border-end border-secondary">
                        <span class="text-secondary small d-block">Điểm Tích Lũy</span>
                        <span class="fs-2 fw-bold text-warning">{{ number_format($customer->diem_tich_luy) }}</span>
                        <small class="text-secondary d-block">PrimePoints</small>
                    </div>
                    <div class="col-4 text-center border-end border-secondary">
                        <span class="text-secondary small d-block">Ưu Đãi Giá Xe</span>
                        <span class="fs-2 fw-bold text-success">-{{ $customer->tier->ti_le_chiet_khau ?? 0 }}%</span>
                        <small class="text-secondary d-block">Chiết khấu trực tiếp</small>
                    </div>
                    <div class="col-4 text-center">
                        <span class="text-secondary small d-block">Tổng Chi Tiêu</span>
                        <span class="fs-4 fw-bold text-info">{{ number_format($customer->tong_chi_tieu / 1000000000, 1) }} Tỷ</span>
                        <small class="text-secondary d-block">VNĐ mua hàng</small>
                    </div>
                </div>

                <!-- PROGRESS BAR LÊN HẠNG TIẾP THEO -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-secondary">Tiến trình thăng hạng</span>
                        @if($nextTier)
                        <span class="text-warning">Cần thêm <b>{{ number_format($pointsToNextTier) }} điểm</b> để lên <b>{{ $nextTier->ten_hang }}</b></span>
                        @else
                        <span class="text-success"><i class="fa-solid fa-check-double me-1"></i> Bạn đã đạt Hạng Cao Nhất (Diamond VIP)</span>
                        @endif
                    </div>
                    <div class="progress bg-dark" style="height: 10px; border-radius: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progressPercent }}%;"></div>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded-3 bg-secondary bg-opacity-10 small">
                    <b class="text-warning"><i class="fa-solid fa-gift me-1"></i> Đặc quyền của bạn:</b> 
                    {{ $customer->tier->dac_quyen ?? 'Tích lũy điểm khi mua xe và bảo dưỡng.' }}
                </div>
            </div>
            @else
            <!-- BANNER GIỚI THIỆU KHI CHƯA TRA CỨU -->
            <div class="p-4 p-md-5 rounded-4 h-100 d-flex flex-column justify-content-center text-center text-white" 
                 style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <i class="fa-solid fa-gem text-warning fa-4x mb-3"></i>
                <h3 class="fw-bold mb-2">Đặc Quyền Dành Riêng Cho Bạn</h3>
                <p class="text-secondary max-w-500 mx-auto mb-4">
                    Mỗi lần mua xe hoặc sử dụng dịch vụ tại PrimeLux Auto, quý khách sẽ được tích lũy điểm thưởng để thăng hạng và hưởng chiết khấu giảm giá trực tiếp từ hàng chục đến hàng trăm triệu đồng.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url('/cars') }}" class="btn btn-accent px-4 py-2.5">
                        <i class="fa-solid fa-car me-2"></i> Khám Phá Mẫu Xe
                    </a>
                    <a href="{{ url('/test-drive') }}" class="btn btn-outline-light px-4 py-2.5">
                        <i class="fa-solid fa-steering-wheel me-2"></i> Đăng Ký Lái Thử
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- BẢNG LỊCH SỬ TÍCH ĐIỂM (NẾU CÓ KHÁCH HÀNG) -->
    @if($customer && count($pointsHistory) > 0)
    <div class="p-4 rounded-4 mb-5" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <h4 class="fw-bold text-white mb-3"><i class="fa-solid fa-clock-rotate-left text-info me-2"></i> Lịch Sử Tích & Đổi Điểm Gần Đây</h4>
        <div class="table-responsive rounded-3 border border-secondary">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="table-active">
                        <th>Thời Gian</th>
                        <th>Nội Dung Hoạt Động</th>
                        <th>Mã Hóa Đơn</th>
                        <th class="text-end">Số Điểm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pointsHistory as $hist)
                    <tr>
                        <td class="small text-secondary">{{ date('d/m/Y H:i', strtotime($hist->ngay_tao)) }}</td>
                        <td>{{ $hist->hanh_dong }}</td>
                        <td class="font-monospace text-info">{{ $hist->ma_hd ?? '-' }}</td>
                        <td class="text-end fw-bold {{ $hist->so_diem > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $hist->so_diem > 0 ? '+' : '' }}{{ number_format($hist->so_diem) }} Điểm
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- 4 HẠNG THÀNH VIÊN & MỨC ƯU ĐÃI (TIERS CARDS) -->
    <div class="text-center mb-5">
        <span class="section-tag">Thang Đo Quyền Lợi</span>
        <h2 class="section-title text-white">4 Hạng Hội Viên PrimeLux Club</h2>
        <p class="text-secondary max-w-600 mx-auto">Càng mua nhiều xe, chiết khấu và đặc quyền của quý khách càng nâng cao</p>
    </div>

    <div class="row g-4">
        @foreach($tiers as $tier)
        <div class="col-xl-3 col-md-6">
            <div class="p-4 rounded-4 h-100 d-flex flex-column justify-content-between position-relative" 
                 style="background: var(--bg-card); border: 1px solid {{ $tier->ma_hang === 'DIAMOND' ? '#f59e0b' : 'var(--border-color)' }}; box-shadow: var(--card-shadow);">
                
                @if($tier->ma_hang === 'DIAMOND')
                <div class="position-absolute top-0 end-0 bg-warning text-dark px-3 py-1 fw-bold small rounded-bottom-start">
                    VIP CAO CẤP NHẤT
                </div>
                @endif

                <div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="p-3 rounded-circle bg-{{ $tier->mau_badge }} bg-opacity-20 text-{{ $tier->mau_badge }} fs-3">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white">{{ $tier->ten_hang }}</h5>
                            <small class="text-secondary">Từ {{ number_format($tier->diem_toi_thieu) }} Điểm</small>
                        </div>
                    </div>

                    <div class="my-3 py-3 border-top border-bottom border-secondary text-center">
                        <span class="text-secondary small d-block">Mức Giảm Giá Xe</span>
                        <span class="display-6 fw-bold text-{{ $tier->mau_badge }}">
                            {{ $tier->ti_le_chiet_khau > 0 ? '-' . $tier->ti_le_chiet_khau . '%' : 'Tích 1% điểm' }}
                        </span>
                        <small class="text-secondary d-block mt-1">
                            {{ $tier->ti_le_chiet_khau > 0 ? 'Trừ trực tiếp vào hóa đơn' : 'Cộng điểm đổi quà' }}
                        </small>
                    </div>

                    <h6 class="fw-bold text-white small mb-2"><i class="fa-solid fa-star text-warning me-1"></i> Đặc Quyền Hạng:</h6>
                    <p class="text-secondary small mb-4" style="line-height: 1.7;">
                        {{ $tier->dac_quyen }}
                    </p>
                </div>

                <div>
                    <a href="{{ url('/cars') }}" class="btn btn-outline-{{ $tier->mau_badge }} w-100 py-2 btn-sm fw-bold">
                        Xem Xe Áp Dụng
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- CƠ CHẾ TÍCH ĐIỂM -->
    <div class="mt-5 p-4 p-md-5 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);">
        <h4 class="fw-bold text-white mb-4 text-center"><i class="fa-solid fa-circle-question text-info me-2"></i> Cơ Chế Tích Điểm & Thăng Hạng Hoạt Động Như Thế Nào?</h4>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-3">
                    <div class="fs-1 fw-bold text-warning mb-2">1. Mua Xe & Dịch Vụ</div>
                    <p class="text-secondary small">Mỗi 10.000.000 VNĐ thanh toán mua xe hoặc bảo dưỡng, quý khách nhận được <b>1 Điểm thưởng PrimePoints</b>.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div class="fs-1 fw-bold text-info mb-2">2. Tự Động Thăng Hạng</div>
                    <p class="text-secondary small">Khi tổng điểm đạt mốc (1.000 - 5.000 - 10.000 điểm), hệ thống tự động nâng hạng VIP trọn đời cho quý khách.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div class="fs-1 fw-bold text-success mb-2">3. Hưởng Chiết Khấu</div>
                    <p class="text-secondary small">Mức giảm từ <b>1% đến 3%</b> được áp dụng ngay khi tính giá lăn bánh và xuất hóa đơn cho các lần mua tiếp theo.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
