<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Hệ Thống - PrimeLux Auto</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom Style & Chatbot -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    <style>
        .login-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 540px;
            padding: 35px;
        }

        .role-tab-btn {
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-secondary);
            border-radius: 12px;
            padding: 10px 8px;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
            text-align: center;
        }

        .role-tab-btn:hover,
        .role-tab-btn.active {
            background: rgba(37, 99, 235, 0.15);
            border-color: var(--accent-blue);
            color: #fff;
        }

        .role-tab-btn.active.advisor-tab {
            background: rgba(6, 182, 212, 0.15);
            border-color: #06b6d4;
            color: #22d3ee;
        }

        .role-tab-btn.active.admin-tab {
            background: rgba(245, 158, 11, 0.15);
            border-color: var(--accent-gold);
            color: var(--accent-gold);
        }

        .badge-demo {
            background: rgba(255, 255, 255, 0.08);
            border: 1px dashed var(--border-color);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR HEADER -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('image/Logo.png') }}" alt="PrimeLux Logo" onerror="this.style.display='none'">
                <span class="brand-text">PRIMELUX <span class="brand-badge">LUXURY</span></span>
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Trang Chủ
            </a>
        </div>
    </nav>

    <!-- LOGIN FORM CONTAINER -->
    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <span class="brand-badge fs-6 px-3 py-1 mb-2 d-inline-block">CỔNG ĐĂNG NHẬP</span>
                <h3 class="fw-bold mb-1" id="loginTitle">Đăng Nhập Khách Hàng</h3>
                <p class="text-secondary small" id="loginSubtitle">Đăng nhập tài khoản để tra cứu điểm thưởng & đặt lịch lái thử</p>
            </div>

            <!-- CHỌN 3 ĐỐI TƯỢNG (KHÁCH HÀNG, TƯ VẤN VIÊN & QUẢN TRỊ) -->
            <div class="row g-2 mb-4">
                <div class="col-4">
                    <button type="button" class="role-tab-btn active" id="tabCustomer" onclick="switchRole('customer')">
                        <i class="fa-solid fa-user d-block fs-5 mb-1"></i>
                        <span class="small d-block text-truncate">Khách Hàng</span>
                    </button>
                </div>
                <div class="col-4">
                    <button type="button" class="role-tab-btn" id="tabAdvisor" onclick="switchRole('advisor')">
                        <i class="fa-solid fa-headset d-block fs-5 mb-1"></i>
                        <span class="small d-block text-truncate">Tư Vấn Viên</span>
                    </button>
                </div>
                <div class="col-4">
                    <button type="button" class="role-tab-btn" id="tabAdmin" onclick="switchRole('admin')">
                        <i class="fa-solid fa-user-shield d-block fs-5 mb-1"></i>
                        <span class="small d-block text-truncate">Quản Trị Admin</span>
                    </button>
                </div>
            </div>

            <!-- DEMO ACCOUNT INFO -->
            <div class="badge-demo mb-4 text-secondary" id="demoAccountInfo">
                <i class="fa-solid fa-circle-info text-info me-1"></i> <strong>Tài khoản Demo (Khách Hàng VIP):</strong><br>
                <span>Email / SĐT: <code>khachhang@gmail.com</code> | Mật khẩu: <code>123456</code></span>
            </div>

            <!-- FORM ĐĂNG NHẬP THỰC TẾ -->
            <form id="loginForm" action="{{ route('login.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="role" id="selectedRole" value="customer">

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-semibold" id="accountLabel">Email / Số Điện Thoại Khách Hàng</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fa-solid fa-envelope" id="inputIcon"></i></span>
                        <input type="text" name="account" class="form-control form-control-custom" id="accountInput" placeholder="khachhang@gmail.com hoặc 0901234567..." required value="khachhang@gmail.com">
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label text-secondary small fw-semibold">Mật Khẩu</label>
                        <a href="#" class="small text-accent-blue text-decoration-none">Quên mật khẩu?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-secondary text-secondary"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control form-control-custom" id="passwordInput" placeholder="Nhập mật khẩu..." required value="123456">
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label text-secondary small" for="rememberMe">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn btn-accent w-100 py-2.5 fw-bold" id="submitBtn">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Đăng Nhập Khách Hàng
                </button>
            </form>
        </div>
    </div>

    <!-- SCRIPT CHUYỂN ĐỔI VAI TRÒ & XỬ LÝ -->
    <script>
        function switchRole(role) {
            document.getElementById('selectedRole').value = role;
            
            document.getElementById('tabCustomer').className = 'role-tab-btn ' + (role === 'customer' ? 'active' : '');
            document.getElementById('tabAdvisor').className = 'role-tab-btn ' + (role === 'advisor' ? 'active advisor-tab' : '');
            document.getElementById('tabAdmin').className = 'role-tab-btn ' + (role === 'admin' ? 'active admin-tab' : '');

            const title = document.getElementById('loginTitle');
            const subtitle = document.getElementById('loginSubtitle');
            const accountLabel = document.getElementById('accountLabel');
            const accountInput = document.getElementById('accountInput');
            const demoInfo = document.getElementById('demoAccountInfo');
            const submitBtn = document.getElementById('submitBtn');
            const inputIcon = document.getElementById('inputIcon');

            if (role === 'customer') {
                title.innerText = 'Đăng Nhập Khách Hàng';
                subtitle.innerText = 'Đăng nhập để tra cứu điểm thưởng PrimeLux Club & xem thông tin hội viên';
                accountLabel.innerText = 'Email / Số Điện Thoại Khách Hàng';
                inputIcon.className = 'fa-solid fa-envelope';
                accountInput.placeholder = 'khachhang@gmail.com';
                accountInput.value = 'khachhang@gmail.com';
                demoInfo.innerHTML = '<i class="fa-solid fa-circle-info text-info me-1"></i> <strong>Tài khoản Demo (Khách Hàng VIP):</strong><br>Email/SĐT: <code>khachhang@gmail.com</code> | Mật khẩu: <code>123456</code> (Điểm: 12.500 Diamond)';
                submitBtn.className = 'btn btn-accent w-100 py-2.5 fw-bold';
                submitBtn.innerHTML = '<i class="fa-solid fa-right-to-bracket me-2"></i> Đăng Nhập Khách Hàng';
            } else if (role === 'advisor') {
                title.innerText = 'Đăng Nhập Tư Vấn Viên';
                subtitle.innerText = 'Cổng nghiệp vụ chuyên viên tư vấn trực tuyến (Realtime Desk)';
                accountLabel.innerText = 'Tài Khoản / Email Tư Vấn Viên';
                inputIcon.className = 'fa-solid fa-headset text-info';
                accountInput.placeholder = 'tuvanvien@primelux.vn';
                accountInput.value = 'tuvanvien@primelux.vn';
                demoInfo.innerHTML = '<i class="fa-solid fa-headset text-info me-1"></i> <strong>Tài khoản Demo (Chuyên Viên Tư Vấn):</strong><br>Tài khoản: <code>tuvanvien@primelux.vn</code> | Mật khẩu: <code>123456</code>';
                submitBtn.className = 'btn btn-info text-white w-100 py-2.5 fw-bold';
                submitBtn.innerHTML = '<i class="fa-solid fa-headset me-2"></i> Vào Bàn Tư Vấn Trực Tuyến';
            } else if (role === 'admin') {
                title.innerText = 'Đăng Nhập Quản Trị';
                subtitle.innerText = 'Quyền quản trị toàn bộ kho xe, hóa đơn, khách hàng & điểm thưởng';
                accountLabel.innerText = 'Tài Khoản Admin / Email';
                inputIcon.className = 'fa-solid fa-user-shield text-warning';
                accountInput.placeholder = 'admin';
                accountInput.value = 'admin';
                demoInfo.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> <strong>Tài khoản Demo (Quản Trị Admin):</strong><br>Tài khoản: <code>admin</code> | Mật khẩu: <code>admin123</code>';
                submitBtn.className = 'btn btn-gold w-100 py-2.5 fw-bold';
                submitBtn.innerHTML = '<i class="fa-solid fa-shield-halved me-2"></i> Đăng Nhập Quản Trị';
            }
        }

        // Tự động chọn vai trò từ URL param
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const roleParam = urlParams.get('role');
            if (roleParam && ['customer', 'advisor', 'admin'].includes(roleParam)) {
                switchRole(roleParam);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
