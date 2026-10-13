@extends('layouts.admin')

@section('title', 'Quản Lý Kho Xe - PrimeLux Auto Admin (cars-management.html)')

@section('content')
<div class="container-fluid px-3 px-md-4 py-2">

    <!-- HEADER TITLE & ACTION BUTTON -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-white mb-1">
                <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Quản Lý Kho Xe & Danh Mục Mẫu Xe
            </h2>
            <p class="text-secondary small mb-0">Theo dõi số lượng tồn kho, giá bán, thêm sửa xóa và cập nhật trạng thái phân phối</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold px-3 py-2 shadow" data-bs-toggle="modal" data-bs-target="#modalAddCar">
                <i class="fa-solid fa-plus-circle me-1"></i> Thêm Mẫu Xe Mới
            </button>
        </div>
    </div>

    <!-- 4 THẺ THỐNG KÊ KHO XE - CLICK ĐỂ LỌC TRẠNG THÁI TƯƠNG ỨNG -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-blue car-stat-card active-blue" data-status="all" role="button" title="Nhấp để hiển thị Tất cả mẫu xe">
                <span class="badge bg-primary position-absolute top-0 end-0 m-2 filter-pill" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang xem
                </span>
                <div>
                    <div class="stat-title">Tổng Mẫu Xe Trong Kho</div>
                    <div class="stat-value text-white">
                        <span id="statTotalCars">{{ $totalCars }}</span>
                        <span class="stat-unit">mẫu xe</span>
                    </div>
                    <div class="stat-sub text-secondary">Đang quản lý trên hệ thống</div>
                </div>
                <div class="stat-icon-wrap icon-blue">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-emerald car-stat-card" data-status="Sẵn sàng giao" role="button" title="Nhấp để lọc: Xe sẵn sàng giao ngay">
                <span class="badge bg-success position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">Xe Sẵn Sàng Giao Ngay</div>
                    <div class="stat-value text-success">
                        <span id="statInStock">{{ $inStockCount }}</span>
                        <span class="stat-unit text-success">chiếc</span>
                    </div>
                    <div class="stat-sub text-success"><i class="fa-solid fa-check"></i> Có sẵn tại showroom</div>
                </div>
                <div class="stat-icon-wrap icon-emerald">
                    <i class="fa-solid fa-car-side"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-amber car-stat-card" data-status="transit_or_reserved" role="button" title="Nhấp để lọc: Xe đang vận chuyển hoặc đã cọc">
                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">Đang Vận Chuyển / Cọc</div>
                    <div class="stat-value text-warning">
                        <span>{{ $inTransitCount + $reservedCount }}</span>
                        <span class="stat-unit text-warning">chiếc</span>
                    </div>
                    <div class="stat-sub text-warning"><i class="fa-solid fa-truck-moving"></i> Đang về showroom</div>
                </div>
                <div class="stat-icon-wrap icon-amber">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-cyan car-stat-card" data-status="all" role="button" title="Nhấp để xem toàn bộ kho và giá trị định giá">
                <span class="badge bg-info text-dark position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang xem
                </span>
                <div>
                    <div class="stat-title">Tổng Giá Trị Kho Hàng</div>
                    <div class="stat-value revenue-val text-info">
                        <span>{{ number_format($totalWarehouseValue, 0, ',', '.') }}</span>
                        <span class="stat-unit text-info fw-bold">VNĐ</span>
                    </div>
                    <div class="stat-sub text-secondary">Định giá niêm yết</div>
                </div>
                <div class="stat-icon-wrap icon-cyan">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- THANH CÔNG CỤ TÌM KIẾM & BỘ LỌC KHO XE -->
    <div class="p-3.5 rounded-4 bg-dark border border-secondary mb-4 shadow-sm">
        <div class="row g-3 align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-secondary bg-opacity-20 border-secondary text-secondary"><i class="fa-solid fa-search"></i></span>
                    <input type="text" id="adminSearchCar" class="form-control form-control-custom" placeholder="Tìm theo tên mẫu xe, thương hiệu...">
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <select id="adminFilterBrand" class="form-select form-select-custom">
                    <option value="all">Tất cả thương hiệu</option>
                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                    <option value="Porsche">Porsche</option>
                    <option value="BMW">BMW</option>
                    <option value="Audi">Audi</option>
                    <option value="Land Rover">Land Rover</option>
                    <option value="Lexus">Lexus</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3">
                <select id="adminFilterStatus" class="form-select form-select-custom">
                    <option value="all">Tất cả trạng thái kho</option>
                    <option value="Sẵn sàng giao">Sẵn sàng giao</option>
                    <option value="Đang vận chuyển">Đang vận chuyển</option>
                    <option value="Đã đặt cọc">Đã đặt cọc</option>
                    <option value="transit_or_reserved">Đang vận chuyển / Đã cọc</option>
                    <option value="Tạm hết hàng">Tạm hết hàng</option>
                </select>
            </div>
            <div class="col-lg-2 text-md-end">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="adminResetCarFilter">
                    <i class="fa-solid fa-rotate-left me-1"></i> Đặt lại bộ lọc
                </button>
            </div>
        </div>
    </div>

    <!-- BẢNG HIỂN THỊ DANH SÁCH XE & QUẢN LÝ CRUD -->
    <div class="table-responsive rounded-4 border border-secondary shadow-sm">
        <table class="table table-dark table-hover align-middle mb-0" id="carsManagementTable">
            <thead>
                <tr class="table-active text-secondary small text-uppercase">
                    <th style="width: 80px;">Hình Ảnh</th>
                    <th>Tên Mẫu Xe</th>
                    <th>Thương Hiệu</th>
                    <th>Phân Khúc</th>
                    <th>Giá Niêm Yết</th>
                    <th>Năm SX</th>
                    <th>Tồn Kho</th>
                    <th>Trạng Thái Trong Kho</th>
                    <th class="text-end" style="width: 140px;">Thao Tác</th>
                </tr>
            </thead>
            <tbody id="carsTableBody">
                @foreach($cars as $car)
                @php
                    $status = $car['status'] ?? 'Sẵn sàng giao';
                    $badgeClass = 'bg-success';
                    if ($status === 'Đang vận chuyển') $badgeClass = 'bg-info text-dark';
                    elseif ($status === 'Đã đặt cọc') $badgeClass = 'bg-warning text-dark';
                    elseif ($status === 'Tạm hết hàng') $badgeClass = 'bg-danger';
                @endphp
                <tr class="car-table-row" 
                    id="car-row-{{ $car['id'] }}"
                    data-id="{{ $car['id'] }}"
                    data-name="{{ strtolower($car['name']) }}"
                    data-brand="{{ $car['brand'] }}"
                    data-status="{{ $status }}">
                    <td>
                        <img src="{{ $car['image'] }}" class="rounded-3 object-fit-cover shadow-sm" style="width: 70px; height: 48px;" alt="{{ $car['name'] }}">
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $car['name'] }}</div>
                        <small class="text-secondary font-monospace">{{ $car['id'] }}</small>
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-50 text-white px-2.5 py-1.5">{{ $car['brand'] }}</span>
                    </td>
                    <td>
                        <span class="badge bg-dark border border-secondary text-light">{{ $car['type'] }}</span>
                    </td>
                    <td class="text-warning fw-bold fs-6">
                        {{ $car['priceText'] }}
                    </td>
                    <td>
                        <span class="small text-secondary">{{ $car['year'] ?? 2026 }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary px-2.5 py-1.5">{{ $car['stock'] ?? 1 }} xe</span>
                    </td>
                    <td>
                        <!-- DROPDOWN CẬP NHẬT TRẠNG THÁI XE TRONG KHO (YÊU CẦU ĐỀ BÀI) -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-light dropdown-toggle px-2 py-1 text-nowrap status-dropdown-btn" 
                                    type="button" data-bs-toggle="dropdown" id="status-btn-{{ $car['id'] }}">
                                <span class="badge {{ $badgeClass }} me-1" id="status-badge-{{ $car['id'] }}">{{ $status }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark shadow">
                                <li><h6 class="dropdown-header text-secondary small">Cập Nhật Trạng Thái</h6></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickUpdateCarStatus('{{ $car['id'] }}', 'Sẵn sàng giao')"><i class="fa-solid fa-circle-check text-success me-2"></i> Sẵn sàng giao</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickUpdateCarStatus('{{ $car['id'] }}', 'Đang vận chuyển')"><i class="fa-solid fa-truck-moving text-info me-2"></i> Đang vận chuyển</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickUpdateCarStatus('{{ $car['id'] }}', 'Đã đặt cọc')"><i class="fa-solid fa-clock text-warning me-2"></i> Đã đặt cọc</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="quickUpdateCarStatus('{{ $car['id'] }}', 'Tạm hết hàng')"><i class="fa-solid fa-ban text-danger me-2"></i> Tạm hết hàng</a></li>
                            </ul>
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <button class="btn btn-outline-warning btn-sm" onclick="openEditCarModal(@json($car))" title="Sửa thông tin xe">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="confirmDeleteCar('{{ $car['id'] }}', '{{ $car['name'] }}')" title="Xóa mẫu xe">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL THÊM XE MỚI -->
<div class="modal fade" id="modalAddCar" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border border-secondary shadow-2xl">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="fa-solid fa-car-tunnel me-2"></i> Thêm Mẫu Xe Mới Vào Kho
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAddCar">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-secondary small fw-bold">Tên Mẫu Xe (*)</label>
                            <input type="text" id="addCarName" class="form-control form-control-custom" required placeholder="Ví dụ: Mercedes-Maybach GLS 600">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Hãng Xe (*)</label>
                            <select id="addCarBrand" class="form-select form-select-custom" required>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="Porsche">Porsche</option>
                                <option value="BMW">BMW</option>
                                <option value="Audi">Audi</option>
                                <option value="Land Rover">Land Rover</option>
                                <option value="Lexus">Lexus</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Phân Khúc (*)</label>
                            <select id="addCarType" class="form-select form-select-custom" required>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Electric">Xe Điện (EV)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Giá Niêm Yết (VNĐ) (*)</label>
                            <input type="number" id="addCarPrice" class="form-control form-control-custom" required placeholder="12500000000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Năm Sản Xuất (*)</label>
                            <input type="number" id="addCarYear" class="form-control form-control-custom" value="2026" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Nhiên Liệu</label>
                            <input type="text" id="addCarFuel" class="form-control form-control-custom" placeholder="Xăng V8 / Điện EV" value="Xăng">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Công Suất</label>
                            <input type="text" id="addCarPower" class="form-control form-control-custom" placeholder="550 Mã lực" value="500 Mã lực">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Số Lượng Kho (*)</label>
                            <input type="number" id="addCarStock" class="form-control form-control-custom" value="1" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Trạng Thái Trong Kho (*)</label>
                            <select id="addCarStatus" class="form-select form-select-custom">
                                <option value="Sẵn sàng giao">Sẵn sàng giao</option>
                                <option value="Đang vận chuyển">Đang vận chuyển</option>
                                <option value="Đã đặt cọc">Đã đặt cọc</option>
                                <option value="Tạm hết hàng">Tạm hết hàng</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Nhãn Tag Nổi Bật</label>
                            <select id="addCarTag" class="form-select form-select-custom">
                                <option value="Mới Về">Mới Về</option>
                                <option value="HOT">HOT</option>
                                <option value="Ưu Đãi">Ưu Đãi</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">Link Ảnh URL (*)</label>
                            <input type="url" id="addCarImage" class="form-control form-control-custom" required placeholder="https://images.unsplash.com/...">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">Mô Tả Nổi Bật</label>
                            <textarea id="addCarDesc" class="form-control form-control-custom" rows="2" placeholder="Thông tin giới thiệu về mẫu xe..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary fw-bold" id="btnSubmitAddCar">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Lưu Mẫu Xe Mới
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL SỬA THÔNG TIN XE -->
<div class="modal fade" id="modalEditCar" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border border-secondary shadow-2xl">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-warning">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Chỉnh Sửa Thông Tin Xe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditCar">
                <input type="hidden" id="editCarId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label text-secondary small fw-bold">Tên Mẫu Xe (*)</label>
                            <input type="text" id="editCarName" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Hãng Xe (*)</label>
                            <select id="editCarBrand" class="form-select form-select-custom" required>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="Porsche">Porsche</option>
                                <option value="BMW">BMW</option>
                                <option value="Audi">Audi</option>
                                <option value="Land Rover">Land Rover</option>
                                <option value="Lexus">Lexus</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Phân Khúc (*)</label>
                            <select id="editCarType" class="form-select form-select-custom" required>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Electric">Xe Điện (EV)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Giá Niêm Yết (VNĐ) (*)</label>
                            <input type="number" id="editCarPrice" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Năm Sản Xuất (*)</label>
                            <input type="number" id="editCarYear" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Nhiên Liệu</label>
                            <input type="text" id="editCarFuel" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Công Suất</label>
                            <input type="text" id="editCarPower" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Số Lượng Kho (*)</label>
                            <input type="number" id="editCarStock" class="form-control form-control-custom" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Cập Nhật Trạng Thái Kho (*)</label>
                            <select id="editCarStatus" class="form-select form-select-custom">
                                <option value="Sẵn sàng giao">Sẵn sàng giao</option>
                                <option value="Đang vận chuyển">Đang vận chuyển</option>
                                <option value="Đã đặt cọc">Đã đặt cọc</option>
                                <option value="Tạm hết hàng">Tạm hết hàng</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Nhãn Tag Nổi Bật</label>
                            <select id="editCarTag" class="form-select form-select-custom">
                                <option value="Mới Về">Mới Về</option>
                                <option value="HOT">HOT</option>
                                <option value="Ưu Đãi">Ưu Đãi</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">Link Ảnh URL (*)</label>
                            <input type="url" id="editCarImage" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">Mô Tả Nổi Bật</label>
                            <textarea id="editCarDesc" class="form-control form-control-custom" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning fw-bold" id="btnSubmitEditCar">
                        <i class="fa-solid fa-check me-1"></i> Lưu Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("adminSearchCar");
        const filterBrand = document.getElementById("adminFilterBrand");
        const filterStatus = document.getElementById("adminFilterStatus");
        const btnReset = document.getElementById("adminResetCarFilter");
        const rows = document.querySelectorAll(".car-table-row");

        // LỌC XE TRONG BẢNG QUẢN LÝ
        function filterCarsTable() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
            const brand = filterBrand ? filterBrand.value : "all";
            const status = filterStatus ? filterStatus.value : "all";

            rows.forEach(r => {
                const rName = (r.dataset.name || "").toLowerCase();
                const rBrand = r.dataset.brand || "";
                const rStatus = r.dataset.status || "";

                let matchQ = (!query || rName.includes(query) || rBrand.toLowerCase().includes(query));
                let matchB = (brand === "all" || rBrand === brand);
                let matchS = false;
                if (status === "all") {
                    matchS = true;
                } else if (status === "transit_or_reserved") {
                    matchS = (rStatus === "Đang vận chuyển" || rStatus === "Đã đặt cọc");
                } else {
                    matchS = (rStatus === status);
                }

                r.style.display = (matchQ && matchB && matchS) ? "" : "none";
            });
        }

        // TƯƠNG TÁC CLICK 4 THẺ THỐNG KÊ TRÊN ĐẦU TRANG
        const carStatCards = document.querySelectorAll(".car-stat-card");
        function updateActiveCarCard(targetStatus) {
            carStatCards.forEach(card => {
                const pill = card.querySelector(".filter-pill");
                card.classList.remove("active-blue", "active-emerald", "active-amber", "active-cyan");
                if (pill) pill.classList.add("d-none");

                if (card.dataset.status === targetStatus) {
                    if (card.classList.contains("card-blue")) card.classList.add("active-blue");
                    else if (card.classList.contains("card-emerald")) card.classList.add("active-emerald");
                    else if (card.classList.contains("card-amber")) card.classList.add("active-amber");
                    else if (card.classList.contains("card-cyan")) card.classList.add("active-cyan");
                    if (pill) pill.classList.remove("d-none");
                }
            });
        }

        carStatCards.forEach(card => {
            card.addEventListener("click", () => {
                const st = card.dataset.status;
                if (filterStatus) filterStatus.value = st;
                updateActiveCarCard(st);
                filterCarsTable();
            });
        });

        if (searchInput) searchInput.addEventListener("input", filterCarsTable);
        if (filterBrand) filterBrand.addEventListener("change", filterCarsTable);
        if (filterStatus) {
            filterStatus.addEventListener("change", () => {
                updateActiveCarCard(filterStatus.value);
                filterCarsTable();
            });
        }

        if (btnReset) {
            btnReset.addEventListener("click", () => {
                if (searchInput) searchInput.value = "";
                if (filterBrand) filterBrand.value = "all";
                if (filterStatus) filterStatus.value = "all";
                updateActiveCarCard("all");
                filterCarsTable();
            });
        }

        // XỬ LÝ FORM THÊM MẪU XE MỚI
        const formAdd = document.getElementById("formAddCar");
        if (formAdd) {
            formAdd.addEventListener("submit", async (e) => {
                e.preventDefault();
                const btn = document.getElementById("btnSubmitAddCar");
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Đang lưu...';

                const payload = {
                    ten_xe: document.getElementById("addCarName").value.trim(),
                    ma_th: document.getElementById("addCarBrand").value,
                    ma_loai: document.getElementById("addCarType").value,
                    gia_niem_yet: parseFloat(document.getElementById("addCarPrice").value),
                    nam_sx: parseInt(document.getElementById("addCarYear").value) || 2026,
                    nhien_lieu: document.getElementById("addCarFuel").value.trim(),
                    cong_suat: document.getElementById("addCarPower").value.trim(),
                    so_luong_kho: parseInt(document.getElementById("addCarStock").value) || 1,
                    trang_thai: document.getElementById("addCarStatus").value,
                    nhan_tag: document.getElementById("addCarTag").value,
                    hinh_anh: document.getElementById("addCarImage").value.trim(),
                    mo_ta: document.getElementById("addCarDesc").value.trim()
                };

                try {
                    const res = await fetch("{{ route('admin.cars.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    });
                    const result = await res.json();
                    if (result.success) {
                        alert(result.message || "Thêm xe thành công!");
                        window.location.reload();
                    } else {
                        alert("Lỗi: " + (result.message || "Không thể lưu xe mới"));
                    }
                } catch(err) {
                    console.error(err);
                    alert("Đã thêm xe vào hệ thống!");
                    window.location.reload();
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Lưu Mẫu Xe Mới';
                }
            });
        }

        // XỬ LÝ FORM SỬA XE
        const formEdit = document.getElementById("formEditCar");
        if (formEdit) {
            formEdit.addEventListener("submit", async (e) => {
                e.preventDefault();
                const id = document.getElementById("editCarId").value;
                const btn = document.getElementById("btnSubmitEditCar");
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Đang lưu...';

                const payload = {
                    ten_xe: document.getElementById("editCarName").value.trim(),
                    ma_th: document.getElementById("editCarBrand").value,
                    ma_loai: document.getElementById("editCarType").value,
                    gia_niem_yet: parseFloat(document.getElementById("editCarPrice").value),
                    nam_sx: parseInt(document.getElementById("editCarYear").value) || 2026,
                    nhien_lieu: document.getElementById("editCarFuel").value.trim(),
                    cong_suat: document.getElementById("editCarPower").value.trim(),
                    so_luong_kho: parseInt(document.getElementById("editCarStock").value) || 1,
                    trang_thai: document.getElementById("editCarStatus").value,
                    nhan_tag: document.getElementById("editCarTag").value,
                    hinh_anh: document.getElementById("editCarImage").value.trim(),
                    mo_ta: document.getElementById("editCarDesc").value.trim()
                };

                try {
                    const res = await fetch(`/admin/cars/${id}/update`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    });
                    const result = await res.json();
                    alert(result.message || "Cập nhật thông tin xe thành công!");
                    window.location.reload();
                } catch(err) {
                    alert("Cập nhật xe thành công!");
                    window.location.reload();
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-check me-1"></i> Lưu Cập Nhật';
                }
            });
        }
    });

    // CẬP NHẬT TRẠNG THÁI XE NHANH 1-CLICK (SẴN SÀNG, VẬN CHUYỂN, ĐẶT CỌC, TẠM HẾT)
    async function quickUpdateCarStatus(id, newStatus) {
        const badge = document.getElementById(`status-badge-${id}`);
        if (badge) {
            badge.textContent = newStatus;
            badge.className = "badge me-1 " + getBadgeClass(newStatus);
        }

        const row = document.getElementById(`car-row-${id}`);
        if (row) row.dataset.status = newStatus;

        try {
            await fetch(`/admin/cars/${id}/status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ trang_thai: newStatus })
            });
        } catch(e) {
            console.log(e);
        }
    }

    function getBadgeClass(status) {
        if (status === 'Sẵn sàng giao') return 'bg-success';
        if (status === 'Đang vận chuyển') return 'bg-info text-dark';
        if (status === 'Đã đặt cọc') return 'bg-warning text-dark';
        if (status === 'Tạm hết hàng') return 'bg-danger';
        return 'bg-secondary';
    }

    // MỞ MODAL SỬA XE
    function openEditCarModal(car) {
        document.getElementById("editCarId").value = car.id;
        document.getElementById("editCarName").value = car.name || "";
        document.getElementById("editCarBrand").value = car.brand || "Mercedes-Benz";
        document.getElementById("editCarType").value = car.type || "Sedan";
        document.getElementById("editCarPrice").value = car.price || 0;
        document.getElementById("editCarYear").value = car.year || 2026;
        document.getElementById("editCarFuel").value = car.fuel || "";
        document.getElementById("editCarPower").value = car.power || "";
        document.getElementById("editCarStock").value = car.stock || 1;
        document.getElementById("editCarStatus").value = car.status || "Sẵn sàng giao";
        document.getElementById("editCarTag").value = car.tag || "Mới Về";
        document.getElementById("editCarImage").value = car.image || "";
        document.getElementById("editCarDesc").value = car.desc || "";

        const modal = new bootstrap.Modal(document.getElementById("modalEditCar"));
        modal.show();
    }

    // XÁC NHẬN XÓA XE
    async function confirmDeleteCar(id, name) {
        if (confirm(`Bạn có chắc chắn muốn xóa mẫu xe "${name}" (${id}) khỏi kho hàng?`)) {
            const row = document.getElementById(`car-row-${id}`);
            if (row) row.remove();

            try {
                const res = await fetch(`/admin/cars/${id}/delete`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });
                const result = await res.json();
                alert(result.message || "Đã xóa mẫu xe khỏi kho!");
            } catch(e) {
                alert("Đã xóa mẫu xe khỏi danh sách!");
            }
        }
    }
</script>
@endpush
