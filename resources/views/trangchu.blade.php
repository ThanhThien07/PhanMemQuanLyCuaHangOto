@extends('layouts.giaodien')

@section('title', 'PrimeLux Auto - Cửa Hàng Ô Tô Hạng Sang & Siêu Xe')

@section('content')
<!-- BANNER QUẢNG CÁO XE NỔI BẬT (HERO PROMOTIONAL CAROUSEL) -->
<section class="hero-promotional-carousel position-relative overflow-hidden">
    <div id="heroPromoCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        <!-- Indicators -->
        <div class="carousel-indicators mb-4">
            <button type="button" data-bs-target="#heroPromoCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroPromoCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroPromoCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1: Mercedes-Maybach S 680 -->
            <div class="carousel-item active" style="min-height: 580px; background: linear-gradient(90deg, #090d16 40%, rgba(9, 13, 22, 0.6) 70%, rgba(9, 13, 22, 0.2) 100%);">
                <div class="container py-5">
                    <div class="row align-items-center min-vh-50">
                        <div class="col-lg-6 py-4 z-2">
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                                <i class="fa-solid fa-fire me-1"></i> HOT DEAL - ĐẶC QUYỀN HỘI VIÊN VIP
                            </span>
                            <h1 class="display-4 fw-extrabold text-white mb-3">Mercedes-Maybach S 680 4MATIC</h1>
                            <p class="fs-5 text-secondary mb-4">
                                Đỉnh cao xa hoa chuẩn nguyên thủ. Động cơ V12 Bi-Turbo 612 mã lực, khoang ghế First-Class bọc da Nappa cùng hệ dẫn động 4 bánh toàn thời gian.
                            </p>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="fs-3 fw-bold text-warning">15.990.000.000 VNĐ</div>
                                <span class="badge bg-danger bg-opacity-20 text-danger border border-danger px-2.5 py-1.5">Tặng 100% Phí Biển Số</span>
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ url('/cars/car-01') }}" class="btn btn-accent btn-lg px-4 shadow">
                                    <i class="fa-solid fa-eye me-2"></i> Khám Phá Chi Tiết
                                </a>
                                <a href="{{ url('/test-drive?car=' . urlencode('Mercedes-Maybach S 680 4MATIC')) }}" class="btn btn-outline-light btn-lg px-4">
                                    <i class="fa-solid fa-steering-wheel me-2"></i> Đặt Lái Thử VIP
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center position-relative">
                            <a href="{{ url('/cars/car-01') }}" title="Khám phá chi tiết Mercedes-Maybach S 680" class="d-inline-block">
                                <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1200&auto=format&fit=crop"
                                    class="img-fluid rounded-4 shadow-2xl border border-secondary border-opacity-25 hero-car-img"
                                    alt="Mercedes-Maybach S 680">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Porsche Taycan Turbo S -->
            <div class="carousel-item" style="min-height: 580px; background: linear-gradient(90deg, #090d16 40%, rgba(9, 13, 22, 0.6) 70%, rgba(9, 13, 22, 0.2) 100%);">
                <div class="container py-5">
                    <div class="row align-items-center min-vh-50">
                        <div class="col-lg-6 py-4 z-2">
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                                <i class="fa-solid fa-bolt me-1"></i> XE MỚI VỀ - CÔNG NGHỆ THUẦN ĐIỆN 800V
                            </span>
                            <h1 class="display-4 fw-extrabold text-white mb-3">Porsche Taycan Turbo S</h1>
                            <p class="fs-5 text-secondary mb-4">
                                Siêu xe thuần điện bứt tốc 0-100km/h chỉ trong 2.8 giây. Công suất cực đại 761 mã lực với hệ thống sạc siêu tốc độ cao nhất phân khúc.
                            </p>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="fs-3 fw-bold text-warning">9.550.000.000 VNĐ</div>
                                <span class="badge bg-success bg-opacity-20 text-success border border-success px-2.5 py-1.5">Tặng Trụ Sạc Home Charger</span>
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ url('/cars/car-02') }}" class="btn btn-accent btn-lg px-4 shadow">
                                    <i class="fa-solid fa-eye me-2"></i> Khám Phá Chi Tiết
                                </a>
                                <a href="{{ url('/test-drive?car=' . urlencode('Porsche Taycan Turbo S')) }}" class="btn btn-outline-light btn-lg px-4">
                                    <i class="fa-solid fa-steering-wheel me-2"></i> Đặt Lái Thử VIP
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center position-relative">
                            <a href="{{ url('/cars/car-02') }}" title="Khám phá chi tiết Porsche Taycan Turbo S" class="d-inline-block">
                                <img src="https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1200&auto=format&fit=crop"
                                    class="img-fluid rounded-4 shadow-2xl border border-secondary border-opacity-25 hero-car-img"
                                    alt="Porsche Taycan Turbo S">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: BMW 740i Pure Excellence -->
            <div class="carousel-item" style="min-height: 580px; background: linear-gradient(90deg, #090d16 40%, rgba(9, 13, 22, 0.6) 70%, rgba(9, 13, 22, 0.2) 100%);">
                <div class="container py-5">
                    <div class="row align-items-center min-vh-50">
                        <div class="col-lg-6 py-4 z-2">
                            <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold mb-3">
                                <i class="fa-solid fa-tag me-1"></i> ƯU ĐÃI THÁNG - BẢO DƯỠNG 3 NĂM
                            </span>
                            <h1 class="display-4 fw-extrabold text-white mb-3">BMW 740i Pure Excellence</h1>
                            <p class="fs-5 text-secondary mb-4">
                                Thiết kế tương lai với lưới tản nhiệt Iconic Glow, rạp chiếu phim Theatre Screen 31 inch 8K phía sau cùng nội thất pha lai Crafted Clarity đỉnh cao.
                            </p>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="fs-3 fw-bold text-warning">6.299.000.000 VNĐ</div>
                                <span class="badge bg-warning bg-opacity-20 text-warning border border-warning px-2.5 py-1.5">Hỗ Trợ Trả Góp 0%</span>
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ url('/cars/car-03') }}" class="btn btn-accent btn-lg px-4 shadow">
                                    <i class="fa-solid fa-eye me-2"></i> Khám Phá Chi Tiết
                                </a>
                                <a href="{{ url('/test-drive?car=' . urlencode('BMW 740i Pure Excellence')) }}" class="btn btn-outline-light btn-lg px-4">
                                    <i class="fa-solid fa-steering-wheel me-2"></i> Đặt Lái Thử VIP
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center position-relative">
                            <a href="{{ url('/cars/car-03') }}" title="Khám phá chi tiết BMW 740i Pure Excellence" class="d-inline-block">
                                <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1200&auto=format&fit=crop"
                                    class="img-fluid rounded-4 shadow-2xl border border-secondary border-opacity-25 hero-car-img"
                                    alt="BMW 740i Pure Excellence">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroPromoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon rounded-circle p-3 bg-dark bg-opacity-50" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroPromoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon rounded-circle p-3 bg-dark bg-opacity-50" aria-hidden="true"></span>
            <span class="visually-hidden">Tiếp theo</span>
        </button>
    </div>
