@extends('layouts.client')

@section('title', $car['name'] . ' - Chi Tiết Xe & Bảng Giá Lăn Bánh - PrimeLux Auto')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/cars') }}" class="text-secondary">Danh Sách Xe</a></li>
            <li class="breadcrumb-item active text-white" id="bc-car-name">{{ $car['name'] }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- HÌNH ẢNH XE & GALLERY -->
        <div class="col-lg-7">
            <div class="rounded-4 overflow-hidden mb-3 border border-secondary shadow-lg" style="height: 420px; transition: all 0.3s ease;">
                <img id="car-detail-img" src="{{ $car['image'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $car['name'] }}" style="transition: opacity 0.3s ease;">
            </div>

            <!-- GALLERY THUMBNAILS -->
            <div class="row g-2" id="gallery-container">
                <div class="col-4">
                    <img id="thumb-0" src="{{ $car['image'] }}" class="w-100 rounded-3 border border-primary thumb-img active-thumb" style="height: 95px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;">
                </div>
                <div class="col-4">
                    <img id="thumb-1" src="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=600&auto=format&fit=crop" class="w-100 rounded-3 border border-secondary thumb-img" style="height: 95px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;">
                </div>
                <div class="col-4">
                    <img id="thumb-2" src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=600&auto=format&fit=crop" class="w-100 rounded-3 border border-secondary thumb-img" style="height: 95px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;">
                </div>
            </div>
        </div>

        <!-- THÔNG TIN & GIÁ XE -->
        <div class="col-lg-5">
            <span class="badge bg-primary text-uppercase px-3 py-2 mb-2" id="car-detail-brand">{{ $car['brand'] }}</span>
            <h1 class="fw-bold mb-3" id="car-detail-name">{{ $car['name'] }}</h1>
            <div class="fs-2 fw-bold text-warning mb-4" id="car-detail-price">{{ $car['priceText'] }}</div>

            <div class="p-3 rounded-3 mb-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="row text-center g-2">
                    <div class="col-4 border-end border-secondary">
                        <div class="text-secondary small">Nhiên Liệu</div>
                        <strong id="car-detail-fuel" class="small">{{ $car['fuel'] }}</strong>
                    </div>
                    <div class="col-4 border-end border-secondary">
                        <div class="text-secondary small">Công Suất</div>
                        <strong id="car-detail-power" class="small">{{ $car['power'] }}</strong>
                    </div>
                    <div class="col-4">
                        <div class="text-secondary small">Số Chỗ</div>
                        <strong id="car-detail-seats" class="small">{{ $car['seats'] }}</strong>
                    </div>
                </div>
            </div>

            <p class="text-secondary mb-4" id="car-detail-desc">{{ $car['desc'] }}</p>

            <div class="d-grid gap-2">
                <a id="btn-compare-link" href="{{ url('/cars/' . $car['id'] . '/compare') }}" class="btn btn-outline-info btn-lg py-2.5 fw-bold">
                    <i class="fa-solid fa-scale-balanced me-2 text-warning"></i> So Sánh Giá Đa Sàn (PO Comparison)
                </a>
                <a id="btn-test-drive-link" href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-gold btn-lg py-2.5">
                    <i class="fa-solid fa-steering-wheel me-2"></i> Đăng Ký Lái Thử Mẫu Xe Này
                </a>
                <a href="tel:0338929013" class="btn btn-outline-light btn-lg py-2">
                    <i class="fa-solid fa-phone me-2"></i> Gọi Hotline Tư Vấn: 0338 929 013
                </a>
            </div>
        </div>
    </div>

    <!-- BẢNG TÍNH GIÁ LĂN BÁNH TỰ ĐỘNG & ƯU ĐÃI ĐIỂM THƯỞNG -->
    <div class="mt-5 p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <h3 class="fw-bold mb-0"><i class="fa-solid fa-calculator text-warning me-2"></i> Bảng Ước Tính Chi Phí Lăn Bánh</h3>
            <a href="{{ url('/loyalty') }}" class="btn btn-outline-warning btn-sm">
                <i class="fa-solid fa-crown me-1"></i> Xem Đặc Quyền PrimeLux Club
            </a>
        </div>
        
        <div class="row g-4">
            <div class="col-md-5">
                <div class="mb-3">
                    <label class="form-label text-secondary fw-bold small">1. Chọn Tỉnh / Thành Phố Đăng Ký Biển Số:</label>
                    <select id="provinceSelect" class="form-select form-select-custom mb-2">
                        <option value="10">TP. Hồ Chí Minh (Thuế 10% - Phí biển 20tr)</option>
                        <option value="12">Hà Nội (Thuế 12% - Phí biển 20tr)</option>
                        <option value="10_other">Các Tỉnh Thành Khác (Thuế 10% - Phí biển 1tr)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary fw-bold small"><i class="fa-solid fa-crown text-warning me-1"></i> 2. Hạng Thành Viên Khách Hàng (Ưu Đãi Chiết Khấu):</label>
                    <select id="memberTierSelect" class="form-select form-select-custom mb-2">
                        <option value="0">Khách Hàng Mới / Hạng Bạc (Chiết khấu 0%)</option>
                        <option value="1">Hạng Vàng (Gold Member) - Chiết khấu 1%</option>
                        <option value="2">Hạng Bạch Kim (Platinum Member) - Chiết khấu 2%</option>
                        <option value="3">Hạng Kim Cương (Diamond VIP) - Chiết khấu 3%</option>
                    </select>
                    <small class="text-secondary d-block">
                        Khách hàng mua nhiều xe hoặc có điểm thưởng cao được giảm trực tiếp đến hàng trăm triệu đồng!
                    </small>
                </div>

                <div class="alert alert-dark border border-secondary text-secondary small mb-0">
                    <i class="fa-solid fa-info-circle me-1 text-info"></i> Giá lăn bánh ước tính đã bao gồm Thuế trước bạ, Phí đăng ký biển số, Phí đường bộ, Bảo hiểm TNDS 1 năm và đã khấu trừ ưu đãi thành viên.
                </div>
            </div>

            <div class="col-md-7">
                <div class="table-responsive">
                    <table class="table table-dark table-striped align-middle">
                        <tbody>
                            <tr>
                                <td>Giá Niêm Yết Gốc:</td>
                                <td class="text-end fw-bold" id="calc-base-price">0 VNĐ</td>
                            </tr>
                            <tr class="table-success table-opacity-10 text-success fw-bold" id="tier-discount-row">
                                <td><i class="fa-solid fa-crown text-warning me-1"></i> Chiết Khấu Thành Viên VIP:</td>
                                <td class="text-end text-success fs-6" id="calc-tier-discount">-0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Giá Sau Chiết Khấu:</td>
                                <td class="text-end fw-bold text-info" id="calc-discounted-price">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Lệ Phí Trước Bạ:</td>
                                <td class="text-end" id="calc-tax">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Đăng Ký Biển Số:</td>
                                <td class="text-end" id="calc-plate">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Bảo Trì Đường Bộ (1 Năm):</td>
                                <td class="text-end">1,560,000 VNĐ</td>
                            </tr>
                            <tr>
                                <td>Phí Bảo Hiểm TNDS (1 Năm):</td>
                                <td class="text-end">480,700 VNĐ</td>
                            </tr>
                            <tr class="table-active border-top border-warning">
                                <td class="fw-bold fs-5 text-warning">TỔNG CHI PHÍ LĂN BÁNH:</td>
                                <td class="text-end fw-bold fs-4 text-warning" id="calc-total">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="small text-secondary"><i class="fa-solid fa-coins text-warning me-1"></i> Điểm thưởng PrimePoints nhận được:</td>
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

        // Click thumbnail to switch main photo
        const thumbs = document.querySelectorAll(".thumb-img");
        thumbs.forEach(thumb => {
            thumb.addEventListener("click", function () {
                mainImg.style.opacity = "0.3";
                setTimeout(() => {
                    mainImg.src = this.src;
                    mainImg.style.opacity = "1";
                }, 150);

                thumbs.forEach(t => {
                    t.classList.remove("border-primary", "active-thumb");
                    t.classList.add("border-secondary");
                });
                this.classList.remove("border-secondary");
                this.classList.add("border-primary", "active-thumb");
            });
        });

        // On-road price calculator with loyalty discounts
        const provinceSelect = document.getElementById("provinceSelect");
        const memberTierSelect = document.getElementById("memberTierSelect");
        
        function updateOnRoadPrice() {
            const provinceVal = provinceSelect.value;
            const discountPercent = parseFloat(memberTierSelect.value) || 0;

            let rate = 10;
            let isOther = false;

            if (provinceVal === "12") rate = 12;
            if (provinceVal === "10_other") isOther = true;

            // Tính chiết khấu hạng thành viên
            const tierDiscount = baseCarPrice * (discountPercent / 100);
            const discountedPrice = baseCarPrice - tierDiscount;

            // Thuế tính theo giá sau chiết khấu hoặc giá niêm yết
            const tax = baseCarPrice * (rate / 100);
            const plate = isOther ? 1000000 : 20000000;
            const road = 1560000;
            const ins = 480700;
            const total = discountedPrice + tax + plate + road + ins;

            // Điểm thưởng nhận được: mỗi 10 triệu = 1 điểm
            const earnedPoints = Math.floor(discountedPrice / 10000000);

            document.getElementById("calc-base-price").textContent = formatCurrency(baseCarPrice);
            document.getElementById("calc-tier-discount").textContent = discountPercent > 0 ? ("-" + formatCurrency(tierDiscount) + " (" + discountPercent + "%)") : "0 VNĐ";
            document.getElementById("calc-discounted-price").textContent = formatCurrency(discountedPrice);
            document.getElementById("calc-tax").textContent = formatCurrency(tax);
            document.getElementById("calc-plate").textContent = formatCurrency(plate);
            document.getElementById("calc-total").textContent = formatCurrency(total);
            document.getElementById("calc-earned-points").textContent = "+" + new Intl.NumberFormat('vi-VN').format(earnedPoints) + " Điểm";
        }

        if (provinceSelect) provinceSelect.addEventListener("change", updateOnRoadPrice);
        if (memberTierSelect) memberTierSelect.addEventListener("change", updateOnRoadPrice);

        updateOnRoadPrice();
    });
</script>
@endpush
