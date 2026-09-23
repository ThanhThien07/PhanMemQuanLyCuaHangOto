@extends('layouts.giaodien')

@section('title', 'PrimeLux Auto - Cửa Hàng Ô Tô Hạng Sang & Siêu Xe')

@section('content')
<!-- HERO BANNER SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <span class="section-tag"><i class="fa-solid fa-crown text-warning"></i> Đỉnh Cao Thượng Lưu</span>
                <h1 class="hero-title">Khám Phá Bộ Sưu Tập Siêu Xe & Xe Sang</h1>
                <p class="hero-subtitle">
                    PrimeLux Auto tự hào cung cấp các dòng xe sang trọng bậc nhất từ Mercedes-Maybach, Porsche, BMW,
                    Audi, Lexus. Trải nghiệm phong cách sống thượng lưu cùng dịch vụ hậu mãi 5 sao.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#featured-cars" class="btn btn-accent btn-lg">
                        <i class="fa-solid fa-car-side me-2"></i> Khám Phá Xe Nổi Bật
                    </a>
                    <a href="{{ url('/test-drive') }}" class="btn btn-outline-light btn-lg" style="border-radius: 10px;">
                        <i class="fa-solid fa-calendar-check me-2"></i> Đặt Lịch Lái Thử
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-img-container">
                    <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1200&auto=format&fit=crop"
                        class="hero-img" alt="Mercedes Maybach S680">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- QUICK FILTER CARD SECTION -->
<div class="container">
    <div class="filter-card">
        <h5 class="fw-bold mb-3"><i class="fa-solid fa-filter text-primary me-2"></i> Tìm Kiếm Nhanh Mẫu Xe Phù Hợp</h5>
        <div class="row g-3">
            <div class="col-md-3">
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
            <div class="col-md-3">
                <select id="filterType" class="form-select form-select-custom">
                    <option value="all">Tất cả loại xe</option>
                    <option value="Sedan">Sedan Sang Trọng</option>
                    <option value="SUV">SUV Hạng Sang</option>
                    <option value="Electric">Xe Điện (EV)</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterPrice" class="form-select form-select-custom">
                    <option value="all">Tất cả khoảng giá</option>
                    <option value="under5">Dưới 5 tỷ VNĐ</option>
                    <option value="5to10">Từ 5 đến 10 tỷ VNĐ</option>
                    <option value="over10">Trên 10 tỷ VNĐ</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" id="searchInput" class="form-control form-control-custom"
                    placeholder="Nhập tên xe...">
            </div>
        </div>
    </div>
</div>

<!-- FEATURED CARS SECTION -->
<section id="featured-cars" class="py-5 mt-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="section-tag">Danh Mục Cao Cấp</span>
                <h2 class="section-title">Các Dòng Xe Đang Phân Phối</h2>
            </div>
            <a href="{{ url('/cars') }}" class="btn btn-outline-primary" style="border-radius: 8px;">Xem Tất Cả Xe <i
                    class="fa-solid fa-arrow-right"></i></a>
        </div>

        <!-- DỮ LIỆU ĐƯỢC RENDER ĐỘNG TỪ INDEX.JS VÀ FALLBACK TỪ BLADE -->
        <div class="row" id="car-list-container">
            @foreach($cars as $car)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="car-card">
                    <div class="car-thumb">
                        <img src="{{ $car['image'] }}" alt="{{ $car['name'] }}">
                        <span class="car-tag {{ $car['tagClass'] }}">{{ $car['tag'] }}</span>
                    </div>
                    <div class="car-body">
                        <div class="car-brand">{{ $car['brand'] }}</div>
                        <h3 class="car-title">{{ $car['name'] }}</h3>
                        <div class="car-specs">
                            <span><i class="fa-solid fa-gas-pump"></i> {{ $car['fuel'] }}</span>
                            <span><i class="fa-solid fa-bolt"></i> {{ $car['power'] }}</span>
                            <span><i class="fa-solid fa-chair"></i> {{ $car['seats'] }}</span>
                        </div>
                        <div class="car-price">{{ $car['priceText'] }}</div>
                        <div class="car-actions">
                            <a href="{{ url('/cars/' . $car['id']) }}" class="btn btn-accent flex-grow-1 text-center">
                                <i class="fa-solid fa-eye"></i> Chi Tiết
                            </a>
                            <a href="{{ url('/cars/' . $car['id'] . '/compare') }}" class="btn btn-outline-info text-center" title="So Sánh Giá Đa Sàn (PO)">
                                <i class="fa-solid fa-scale-balanced"></i> So Sánh
                            </a>
                            <a href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-gold text-center" title="Đặt Lái Thử">
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
<section class="py-5" style="background: rgba(255, 255, 255, 0.02); border-y: 1px solid var(--border-color);">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="section-tag">Đặc Quyền Khách Hàng</span>
            <h2 class="section-title">Tại Sao Chọn PrimeLux Auto?</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 rounded-4"
                    style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-certificate text-warning fa-3x mb-3"></i>
                    <h4 class="fw-bold fs-5">Cam Kết Chính Hãng</h4>
                    <p class="text-secondary small">100% dòng xe có nguồn gốc rõ ràng, kiểm định 165 điểm theo tiêu
                        chuẩn quốc tế.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4"
                    style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-handshake-angle text-primary fa-3x mb-3"></i>
                    <h4 class="fw-bold fs-5">Lái Thử Tận Nhà</h4>
                    <p class="text-secondary small">Giao xe lái thử tận nơi cho khách hàng trải nghiệm trong không
                        gian riêng tư.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4"
                    style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-shield-halved text-success fa-3x mb-3"></i>
                    <h4 class="fw-bold fs-5">Bảo Hành 5 Sao</h4>
                    <p class="text-secondary small">Hỗ trợ kỹ thuật 24/7, xe cứu hộ riêng và chính sách bảo dưỡng
                        miễn phí.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HỆ THỐNG PHÂN PHỐI SECTION -->
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
                            <h5 class="fw-bold mb-1">Showroom TP. Hồ Chí Minh</h5>
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
                            <h5 class="fw-bold mb-1">Showroom Hà Nội</h5>
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
                            <h5 class="fw-bold mb-1">Center Đà Nẵng</h5>
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
