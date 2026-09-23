@extends('layouts.client')

@section('title', 'Danh Sách Xe Hạng Sang - PrimeLux Auto')

@section('content')
<!-- HEADER TITLE -->
<div class="py-5 bg-dark text-center border-bottom border-secondary">
    <div class="container">
        <span class="section-tag">Showroom Online</span>
        <h1 class="fw-bold display-5 mb-2">Danh Sách Mẫu Xe Cao Cấp</h1>
        <p class="text-secondary max-w-600 mx-auto">Bộ sưu tập xe sang, xe thể thao và siêu xe sẵn sàng bàn giao tại các Showroom PrimeLux Auto.</p>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container py-5">
    <div class="row">
        <!-- SIDEBAR FILTER -->
        <div class="col-lg-3 mb-4">
            <div class="p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <h5 class="fw-bold mb-4"><i class="fa-solid fa-sliders text-primary me-2"></i> Lọc Xe Phù Hợp</h5>
                
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Từ Khóa Tìm Kiếm</label>
                    <input type="text" id="searchInput" class="form-control form-control-custom" placeholder="Nhập tên xe...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Thương Hiệu</label>
                    <select id="filterBrand" class="form-select form-select-custom">
                        <option value="all">Tất cả thương hiệu</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Porsche">Porsche</option>
                        <option value="BMW">BMW</option>
                        <option value="Audi">Audi</option>
                        <option value="Land Rover">Land Rover</option>
                        <option value="Lexus">Lexus</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Kiểu Dáng</label>
                    <select id="filterType" class="form-select form-select-custom">
                        <option value="all">Tất cả kiểu dáng</option>
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="Electric">Xe Điện (EV)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Mức Giá</label>
                    <select id="filterPrice" class="form-select form-select-custom">
                        <option value="all">Tất cả khoảng giá</option>
                        <option value="under5">Dưới 5 tỷ VNĐ</option>
                        <option value="5to10">Từ 5 đến 10 tỷ VNĐ</option>
                        <option value="over10">Trên 10 tỷ VNĐ</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- CAR GRID CONTAINER -->
        <div class="col-lg-9">
            <div class="row" id="car-list-container">
                @foreach($cars as $car)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="car-card">
                        <div class="car-thumb">
                            <img src="{{ $car['image'] }}" alt="{{ $car['name'] }}">
                            <span class="car-tag {{ $car['tagClass'] }}">{{ $car['tag'] }}</span>
                        </div>
                        <div class="car-body">
                            <div class="car-brand">{{ $car['brand'] }}</div>
                            <h3 class="car-title">{{ $car['name'] }}</h3>
                            <div class="car-specs">
                                <span><i class="fa-solid fa-gas-pump"></i> {{ $car['fuel'] }}</span>
                                <span><i class="fa-solid fa-bolt"></i> {{ $car['power'] }}</span>
                                <span><i class="fa-solid fa-chair"></i> {{ $car['seats'] }}</span>
                            </div>
                            <div class="car-price">{{ $car['priceText'] }}</div>
                            <div class="car-actions">
                                <a href="{{ url('/cars/' . $car['id']) }}" class="btn btn-accent flex-grow-1 text-center">
                                    <i class="fa-solid fa-eye"></i> Chi Tiết
                                </a>
                                <a href="{{ url('/cars/' . $car['id'] . '/compare') }}" class="btn btn-outline-info text-center" title="So Sánh Giá Đa Sàn (PO)">
                                    <i class="fa-solid fa-scale-balanced"></i> So Sánh
                                </a>
                                <a href="{{ url('/test-drive?car=' . urlencode($car['name'])) }}" class="btn btn-gold text-center" title="Đặt Lái Thử">
                                    <i class="fa-solid fa-steering-wheel"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // URL param filter sync (e.g. ?type=SUV, ?brand=BMW)
    document.addEventListener("DOMContentLoaded", () => {
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        const brandParam = urlParams.get('brand');
        
        if (typeParam && document.getElementById('filterType')) {
            document.getElementById('filterType').value = typeParam;
            document.getElementById('filterType').dispatchEvent(new Event('change'));
        }
        if (brandParam && document.getElementById('filterBrand')) {
            document.getElementById('filterBrand').value = brandParam;
            document.getElementById('filterBrand').dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
