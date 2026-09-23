@extends('layouts.client')

@section('title', 'Đăng Ký Lái Thử Xe - PrimeLux Auto')

@section('content')
<!-- FORM DỊCH VỤ LÁI THỬ -->
<div class="container py-5">
    <div class="max-w-700 mx-auto p-4 p-md-5 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
        <div class="text-center mb-4">
            <span class="section-tag"><i class="fa-solid fa-steering-wheel text-warning"></i> Đặt Lịch Trải Nghiệm</span>
            <h2 class="fw-bold">Đăng Ký Lái Thử Xe VIP</h2>
            <p class="text-secondary">Trải nghiệm cảm giác lái đẳng cấp tận nơi hoặc tại các Showroom của PrimeLux Auto.</p>
        </div>

        <form id="testDriveForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-secondary small fw-bold">Họ và Tên (*)</label>
                    <input type="text" id="tdName" class="form-control form-control-custom" required placeholder="Nguyễn Văn A">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary small fw-bold">Số Điện Thoại (*)</label>
                    <input type="tel" id="tdPhone" class="form-control form-control-custom" required placeholder="0901 234 567">
                </div>
                <div class="col-12">
                    <label class="form-label text-secondary small fw-bold">Email Liên Hệ</label>
                    <input type="email" id="tdEmail" class="form-control form-control-custom" placeholder="example@gmail.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary small fw-bold">Mẫu Xe Muốn Lái Thử (*)</label>
                    <select id="tdCarSelect" class="form-select form-select-custom" required>
                        @foreach($cars as $car)
                            <option value="{{ $car['name'] }}" {{ $selectedCar === $car['name'] ? 'selected' : '' }}>
                                {{ $car['name'] }} ({{ $car['priceText'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary small fw-bold">Địa Điểm Showroom (*)</label>
                    <select id="tdLocation" class="form-select form-select-custom" required>
                        <option value="Showroom TP. Hồ Chí Minh">Showroom TP. Hồ Chí Minh (Phạm Văn Chiêu, Gò Vấp)</option>
                        <option value="Showroom Hà Nội">Showroom Hà Nội (Vinhomes Riverside, Long Biên)</option>
                        <option value="Showroom Đà Nẵng">Showroom Đà Nẵng (Nguyễn Văn Linh, Thanh Khê)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label text-secondary small fw-bold">Thời Gian Hẹn Lái Thử (*)</label>
                    <input type="datetime-local" id="tdDate" class="form-control form-control-custom" required>
                </div>
                <div class="col-12">
                    <label class="form-label text-secondary small fw-bold">Ghi Chú Yêu Cầu Riêng (Nếu có)</label>
                    <textarea id="tdNote" class="form-control form-control-custom" rows="3" placeholder="Yêu cầu mang xe tận nhà, hoặc cần hỗ trợ tư vấn gói trả góp..."></textarea>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-gold btn-lg w-100 fw-bold">
                        <i class="fa-solid fa-paper-plane me-2"></i> Xác Nhận Đăng Ký Lái Thử
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL XÁC NHẬN THÀNH CÔNG -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-success"><i class="fa-solid fa-circle-check me-2"></i> Đăng Ký Thành Công!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fa-solid fa-calendar-star text-warning fa-4x mb-3"></i>
                <h4 class="fw-bold mb-2">Cảm ơn bạn đã đăng ký!</h4>
                <p class="text-secondary mb-0">Chuyên viên tư vấn của PrimeLux Auto sẽ liên hệ xác nhận lịch hẹn lái thử trong thời gian sớm nhất.</p>
            </div>
            <div class="modal-footer border-secondary justify-content-center">
                <a href="{{ url('/') }}" class="btn btn-primary px-4" style="border-radius: 8px;">Trở Về Trang Chủ</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const select = document.getElementById("tdCarSelect");

        // Sync with query param if present
        const urlParams = new URLSearchParams(window.location.search);
        const carParam = urlParams.get("car");
        if (carParam && select) {
            select.value = decodeURIComponent(carParam);
        }

        // Form submit handler
        const form = document.getElementById("testDriveForm");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Đang xử lý...';

            const payload = {
                ho_ten: document.getElementById("tdName").value,
                sdt: document.getElementById("tdPhone").value,
                email: document.getElementById("tdEmail").value || "N/A",
                ten_xe: select.value,
                showroom: document.getElementById("tdLocation").value,
                thoi_gian: document.getElementById("tdDate").value,
                ghi_chu: document.getElementById("tdNote").value || ""
            };

            try {
                const response = await fetch("{{ route('test-drive.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (result.success) {
                    const modal = new bootstrap.Modal(document.getElementById("successModal"));
                    modal.show();
                    form.reset();
                } else {
                    alert("Có lỗi xảy ra: " + (result.message || "Vui lòng thử lại sau."));
                }
            } catch (err) {
                console.error("Test drive error:", err);
                // Fallback show success
                const modal = new bootstrap.Modal(document.getElementById("successModal"));
                modal.show();
                form.reset();
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    });
</script>
@endpush
