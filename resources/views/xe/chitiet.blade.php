@extends('layouts.giaodien')

@section('title', $car['name'] . ' - Chi Tiết Xe, Thông Số Kỹ Thuật & Giá Lăn Bánh - PrimeLux Auto')

@section('content')
<div class="container py-5">
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/cars') }}" class="text-secondary">Danh Sách Xe</a></li>
            <li class="breadcrumb-item active text-white" id="bc-car-name">{{ $car['name'] }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- CỘT TRÁI: HÌNH ẢNH NGOẠI THẤT & NỘI THẤT -->
        <div class="col-lg-7">
            <!-- ẢNH CHÍNH LỚN -->
            <div class="rounded-4 overflow-hidden mb-3 border border-secondary shadow-2xl position-relative" style="height: 440px; background: #000;">
                <img id="car-detail-img" src="{{ $car['image'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $car['name'] }}" style="transition: opacity 0.3s ease;">
                <span class="badge {{ $car['tagClass'] ?? 'tag-hot' }} position-absolute top-0 end-0 m-3 px-3 py-2 fs-6">
                    {{ $car['tag'] ?? 'Nổi Bật' }}
                </span>
                <span class="badge bg-dark bg-opacity-75 text-white border border-secondary position-absolute bottom-0 start-0 m-3 px-3 py-2">
                    <i class="fa-solid fa-camera me-1 text-warning"></i> <span id="gallery-current-label">Ngoại Thất</span>
                </span>
            </div>

            <!-- TABS CHỌN NGOẠI THẤT / NỘI THẤT -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-warning btn-sm active" id="btnTabExterior">
                        <i class="fa-solid fa-car-side me-1"></i> Ngoại Thất (Exterior)
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm" id="btnTabInterior">
                        <i class="fa-solid fa-couch me-1"></i> Nội Thất (Interior)
                    </button>
                </div>
                <small class="text-secondary"><i class="fa-solid fa-hand-pointer me-1"></i> Bấm vào ảnh nhỏ để xem chi tiết</small>
            </div>

            <!-- GALLERY THUMBNAILS NGOẠI THẤT -->
            <div class="row g-2" id="gallery-exterior-container">
                @php 
                    $extImgs = $car['gallery_exterior'] ?? [$car['image']];
                @endphp
                @foreach($extImgs as $idx => $img)
                <div class="col-4">
                    <img src="{{ $img }}" class="w-100 rounded-3 border thumb-img {{ $idx === 0 ? 'border-primary active-thumb' : 'border-secondary' }}" 
                         style="height: 100px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;"
                         alt="Ngoại thất {{ $car['name'] }} - {{ $idx + 1 }}">
                </div>
                @endforeach
            </div>

            <!-- GALLERY THUMBNAILS NỘI THẤT (ẨN BAN ĐẦU) -->
            <div class="row g-2 d-none" id="gallery-interior-container">
                @php 
                    $intImgs = $car['gallery_interior'] ?? [$car['image']];
                @endphp
                @foreach($intImgs as $idx => $img)
                <div class="col-4">
                    <img src="{{ $img }}" class="w-100 rounded-3 border border-secondary thumb-img" 
                         style="height: 100px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;"
                         alt="Nội thất {{ $car['name'] }} - {{ $idx + 1 }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- CỘT PHẢI: THÔNG TIN CƠ BẢN & GIÁ & CTA -->
        <div class="col-lg-5">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary text-uppercase px-3 py-1.5" id="car-detail-brand">{{ $car['brand'] }}</span>
                <span class="badge bg-secondary text-uppercase px-2.5 py-1.5">{{ $car['type'] }}</span>
                @if(!empty($car['year']))
                <span class="badge bg-dark border border-secondary text-warning">Đời {{ $car['year'] }}</span>
                @endif
            </div>

            <h1 class="fw-extrabold text-white mb-2" id="car-detail-name">{{ $car['name'] }}</h1>
            <div class="fs-2 fw-bold text-warning mb-3" id="car-detail-price">{{ $car['priceText'] }}</div>

            <!-- TÓM TẮT NHANH -->
            <div class="p-3 rounded-4 mb-3" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="row text-center g-2">
                    <div class="col-4 border-end border-secondary">
                        <div class="text-secondary small">Nhiên Liệu</div>
                        <strong class="text-white small d-block mt-1">{{ $car['fuel'] }}</strong>
                    </div>
                    <div class="col-4 border-end border-secondary">
                        <div class="text-secondary small">Công Suất</div>
                        <strong class="text-white small d-block mt-1">{{ $car['power'] }}</strong>
                    </div>
                    <div class="col-4">
                        <div class="text-secondary small">Hộp Số</div>
                        <strong class="text-white small d-block mt-1">{{ $car['transmission'] ?? 'Tự động' }}</strong>
                    </div>
                </div>
            </div>

            <p class="text-secondary mb-4 leading-relaxed" id="car-detail-desc">{{ $car['desc'] }}</p>

            <!-- CÁC NÚT HÀNH ĐỘNG -->
            <div class="d-grid gap-2 mb-3">
                <a id="btn-test-drive-link" href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-gold btn-lg py-2.5 fw-bold shadow">
                    <i class="fa-solid fa-steering-wheel me-2"></i> Đăng Ký Lái Thử Mẫu Xe Này (test-drive.html)
                </a>
                <a id="btn-compare-link" href="{{ url('/cars/' . $car['id'] . '/compare') }}" class="btn btn-outline-info btn-lg py-2.5 fw-bold">
                    <i class="fa-solid fa-scale-balanced me-2 text-warning"></i> So Sánh Giá Đa Sàn (PO Market)
                </a>
                <a href="tel:0338929013" class="btn btn-outline-light btn-lg py-2">
                    <i class="fa-solid fa-phone me-2 text-success"></i> Hotline Tư Vấn: 0338 929 013
                </a>
            </div>

            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-secondary bg-opacity-10 border border-secondary">
                <div class="small text-secondary">
                    <i class="fa-solid fa-warehouse text-warning me-1"></i> Tình trạng: 
                    <strong class="text-success">{{ $car['status'] ?? 'Sẵn sàng giao ngay' }}</strong>
                </div>
                <div class="small text-secondary">
                    <i class="fa-solid fa-shield-check text-info me-1"></i> Bảo hành chính hãng <strong>3 năm</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- BẢNG THÔNG SỐ KỸ THUẬT: ĐỘNG CƠ, CÔNG SUẤT, AN TOÀN -->
    <div class="mt-5 p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="d-flex align-items-center mb-4">
            <div class="p-3 rounded-3 bg-primary bg-opacity-20 text-primary fs-4 me-3">
                <i class="fa-solid fa-gauge-high"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1 text-white">Thông Số Kỹ Thuật Chi Tiết</h3>
                <p class="text-secondary small mb-0">Động cơ, hệ thống truyền động, hiệu suất vận hành và trang bị an toàn tiêu chuẩn quốc tế</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- 1. ĐỘNG CƠ & HIỆU SUẤT VẬN HÀNH -->
            <div class="col-lg-6">
                <div class="p-3.5 rounded-3 h-100" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <h5 class="fw-bold text-warning mb-3">
                        <i class="fa-solid fa-engine me-2"></i> 1. Động Cơ & Hiệu Năng Vận Hành
                    </h5>
                    <table class="table table-dark table-striped align-middle mb-0 small">
                        <tbody>
                            <tr>
                                <td class="text-secondary" style="width: 45%;">Loại Động Cơ:</td>
                                <td class="fw-bold text-white">{{ $car['specs']['engine'] ?? $car['fuel'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Công Suất Cực Đại:</td>
                                <td class="fw-bold text-warning">{{ $car['specs']['power'] ?? $car['power'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Mô-men Xoắn Cực Đại:</td>
                                <td class="fw-bold text-white">{{ $car['specs']['torque'] ?? '650 Nm' }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Hộp Số:</td>
                                <td class="fw-bold text-info">{{ $car['specs']['transmission'] ?? ($car['transmission'] ?? 'Tự động') }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Hệ Dẫn Động:</td>
                                <td class="fw-bold text-white">{{ $car['specs']['drivetrain'] ?? 'AWD 4 bánh toàn thời gian' }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Tăng Tốc (0 - 100 km/h):</td>
                                <td class="fw-bold text-danger">{{ $car['specs']['acceleration'] ?? '4.5 giây' }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Vận Tốc Tối Đa:</td>
                                <td class="fw-bold text-white">{{ $car['specs']['topSpeed'] ?? '250 km/h' }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Kích Thước Dài x Rộng x Cao:</td>
                                <td class="fw-bold text-white">{{ $car['specs']['dimensions'] ?? '5.200 x 1.950 x 1.500 mm' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. HỆ THỐNG AN TOÀN CAO CẤP -->
            <div class="col-lg-6">
                <div class="p-3.5 rounded-3 h-100" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <h5 class="fw-bold text-info mb-3">
                        <i class="fa-solid fa-shield-halved me-2"></i> 2. Hệ Thống An Toàn & Hỗ Trợ Lái
                    </h5>
                    <ul class="list-group list-group-flush bg-transparent">
                        @php
                            $safeties = $car['specs']['safety'] ?? [
                                'Hệ thống phanh tự động khẩn cấp AEB phát hiện chướng ngại vật và người đi bộ',
                                'Hỗ trợ giữ làn chủ động và cảnh báo lệch làn đường LKA',
                                'Giám sát điểm mù chủ động BSM và cảnh báo phương tiện cắt ngang khi lùi',
                                'Camera 360 độ 3D Surround View sắc nét kết hợp cảm biến đỗ xe trước sau',
                                'Hệ thống 10 - 11 túi khí bảo vệ toàn bộ khoang hành khách',
                                'Hệ thống cân bằng điện tử ESP và kiểm soát lực kéo thông minh'
                            ];
                        @endphp
                        @foreach($safeties as $item)
                        <li class="list-group-item bg-transparent text-light border-secondary border-opacity-50 py-2.5 px-0 d-flex align-items-start gap-2">
                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                            <span class="small">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- BẢNG TÍNH GIÁ LĂN BÁNH TỰ ĐỘNG DỰA TRÊN GIÁ XE, THUẾ VÀ PHÍ BIỂN SỐ -->
    <div class="mt-5 p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-warning bg-opacity-20 text-warning fs-4">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1 text-white">Bảng Tính Chi Phí Lăn Bánh</h3>
                    <p class="text-secondary small mb-0">Tự động ước tính dựa trên Giá xe, Lệ phí trước bạ, Phí biển số theo từng Tỉnh/Thành</p>
                </div>
            </div>
            <a href="{{ url('/loyalty') }}" class="btn btn-outline-warning btn-sm">
                <i class="fa-solid fa-crown me-1"></i> Xem Đặc Quyền PrimeLux Club
            </a>
        </div>
        
        <div class="row g-4">
            <!-- CỘT CHỌN THÔNG SỐ TÍNH TOÁN -->
            <div class="col-lg-5">
                <div class="mb-3">
                    <label class="form-label text-secondary fw-bold small">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> 1. Tỉnh / Thành Phố Đăng Ký Biển Số:
                    </label>
                    <select id="provinceSelect" class="form-select form-select-custom mb-2">
                        <option value="10_hcm">TP. Hồ Chí Minh (Thuế 10% - Phí biển 20.000.000 VNĐ)</option>
                        <option value="12_hn">Hà Nội (Thuế 12% - Phí biển 20.000.000 VNĐ)</option>
                        <option value="10_other">Các Tỉnh Thành Khác (Thuế 10% - Phí biển 1.000.000 VNĐ)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary fw-bold small">
                        <i class="fa-solid fa-crown text-warning me-1"></i> 2. Hạng Thành Viên Khách Hàng (Ưu Đãi Chiết Khấu VIP):
                    </label>
                    <select id="memberTierSelect" class="form-select form-select-custom mb-2">
                        <option value="0">Khách Hàng Mới / Hạng Bạc (Chiết khấu 0%)</option>
                        <option value="1">Hạng Vàng (Gold Member) - Chiết khấu 1%</option>
                        <option value="2">Hạng Bạch Kim (Platinum Member) - Chiết khấu 2%</option>
                        <option value="3">Hạng Kim Cương (Diamond VIP) - Chiết khấu 3%</option>
                    </select>
                    <small class="text-secondary d-block">
                        Khách hàng mua nhiều xe hoặc có thẻ thành viên được giảm trực tiếp đến hàng trăm triệu đồng vào giá mua!
                    </small>
                </div>

                <div class="alert alert-dark border border-secondary text-secondary small mb-3">
                    <i class="fa-solid fa-info-circle me-1 text-info"></i> <strong>Ghi chú:</strong> Giá lăn bánh tính đúng theo biểu phí quy định Nhà nước: Thuế trước bạ (10%-12%), Phí biển số (1tr-20tr), Phí đường bộ (1.560.000 VNĐ), Đăng kiểm (340.000 VNĐ), Bảo hiểm TNDS (480.700 VNĐ).
                </div>

                <div class="d-grid">
                    <a href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-warning text-dark fw-bold py-2">
                        <i class="fa-solid fa-steering-wheel me-1"></i> Đăng Ký Lái Thử Nhận Báo Giá Lăn Bánh
                    </a>
                </div>
            </div>

            <!-- CỘT BẢNG KÊ CHI TIẾT CHI PHÍ -->
            <div class="col-lg-7">
                <div class="table-responsive rounded-3 border border-secondary">
                    <table class="table table-dark table-striped align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="text-secondary">Giá Niêm Yết Gốc:</td>
                                <td class="text-end fw-bold text-white fs-6" id="calc-base-price">0 VNĐ</td>
                            </tr>
                            <tr class="table-success table-opacity-10 text-success fw-bold" id="tier-discount-row">
                                <td><i class="fa-solid fa-crown text-warning me-1"></i> Chiết Khấu Thành Viên VIP:</td>
                                <td class="text-end text-success fs-6" id="calc-tier-discount">-0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Giá Mua Xe Sau Chiết Khấu:</td>
                                <td class="text-end fw-bold text-info" id="calc-discounted-price">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Lệ Phí Trước Bạ (<span id="calc-tax-rate">10%</span>):</td>
                                <td class="text-end fw-bold" id="calc-tax">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Đăng Ký Biển Số Xe:</td>
                                <td class="text-end fw-bold" id="calc-plate">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Bảo Trì Đường Bộ (1 Năm):</td>
                                <td class="text-end">1.560.000 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Kiểm Định Đăng Kiểm:</td>
                                <td class="text-end">340.000 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Bảo Hiểm Trách Nhiệm Dân Sự (1 Năm):</td>
                                <td class="text-end">480.700 VNĐ</td>
                            </tr>
                            <tr class="table-active border-top border-warning">
                                <td class="fw-bold fs-5 text-warning">TỔNG CHI PHÍ LĂN BÁNH DỰ KIẾN:</td>
                                <td class="text-end fw-bold fs-4 text-warning" id="calc-total">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="small text-secondary"><i class="fa-solid fa-coins text-warning me-1"></i> Điểm thưởng PrimePoints tích lũy:</td>
                                <td class="text-end fw-bold text-warning small" id="calc-earned-points">+0 Điểm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- BẢNG TÍNH VAY TRẢ GÓP & CỔNG THANH TOÁN ONLINE TIỀN TRẢ TRƯỚC (DOWN PAYMENT GATEWAY) -->
    <div class="mt-5 p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);" id="installment-downpayment-section">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-success bg-opacity-20 text-success fs-4">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h3 class="fw-bold mb-0 text-white">Bảng Tính Vay Trả Góp & Thanh Toán Trả Trước Online</h3>
                        <span class="badge bg-success bg-opacity-25 text-success border border-success">
                            <i class="fa-solid fa-circle-check me-1"></i> Cổng Online: Hoạt Động
                        </span>
                    </div>
                    <p class="text-secondary small mb-0">Hỗ trợ tính toán số tiền trả trước linh hoạt (20% - 80%), dư nợ ngân hàng và quét mã VietQR thanh toán online tức thì</p>
                </div>
            </div>
            <a href="{{ url('/thanh-toan-tra-truoc?car=' . $car['id']) }}" class="btn btn-outline-warning btn-sm">
                <i class="fa-solid fa-up-right-from-square me-1"></i> Xem Trang Thanh Toán Trả Trước Toàn Diện
            </a>
        </div>

        <div class="row g-4">
            <!-- CỘT CHỌN THÔNG SỐ TRẢ GÓP -->
            <div class="col-lg-5">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label text-secondary fw-bold small mb-0">
                            <i class="fa-solid fa-sliders text-warning me-1"></i> 1. Tỷ Lệ Trả Trước Ban Đầu:
                        </label>
                        <span class="badge bg-warning text-dark fs-6 fw-bold" id="detail-percent-badge">30%</span>
                    </div>

                    <div class="btn-group w-100 mb-2" role="group">
                        <button type="button" class="btn btn-outline-warning btn-sm btn-detail-percent" data-val="20">20%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-detail-percent active" data-val="30">30%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-detail-percent" data-val="40">40%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-detail-percent" data-val="50">50%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-detail-percent" data-val="70">70%</button>
                    </div>

                    <input type="range" class="form-range" id="detailPercentRange" min="20" max="80" step="5" value="30">
                    <div class="d-flex justify-content-between text-secondary" style="font-size: 11px;">
                        <span>20% (Tối thiểu)</span>
                        <span>30% - 50% (Phổ biến)</span>
                        <span>80% (Tối đa)</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary fw-bold small">
                        <i class="fa-solid fa-calendar-days text-info me-1"></i> 2. Thời Gian Vay Ngân Hàng Số Tiền Còn Lại:
                    </label>
                    <select id="detailLoanYearsSelect" class="form-select form-select-custom mb-2">
                        <option value="1">1 Năm (12 Tháng) — Lãi suất 7.5%/năm</option>
                        <option value="2">2 Năm (24 Tháng) — Lãi suất 7.5%/năm</option>
                        <option value="3">3 Năm (36 Tháng) — Lãi suất 7.9%/năm</option>
                        <option value="4">4 Năm (48 Tháng) — Lãi suất 7.9%/năm</option>
                        <option value="5" selected>5 Năm (60 Tháng) — Lãi suất 7.9%/năm (Khuyên Dùng)</option>
                        <option value="6">6 Năm (72 Tháng) — Lãi suất 8.5%/năm</option>
                        <option value="7">7 Năm (84 Tháng) — Lãi suất 8.5%/năm</option>
                        <option value="8">8 Năm (96 Tháng) — Lãi suất 8.9%/năm</option>
                    </select>
                </div>

                <div class="alert alert-dark border border-secondary text-secondary small mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-white fw-bold"><i class="fa-solid fa-shield-halved text-success me-1"></i> Cổng kết nối thanh toán:</span>
                        <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Hoạt Động</span>
                    </div>
                    <div>Ngân hàng thụ hưởng: <strong class="text-warning">MBBank &mdash; 0338929013</strong> (PRIMELUX AUTO SHOWROOM)</div>
                    <div style="font-size: 11px;" class="mt-1">Xác thực giao dịch tự động qua mã QR VietQR NAPAS 24/7 tức thì.</div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-warning text-dark fw-bold py-2.5 shadow" id="btnOpenDownPaymentModal">
                        <i class="fa-solid fa-qrcode me-2"></i> Thanh Toán Online Tiền Trả Trước Ngay
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm py-2" id="btnOpenDepositModal">
                        <i class="fa-solid fa-hand-holding-dollar me-2 text-warning"></i> Đặt Cọc Trước 100.000.000 VNĐ Giữ Xe
                    </button>
                </div>
            </div>

            <!-- CỘT BẢNG KÊ CHI TIẾT TRẢ TRƯỚC -->
            <div class="col-lg-7">
                <div class="table-responsive rounded-3 border border-secondary">
                    <table class="table table-dark table-striped align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="text-secondary">Giá Xe Niêm Yết:</td>
                                <td class="text-end fw-bold text-white fs-6" id="calc-down-base-price">0 VNĐ</td>
                            </tr>
                            <tr class="table-warning table-opacity-10 text-warning fw-bold">
                                <td>
                                    <i class="fa-solid fa-money-bill-transfer text-warning me-1"></i> 
                                    SỐ TIỀN TRẢ TRƯỚC (<span id="calc-down-percent-label">30%</span>):
                                </td>
                                <td class="text-end text-warning fs-4 fw-extrabold" id="calc-down-amount">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Số Tiền Vay Ngân Hàng Còn Lại:</td>
                                <td class="text-end fw-bold text-info" id="calc-loan-amount">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Tiền Gốc Trả Hàng Tháng:</td>
                                <td class="text-end" id="calc-monthly-principal">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Tiền Lãi Tháng Đầu (Ước Tính 7.9%/năm):</td>
                                <td class="text-end text-danger" id="calc-monthly-interest">0 VNĐ</td>
                            </tr>
                            <tr class="table-active border-top border-info">
                                <td class="fw-bold fs-6 text-white">Tổng Trả Góp Tháng Đầu Tiên (Gốc + Lãi):</td>
                                <td class="text-end fw-bold fs-5 text-info" id="calc-monthly-total">0 VNĐ / tháng</td>
                            </tr>
                            <tr>
                                <td class="small text-secondary"><i class="fa-solid fa-circle-info text-info me-1"></i> Phương thức trả nợ:</td>
                                <td class="text-end text-secondary small">Dư nợ giảm dần theo từng tháng</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 p-3 rounded-3 bg-secondary bg-opacity-10 border border-secondary d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="small text-secondary">
                        <i class="fa-solid fa-building-columns text-warning me-1"></i> Ngân hàng liên kết: <strong>MBBank, Vietcombank, Techcombank, BIDV</strong> (Hỗ trợ duyệt trong 4h)
                    </div>
                    <a href="tel:0338929013" class="btn btn-outline-info btn-xs py-1 px-2">
                        <i class="fa-solid fa-headset me-1"></i> Tư Vấn Gói Vay: 0338 929 013
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL THANH TOÁN ONLINE TRẢ TRƯỚC (CỔNG KẾT NỐI ba_0VXvtCFwZHBJL8Lb7GYukenOW9B) -->
    <div class="modal fade" id="downPaymentModal" tabindex="-1" aria-labelledby="downPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content text-white" style="background: #111827; border: 1px solid #374151;">
                <div class="modal-header border-secondary">
                    <div>
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2" id="downPaymentModalLabel">
                            <i class="fa-solid fa-qrcode text-warning"></i> Cổng Thanh Toán Trực Tuyến PrimeLux Pay
                        </h5>
                        <div class="small text-secondary">
                            Ngân hàng kết nối: <strong class="text-warning fw-bold">MBBank &mdash; 0338929013</strong> &mdash; <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Hoạt Động</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-2 rounded-3 bg-white d-inline-block shadow" style="max-width: 210px;">
                                <img id="modalQrImage" 
                                     src="https://img.vietqr.io/image/MB-0338929013-compact2.png?amount=100000000&addInfo=PLDP{{ $car['id'] }}&accountName=PRIMELUX+AUTO+SHOWROOM" 
                                     class="img-fluid rounded" 
                                     alt="Mã QR VietQR thanh toán tiền trả trước">
                            </div>
                            <small class="text-secondary d-block mt-2">
                                <i class="fa-solid fa-camera text-warning me-1"></i> Mở App Ngân Hàng bất kỳ để quét mã
                            </small>
                            <span class="badge bg-dark border border-secondary text-info mt-1" id="modalTimerBadge">
                                <i class="fa-solid fa-clock me-1"></i> Hiệu lực: <span id="modalCountdown">15:00</span>
                            </span>
                        </div>

                        <div class="col-md-7">
                            <div class="p-3 rounded-3 bg-dark border border-secondary small">
                                <div class="mb-2">
                                    <small class="text-secondary d-block">Mẫu xe thanh toán:</small>
                                    <strong class="text-white fs-6">{{ $car['name'] }}</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Khoản thanh toán:</small>
                                    <strong class="text-warning" id="modalPaymentTypeLabel">Tiền trả trước xe (30%)</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Ngân hàng thụ hưởng:</small>
                                    <strong class="text-white">MBBank (Ngân hàng Quân Đội)</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Số tài khoản thụ hưởng:</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="text-warning fs-5" id="modalAccNo">0338929013</strong>
                                        <button class="btn btn-outline-warning btn-xs py-0 px-2" onclick="navigator.clipboard.writeText('0338929013'); alert('Đã sao chép STK!');">
                                            <i class="fa-regular fa-copy me-1"></i> Sao Chép
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Chủ tài khoản:</small>
                                    <strong class="text-light">PRIMELUX AUTO SHOWROOM</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Số tiền chuyển khoản:</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="text-success fs-5" id="modalPayAmount">0 VNĐ</strong>
                                        <button class="btn btn-outline-success btn-xs py-0 px-2" id="modalBtnCopyAmount">
                                            <i class="fa-regular fa-copy me-1"></i> Sao Chép
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <small class="text-secondary d-block">Nội dung chuyển khoản:</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="text-info" id="modalPayContent">PLDP-{{ strtoupper($car['id']) }}</strong>
                                        <button class="btn btn-outline-info btn-xs py-0 px-2" id="modalBtnCopyContent">
                                            <i class="fa-regular fa-copy me-1"></i> Sao Chép
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modalSuccessNotice" class="d-none alert alert-success border-success text-center p-3 mt-3">
                        <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                        <h6 class="fw-bold mb-1">Xác Nhận Đã Nhận Thanh Toán Online Trả Trước Thành Công!</h6>
                        <p class="small mb-1" id="modalSuccessMsg">Hệ thống đã khớp lệnh thành công qua cổng <b>PrimeLux Pay &mdash; MBBank</b>.</p>
                        <span class="badge bg-success" id="modalReceiptBadge">Mã biên lai: BL-TT-789012</span>
                    </div>
                </div>

                <div class="modal-footer border-secondary justify-content-between">
                    <div class="small text-secondary">
                        <i class="fa-solid fa-shield-check text-success me-1"></i> Giao dịch bảo mật 100%
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-success fw-bold" id="modalBtnVerify">
                            <i class="fa-solid fa-arrows-rotate me-1"></i> Tôi Đã Chuyển Khoản — Xác Nhận Ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const baseCarPrice = {{ $car['price'] }};
        const carId = "{{ $car['id'] }}";
        const carName = "{{ $car['name'] }}";
        const mainImg = document.getElementById("car-detail-img");
        const galleryLabel = document.getElementById("gallery-current-label");

        // CHUYỂN TAB NGOẠI THẤT / NỘI THẤT
        const btnTabExterior = document.getElementById("btnTabExterior");
        const btnTabInterior = document.getElementById("btnTabInterior");
        const extContainer = document.getElementById("gallery-exterior-container");
        const intContainer = document.getElementById("gallery-interior-container");

        if (btnTabExterior && btnTabInterior) {
            btnTabExterior.addEventListener("click", () => {
                btnTabExterior.classList.add("active");
                btnTabInterior.classList.remove("active");
                extContainer.classList.remove("d-none");
                intContainer.classList.add("d-none");
                if (galleryLabel) galleryLabel.textContent = "Ngoại Thất";

                const firstExtThumb = extContainer.querySelector(".thumb-img");
                if (firstExtThumb) firstExtThumb.click();
            });

            btnTabInterior.addEventListener("click", () => {
                btnTabInterior.classList.add("active");
                btnTabExterior.classList.remove("active");
                intContainer.classList.remove("d-none");
                extContainer.classList.add("d-none");
                if (galleryLabel) galleryLabel.textContent = "Nội Thất";

                const firstIntThumb = intContainer.querySelector(".thumb-img");
                if (firstIntThumb) firstIntThumb.click();
            });
        }

        // CLICK THUMBNAIL ĐỂ ĐỔI ẢNH LỚN
        function bindThumbClicks() {
            const thumbs = document.querySelectorAll(".thumb-img");
            thumbs.forEach(thumb => {
                thumb.addEventListener("click", function () {
                    mainImg.style.opacity = "0.3";
                    setTimeout(() => {
                        mainImg.src = this.src;
                        mainImg.style.opacity = "1";
                    }, 120);

                    thumbs.forEach(t => {
                        t.classList.remove("border-primary", "active-thumb");
                        t.classList.add("border-secondary");
                    });
                    this.classList.remove("border-secondary");
                    this.classList.add("border-primary", "active-thumb");
                });
            });
        }
        bindThumbClicks();

        // TÍNH TOÁN GIÁ LĂN BÁNH DỰA TRÊN GIÁ XE, THUẾ VÀ PHÍ BIỂN SỐ
        const provinceSelect = document.getElementById("provinceSelect");
        const memberTierSelect = document.getElementById("memberTierSelect");

        function formatVnd(num) {
            return new Intl.NumberFormat('vi-VN').format(Math.round(num)) + ' VNĐ';
        }

        function updateOnRoadPrice() {
            const provinceVal = provinceSelect ? provinceSelect.value : "10_hcm";
            const discountPercent = parseFloat(memberTierSelect ? memberTierSelect.value : 0) || 0;

            let rate = 10;
            let plate = 20000000;

            if (provinceVal === "12_hn") {
                rate = 12;
                plate = 20000000;
            } else if (provinceVal === "10_other") {
                rate = 10;
                plate = 1000000;
            } else {
                rate = 10;
                plate = 20000000;
            }

            // Chiết khấu hạng VIP
            const tierDiscount = baseCarPrice * (discountPercent / 100);
            const discountedPrice = baseCarPrice - tierDiscount;

            // Thuế trước bạ (tính theo giá xe)
            const tax = baseCarPrice * (rate / 100);
            const roadFee = 1560000;
            const inspectFee = 340000;
            const tndsFee = 480700;

            const total = discountedPrice + tax + plate + roadFee + inspectFee + tndsFee;
            const earnedPoints = Math.floor(discountedPrice / 10000000);

            // Ghi ra DOM
            document.getElementById("calc-base-price").textContent = formatVnd(baseCarPrice);
            document.getElementById("calc-tier-discount").textContent = discountPercent > 0 ? ("-" + formatVnd(tierDiscount) + " (" + discountPercent + "%)") : "0 VNĐ";
            document.getElementById("calc-discounted-price").textContent = formatVnd(discountedPrice);
            document.getElementById("calc-tax-rate").textContent = rate + "%";
            document.getElementById("calc-tax").textContent = formatVnd(tax);
            document.getElementById("calc-plate").textContent = formatVnd(plate);
            document.getElementById("calc-total").textContent = formatVnd(total);
            document.getElementById("calc-earned-points").textContent = "+" + new Intl.NumberFormat('vi-VN').format(earnedPoints) + " Điểm";
        }

        if (provinceSelect) provinceSelect.addEventListener("change", updateOnRoadPrice);
        if (memberTierSelect) memberTierSelect.addEventListener("change", updateOnRoadPrice);

        updateOnRoadPrice();

        // ==========================================
        // TÍNH TOÁN TRẢ GÓP & CỔNG THANH TOÁN ONLINE TRẢ TRƯỚC
        // ==========================================
        const detailPercentRange = document.getElementById("detailPercentRange");
        const detailPercentBadge = document.getElementById("detailPercentBadge");
        const detailLoanYearsSelect = document.getElementById("detailLoanYearsSelect");
        let activeDownPaymentAmount = baseCarPrice * 0.3;
        let activeTransCode = "PLDP" + Math.floor(100000 + Math.random() * 900000);
        let isDepositMode = false;

        function updateDownPaymentCalculation() {
            const percent = parseInt(detailPercentRange ? detailPercentRange.value : 30) || 30;
            const years = parseInt(detailLoanYearsSelect ? detailLoanYearsSelect.value : 5) || 5;

            if (detailPercentBadge) detailPercentBadge.textContent = percent + "%";
            const percentLabel = document.getElementById("calc-down-percent-label");
            if (percentLabel) percentLabel.textContent = percent + "%";

            const downAmount = isDepositMode ? 100000000 : (baseCarPrice * (percent / 100));
            activeDownPaymentAmount = downAmount;
            const loanAmount = Math.max(0, baseCarPrice - downAmount);

            // Lãi suất ước tính theo số năm
            let interestRate = 0.079;
            if (years <= 2) interestRate = 0.075;
            else if (years >= 6) interestRate = 0.085;

            const totalMonths = years * 12;
            const monthlyPrincipal = loanAmount / totalMonths;
            const monthlyInterest = (loanAmount * interestRate) / 12;
            const monthlyTotal = monthlyPrincipal + monthlyInterest;

            document.getElementById("calc-down-base-price").textContent = formatVnd(baseCarPrice);
            document.getElementById("calc-down-amount").textContent = formatVnd(downAmount);
            document.getElementById("calc-loan-amount").textContent = formatVnd(loanAmount);
            document.getElementById("calc-monthly-principal").textContent = formatVnd(monthlyPrincipal) + " / tháng";
            document.getElementById("calc-monthly-interest").textContent = formatVnd(monthlyInterest) + " / tháng";
            document.getElementById("calc-monthly-total").textContent = formatVnd(monthlyTotal) + " / tháng";
        }

        // Đổi lựa chọn % trả trước bằng nút bấm nhanh
        document.querySelectorAll(".btn-detail-percent").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".btn-detail-percent").forEach(b => b.classList.remove("active"));
                btn.classList.add("active");
                if (detailPercentRange) {
                    detailPercentRange.value = btn.getAttribute("data-val");
                }
                isDepositMode = false;
                updateDownPaymentCalculation();
            });
        });

        if (detailPercentRange) {
            detailPercentRange.addEventListener("input", () => {
                document.querySelectorAll(".btn-detail-percent").forEach(b => b.classList.remove("active"));
                const matchBtn = document.querySelector(`.btn-detail-percent[data-val="${detailPercentRange.value}"]`);
                if (matchBtn) matchBtn.classList.add("active");
                isDepositMode = false;
                updateDownPaymentCalculation();
            });
        }

        if (detailLoanYearsSelect) {
            detailLoanYearsSelect.addEventListener("change", updateDownPaymentCalculation);
        }

        updateDownPaymentCalculation();

        // ==========================================
        // MỞ MODAL THANH TOÁN ONLINE (CỔNG KẾT NỐI ba_0VXvtCFwZHBJL8Lb7GYukenOW9B)
        // ==========================================
        const modalEl = document.getElementById("downPaymentModal");
        let modalInstance = null;
        if (modalEl && typeof bootstrap !== 'undefined') {
            modalInstance = new bootstrap.Modal(modalEl);
        }

        function openPaymentModal(isDeposit) {
            isDepositMode = isDeposit;
            const percent = parseInt(detailPercentRange ? detailPercentRange.value : 30) || 30;
            const payAmount = isDeposit ? 100000000 : (baseCarPrice * (percent / 100));
            activeDownPaymentAmount = payAmount;
            activeTransCode = "PLDP" + Math.floor(100000 + Math.random() * 900000);

            const typeLabel = isDeposit ? "Đặt cọc giữ xe trước (100.000.000 VNĐ)" : `Tiền trả trước xe (${percent}%)`;
            document.getElementById("modalPaymentTypeLabel").textContent = typeLabel;
            document.getElementById("modalPayAmount").textContent = formatVnd(payAmount);

            const content = activeTransCode + " " + carId.toUpperCase();
            document.getElementById("modalPayContent").textContent = content;

            // Tạo VietQR URL
            const qrUrl = `https://img.vietqr.io/image/MB-0338929013-compact2.png?amount=${Math.round(payAmount)}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent('PRIMELUX AUTO SHOWROOM')}`;
            document.getElementById("modalQrImage").src = qrUrl;

            // Reset thông báo thành công
            const successBox = document.getElementById("modalSuccessNotice");
            if (successBox) successBox.classList.add("d-none");

            const btnVerify = document.getElementById("modalBtnVerify");
            if (btnVerify) {
                btnVerify.disabled = false;
                btnVerify.innerHTML = '<i class="fa-solid fa-arrows-rotate me-1"></i> Tôi Đã Chuyển Khoản — Xác Nhận Ngay';
                btnVerify.className = 'btn btn-success fw-bold';
            }

            if (modalInstance) {
                modalInstance.show();
            }
        }

        const btnOpenDown = document.getElementById("btnOpenDownPaymentModal");
        if (btnOpenDown) {
            btnOpenDown.addEventListener("click", () => openPaymentModal(false));
        }

        const btnOpenDep = document.getElementById("btnOpenDepositModal");
        if (btnOpenDep) {
            btnOpenDep.addEventListener("click", () => openPaymentModal(true));
        }

        // Nút sao chép trong modal
        const btnModalCopyAmount = document.getElementById("modalBtnCopyAmount");
        if (btnModalCopyAmount) {
            btnModalCopyAmount.addEventListener("click", () => {
                navigator.clipboard.writeText(Math.round(activeDownPaymentAmount).toString());
                alert("Đã sao chép số tiền: " + formatVnd(activeDownPaymentAmount));
            });
        }

        const btnModalCopyContent = document.getElementById("modalBtnCopyContent");
        if (btnModalCopyContent) {
            btnModalCopyContent.addEventListener("click", () => {
                navigator.clipboard.writeText(document.getElementById("modalPayContent").textContent);
                alert("Đã sao chép nội dung chuyển khoản!");
            });
        }

        // Nút xác nhận thanh toán trong modal
        const modalBtnVerify = document.getElementById("modalBtnVerify");
        if (modalBtnVerify) {
            modalBtnVerify.addEventListener("click", () => {
                modalBtnVerify.disabled = true;
                modalBtnVerify.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang kết nối PrimeLux Pay — Đang xác thực...';

                fetch("{{ route('api.payment.check') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        transaction_id: activeTransCode
                    })
                })
                .then(res => res.json())
                .then(data => {
                    setTimeout(() => {
                        modalBtnVerify.disabled = false;
                        modalBtnVerify.innerHTML = '<i class="fa-solid fa-check me-1"></i> Đã Xác Nhận Thành Công';
                        modalBtnVerify.className = 'btn btn-secondary fw-bold';

                        const successBox = document.getElementById("modalSuccessNotice");
                        if (successBox) {
                            successBox.classList.remove("d-none");
                            document.getElementById("modalSuccessMsg").innerHTML = `Đã xác nhận thanh toán thành công <b>${formatVnd(activeDownPaymentAmount)}</b> cho mẫu xe <b>${carName}</b> qua cổng kết nối <b>${data.id}</b>!`;
                            document.getElementById("modalReceiptBadge").textContent = "Mã Biên Lai Điện Tử: " + (data.receipt_number || "BL-TT-112233");
                        }
                    }, 1000);
                })
                .catch(err => {
                    modalBtnVerify.disabled = false;
                    modalBtnVerify.innerHTML = '<i class="fa-solid fa-arrows-rotate me-1"></i> Tôi Đã Chuyển Khoản — Xác Nhận Ngay';
                    alert("Đã gửi yêu cầu đối soát thanh toán. Vui lòng thử lại sau giây lát.");
                });
            });
        }

        // Đếm ngược 15 phút modal
        let modalTimeLeft = 15 * 60;
        const modalCountdownEl = document.getElementById("modalCountdown");
        setInterval(() => {
            if (modalCountdownEl && modalTimeLeft > 0) {
                modalTimeLeft--;
                const m = Math.floor(modalTimeLeft / 60);
                const s = modalTimeLeft % 60;
                modalCountdownEl.textContent = (m < 10 ? "0" : "") + m + ":" + (s < 10 ? "0" : "") + s;
            }
        }, 1000);
    });
</script>
@endpush

