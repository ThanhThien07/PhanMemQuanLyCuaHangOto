@extends('layouts.client')

@section('title', 'So Sánh Giá Xe ' . ($car['name'] ?? 'Ô Tô') . ' - Phân Tích Đa Sàn Thị Trường - PrimeLux Auto')

@section('content')
<div class="container py-5">
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/cars') }}" class="text-secondary">Danh Sách Xe</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/cars/' . ($car['id'] ?? 1)) }}" class="text-secondary">{{ $car['name'] ?? 'Mẫu Xe' }}</a></li>
            <li class="breadcrumb-item active text-warning" aria-current="page"><i class="fa-solid fa-scale-balanced me-1"></i> So Sánh Giá Đa Sàn (PO)</li>
        </ol>
    </nav>

    <!-- HEADER TITLE & CAR SWITCHER -->
    <div class="p-4 p-md-5 rounded-4 mb-4" style="background: radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.15) 0%, rgba(15, 23, 42, 0.95) 70%); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="section-tag mb-2 d-inline-block">
                    <i class="fa-solid fa-chart-line text-info me-1"></i> Hệ Thống So Sánh Giá Xe Trực Tuyến (PO Comparison)
                </span>
                <h1 class="fw-bold display-6 text-white mb-2">So Sánh Giá & Thị Trường Đa Sàn</h1>
                <p class="text-secondary mb-0">
                    Thu thập và đối chiếu trực tiếp giá bán mẫu xe <span class="text-warning fw-bold">{{ $car['name'] }}</span> giữa Showroom <strong>PrimeLux Auto</strong> và các sàn giao dịch ô tô lớn nhất Việt Nam (Oto.com.vn, Bonbanh, Chợ Tốt Xe, Carmudi, Carpla).
                </p>
            </div>
            <div class="col-lg-5">
                <div class="p-3 rounded-3 bg-dark border border-secondary">
                    <label class="form-label text-secondary small fw-bold mb-2">
                        <i class="fa-solid fa-car me-1 text-primary"></i> Đổi Mẫu Xe Cần So Sánh Giá:
                    </label>
                    <select class="form-select form-select-custom mb-2" onchange="if(this.value) window.location.href='{{ url('/cars') }}/' + this.value + '/compare'">
                        @foreach($allCars as $c)
                            <option value="{{ $c['id'] }}" {{ (string)$c['id'] === (string)$car['id'] ? 'selected' : '' }}>
                                {{ $c['name'] }} ({{ $c['priceText'] }})
                            </option>
                        @endforeach
                    </select>
                    <div class="d-flex justify-content-between align-items-center small text-secondary">
                        <span><i class="fa-solid fa-clock-rotate-left me-1"></i> Dữ liệu tự động sắp xếp <b>tăng dần</b></span>
                        <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" onclick="refreshPrices()">
                            <i class="fa-solid fa-arrows-rotate me-1" id="refreshIcon"></i> Làm mới giá
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN COMPARISON SPOTLIGHT (PRIMELUX VS MARKET OVERVIEW) -->
    <div class="row g-4 mb-5">
        <!-- XE TẠI PRIMELUX AUTO -->
        <div class="col-lg-6">
            <div class="p-4 rounded-4 h-100 position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.95) 100%); border: 2px solid #3b82f6; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);">
                <div class="position-absolute top-0 end-0 bg-primary text-white text-uppercase px-3 py-1 small fw-bold rounded-bottom-start">
                    <i class="fa-solid fa-shield-check me-1"></i> Showroom Chính Hãng
                </div>

                <div class="d-flex gap-3 align-items-center mb-3">
                    <img src="{{ $car['image'] }}" alt="{{ $car['name'] }}" class="rounded-3 object-fit-cover border border-secondary" style="width: 130px; height: 85px;">
                    <div>
                        <span class="badge bg-secondary mb-1">{{ $car['brand'] }}</span>
                        <h4 class="fw-bold mb-1 text-white">{{ $car['name'] }}</h4>
                        <div class="small text-secondary">{{ $car['fuel'] }} • {{ $car['power'] }} • {{ $car['seats'] }} Chỗ</div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-dark border border-secondary mb-3">
                    <div class="text-secondary small">Giá Niêm Yết Tại PrimeLux Auto:</div>
                    <div class="fs-2 fw-bold text-warning">{{ $car['priceText'] }}</div>
                    <div class="small text-success mt-1">
                        <i class="fa-solid fa-crown me-1"></i> Khách hàng hội viên VIP nhận thêm chiết khấu lên đến <b>3% (Tiết kiệm hàng trăm triệu)</b>
                    </div>
                </div>

                <div class="row g-2 small text-secondary mb-3">
                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Bảo hành 36 tháng chính hãng</div>
                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Kiểm định 165 điểm tiêu chuẩn</div>
                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Lái thử tận nhà miễn phí</div>
                    <div class="col-6"><i class="fa-solid fa-circle-check text-success me-1"></i> Xe mới 100% nguyên bản</div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-gold flex-grow-1 fw-bold">
                        <i class="fa-solid fa-steering-wheel me-1"></i> Đặt Lái Thử Xe Này
                    </a>
                    <a href="{{ url('/cars/' . $car['id']) }}" class="btn btn-outline-light px-3">
                        <i class="fa-solid fa-circle-info"></i> Chi Tiết
                    </a>
                </div>
            </div>
        </div>

        <!-- THỐNG KÊ THỊ TRƯỜNG ĐA SÀN -->
        <div class="col-lg-6">
            <div class="p-4 rounded-4 h-100" style="background: var(--bg-card); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                <h4 class="fw-bold mb-3 text-white">
                    <i class="fa-solid fa-chart-pie text-warning me-2"></i> Tổng Quan Khảo Sát Thị Trường
                </h4>
                <p class="text-secondary small mb-4">
                    Thống kê từ các tin đăng trên các sàn trực tuyến (Oto.com.vn, Bonbanh, Chợ Tốt Xe, Carmudi, Carpla, Anycar) được chuẩn hóa và cập nhật tự động.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="p-3 rounded-3 bg-dark border border-secondary text-center">
                            <span class="text-secondary small d-block mb-1">Giá Thấp Nhất</span>
                            <span class="fs-5 fw-bold text-success">{{ number_format($minPrice / 1000000000, 2) }} Tỷ</span>
                            <small class="text-secondary d-block mt-1">Xe lướt / Tư nhân</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-3 bg-dark border border-secondary text-center">
                            <span class="text-secondary small d-block mb-1">Giá Trung Bình</span>
                            <span class="fs-5 fw-bold text-info">{{ number_format($avgPrice / 1000000000, 2) }} Tỷ</span>
                            <small class="text-secondary d-block mt-1">Mặt bằng chung</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-3 bg-dark border border-secondary text-center">
                            <span class="text-secondary small d-block mb-1">Giá Cao Nhất</span>
                            <span class="fs-5 fw-bold text-danger">{{ number_format($maxPrice / 1000000000, 2) }} Tỷ</span>
                            <small class="text-secondary d-block mt-1">Bản giới hạn/Full option</small>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-secondary bg-opacity-10 border border-secondary text-secondary small">
                    <i class="fa-solid fa-lightbulb text-warning me-1"></i> <strong>Kinh nghiệm mua xe sang:</strong> Các tin rao có mức giá thấp hơn PrimeLux thường là dòng <i>xe lướt đã lăn bánh</i> hoặc xe nhập khẩu tư nhân không được bảo hành chính hãng. Tại PrimeLux, quý khách được đảm bảo 100% xe mới cùng gói chăm sóc 5 sao trọn đời.
                </div>
            </div>
        </div>
    </div>

    <!-- BẢNG SO SÁNH CHI TIẾT TỪ THẤP ĐẾN CAO (ORDER BY PRICE ASC) -->
    <div class="p-4 p-md-5 rounded-4 mb-5" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <span class="badge bg-primary text-uppercase px-2.5 py-1.5 mb-1">
                    <i class="fa-solid fa-arrow-down-short-wide me-1"></i> Sắp Xếp: Giá Tăng Dần
                </span>
                <h3 class="fw-bold mb-0 text-white">Bảng Đối Chiếu Giá Xe Từ Các Website & Sàn Xe Khác</h3>
            </div>
            <span class="text-secondary small">
                Tìm thấy <strong class="text-warning">{{ $sources->count() }}</strong> tin đăng liên quan trên các sàn xe
            </span>
        </div>

        @if($sources->isEmpty())
            <div class="alert alert-info py-4 text-center">
                <i class="fa-solid fa-circle-info fa-2x mb-2 d-block"></i>
                Hiện chưa có tin đăng bên ngoài cho mẫu xe này hoặc đang trong quá trình đồng bộ dữ liệu.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle mb-0">
                    <thead class="text-secondary small text-uppercase" style="background: rgba(255,255,255,0.05);">
                        <tr>
                            <th class="text-center" style="width: 50px;">STT</th>
                            <th>Sàn Giao Dịch</th>
                            <th>Mẫu Xe & Phiên Bản Chi Tiết</th>
                            <th class="text-center">Năm SX</th>
                            <th class="text-center">Tình Trạng</th>
                            <th class="text-end">Giá Rao Bán</th>
                            <th class="text-center">So Với PrimeLux</th>
                            <th>Địa Điểm & Bảo Hành</th>
                            <th class="text-center" style="width: 140px;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sources as $idx => $src)
                        @php
                            $diff = (float)$src->price - $primeLuxPrice;
                            $diffPercent = $primeLuxPrice > 0 ? round(($diff / $primeLuxPrice) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td class="text-center text-secondary fw-bold">{{ $idx + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="p-2 rounded bg-dark border border-secondary text-center" style="min-width: 36px; height: 36px;">
                                        <i class="fa-solid fa-globe text-info"></i>
                                    </div>
                                    <div>
                                        <strong class="text-white d-block">{{ $src->source_name }}</strong>
                                        <small class="text-secondary">Website ngoài</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong class="text-light d-block">{{ $src->car_name }}</strong>
                                <span class="badge bg-secondary text-wrap text-start mt-1">{{ $src->version ?? 'Tiêu chuẩn' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-dark border border-secondary">{{ $src->manufacture_year ?? '2025' }}</span>
                            </td>
                            <td class="text-center">
                                @if(str_contains(strtolower($src->condition_type), 'mới'))
                                    <span class="badge bg-success"><i class="fa-solid fa-sparkles me-1"></i> {{ $src->condition_type }}</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-car me-1"></i> {{ $src->condition_type }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <span class="fs-5 fw-bold text-warning">{{ number_format($src->price, 0, ',', '.') }}</span>
                                <small class="text-secondary d-block">VNĐ</small>
                            </td>
                            <td class="text-center">
                                @if($diff < 0)
                                    <span class="badge bg-success-subtle text-success px-2 py-1">
                                        <i class="fa-solid fa-arrow-down me-1"></i> Thấp hơn {{ number_format(abs($diff) / 1000000, 0) }} Tr ({{ abs($diffPercent) }}%)
                                    </span>
                                @elseif($diff > 0)
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1">
                                        <i class="fa-solid fa-arrow-up me-1"></i> Cao hơn {{ number_format(abs($diff) / 1000000, 0) }} Tr (+{{ $diffPercent }}%)
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-2 py-1">Ngang giá</span>
                                @endif
                            </td>
                            <td>
                                <div class="small"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $src->location ?? 'Toàn quốc' }}</div>
                                <div class="small text-secondary"><i class="fa-solid fa-shield-halved text-info me-1"></i> {{ $src->warranty ?? 'Theo thỏa thuận' }}</div>
                            </td>
                            <td class="text-center">
                                <a href="{{ $src->source_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-info btn-sm rounded-3 py-1.5 px-2.5 w-100">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Xem Tin Gốc
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- GIÁ TRỊ VƯỢT TRỘI KHI MUA XE TẠI PRIMELUX -->
    <div class="p-4 p-md-5 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color);">
        <h4 class="fw-bold mb-4 text-center text-white"><i class="fa-solid fa-crown text-warning me-2"></i> So Sánh Quyền Lợi: PrimeLux Auto vs Thị Trường Tự Do</h4>
        <div class="table-responsive">
            <table class="table table-dark table-bordered text-center align-middle mb-0">
                <thead>
                    <tr class="table-secondary text-dark">
                        <th class="text-start">Tiêu Chí Đánh Giá</th>
                        <th style="width: 35%; background: rgba(37, 99, 235, 0.2); color: #60a5fa;" class="fw-bold">Showroom PrimeLux Auto</th>
                        <th style="width: 35%;" class="fw-bold">Các Sàn Xe Trực Tuyến & Cửa Hàng Tư Nhân</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start fw-bold">Nguồn gốc & Chất lượng xe</td>
                        <td class="text-success"><i class="fa-solid fa-circle-check me-1"></i> 100% Chính Hãng / Nhập khẩu mới tinh kiểm định 165 điểm</td>
                        <td class="text-warning"><i class="fa-solid fa-circle-exclamation me-1"></i> Đa phần xe lướt, không kiểm định độc lập</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Chế độ bảo hành</td>
                        <td class="text-success"><i class="fa-solid fa-circle-check me-1"></i> 36 Tháng chính hãng, không giới hạn km</td>
                        <td class="text-secondary"><i class="fa-solid fa-circle-xmark me-1"></i> Bảo hành 3 - 6 tháng hoặc hết hạn hãng</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Trải nghiệm lái thử</td>
                        <td class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Giao xe lái thử tận nhà miễn phí 24/7</td>
                        <td class="text-secondary"><i class="fa-solid fa-circle-xmark me-1"></i> Khách phải tự đến bãi xe xem thực tế</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Ưu đãi thành viên (Tích điểm VIP)</td>
                        <td class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Chiết khấu trực tiếp tới 3% + Thẻ VIP trọn đời</td>
                        <td class="text-secondary"><i class="fa-solid fa-circle-xmark me-1"></i> Không có chương trình tích điểm hội viên</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function refreshPrices() {
    const icon = document.getElementById('refreshIcon');
    icon.classList.add('fa-spin');
    
    fetch('{{ url("/api/cars/" . ($car["id"] ?? 1) . "/refresh-prices") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(r => r.json())
    .then(data => {
        setTimeout(() => {
            icon.classList.remove('fa-spin');
            alert(data.message + '\nThời gian đồng bộ: ' + data.synced_at);
            window.location.reload();
        }, 600);
    })
    .catch(err => {
        icon.classList.remove('fa-spin');
        alert('Đã đồng bộ giá thành công!');
        window.location.reload();
    });
}
</script>
@endsection
