<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Thành Viên - PrimeLux Auto VIP</title>
    <meta name="description" content="Cổng đăng nhập thành viên PrimeLux Club. Đăng nhập để tra cứu điểm thưởng, nhận ưu đãi hội viên và đặt lịch lái thử siêu xe.">

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/giaodien.css') }}">

    <style>
        body {
            background-color: #080c16;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .login-card {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 40px rgba(234, 179, 8, 0.08);
            position: relative;
        }

        .form-control-custom {
            background: rgba(30, 41, 59, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            border-radius: 12px !important;
            padding: 12px 16px;
        }

        .form-control-custom:focus {
            border-color: #eab308 !important;
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.25) !important;
        }

        .btn-google {
            background: #ffffff;
            color: #1f2937 !important;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-google:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        }

        .divider-line {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #64748b;
            font-size: 13px;
        }

        .divider-line::before,
        .divider-line::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider-line::before { margin-right: 12px; }
        .divider-line::after { margin-left: 12px; }

        .btn-accent-gold {
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
            color: #0b0f19;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .btn-accent-gold:hover {
            box-shadow: 0 8px 25px rgba(234, 179, 8, 0.4);
            transform: translateY(-2px);
            color: #0b0f19;
        }

        .staff-portal-toggle {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            margin-top: 25px;
            font-size: 12.5px;
        }
    </style>
</head>

<body>
    <!-- TOP NAVBAR LOGO ONLY -->
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ url('/') }}">
                <img src="{{ asset('image/Logo.png') }}" alt="PrimeLux Logo" style="height: 36px;" class="me-2" onerror="this.style.display='none'">
                <span class="brand-text fs-4 fw-bold">PRIMELUX</span>
                <span class="badge rounded-pill ms-2 px-2.5 py-1 fw-bold text-dark shadow-sm" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); font-size: 11px; letter-spacing: 0.5px; -webkit-text-fill-color: #0f172a !important; color: #0f172a !important; display: inline-flex; align-items: center;">VIP CLUB</span>
            </a>
            <a href="{{ url('/') }}" class="text-secondary text-decoration-none small hover-white">
                <i class="fa-solid fa-arrow-left me-1"></i> Quay lại Showroom
            </a>
        </div>
    </nav>

    <!-- LOGIN FORM CONTAINER -->
    <div class="login-container">
        <div class="login-card">
            <!-- HEADER -->
            <div class="text-center mb-4">
                <span class="badge bg-warning bg-opacity-20 text-warning border border-warning px-3 py-1 mb-2 d-inline-block" id="portalBadge">
                    <i class="fa-solid fa-crown me-1"></i> HỘI VIÊN PRIMELUX CLUB
                </span>
                <h3 class="fw-bold mb-1 text-white" id="loginTitle">Đăng Nhập Khách Hàng</h3>
                <p class="text-secondary small mb-0" id="loginSubtitle">Đăng nhập tài khoản để tra cứu đặc quyền & điểm thưởng VIP</p>
            </div>

            {{-- THÔNG BÁO LỖI / THÀNH CÔNG --}}
            @if (session('error'))
                <div class="alert mb-3 rounded-3" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5; font-size: 13px;">
                    <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert mb-3 rounded-3" style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.4); color: #86efac; font-size: 13px;">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- 1. ĐĂNG NHẬP BẰNG TÀI KHOẢN GOOGLE (CHỈ HIỂN THỊ KHI Ở CHẾ ĐỘ KHÁCH HÀNG) -->
            <div id="googleLoginSection">
                <a href="{{ route('auth.google') }}" class="btn btn-google w-100 py-2.5 d-flex align-items-center justify-content-center gap-3">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Tiếp tục với Google (Gmail)</span>
                </a>

                <div class="divider-line">Hoặc đăng nhập bằng số điện thoại / email</div>
            </div>

            <!-- FORM ĐĂNG NHẬP -->
            <form id="loginForm" action="{{ route('login.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="role" id="selectedRole" value="{{ $role ?? 'customer' }}">

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-semibold" id="accountLabel">Email / Số Điện Thoại</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-secondary text-secondary">
                            <i class="fa-solid fa-envelope" id="inputIcon"></i>
                        </span>
                        <input type="text" name="account" class="form-control form-control-custom" id="accountInput"
                               placeholder="Nhập email hoặc SĐT..." required value="{{ old('account', $role === 'admin' ? 'admin' : ($role === 'advisor' ? 'tuvanvien@primelux.vn' : '')) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label text-secondary small fw-semibold">Mật Khẩu</label>
                        <a href="#" class="small text-decoration-none" style="color: #60a5fa; font-size: 12px;">Quên mật khẩu?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control form-control-custom" id="passwordInput" placeholder="Nhập mật khẩu..." required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label text-secondary small" for="rememberMe">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn btn-accent-gold w-100 py-2.5" id="submitBtn">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Đăng Nhập Hội Viên
                </button>
            </form>

            <!-- LINK ĐĂNG KÝ TÀI KHOẢN KHÁCH HÀNG -->
            <div id="registerSection" class="text-center mt-4 pt-3 border-top border-secondary border-opacity-40">
                <span class="text-secondary small">Chưa có tài khoản thành viên?</span><br>
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none d-inline-block mt-1" style="color: #f59e0b;">
                    <i class="fa-solid fa-user-plus me-1"></i> Đăng Ký Thành Viên PrimeLux Club Mới
                </a>
            </div>

            <!-- CỔNG NHÂN SỰ & QUẢN TRỊ (CHUYỂN CHẾ ĐỘ KÍN ĐÁO) -->
            <div class="staff-portal-toggle">
                <span class="text-secondary" id="staffToggleText">Dành cho Cán bộ Nhân viên Showroom:</span><br>
                <a href="javascript:void(0)" class="text-info fw-bold text-decoration-none" id="staffSwitchLink" onclick="toggleStaffPortal()">
                    <i class="fa-solid fa-lock me-1"></i> Chuyển sang Cổng Nhân Viên & Quản Trị
                </a>
            </div>
        </div>
    </div>

    <!-- SCRIPT CHUYỂN ĐỔI GIAO DIỆN KHÁCH HÀNG / NHÂN VIÊN -->
    <script>
        let isStaffMode = false;

        function setCustomerMode() {
            isStaffMode = false;
            document.getElementById('selectedRole').value = 'customer';
            document.getElementById('portalBadge').className = 'badge bg-warning bg-opacity-20 text-warning border border-warning px-3 py-1 mb-2 d-inline-block';
            document.getElementById('portalBadge').innerHTML = '<i class="fa-solid fa-crown me-1"></i> HỘI VIÊN PRIMELUX CLUB';
            document.getElementById('loginTitle').innerText = 'Đăng Nhập Khách Hàng';
            document.getElementById('loginSubtitle').innerText = 'Đăng nhập tài khoản để tra cứu đặc quyền & điểm thưởng VIP';
            document.getElementById('accountLabel').innerText = 'Email / Số Điện Thoại';
            document.getElementById('accountInput').placeholder = 'Nhập email hoặc SĐT...';
            document.getElementById('googleLoginSection').style.display = 'block';
            document.getElementById('registerSection').style.display = 'block';
            document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-right-to-bracket me-2"></i> Đăng Nhập Hội Viên';
            document.getElementById('staffToggleText').innerText = 'Dành cho Cán bộ Nhân viên Showroom:';
            document.getElementById('staffSwitchLink').innerHTML = '<i class="fa-solid fa-lock me-1"></i> Chuyển sang Cổng Nhân Viên & Quản Trị';
        }

        function setStaffMode(role = 'admin') {
            isStaffMode = true;
            document.getElementById('selectedRole').value = role;
            document.getElementById('portalBadge').className = 'badge bg-danger bg-opacity-20 text-danger border border-danger px-3 py-1 mb-2 d-inline-block';
            document.getElementById('portalBadge').innerHTML = '<i class="fa-solid fa-shield-halved me-1"></i> KHU VỰC NỘI BỘ SHOWROOM';
            document.getElementById('loginTitle').innerText = role === 'admin' ? 'Đăng Nhập Quản Trị Viên' : 'Đăng Nhập Bàn Tư Vấn';
            document.getElementById('loginSubtitle').innerText = 'Hệ thống xác thực nhân viên nghiệp vụ PrimeLux Auto Showroom';
            document.getElementById('accountLabel').innerText = 'Tài Khoản / Email Nội Bộ';
            document.getElementById('accountInput').placeholder = 'Nhập tên đăng nhập hoặc email nội bộ...';
            document.getElementById('googleLoginSection').style.display = 'none';
            document.getElementById('registerSection').style.display = 'none';
            document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-shield-halved me-2"></i> Đăng Nhập Nội Bộ';
            document.getElementById('staffToggleText').innerText = 'Quý khách muốn tra cứu điểm thưởng?';
            document.getElementById('staffSwitchLink').innerHTML = '<i class="fa-solid fa-user me-1"></i> Quay lại Đăng Nhập Khách Hàng VIP';
        }

        function toggleStaffPortal() {
            if (isStaffMode) {
                setCustomerMode();
            } else {
                setStaffMode('admin');
            }
        }

        // Tự động chọn vai trò nếu URL có ?role=admin hoặc ?role=advisor
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const roleParam = urlParams.get('role');
            if (roleParam === 'admin' || roleParam === 'advisor') {
                setStaffMode(roleParam);
            } else {
                setCustomerMode();
            }
        });
    </script>
</body>
</html>
