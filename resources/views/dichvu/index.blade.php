@extends('layouts.giaodien')

@section('title', 'Trung Tâm Dịch Vụ & Cứu Hộ Ô Tô Cao Cấp - PrimeLux Auto')
@section('meta_description', 'Trung tâm dịch vụ bảo dưỡng định kỳ, bảo hiểm thân vỏ, sơn hấp tiêu chuẩn Đức và cứu hộ khẩn cấp 24/7 tại Showroom PrimeLux Auto.')

@push('styles')
<style>
    /* PRIMELUX STREAMLINED LUXURY SERVICE STYLING */
    .service-hero {
        background: linear-gradient(135deg, rgba(10, 15, 29, 0.95), rgba(18, 24, 43, 0.88)),
                    url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 60px 0 50px;
        color: #ffffff;
        border-bottom: 2px solid rgba(212, 175, 55, 0.4);
    }

    .gold-accent {
        color: #d4af37;
    }

    .service-nav-tabs {
        background: #0f172a;
        border-radius: 50px;
        padding: 6px;
        display: flex;
        gap: 8px;
        overflow-x: auto;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .service-nav-tabs .nav-link {
        color: #94a3b8;
        border-radius: 40px;
        padding: 10px 20px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.3s ease;
        border: none;
    }

    .service-nav-tabs .nav-link.active,
    .service-nav-tabs .nav-link:hover {
        background: linear-gradient(135deg, #d4af37, #f39c12);
        color: #0b0f19;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .service-card {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
        border-color: rgba(212, 175, 55, 0.5);
    }

    .service-img-wrapper {
        position: relative;
        height: 200px;
        background: #0f172a;
        overflow: hidden;
    }

    .service-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .service-card:hover .service-img-wrapper img {
        transform: scale(1.06);
    }

    .service-badge-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .sos-banner {
        background: linear-gradient(135deg, #7f1d1d, #b91c1c);
        border-radius: 18px;
        padding: 30px;
        border: 2px solid #ef4444;
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
    }

    .lookup-card {
        background: #0f172a;
        border-radius: 18px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        padding: 24px;
    }

    .modal-content-dark {
        background: #0f172a;
        color: #ffffff;
        border: 1px solid rgba(212, 175, 55, 0.4);
    }

    .modal-content-dark .form-control,
    .modal-content-dark .form-select {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .modal-content-dark .form-control:focus,
    .modal-content-dark .form-select:focus {
        border-color: #d4af37;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }
</style>
@endpush

@section('content')
<!-- HERO BANNER TINH GỌN -->
<section class="service-hero text-center">
    <div class="container">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
            <i class="fa-solid fa-crown me-1"></i> PrimeLux Premium Automotive Care
        </span>
        <h1 class="display-5 fw-bold text-white mb-2">
            CENTRAL <span class="gold-accent">SERVICE & RESCUE</span>
        </h1>
        <p class="text-light mx-auto mb-3" style="max-width: 650px;">
            Trung tâm chăm sóc, bảo dưỡng kỹ thuật số & cứu hộ giao thông 24/7 chuyên nghiệp cho các dòng xe cao cấp.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-2.5">
            <button class="btn btn-warning rounded-pill px-4 py-2.5 fw-bold text-dark shadow" data-bs-toggle="modal" data-bs-target="#bookingModal">
                <i class="fa-solid fa-calendar-check me-1.5"></i> Đặt Lịch Bảo Dưỡng
            </button>
            <button class="btn btn-danger rounded-pill px-4 py-2.5 fw-bold shadow" data-bs-toggle="modal" data-bs-target="#sosModal">
                <i class="fa-solid fa-truck-medical me-1.5"></i> Cứu Hộ SOS 24/7
            </button>
            <a href="#tra-cuu" class="btn btn-outline-light rounded-pill px-4 py-2.5 fw-bold">
                <i class="fa-solid fa-magnifying-glass me-1.5"></i> Tra Cứu Tiến Độ
            </a>
        </div>
    </div>
</section>

<!-- MAIN NAVIGATION TABS -->
<div class="container py-3">
    <ul class="nav service-nav-tabs justify-content-center" id="serviceTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="bao-tri-tab" data-bs-toggle="tab" data-bs-target="#tab-bao-tri">
                <i class="fa-solid fa-oil-can me-1.5"></i> Bảo Trì Định Kỳ
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="bao-hiem-tab" data-bs-toggle="tab" data-bs-target="#tab-bao-hiem">
                <i class="fa-solid fa-shield-halved me-1.5"></i> Bảo Hiểm & Bảo Hành
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="cuu-ho-tab" data-bs-toggle="tab" data-bs-target="#tab-cuu-ho">
                <i class="fa-solid fa-truck-medical me-1.5 text-danger"></i> Cứu Hộ 24/7
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="sua-chua-tab" data-bs-toggle="tab" data-bs-target="#tab-sua-chua">
                <i class="fa-solid fa-wrench me-1.5"></i> Sửa Chữa & Sơn Hấp
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="uu-dai-tab" data-bs-toggle="tab" data-bs-target="#tab-uu-dai">
                <i class="fa-solid fa-gift me-1.5 text-warning"></i> Ưu Đãi VIP
            </button>
        </li>
    </ul>
</div>

<!-- CONTAINER NỘI DUNG CÁC TAB -->
<div class="container pb-5">
    <div class="tab-content" id="serviceTabsContent">

        <!-- TAB 1: BẢO TRÌ ĐỊNH KỲ -->
        <div class="tab-pane fade show active" id="tab-bao-tri" role="tabpanel">
            <div class="row g-4 my-2">
                @foreach($baoTri as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-img-wrapper">
                            <img src="{{ $item->hinh_anh }}" alt="{{ $item->ten_dv }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?auto=format&fit=crop&w=800&q=80';">
                            <span class="service-badge-tag {{ $item->loai_dv_badge['class'] }}">
                                {{ $item->ten_loai_dv }}
                            </span>
                        </div>
                        <div class="p-3.5 d-flex flex-column flex-grow-1">
                            <h5 class="fw-bold text-white mb-1 fs-6">{{ $item->ten_dv }}</h5>
                            <p class="text-warning small mb-2"><i class="fa-solid fa-star me-1"></i> {{ $item->tieu_de }}</p>
                            <p class="text-secondary small mb-3 flex-grow-1">{{ $item->mo_ta }}</p>

                            @if($item->quy_trinh)
                            <div class="bg-dark p-2 rounded text-light small mb-3">
                                {!! nl2br(e($item->quy_trinh)) !!}
                            </div>
                            @endif

                            <div class="border-top border-secondary pt-2.5 d-flex align-items-center justify-content-between mt-auto">
                                <div>
                                    <span class="text-secondary small d-block">Giá từ</span>
                                    <span class="fs-6 fw-bold gold-accent">{{ number_format($item->gia_tham_khao) }} VNĐ</span>
                                </div>
                                <button class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark"
                                        onclick="openBookingWithService('{{ $item->ten_loai_dv }}', '{{ $item->ten_dv }}')">
                                    Chọn Đặt Lịch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 2: BẢO HIỂM & BẢO HÀNH -->
        <div class="tab-pane fade" id="tab-bao-hiem" role="tabpanel">
            <div class="row g-4 my-2">
                @foreach($baoHiem as $item)
                <div class="col-lg-6">
                    <div class="service-card p-3.5">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <div class="service-img-wrapper rounded-3">
                                    <img src="{{ $item->hinh_anh }}" class="img-fluid rounded-3 h-100 object-fit-cover" alt="{{ $item->ten_dv }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=800&q=80';">
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-column">
                                <span class="badge bg-info text-dark mb-2" style="width: max-content;">{{ $item->ten_loai_dv }}</span>
                                <h5 class="fw-bold text-white mb-1 fs-6">{{ $item->ten_dv }}</h5>
                                <p class="text-secondary small mb-2">{{ $item->mo_ta }}</p>
                                <div class="fs-6 fw-bold text-info mb-3">{{ number_format($item->gia_tham_khao) }} VNĐ</div>
                                <button class="btn btn-info btn-sm text-dark fw-bold rounded-pill px-3 w-fit-content"
                                        onclick="openBookingWithService('{{ $item->ten_loai_dv }}', '{{ $item->ten_dv }}')">
                                    Đăng Ký Tư Vấn
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 3: HỖ TRỢ & CỨU HỘ 24/7 -->
        <div class="tab-pane fade" id="tab-cuu-ho" role="tabpanel">
            <div class="sos-banner text-white my-3">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-danger fw-bold text-uppercase px-2.5 py-1 mb-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Emergency SOS
                        </span>
                        <h3 class="fw-bold mb-2">CỨU HỘ GIAO THÔNG CHUYÊN DỤNG 24/7</h3>
                        <p class="mb-3 small">
                            Xe sàn trượt phẳng nghiêng 100%, bảo vệ an toàn gầm xe thấp. Có mặt ngay trong 30 phút.
                        </p>
                        <div class="d-flex flex-wrap gap-2.5">
                            <a href="tel:0338929013" class="btn btn-light rounded-pill fw-bold text-danger px-3.5">
                                <i class="fa-solid fa-phone-volume me-1.5"></i> HOTLINE SOS: 0338 929 013
                            </a>
                            <button class="btn btn-dark rounded-pill fw-bold border-white px-3.5" data-bs-toggle="modal" data-bs-target="#sosModal">
                                <i class="fa-solid fa-location-crosshairs me-1.5"></i> GỬI VỊ TRÍ SOS
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center mt-3 mt-lg-0">
                        <i class="fa-solid fa-truck-medical text-white" style="font-size: 6rem; opacity: 0.9;"></i>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-1">
                @foreach($cuuHo as $item)
                <div class="col-md-6">
                    <div class="service-card p-3.5">
                        <h5 class="fw-bold text-white mb-1 fs-6"><i class="fa-solid fa-truck-pickup text-danger me-1.5"></i> {{ $item->ten_dv }}</h5>
                        <p class="text-secondary small mb-2">{{ $item->mo_ta }}</p>
                        <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-2.5 mt-auto">
                            <span class="gold-accent fw-bold small">{{ $item->gia_tham_khao > 0 ? number_format($item->gia_tham_khao) . ' VNĐ' : 'Miễn phí cho VIP' }}</span>
                            <button class="btn btn-danger btn-sm rounded-pill fw-bold px-3" data-bs-toggle="modal" data-bs-target="#sosModal">
                                Gọi Cứu Hộ
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 4: SỬA CHỮA & SƠN HẤP -->
        <div class="tab-pane fade" id="tab-sua-chua" role="tabpanel">
            <div class="row g-4 my-2">
                @foreach($suaChua as $item)
                <div class="col-lg-6">
                    <div class="service-card p-3.5">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <div class="service-img-wrapper rounded-3">
                                    <img src="{{ $item->hinh_anh }}" class="img-fluid rounded-3 h-100 object-fit-cover" alt="{{ $item->ten_dv }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=800&q=80';">
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-column">
                                <h5 class="fw-bold text-white mb-1 fs-6">{{ $item->ten_dv }}</h5>
                                <p class="text-secondary small mb-2">{{ $item->mo_ta }}</p>
                                <div class="gold-accent fw-bold mb-3">{{ number_format($item->gia_tham_khao) }} VNĐ</div>
                                <button class="btn btn-warning btn-sm text-dark fw-bold rounded-pill px-3 w-fit-content"
                                        onclick="openBookingWithService('Sửa Chữa', '{{ $item->ten_dv }}')">
                                    Đặt Lịch Sửa Chữa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 5: ƯU ĐÃI KHÁCH HÀNG VIP -->
        <div class="tab-pane fade" id="tab-uu-dai" role="tabpanel">
            <div class="row g-4 my-2">
                @foreach($uuDai as $item)
                <div class="col-lg-6">
                    <div class="service-card p-3.5 border-success">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <div class="service-img-wrapper rounded-3">
                                    <img src="{{ $item->hinh_anh }}" class="img-fluid rounded-3 h-100 object-fit-cover" alt="{{ $item->ten_dv }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800&q=80';">
                                    <span class="service-badge-tag bg-success text-white">
                                        <i class="fa-solid fa-gift me-1"></i> Ưu Đãi VIP
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-column">
                                <div class="d-flex align-items-center gap-2 mb-1.5">
                                    <span class="badge bg-success text-uppercase small">{{ $item->tieu_de }}</span>
                                </div>
                                <h5 class="fw-bold text-white mb-1 fs-6">{{ $item->ten_dv }}</h5>
                                <p class="text-secondary small mb-3">{{ $item->mo_ta }}</p>
                                <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-2.5 mt-auto">
                                    <span class="text-success fw-bold small"><i class="fa-solid fa-crown me-1"></i> Đặc Quyền VIP</span>
                                    <button class="btn btn-success btn-sm rounded-pill fw-bold px-3" onclick="openBookingWithService('Ưu Đãi Khách Hàng', '{{ $item->ten_dv }}')">
                                        Nhận Ưu Đãi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<!-- SECTION TRA CỨU TRẠNG THÁI -->
<section id="tra-cuu" class="py-4" style="background: #0b0f19;">
    <div class="container">
        <div class="lookup-card">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h4 class="fw-bold text-white mb-1 fs-5">
                        <i class="fa-solid fa-clock-rotate-left gold-accent me-2"></i> TRA CỨU TRẠNG THÁI HỒ SƠ DỊCH VỤ
                    </h4>
                    <p class="text-secondary small mb-3">Nhập Số điện thoại hoặc Mã đặt lịch (VD: SER-2026-001) để kiểm tra tiến độ.</p>

                    <form id="lookupForm" class="d-flex gap-2">
                        <input type="text" id="lookupQuery" class="form-control rounded-pill" placeholder="Nhập Mã lịch hoặc SĐT..." required>
                        <button type="submit" class="btn btn-warning rounded-pill px-3.5 fw-bold text-dark text-nowrap">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Tra Cứu
                        </button>
                    </form>
                </div>
                <div class="col-lg-6 mt-3 mt-lg-0">
                    <div id="lookupResult" class="p-3 rounded-3" style="background: rgba(255,255,255,0.03); min-height: 120px;">
                        <div class="text-center text-secondary py-3 small">
                            <i class="fa-solid fa-receipt fs-2 mb-1 d-block opacity-50"></i>
                            Kết quả tra cứu sẽ hiển thị tại đây.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION SỔ BẢO HÀNH ĐIỆN TỬ THEO SỐ KHUNG VIN (E-WARRANTY BY VIN) -->
<section id="so-bao-hanh" class="py-5" style="background: radial-gradient(circle at 10% 50%, rgba(212, 175, 55, 0.08) 0%, rgba(11, 15, 25, 0.98) 70%); border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold rounded-pill text-uppercase mb-2">
                    <i class="fa-solid fa-certificate me-1"></i> PrimeLux Digital E-Warranty
                </span>
                <h3 class="fw-bold text-white mb-2">
                    Sổ Bảo Hành Điện Tử & Lịch Sử Bảo Dưỡng Theo Số Khung (VIN)
                </h3>
                <p class="text-secondary small mb-0">
                    Tra cứu tức thì toàn bộ lịch sử các lần bảo dưỡng định kỳ (5.000km, 10.000km, 20.000km...), các hạng mục phụ tùng chính hãng đã thay thế và thời hạn bảo hành còn lại của chiếc xe.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="small text-secondary mb-1">Thử nhanh với xe mẫu có sẵn:</div>
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="quickVinSearch('WBA53BJ04RFP98124')">
                        Maybach S 680
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="quickVinSearch('WP0ZZZ99ZTS182931')">
                        Porsche 911 GT3
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" onclick="quickVinSearch('51K-888.88')">
                        Biển 51K-888.88
                    </button>
                </div>
            </div>
        </div>

        <!-- FORM TRA CỨU VIN -->
        <div class="p-4 rounded-4 mb-4" style="background: #131b2e; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);">
            <form id="vinLookupForm" class="row g-3 align-items-center">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-warning">
                            <i class="fa-solid fa-barcode fs-5"></i>
                        </span>
                        <input type="text" id="vinInput" class="form-control bg-dark border-secondary text-white text-uppercase py-2.5 fs-6" 
                               placeholder="Nhập 17 ký tự Số Khung (VIN) hoặc Biển Số Xe (VD: WBA53BJ04RFP98124 hoặc 51K-888.88)..." required>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2.5 shadow rounded-3">
                        <i class="fa-solid fa-shield-halved me-1"></i> Tra Cứu Bảo Hành VIN
                    </button>
                </div>
            </form>
        </div>

        <!-- KẾT QUẢ SỔ BẢO HÀNH VIN (DYNAMIC RESULT CONTAINER) -->
        <div id="vinResultContainer" class="d-none">
            <!-- Rendered by JS -->
        </div>
    </div>
</section>

<!-- MODAL ĐẶT LỊCH DỊCH VỤ -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold gold-accent"><i class="fa-solid fa-calendar-plus me-2"></i> ĐẶT LỊCH DỊCH VỤ BẢO TRÌ & SỬA CHỮA</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookingForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-light fw-bold small">Họ và Tên (*)</label>
                            <input type="text" name="ho_ten" class="form-control" value="{{ $currentUser['name'] ?? '' }}" placeholder="Nhập họ tên" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light fw-bold small">Số Điện Thoại (*)</label>
                            <input type="tel" name="sdt" class="form-control" value="{{ $currentUser['phone'] ?? '' }}" placeholder="VD: 0901234567" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light small">Email Liên Hệ</label>
                            <input type="email" name="email" class="form-control" value="{{ $currentUser['email'] ?? '' }}" placeholder="name@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light small">Biển Số Xe</label>
                            <input type="text" name="bien_so" class="form-control text-uppercase" placeholder="VD: 51K-888.88">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light fw-bold small">Dòng Xe</label>
                            <select name="ten_xe" class="form-select">
                                <option value="PrimeLux Luxury Sedan">PrimeLux Luxury Sedan</option>
                                <option value="Porsche Taycan Turbo S">Porsche Taycan Turbo S</option>
                                <option value="BMW 7 Series">BMW 7 Series</option>
                                <option value="Audi e-tron GT">Audi e-tron GT</option>
                                <option value="Range Rover Autobiography">Range Rover Autobiography</option>
                                <option value="Lexus LX 600">Lexus LX 600</option>
                                <option value="Khác">Dòng Xe Khác</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light fw-bold small">Loại Dịch Vụ (*)</label>
                            <select name="loai_dich_vu" id="modalLoaiDichVu" class="form-select" required>
                                <option value="Bảo Trì Định Kỳ">Bảo Trì Định Kỳ</option>
                                <option value="Bảo Hiểm Thân Vỏ">Bảo Hiểm Thân Vỏ & Bảo Hành</option>
                                <option value="Sửa Chữa & Sơn Hấp">Sửa Chữa & Sơn Hấp</option>
                                <option value="Ưu Đãi Khách Hàng">Ưu Đãi Khách Hàng VIP</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light small">Tên Gói Dịch Vụ Cụ Thể</label>
                            <input type="text" name="ten_dich_vu_cu_the" id="modalTenDichVuCuThe" class="form-control" placeholder="Gói dịch vụ chi tiết">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light fw-bold small">Showroom (*)</label>
                            <select name="showroom" class="form-select" required>
                                <option value="Showroom TP. Hồ Chí Minh (Phạm Văn Chiêu)">Showroom TP. Hồ Chí Minh (Phạm Văn Chiêu)</option>
                                <option value="Showroom Hà Nội (Vinhomes Riverside)">Showroom Hà Nội (Vinhomes Riverside)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-light fw-bold small">Thời Gian Hẹn (*)</label>
                            <input type="datetime-local" name="thoi_gian_hen" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-light small">Ghi Chú Yêu Cầu</label>
                            <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ghi chú chi tiết cho Kỹ thuật viên..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4">XÁC NHẬN ĐẶT LỊCH</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL CỨU HỘ KHẨN CẤP SOS 24/7 -->
<div class="modal fade" id="sosModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-dark border-danger">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i> YÊU CẦU CỨU HỘ SOS 24/7</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="sosForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-light fw-bold small">Họ và Tên (*)</label>
                        <input type="text" name="ho_ten" class="form-control" value="{{ $currentUser['name'] ?? '' }}" placeholder="Nhập tên người liên hệ" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light fw-bold small">Số Điện Thoại Khẩn (*)</label>
                        <input type="tel" name="sdt" class="form-control" value="{{ $currentUser['phone'] ?? '' }}" placeholder="VD: 0901234567" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light small">Biển Số Xe & Dòng Xe</label>
                        <input type="text" name="bien_so" class="form-control" placeholder="VD: 51K-888.88">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light fw-bold small">Vị Trí Cứu Hộ Hiện Tại (*)</label>
                        <input type="text" name="vi_tri_cuu_ho" class="form-control border-danger" placeholder="Địa chỉ hoặc mốc đường gần nhất..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light small">Mô Tả Sự Cố</label>
                        <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Nổ lốp, cạ gầm, hết điện..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger fw-bold rounded-pill px-4">GỬI YÊU CẦU SOS</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openBookingWithService(loaiDv, tenDv) {
        document.getElementById('modalLoaiDichVu').value = loaiDv;
        document.getElementById('modalTenDichVuCuThe').value = tenDv;
        var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        modal.show();
    }

    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        fetch("{{ route('dichvu.datlich') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
                if (window.PrimeLuxSync) {
                    window.PrimeLuxSync.showToast({
                        title: 'Đặt Lịch Dịch Vụ Thành Công',
                        message: `${data.message} • MÃ ĐẶT LỊCH: <b>${data.data.ma_dat_lich}</b>`,
                        icon: 'fa-calendar-check',
                        type: 'success'
                    });
                }
                document.getElementById('lookupQuery').value = data.data.ma_dat_lich;
                document.getElementById('lookupForm').dispatchEvent(new Event('submit'));
                window.location.hash = 'tra-cuu';
            } else {
                if (window.PrimeLuxSync) {
                    window.PrimeLuxSync.showToast({
                        title: 'Lỗi Đặt Lịch',
                        message: data.message || 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại!',
                        icon: 'fa-triangle-exclamation',
                        type: 'danger'
                    });
                }
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            if (window.PrimeLuxSync) {
                window.PrimeLuxSync.showToast({
                    title: 'Lỗi Kết Nối',
                    message: 'Không thể kết nối máy chủ dịch vụ. Vui lòng thử lại!',
                    icon: 'fa-wifi',
                    type: 'danger'
                });
            }
        });
    });

    document.getElementById('sosForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        fetch("{{ route('dichvu.cuuho') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('sosModal')).hide();
                if (window.PrimeLuxSync) {
                    window.PrimeLuxSync.showToast({
                        title: 'Tiếp Nhận Cứu Hộ Khẩn Cấp',
                        message: `🚨 ${data.message} • MÃ CỨU HỘ: <b>${data.data.ma_dat_lich}</b>. Đội cơ động đang xuất phát!`,
                        icon: 'fa-truck-medical',
                        type: 'warning',
                        duration: 8000
                    });
                }
                document.getElementById('lookupQuery').value = data.data.ma_dat_lich;
                document.getElementById('lookupForm').dispatchEvent(new Event('submit'));
                window.location.hash = 'tra-cuu';
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            if (window.PrimeLuxSync) {
                window.PrimeLuxSync.showToast({
                    title: 'Lỗi Kết Nối',
                    message: 'Không thể gửi yêu cầu cứu hộ qua web. Quý khách vui lòng gọi Hotline 0338 929 013 để được ứng cứu ngay!',
                    icon: 'fa-phone-volume',
                    type: 'danger'
                });
            }
        });
    });

    document.getElementById('lookupForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = document.getElementById('lookupQuery').value.trim();
        const resultContainer = document.getElementById('lookupResult');

        if (!query) return;

        resultContainer.innerHTML = '<div class="text-center py-3"><i class="fa-solid fa-spinner fa-spin fs-4 gold-accent"></i></div>';

        fetch(`{{ route('api.dichvu.tracuu') }}?query=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                let html = `<h6 class="fw-bold text-white mb-2 small">Tìm thấy ${data.count} kết quả:</h6>`;
                data.data.forEach(item => {
                    html += `
                        <div class="card bg-dark border-secondary mb-2 p-2 small">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-warning">${item.ma_dat_lich}</span>
                                <span class="badge ${item.badge.class}">${item.badge.label}</span>
                            </div>
                            <div class="text-white fw-bold mt-1">${item.loai_dich_vu}</div>
                            <div class="text-secondary small">Khách hàng: ${item.ho_ten} (${item.sdt}) | Xe: ${item.ten_xe}</div>
                            <div class="text-secondary small">Thời gian: ${item.thoi_gian_hen}</div>
                        </div>
                    `;
                });
                resultContainer.innerHTML = html;
            } else {
                resultContainer.innerHTML = `<div class="alert alert-warning text-center my-2 p-2 small">${data.message}</div>`;
            }
        })
        .catch(err => {
            resultContainer.innerHTML = '<div class="alert alert-danger text-center my-2 p-2 small">Lỗi tra cứu.</div>';
        });
    });

    // TRA CỨU SỔ BẢO HÀNH VIN & LỊCH SỬ BẢO DƯỠNG
    function quickVinSearch(vin) {
        document.getElementById('vinInput').value = vin;
        performVinSearch(vin);
    }

    function performVinSearch(vin) {
        const container = document.getElementById('vinResultContainer');
        container.classList.remove('d-none');
        container.innerHTML = '<div class="text-center py-5"><i class="fa-solid fa-spinner fa-spin fs-2 gold-accent mb-2"></i><div class="text-secondary small">Đang đối soát số khung VIN với cơ sở dữ liệu bảo hành...</div></div>';

        fetch(`{{ url('/api/dich-vu/so-bao-hanh-vin') }}?vin=${encodeURIComponent(vin)}`)
        .then(r => r.json())
        .then(res => {
            if (res.success && res.data) {
                const d = res.data;
                let historyHtml = '';
                if (d.history && d.history.length > 0) {
                    d.history.forEach((h, idx) => {
                        historyHtml += `
                            <tr>
                                <td class="fw-bold text-warning">${h.ngay}</td>
                                <td><span class="badge bg-primary">${h.moc_km}</span></td>
                                <td class="text-white">${h.noi_dung}</td>
                                <td class="text-secondary small">${h.phu_tung || 'Kiểm tra tổng quát'}</td>
                                <td class="text-warning fw-bold">${h.chi_phi}</td>
                                <td class="text-info small">${h.ky_thuat_vien}</td>
                                <td class="text-success fw-bold small">${h.diem_thuong}</td>
                            </tr>
                        `;
                    });
                } else {
                    historyHtml = '<tr><td colspan="7" class="text-center py-3 text-secondary">Chưa có bản ghi bảo dưỡng nào.</td></tr>';
                }

                container.innerHTML = `
                    <div class="p-4 rounded-4" style="background: #111827; border: 1.5px solid #d4af37; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);">
                        <div class="row g-4 align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-30">
                            <div class="col-md-7">
                                <span class="badge bg-success bg-opacity-20 text-success border border-success px-3 py-1 mb-2">
                                    <i class="fa-solid fa-circle-check me-1"></i> ${d.trang_thai}
                                </span>
                                <h4 class="fw-bold text-white mb-1">${d.ten_xe}</h4>
                                <div class="text-secondary small">
                                    Số Khung (VIN): <code class="text-warning fw-bold fs-6">${d.vin}</code> | Biển Số: <strong class="text-white">${d.bien_so || 'Chưa gắn biển'}</strong>
                                </div>
                                <div class="text-secondary small mt-1">
                                    Chủ sở hữu: <strong class="text-white">${d.chu_so_huu}</strong> (${d.sdt})
                                </div>
                            </div>
                            <div class="col-md-5 text-md-end">
                                <div class="p-3 rounded-3 bg-black bg-opacity-40 border border-secondary border-opacity-40 text-start">
                                    <div class="small text-secondary">Gói Bảo Hành: <strong class="text-warning">${d.goi_bao_hanh}</strong></div>
                                    <div class="small text-secondary">Thời Hạn Còn Lại: <strong class="text-success fs-5 fw-bold">${d.con_lai_thang} Tháng</strong> (${d.con_lai_ngay} ngày)</div>
                                    <div class="small text-secondary">Hết hạn vào: <strong class="text-white">${d.ngay_het_han}</strong></div>
                                    <div class="small text-secondary">Số ODO hiện tại: <strong class="text-info">${d.so_km_hien_tai}</strong></div>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold text-white mb-3">
                            <i class="fa-solid fa-clock-rotate-left text-warning me-2"></i> Lịch Sử Nhật Ký Bảo Dưỡng & Thay Thế Phụ Tùng
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped align-middle mb-0 small">
                                <thead>
                                    <tr class="table-secondary text-dark">
                                        <th>Ngày</th>
                                        <th>Mốc Km</th>
                                        <th>Hạng Mục Thực Hiện</th>
                                        <th>Phụ Tùng Thay Thế</th>
                                        <th>Chi Phí</th>
                                        <th>Kỹ Sư Trưởng</th>
                                        <th>Điểm Thưởng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${historyHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = `<div class="alert alert-warning text-center py-4 my-2"><i class="fa-solid fa-triangle-exclamation fs-3 d-block mb-2"></i>${res.message || 'Không tìm thấy hồ sơ'}</div>`;
            }
        })
        .catch(err => {
            container.innerHTML = '<div class="alert alert-danger text-center py-4 my-2">Lỗi tra cứu máy chủ. Vui lòng thử lại.</div>';
        });
    }

    document.getElementById('vinLookupForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const vin = document.getElementById('vinInput').value.trim();
        if (vin) {
            performVinSearch(vin);
        }
    });
</script>
@endpush
