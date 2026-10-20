@extends('layouts.admin')

@section('title', 'Quản Lý Lịch Lái Thử - PrimeLux Auto Admin')

@section('content')
<div class="container-fluid px-3 px-md-4 py-2">

    <!-- HEADER TITLE -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-white mb-1">
                <i class="fa-solid fa-calendar-check text-warning me-2"></i> Tiếp Nhận & Quản Lý Lịch Đăng Ký Lái Thử
            </h2>
            <p class="text-secondary small mb-0">Theo dõi quy trình tư vấn chăm sóc khách hàng: <strong>Chờ duyệt → Đã liên hệ → Đã hoàn thành</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/test-drive') }}" target="_blank" class="btn btn-outline-warning btn-sm">
                <i class="fa-solid fa-plus-circle me-1"></i> Trang Đặt Lịch Web
            </a>
        </div>
    </div>

    <!-- 4 THẺ THỐNG KÊ QUY TRÌNH TIẾP NHẬN - CLICK ĐỂ LỌC TRẠNG THÁI -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-blue drive-stat-card active-blue" data-status="all" role="button" title="Nhấp để hiển thị Tất cả lịch hẹn">
                <span class="badge bg-primary position-absolute top-0 end-0 m-2 filter-pill" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang xem
                </span>
                <div>
                    <div class="stat-title">Tổng Số Lịch Hẹn</div>
                    <div class="stat-value text-white">
                        <span id="statTotalDrives">{{ $totalDrives }}</span>
                        <span class="stat-unit">lượt</span>
                    </div>
                    <div class="stat-sub text-secondary">Tất cả yêu cầu đã tiếp nhận</div>
                </div>
                <div class="stat-icon-wrap icon-blue">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-amber drive-stat-card" data-status="Chờ duyệt" role="button" title="Nhấp để lọc danh sách: Đang chờ duyệt">
                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">1. Đang Chờ Duyệt</div>
                    <div class="stat-value text-warning">
                        <span id="statPendingDrives">{{ $pendingCount }}</span>
                        <span class="stat-unit text-warning">yêu cầu</span>
                    </div>
                    <div class="stat-sub text-warning"><i class="fa-solid fa-clock"></i> Cần gọi tư vấn viên</div>
                </div>
                <div class="stat-icon-wrap icon-amber">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-cyan drive-stat-card" data-status="Đã liên hệ" role="button" title="Nhấp để lọc danh sách: Đã liên hệ khách">
                <span class="badge bg-info text-dark position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">2. Đã Liên Hệ Khách</div>
                    <div class="stat-value text-info">
                        <span id="statContactedDrives">{{ $contactedCount }}</span>
                        <span class="stat-unit text-info">khách</span>
                    </div>
                    <div class="stat-sub text-info"><i class="fa-solid fa-phone"></i> Đã chốt ngày giờ showroom</div>
                </div>
                <div class="stat-icon-wrap icon-cyan">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-luxury card-emerald drive-stat-card" data-status="Đã hoàn thành" role="button" title="Nhấp để lọc danh sách: Đã hoàn thành">
                <span class="badge bg-success position-absolute top-0 end-0 m-2 filter-pill d-none" style="font-size: 9px;">
                    <i class="fa-solid fa-filter me-1"></i>Đang lọc
                </span>
                <div>
                    <div class="stat-title">3. Đã Hoàn Thành</div>
                    <div class="stat-value text-success">
                        <span id="statCompletedDrives">{{ $completedCount }}</span>
                        <span class="stat-unit text-success">hoàn tất</span>
                    </div>
                    <div class="stat-sub text-success"><i class="fa-solid fa-circle-check"></i> Trải nghiệm xong</div>
                </div>
                <div class="stat-icon-wrap icon-emerald">
                    <i class="fa-solid fa-flag-checkered"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- THANH TÌM KIẾM & BỘ LỌC TRẠNG THÁI -->
    <div class="p-3.5 rounded-4 bg-dark border border-secondary mb-4 shadow-sm">
        <div class="row g-3 align-items-center">
            <div class="col-lg-5 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-secondary bg-opacity-20 border-secondary text-secondary"><i class="fa-solid fa-search"></i></span>
                    <input type="text" id="adminSearchDrive" class="form-control form-control-custom" placeholder="Tìm theo tên khách hàng, số điện thoại, xe...">
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <select id="adminFilterDriveStatus" class="form-select form-select-custom">
                    <option value="all">Tất cả trạng thái (Chờ duyệt → Đã liên hệ → Hoàn thành)</option>
                    <option value="Chờ duyệt">Chờ duyệt</option>
                    <option value="Đã liên hệ">Đã liên hệ</option>
                    <option value="Đã hoàn thành">Đã hoàn thành</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </div>
            <div class="col-lg-3 text-md-end">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="adminResetDriveFilter">
                    <i class="fa-solid fa-rotate-left me-1"></i> Đặt lại bộ lọc
                </button>
            </div>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH TIẾP NHẬN ĐĂNG KÝ LÁI THỬ -->
    <div class="table-responsive rounded-4 border border-secondary shadow-sm">
        <table class="table table-dark table-hover align-middle mb-0" id="testDrivesTable">
            <thead>
                <tr class="table-active text-secondary small text-uppercase">
                    <th style="width: 100px;">Mã Lịch</th>
                    <th>Khách Hàng</th>
                    <th>Liên Hệ (SĐT / Email)</th>
                    <th>Mẫu Xe Lái Thử</th>
                    <th>Showroom</th>
                    <th>Thời Gian Hẹn</th>
                    <th>Trạng Thái</th>
                    <th class="text-end" style="min-width: 220px;">Cập Nhật Tiến Độ</th>
                </tr>
            </thead>
            <tbody id="testDrivesTableBody">
                @foreach($testDrives as $td)
                @php
                    $rawStatus = $td->trang_thai;
                    $normalizedStatus = $rawStatus;
                    if ($rawStatus === 'Đang chờ duyệt') $normalizedStatus = 'Chờ duyệt';
                    elseif ($rawStatus === 'Đã xác nhận') $normalizedStatus = 'Đã hoàn thành';

                    $badgeClass = 'bg-warning text-dark';
                    if ($normalizedStatus === 'Đã liên hệ') $badgeClass = 'bg-info text-dark';
                    elseif ($normalizedStatus === 'Đã hoàn thành') $badgeClass = 'bg-success';
                    elseif ($normalizedStatus === 'Đã hủy') $badgeClass = 'bg-danger';
                @endphp
                <tr class="drive-table-row" 
                    id="drive-row-{{ $td->id }}"
                    data-id="{{ $td->id }}"
                    data-code="{{ $td->ma_lich }}"
                    data-name="{{ strtolower($td->ho_ten) }}"
                    data-phone="{{ $td->sdt }}"
                    data-car="{{ strtolower($td->ten_xe) }}"
                    data-status="{{ $normalizedStatus }}">
                    <td class="font-monospace fw-bold text-info">
                        {{ $td->ma_lich }}
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $td->ho_ten }}</div>
                        @if(!empty($td->ghi_chu))
                        <small class="text-secondary italic" title="{{ $td->ghi_chu }}"><i class="fa-solid fa-comment-dots text-warning me-1"></i>{{ Str::limit($td->ghi_chu, 30) }}</small>
                        @endif
                    </td>
                    <td>
                        <strong class="text-warning"><i class="fa-solid fa-phone me-1"></i>{{ $td->sdt }}</strong>
                        <br><small class="text-secondary">{{ $td->email ?? 'N/A' }}</small>
                    </td>
                    <td class="text-white fw-bold">
                        <i class="fa-solid fa-car text-primary me-1"></i> {{ $td->ten_xe }}
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-50 text-white">{{ $td->showroom }}</span>
                    </td>
                    <td class="small text-light">
                        <i class="fa-regular fa-clock text-info me-1"></i> {{ substr($td->thoi_gian, 0, 16) }}
                    </td>
                    <td>
                        <span class="badge {{ $badgeClass }} px-2.5 py-1.5" id="drive-badge-{{ $td->id }}">
                            {{ $normalizedStatus }}
                        </span>
                    </td>
                    <td class="text-end">
                        <!-- CÁC NÚT CẬP NHẬT TRẠNG THÁI NHANH 1-CLICK THEO QUY TRÌNH (YÊU CẦU ĐỀ BÀI) -->
                        <div class="d-inline-flex gap-1" id="action-group-{{ $td->id }}">
                            @if($normalizedStatus === 'Chờ duyệt')
                            <button type="button" class="btn btn-outline-info btn-sm fw-bold" onclick="updateDriveStatusStep('{{ $td->id }}', 'Đã liên hệ')" title="Chuyển sang: Đã liên hệ khách hàng">
                                <i class="fa-solid fa-phone me-1"></i> Đã Liên Hệ
                            </button>
                            @elseif($normalizedStatus === 'Đã liên hệ')
                            <button type="button" class="btn btn-outline-success btn-sm fw-bold" onclick="updateDriveStatusStep('{{ $td->id }}', 'Đã hoàn thành')" title="Chuyển sang: Đã hoàn thành lái thử">
                                <i class="fa-solid fa-check-double me-1"></i> Hoàn Thành
                            </button>
                            @else
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateDriveStatusStep('{{ $td->id }}', 'Chờ duyệt')" title="Đặt lại: Chờ duyệt">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                            @endif

                            <!-- DROPDOWN TRẠNG THÁI KHÁC -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark shadow">
                                    <li><h6 class="dropdown-header text-secondary small">Chọn Trạng Thái</h6></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('{{ $td->id }}', 'Chờ duyệt')"><i class="fa-solid fa-clock text-warning me-2"></i> Chờ duyệt</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('{{ $td->id }}', 'Đã liên hệ')"><i class="fa-solid fa-phone text-info me-2"></i> Đã liên hệ</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('{{ $td->id }}', 'Đã hoàn thành')"><i class="fa-solid fa-circle-check text-success me-2"></i> Đã hoàn thành</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="updateDriveStatusStep('{{ $td->id }}', 'Đã hủy')"><i class="fa-solid fa-ban me-2"></i> Đã hủy</a></li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteTestDriveRecord('{{ $td->id }}', '{{ $td->ma_lich }}')" title="Xóa lịch hẹn">
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
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("adminSearchDrive");
        const filterStatus = document.getElementById("adminFilterDriveStatus");
        const btnReset = document.getElementById("adminResetDriveFilter");
        const rows = document.querySelectorAll(".drive-table-row");

        // LỌC DANH SÁCH LÁI THỬ
        function filterDrives() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
            const status = filterStatus ? filterStatus.value : "all";

            rows.forEach(r => {
                const rName = (r.dataset.name || "").toLowerCase();
                const rPhone = r.dataset.phone || "";
                const rCar = (r.dataset.car || "").toLowerCase();
                const rCode = r.dataset.code ? r.dataset.code.toLowerCase() : "";
                const rStatus = r.dataset.status || "";

                let matchQ = (!query || rName.includes(query) || rPhone.includes(query) || rCar.includes(query) || rCode.includes(query));
                let matchS = (status === "all" || rStatus === status || 
                             (status === "Chờ duyệt" && (rStatus === "Đang chờ duyệt" || rStatus === "Chờ duyệt")));

                r.style.display = (matchQ && matchS) ? "" : "none";
            });
        }

        // TƯƠNG TÁC CLICK 4 THẺ THỐNG KÊ QUY TRÌNH
        const driveStatCards = document.querySelectorAll(".drive-stat-card");
        function updateActiveDriveCard(targetStatus) {
            driveStatCards.forEach(card => {
                const pill = card.querySelector(".filter-pill");
                card.classList.remove("active-blue", "active-amber", "active-cyan", "active-emerald");
                if (pill) pill.classList.add("d-none");

                if (card.dataset.status === targetStatus) {
                    if (card.classList.contains("card-blue")) card.classList.add("active-blue");
                    else if (card.classList.contains("card-amber")) card.classList.add("active-amber");
                    else if (card.classList.contains("card-cyan")) card.classList.add("active-cyan");
                    else if (card.classList.contains("card-emerald")) card.classList.add("active-emerald");
                    if (pill) pill.classList.remove("d-none");
                }
            });
        }

        driveStatCards.forEach(card => {
            card.addEventListener("click", () => {
                const st = card.dataset.status;
                if (filterStatus) filterStatus.value = st;
                updateActiveDriveCard(st);
                filterDrives();
            });
        });

        if (searchInput) searchInput.addEventListener("input", filterDrives);
        if (filterStatus) {
            filterStatus.addEventListener("change", () => {
                updateActiveDriveCard(filterStatus.value);
                filterDrives();
            });
        }

        if (btnReset) {
            btnReset.addEventListener("click", () => {
                if (searchInput) searchInput.value = "";
                if (filterStatus) filterStatus.value = "all";
                updateActiveDriveCard("all");
                filterDrives();
            });
        }
    });

    // CẬP NHẬT TRẠNG THÁI: CHỜ DUYỆT → ĐÃ LIÊN HỆ → ĐÃ HOÀN THÀNH (YÊU CẦU ĐỀ BÀI)
    async function updateDriveStatusStep(id, newStatus) {
        const badge = document.getElementById(`drive-badge-${id}`);
        const row = document.getElementById(`drive-row-${id}`);
        const actionGroup = document.getElementById(`action-group-${id}`);

        if (badge) {
            badge.textContent = newStatus;
            badge.className = "badge px-2.5 py-1.5 " + getStatusBadgeClass(newStatus);
        }

        if (row) {
            row.dataset.status = newStatus;
        }

        // Cập nhật lại nút hành động nhanh
        if (actionGroup) {
            let nextBtnHtml = '';
            if (newStatus === 'Chờ duyệt') {
                nextBtnHtml = `
                    <button type="button" class="btn btn-outline-info btn-sm fw-bold" onclick="updateDriveStatusStep('${id}', 'Đã liên hệ')" title="Chuyển sang: Đã liên hệ">
                        <i class="fa-solid fa-phone me-1"></i> Đã Liên Hệ
                    </button>
                `;
            } else if (newStatus === 'Đã liên hệ') {
                nextBtnHtml = `
                    <button type="button" class="btn btn-outline-success btn-sm fw-bold" onclick="updateDriveStatusStep('${id}', 'Đã hoàn thành')" title="Chuyển sang: Đã hoàn thành">
                        <i class="fa-solid fa-check-double me-1"></i> Hoàn Thành
                    </button>
                `;
            } else {
                nextBtnHtml = `
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateDriveStatusStep('${id}', 'Chờ duyệt')" title="Đặt lại: Chờ duyệt">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                `;
            }

            const dropdownHtml = `
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                    <ul class="dropdown-menu dropdown-menu-dark shadow">
                        <li><h6 class="dropdown-header text-secondary small">Chọn Trạng Thái</h6></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Chờ duyệt')"><i class="fa-solid fa-clock text-warning me-2"></i> Chờ duyệt</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Đã liên hệ')"><i class="fa-solid fa-phone text-info me-2"></i> Đã liên hệ</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Đã hoàn thành')"><i class="fa-solid fa-circle-check text-success me-2"></i> Đã hoàn thành</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Đã hủy')"><i class="fa-solid fa-ban me-2"></i> Đã hủy</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteTestDriveRecord('${id}', '')"><i class="fa-solid fa-trash"></i></button>
            `;

            actionGroup.innerHTML = nextBtnHtml + dropdownHtml;
        }

        // GỬI REQUEST CẬP NHẬT DATABASE
        try {
            const response = await fetch(`/admin/test-drives/${id}/status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ trang_thai: newStatus })
            });

            const data = await response.json();
            if (data.success) {
                if (data.stats) applyTestDriveStats(data.stats);
                if (window.PrimeLuxSync) {
                    window.PrimeLuxSync.showToast({
                        title: 'Đã Cập Nhật Lịch Hẹn',
                        message: `Lịch lái thử #${id} đã chuyển sang: ${newStatus}`,
                        icon: 'fa-check-circle',
                        type: 'success'
                    });
                    window.PrimeLuxSync.broadcast('TEST_DRIVE_STATUS_CHANGED', { id, newStatus, stats: data.stats });
                }
            }
        } catch(e) {
            console.error(e);
        }
    }

    function getStatusBadgeClass(status) {
        if (status === 'Chờ duyệt' || status === 'Đang chờ duyệt') return 'bg-warning text-dark';
        if (status === 'Đã liên hệ') return 'bg-info text-dark';
        if (status === 'Đã hoàn thành' || status === 'Đã xác nhận') return 'bg-success';
        if (status === 'Đã hủy') return 'bg-danger';
        return 'bg-secondary';
    }

    // XÓA LỊCH HẸN
    async function deleteTestDriveRecord(id, code) {
        if (confirm(`Bạn có chắc chắn muốn xóa bản ghi lái thử ${code || id}?`)) {
            const row = document.getElementById(`drive-row-${id}`);
            if (row) row.remove();

            try {
                const response = await fetch(`/admin/test-drives/${id}/delete`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });

                const data = await response.json();
                if (data.success) {
                    if (data.stats) applyTestDriveStats(data.stats);
                    if (window.PrimeLuxSync) {
                        window.PrimeLuxSync.showToast({
                            title: 'Đã Xóa Bản Ghi',
                            message: `Đã xóa yêu cầu lái thử ${code || id} khỏi hệ thống.`,
                            icon: 'fa-trash',
                            type: 'info'
                        });
                        window.PrimeLuxSync.broadcast('TEST_DRIVE_DELETED', { id, stats: data.stats });
                    }
                }
            } catch(e) {
                console.error(e);
            }
        }
    }

    function applyTestDriveStats(stats) {
        if (!stats) return;
        const sTotal = document.getElementById('statTotalDrives');
        const sPending = document.getElementById('statPendingDrives');
        const sContacted = document.getElementById('statContactedDrives');
        const sCompleted = document.getElementById('statCompletedDrives');

        if (sTotal && stats.total !== undefined) sTotal.textContent = stats.total;
        if (sPending && stats.pending !== undefined) sPending.textContent = stats.pending;
        if (sContacted && stats.contacted !== undefined) sContacted.textContent = stats.contacted;
        if (sCompleted && stats.completed !== undefined) sCompleted.textContent = stats.completed;
    }

    function renderTestDriveRowHtml(td) {
        const rawStatus = td.trang_thai || 'Chờ duyệt';
        const normalizedStatus = (rawStatus === 'Đang chờ duyệt') ? 'Chờ duyệt' : (rawStatus === 'Đã xác nhận' ? 'Đã hoàn thành' : rawStatus);
        const badgeClass = getStatusBadgeClass(normalizedStatus);
        const id = td.id;
        const code = td.code || td.ma_lich || ('TD-' + id);
        const thoiGian = (td.thoi_gian || '').substring(0, 16);

        return `
            <tr class="drive-table-row table-row-highlight-new" 
                id="drive-row-${id}"
                data-id="${id}"
                data-code="${code}"
                data-name="${(td.ho_ten || '').toLowerCase()}"
                data-phone="${td.sdt || ''}"
                data-car="${(td.ten_xe || '').toLowerCase()}"
                data-status="${normalizedStatus}">
                <td class="font-monospace fw-bold text-info">
                    ${code}
                </td>
                <td>
                    <div class="fw-bold text-white">${td.ho_ten}</div>
                    ${td.ghi_chu ? `<small class="text-secondary italic" title="${td.ghi_chu}"><i class="fa-solid fa-comment-dots text-warning me-1"></i>${td.ghi_chu.substring(0, 30)}</small>` : ''}
                </td>
                <td>
                    <strong class="text-warning"><i class="fa-solid fa-phone me-1"></i>${td.sdt}</strong>
                    <br><small class="text-secondary">${td.email || 'N/A'}</small>
                </td>
                <td class="text-white fw-bold">
                    <i class="fa-solid fa-car text-primary me-1"></i> ${td.ten_xe}
                </td>
                <td>
                    <span class="badge bg-secondary bg-opacity-50 text-white">${td.showroom}</span>
                </td>
                <td class="small text-light">
                    <i class="fa-regular fa-clock text-info me-1"></i> ${thoiGian}
                </td>
                <td>
                    <span class="badge ${badgeClass} px-2.5 py-1.5" id="drive-badge-${id}">
                        ${normalizedStatus}
                    </span>
                </td>
                <td class="text-end">
                    <div class="d-inline-flex gap-1" id="action-group-${id}">
                        <button type="button" class="btn btn-outline-info btn-sm fw-bold" onclick="updateDriveStatusStep('${id}', 'Đã liên hệ')" title="Chuyển sang: Đã liên hệ khách hàng">
                            <i class="fa-solid fa-phone me-1"></i> Đã Liên Hệ
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                            <ul class="dropdown-menu dropdown-menu-dark shadow">
                                <li><h6 class="dropdown-header text-secondary small">Chọn Trạng Thái</h6></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Chờ duyệt')"><i class="fa-solid fa-clock text-warning me-2"></i> Chờ duyệt</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Đã liên hệ')"><i class="fa-solid fa-phone text-info me-2"></i> Đã liên hệ</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Đã hoàn thành')"><i class="fa-solid fa-circle-check text-success me-2"></i> Đã hoàn thành</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="updateDriveStatusStep('${id}', 'Đã hủy')"><i class="fa-solid fa-ban me-2"></i> Đã hủy</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteTestDriveRecord('${id}', '${code}')" title="Xóa lịch hẹn">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    // LẮNG NGHE SỰ KIỆN TEST DRIVE REALTIME (TỨC THÌ 0ms)
    if (window.PrimeLuxSync) {
        window.PrimeLuxSync.on('TEST_DRIVE_BOOKED', (td) => {
            if (!td) return;
            const tbody = document.getElementById('testDrivesTableBody');
            if (tbody) {
                const existingRow = document.getElementById(`drive-row-${td.id}`);
                if (!existingRow) {
                    const tempTable = document.createElement('tbody');
                    tempTable.innerHTML = renderTestDriveRowHtml(td);
                    const newRow = tempTable.firstElementChild;
                    tbody.prepend(newRow);
                }
            }

            if (td.stats) {
                applyTestDriveStats(td.stats);
            } else {
                const sTotal = document.getElementById('statTotalDrives');
                const sPending = document.getElementById('statPendingDrives');
                if (sTotal) sTotal.textContent = (parseInt(sTotal.textContent || '0') + 1);
                if (sPending) sPending.textContent = (parseInt(sPending.textContent || '0') + 1);
            }

            window.PrimeLuxSync.showToast({
                title: 'Lịch Lái Thử Mới!',
                message: `Khách hàng <b>${td.ho_ten}</b> (${td.sdt}) vừa đăng ký lái thử xe <b>${td.ten_xe}</b> lúc ${td.thoi_gian}.`,
                icon: 'fa-calendar-plus',
                type: 'warning'
            });
        });
    }
</script>
@endpush
