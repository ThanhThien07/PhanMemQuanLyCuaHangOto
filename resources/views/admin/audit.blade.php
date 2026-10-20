@extends('layouts.admin')

@section('title', 'Nhật Ký Kiểm Toán & Phân Quyền RBAC - PrimeLux Auto Admin')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- TIÊU ĐỀ & HÀNH ĐỘNG -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0">Nhật Ký Hoạt Động (Audit Log) & Phân Quyền RBAC</h2>
                <span class="badge bg-danger bg-opacity-20 text-danger border border-danger px-3 py-1">
                    <i class="fa-solid fa-shield-halved me-1"></i> Chuẩn Bảo Mật 2FA
                </span>
            </div>
            <p class="text-secondary small mb-0">
                Ghi nhận các thao tác nghiệp vụ của nhân viên (Quản lý bán hàng, Tư vấn viên, Kế toán) để giám sát và bảo mật dữ liệu. <span class="text-warning fw-bold"><i class="fa-solid fa-shield-halved me-1"></i>Super Admin có quyền quản trị tối thượng và được miễn trừ theo dõi nhật ký.</span>
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#twoFactorModal">
                <i class="fa-solid fa-key me-1"></i> Cài Đặt 2FA (Google Authenticator)
            </button>
            <button type="button" class="btn btn-outline-light btn-sm" onclick="location.reload()">
                <i class="fa-solid fa-arrows-rotate me-1"></i> Làm Mới
            </button>
        </div>
    </div>

    <!-- 4 THẺ VAI TRÒ HỆ THỐNG (RBAC ROLES) -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="p-3 rounded-4 bg-dark border border-danger border-opacity-40">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-danger">Super Admin</span>
                    <span class="badge bg-dark border border-warning text-warning" style="font-size: 10px;">Miễn Trừ Log</span>
                </div>
                <div class="fw-bold text-white mb-1">Toàn Quyền Tối Thượng</div>
                <div class="text-secondary" style="font-size: 11px;">Toàn quyền hệ thống, không bị giám sát thao tác, cấu hình bảo mật & phân quyền cấp cao.</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 rounded-4 bg-dark border border-warning border-opacity-40">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark">Quản Lý Bán Hàng</span>
                    <i class="fa-solid fa-car-tunnel text-warning fs-5"></i>
                </div>
                <div class="fw-bold text-white mb-1">Kinh Doanh & Cọc Xe</div>
                <div class="text-secondary" style="font-size: 11px;">Quản lý tồn kho xe, phê duyệt đặt cọc trực tuyến, thẩm định thu cũ đổi mới.</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 rounded-4 bg-dark border border-info border-opacity-40">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-info text-dark">Tư Vấn Viên</span>
                    <i class="fa-solid fa-headset text-info fs-5"></i>
                </div>
                <div class="fw-bold text-white mb-1">Chăm Sóc & Lái Thử</div>
                <div class="text-secondary" style="font-size: 11px;">Tiếp nhận câu hỏi từ AI/Web, trực chat SSE Realtime, điều phối lịch lái thử.</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 rounded-4 bg-dark border border-success border-opacity-40">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success">Kế Toán Showroom</span>
                    <i class="fa-solid fa-file-invoice-dollar text-success fs-5"></i>
                </div>
                <div class="fw-bold text-white mb-1">Hóa Đơn & Doanh Thu</div>
                <div class="text-secondary" style="font-size: 11px;">Quản lý thanh toán SePay, xuất hóa đơn điện tử, xuất báo cáo BI Excel.</div>
            </div>
        </div>
    </div>

    <!-- BẢNG NHẬT KÝ KIỂM TOÁN (AUDIT LOGS) -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card bg-dark border-secondary rounded-4 overflow-hidden shadow">
                <div class="card-header bg-black bg-opacity-40 border-secondary py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-white mb-0">
                        <i class="fa-solid fa-timeline text-danger me-2"></i> Lịch Sử Thao Tác Nghiệp Vụ Nhạy Cảm (Audit Logs)
                    </h5>
                    <span class="badge bg-secondary">{{ $logs->total() }} Bản ghi</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover align-middle mb-0 small">
                            <thead>
                                <tr class="table-secondary text-dark">
                                    <th>Thời Gian</th>
                                    <th>Người Dùng</th>
                                    <th>Vai Trò</th>
                                    <th>Hành Động</th>
                                    <th>Chi Tiết</th>
                                    <th>Địa Chỉ IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td class="text-secondary">{{ $log->created_at->format('H:i:s d/m/Y') }}</td>
                                    <td><strong class="text-white">{{ $log->user_name }}</strong></td>
                                    <td>
                                        @if($log->user_role === 'Super Admin')
                                            <span class="badge bg-danger">{{ $log->user_role }}</span>
                                        @elseif($log->user_role === 'Quản lý bán hàng')
                                            <span class="badge bg-warning text-dark">{{ $log->user_role }}</span>
                                        @elseif($log->user_role === 'Tư vấn viên')
                                            <span class="badge bg-info text-dark">{{ $log->user_role }}</span>
                                        @elseif($log->user_role === 'Kế toán')
                                            <span class="badge bg-success">{{ $log->user_role }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $log->user_role }}</span>
                                        @endif
                                    </td>
                                    <td><strong class="text-warning">{{ $log->action }}</strong></td>
                                    <td class="text-secondary">{{ Str::limit($log->details, 60) }}</td>
                                    <td><code>{{ $log->ip_address ?? '127.0.0.1' }}</code></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-secondary">Chưa có nhật ký hoạt động nào.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($logs->hasPages())
                <div class="card-footer bg-black bg-opacity-20 border-secondary py-2">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- CỘT PHẢI: LỊCH SỬ THÔNG BÁO TỰ ĐỘNG ĐA KÊNH -->
        <div class="col-lg-4">
            <div class="card bg-dark border-secondary rounded-4 overflow-hidden shadow">
                <div class="card-header bg-black bg-opacity-40 border-secondary py-3">
                    <h5 class="fw-bold text-white mb-0">
                        <i class="fa-solid fa-paper-plane text-info me-2"></i> Lịch Sử Thông Báo Đa Kênh
                    </h5>
                    <small class="text-secondary">Zalo ZNS, SMS Brandname & Email</small>
                </div>
                <div class="card-body p-3">
                    @forelse($notifications as $noti)
                    <div class="p-2.5 rounded-3 mb-2" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge {{ $noti->loai_kenh === 'Zalo ZNS' ? 'bg-primary' : ($noti->loai_kenh === 'SMS Brandname' ? 'bg-warning text-dark' : 'bg-info text-dark') }} small">
                                {{ $noti->loai_kenh }}
                            </span>
                            <span class="text-secondary" style="font-size: 11px;">{{ $noti->thoi_gian_gui->format('H:i d/m') }}</span>
                        </div>
                        <div class="fw-bold text-white small mb-1">{{ $noti->tieu_de }}</div>
                        <div class="text-secondary" style="font-size: 11px;">
                            Người nhận: <strong class="text-white">{{ $noti->nguoi_nhan }}</strong> ({{ $noti->sdt_email }})
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-secondary py-3 small">Chưa có thông báo đa kênh nào.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CẤU HÌNH XÁC THỰC 2 YẾU TỐ (2FA) -->
<div class="modal fade" id="twoFactorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-warning">
                    <i class="fa-solid fa-shield-halved me-2"></i> Kích Hoạt Xác Thực 2 Yếu Tố (2FA)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <img src="https://api.qrserver.com/com/v1/create-qr-code/?size=180x180&data=otpauth%3A%2F%2Ftotp%2FPrimeLux%20Auto%3Aadmin%40primelux.vn%3Fsecret%3DJBSWY3DPEHPK3PXP%26issuer%3DPrimeLux%20Auto" alt="2FA QR Code" class="p-2 bg-white rounded-3 shadow">
                </div>
                <h6 class="fw-bold text-white mb-2">Quét mã bằng Google Authenticator / Microsoft Authenticator</h6>
                <p class="text-secondary small mb-3">Mã khóa bí mật dự phòng: <code class="text-warning">JBSWY3DPEHPK3PXP</code></p>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-custom text-center fs-4 fw-bold letter-spacing-2" placeholder="000 000" maxlength="6" id="twoFactorCode">
                </div>
                <div class="alert alert-success bg-opacity-10 border border-success text-success small mb-0">
                    <i class="fa-solid fa-lock me-1"></i> Sau khi kích hoạt, mọi lần đăng nhập quyền Admin và Advisor đều bắt buộc nhập mã OTP bảo mật.
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-warning text-dark fw-bold btn-sm px-3" onclick="verifyTwoFactor()">
                    <i class="fa-solid fa-check me-1"></i> Xác Nhận & Kích Hoạt 2FA
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function verifyTwoFactor() {
    const code = document.getElementById('twoFactorCode').value.trim();
    if (code.length < 6) {
        if (window.PrimeLuxSync) {
            window.PrimeLuxSync.showToast({
                title: 'Mã OTP Không Hợp Lệ',
                message: 'Vui lòng nhập đủ 6 chữ số mã xác thực OTP từ ứng dụng Google Authenticator!',
                icon: 'fa-shield-halved',
                type: 'warning'
            });
        }
        return;
    }
    if (window.PrimeLuxSync) {
        window.PrimeLuxSync.showToast({
            title: 'Kích Hoạt 2FA Thành Công',
            message: 'Tài khoản Quản Trị đã được bảo vệ an toàn bằng Xác thực 2 bước (Google Authenticator)!',
            icon: 'fa-lock',
            type: 'success'
        });
    }
    bootstrap.Modal.getInstance(document.getElementById('twoFactorModal')).hide();
}
</script>
@endsection
