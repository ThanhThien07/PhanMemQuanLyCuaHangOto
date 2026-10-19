@extends('layouts.giaodien')

@section('title', 'Thời Khóa Biểu Đăng Ký Lái Thử Xe VIP - PrimeLux Auto')
@section('meta_description', 'Đăng ký lịch lái thử các dòng xe sang Mercedes-Benz, Porsche, BMW, Audi, Lexus tại tư gia hoặc showroom PrimeLux Auto với chuyên viên VIP.')

@push('styles')
<style>
    /* TIMETABLE & TEST DRIVE LUXURY STYLES */
    .timetable-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        border-radius: 20px;
        overflow: hidden;
    }

    .section-header-banner {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(37, 99, 235, 0.08) 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 2.2rem 1.5rem;
    }

    /* DATE STRIP PILLS */
    .date-scroll-container {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: thin;
        scrollbar-color: rgba(245, 158, 11, 0.3) transparent;
    }

    .date-scroll-container::-webkit-scrollbar {
        height: 5px;
    }
    .date-scroll-container::-webkit-scrollbar-thumb {
        background: rgba(245, 158, 11, 0.4);
        border-radius: 10px;
    }

    .date-pill-btn {
        flex: 0 0 auto;
        min-width: 105px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 10px 12px;
        text-align: center;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }

    .date-pill-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(245, 158, 11, 0.5);
        transform: translateY(-2px);
    }

    .date-pill-btn.active {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.25) 0%, rgba(217, 119, 6, 0.35) 100%);
        border: 1.5px solid var(--accent-gold);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        transform: translateY(-2px);
    }

    .date-pill-day {
        font-size: 11.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary);
    }

    .date-pill-btn.active .date-pill-day {
        color: #fde68a;
    }

    .date-pill-number {
        font-size: 19px;
        font-weight: 800;
        line-height: 1.2;
        margin: 2px 0;
        color: #fff;
    }

    .date-pill-month {
        font-size: 11px;
        color: var(--text-secondary);
    }

    /* SESSION BLOCK (SÁNG / CHIỀU) */
    .session-block {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 22px;
        transition: border-color 0.3s ease;
    }

    .session-block:hover {
        border-color: rgba(255, 255, 255, 0.15);
    }

    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
    }

    .session-title {
        font-size: 17px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .session-time-range {
        font-size: 12px;
        background: rgba(255, 255, 255, 0.06);
        padding: 4px 10px;
        border-radius: 20px;
        color: var(--text-secondary);
    }

    /* SLOT CARDS */
    .slot-card {
        background: rgba(17, 24, 39, 0.85);
        border: 1.5px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .slot-card:hover:not(.disabled):not(.booked) {
        border-color: var(--accent-gold);
        background: rgba(31, 41, 55, 0.95);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
    }

    .slot-card.active {
        border-color: var(--accent-gold) !important;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18) 0%, rgba(17, 24, 39, 0.95) 100%) !important;
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.28) !important;
        transform: translateY(-2px);
    }

    .slot-card.active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--accent-gold);
    }

    .slot-card.disabled {
        opacity: 0.42;
        cursor: not-allowed;
        background: rgba(17, 24, 39, 0.5);
        border-style: dashed;
    }

    .slot-card.booked {
        opacity: 0.55;
        cursor: not-allowed;
        background: rgba(239, 68, 68, 0.06);
        border-color: rgba(239, 68, 68, 0.3);
    }

    .slot-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .slot-name {
        font-size: 13px;
        font-weight: 700;
        color: #e2e8f0;
    }

    .slot-duration {
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 6px;
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        font-weight: 600;
    }

    .slot-time {
        font-size: 17px;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .slot-card.active .slot-time {
        color: #fde68a;
    }

    .slot-desc {
        font-size: 11.5px;
        color: var(--text-secondary);
        line-height: 1.4;
        margin-bottom: 10px;
    }

    .slot-status-pill {
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* VIP TICKET PREVIEW CARD */
    .vip-ticket-preview {
        background: linear-gradient(135deg, #0d1322 0%, #151d30 100%);
        border: 1px solid rgba(245, 158, 11, 0.35);
        border-radius: 16px;
        padding: 20px;
        position: relative;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .vip-ticket-preview::after {
        content: 'VIP PASS';
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 10px;
        letter-spacing: 2px;
        font-weight: 800;
        color: rgba(245, 158, 11, 0.6);
        border: 1px solid rgba(245, 158, 11, 0.4);
        padding: 2px 8px;
        border-radius: 4px;
    }

    .ticket-dashed-line {
        border-top: 1.5px dashed rgba(255, 255, 255, 0.15);
        margin: 15px 0;
        position: relative;
    }

    .session-filter-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
        transition: all 0.2s ease;
    }

    .session-filter-btn:hover, .session-filter-btn.active {
        background: rgba(245, 158, 11, 0.2);
        border-color: var(--accent-gold);
        color: #fff;
    }

    /* ATTENTION PULSE ANIMATION */
    @keyframes scheduleAlertPulse {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    .pulse-attention {
        animation: scheduleAlertPulse 1.2s infinite;
        border-color: var(--accent-gold) !important;
    }
</style>
@endpush

@section('content')
<div class="container py-4 py-lg-5">
    <!-- BREADCRUMB & HEADER -->
    <div class="timetable-wrapper mb-4">
        <div class="section-header-banner text-center text-md-start">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="section-tag mb-2 d-inline-block">
                        <i class="fa-solid fa-calendar-check text-warning me-2"></i> Lịch Trải Nghiệm Xe VIP PrimeLux
                    </span>
                    <h1 class="h2 fw-bold text-white mb-2">Thời Khóa Biểu Đăng Ký Lái Thử</h1>
                    <p class="text-secondary mb-0">
                        Đặt lịch dễ dàng theo thời khóa biểu chuẩn <strong>2 buổi Sáng & Chiều</strong>. Mỗi ca trải nghiệm trọn vẹn <strong>1 giờ 30 phút</strong> cùng chuyên viên kỹ thuật VIP và bảo hiểm đầy đủ.
                    </p>
                </div>
                <div class="col-md-4 mt-3 mt-md-0 text-md-end">
                    <div class="d-inline-flex flex-column gap-2 text-start bg-black bg-opacity-25 p-3 rounded-3 border border-secondary border-opacity-25">
                        <div class="small text-light d-flex align-items-center gap-2">
                            <i class="fa-solid fa-stopwatch text-warning"></i>
                            <span>Thời lượng mỗi ca: <strong>1 Giờ 30 Phút</strong></span>
                        </div>
                        <div class="small text-light d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sun text-warning"></i>
                            <span>2 Buổi cố định: <strong>Sáng & Chiều</strong></span>
                        </div>
                        <div class="small text-light d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-info"></i>
                            <span>Bảo hiểm & lộ trình: <strong>Độc quyền VIP</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN INTERACTIVE TIMETABLE & FORM -->
    <div class="row g-4">
        <!-- CỘT BÊN TRÁI: THỜI KHÓA BIỂU (TIMETABLE BOARD) -->
        <div class="col-lg-7 col-xl-8">
            <div class="p-3 p-md-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);" id="timetableContainer">
                
                <!-- BƯỚC 1: THANH CHỌN NGÀY (DATE SELECTOR STRIP) -->
                <div class="mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <label class="fw-bold text-white small text-uppercase tracking-wider">
                            <i class="fa-solid fa-calendar-day text-warning me-1"></i> Bước 1: Chọn Ngày Trải Nghiệm
                        </label>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-secondary d-none d-sm-inline">Hoặc ngày khác:</span>
                            <input type="date" id="customDatePicker" class="form-control form-control-sm form-control-custom" style="max-width: 160px; padding: 4px 10px; font-size: 13px;">
                        </div>
                    </div>

                    <!-- THANH CHỌN NHANH 7 NGÀY TỚI -->
                    <div class="date-scroll-container pb-2" id="dateScrollStrip">
                        <!-- Rendered by JavaScript -->
                    </div>

                    <!-- THÔNG BÁO NGÀY ĐANG CHỌN -->
                    <div class="mt-2 p-2 px-3 rounded-3 d-flex align-items-center justify-content-between" style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2);">
                        <div class="small text-light">
                            <i class="fa-regular fa-calendar-check text-warning me-2"></i>
                            Thời khóa biểu ngày: <strong id="lblSelectedDateText" class="text-warning">--</strong>
                        </div>
                        <span class="badge bg-dark border border-secondary text-secondary small" id="lblDateStatusTag">Lịch hiện thời</span>
                    </div>
                </div>

                <!-- BƯỚC 2: BẢNG PHÂN CA 2 BUỔI (SÁNG / CHIỀU - 1H30/CA) -->
                <div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <label class="fw-bold text-white small text-uppercase tracking-wider">
                            <i class="fa-solid fa-table-cells-large text-warning me-1"></i> Bước 2: Chọn Khung Giờ Trên Thời Khóa Biểu (1h30 / Ca)
                        </label>

                        <!-- LỌC BUỔI NHANH -->
                        <div class="d-flex gap-1" id="sessionFilters">
                            <button type="button" class="session-filter-btn active" data-filter="all">Tất Cả (6 Ca)</button>
                            <button type="button" class="session-filter-btn" data-filter="sang"><i class="fa-solid fa-sun text-warning me-1"></i> Buổi Sáng</button>
                            <button type="button" class="session-filter-btn" data-filter="chieu"><i class="fa-solid fa-cloud-sun text-info me-1"></i> Buổi Chiều</button>
                        </div>
                    </div>

                    <!-- BUỔI SÁNG -->
                    <div class="session-block session-group" id="groupMorning">
                        <div class="session-header">
                            <div class="session-title text-warning">
                                <i class="fa-solid fa-sun fa-lg"></i>
                                <div>
                                    <span class="text-white">BUỔI SÁNG</span>
                                    <div class="small fw-normal text-secondary" style="font-size: 11px;">Thời gian mở cửa đón khách: 08:00 – 12:30</div>
                                </div>
                            </div>
                            <span class="session-time-range"><i class="fa-solid fa-clock me-1"></i> 3 Khung Giờ (1h30 / Ca)</span>
                        </div>

                        <div class="row g-3" id="morningSlotsRow">
                            <!-- Slot S1: 08:00 - 09:30 -->
                            <div class="col-md-4">
                                <div class="slot-card" data-slot-id="s1" data-session="sáng" data-start="08:00" data-end="09:30" onclick="selectSlot('s1', 'sáng', '08:00', '09:30', 'Ca Sáng 1')">
                                    <div>
                                        <div class="slot-top-row">
                                            <span class="slot-name">Ca Sáng 1</span>
                                            <span class="slot-duration"><i class="fa-solid fa-stopwatch me-1"></i>1h30</span>
                                        </div>
                                        <div class="slot-time">
                                            <span>08:00</span>
                                            <i class="fa-solid fa-arrow-right-long text-secondary" style="font-size: 12px;"></i>
                                            <span>09:30</span>
                                        </div>
                                        <div class="slot-desc">Khởi đầu ngày mới, đường thông thoáng & thuận tiện thử xe</div>
                                    </div>
                                    <div class="slot-status-pill text-success" id="status-s1">
                                        <i class="fa-solid fa-circle-dot"></i> <span>Còn trống</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slot S2: 09:30 - 11:00 -->
                            <div class="col-md-4">
                                <div class="slot-card" data-slot-id="s2" data-session="sáng" data-start="09:30" data-end="11:00" onclick="selectSlot('s2', 'sáng', '09:30', '11:00', 'Ca Sáng 2')">
                                    <div>
                                        <div class="slot-top-row">
                                            <span class="slot-name">Ca Sáng 2</span>
                                            <span class="slot-duration"><i class="fa-solid fa-stopwatch me-1"></i>1h30</span>
                                        </div>
                                        <div class="slot-time">
                                            <span>09:30</span>
                                            <i class="fa-solid fa-arrow-right-long text-secondary" style="font-size: 12px;"></i>
                                            <span>11:00</span>
                                        </div>
                                        <div class="slot-desc">Khung giờ Vàng sáng - Ánh sáng đẹp, trải nghiệm trọn vẹn</div>
                                    </div>
                                    <div class="slot-status-pill text-warning" id="status-s2">
                                        <i class="fa-solid fa-star"></i> <span>Giờ Vàng VIP</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slot S3: 11:00 - 12:30 -->
                            <div class="col-md-4">
                                <div class="slot-card" data-slot-id="s3" data-session="sáng" data-start="11:00" data-end="12:30" onclick="selectSlot('s3', 'sáng', '11:00', '12:30', 'Ca Sáng 3')">
                                    <div>
                                        <div class="slot-top-row">
                                            <span class="slot-name">Ca Sáng 3</span>
                                            <span class="slot-duration"><i class="fa-solid fa-stopwatch me-1"></i>1h30</span>
                                        </div>
                                        <div class="slot-time">
                                            <span>11:00</span>
                                            <i class="fa-solid fa-arrow-right-long text-secondary" style="font-size: 12px;"></i>
                                            <span>12:30</span>
                                        </div>
                                        <div class="slot-desc">Lái thử thư thái trước giờ ăn trưa, phục vụ nước uống VIP</div>
                                    </div>
                                    <div class="slot-status-pill text-success" id="status-s3">
                                        <i class="fa-solid fa-circle-dot"></i> <span>Còn trống</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BUỔI CHIỀU -->
                    <div class="session-block session-group" id="groupAfternoon">
                        <div class="session-header">
                            <div class="session-title text-info">
                                <i class="fa-solid fa-cloud-sun fa-lg"></i>
                                <div>
                                    <span class="text-white">BUỔI CHIỀU</span>
                                    <div class="small fw-normal text-secondary" style="font-size: 11px;">Thời gian mở cửa đón khách: 13:30 – 18:00</div>
                                </div>
                            </div>
                            <span class="session-time-range"><i class="fa-solid fa-clock me-1"></i> 3 Khung Giờ (1h30 / Ca)</span>
                        </div>

                        <div class="row g-3" id="afternoonSlotsRow">
                            <!-- Slot C1: 13:30 - 15:00 -->
                            <div class="col-md-4">
                                <div class="slot-card" data-slot-id="c1" data-session="chiều" data-start="13:30" data-end="15:00" onclick="selectSlot('c1', 'chiều', '13:30', '15:00', 'Ca Chiều 1')">
                                    <div>
                                        <div class="slot-top-row">
                                            <span class="slot-name">Ca Chiều 1</span>
                                            <span class="slot-duration"><i class="fa-solid fa-stopwatch me-1"></i>1h30</span>
                                        </div>
                                        <div class="slot-time">
                                            <span>13:30</span>
                                            <i class="fa-solid fa-arrow-right-long text-secondary" style="font-size: 12px;"></i>
                                            <span>15:00</span>
                                        </div>
                                        <div class="slot-desc">Đầu giờ chiều yên tĩnh, không gian lái riêng tư và tập trung</div>
                                    </div>
                                    <div class="slot-status-pill text-success" id="status-c1">
                                        <i class="fa-solid fa-circle-dot"></i> <span>Còn trống</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slot C2: 15:00 - 16:30 -->
                            <div class="col-md-4">
                                <div class="slot-card" data-slot-id="c2" data-session="chiều" data-start="15:00" data-end="16:30" onclick="selectSlot('c2', 'chiều', '15:00', '16:30', 'Ca Chiều 2')">
                                    <div>
                                        <div class="slot-top-row">
                                            <span class="slot-name">Ca Chiều 2</span>
                                            <span class="slot-duration"><i class="fa-solid fa-stopwatch me-1"></i>1h30</span>
                                        </div>
                                        <div class="slot-time">
                                            <span>15:00</span>
                                            <i class="fa-solid fa-arrow-right-long text-secondary" style="font-size: 12px;"></i>
                                            <span>16:30</span>
                                        </div>
                                        <div class="slot-desc">Khung giờ Vàng chiều - Trải nghiệm tăng tốc & tiện nghi đẳng cấp</div>
                                    </div>
                                    <div class="slot-status-pill text-warning" id="status-c2">
                                        <i class="fa-solid fa-star"></i> <span>Giờ Vàng VIP</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slot C3: 16:30 - 18:00 -->
                            <div class="col-md-4">
                                <div class="slot-card" data-slot-id="c3" data-session="chiều" data-start="16:30" data-end="18:00" onclick="selectSlot('c3', 'chiều', '16:30', '18:00', 'Ca Chiều 3')">
                                    <div>
                                        <div class="slot-top-row">
                                            <span class="slot-name">Ca Chiều 3</span>
                                            <span class="slot-duration"><i class="fa-solid fa-stopwatch me-1"></i>1h30</span>
                                        </div>
                                        <div class="slot-time">
                                            <span>16:30</span>
                                            <i class="fa-solid fa-arrow-right-long text-secondary" style="font-size: 12px;"></i>
                                            <span>18:00</span>
                                        </div>
                                        <div class="slot-desc">Hoàng hôn VIP - Trải nghiệm đèn Matrix LED và đèn viền Ambient</div>
                                    </div>
                                    <div class="slot-status-pill text-info" id="status-c3">
                                        <i class="fa-solid fa-moon"></i> <span>Hoàng Hôn VIP</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GHI CHÚ CHÍNH SÁCH THỜI GIAN -->
                    <div class="p-3 rounded-3 d-flex align-items-start gap-3" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06);">
                        <i class="fa-solid fa-circle-info text-warning mt-1"></i>
                        <div class="small text-secondary">
                            <strong class="text-light">Lưu ý về Thời Khóa Biểu:</strong> Quý khách vui lòng có mặt trước 10 phút để nhận bàn giao xe và thưởng thức trà/cà phê VIP. Mỗi ca đã bao gồm 15 phút giới thiệu tính năng + 60 phút cầm lái thực tế trên cung đường đô thị/cao tốc + 15 phút tổng kết & tư vấn kỹ thuật.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- CỘT BÊN PHẢI: FORM THÔNG TIN KHÁCH HÀNG & THẺ LỊCH HẸN PREVIEW -->
        <div class="col-lg-5 col-xl-4">
            <div class="position-sticky" style="top: 90px;">
                <!-- THẺ PREVIEW LỊCH HẸN TRỰC TIẾP (VIP PASS PREVIEW) -->
                <div class="vip-ticket-preview mb-4" id="ticketPreviewCard">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-id-card-clip text-warning fa-lg"></i>
                        <div>
                            <div class="fw-bold text-white small text-uppercase">Phiếu Hẹn Lái Thử Trực Tuyến</div>
                            <div class="text-secondary" style="font-size: 11px;">PrimeLux Dealership Official Pass</div>
                        </div>
                    </div>

                    <!-- MẪU XE & SHOWROOM PREVIEW -->
                    <div class="mb-2">
                        <div class="text-secondary small">Mẫu xe đăng ký:</div>
                        <div class="fw-bold text-warning text-truncate" id="ticketCarName" style="font-size: 15px;">
                            {{ $selectedCar ?: ($cars[0]['name'] ?? 'Mẫu xe sang VIP') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-secondary small">Địa điểm đón tiếp:</div>
                        <div class="text-light small text-truncate" id="ticketLocation">
                            Showroom TP. Hồ Chí Minh
                        </div>
                    </div>

                    <div class="ticket-dashed-line"></div>

                    <!-- NGÀY & KHUNG GIỜ ĐÃ CHỌN -->
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <div class="text-secondary small">Ngày hẹn:</div>
                            <div class="fw-bold text-white small" id="ticketDate">Chưa chọn ngày</div>
                        </div>
                        <div class="col-6">
                            <div class="text-secondary small">Thời lượng:</div>
                            <div class="fw-bold text-warning small"><i class="fa-solid fa-stopwatch me-1"></i>1 Giờ 30 Phút</div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="text-secondary small">Khung giờ trải nghiệm:</div>
                            <div class="fw-bold text-success" id="ticketSlotTime" style="font-size: 14px;">
                                <i class="fa-solid fa-hand-pointer text-warning me-1"></i> Vui lòng chọn ca trên biểu
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM ĐIỀN THÔNG TIN KHÁCH HÀNG -->
                <div class="p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-check text-warning"></i> Thông Tin Khách Hàng
                    </h5>

                    <form id="testDriveForm">
                        <!-- HIDDEN DATETIME GỬI LÊN CONTROLLER THEO FORMAT YYYY-MM-DD HH:MM:00 -->
                        <input type="hidden" id="tdDate" name="thoi_gian" required>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Họ và Tên (*)</label>
                            <input type="text" id="tdName" class="form-control form-control-custom" required placeholder="Ví dụ: Nguyễn Văn Hoàng">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Số Điện Thoại (*)</label>
                            <input type="tel" id="tdPhone" class="form-control form-control-custom" required placeholder="Ví dụ: 0901 234 567">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Email Nhận Lịch Hẹn</label>
                            <input type="email" id="tdEmail" class="form-control form-control-custom" placeholder="example@gmail.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Mẫu Xe Muốn Lái Thử (*)</label>
                            <select id="tdCarSelect" class="form-select form-select-custom" required>
                                @foreach($cars as $car)
                                    <option value="{{ $car['name'] }}" {{ $selectedCar === $car['name'] ? 'selected' : '' }}>
                                        {{ $car['name'] }} ({{ $car['priceText'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Địa Điểm Showroom (*)</label>
                            <select id="tdLocation" class="form-select form-select-custom" required>
                                <option value="Showroom TP. Hồ Chí Minh">Showroom TP. Hồ Chí Minh (Phạm Văn Chiêu, Gò Vấp)</option>
                                <option value="Showroom Hà Nội">Showroom Hà Nội (Vinhomes Riverside, Long Biên)</option>
                                <option value="Showroom Đà Nẵng">Showroom Đà Nẵng (Nguyễn Văn Linh, Thanh Khê)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Ghi Chú Yêu Cầu Thêm</label>
                            <textarea id="tdNote" class="form-control form-control-custom" rows="2" placeholder="Yêu cầu mang xe tận nhà, số lượng người cùng đi..."></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-gold btn-lg w-100 fw-bold shadow-sm" id="btnSubmitForm">
                                <i class="fa-solid fa-paper-plane me-2"></i> Xác Nhận Đăng Ký Lái Thử
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-secondary" style="font-size: 11.5px;">
                                <i class="fa-solid fa-lock text-warning me-1"></i> Thông tin cam kết bảo mật 100%. Hotline: <strong>1900 8888</strong>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL XÁC NHẬN THÀNH CÔNG -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border border-secondary text-white rounded-4 shadow-lg">
            <div class="modal-header border-secondary border-opacity-50">
                <h5 class="modal-title text-success fw-bold">
                    <i class="fa-solid fa-circle-check me-2"></i> Đăng Ký Lái Thử Thành Công!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4 px-4">
                <div class="mb-3">
                    <div class="d-inline-flex p-3 rounded-circle" style="background: rgba(245, 158, 11, 0.15); border: 2px solid var(--accent-gold);">
                        <i class="fa-solid fa-calendar-star text-warning fa-3x"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-white mb-2">PrimeLux Đã Ghi Nhận Lịch Hẹn!</h4>
                <p class="text-secondary small mb-3">Mã lịch hẹn VIP của Quý khách đã được gửi đến hệ thống quản lý showroom.</p>

                <!-- THẺ CHI TIẾT LỊCH ĐÃ ĐẶT -->
                <div class="p-3 rounded-3 text-start mb-3" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="row g-2 small">
                        <div class="col-5 text-secondary">Mã lịch hẹn:</div>
                        <div class="col-7 fw-bold text-warning text-end" id="resBookingCode">TD-XXXXX</div>

                        <div class="col-5 text-secondary">Khách hàng:</div>
                        <div class="col-7 fw-bold text-white text-end text-truncate" id="resCustomerName">--</div>

                        <div class="col-5 text-secondary">Mẫu xe:</div>
                        <div class="col-7 fw-bold text-warning text-end text-truncate" id="resCarName">--</div>

                        <div class="col-5 text-secondary">Khung giờ (1h30):</div>
                        <div class="col-7 fw-bold text-success text-end" id="resDateTime">--</div>

                        <div class="col-5 text-secondary">Showroom:</div>
                        <div class="col-7 text-white text-end text-truncate" id="resShowroom">--</div>
                    </div>
                </div>

                <p class="text-secondary small mb-0">Chuyên viên tư vấn VIP sẽ liên hệ qua điện thoại trong vòng 15 phút để xác nhận lộ trình lái thử.</p>
            </div>
            <div class="modal-footer border-secondary border-opacity-50 justify-content-center gap-2">
                <button type="button" class="btn btn-outline-light px-3" data-bs-dismiss="modal">Đóng</button>
                <a href="{{ url('/') }}" class="btn btn-gold px-4 fw-bold">Trở Về Trang Chủ</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // DỮ LIỆU ĐÃ ĐẶT TỪ CONTROLLER
    const existingBookings = @json($existingBookings ?? []);

    // CẤU HÌNH THỜI KHÓA BIỂU: 2 BUỔI (SÁNG / CHIỀU) - MỖI CA 1H30
    const SLOTS = [
        { id: 's1', session: 'sáng', start: '08:00', end: '09:30', name: 'Ca Sáng 1', desc: 'Khởi đầu ngày mới, đường thông thoáng & thuận tiện thử xe', tag: 'Sẵn sàng' },
        { id: 's2', session: 'sáng', start: '09:30', end: '11:00', name: 'Ca Sáng 2', desc: 'Khung giờ Vàng sáng - Ánh sáng đẹp, trải nghiệm trọn vẹn', tag: 'Giờ Vàng VIP' },
        { id: 's3', session: 'sáng', start: '11:00', end: '12:30', name: 'Ca Sáng 3', desc: 'Lái thử thư thái trước giờ ăn trưa, phục vụ nước uống VIP', tag: 'Sẵn sàng' },
        { id: 'c1', session: 'chiều', start: '13:30', end: '15:00', name: 'Ca Chiều 1', desc: 'Đầu giờ chiều yên tĩnh, không gian lái riêng tư và tập trung', tag: 'Sẵn sàng' },
        { id: 'c2', session: 'chiều', start: '15:00', end: '16:30', name: 'Ca Chiều 2', desc: 'Khung giờ Vàng chiều - Trải nghiệm tăng tốc & tiện nghi đẳng cấp', tag: 'Giờ Vàng VIP' },
        { id: 'c3', session: 'chiều', start: '16:30', end: '18:00', name: 'Ca Chiều 3', desc: 'Hoàng hôn VIP - Trải nghiệm đèn Matrix LED và đèn viền Ambient', tag: 'Hoàng Hôn VIP' },
    ];

    // STATE HIỆN TẠI
    let selectedDateString = ''; // YYYY-MM-DD
    let selectedSlotData = null;  // Object slot được chọn

    // ĐỊNH DẠNG TÊN THỨ TRONG TUẦN
    const DAYS_OF_WEEK = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];

    function padZero(num) {
        return num < 10 ? '0' + num : '' + num;
    }

    function formatDateToYMD(d) {
        return `${d.getFullYear()}-${padZero(d.getMonth() + 1)}-${padZero(d.getDate())}`;
    }

    function formatDisplayDate(dateObj) {
        const dayOfWeek = DAYS_OF_WEEK[dateObj.getDay()];
        const day = padZero(dateObj.getDate());
        const month = padZero(dateObj.getMonth() + 1);
        const year = dateObj.getFullYear();
        return `${dayOfWeek}, ${day}/${month}/${year}`;
    }

    // KHỞI TẠO THANH CHỌN 7 NGÀY
    function initDateStrip() {
        const container = document.getElementById('dateScrollStrip');
        container.innerHTML = '';

        const today = new Date();
        const customPicker = document.getElementById('customDatePicker');
        customPicker.min = formatDateToYMD(today);

        // Tạo 7 ngày liên tiếp
        for (let i = 0; i < 7; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            const ymd = formatDateToYMD(date);

            let dayLabel = DAYS_OF_WEEK[date.getDay()];
            if (i === 0) dayLabel = 'Hôm nay';
            else if (i === 1) dayLabel = 'Ngày mai';

            const btn = document.createElement('div');
            btn.className = `date-pill-btn ${i === 0 ? 'active' : ''}`;
            btn.dataset.date = ymd;
            btn.innerHTML = `
                <div class="date-pill-day">${dayLabel}</div>
                <div class="date-pill-number">${padZero(date.getDate())}</div>
                <div class="date-pill-month">Tháng ${padZero(date.getMonth() + 1)}</div>
            `;

            btn.addEventListener('click', () => {
                document.querySelectorAll('.date-pill-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                setDate(ymd);
            });

            container.appendChild(btn);
        }

        // Mặc định chọn hôm nay
        setDate(formatDateToYMD(today));

        // Lắng nghe sự kiện chọn ngày bất kỳ từ input date
        customPicker.addEventListener('change', (e) => {
            if (e.target.value) {
                // Kiểm tra xem nút có trong danh sách 7 ngày không
                let foundBtn = null;
                document.querySelectorAll('.date-pill-btn').forEach(b => {
                    b.classList.remove('active');
                    if (b.dataset.date === e.target.value) {
                        foundBtn = b;
                    }
                });
                if (foundBtn) {
                    foundBtn.classList.add('active');
                }
                setDate(e.target.value);
            }
        });
    }

    // ĐẶT NGÀY & CẬP NHẬT THỜI KHÓA BIỂU
    function setDate(ymd) {
        selectedDateString = ymd;
        document.getElementById('customDatePicker').value = ymd;

        const parts = ymd.split('-');
        const dateObj = new Date(parts[0], parseInt(parts[1]) - 1, parts[2]);
        const formattedDate = formatDisplayDate(dateObj);

        document.getElementById('lblSelectedDateText').textContent = formattedDate;
        document.getElementById('ticketDate').textContent = `${padZero(dateObj.getDate())}/${padZero(dateObj.getMonth() + 1)}/${dateObj.getFullYear()}`;

        const todayYMD = formatDateToYMD(new Date());
        const tag = document.getElementById('lblDateStatusTag');
        if (ymd === todayYMD) {
            tag.textContent = 'Hôm nay';
            tag.className = 'badge bg-warning text-dark small';
        } else {
            tag.textContent = 'Lịch sắp tới';
            tag.className = 'badge bg-dark border border-secondary text-secondary small';
        }

        // Cập nhật tình trạng các ca trên thời khóa biểu
        updateSlotsAvailability();

        // Nếu slot đã chọn bị hết hạn hoặc không khả dụng thì xóa chọn
        if (selectedSlotData) {
            checkCurrentSelectionValid();
        }
    }

    // KIỂM TRA TRẠNG THÁI CÁC CA (ĐÃ QUA GIỜ / ĐÃ KÍN LỊCH / CÒN TRỐNG)
    function updateSlotsAvailability() {
        const now = new Date();
        const todayYMD = formatDateToYMD(now);
        const currentHour = now.getHours();
        const currentMinute = now.getMinutes();
        const selectedShowroom = document.getElementById('tdLocation').value;

        SLOTS.forEach(slot => {
            const card = document.querySelector(`.slot-card[data-slot-id="${slot.id}"]`);
            const statusEl = document.getElementById(`status-${slot.id}`);
            if (!card || !statusEl) return;

            // 1. Kiểm tra nếu là ngày hôm nay và đã qua giờ
            let isPast = false;
            if (selectedDateString === todayYMD) {
                const [slotH, slotM] = slot.start.split(':').map(Number);
                if (currentHour > slotH || (currentHour === slotH && currentMinute >= slotM)) {
                    isPast = true;
                }
            }

            // 2. Kiểm tra nếu trùng lịch đã đặt ở showroom này
            const checkDateTime = `${selectedDateString} ${slot.start}`;
            const isBooked = existingBookings.some(b => {
                return b.showroom === selectedShowroom && (b.thoi_gian === checkDateTime || b.thoi_gian === `${checkDateTime}:00`);
            });

            // Reset class
            card.classList.remove('disabled', 'booked');

            if (isPast) {
                card.classList.add('disabled');
                statusEl.className = 'slot-status-pill text-secondary';
                statusEl.innerHTML = '<i class="fa-solid fa-lock"></i> <span>Đã qua giờ</span>';
            } else if (isBooked) {
                card.classList.add('booked');
                statusEl.className = 'slot-status-pill text-danger';
                statusEl.innerHTML = '<i class="fa-solid fa-user-xmark"></i> <span>Đã kín lịch</span>';
            } else {
                // Khả dụng
                if (slot.id === (selectedSlotData?.id)) {
                    statusEl.className = 'slot-status-pill text-warning fw-bold';
                    statusEl.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>✓ Đang Chọn</span>';
                } else if (slot.tag === 'Giờ Vàng VIP') {
                    statusEl.className = 'slot-status-pill text-warning';
                    statusEl.innerHTML = '<i class="fa-solid fa-star"></i> <span>Giờ Vàng VIP</span>';
                } else if (slot.tag === 'Hoàng Hôn VIP') {
                    statusEl.className = 'slot-status-pill text-info';
                    statusEl.innerHTML = '<i class="fa-solid fa-moon"></i> <span>Hoàng Hôn VIP</span>';
                } else {
                    statusEl.className = 'slot-status-pill text-success';
                    statusEl.innerHTML = '<i class="fa-solid fa-circle-dot"></i> <span>Còn trống</span>';
                }
            }
        });
    }

    // CHỌN CA LÁI THỬ TRÊN THỜI KHÓA BIỂU
    function selectSlot(slotId, session, start, end, slotName) {
        const card = document.querySelector(`.slot-card[data-slot-id="${slotId}"]`);
        if (!card || card.classList.contains('disabled') || card.classList.contains('booked')) {
            return;
        }

        // Bỏ active tất cả các ca
        document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        // Lưu thông tin ca
        selectedSlotData = {
            id: slotId,
            session: session,
            start: start,
            end: end,
            name: slotName
        };

        // Ghi giá trị vào hidden input datetime (Format: YYYY-MM-DD HH:MM:00)
        const fullDateTime = `${selectedDateString} ${start}:00`;
        document.getElementById('tdDate').value = fullDateTime;

        // Cập nhật hiển thị trên VIP Pass Preview
        const sessionNameUpper = session === 'sáng' ? 'Buổi Sáng' : 'Buổi Chiều';
        document.getElementById('ticketSlotTime').innerHTML = `
            <span class="text-warning">${sessionNameUpper} (${slotName}):</span> 
            <strong>${start} – ${end}</strong> 
            <span class="badge bg-warning text-dark ms-1">1h30</span>
        `;

        // Xóa viền báo lỗi nếu có
        document.getElementById('timetableContainer').classList.remove('pulse-attention');

        updateSlotsAvailability();
    }

    function checkCurrentSelectionValid() {
        if (!selectedSlotData) return;
        const card = document.querySelector(`.slot-card[data-slot-id="${selectedSlotData.id}"]`);
        if (!card || card.classList.contains('disabled') || card.classList.contains('booked')) {
            // Hủy chọn vì không còn hợp lệ trên ngày/showroom này
            card?.classList.remove('active');
            selectedSlotData = null;
            document.getElementById('tdDate').value = '';
            document.getElementById('ticketSlotTime').innerHTML = `
                <i class="fa-solid fa-hand-pointer text-warning me-1"></i> Vui lòng chọn ca trên biểu
            `;
        } else {
            // Cập nhật lại giá trị datetime
            const fullDateTime = `${selectedDateString} ${selectedSlotData.start}:00`;
            document.getElementById('tdDate').value = fullDateTime;
        }
    }

    // SỰ KIỆN KHỞI CHẠY KHI TẢI TRANG
    document.addEventListener("DOMContentLoaded", () => {
        // Khởi tạo thanh chọn ngày & thời khóa biểu
        initDateStrip();

        // Đồng bộ chọn xe từ query string ?car=...
        const carSelect = document.getElementById("tdCarSelect");
        const locationSelect = document.getElementById("tdLocation");
        const ticketCarName = document.getElementById("ticketCarName");
        const ticketLocation = document.getElementById("ticketLocation");

        const urlParams = new URLSearchParams(window.location.search);
        const carParam = urlParams.get("car");
        if (carParam && carSelect) {
            carSelect.value = decodeURIComponent(carParam);
        }

        if (carSelect) {
            ticketCarName.textContent = carSelect.value;
            carSelect.addEventListener('change', () => {
                ticketCarName.textContent = carSelect.value;
            });
        }

        if (locationSelect) {
            ticketLocation.textContent = locationSelect.value;
            locationSelect.addEventListener('change', () => {
                ticketLocation.textContent = locationSelect.value;
                updateSlotsAvailability();
                checkCurrentSelectionValid();
            });
        }

        // Bộ lọc buổi (Tất cả / Sáng / Chiều)
        const filterBtns = document.querySelectorAll('.session-filter-btn');
        const morningGroup = document.getElementById('groupMorning');
        const afternoonGroup = document.getElementById('groupAfternoon');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;
                if (filter === 'sang') {
                    morningGroup.style.display = 'block';
                    afternoonGroup.style.display = 'none';
                } else if (filter === 'chieu') {
                    morningGroup.style.display = 'none';
                    afternoonGroup.style.display = 'block';
                } else {
                    morningGroup.style.display = 'block';
                    afternoonGroup.style.display = 'block';
                }
            });
        });

        // XỬ LÝ SUBMIT FORM ĐĂNG KÝ
        const form = document.getElementById("testDriveForm");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const dateValue = document.getElementById("tdDate").value;
            if (!dateValue || !selectedSlotData) {
                // Chưa chọn ca trên thời khóa biểu
                const timetableBox = document.getElementById('timetableContainer');
                timetableBox.classList.add('pulse-attention');
                timetableBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

                alert("Quý khách vui lòng chọn 1 khung giờ trong Thời Khóa Biểu (Sáng hoặc Chiều, 1h30/ca) trước khi xác nhận!");
                return;
            }

            const submitBtn = document.getElementById("btnSubmitForm");
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Đang ghi nhận lịch...';

            const payload = {
                ho_ten: document.getElementById("tdName").value.trim(),
                sdt: document.getElementById("tdPhone").value.trim(),
                email: document.getElementById("tdEmail").value.trim() || "N/A",
                ten_xe: carSelect.value,
                showroom: locationSelect.value,
                thoi_gian: dateValue,
                ghi_chu: document.getElementById("tdNote").value.trim() || ""
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
                    // Cập nhật thông tin lên modal xác nhận thành công
                    document.getElementById('resBookingCode').textContent = result.data?.id || 'TD-VIP';
                    document.getElementById('resCustomerName').textContent = payload.ho_ten;
                    document.getElementById('resCarName').textContent = payload.ten_xe;
                    document.getElementById('resShowroom').textContent = payload.showroom;

                    const parts = selectedDateString.split('-');
                    const dateFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
                    const sessionUpper = selectedSlotData.session === 'sáng' ? 'Buổi Sáng' : 'Buổi Chiều';
                    document.getElementById('resDateTime').textContent = `${dateFormatted} • ${sessionUpper} (${selectedSlotData.start} - ${selectedSlotData.end})`;

                    // Thêm vào existingBookings cục bộ để slot đó chuyển thành đã kín ngay lập tức
                    existingBookings.push({
                        showroom: payload.showroom,
                        thoi_gian: payload.thoi_gian.substring(0, 16)
                    });
                    updateSlotsAvailability();

                    // Mở Modal
                    const modal = new bootstrap.Modal(document.getElementById("successModal"));
                    modal.show();

                    // Reset form ngoại trừ ngày và xe
                    document.getElementById("tdName").value = '';
                    document.getElementById("tdPhone").value = '';
                    document.getElementById("tdEmail").value = '';
                    document.getElementById("tdNote").value = '';
                    document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('active'));
                    selectedSlotData = null;
                    document.getElementById('tdDate').value = '';
                    document.getElementById('ticketSlotTime').innerHTML = `
                        <i class="fa-solid fa-hand-pointer text-warning me-1"></i> Vui lòng chọn ca trên biểu
                    `;
                } else {
                    alert("Có lỗi xảy ra: " + (result.message || "Vui lòng thử lại sau."));
                }
            } catch (err) {
                console.error("Test drive booking error:", err);
                alert("Đã xảy ra lỗi kết nối mạng. Vui lòng kiểm tra và thử lại!");
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    });
</script>
@endpush
