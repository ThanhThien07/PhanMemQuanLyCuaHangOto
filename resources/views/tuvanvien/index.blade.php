<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cổng Chuyên Viên Tư Vấn Trực Tuyến (Vue.js Realtime) - PrimeLux Advisor Portal</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Vue.js 3 Framework (Production Engine) -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <style>
        [v-cloak] {
            display: none !important;
        }

        body {
            background-color: #0b0f19;
            color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .advisor-navbar {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .stat-card-advisor {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 16px 20px;
            transition: all 0.25s ease;
        }

        .stat-card-advisor:hover {
            transform: translateY(-2px);
            border-color: rgba(234, 179, 8, 0.4);
        }

        .inquiry-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .inquiry-card:hover {
            background: rgba(51, 65, 85, 0.8);
            border-color: rgba(234, 179, 8, 0.3);
        }

        .inquiry-card.active {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        .inquiry-list-container {
            max-height: calc(100vh - 280px);
            overflow-y: auto;
            padding-right: 6px;
        }

        .inquiry-list-container::-webkit-scrollbar {
            width: 6px;
        }

        .inquiry-list-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
        }

        .reply-panel {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 24px;
            min-height: calc(100vh - 280px);
            display: flex;
            flex-direction: column;
        }

        .canned-chip {
            background: rgba(234, 179, 8, 0.1);
            color: #facc15;
            border: 1px solid rgba(234, 179, 8, 0.3);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block;
            margin: 3px;
            user-select: none;
        }

        .canned-chip:hover {
            background: #eab308;
            color: #000;
        }

        .status-badge-pending {
            background-color: #ef4444;
            color: #fff;
            animation: pulse-red 2s infinite;
        }

        .status-badge-progress {
            background-color: #3b82f6;
            color: #fff;
        }

        .status-badge-resolved {
            background-color: #10b981;
            color: #fff;
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .pulse-online {
            display: inline-block;
            width: 9px;
            height: 9px;
            background-color: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 8px #22c55e;
            margin-right: 6px;
            animation: pulse-green 1.5s infinite;
        }

        @keyframes pulse-green {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.2); }
            100% { opacity: 1; transform: scale(1); }
        }

        .vue-framework-badge {
            background: linear-gradient(135deg, #42b883, #35495e);
            color: #ffffff;
            font-weight: 600;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .new-alert-toast {
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>

<body>

    <div id="advisorApp" v-cloak>

        <!-- TOP NAVBAR CHO CHUYÊN VIÊN TƯ VẤN -->
        <nav class="navbar navbar-dark advisor-navbar sticky-top py-2 px-3 px-md-4">
            <div class="container-fluid px-0">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand d-flex align-items-center me-0" href="{{ url('/') }}">
                        <span class="fw-bold fs-4 text-warning">PRIMELUX</span>
                        <span class="badge bg-primary text-white ms-2 px-2 py-1 fs-6">ADVISOR DESK</span>
                    </a>

                    <!-- REALTIME ENGINE BADGE -->
                    <span class="vue-framework-badge d-none d-md-inline-flex">
                        <i class="fa-brands fa-vuejs fa-lg"></i> Vue.js 3 Realtime Engine
                    </span>

                    <span class="badge bg-dark border border-secondary text-light d-none d-lg-inline-flex align-items-center py-2 px-3">
                        <span class="pulse-online"></span> Đang Kết Nối Realtime (Tự động cập nhật không cần tải lại trang)
                    </span>
                </div>

                <div class="d-flex align-items-center gap-2 gap-md-3">
                    <span class="text-secondary small d-none d-xl-inline">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i>Đồng bộ lúc: <strong class="text-white">@{{ lastSyncTime }}</strong>
                    </span>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-globe me-1"></i> Trang Chủ Web
                    </a>
                    <a href="{{ url('/loyalty') }}" target="_blank" class="btn btn-outline-warning btn-sm">
                        <i class="fa-solid fa-crown me-1"></i> Cổng Hội Viên
                    </a>
                    <a href="{{ url('/admin') }}" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fa-solid fa-gauge-high me-1"></i> Quản Trị Hệ Thống
                    </a>
                </div>
            </div>
        </nav>

        <!-- THÔNG BÁO CÂU HỎI MỚI (TỰ ĐỘNG XUẤT HIỆN KHI CÓ KHÁCH HỎI) -->
        <div v-if="newInquiryAlert" class="alert alert-warning border-warning new-alert-toast mx-3 mx-md-4 mt-3 mb-0 d-flex align-items-center justify-content-between py-2 px-3 rounded-3" style="background: rgba(234, 179, 8, 0.15); color: #fef08a;">
            <div>
                <i class="fa-solid fa-bell fa-bounce text-warning me-2"></i>
                <strong>Có câu hỏi mới từ khách hàng!</strong> Dữ liệu đã được hệ thống cập nhật tự động lên giao diện.
            </div>
            <button type="button" class="btn-close btn-close-white btn-sm" @click="newInquiryAlert = false"></button>
        </div>

        <!-- MAIN WORKSPACE -->
        <div class="container-fluid px-3 px-md-4 py-4">

            <!-- THỐNG KÊ REALTIME COMPUTED TỰ ĐỘNG CẬP NHẬT -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-card-advisor d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase">Tổng Câu Hỏi Nhận</div>
                            <div class="fs-2 fw-bold text-white">@{{ stats.total }}</div>
                            <div class="text-secondary small">Cập nhật tự động liên tục</div>
                        </div>
                        <div class="p-3 rounded-3 bg-secondary bg-opacity-20 text-info fs-3">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card-advisor d-flex align-items-center justify-content-between" style="border-left: 4px solid #ef4444;">
                        <div>
                            <div class="text-danger small fw-bold text-uppercase">Chờ Phản Hồi Gấp</div>
                            <div class="fs-2 fw-bold text-danger">@{{ stats.pending }}</div>
                            <div class="text-secondary small">Cần chuyên viên giải đáp</div>
                        </div>
                        <div class="p-3 rounded-3 bg-danger bg-opacity-20 text-danger fs-3">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card-advisor d-flex align-items-center justify-content-between" style="border-left: 4px solid #3b82f6;">
                        <div>
                            <div class="text-info small fw-bold text-uppercase">Đang Tư Vấn</div>
                            <div class="fs-2 fw-bold text-info">@{{ stats.inProgress }}</div>
                            <div class="text-secondary small">Đang trao đổi cùng khách</div>
                        </div>
                        <div class="p-3 rounded-3 bg-primary bg-opacity-20 text-primary fs-3">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card-advisor d-flex align-items-center justify-content-between" style="border-left: 4px solid #10b981;">
                        <div>
                            <div class="text-success small fw-bold text-uppercase">Đã Giải Đáp Xong</div>
                            <div class="fs-2 fw-bold text-success">@{{ stats.resolved }}</div>
                            <div class="text-secondary small">Khách hàng hài lòng</div>
                        </div>
                        <div class="p-3 rounded-3 bg-success bg-opacity-20 text-success fs-3">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BỘ LỌC TRẠNG THÁI VÀ Ô TÌM KIẾM (TWO-WAY REACTIVE BINDING) -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div class="btn-group" role="group">
                    <button type="button" @click="statusFilter = 'all'" :class="['btn btn-sm', statusFilter === 'all' ? 'btn-primary' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-list me-1"></i> Tất Cả (@{{ stats.total }})
                    </button>
                    <button type="button" @click="statusFilter = 'Chờ phản hồi'" :class="['btn btn-sm', statusFilter === 'Chờ phản hồi' ? 'btn-danger' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-clock me-1"></i> Chờ Phản Hồi (@{{ stats.pending }})
                    </button>
                    <button type="button" @click="statusFilter = 'Đang tư vấn'" :class="['btn btn-sm', statusFilter === 'Đang tư vấn' ? 'btn-info text-white' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-spinner me-1"></i> Đang Tư Vấn (@{{ stats.inProgress }})
                    </button>
                    <button type="button" @click="statusFilter = 'Đã trả lời'" :class="['btn btn-sm', statusFilter === 'Đã trả lời' ? 'btn-success' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-check-double me-1"></i> Đã Giải Đáp (@{{ stats.resolved }})
                    </button>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: 300px;">
                        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fa-solid fa-search"></i></span>
                        <input type="text" v-model="searchQuery" class="form-control bg-dark border-secondary text-white" placeholder="Tìm theo tên, SĐT, nội dung...">
                        <button v-if="searchQuery" class="btn btn-outline-secondary" type="button" @click="searchQuery = ''"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" @click="fetchRealtimeFeed" title="Cập nhật ngay">
                        <i class="fa-solid fa-rotate" :class="{ 'fa-spin': isRefreshing }"></i>
                    </button>
                </div>
            </div>

            <!-- WORKSPACE CHÍNH: 2 CỘT TỰ ĐỘNG REACTIVE -->
            <div class="row g-4">
                
                <!-- CỘT TRÁI: DANH SÁCH YÊU CẦU & CÂU HỎI -->
                <div class="col-lg-5 col-xl-4">
                    <div class="p-3 rounded-4 bg-dark border border-secondary">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-white small text-uppercase">
                                <i class="fa-solid fa-inbox text-warning me-1"></i> Hộp Thư Yêu Cầu (@{{ filteredInquiries.length }})
                            </span>
                            <span class="text-secondary small"><i class="fa-solid fa-bolt text-warning me-1"></i>Tự động cập nhật</span>
                        </div>

                        <div class="inquiry-list-container">
                            <div v-for="item in filteredInquiries" 
                                 :key="item.ma_tin"
                                 :class="['inquiry-card', { active: activeInquiryId === item.ma_tin }]" 
                                 @click="selectInquiry(item.ma_tin)">
                                
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="fw-bold text-white fs-6">@{{ item.nguoi_gui }}</span>
                                        <span v-if="item.customer_info" :class="'badge bg-' + item.customer_info.badge + ' text-dark ms-1'" style="font-size: 10px;">
                                            <i class="fa-solid fa-gem me-1"></i>@{{ item.customer_info.tier_name }}
                                        </span>
                                    </div>
                                    <span :class="['badge', getStatusBadgeClass(item.trang_thai)]" style="font-size: 11px;">
                                        @{{ item.trang_thai }}
                                    </span>
                                </div>

                                <p class="text-light small mb-2 text-truncate" style="max-height: 40px; line-height: 1.4;">
                                    @{{ item.noi_dung }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center small text-secondary" style="font-size: 11px;">
                                    <span><i class="fa-solid fa-clock me-1"></i>@{{ item.thoi_gian }}</span>
                                    <span>
                                        <span v-if="item.sdt_khach">
                                            <i class="fa-solid fa-phone text-warning me-1"></i>@{{ item.sdt_khach }}
                                        </span>
                                        <span v-else class="font-monospace text-muted">@{{ item.ma_tin }}</span>
                                    </span>
                                </div>
                            </div>

                            <div v-if="filteredInquiries.length === 0" class="text-center py-5 text-secondary">
                                <i class="fa-regular fa-comment-dots fa-3x mb-3 text-muted"></i>
                                <p class="mb-0">Không tìm thấy câu hỏi phù hợp.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI: KHÔNG GIAN TƯ VẤN & TRẢ LỜI TRỰC TIẾP -->
                <div class="col-lg-7 col-xl-8">
                    <div class="reply-panel">
                        
                        <div v-if="activeInquiry">
                            <!-- HEADER KHÁCH HÀNG & HẠNG VIP -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center pb-3 mb-3 border-bottom border-secondary">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h4 class="fw-bold text-white mb-0">@{{ activeInquiry.nguoi_gui }}</h4>
                                        <span v-if="activeInquiry.customer_info" :class="'badge bg-' + activeInquiry.customer_info.badge + ' text-dark fs-6'">
                                            <i class="fa-solid fa-crown me-1"></i>@{{ activeInquiry.customer_info.tier_name }} (-@{{ activeInquiry.customer_info.discount }}%)
                                        </span>
                                    </div>
                                    <div class="text-secondary small">
                                        <span class="me-3"><i class="fa-solid fa-hashtag text-info me-1"></i>Mã tin: <strong class="text-white">@{{ activeInquiry.ma_tin }}</strong></span>
                                        <span class="me-3"><i class="fa-solid fa-phone text-warning me-1"></i>SĐT: <strong class="text-white">@{{ activeInquiry.sdt_khach || 'Chưa cung cấp' }}</strong></span>
                                        <span><i class="fa-solid fa-clock text-secondary me-1"></i>Nhận lúc: @{{ activeInquiry.thoi_gian }}</span>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-2 mt-sm-0">
                                    <a v-if="activeInquiry.sdt_khach" :href="'tel:' + activeInquiry.sdt_khach" class="btn btn-outline-warning btn-sm">
                                        <i class="fa-solid fa-phone me-1"></i> Gọi Điện Ngay
                                    </a>
                                    <span :class="['badge px-3 py-2 align-self-center fs-6', getStatusBadgeClass(activeInquiry.trang_thai)]">
                                        @{{ activeInquiry.trang_thai }}
                                    </span>
                                </div>
                            </div>

                            <!-- CHI TIẾT CÂU HỎI CỦA KHÁCH HÀNG -->
                            <div class="mb-4">
                                <label class="form-label text-warning small fw-bold text-uppercase">
                                    <i class="fa-solid fa-quote-left me-1"></i> Nội Dung Câu Hỏi Riêng Của Khách Hàng:
                                </label>
                                <div class="p-3 rounded-3 text-white" style="font-size: 15px; line-height: 1.6; background-color: #0d131f; border: 1px solid rgba(255, 255, 255, 0.1);">
                                    @{{ activeInquiry.noi_dung }}
                                </div>
                            </div>

                            <!-- PHẢN HỒI HIỆN TẠI (NẾU CÓ) -->
                            <div v-if="activeInquiry.tra_loi_tu_van" class="mb-4">
                                <label class="form-label text-success small fw-bold text-uppercase">
                                    <i class="fa-solid fa-circle-check me-1"></i> Câu Trả Lời Của Chuyên Viên Đã Gửi:
                                </label>
                                <div class="p-3 rounded-3 border border-success border-opacity-50 text-light" style="background: rgba(16, 185, 129, 0.08); font-size: 14px; line-height: 1.6;">
                                    @{{ activeInquiry.tra_loi_tu_van }}
                                </div>
                                <div class="text-secondary small mt-1">
                                    Trả lời bởi: <strong class="text-info">@{{ activeInquiry.ten_tu_van || 'Chuyên viên tư vấn' }}</strong> 
                                    <span v-if="activeInquiry.thoi_gian_tra_loi"> lúc @{{ activeInquiry.thoi_gian_tra_loi }}</span>
                                </div>
                            </div>

                            <!-- CÂU TRẢ LỜI MẪU NHANH CHO CHUYÊN VIÊN -->
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">
                                    <i class="fa-solid fa-bolt text-warning me-1"></i> Mẫu Phản Hồi Nhanh (Click để chèn nội dung):
                                </label>
                                <div class="d-flex flex-wrap">
                                    <span v-for="canned in cannedReplies" 
                                          :key="canned.title"
                                          class="canned-chip" 
                                          @click="insertCanned(canned.text)">
                                        + @{{ canned.title }}
                                    </span>
                                </div>
                            </div>

                            <!-- FORM NHẬP CÂU TRẢ LỜI TƯ VẤN (VUE TWO-WAY REACTIVITY) -->
                            <form @submit.prevent="sendReply" class="mt-auto">
                                <div class="mb-3">
                                    <label class="form-label text-white small fw-bold">
                                        <i class="fa-solid fa-pen-nib text-primary me-1"></i> Soạn Câu Trả Lời Riêng Của Bạn Cho Khách Hàng (*):
                                    </label>
                                    <textarea v-model="replyText" 
                                              class="form-control bg-dark border-secondary text-white p-3" 
                                              rows="4" 
                                              required 
                                              placeholder="Nhập câu trả lời chi tiết, tận tâm cho câu hỏi của khách hàng..." 
                                              style="border-radius: 12px; font-size: 14px;"></textarea>
                                </div>

                                <div class="row g-2 align-items-center">
                                    <div class="col-md-4">
                                        <label class="text-secondary small">Tên Chuyên Viên Ký Tên:</label>
                                        <input type="text" v-model="advisorName" class="form-control form-control-sm bg-dark border-secondary text-white">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-secondary small">Cập Nhật Trạng Thái:</label>
                                        <select v-model="selectedStatus" class="form-select form-select-sm bg-dark border-secondary text-white">
                                            <option value="Đã trả lời">Đã Giải Đáp (Hoàn tất)</option>
                                            <option value="Đang tư vấn">Đang Tư Vấn (Chờ trao đổi thêm)</option>
                                            <option value="Chờ phản hồi">Chờ Phản Hồi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-3 mt-md-auto">
                                        <button type="submit" class="btn btn-warning fw-bold text-dark w-100" :disabled="isSubmitting">
                                            <span v-if="isSubmitting"><i class="fa-solid fa-spinner fa-spin me-1"></i> Đang gửi...</span>
                                            <span v-else><i class="fa-solid fa-paper-plane me-1"></i> Gửi Câu Trả Lời</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div v-else class="text-center py-5 my-auto text-secondary">
                            <i class="fa-solid fa-inbox fa-4x mb-3 text-muted"></i>
                            <h4 class="text-white">Không Có Câu Hỏi Nào Được Chọn</h4>
                            <p>Vui lòng chọn một câu hỏi từ danh sách bên trái để phản hồi tư vấn cho khách hàng.</p>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- VUE.JS 3 REALTIME REACTIVE APPLICATION SCRIPT -->
    <script>
        const { createApp } = Vue;

        const initialInquiries = @json($chatLogs);
        const initialCannedReplies = @json($cannedReplies);

        createApp({
            data() {
                return {
                    inquiries: initialInquiries || [],
                    activeInquiryId: initialInquiries.length > 0 ? initialInquiries[0].ma_tin : null,
                    statusFilter: 'all',
                    searchQuery: '',
                    replyText: '',
                    advisorName: 'Chuyên Viên Tư Vấn PrimeLux',
                    selectedStatus: 'Đã trả lời',
                    isSubmitting: false,
                    isRefreshing: false,
                    newInquiryAlert: false,
                    lastSyncTime: new Date().toLocaleTimeString('vi-VN'),
                    cannedReplies: initialCannedReplies || [],
                    pollTimer: null
                };
            },
            computed: {
                // TỰ ĐỘNG TÍNH TOÁN THỐNG KÊ KHI DỮ LIỆU THAY ĐỔI MÀ KHÔNG CẦN GỌI HÀM
                stats() {
                    const total = this.inquiries.length;
                    const pending = this.inquiries.filter(i => i.trang_thai === 'Chờ phản hồi').length;
                    const inProgress = this.inquiries.filter(i => i.trang_thai === 'Đang tư vấn').length;
                    const resolved = this.inquiries.filter(i => i.trang_thai === 'Đã trả lời').length;
                    return { total, pending, inProgress, resolved };
                },

                // TỰ ĐỘNG LỌC DANH SÁCH THEO TRẠNG THÁI VÀ TỪ KHÓA TÌM KIẾM
                filteredInquiries() {
                    const query = this.searchQuery.toLowerCase().trim();
                    return this.inquiries.filter(item => {
                        // Lọc theo trạng thái
                        const matchStatus = (this.statusFilter === 'all') || (item.trang_thai === this.statusFilter);
                        if (!matchStatus) return false;

                        // Lọc theo từ khóa tìm kiếm
                        if (!query) return true;

                        const matin = (item.ma_tin || '').toLowerCase();
                        const sender = (item.nguoi_gui || '').toLowerCase();
                        const phone = (item.sdt_khach || '').toLowerCase();
                        const content = (item.noi_dung || '').toLowerCase();

                        return matin.includes(query) || sender.includes(query) || phone.includes(query) || content.includes(query);
                    });
                },

                // TỰ ĐỘNG TRUY XUẤT CÂU HỎI ĐANG ĐƯỢC CHỌN
                activeInquiry() {
                    if (!this.activeInquiryId && this.inquiries.length > 0) {
                        return this.inquiries[0];
                    }
                    return this.inquiries.find(i => i.ma_tin === this.activeInquiryId) || this.inquiries[0] || null;
                }
            },
            methods: {
                selectInquiry(maTin) {
                    this.activeInquiryId = maTin;
                    this.replyText = '';
                    const item = this.inquiries.find(i => i.ma_tin === maTin);
                    if (item) {
                        this.selectedStatus = item.trang_thai;
                    }
                },

                insertCanned(text) {
                    this.replyText = text;
                },

                getStatusBadgeClass(status) {
                    if (status === 'Chờ phản hồi') return 'status-badge-pending';
                    if (status === 'Đang tư vấn') return 'status-badge-progress';
                    return 'status-badge-resolved';
                },

                // GỬI PHẢN HỒI CHO KHÁCH HÀNG & CẬP NHẬT TRẠNG THÁI REACTIVE
                async sendReply() {
                    if (!this.activeInquiry || !this.replyText.trim()) return;

                    this.isSubmitting = true;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    try {
                        const response = await fetch("{{ route('consultant.reply') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({
                                ma_tin: this.activeInquiry.ma_tin,
                                tra_loi: this.replyText.trim(),
                                ten_tu_van: this.advisorName.trim(),
                                trang_thai: this.selectedStatus
                            })
                        });

                        const res = await response.json();
                        if (res.success) {
                            // CẬP NHẬT TRỰC TIẾP VÀO REACTIVE STATE (VUE TỰ ĐỘNG RE-RENDER GIAO DIỆN)
                            const current = this.inquiries.find(i => i.ma_tin === this.activeInquiry.ma_tin);
                            if (current) {
                                current.tra_loi_tu_van = this.replyText.trim();
                                current.ten_tu_van = this.advisorName.trim();
                                current.trang_thai = this.selectedStatus;
                                current.thoi_gian_tra_loi = res.data.thoi_gian;
                            }

                            this.replyText = '';
                            alert("Đã gửi câu trả lời tư vấn thành công tới khách hàng!");
                        } else {
                            alert("Lỗi: " + (res.message || "Không thể gửi phản hồi."));
                        }
                    } catch (err) {
                        console.error(err);
                        alert("Đã xảy ra lỗi khi gửi yêu cầu.");
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                // ĐỒNG BỘ REALTIME TỰ ĐỘNG KHÔNG CẦN GỌI HÀM THỦ CÔNG
                async fetchRealtimeFeed() {
                    this.isRefreshing = true;
                    try {
                        const res = await fetch("{{ route('api.consultant.realtime-feed') }}");
                        const data = await res.json();

                        if (data.success && Array.isArray(data.inquiries)) {
                            // Kiểm tra xem có câu hỏi mới xuất hiện không
                            if (data.inquiries.length > this.inquiries.length) {
                                this.newInquiryAlert = true;
                                setTimeout(() => { this.newInquiryAlert = false; }, 5000);
                            }

                            // Cập nhật mảng inquiries (Vue tự động phản ứng và vẽ lại tất cả các component)
                            this.inquiries = data.inquiries;
                            this.lastSyncTime = data.timestamp;

                            // Đảm bảo vẫn chọn đúng inquiry đang xem
                            if (!this.inquiries.some(i => i.ma_tin === this.activeInquiryId) && this.inquiries.length > 0) {
                                this.activeInquiryId = this.inquiries[0].ma_tin;
                            }
                        }
                    } catch (err) {
                        console.log("Realtime sync note:", err);
                    } finally {
                        this.isRefreshing = false;
                    }
                },

                // KÍCH HOẠT REALTIME EVENT STREAM LIÊN TỤC
                initContinuousRealtime() {
                    // Thực hiện polling định kỳ 2.5 giây tự động cập nhật
                    this.pollTimer = setInterval(() => {
                        this.fetchRealtimeFeed();
                    }, 2500);
                }
            },
            mounted() {
                // Khởi động luồng realtime liên tục khi component được mount
                this.initContinuousRealtime();
            },
            beforeUnmount() {
                if (this.pollTimer) clearInterval(this.pollTimer);
            }
        }).mount('#advisorApp');
    </script>
</body>

</html>
