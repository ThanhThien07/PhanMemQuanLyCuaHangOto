<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng Ký Thành Viên PrimeLux Club - PrimeLux Auto</title>
    <meta name="description" content="Đăng ký tài khoản thành viên PrimeLux Club để nhận ưu đãi độc quyền, tích điểm và quản lý xe của bạn.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/giaodien.css') }}">

    <style>
        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 15px;
            background: linear-gradient(135deg, #0a0a0f 0%, #0d1117 50%, #0a1628 100%);
        }

        .register-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 900px;
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
        }

        .register-banner {
            background: linear-gradient(145deg, #1a1005, #2d1a00);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .register-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(245, 158, 11, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        .register-banner .brand-logo {
            font-size: 22px;
            font-weight: 800;
            color: #f59e0b;
            letter-spacing: 2px;
            text-decoration: none;
        }

        .register-banner .perks {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .register-banner .perks li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(245, 158, 11, 0.1);
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .register-banner .perks li:last-child {
            border-bottom: none;
        }

        .register-banner .perks li i {
            color: #f59e0b;
            width: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .register-form-panel {
            background: #111827;
            padding: 45px 40px;
        }

        .form-control-custom {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #fff !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            font-size: 14px !important;
            transition: all 0.2s !important;
        }

        .form-control-custom:focus {
            background: rgba(37, 99, 235, 0.08) !important;
            border-color: rgba(37, 99, 235, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
            color: #fff !important;
        }

        .form-control-custom::placeholder {
            color: rgba(255, 255, 255, 0.3) !important;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: rgba(255, 255, 255, 0.4) !important;
            border-radius: 10px 0 0 10px !important;
        }

        .input-group .form-control-custom {
            border-radius: 0 10px 10px 0 !important;
        }

        .btn-register {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 12px;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .form-label {
            color: rgba(255, 255, 255, 0.6) !important;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .divider-text {
            position: relative;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
        }

        .divider-text::before,
        .divider-text::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .divider-text::before { left: 0; }
        .divider-text::after { right: 0; }

        @media (max-width: 768px) {
            .register-container {
                grid-template-columns: 1fr;
            }
            .register-banner {
                display: none;
            }
        }

        .tier-badge-preview {
            background: linear-gradient(135deg, rgba(156, 163, 175, 0.1), rgba(107, 114, 128, 0.05));
            border: 1px solid rgba(156, 163, 175, 0.2);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body style="margin:0; padding:0; background: #0a0a0f;">

    <div class="register-wrapper">
        <div class="register-container">

            <!-- BANNER TRÁI - QuyỀN LỢI THÀNH VIÊN -->
            <div class="register-banner">
                <div>
                    <a href="{{ url('/') }}" class="brand-logo">
                        <i class="fa-solid fa-gem me-2"></i>PRIMELUX
                    </a>
                    <div class="mt-3" style="color: rgba(255,255,255,0.5); font-size: 13px;">Trở thành thành viên PrimeLux Club</div>
                </div>

                <div class="my-4">
                    <h3 style="color: #f59e0b; font-weight: 700; margin-bottom: 6px;">Quyền Lợi Thành Viên</h3>
                    <p style="color: rgba(255,255,255,0.4); font-size: 13px; margin-bottom: 20px;">Đặc quyền dành riêng cho hội viên PrimeLux</p>

                    <ul class="perks">
                        <li>
                            <i class="fa-solid fa-star"></i>
                            <div>
                                <strong style="color:#fff;">Tích điểm mua xe</strong><br>
                                <span style="font-size:12px; color:rgba(255,255,255,0.5);">Nhận điểm thưởng từ mỗi giao dịch để đổi quà & ưu đãi</span>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-calendar-check"></i>
                            <div>
                                <strong style="color:#fff;">Đặt lịch lái thử ưu tiên</strong><br>
                                <span style="font-size:12px; color:rgba(255,255,255,0.5);">Xếp hàng ưu tiên, lái thử xe mới nhất tại showroom</span>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-file-invoice"></i>
                            <div>
                                <strong style="color:#fff;">Hóa đơn điện tử về Gmail</strong><br>
                                <span style="font-size:12px; color:rgba(255,255,255,0.5);">Nhận hóa đơn tự động khi giao dịch hoàn thành</span>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-headset"></i>
                            <div>
                                <strong style="color:#fff;">Tư vấn viên riêng 24/7</strong><br>
                                <span style="font-size:12px; color:rgba(255,255,255,0.5);">Hỗ trợ trực tiếp từ chuyên viên tư vấn cao cấp</span>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-shield-halved"></i>
                            <div>
                                <strong style="color:#fff;">Bảo hành & cứu hộ VIP</strong><br>
                                <span style="font-size:12px; color:rgba(255,255,255,0.5);">Dịch vụ cứu hộ khẩn cấp 24/7, bảo dưỡng ưu tiên</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="tier-badge-preview">
                    <i class="fa-solid fa-award me-2" style="color:#9ca3af;"></i>
                    Bắt đầu với hạng <strong style="color:#d1d5db;">Silver Member</strong> — tích điểm lên Gold & Diamond VIP!
                </div>
            </div>

            <!-- FORM ĐĂNG KÝ PHẢI -->
            <div class="register-form-panel">
                <div class="mb-4">
                    <h3 style="color: #fff; font-weight: 700; margin-bottom: 4px;">Tạo Tài Khoản Mới</h3>
                    <p style="color: rgba(255,255,255,0.4); font-size: 14px; margin: 0;">Điền thông tin để gia nhập PrimeLux Club</p>
                </div>

                {{-- THÔNG BÁO LỖI --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; font-size: 13px;">
                        <i class="fa-solid fa-circle-xmark me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger rounded-3 mb-3" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; font-size: 13px;">
                        <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <a href="{{ route('auth.google') }}" class="btn btn-outline-light w-100 py-2.5 d-flex align-items-center justify-content-center gap-2 fw-semibold" style="background:#fff; color:#1f2937 !important; border-radius:12px;">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Đăng Ký Nhanh Bằng Tài Khoản Google</span>
                    </a>
                </div>

                <div class="divider-text mb-3">Hoặc điền biểu mẫu đăng ký thành viên</div>

                <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Họ và Tên <span style="color:#f59e0b;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="ho_ten" class="form-control form-control-custom" placeholder="Nguyễn Văn A" value="{{ old('ho_ten') }}" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Số Điện Thoại <span style="color:#f59e0b;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" name="sdt" class="form-control form-control-custom" placeholder="0901234567" value="{{ old('sdt') }}" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Ngày Sinh</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-cake-candles"></i></span>
                                <input type="date" name="ngay_sinh" class="form-control form-control-custom" value="{{ old('ngay_sinh') }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email <span style="color:#f59e0b;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-custom" placeholder="email@gmail.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Địa Chỉ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                <input type="text" name="dia_chi" class="form-control form-control-custom" placeholder="Số nhà, đường, quận/huyện, tỉnh/thành phố" value="{{ old('dia_chi') }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Mật Khẩu <span style="color:#f59e0b;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="mat_khau" id="passwordField" class="form-control form-control-custom" placeholder="Tối thiểu 6 ký tự" required>
                                <button type="button" class="input-group-text" onclick="togglePass('passwordField', this)" style="cursor:pointer;">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Xác Nhận Mật Khẩu <span style="color:#f59e0b;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock-open"></i></span>
                                <input type="password" name="mat_khau_confirmation" id="confirmField" class="form-control form-control-custom" placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mt-3 mb-4">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms" style="color: rgba(255,255,255,0.5); font-size: 13px;">
                            Tôi đồng ý với <a href="#" style="color: #f59e0b; text-decoration: none;">Điều khoản dịch vụ</a> và <a href="#" style="color: #f59e0b; text-decoration: none;">Chính sách bảo mật</a> của PrimeLux Auto
                        </label>
                    </div>

                    <button type="submit" class="btn btn-register w-100" id="registerBtn">
                        <i class="fa-solid fa-user-plus me-2"></i>Tạo Tài Khoản PrimeLux Club
                    </button>
                </form>

                <div class="divider-text my-4">Hoặc</div>

                <div class="text-center" style="font-size: 13px; color: rgba(255,255,255,0.4);">
                    Đã có tài khoản?
                    <a href="{{ route('dangnhap') }}" style="color: #f59e0b; text-decoration: none; font-weight: 600;">
                        Đăng nhập ngay
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" style="color: rgba(255,255,255,0.3); font-size: 12px; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left me-1"></i>Quay về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePass(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fa-solid fa-eye';
            } else {
                field.type = 'password';
                icon.className = 'fa-solid fa-eye-slash';
            }
        }

        // Loading state on submit
        document.getElementById('registerForm').addEventListener('submit', function () {
            const btn = document.getElementById('registerBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Đang tạo tài khoản...';
        });
    </script>
</body>

</html>
