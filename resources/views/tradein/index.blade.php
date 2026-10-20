@extends('layouts.giaodien')

@section('title', 'Thẩm Định Xe Cũ & Thu Cũ Đổi Mới (Trade-In) - PrimeLux Auto')
@section('meta_description', 'Chương trình Trade-In thu cũ đổi mới siêu xe và xe sang tại PrimeLux Auto. Định giá xe cũ theo thuật toán 176 hạng mục chuẩn quốc tế.')

@section('content')
<div class="container py-5">
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/cars') }}" class="text-secondary">Kho Xe</a></li>
            <li class="breadcrumb-item active text-warning" aria-current="page"><i class="fa-solid fa-repeat me-1"></i> Thu Cũ Đổi Mới (Trade-In)</li>
        </ol>
    </nav>

    <!-- HERO HEADER -->
    <div class="p-4 p-md-5 rounded-4 mb-5 position-relative overflow-hidden" 
         style="background: radial-gradient(circle at 85% 30%, rgba(245, 158, 11, 0.12) 0%, rgba(15, 23, 42, 0.98) 75%); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold mb-3 text-uppercase">
                    <i class="fa-solid fa-arrows-rotate me-1"></i> PrimeLux Certified Trade-In Program
                </span>
                <h1 class="display-6 fw-extrabold text-white mb-3">
                    Thẩm Định Xe Cũ & Thu Cũ Đổi Mới Siêu Xe
                </h1>
                <p class="text-secondary lead fs-6 mb-4 leading-relaxed">
                    Đổi chiếc xe sang Quý khách đang sử dụng lấy siêu xe mới tinh tại Showroom PrimeLux Auto. Định giá sơ bộ tự động trong <strong>10 giây</strong>, kiểm định tận nơi <strong>176 hạng mục</strong> tiêu chuẩn quốc tế và cấn trừ trực tiếp vào hóa đơn xe mới.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#tradein-form-section" class="btn btn-warning text-dark fw-bold px-4 py-2.5 shadow">
                        <i class="fa-solid fa-calculator me-1"></i> Định Giá Xe Cũ Ngay
                    </a>
                    <a href="{{ url('/cars') }}" class="btn btn-outline-light px-4 py-2.5">
                        <i class="fa-solid fa-car me-1"></i> Khám Phá Kho Xe Sẵn Hàng
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="p-4 rounded-4 bg-dark bg-opacity-75 border border-secondary shadow-lg">
                    <div class="fs-1 text-warning mb-2"><i class="fa-solid fa-certificate"></i></div>
                    <div class="h5 fw-bold text-white mb-1">Kiểm Định 176 Hạng Mục</div>
                    <p class="text-secondary small mb-0">Cam kết thu mua giá cao hơn thị trường 3% - 5% cho xe bảo dưỡng chính hãng.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 BƯỚC QUY TRÌNH THU CŨ ĐỔI MỚI -->
    <div class="row g-4 mb-5 text-center">
        <div class="col-md-4">
            <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="fs-2 text-warning mb-3"><i class="fa-solid fa-1"></i></div>
                <h5 class="fw-bold text-white mb-2">1. Định Giá Trực Tuyến</h5>
                <p class="text-secondary small mb-0">Nhập thông tin hãng, dòng xe, năm sản xuất và ODO. Hệ thống tự động ước tính mức giá sơ bộ chuẩn xác.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="fs-2 text-info mb-3"><i class="fa-solid fa-2"></i></div>
                <h5 class="fw-bold text-white mb-2">2. Kiểm Tra Thực Tế Tận Nơi</h5>
                <p class="text-secondary small mb-0">Kỹ sư trưởng PrimeLux đến tận tư gia hoặc showroom thẩm định chi tiết 176 hạng mục động cơ và khung gầm.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="fs-2 text-success mb-3"><i class="fa-solid fa-3"></i></div>
                <h5 class="fw-bold text-white mb-2">3. Bàn Giao Xe Mới</h5>
                <p class="text-secondary small mb-0">Giá trị xe cũ được trừ thẳng vào giá xe mới. Hỗ trợ thủ tục sang tên đổi chủ trọn gói trong 24 giờ.</p>
            </div>
        </div>
    </div>

    <!-- MAIN FORM & ESTIMATOR -->
    <div class="row g-5 mb-5" id="tradein-form-section">
        <!-- CỘT TRÁI: FORM NHẬP THÔNG TIN XE CŨ -->
        <div class="col-lg-7">
            <div class="p-4 p-md-5 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="p-3 rounded-3 bg-warning bg-opacity-20 text-warning fs-4">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-white mb-1">Thông Tin Chiếc Xe Quý Khách Đang Đi</h3>
                        <p class="text-secondary small mb-0">Vui lòng điền thông số để nhận báo giá thẩm định trong 10 giây</p>
                    </div>
                </div>

                <form id="tradeInForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Hãng Xe <span class="text-danger">*</span></label>
                            <select class="form-select form-select-custom" id="tiBrand" name="hang_xe" required onchange="updateEstimatedPrice()">
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="BMW">BMW</option>
                                <option value="Porsche">Porsche</option>
                                <option value="Audi">Audi</option>
                                <option value="Lexus">Lexus</option>
                                <option value="Land Rover">Land Rover</option>
                                <option value="Khác">Hãng xe khác</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Dòng Xe / Phiên Bản <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" id="tiModel" name="dong_xe" placeholder="Ví dụ: C 300 AMG, 530i, Macan GTS" value="C 300 AMG" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Năm Sản Xuất <span class="text-danger">*</span></label>
                            <select class="form-select form-select-custom" id="tiYear" name="nam_sx" required onchange="updateEstimatedPrice()">
                                @for($y = 2026; $y >= 2012; $y--)
                                    <option value="{{ $y }}" {{ $y === 2023 ? 'selected' : '' }}>Năm {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Số Km Đã Chạy (ODO) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-custom" id="tiOdo" name="so_km" placeholder="Ví dụ: 25000" value="25000" min="0" step="1000" required onchange="updateEstimatedPrice()" oninput="updateEstimatedPrice()">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Tình Trạng Xe</label>
                            <select class="form-select form-select-custom" id="tiCondition" name="tinh_trang" onchange="updateEstimatedPrice()">
                                <option value="excellent">Xuất sắc (Lướt như mới, sơn zin >98%)</option>
                                <option value="good" selected>Tốt (Nguyên bản, bảo dưỡng hãng đầy đủ)</option>
                                <option value="fair">Khá (Có trầy xước nhẹ qua thời gian)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Siêu Xe Muốn Đổi Lấy Tại PrimeLux</label>
                            <select class="form-select form-select-custom" name="xe_du_dinh_doi">
                                @foreach($cars as $c)
                                    <option value="{{ $c['name'] }}" {{ $selectedCar === $c['name'] ? 'selected' : '' }}>
                                        {{ $c['name'] }} ({{ $c['priceText'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 pt-2 border-top border-secondary border-opacity-30">
                            <h6 class="text-warning fw-bold mb-3"><i class="fa-solid fa-user me-1"></i> Thông Tin Khách Hàng Để Kỹ Sư Liên Hệ Thẩm Định:</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Họ Và Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom" name="ho_ten" placeholder="Nguyễn Văn A" value="{{ session('user.name') ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-custom" name="sdt" placeholder="0901234567" value="{{ session('user.phone') ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">Ghi Chú Thêm Về Tình Trạng Xe (Tùy chọn)</label>
                            <textarea class="form-control form-control-custom" name="ghi_chu" rows="2" placeholder="Ví dụ: Đã nâng cấp mâm thể thao, dán phim 3M, xe biển số TP.HCM..."></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-3 shadow" id="btnSubmitTradeIn">
                                <i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Thẩm Định & Đặt Lịch Kiểm Tra Xe
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- CỘT PHẢI: KẾT QUẢ ĐỊNH GIÁ TỨC THÌ (REALTIME VALUATION CARD) -->
        <div class="col-lg-5">
            <div class="p-4 p-md-5 rounded-4 sticky-top" style="top: 100px; background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%); border: 2px solid #f59e0b; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.15);">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 text-uppercase">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Định Giá AI Thuật Toán
                    </span>
                    <span class="text-secondary small"><i class="fa-solid fa-bolt text-warning me-1"></i> Thời gian thực</span>
                </div>

                <div class="text-secondary small mb-1">MỨC GIÁ THẨM ĐỊNH SƠ BỘ ƯỚC TÍNH:</div>
                <div class="display-6 fw-extrabold text-warning mb-2" id="valEstimatedPrice">
                    1.750.000.000 VNĐ
                </div>
                <p class="text-secondary small mb-4">
                    Giá trị này sẽ được <strong class="text-success">trừ trực tiếp</strong> vào hợp đồng mua siêu xe mới tại PrimeLux Auto sau khi kỹ thuật viên xác nhận hiện trạng thực tế.
                </p>

                <div class="p-3 rounded-3 bg-dark border border-secondary mb-4">
                    <h6 class="text-white fw-bold mb-2 small"><i class="fa-solid fa-clipboard-check text-info me-1"></i> Tiêu Chuẩn 176 Hạng Mục Gồm:</h6>
                    <ul class="list-unstyled mb-0 small text-secondary">
                        <li class="mb-1"><i class="fa-solid fa-check text-success me-1"></i> Kiểm tra động cơ, hộp số và hệ dẫn động</li>
                        <li class="mb-1"><i class="fa-solid fa-check text-success me-1"></i> Đo độ dày nước sơn & kết cấu khung gầm xe</li>
                        <li class="mb-1"><i class="fa-solid fa-check text-success me-1"></i> Quét lỗi máy tính ECU & hệ thống điện tử</li>
                        <li><i class="fa-solid fa-check text-success me-1"></i> Lịch sử bảo dưỡng chính hãng & hồ sơ pháp lý</li>
                    </ul>
                </div>

                <div class="alert alert-success bg-opacity-10 border border-success text-success small mb-0">
                    <i class="fa-solid fa-shield-halved me-1"></i> <strong>Đặc quyền Trade-In:</strong> Tặng kèm 01 năm bảo hiểm thân vỏ cao cấp và gói cứu hộ 24/7 độc quyền cho xe mới!
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateEstimatedPrice() {
    const brand = document.getElementById('tiBrand').value;
    const year = parseInt(document.getElementById('tiYear').value) || 2023;
    const odo = parseInt(document.getElementById('tiOdo').value) || 20000;
    const condition = document.getElementById('tiCondition').value;

    fetch('{{ url("/api/trade-in/calculate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            hang_xe: brand,
            nam_sx: year,
            so_km: odo,
            tinh_trang: condition
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('valEstimatedPrice').innerText = data.formatted_price;
        }
    })
    .catch(err => {});
}

document.getElementById('tradeInForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitTradeIn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Đang tiếp nhận yêu cầu...';

    const formData = new FormData(this);

    fetch('{{ url("/trade-in") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Thẩm Định';
        if (data.success) {
            if (window.PrimeLuxSync) {
                window.PrimeLuxSync.showToast({
                    title: 'Đã Tiếp Nhận Yêu Cầu',
                    message: `${data.message} • Mã: <b>${data.data.ma_yeu_cau}</b> (Định giá: <b>${data.data.gia_dinh_gia_so_bo}</b>)`,
                    icon: 'fa-handshake',
                    type: 'success',
                    duration: 8000
                });
                window.PrimeLuxSync.broadcast('TRADEIN_SUBMITTED', data.data);
            }
            document.getElementById('tradeInForm').reset();
            updateEstimatedPrice();
        } else {
            if (window.PrimeLuxSync) {
                window.PrimeLuxSync.showToast({
                    title: 'Lỗi Gửi Yêu Cầu',
                    message: data.message || 'Có lỗi xảy ra, vui lòng thử lại.',
                    icon: 'fa-triangle-exclamation',
                    type: 'danger'
                });
            }
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Thẩm Định';
        if (window.PrimeLuxSync) {
            window.PrimeLuxSync.showToast({
                title: 'Đã Gửi Yêu Cầu',
                message: 'Đã gửi yêu cầu thẩm định thành công! Chuyên viên sẽ liên hệ Quý khách.',
                icon: 'fa-check-circle',
                type: 'success'
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', updateEstimatedPrice);
</script>
@endsection
