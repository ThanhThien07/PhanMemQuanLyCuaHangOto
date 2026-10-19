@extends('layouts.giaodien')

@section('title', 'Danh Sách Xe Hạng Sang - PrimeLux Auto')
@section('meta_description', 'Khám phá danh sách các mẫu xe hạng sang, siêu xe thể thao và xe điện EV nhập khẩu chính hãng: Mercedes-Maybach, Porsche, BMW, Audi, Lexus tại PrimeLux Auto.')

@section('content')
<!-- HEADER TITLE -->
<div class="py-5 bg-dark text-center border-bottom border-secondary">
    <div class="container">
        <span class="section-tag"><i class="fa-solid fa-car-side text-warning me-1"></i> Showroom Trực Tuyến</span>
        <h1 class="fw-bold display-5 mb-2 text-white">Danh Sách Mẫu Xe Cao Cấp</h1>
        <p class="text-secondary max-w-600 mx-auto">Bộ sưu tập xe sang, xe thể thao và siêu xe sẵn sàng bàn giao ngay tại các Showroom PrimeLux Auto.</p>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container py-5">
    <div class="row">
        <!-- SIDEBAR FILTER (BỘ LỌC ĐẦY ĐỦ: HÃNG, NHIÊN LIỆU, HỘP SỐ, MỨC GIÁ) -->
        <div class="col-lg-3 mb-4">
            <div class="p-4 rounded-4 sticky-top" style="background: var(--bg-card); border: 1px solid var(--border-color); top: 90px; z-index: 10;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h5 fw-bold mb-0 text-white">
                        <i class="fa-solid fa-sliders text-primary me-2"></i> Bộ Lọc Tìm Kiếm
                    </h2>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetFilter" title="Đặt lại bộ lọc">
                        <i class="fa-solid fa-rotate-left me-1"></i> Đặt Lại
                    </button>
                </div>
                
                <!-- 1. TÌM KIẾM THEO TÊN -->
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Từ Khóa Tên Xe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fa-solid fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control form-control-custom" placeholder="Ví dụ: Maybach, Taycan...">
                    </div>
                </div>

                <!-- 2. LỌC THEO HÃNG XE -->
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold"><i class="fa-solid fa-shield-halved text-warning me-1"></i> Hãng Xe (Thương Hiệu)</label>
                    <select id="filterBrand" class="form-select form-select-custom">
                        <option value="all">Tất cả thương hiệu</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Porsche">Porsche</option>
                        <option value="BMW">BMW</option>
                        <option value="Audi">Audi</option>
                        <option value="Land Rover">Land Rover</option>
                        <option value="Lexus">Lexus</option>
                    </select>
                </div>

                <!-- 3. LỌC THEO NHIÊN LIỆU -->
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold"><i class="fa-solid fa-gas-pump text-info me-1"></i> Nhiên Liệu</label>
                    <select id="filterFuel" class="form-select form-select-custom">
                        <option value="all">Tất cả loại nhiên liệu</option>
                        <option value="Xăng">Động cơ Xăng</option>
                        <option value="Điện">Thuần Điện (EV)</option>
                        <option value="Hybrid">Hybrid / Mild-Hybrid</option>
                    </select>
                </div>

                <!-- 4. LỌC THEO HỘP SỐ -->
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold"><i class="fa-solid fa-gear text-success me-1"></i> Hộp Số</label>
                    <select id="filterTransmission" class="form-select form-select-custom">
                        <option value="all">Tất cả loại hộp số</option>
                        <option value="9G-TRONIC">Tự động 9 cấp (9G-TRONIC)</option>
                        <option value="Steptronic">Tự động 8 cấp (Steptronic / ZF)</option>
                        <option value="PDK">Tự động thể thao (PDK / 2 cấp)</option>
                        <option value="Direct-Shift">Tự động 10 cấp (Direct-Shift)</option>
                    </select>
                </div>

                <!-- 5. LỌC THEO MỨC GIÁ -->
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold"><i class="fa-solid fa-money-bill-wave text-danger me-1"></i> Mức Giá Bán</label>
                    <select id="filterPrice" class="form-select form-select-custom">
                        <option value="all">Tất cả khoảng giá</option>
                        <option value="under5">Dưới 5 tỷ VNĐ</option>
                        <option value="5to10">Từ 5 đến 10 tỷ VNĐ</option>
                        <option value="over10">Trên 10 tỷ VNĐ</option>
                    </select>
                </div>

                <!-- KIỂU DÁNG / PHÂN KHÚC PHỤ TRỢ -->
                <div class="mb-2">
                    <label class="form-label text-secondary small fw-bold"><i class="fa-solid fa-car text-secondary me-1"></i> Phân Khúc Kiểu Dáng</label>
                    <select id="filterType" class="form-select form-select-custom">
                        <option value="all">Tất cả kiểu dáng</option>
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="Electric">Xe Điện</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- CAR GRID CONTAINER & TOP SORT BAR -->
        <div class="col-lg-9">
            <!-- TOP BAR: KẾT QUẢ TÌM THẤY & SẮP XẾP THEO GIÁ / ĐỜI XE -->
            <div class="d-flex flex-wrap justify-content-between align-items-center p-3 mb-4 rounded-4" 
                 style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                    <span class="text-white fw-bold"><i class="fa-solid fa-list-check text-primary me-2"></i> Kết Quả:</span>
                    <span class="badge bg-primary px-3 py-2" id="carsCountBadge">Tìm thấy {{ count($cars) }} mẫu xe</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="sortBy" class="text-secondary small fw-bold text-nowrap mb-0">
                        <i class="fa-solid fa-arrow-down-wide-short me-1"></i> Sắp Xếp Theo:
                    </label>
                    <select id="sortBy" class="form-select form-select-custom form-select-sm" style="min-width: 220px;">
                        <option value="default">Mặc định (Nổi bật nhất)</option>
                        <option value="price_asc">Giá: Thấp đến Cao (Tăng dần)</option>
                        <option value="price_desc">Giá: Cao đến Thấp (Giảm dần)</option>
                        <option value="year_desc">Đời xe mới nhất (Năm SX)</option>
                    </select>
                </div>
            </div>

            <!-- DANH SÁCH XE DẠNG GRID -->
            <div class="row" id="carsGridContainer">
                @foreach($cars as $car)
                <div class="col-lg-4 col-md-6 mb-4 car-item-box"
                     data-id="{{ $car['id'] }}"
                     data-brand="{{ $car['brand'] }}"
                     data-fuel="{{ $car['fuel'] }}"
                     data-transmission="{{ $car['transmission'] ?? '' }}"
                     data-price="{{ $car['price'] }}"
                     data-year="{{ $car['year'] ?? 2026 }}"
                     data-type="{{ $car['type'] }}"
                     data-name="{{ strtolower($car['name']) }}">
                    <div class="car-card h-100 d-flex flex-column">
                        <div class="car-thumb position-relative overflow-hidden">
                            <a href="{{ url('/cars/' . $car['id']) }}" class="d-block w-100 h-100" title="Xem chi tiết {{ $car['name'] }}">
                                <img src="{{ $car['image'] }}" 
                                     alt="Mẫu xe {{ $car['name'] }} - {{ $car['brand'] }} chính hãng tại PrimeLux Auto" 
                                     class="w-100 object-fit-cover" 
                                     width="400" 
                                     height="220" 
                                     loading="lazy" 
                                     decoding="async">
                            </a>
                            <span class="car-tag {{ $car['tagClass'] ?? 'tag-hot' }} position-absolute top-0 end-0 m-3 pe-none">
                                {{ $car['tag'] }}
                            </span>
                            @if(!empty($car['year']))
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute top-0 start-0 m-3 border border-secondary pe-none">
                                Đời {{ $car['year'] }}
                            </span>
                            @endif
                        </div>
                        <div class="car-body d-flex flex-column flex-grow-1 p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="car-brand text-primary fw-bold small text-uppercase">{{ $car['brand'] }}</span>
                                <span class="badge bg-secondary bg-opacity-25 text-secondary small">{{ $car['type'] }}</span>
                            </div>
                            <h3 class="car-title fs-5 fw-bold text-white mb-2">
                                <a href="{{ url('/cars/' . $car['id']) }}" class="text-white text-decoration-none" title="Xem chi tiết {{ $car['name'] }}">{{ $car['name'] }}</a>
                            </h3>
                            <div class="car-specs text-secondary small mb-3 d-flex flex-wrap gap-2">
                                <span><i class="fa-solid fa-gas-pump text-primary me-1"></i> {{ $car['fuel'] }}</span>
                                <span><i class="fa-solid fa-gear text-success me-1"></i> {{ $car['transmission'] ?? 'Tự động' }}</span>
                                <span><i class="fa-solid fa-bolt text-warning me-1"></i> {{ $car['power'] }}</span>
                            </div>
                            <div class="car-price text-warning fw-bold fs-5 mt-auto mb-3">{{ $car['priceText'] }}</div>
                            <div class="car-actions d-flex gap-2">
                                <a href="{{ url('/cars/' . $car['id']) }}" class="btn btn-accent flex-grow-1 text-center py-2" title="Xem chi tiết xe">
                                    <i class="fa-solid fa-eye me-1"></i> Chi Tiết
                                </a>
                                <a href="{{ url('/cars/' . $car['id'] . '/compare') }}" class="btn btn-outline-info text-center py-2 px-2.5" title="So Sánh Giá Đa Sàn (PO)">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                </a>
                                <a href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-gold text-center py-2 px-2.5" title="Đặt Lái Thử Xe">
                                    <i class="fa-solid fa-steering-wheel"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- THÔNG BÁO KHI KHÔNG TÌM THẤY KẾT QUẢ -->
            <div id="noResultsAlert" class="text-center py-5 d-none p-4 rounded-4" style="background: var(--bg-card); border: 1px dashed var(--border-color);">
                <i class="fa-solid fa-car-tunnel text-secondary fa-4x mb-3"></i>
                <h4 class="text-white fw-bold">Không tìm thấy mẫu xe phù hợp</h4>
                <p class="text-secondary mb-3">Vui lòng điều chỉnh hoặc đặt lại các tiêu chí lọc để xem thêm các mẫu xe khác.</p>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('btnResetFilter').click()">
                    <i class="fa-solid fa-rotate-left me-1"></i> Đặt Lại Toàn Bộ Bộ Lọc
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInput");
        const filterBrand = document.getElementById("filterBrand");
        const filterFuel = document.getElementById("filterFuel");
        const filterTransmission = document.getElementById("filterTransmission");
        const filterPrice = document.getElementById("filterPrice");
        const filterType = document.getElementById("filterType");
        const sortBy = document.getElementById("sortBy");
        const btnResetFilter = document.getElementById("btnResetFilter");
        const countBadge = document.getElementById("carsCountBadge");
        const gridContainer = document.getElementById("carsGridContainer");
        const noResults = document.getElementById("noResultsAlert");

        const carBoxes = Array.from(document.querySelectorAll(".car-item-box"));

        // HÀM LỌC VÀ SẮP XẾP XE REALTIME
        function filterAndSortCars() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
            const brandVal = filterBrand ? filterBrand.value : "all";
            const fuelVal = filterFuel ? filterFuel.value : "all";
            const transVal = filterTransmission ? filterTransmission.value : "all";
            const priceVal = filterPrice ? filterPrice.value : "all";
            const typeVal = filterType ? filterType.value : "all";
            const sortVal = sortBy ? sortBy.value : "default";

            let matchedCars = carBoxes.filter(box => {
                const brand = box.dataset.brand;
                const fuel = box.dataset.fuel;
                const trans = box.dataset.transmission;
                const price = parseFloat(box.dataset.price) || 0;
                const type = box.dataset.type;
                const name = box.dataset.name;

                // 1. Kiểm tra từ khóa
                if (query && !name.includes(query) && !brand.toLowerCase().includes(query)) {
                    return false;
                }

                // 2. Kiểm tra hãng
                if (brandVal !== "all" && brand !== brandVal) {
                    return false;
                }

                // 3. Kiểm tra nhiên liệu
                if (fuelVal !== "all") {
                    if (fuelVal === "Điện" && !fuel.includes("Điện") && !fuel.includes("EV")) return false;
                    if (fuelVal === "Xăng" && !fuel.includes("Xăng")) return false;
                    if (fuelVal === "Hybrid" && !fuel.includes("Hybrid")) return false;
                }

                // 4. Kiểm tra hộp số
                if (transVal !== "all") {
                    if (!trans.toLowerCase().includes(transVal.toLowerCase())) return false;
                }

                // 5. Kiểm tra mức giá
                if (priceVal === "under5" && price >= 5000000000) return false;
                if (priceVal === "5to10" && (price < 5000000000 || price > 10000000000)) return false;
                if (priceVal === "over10" && price <= 10000000000) return false;

                // 6. Kiểm tra kiểu dáng
                if (typeVal !== "all" && type !== typeVal) return false;

                return true;
            });

            // SẮP XẾP XE
            if (sortVal === "price_asc") {
                matchedCars.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
            } else if (sortVal === "price_desc") {
                matchedCars.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
            } else if (sortVal === "year_desc") {
                matchedCars.sort((a, b) => parseInt(b.dataset.year) - parseInt(a.dataset.year));
            }

            // HIỂN THỊ KẾT QUẢ RA DOM
            carBoxes.forEach(b => b.style.display = "none");

            matchedCars.forEach(b => {
                b.style.display = "";
                gridContainer.appendChild(b);
            });

            if (countBadge) {
                countBadge.textContent = `Tìm thấy ${matchedCars.length} mẫu xe`;
            }

            if (noResults) {
                if (matchedCars.length === 0) {
                    noResults.classList.remove("d-none");
                } else {
                    noResults.classList.add("d-none");
                }
            }
        }

        // Hàm Debounce tối ưu hiệu năng Runtime theo Chương 8
        function debounce(fn, delay = 250) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        // BẮT SỰ KIỆN THAY ĐỔI BỘ LỌC
        if (searchInput) searchInput.addEventListener("input", debounce(filterAndSortCars, 250));
        if (filterBrand) filterBrand.addEventListener("change", filterAndSortCars);
        if (filterFuel) filterFuel.addEventListener("change", filterAndSortCars);
        if (filterTransmission) filterTransmission.addEventListener("change", filterAndSortCars);
        if (filterPrice) filterPrice.addEventListener("change", filterAndSortCars);
        if (filterType) filterType.addEventListener("change", filterAndSortCars);
        if (sortBy) sortBy.addEventListener("change", filterAndSortCars);

        // NÚT ĐẶT LẠI BỘ LỌC
        if (btnResetFilter) {
            btnResetFilter.addEventListener("click", () => {
                if (searchInput) searchInput.value = "";
                if (filterBrand) filterBrand.value = "all";
                if (filterFuel) filterFuel.value = "all";
                if (filterTransmission) filterTransmission.value = "all";
                if (filterPrice) filterPrice.value = "all";
                if (filterType) filterType.value = "all";
                if (sortBy) sortBy.value = "default";
                filterAndSortCars();
            });
        }

        // ĐỒNG BỘ TỪ QUERY PARAMETERS TRÊN URL
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        const brandParam = urlParams.get('brand');
        const fuelParam = urlParams.get('fuel');
        const sortParam = urlParams.get('sort');

        if (typeParam && filterType) filterType.value = typeParam;
        if (brandParam && filterBrand) filterBrand.value = brandParam;
        if (fuelParam && filterFuel) filterFuel.value = fuelParam;
        if (sortParam && sortBy) sortBy.value = sortParam;

        filterAndSortCars();
    });
</script>
@endpush
