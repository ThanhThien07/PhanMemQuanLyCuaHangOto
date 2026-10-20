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

        /* SEPAY FLOATING PAYMENT TOAST POPUP (GÓC PHẢI MÀN HÌNH ADMIN) */
        .sepay-floating-toast {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 10050;
            max-width: 390px;
            width: calc(100vw - 36px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sepay-toast-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.98), rgba(8, 14, 26, 0.99));
            border: 1.5px solid rgba(16, 185, 129, 0.6);
            border-radius: 16px;
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.75), 0 0 30px rgba(16, 185, 129, 0.25);
            backdrop-filter: blur(16px);
            overflow: hidden;
            animation: slideInRightToast 0.45s ease-out forwards;
        }

        @keyframes slideInRightToast {
            from {
                transform: translateX(120%) scale(0.95);
                opacity: 0;
            }
            to {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
        }

        .toast-header-bar {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.18), rgba(245, 158, 11, 0.1));
            border-bottom: 1px solid rgba(16, 185, 129, 0.3);
            padding: 10px 14px;
        }

        .toast-icon-pulse {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.2);
            border: 1.5px solid #10b981;
            color: #34d399;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulseGreen 1.8s infinite;
        }

        @keyframes pulseGreen {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
            70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>

<body style="background-color: #090d16; color: #f8fafc; min-height: 100vh;">

    <!-- TOP HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary py-2.5">
        <div class="container-fluid px-3 px-md-4">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ url('/admin') }}">
                <span class="brand-text fs-4 fw-bold">PRIMELUX</span>
                <span class="badge rounded-pill ms-2 px-2.5 py-1 fw-bold text-dark shadow-sm" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); font-size: 11px; letter-spacing: 0.5px; -webkit-text-fill-color: #0f172a !important; color: #0f172a !important; display: inline-flex; align-items: center;">ADMIN PORTAL</span>
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
                        <i class="fa-solid fa-globe me-1"></i> Xem Website
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
                <a href="{{ url('/admin') }}" class="admin-nav-link {{ Request::is('admin') || Request::is('admin/dashboard*') || Request::is('quantri*') && !Request::is('admin/cars*') && !Request::is('admin/test*') && !Request::is('admin/payment*') && !Request::is('admin/trade-in*') && !Request::is('admin/audit*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line me-2"></i> Tổng Quan
                </a>
                <a href="{{ url('/admin/cars-management') }}" class="admin-nav-link {{ Request::is('admin/cars*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked me-2"></i> Quản Lý Kho Xe
                </a>
                <a href="{{ url('/admin/test-drive-list') }}" class="admin-nav-link {{ Request::is('admin/test*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check me-2"></i> Lịch Lái Thử
                </a>
                <a href="{{ url('/admin/invoices') }}" class="admin-nav-link {{ Request::is('admin/invoices*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar me-2 text-success"></i> Hóa Đơn & Doanh Thu
                </a>
                <a href="{{ url('/admin/payments') }}" class="admin-nav-link {{ Request::is('admin/payment*') || Request::is('admin/sepay*') ? 'active' : '' }}">
                    <i class="fa-solid fa-credit-card me-2 text-warning"></i> Thanh Toán & SePay
                </a>
                <a href="{{ url('/admin/trade-in') }}" class="admin-nav-link {{ Request::is('admin/trade-in*') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrows-rotate me-2 text-info"></i> Thu Cũ Đổi Mới
                </a>
                <a href="{{ url('/admin/audit-logs') }}" class="admin-nav-link {{ Request::is('admin/audit*') ? 'active' : '' }}">
                    <i class="fa-solid fa-shield-halved me-2 text-danger"></i> Nhật Ký & 2FA
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

    <!-- FORM THÔNG BÁO NHỎ Ở GÓC PHẢI MÀN HÌNH ADMIN (SEPAY PAYMENT NOTIFICATION TOAST) -->
    <div id="sepayAdminPaymentToast" class="sepay-floating-toast d-none" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="sepay-toast-card">
            <div class="toast-header-bar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success bg-opacity-25 text-success border border-success px-2 py-0.5" style="font-size: 11px;">
                        <i class="fa-solid fa-circle-check me-1"></i> SePay Online
                    </span>
                    <strong class="text-white small mb-0"><i class="fa-solid fa-bell text-warning me-1"></i> Đã Thanh Toán Rồi!</strong>
                </div>
                <button type="button" class="btn btn-sm btn-link text-secondary p-0 text-decoration-none hover-white" onclick="closeAdminPaymentToast()" title="Đóng thông báo">
                    <i class="fa-solid fa-xmark fs-5"></i>
                </button>
            </div>
            <div class="p-3">
                <div class="d-flex align-items-start gap-3 mb-2.5">
                    <div class="toast-icon-pulse flex-shrink-0">
                        <i class="fa-solid fa-money-bill-wave fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-success fw-bold fs-5 mb-0" id="toastAmount">+0 VNĐ</div>
                        <div class="text-white small fw-bold mt-0.5" id="toastCustomer">Khách hàng: ...</div>
                        <div class="text-secondary" style="font-size: 12px;" id="toastCar">Mẫu xe: ...</div>
                    </div>
                </div>
                <div class="p-2 rounded-2 bg-black bg-opacity-40 border border-secondary border-opacity-30 mb-2.5 small">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-secondary" style="font-size: 11px;">Mã Đơn / GD:</span>
                        <code class="text-warning fw-bold" id="toastCode">PLDP...</code>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary" style="font-size: 11px;">Trạng Thái:</span>
                        <span class="badge bg-success" style="font-size: 10px;">
                            <i class="fa-solid fa-shield-check me-1"></i> Xác minh thành công
                        </span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a id="toastDetailLink" href="{{ url('/admin/payments') }}" class="btn btn-warning btn-sm w-100 text-dark fw-bold py-1.5" style="font-size: 12px;">
                        <i class="fa-solid fa-receipt me-1"></i> Xem Chi Tiết Giao Dịch
                    </a>
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="closeAdminPaymentToast()" style="font-size: 12px;">
                        Đã Hiểu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // XỬ LÝ FORM THÔNG BÁO NHỎ Ở GÓC PHẢI MÀN HÌNH ADMIN (SEPAY TOAST)
        let currentNotifiedTransId = null;

        function playPaymentNotificationSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = "sine";
                osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                osc.frequency.setValueAtTime(880, ctx.currentTime + 0.12); // A5
                gain.gain.setValueAtTime(0.18, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.65);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.7);
            } catch (e) {
                // AudioContext có thể bị chặn nếu chưa có tương tác người dùng
            }
        }

        window.showAdminPaymentToast = function(tx) {
            currentNotifiedTransId = tx.id;
            document.getElementById("toastAmount").textContent = "+" + (tx.transfer_amount_formatted || tx.transfer_amount + " VNĐ");
            document.getElementById("toastCustomer").textContent = "Khách hàng: " + (tx.customer_name || "Khách VIP") + (tx.customer_phone ? " (" + tx.customer_phone + ")" : "");
            document.getElementById("toastCar").textContent = "Mẫu xe: " + (tx.car_name || "Mẫu xe sang PrimeLux");
            document.getElementById("toastCode").textContent = tx.code || "PLDP...";
            document.getElementById("toastDetailLink").href = "{{ url('/admin/payments') }}?keyword=" + encodeURIComponent(tx.code || '');

            const toastEl = document.getElementById("sepayAdminPaymentToast");
            toastEl.classList.remove("d-none");
            playPaymentNotificationSound();
        };

        window.closeAdminPaymentToast = function() {
            const toastEl = document.getElementById("sepayAdminPaymentToast");
            toastEl.classList.add("d-none");

            if (currentNotifiedTransId) {
                fetch("{{ route('admin.payments.mark-notified') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id: currentNotifiedTransId })
                }).catch(e => {});
                currentNotifiedTransId = null;
            }
        };

        // Polling thăm dò giao dịch mới mỗi 4 giây
        function pollSepayPaymentNotifications() {
            fetch("{{ route('admin.payments.latest-notification') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.has_new && data.transaction) {
                        showAdminPaymentToast(data.transaction);
                    }
                })
                .catch(err => {});
        }

        setInterval(pollSepayPaymentNotifications, 4000);
        setTimeout(pollSepayPaymentNotifications, 1000);
    </script>
    <script src="{{ asset('js/cars-realtime.js') }}"></script>

    <!-- CHỐNG BROWSER BACK-BUTTON CACHE (BFCACHE) SAU LOGOUT ADMIN -->
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>
    @stack('scripts')
</body>

</html>

