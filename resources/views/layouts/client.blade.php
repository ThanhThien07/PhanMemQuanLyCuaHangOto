<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PrimeLux Auto - Cửa Hàng Ô Tô Hạng Sang & Siêu Xe')</title>

    <!-- SEO ON-PAGE & METADATA THEO CHƯƠNG 8 -->
    <meta name="description" content="@yield('meta_description', 'PrimeLux Auto - Hệ thống phân phối siêu xe và ô tô hạng sang nhập khẩu chính hãng: Mercedes-Maybach, Porsche, BMW, Audi, Lexus. Lái thử tận nơi, bảo dưỡng 5 sao.')">
    <meta name="keywords" content="@yield('meta_keywords', 'showroom ô tô, siêu xe, ô tô hạng sang, mercedes-benz, porsche, bmw, audi, lexus, lái thử xe, bảng giá xe')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <meta name="theme-color" content="#d97706">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- RESOURCE HINTS: PRECONNECT & DNS-PREFETCH TĂNG TỐC TẢI TRANG -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//images.unsplash.com">
    @stack('head_preload')

    <!-- OPEN GRAPH (FACEBOOK, ZALO, LINKEDIN) -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="PrimeLux Auto">
    <meta property="og:title" content="@yield('og_title', 'PrimeLux Auto - Cửa Hàng Ô Tô Hạng Sang & Siêu Xe')">
    <meta property="og:description" content="@yield('og_description', 'PrimeLux Auto - Hệ thống phân phối các dòng siêu xe và ô tô hạng sang nhập khẩu chính hãng hàng đầu Việt Nam.')">
    <meta property="og:image" content="@yield('og_image', asset('image/Logo.png'))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:locale" content="vi_VN">

    <!-- TWITTER CARD -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'PrimeLux Auto - Cửa Hàng Ô Tô Hạng Sang & Siêu Xe')">
    <meta name="twitter:description" content="@yield('og_description', 'Khám phá bộ sưu tập siêu xe và ô tô hạng sang tại PrimeLux Auto.')">
    <meta name="twitter:image" content="@yield('og_image', asset('image/Logo.png'))">

    <!-- STRUCTURED DATA: JSON-LD (AUTODEALER) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "AutoDealer",
        "name": "PrimeLux Auto",
        "image": "{{ asset('image/Logo.png') }}",
        "url": "{{ url('/') }}",
        "telephone": "0338929013",
        "priceRange": "$$$$",
        "currenciesAccepted": "VND",
        "paymentAccepted": "Tiền mặt, Chuyển khoản, Trả góp trực tuyến",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "123 Nguyễn Văn Linh, Phường Tân Phong, Quận 7",
            "addressLocality": "TP. Hồ Chí Minh",
            "addressCountry": "VN"
        },
        "geo": {
            "@@type": "GeoCoordinates",
            "latitude": 10.7291,
            "longitude": 106.7118
        },
        "openingHoursSpecification": [
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                "opens": "08:00",
                "closes": "20:00"
            }
        ]
    }
    </script>
    @stack('structured_data')

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom Style & Chatbot (KÈM CACHE-BUSTING CHỐNG LƯU TRÌNH DUYỆT CŨ) -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}?v={{ time() }}">
    @stack('styles')
</head>

