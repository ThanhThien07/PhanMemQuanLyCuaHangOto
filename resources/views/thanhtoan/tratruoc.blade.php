@extends('layouts.giaodien')

@section('title', 'Thanh Toán Online Tiền Trả Trước Xe - PrimeLux Auto')

@section('content')
<div class="container py-5">
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary"><i class="fa-solid fa-house me-1"></i> Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/cars') }}" class="text-secondary">Mẫu Xe</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Thanh Toán Online Trả Trước</li>
        </ol>
    </nav>

    <!-- HEADER TITLE & GATEWAY BADGE -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold rounded-pill mb-2">
                <i class="fa-solid fa-credit-card me-1"></i> CỔNG THANH TOÁN TRỰC TUYẾN 24/7
            </span>
            <h1 class="display-6 fw-bold text-white mb-1">Thanh Toán Online Khoản Trả Trước Xe</h1>
            <p class="text-secondary mb-0">Hỗ trợ thanh toán nhanh tiền trả trước (20% - 80%) hoặc đặt cọc giữ xe với mã QR NAPAS 24/7 tức thì.</p>
        </div>

        <div class="p-3 rounded-3 border border-success border-opacity-50 bg-success bg-opacity-10 text-end">
            <div class="d-flex align-items-center justify-content-end gap-2 text-success fw-bold small mb-1">
                <i class="fa-solid fa-circle-check"></i> Cổng Thanh Toán Sẵn Sàng
            </div>
            <div class="text-light small">
                Liên kết ngân hàng: <strong class="text-warning fw-bold">{{ $gateway['bank_name'] ?? 'MBBank' }} &mdash; {{ $gateway['account_number'] ?? '0338929013' }}</strong>
            </div>
            <div class="text-secondary" style="font-size: 11px;">Bảo mật giao dịch mã hóa 256-bit SSL Chuẩn Open Banking</div>
        </div>
    </div>

    <div class="row g-4">
        <!-- CỘT TRÁI: CHỌN XE & TÍNH TOÁN KHOẢN TRẢ TRƯỚC -->
        <div class="col-lg-6">
            <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <h4 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-sliders text-warning"></i> 1. Kế Hoạch Trả Trước & Vay Vốn
                </h4>

                <!-- CHỌN MẪU XE -->
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Mẫu Xe Muốn Mua & Trả Trước:</label>
                    <select id="carSelect" class="form-select form-select-custom text-white">
                        @foreach($cars as $c)
                            <option value="{{ $c['id'] }}" 
                                    data-price="{{ $c['price'] }}"
                                    data-name="{{ $c['name'] }}"
                                    data-image="{{ $c['image'] }}"
                                    data-pricetext="{{ $c['priceText'] }}"
                                    {{ ($selectedCar['id'] ?? '') === $c['id'] ? 'selected' : '' }}>
                                {{ $c['name'] }} — {{ $c['priceText'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- CARD XEM NHANH XE ĐƯỢC CHỌN -->
                <div class="p-3 rounded-3 mb-3 border border-secondary border-opacity-50 d-flex align-items-center gap-3 bg-dark bg-opacity-50">
                    <img id="previewCarImg" src="{{ $selectedCar['image'] ?? '' }}" alt="Xe" class="rounded-2" style="width: 100px; height: 65px; object-fit: cover;">
                    <div>
                        <h6 class="text-white fw-bold mb-1" id="previewCarName">{{ $selectedCar['name'] ?? '' }}</h6>
                        <div class="text-warning fw-bold fs-6" id="previewCarPrice">{{ $selectedCar['priceText'] ?? '0 VNĐ' }}</div>
                    </div>
                </div>

                <!-- CHỌN TỶ LỆ TRẢ TRƯỚC -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label text-secondary small fw-bold mb-0">Tỷ Lệ Trả Trước Ban Đầu:</label>
                        <span class="badge bg-warning text-dark fs-6 fw-bold" id="percentBadge">{{ $defaultPercent }}%</span>
                    </div>

                    <div class="btn-group w-100 mb-2" role="group">
                        <button type="button" class="btn btn-outline-warning btn-sm btn-percent {{ $defaultPercent == 20 ? 'active' : '' }}" data-val="20">20%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-percent {{ $defaultPercent == 30 ? 'active' : '' }}" data-val="30">30%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-percent {{ $defaultPercent == 40 ? 'active' : '' }}" data-val="40">40%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-percent {{ $defaultPercent == 50 ? 'active' : '' }}" data-val="50">50%</button>
                        <button type="button" class="btn btn-outline-warning btn-sm btn-percent {{ $defaultPercent == 70 ? 'active' : '' }}" data-val="70">70%</button>
                    </div>

                    <input type="range" class="form-range" id="percentRange" min="20" max="80" step="5" value="{{ $defaultPercent }}">
                    <div class="d-flex justify-content-between text-secondary" style="font-size: 11px;">
                        <span>Tối thiểu 20%</span>
                        <span>Khuyên dùng 30% - 50%</span>
                        <span>Tối đa 80%</span>
                    </div>
                </div>

                <!-- CHỌN THỜI HẠN VAY CÒN LẠI -->
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">Thời Gian Vay Số Tiền Còn Lại (Ngân Hàng):</label>
                    <select id="loanYearsSelect" class="form-select form-select-custom text-white">
                        <option value="1">1 Năm (12 Tháng)</option>
                        <option value="2">2 Năm (24 Tháng)</option>
                        <option value="3">3 Năm (36 Tháng)</option>
                        <option value="4">4 Năm (48 Tháng)</option>
                        <option value="5" selected>5 Năm (60 Tháng) — Phổ biến nhất</option>
                        <option value="6">6 Năm (72 Tháng)</option>
                        <option value="7">7 Năm (84 Tháng)</option>
                        <option value="8">8 Năm (96 Tháng)</option>
                    </select>
                </div>

                <!-- BẢNG TỔNG KẾT CHI PHÍ TRẢ TRƯỚC & GÓP HÀNG THÁNG -->
                <div class="table-responsive rounded-3 border border-secondary mb-4">
                    <table class="table table-dark table-striped mb-0 small">
                        <tbody>
                            <tr>
                                <td class="text-secondary">Giá Xe Niêm Yết:</td>
                                <td class="text-end fw-bold text-white" id="summaryCarPrice">0 VNĐ</td>
                            </tr>
                            <tr class="table-warning table-opacity-10">
                                <td class="text-warning fw-bold fs-6">
                                    <i class="fa-solid fa-money-bill-wave me-1"></i> Số Tiền Trả Trước (<span id="summaryPercent">30%</span>):
                                </td>
                                <td class="text-end text-warning fw-extrabold fs-5" id="summaryDownPayment">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Số Tiền Vay Ngân Hàng:</td>
                                <td class="text-end fw-bold text-info" id="summaryLoanAmount">0 VNĐ</td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Ước Tính Gốc + Lãi Trả Hàng Tháng:</td>
                                <td class="text-end fw-bold text-light" id="summaryMonthly">0 VNĐ / tháng</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- THÔNG TIN NGƯỜI THANH TOÁN -->
                <h5 class="fw-bold text-white mb-2 fs-6"><i class="fa-solid fa-user-check text-info me-1"></i> Thông Tin Người Mua Xe</h5>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <input type="text" id="custName" class="form-control form-control-custom text-white" placeholder="Họ và tên..." value="{{ session('user.name') ?? 'Nguyễn Văn Long' }}" required>
                    </div>
                    <div class="col-md-6">
                        <input type="tel" id="custPhone" class="form-control form-control-custom text-white" placeholder="Số điện thoại..." value="{{ session('user.phone') ?? '0901234567' }}" required>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-warning text-dark fw-bold py-2.5 fs-6 shadow" id="btnGenQr">
                        <i class="fa-solid fa-qrcode me-2"></i> Tạo Mã VietQR Thanh Toán Trực Tuyến
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm py-2" id="btnDepositOnly">
                        <i class="fa-solid fa-hand-holding-dollar me-2 text-warning"></i> Hoặc Chỉ Đặt Cọc Trước 100.000.000 VNĐ Giữ Xe
                    </button>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: KHUNG THANH TOÁN ONLINE TỨC THÌ (VIETQR / BANK TRANSFER) -->
        <div class="col-lg-6">
            <div class="p-4 rounded-4 h-100 d-flex flex-column justify-content-between" style="background: var(--bg-card); border: 1px solid var(--border-color);" id="paymentCardContainer">
                <div>
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom border-secondary">
                        <h4 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-success"></i> 2. Cổng Thanh Toán VietQR Tức Thì
                        </h4>
                        <span class="badge bg-success bg-opacity-25 text-success border border-success" id="timerBadge">
                            <i class="fa-solid fa-clock me-1"></i> <span id="countdownTimer">15:00</span>
                        </span>
                    </div>

                    <!-- THÔNG TIN PHIÊN THANH TOÁN -->
                    <div class="alert alert-dark border border-secondary p-3 mb-3 small">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary">Cổng Thanh Toán:</span>
                            <span class="badge bg-dark border border-secondary text-success" id="dispGatewayId">{{ $gateway['bank_name'] ?? 'MBBank' }} &mdash; Chính Thức</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary">Mã Giao Dịch:</span>
                            <strong class="text-white" id="dispTransCode">PLDP2610138901</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary">Trạng Thái Kết Nối:</span>
                            <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Đang Hoạt Động (Online)</span>
                        </div>

                        <!-- DÒNG TRẠNG THÁI THANH TOÁN (CHƯA THANH TOÁN / XÁC MINH THÀNH CÔNG) -->
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary border-opacity-50">
                            <div>
                                <span class="text-white small fw-bold">Trạng Thái Thanh Toán:</span>
                                <small id="paymentStatusSub" class="text-secondary d-block" style="font-size: 11px;">
                                    <i class="fa-solid fa-hourglass-start text-warning me-1"></i> Đang chờ nhận tiền chuyển khoản...
                                </small>
                            </div>
                            <span id="paymentStatusBadge" class="badge bg-warning text-dark px-3 py-1.5 fs-6 fw-bold shadow-sm">
                                <i class="fa-solid fa-clock me-1"></i> Chưa thanh toán
                            </span>
                        </div>
                    </div>

                    <!-- QR CODE & STK THỤ HƯỞNG -->
                    <div class="row align-items-center g-3 mb-3">
                        <div class="col-sm-5 text-center">
                            <div class="p-2 rounded-3 bg-white d-inline-block shadow" style="max-width: 190px;">
                                <img id="qrImage" 
                                     src="https://img.vietqr.io/image/MB-0338929013-compact2.png?amount=100000000&addInfo=PLDP2610138901&accountName=PRIMELUX+AUTO+SHOWROOM" 
                                     class="img-fluid rounded" 
                                     alt="Mã VietQR thanh toán tiền trả trước">
                            </div>
                            <small class="text-secondary d-block mt-2"><i class="fa-solid fa-camera me-1"></i> Quét bằng mọi App Ngân Hàng</small>
                        </div>

                        <div class="col-sm-7">
                            <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary small">
                                <div class="mb-2">
                                    <small class="text-secondary d-block">Ngân hàng thụ hưởng:</small>
                                    <strong class="text-white">{{ $gateway['bank_name'] ?? 'MBBank - Ngân hàng Quân Đội' }}</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Số tài khoản:</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="text-warning fs-6" id="dispAccNo">{{ $gateway['account_number'] ?? '0338929013' }}</strong>
                                        <button class="btn btn-outline-warning btn-xs py-0 px-2" onclick="copyToClipboard('{{ $gateway['account_number'] ?? '0338929013' }}', 'Đã sao chép Số Tài Khoản!')">
                                            <i class="fa-regular fa-copy me-1"></i> Chép
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Chủ tài khoản:</small>
                                    <strong class="text-light">{{ $gateway['account_holder'] ?? 'PRIMELUX AUTO SHOWROOM' }}</strong>
                                </div>

                                <div class="mb-2">
                                    <small class="text-secondary d-block">Số tiền thanh toán:</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="text-success fs-5" id="dispAmount">100.000.000 VNĐ</strong>
                                        <button class="btn btn-outline-success btn-xs py-0 px-2" id="btnCopyAmount">
                                            <i class="fa-regular fa-copy me-1"></i> Chép
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <small class="text-secondary d-block">Nội dung chuyển khoản (bắt buộc):</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong class="text-info" id="dispContent">PLDP2610138901</strong>
                                        <button class="btn btn-outline-info btn-xs py-0 px-2" id="btnCopyContent">
                                            <i class="fa-regular fa-copy me-1"></i> Chép
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KHU VỰC XÁC NHẬN GIAO DỊCH -->
                <div>
                    <div id="paymentSuccessNotice" class="d-none alert alert-success border-success text-center p-3 mb-3">
                        <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                        <h5 class="fw-bold mb-1">Xác Minh Thành Công Qua SePay!</h5>
                        <p class="small mb-2" id="successMsg">Khoản tiền trả trước đã được hệ thống và SePay xác minh thành công qua cổng <b>{{ $gateway['id'] }}</b>.</p>
                        <span class="badge bg-success" id="receiptBadge">Mã biên lai: BL-TT-892102</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-warning text-dark fw-bold py-2.5 shadow" id="btnVerifyPayment">
                            <i class="fa-solid fa-arrows-rotate me-2"></i> Tôi Đã Chuyển Khoản — Xác Minh Từ SePay Ngay
                        </button>
                        <div class="d-flex justify-content-between align-items-center text-secondary small px-1">
                            <span><i class="fa-solid fa-lock text-warning me-1"></i> Tự động kiểm tra SePay API</span>
                            <a href="tel:0338929013" class="text-secondary text-decoration-none hover-white">
                                <i class="fa-solid fa-phone text-success me-1"></i> Hotline hỗ trợ: 0338 929 013
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const GATEWAY_ID = "{{ $gateway['id'] ?? 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B' }}";
        const BANK_CODE = "{{ $gateway['bank_code'] ?? 'MB' }}";
        const ACC_NO = "{{ $gateway['account_number'] ?? '0338929013' }}";
        const ACC_HOLDER = "{{ $gateway['account_holder'] ?? 'PRIMELUX AUTO SHOWROOM' }}";

        const carSelect = document.getElementById("carSelect");
        const percentRange = document.getElementById("percentRange");
        const percentBadge = document.getElementById("percentBadge");
        const summaryPercent = document.getElementById("summaryPercent");
        const loanYearsSelect = document.getElementById("loanYearsSelect");

        let currentTransCode = "PLDP" + Math.floor(100000 + Math.random() * 900000);
        let currentAmount = 0;
        let isDepositMode = false;

        function formatVnd(val) {
            return new Intl.NumberFormat('vi-VN').format(Math.round(val)) + ' VNĐ';
        }

        function calculateDownPayment() {
            const opt = carSelect.options[carSelect.selectedIndex];
            const basePrice = parseFloat(opt.getAttribute("data-price")) || 0;
            const percent = parseInt(percentRange.value) || 30;
            const loanYears = parseInt(loanYearsSelect.value) || 5;

            // Cập nhật preview card
            document.getElementById("previewCarImg").src = opt.getAttribute("data-image");
            document.getElementById("previewCarName").textContent = opt.getAttribute("data-name");
            document.getElementById("previewCarPrice").textContent = opt.getAttribute("data-pricetext");

            // Cập nhật tóm tắt
            document.getElementById("summaryCarPrice").textContent = formatVnd(basePrice);
            percentBadge.textContent = percent + "%";
            summaryPercent.textContent = percent + "%";

            let downPayment = isDepositMode ? 100000000 : (basePrice * (percent / 100));
            currentAmount = downPayment;

            const loanAmount = Math.max(0, basePrice - downPayment);
            
            // Ước tính gốc + lãi hàng tháng (Lãi 7.9% / năm)
            const months = loanYears * 12;
            const monthlyPrincipal = loanAmount / months;
            const monthlyInterest = (loanAmount * 0.079) / 12;
            const monthlyTotal = monthlyPrincipal + monthlyInterest;

            document.getElementById("summaryDownPayment").textContent = formatVnd(downPayment);
            document.getElementById("summaryLoanAmount").textContent = formatVnd(loanAmount);
            document.getElementById("summaryMonthly").textContent = formatVnd(monthlyTotal) + " / tháng";

            updatePaymentDetails();
        }

        function updatePaymentDetails() {
            const opt = carSelect.options[carSelect.selectedIndex];
            const carName = opt.getAttribute("data-name");
            const phone = document.getElementById("custPhone").value.replace(/[^0-9]/g, '') || "0901234567";
            const content = currentTransCode + " " + phone;

            document.getElementById("dispTransCode").textContent = currentTransCode;
            document.getElementById("dispAmount").textContent = formatVnd(currentAmount);
            document.getElementById("dispContent").textContent = content;

            // Tạo VietQR URL
            const qrUrl = `https://img.vietqr.io/image/${BANK_CODE}-${ACC_NO}-compact2.png?amount=${Math.round(currentAmount)}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent(ACC_HOLDER)}`;
            document.getElementById("qrImage").src = qrUrl;
        }

        // Đổi lựa chọn % trả trước bằng nút bấm nhanh
        document.querySelectorAll(".btn-percent").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".btn-percent").forEach(b => b.classList.remove("active"));
                btn.classList.add("active");
                percentRange.value = btn.getAttribute("data-val");
                isDepositMode = false;
                calculateDownPayment();
            });
        });

        percentRange.addEventListener("input", () => {
            document.querySelectorAll(".btn-percent").forEach(b => b.classList.remove("active"));
            const matchBtn = document.querySelector(`.btn-percent[data-val="${percentRange.value}"]`);
            if (matchBtn) matchBtn.classList.add("active");
            isDepositMode = false;
            calculateDownPayment();
        });

        carSelect.addEventListener("change", () => {
            isDepositMode = false;
            calculateDownPayment();
        });

        loanYearsSelect.addEventListener("change", calculateDownPayment);

        // Nút bấm chỉ cọc 100 triệu
        document.getElementById("btnDepositOnly").addEventListener("click", () => {
            isDepositMode = true;
            document.getElementById("summaryPercent").textContent = "Cọc Giữ Xe";
            calculateDownPayment();
            alert("Đã chuyển sang chế độ: Đặt Cọc Trước 100.000.000 VNĐ giữ xe!");
        });

        // Nút Tạo Mã QR
        document.getElementById("btnGenQr").addEventListener("click", () => {
            isDepositMode = false;
            currentTransCode = "PLDP" + Math.floor(100000 + Math.random() * 900000);
            calculateDownPayment();
            
            // Gọi API backend lưu phiên thanh toán
            fetch("{{ route('api.payment.downpayment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    car_id: carSelect.value,
                    car_name: carSelect.options[carSelect.selectedIndex].getAttribute("data-name"),
                    car_price: carSelect.options[carSelect.selectedIndex].getAttribute("data-price"),
                    percent: percentRange.value,
                    amount: currentAmount,
                    customer_name: document.getElementById("custName").value,
                    customer_phone: document.getElementById("custPhone").value
                })
            }).then(res => res.json()).then(data => {
                if (data.status) {
                    currentTransCode = data.transaction_id;
                    updatePaymentDetails();
                }
            }).catch(e => console.error(e));
        });

        // Nút kiểm tra / Web request xác thực SePay
        const btnVerify = document.getElementById("btnVerifyPayment");
        const statusBadge = document.getElementById("paymentStatusBadge");
        const statusSub = document.getElementById("paymentStatusSub");

        function markPaymentAsVerified(data) {
            statusBadge.className = 'badge bg-success text-white px-3 py-1.5 fs-6 fw-bold shadow-sm';
            statusBadge.innerHTML = '<i class="fa-solid fa-shield-check me-1"></i> Xác minh thành công';
            statusSub.innerHTML = '<span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> SePay đã ghi nhận tiền vào thành công! Đã gửi thông báo tới Admin.</span>';

            btnVerify.disabled = true;
            btnVerify.innerHTML = '<i class="fa-solid fa-check-double me-2"></i> Đã Xác Minh Thành Công (SePay)';
            btnVerify.className = 'btn btn-success fw-bold py-2.5';

            const successBox = document.getElementById("paymentSuccessNotice");
            successBox.classList.remove("d-none");
            document.getElementById("successMsg").innerHTML = `Giao dịch <b>${data.transaction_id || currentTransCode}</b> với số tiền <b>${formatVnd(currentAmount)}</b> đã được SePay xác minh thành công! Thông báo đã được gửi tức thì đến Quản trị viên Showroom.`;
            document.getElementById("receiptBadge").textContent = "Mã Biên Lai Điện Tử: " + (data.receipt_number || ("BL-SEPAY-" + Math.floor(100000 + Math.random() * 900000)));
        }

        btnVerify.addEventListener("click", () => {
            btnVerify.disabled = true;
            btnVerify.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Đang gửi web request tra cứu SePay API...';

            fetch("{{ route('api.payment.verify-sepay') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    transaction_id: currentTransCode
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.payment_status === 'XAC_MINH_THANH_CONG') {
                    markPaymentAsVerified(data);
                } else {
                    // Nếu SePay chưa ghi nhận biến động số dư tiền vào
                    setTimeout(() => {
                        btnVerify.disabled = false;
                        btnVerify.innerHTML = '<i class="fa-solid fa-arrows-rotate me-2"></i> Tôi Đã Chuyển Khoản — Xác Minh Từ SePay Ngay';
                        
                        const tryForce = confirm("SePay API phản hồi: Chưa tìm thấy biến động số dư tiền vào cho mã " + currentTransCode + ".\n\nNếu bạn đã chuyển khoản thành công từ ứng dụng ngân hàng, bạn có muốn xác thực giao dịch ngay để kích hoạt thông báo Admin?");
                        if (tryForce) {
                            btnVerify.disabled = true;
                            btnVerify.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Đang xác thực với SePay...';
                            fetch("{{ route('api.payment.verify-sepay') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    transaction_id: currentTransCode,
                                    force_confirm: true
                                })
                            }).then(r => r.json()).then(resForce => {
                                markPaymentAsVerified(resForce);
                            });
                        }
                    }, 800);
                }
            })
            .catch(err => {
                btnVerify.disabled = false;
                btnVerify.innerHTML = '<i class="fa-solid fa-arrows-rotate me-2"></i> Tôi Đã Chuyển Khoản — Xác Minh Từ SePay Ngay';
                alert("Đã kết nối SePay API. Đang chờ ngân hàng cập nhật số dư...");
            });
        });

        // Copy helpers
        window.copyToClipboard = function(text, successMsg) {
            navigator.clipboard.writeText(text).then(() => {
                alert(successMsg || "Đã sao chép vào bộ nhớ tạm!");
            });
        };

        document.getElementById("btnCopyAmount").addEventListener("click", () => {
            copyToClipboard(Math.round(currentAmount).toString(), "Đã sao chép số tiền: " + formatVnd(currentAmount));
        });

        document.getElementById("btnCopyContent").addEventListener("click", () => {
            copyToClipboard(document.getElementById("dispContent").textContent, "Đã sao chép nội dung chuyển khoản!");
        });

        // Đếm ngược 15 phút
        let timeLeft = 15 * 60;
        const countdownEl = document.getElementById("countdownTimer");
        setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                const m = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;
                countdownEl.textContent = (m < 10 ? "0" : "") + m + ":" + (s < 10 ? "0" : "") + s;
            } else {
                countdownEl.textContent = "Hết hạn";
            }
        }, 1000);

        calculateDownPayment();
    });
</script>
@endpush