</section>

<!-- QUICK SEARCH & FILTER SECTION (TÌM KIẾM NHANH THEO HÃNG, PHÂN KHÚC, TẦM GIÁ) -->
<div class="container my-4">
    <div class="filter-card shadow-lg p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h5 class="fw-bold mb-0 text-white">
                <i class="fa-solid fa-magnifying-glass text-primary me-2"></i> Tìm Kiếm Nhanh Mẫu Xe Phù Hợp
            </h5>
            <span class="badge bg-secondary text-white" id="filterResultCount">Đang hiển thị {{ count($cars) }} mẫu xe</span>
        </div>
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-secondary small fw-bold">Hãng Xe</label>
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
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-secondary small fw-bold">Phân Khúc</label>
                <select id="filterType" class="form-select form-select-custom">
                    <option value="all">Tất cả phân khúc</option>
                    <option value="Sedan">Sedan Sang Trọng</option>
                    <option value="SUV">SUV Hạng Sang</option>
                    <option value="Electric">Xe Điện (EV)</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-secondary small fw-bold">Tầm Giá</label>
                <select id="filterPrice" class="form-select form-select-custom">
                    <option value="all">Tất cả khoảng giá</option>
                    <option value="under5">Dưới 5 tỷ VNĐ</option>
                    <option value="5to10">Từ 5 đến 10 tỷ VNĐ</option>
                    <option value="over10">Trên 10 tỷ VNĐ</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-secondary small fw-bold">Từ Khóa Tên Xe</label>
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control form-control-custom" placeholder="Nhập tên xe...">
                    <button class="btn btn-outline-secondary" type="button" id="btnResetFilter" title="Đặt lại bộ lọc">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FEATURED CARS SECTION (HIỂN THỊ XE MỚI VỀ, XE BÁN CHẠY DẠNG GRID CARD) -->
