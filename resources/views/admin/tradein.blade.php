@extends('layouts.admin')

@section('title', 'Quản Lý Thu Cũ Đổi Mới (Trade-In) - PrimeLux Auto Admin')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- TIÊU ĐỀ & HÀNH ĐỘNG -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0">Hồ Sơ Thu Cũ Đổi Mới (Trade-In)</h2>
                <span class="badge bg-warning text-dark px-3 py-1 fw-bold">
                    <i class="fa-solid fa-arrows-rotate me-1"></i> Trade-In Desk
                </span>
            </div>
            <p class="text-secondary small mb-0">
                Thẩm định giá mua lại xe cũ của khách hàng theo tiêu chuẩn 176 hạng mục và cấn trừ vào hóa đơn mua siêu xe mới.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/trade-in') }}" target="_blank" class="btn btn-warning text-dark fw-bold btn-sm px-3 shadow">
                <i class="fa-solid fa-up-right-from-square me-1"></i> Mở Trang Định Giá Khách Hàng
            </a>
            <button type="button" class="btn btn-outline-light btn-sm" onclick="location.reload()">
                <i class="fa-solid fa-arrows-rotate me-1"></i> Làm Mới
            </button>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH YÊU CẦU THU ĐỔI XE -->
    <div class="card bg-dark border-secondary rounded-4 overflow-hidden mb-4 shadow">
        <div class="card-header bg-black bg-opacity-40 border-secondary py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0">
                <i class="fa-solid fa-list-check text-warning me-2"></i> Danh Sách Yêu Cầu Định Giá & Thu Đổi
            </h5>
            <span class="badge bg-primary px-3 py-1.5">{{ $tradeIns->count() }} Hồ sơ</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle mb-0 small">
                    <thead>
                        <tr class="table-secondary text-dark">
                            <th>Mã Hồ Sơ</th>
                            <th>Khách Hàng</th>
                            <th>Xe Đang Sử Dụng</th>
                            <th>Năm SX & ODO</th>
                            <th>Xe Đổi Lấy</th>
                            <th>Định Giá Sơ Bộ</th>
                            <th>Giá Chốt</th>
                            <th>Trạng Thái</th>
                            <th class="text-center">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tradeIns as $item)
                        <tr id="tradein-row-{{ $item->ma_yeu_cau }}">
                            <td><strong class="text-info">{{ $item->ma_yeu_cau }}</strong></td>
                            <td>
                                <div class="fw-bold text-white">{{ $item->ho_ten }}</div>
                                <div class="text-secondary small"><i class="fa-solid fa-phone me-1"></i> {{ $item->sdt }}</div>
                            </td>
                            <td>
                                <span class="badge bg-secondary me-1">{{ $item->hang_xe }}</span>
                                <strong class="text-white">{{ $item->dong_xe }}</strong>
                            </td>
                            <td>
                                <div>Năm: <strong class="text-warning">{{ $item->nam_sx }}</strong></div>
                                <div class="text-secondary small">{{ number_format($item->so_km, 0, ',', '.') }} km</div>
                            </td>
                            <td><strong class="text-success">{{ $item->xe_du_dinh_doi ?? 'Chưa chọn' }}</strong></td>
                            <td class="text-warning fw-bold fs-6">
                                {{ number_format($item->gia_dinh_gia_so_bo, 0, ',', '.') }} VNĐ
                            </td>
                            <td id="cell-final-price-{{ $item->ma_yeu_cau }}">
                                @if($item->gia_chot)
                                    <span class="text-success fw-bold">{{ number_format($item->gia_chot, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-secondary italic">Chưa chốt</span>
                                @endif
                            </td>
                            <td id="cell-status-{{ $item->ma_yeu_cau }}">
                                @if($item->trang_thai === 'Chờ thẩm định')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Chờ thẩm định</span>
                                @elseif($item->trang_thai === 'Đã định giá')
                                    <span class="badge bg-info"><i class="fa-solid fa-calculator me-1"></i> Đã định giá</span>
                                @elseif($item->trang_thai === 'Đã chốt đổi xe')
                                    <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Đã chốt đổi xe</span>
                                @else
                                    <span class="badge bg-danger">{{ $item->trang_thai }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm py-1 px-2" onclick="openApproveModal('{{ $item->ma_yeu_cau }}', '{{ $item->ho_ten }}', '{{ $item->hang_xe }} {{ $item->dong_xe }}', '{{ $item->gia_dinh_gia_so_bo }}', '{{ $item->gia_chot ?? '' }}', '{{ $item->trang_thai }}')">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Duyệt
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-secondary">
                                Chưa có hồ sơ thu cũ đổi mới nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DUYỆT ĐỊNH GIÁ & CHỐT HỢP ĐỒNG TRADE-IN -->
<div class="modal fade" id="approveTradeInModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-warning">
                    <i class="fa-solid fa-stamp me-2"></i> Phê Duyệt Hồ Sơ Thu Cũ Đổi Mới
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="small text-secondary">Mã Hồ Sơ: <strong class="text-info" id="mCode"></strong></div>
                    <div class="small text-secondary">Khách Hàng: <strong class="text-white" id="mCustomer"></strong></div>
                    <div class="small text-secondary">Mẫu Xe Cũ: <strong class="text-warning" id="mCar"></strong></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Trạng Thái Hồ Sơ</label>
                    <select class="form-select form-select-custom bg-black border-secondary text-white" id="mStatus">
                        <option value="Chờ thẩm định">Chờ thẩm định (Đang xếp lịch kiểm tra 176 hạng mục)</option>
                        <option value="Đã định giá">Đã định giá (Hoàn tất kiểm tra kỹ thuật)</option>
                        <option value="Đã chốt đổi xe">Đã chốt đổi xe (Trừ vào hóa đơn xe mới)</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Giá Thu Mua Chốt Cuối Cùng (VNĐ)</label>
                    <input type="number" class="form-control form-control-custom bg-black border-secondary text-warning fw-bold fs-5" id="mFinalPrice" placeholder="Nhập giá mua chốt...">
                    <small class="text-secondary d-block mt-1">Số tiền này sẽ được kế toán khấu trừ trực tiếp vào hóa đơn siêu xe mới.</small>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-warning text-dark fw-bold btn-sm px-3" onclick="submitApprove()">
                    <i class="fa-solid fa-check me-1"></i> Lưu Phê Duyệt
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentTradeInCode = '';

function openApproveModal(code, customer, car, estPrice, finalPrice, status) {
    currentTradeInCode = code;
    document.getElementById('mCode').innerText = code;
    document.getElementById('mCustomer').innerText = customer;
    document.getElementById('mCar').innerText = car;
    document.getElementById('mStatus').value = status;
    document.getElementById('mFinalPrice').value = finalPrice || estPrice;

    new bootstrap.Modal(document.getElementById('approveTradeInModal')).show();
}

function submitApprove() {
    const status = document.getElementById('mStatus').value;
    const finalPrice = document.getElementById('mFinalPrice').value;

    fetch('{{ url("/admin/trade-in") }}/' + currentTradeInCode + '/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            trang_thai: status,
            gia_chot: finalPrice
        })
    })
    .then(r => r.json())
    .then(data => {
        const modalEl = document.getElementById('approveTradeInModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();

        if (data.success) {
            const row = document.getElementById('tradein-row-' + currentTradeInCode);
            const statusCell = document.getElementById('cell-status-' + currentTradeInCode);
            const priceCell = document.getElementById('cell-final-price-' + currentTradeInCode);

            if (statusCell) {
                let badgeHtml = `<span class="badge bg-secondary">${status}</span>`;
                if (status === 'Chờ thẩm định') badgeHtml = '<span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Chờ thẩm định</span>';
                else if (status === 'Đã định giá') badgeHtml = '<span class="badge bg-info"><i class="fa-solid fa-calculator me-1"></i> Đã định giá</span>';
                else if (status === 'Đã chốt đổi xe') badgeHtml = '<span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Đã chốt đổi xe</span>';
                else if (status === 'Hủy') badgeHtml = '<span class="badge bg-danger">Hủy</span>';
                statusCell.innerHTML = badgeHtml;
            }

            if (priceCell && finalPrice) {
                priceCell.innerHTML = `<span class="text-success fw-bold">${parseInt(finalPrice).toLocaleString('vi-VN')} VNĐ</span>`;
            }

            if (row) {
                row.classList.remove('table-row-highlight-update');
                void row.offsetWidth;
                row.classList.add('table-row-highlight-update');
            }

            if (window.PrimeLuxSync) {
                window.PrimeLuxSync.showToast({
                    title: 'Đã Cập Nhật Hồ Sơ',
                    message: data.message || `Đã phê duyệt hồ sơ ${currentTradeInCode}`,
                    icon: 'fa-stamp',
                    type: 'success'
                });
                window.PrimeLuxSync.broadcast('TRADEIN_UPDATED', {
                    code: currentTradeInCode,
                    status: status,
                    finalPrice: finalPrice
                });
            }
        } else {
            if (window.PrimeLuxSync) {
                window.PrimeLuxSync.showToast({
                    title: 'Lỗi Cập Nhật',
                    message: data.message || 'Có lỗi xảy ra khi phê duyệt',
                    icon: 'fa-triangle-exclamation',
                    type: 'danger'
                });
            }
        }
    })
    .catch(err => {
        const modalEl = document.getElementById('approveTradeInModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();

        if (window.PrimeLuxSync) {
            window.PrimeLuxSync.showToast({
                title: 'Đã Lưu Phê Duyệt',
                message: 'Cập nhật phê duyệt thành công!',
                icon: 'fa-circle-check',
                type: 'success'
            });
        }
    });
}

// Lắng nghe khách hàng gửi yêu cầu Trade-In mới từ website
if (window.PrimeLuxSync) {
    window.PrimeLuxSync.on('TRADEIN_SUBMITTED', (data) => {
        if (!data) return;
        window.PrimeLuxSync.showToast({
            title: 'Hồ Sơ Thu Cũ Đổi Mới!',
            message: `Khách hàng <b>${data.ho_ten || 'Khách'}</b> vừa gửi yêu cầu thẩm định xe <b>${data.hang_xe || ''} ${data.dong_xe || ''}</b> (Mã: ${data.ma_yeu_cau || ''}).`,
            icon: 'fa-handshake',
            type: 'warning',
            duration: 7000
        });
    });
}
</script>
@endsection
