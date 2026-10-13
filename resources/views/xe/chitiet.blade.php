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
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const baseCarPrice = {{ $car['price'] }};
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
    });
</script>
@endpush