<section id="featured-cars" class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <span class="section-tag"><i class="fa-solid fa-crown text-warning me-1"></i> Bộ Sưu Tập Xe Sang</span>
                <h2 class="section-title mb-0">Các Dòng Xe Đang Phân Phối</h2>
            </div>
            <!-- TABS LỌC DANH MỤC: TẤT CẢ / XE MỚI VỀ / XE BÁN CHẠY / ƯU ĐÃI -->
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-category-tab active" data-category="all">
                    <i class="fa-solid fa-border-all me-1"></i> Tất Cả Xe
                </button>
                <button class="btn btn-sm btn-category-tab" data-category="new">
                    <i class="fa-solid fa-sparkles me-1 text-info"></i> Xe Mới Về
                </button>
                <button class="btn btn-sm btn-category-tab" data-category="bestseller">
                    <i class="fa-solid fa-fire me-1 text-danger"></i> Xe Bán Chạy
                </button>
                <button class="btn btn-sm btn-category-tab" data-category="sale">
                    <i class="fa-solid fa-tags me-1 text-warning"></i> Ưu Đãi Đặc Biệt
                </button>
                <a href="{{ url('/cars') }}" class="btn btn-sm btn-outline-primary ms-lg-2">
                    Xem Tất Cả (cars.html) <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- GRID CARD LIST CONTAINER -->
        <div class="row" id="car-list-container">
            @foreach($cars as $car)
            <div class="col-lg-4 col-md-6 mb-4 car-item-col" 
                 data-brand="{{ $car['brand'] }}" 
                 data-type="{{ $car['type'] }}" 
                 data-price="{{ $car['price'] }}" 
                 data-name="{{ strtolower($car['name']) }}"
                 data-tag="{{ $car['tag'] }}"
                 data-new="{{ !empty($car['is_new']) ? '1' : '0' }}"
                 data-bestseller="{{ !empty($car['is_best_seller']) ? '1' : '0' }}">
                <div class="car-card h-100 d-flex flex-column">
                    <div class="car-thumb position-relative overflow-hidden">
                        <a href="{{ url('/cars/' . $car['id']) }}" class="d-block w-100 h-100" title="Xem chi tiết {{ $car['name'] }}">
                            <img src="{{ $car['image'] }}" alt="{{ $car['name'] }}" class="w-100 object-fit-cover" style="height: 230px;">
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
                            <span><i class="fa-solid fa-bolt text-warning me-1"></i> {{ $car['power'] }}</span>
                            <span><i class="fa-solid fa-chair text-info me-1"></i> {{ $car['seats'] }}</span>
                        </div>
                        <div class="car-price text-warning fw-bold fs-5 mt-auto mb-3">{{ $car['priceText'] }}</div>
                        <div class="car-actions d-flex gap-2">
                            <a href="{{ url('/cars/' . $car['id']) }}" class="btn btn-accent flex-grow-1 text-center py-2" title="Chi tiết xe">
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
    </div>