<body>

    <!-- SINGLE COMBINED NAVBAR HEADER (LUXURY SLEEK STYLE) -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid px-3 px-md-4 px-xl-5">
            <!-- LOGO NẰM BÊN TRÁI -->
            <a class="navbar-brand d-flex align-items-center me-3 me-xl-4" href="{{ url('/') }}">
                <img src="{{ asset('image/Logo.png') }}" alt="PrimeLux Logo" onerror="this.style.display='none'">
                <span class="brand-text">PRIMELUX <span class="brand-badge">LUXURY</span></span>
            </a>

            <button class="navbar-toggler text-white border-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::is('/') || Request::is('home') || Request::is('trangchu') ? 'active' : '' }}" href="{{ url('/') }}">Trang Chủ</a>
                    </li>

                    <!-- MENU MẪU XE & DÒNG XE -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle {{ Request::is('cars*') || Request::is('xe*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            Mẫu Xe
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item fw-bold text-primary" href="{{ url('/cars') }}"><i class="fa-solid fa-grid-2 me-2"></i> Xem Tất Cả Mẫu Xe</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header text-uppercase text-secondary small"><i class="fa-solid fa-layer-group me-1"></i> Phân Khúc</h6></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?type=Sedan') }}"><i class="fa-solid fa-car-side me-2"></i> Sedan Sang Trọng</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?type=SUV') }}"><i class="fa-solid fa-truck-monster me-2"></i> SUV Hạng Sang</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?type=Electric') }}"><i class="fa-solid fa-charging-station me-2"></i> Xe Điện EV & Hybrid</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header text-uppercase text-secondary small"><i class="fa-solid fa-shield-halved me-1"></i> Thương Hiệu</h6></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?brand=Mercedes-Benz') }}"><i class="fa-solid fa-car me-2"></i> Mercedes-Benz</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?brand=BMW') }}"><i class="fa-solid fa-car me-2"></i> BMW</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?brand=Porsche') }}"><i class="fa-solid fa-car me-2"></i> Porsche</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?brand=Audi') }}"><i class="fa-solid fa-car me-2"></i> Audi</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?brand=Lexus') }}"><i class="fa-solid fa-car me-2"></i> Lexus</a></li>
                            <li><a class="dropdown-item" href="{{ url('/cars?brand=Land Rover') }}"><i class="fa-solid fa-car me-2"></i> Land Rover</a></li>
                        </ul>
                    </li>

                    <!-- SO SÁNH GIÁ ĐA SÀN (PO COMPARISON) -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::is('compare*') || Request::is('sosanh*') ? 'active' : '' }}" href="{{ url('/compare') }}" title="So sánh giá xe đa sàn trực tuyến">
                            <i class="fa-solid fa-scale-balanced me-1 text-warning"></i> So Sánh Giá
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::is('test-drive*') || Request::is('laithu*') ? 'active' : '' }}" href="{{ url('/test-drive') }}">Lái Thử</a>
                    </li>

                    <!-- TRA CỨU HÓA ĐƠN CHO KHÁCH VÃNG LAI -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::is('invoices*') || Request::is('hoadon*') ? 'active' : '' }}" href="{{ url('/invoices') }}" title="Dành riêng cho khách hàng vãng lai">
                            <i class="fa-solid fa-receipt me-1 text-info"></i> Tra Cứu HĐ
                        </a>
                    </li>

                    <!-- THANH TOÁN ONLINE TRẢ TRƯỚC -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::is('thanh-toan-tra-truoc*') || Request::is('down-payment*') || Request::is('tra-truoc*') ? 'active' : '' }}" href="{{ url('/thanh-toan-tra-truoc') }}" title="Cổng thanh toán online tiền trả trước & đặt cọc xe">
                            <i class="fa-solid fa-credit-card me-1 text-warning"></i> Trả Trước Online
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 ms-lg-2 navbar-auth-section">
                    <!-- PHẦN LOGIN / LOGOUT THỰC TẾ (LUÔN HIỂN THỊ RÕ RÀNG KHÔNG BỊ TRÀN) -->
                    @if(session()->has('user'))
                        @php $currentUser = session('user'); @endphp
                        <div class="dropdown">
                            <button class="btn btn-warning btn-sm dropdown-toggle rounded-pill px-3 py-1.5 d-flex align-items-center gap-2 text-dark fw-bold shadow" type="button" data-bs-toggle="dropdown">
                                <img src="{{ $currentUser['avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}" class="rounded-circle" style="width: 22px; height: 22px;" alt="Avatar">
                                <span class="text-truncate" style="max-width: 120px;">{{ $currentUser['name'] }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                                <li><h6 class="dropdown-header text-uppercase text-secondary small">Tài Khoản Đang Đăng Nhập</h6></li>
                                <li><div class="px-3 py-1 small text-light fw-bold">{{ $currentUser['name'] }}</div></li>
                                <li><div class="px-3 pb-2 small text-secondary">{{ $currentUser['email'] ?? $currentUser['phone'] ?? '' }}</div></li>
                                <li><hr class="dropdown-divider"></li>
                                @if(($currentUser['role'] ?? '') === 'customer')
                                    <li><a class="dropdown-item" href="{{ url('/loyalty?phone=' . urlencode($currentUser['phone'] ?? '')) }}"><i class="fa-solid fa-crown me-2 text-warning"></i> Thẻ Hội Viên VIP</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/test-drive') }}"><i class="fa-solid fa-steering-wheel me-2 text-primary"></i> Đặt Lịch Lái Thử</a></li>
                                @elseif(($currentUser['role'] ?? '') === 'advisor')
                                    <li><a class="dropdown-item" href="{{ url('/consultant') }}"><i class="fa-solid fa-headset me-2 text-info"></i> Bàn Tư Vấn Realtime Desk</a></li>
                                @elseif(($currentUser['role'] ?? '') === 'admin')
                                    <li><a class="dropdown-item" href="{{ url('/admin') }}"><i class="fa-solid fa-gauge-high me-2 text-warning"></i> Bảng Quản Trị Hệ Thống</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="{{ url('/logout') }}">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng Xuất (Logout)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- NÚT ĐĂNG KÝ VÀ ĐĂNG NHẬP CHO KHÁCH HÀNG (RÕ RÀNG, BẢO MẬT, KHÔNG LỘ CỔNG NỘI BỘ) -->
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ url('/register') }}" class="btn btn-outline-warning btn-sm rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 text-nowrap shadow-sm" style="border-width: 1.5px;">
                                <i class="fa-solid fa-user-plus"></i> Đăng Ký
                            </a>
                            <a href="{{ url('/login') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fw-bold shadow d-inline-flex align-items-center gap-1.5 text-nowrap">
                                <i class="fa-solid fa-right-to-bracket"></i> Đăng Nhập
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT BODY -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <span class="brand-text fs-3">PRIMELUX <span class="brand-badge">LUXURY</span></span>
                    <p class="text-secondary mt-3">Chuỗi Showroom phân phối các dòng xe siêu sang hàng đầu Việt Nam. Nơi
                        khẳng định đẳng cấp và phong cách sống thượng lưu.</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Hệ Thống Showroom</h5>
                    <p class="text-secondary mb-2"><i class="fa-solid fa-location-dot text-primary me-2"></i> Showroom
                        TP.HCM: 111/28/33 Phạm Văn Chiêu, P. An Hội Tây</p>
                    <p class="text-secondary mb-2"><i class="fa-solid fa-location-dot text-primary me-2"></i> Showroom
                        Hà Nội: KĐT Vinhomes Riverside, Long Biên</p>
                    <p class="text-secondary"><i class="fa-solid fa-phone text-warning me-2"></i> Hotline: 0338 929 013
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3 text-warning"><i class="fa-solid fa-shield-halved me-2"></i>Cam Kết & Đặc Quyền 5 Sao</h5>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="fa-solid fa-certificate text-warning mt-1"></i>
                            <span><strong>Bảo Hành 36 Tháng:</strong> Tiêu chuẩn chính hãng quốc tế hoặc 100.000 km.</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="fa-solid fa-truck-pickup text-primary mt-1"></i>
                            <span><strong>Cứu Hộ VIP 24/7:</strong> Xe nâng chuyên dụng toàn quốc không chạm gầm.</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="fa-solid fa-clipboard-check text-success mt-1"></i>
                            <span><strong>Kiểm Định 176 Hạng Mục:</strong> Cam kết xe nguyên bản, minh bạch lịch sử.</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="fa-solid fa-clock text-info mt-1"></i>
                            <span><strong>Giờ Mở Cửa:</strong> 08:00 - 20:00 (Phục vụ 7 ngày/tuần, kể cả ngày Lễ & Tết).</span>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="border-top border-secondary pt-4 text-center text-secondary small">
                © 2026 PrimeLux Auto. Bản quyền thuộc về Võ Hoàng Long (501250437).
            </div>
        </div>
    </footer>

    <!-- JS BOOTSTRAP, MAIN JS & CHATBOT (DEFER & CACHE-BUSTING CHỐNG LƯU BROWSER CACHE CŨ) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/Index.js') }}?v={{ time() }}" defer></script>
    <script src="{{ asset('js/chatbot.js') }}?v={{ time() }}" defer></script>
    <script src="{{ asset('js/cars-realtime.js') }}?v={{ time() }}" defer></script>
    @stack('scripts')
</body>

</html>
