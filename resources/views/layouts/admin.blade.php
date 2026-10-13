<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bảng Điều Khiển Quản Trị - PrimeLux Auto Admin')</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/giaodien.css') }}">
    
    <!-- Chart.js CDN for Revenue Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
    <style>
        .admin-nav-link {
            color: #94a3b8;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .admin-nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }
        .admin-nav-link.active {
            color: #fff;
            background: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
        .admin-subbar {
            background: #0d121f;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* LUXURY STAT CARDS */
        .stat-card-luxury {
            background: linear-gradient(145deg, #131b2e 0%, #0c1222 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 16px 18px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
        }

        .stat-card-luxury[role="button"] {
            cursor: pointer;
            user-select: none;
        }

        .stat-card-luxury::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: transparent;
            transition: all 0.25s ease;
        }

        .stat-card-luxury.card-blue::before {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }
        .stat-card-luxury.card-cyan::before {
            background: linear-gradient(90deg, #06b6d4, #22d3ee);
        }
        .stat-card-luxury.card-amber::before {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }
        .stat-card-luxury.card-emerald::before {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .stat-card-luxury:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
            border-color: rgba(255, 255, 255, 0.16);
        }

        .stat-card-luxury.active-blue {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.35);
            background: linear-gradient(145deg, rgba(59, 130, 246, 0.22), #0c1222) !important;
        }
        .stat-card-luxury.active-cyan {
            border-color: #06b6d4 !important;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.35);
            background: linear-gradient(145deg, rgba(6, 182, 212, 0.22), #0c1222) !important;
        }
        .stat-card-luxury.active-amber {
            border-color: #f59e0b !important;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.35);
            background: linear-gradient(145deg, rgba(245, 158, 11, 0.22), #0c1222) !important;
        }
        .stat-card-luxury.active-emerald {
            border-color: #10b981 !important;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.35);
            background: linear-gradient(145deg, rgba(16, 185, 129, 0.22), #0c1222) !important;
        }

        .dash-section {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .stat-card-luxury .stat-title {
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 5px;
        }

        .stat-card-luxury .stat-value {
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.01em;
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .stat-card-luxury .stat-value.revenue-val {
            font-size: 1.15rem;
            white-space: nowrap;
        }

        .stat-card-luxury .stat-unit {
            font-size: 0.8rem;
            font-weight: 500;
            color: #94a3b8;
        }

        .stat-card-luxury .stat-sub {
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-icon-wrap {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: transform 0.25s ease;
        }

        .stat-card-luxury:hover .stat-icon-wrap {
            transform: scale(1.06);
        }

        .icon-blue {
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.25);
            color: #60a5fa;
        }

        .icon-cyan {
            background: rgba(6, 182, 212, 0.12);
            border: 1px solid rgba(6, 182, 212, 0.25);
            color: #22d3ee;
        }

        .icon-amber {
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.25);
            color: #fbbf24;
        }

        .icon-emerald {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #34d399;
        }
    </style>
</head>

<body style="background-color: #090d16; color: #f8fafc; min-height: 100vh;">

    <!-- TOP HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary py-2.5">
        <div class="container-fluid px-3 px-md-4">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin/dashboard.html') }}">
                <span class="brand-text fs-4">PRIMELUX <span class="badge bg-warning text-dark fs-6 ms-2">ADMIN PORTAL</span></span>
            </a>

            <button class="navbar-toggler text-white border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarContent">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbarContent">
                <div class="ms-auto d-flex flex-wrap align-items-center gap-2 gap-md-3 py-2 py-lg-0">
                    <span class="text-secondary small d-none d-xl-inline"><i class="fa-solid fa-user-circle text-primary me-1"></i> Xin chào, Quản trị viên</span>
                    <a href="{{ url('/consultant') }}" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fa-solid fa-headset me-1"></i> Bàn Tư Vấn
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-globe me-1"></i> Xem Website (index.html)
                    </a>
                    <a href="{{ url('/logout') }}" class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Đăng Xuất
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ADMIN SUB-NAVBAR FOR DIRECT ACCESSIBILITY (TỔNG QUAN, KHO XE, LỊCH LÁI THỬ) -->
    <div class="admin-subbar py-2 px-3 px-md-4">
        <div class="container-fluid px-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex flex-wrap gap-1 gap-md-2 overflow-auto py-1">
                <a href="{{ url('/admin/dashboard.html') }}" class="admin-nav-link {{ Request::is('admin') || Request::is('admin/dashboard*') || Request::is('quantri*') && !Request::is('admin/cars*') && !Request::is('admin/test*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line me-2"></i> Tổng Quan (dashboard.html)
                </a>
                <a href="{{ url('/admin/cars-management.html') }}" class="admin-nav-link {{ Request::is('admin/cars*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked me-2"></i> Quản Lý Kho Xe (cars-management.html)
                </a>
                <a href="{{ url('/admin/test-drive-list.html') }}" class="admin-nav-link {{ Request::is('admin/test*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check me-2"></i> Quản Lý Lịch Lái Thử (test-drive-list.html)
                </a>
            </div>
            <div class="text-secondary small d-none d-lg-block">
                <i class="fa-solid fa-clock text-info me-1"></i> Hệ thống Showroom PrimeLux Auto 2026
            </div>
        </div>
    </div>

    <!-- MAIN BODY -->
    <main class="py-3">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