</section>

<!-- WHY CHOOSE PRIMELUX -->
<section class="py-5" style="background: rgba(255, 255, 255, 0.02); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="section-tag">Đặc Quyền Khách Hàng</span>
            <h2 class="section-title">Tại Sao Chọn PrimeLux Auto?</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-certificate text-warning fa-3x mb-3"></i>
                    <h4 class="fw-bold fs-5 text-white">Cam Kết Chính Hãng 100%</h4>
                    <p class="text-secondary small mb-0">Tất cả dòng siêu xe và xe sang đều có nguồn gốc minh bạch, kiểm định 165 điểm khắt khe chuẩn châu Âu.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-handshake-angle text-primary fa-3x mb-3"></i>
                    <h4 class="fw-bold fs-5 text-white">Lái Thử Tận Nơi VIP</h4>
                    <p class="text-secondary small mb-0">Giao xe tận tư gia hoặc cơ quan để khách hàng trải nghiệm thực tế cùng chuyên viên cao cấp.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-shield-halved text-success fa-3x mb-3"></i>
                    <h4 class="fw-bold fs-5 text-white">Bảo Hành & Cứu Hộ 24/7</h4>
                    <p class="text-secondary small mb-0">Hỗ trợ kỹ thuật 24/7, xe cứu hộ chuyên dụng riêng biệt và chính sách bảo dưỡng 5 sao miễn phí.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HỆ THỐNG SHOWROOM TOÀN QUỐC -->
<section id="distribution-system" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag"><i class="fa-solid fa-network-wired text-primary me-1"></i> Mạng Lưới Rộng Khắp</span>
            <h2 class="section-title">Hệ Thống Phân Phối PrimeLux Auto</h2>
            <p class="text-secondary">Trải nghiệm dịch vụ mua bán & bảo dưỡng siêu xe chuẩn 5 sao trên toàn quốc</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary fs-4">
                            <i class="fa-solid fa-building-flag"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Showroom TP. Hồ Chí Minh</h5>
                            <span class="badge bg-primary">Flagship Center</span>
                        </div>
                    </div>
                    <p class="text-secondary small mb-2"><i class="fa-solid fa-location-dot text-danger me-2"></i> 123 Nguyễn Văn Linh, Phường Tân Phong, Quận 7, TP.HCM</p>
                    <p class="text-secondary small mb-2"><i class="fa-solid fa-phone text-warning me-2"></i> Hotline: 0338 929 013</p>
                    <p class="text-secondary small mb-0"><i class="fa-solid fa-clock text-info me-2"></i> 08:00 - 20:00 (Hàng ngày)</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning fs-4">
                            <i class="fa-solid fa-building-user"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Showroom Hà Nội</h5>
                            <span class="badge bg-warning text-dark">Luxury Hub</span>
                        </div>
                    </div>
                    <p class="text-secondary small mb-2"><i class="fa-solid fa-location-dot text-danger me-2"></i> KĐT Vinhomes Riverside, Phường Phúc Lợi, Q. Long Biên, Hà Nội</p>
                    <p class="text-secondary small mb-2"><i class="fa-solid fa-phone text-warning me-2"></i> Hotline: 0909 123 456</p>
                    <p class="text-secondary small mb-0"><i class="fa-solid fa-clock text-info me-2"></i> 08:00 - 20:00 (Hàng ngày)</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-info bg-opacity-10 text-info fs-4">
                            <i class="fa-solid fa-warehouse"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Center Đà Nẵng</h5>
                            <span class="badge bg-info text-dark">Service & Sales</span>
                        </div>
                    </div>
                    <p class="text-secondary small mb-2"><i class="fa-solid fa-location-dot text-danger me-2"></i> 88 Nguyễn Văn Linh, Quận Hải Châu, TP. Đà Nẵng</p>
                    <p class="text-secondary small mb-2"><i class="fa-solid fa-phone text-warning me-2"></i> Hotline: 0988 777 999</p>
                    <p class="text-secondary small mb-0"><i class="fa-solid fa-clock text-info me-2"></i> 08:00 - 20:00 (Hàng ngày)</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .btn-category-tab {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        font-weight: 600;
        border-radius: 20px;
        padding: 6px 16px;
        transition: all 0.2s ease;
    }
    .btn-category-tab:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    .btn-category-tab.active {
        background: var(--accent-blue);
        border-color: var(--accent-blue);
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .hero-car-img {
        max-height: 380px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }
    .hero-car-img:hover {
        transform: scale(1.02);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const filterBrand = document.getElementById("filterBrand");
        const filterType = document.getElementById("filterType");
        const filterPrice = document.getElementById("filterPrice");
        const searchInput = document.getElementById("searchInput");
        const btnResetFilter = document.getElementById("btnResetFilter");
        const countBadge = document.getElementById("filterResultCount");
        const categoryTabs = document.querySelectorAll(".btn-category-tab");
        const carCols = document.querySelectorAll(".car-item-col");

        let activeCategory = "all";

        function applyQuickFilter() {
            const brandVal = filterBrand ? filterBrand.value : "all";
            const typeVal = filterType ? filterType.value : "all";
            const priceVal = filterPrice ? filterPrice.value : "all";
            const query = searchInput ? searchInput.value.toLowerCase().trim() : "";

            let visibleCount = 0;

            carCols.forEach(col => {
                const brand = col.dataset.brand;
                const type = col.dataset.type;
                const price = parseFloat(col.dataset.price) || 0;
                const name = col.dataset.name;
                const tag = col.dataset.tag;
                const isNew = col.dataset.new === "1";
                const isBestSeller = col.dataset.bestseller === "1";

                let matchBrand = (brandVal === "all" || brand === brandVal);
                let matchType = (typeVal === "all" || type === typeVal);
                let matchQuery = (!query || name.includes(query) || brand.toLowerCase().includes(query));

                let matchPrice = true;
                if (priceVal === "under5") matchPrice = (price < 5000000000);
                else if (priceVal === "5to10") matchPrice = (price >= 5000000000 && price <= 10000000000);
                else if (priceVal === "over10") matchPrice = (price > 10000000000);

                let matchCategory = true;
                if (activeCategory === "new") matchCategory = isNew || (tag === "Mới Về");
                else if (activeCategory === "bestseller") matchCategory = isBestSeller || (tag === "HOT");
                else if (activeCategory === "sale") matchCategory = (tag === "Ưu Đãi" || tag === "HOT");

                if (matchBrand && matchType && matchPrice && matchQuery && matchCategory) {
                    col.style.display = "";
                    visibleCount++;
                } else {
                    col.style.display = "none";
                }
            });

            if (countBadge) {
                countBadge.textContent = `Đang hiển thị ${visibleCount} mẫu xe`;
            }
        }

        if (filterBrand) filterBrand.addEventListener("change", applyQuickFilter);
        if (filterType) filterType.addEventListener("change", applyQuickFilter);
        if (filterPrice) filterPrice.addEventListener("change", applyQuickFilter);
        if (searchInput) searchInput.addEventListener("input", applyQuickFilter);

        categoryTabs.forEach(tab => {
            tab.addEventListener("click", function() {
                categoryTabs.forEach(t => t.classList.remove("active"));
                this.classList.add("active");
                activeCategory = this.dataset.category;
                applyQuickFilter();
            });
        });

        if (btnResetFilter) {
            btnResetFilter.addEventListener("click", () => {
                if (filterBrand) filterBrand.value = "all";
                if (filterType) filterType.value = "all";
                if (filterPrice) filterPrice.value = "all";
                if (searchInput) searchInput.value = "";
                categoryTabs.forEach(t => t.classList.remove("active"));
                const allTab = document.querySelector('.btn-category-tab[data-category="all"]');
                if (allTab) allTab.classList.add("active");
                activeCategory = "all";
                applyQuickFilter();
            });
        }
    });
</script>
@endpush
