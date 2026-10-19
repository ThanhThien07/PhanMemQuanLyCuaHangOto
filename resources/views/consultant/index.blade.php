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
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .stat-card-advisor:hover {
            transform: translateY(-2px);
            border-color: rgba(234, 179, 8, 0.4);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
        }

        .stat-card-advisor.active-all {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 18px rgba(56, 189, 248, 0.35);
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.15), rgba(15, 23, 42, 0.95));
        }

        .stat-card-advisor.active-pending {
            border-color: #ef4444 !important;
            box-shadow: 0 0 18px rgba(239, 68, 68, 0.35);
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.18), rgba(15, 23, 42, 0.95));
        }

        .stat-card-advisor.active-progress {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 18px rgba(59, 130, 246, 0.35);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(15, 23, 42, 0.95));
        }

        .stat-card-advisor.active-resolved {
            border-color: #10b981 !important;
            box-shadow: 0 0 18px rgba(16, 185, 129, 0.35);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.18), rgba(15, 23, 42, 0.95));
        }

        .inquiry-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .inquiry-card:hover {
            background: rgba(51, 65, 85, 0.8);
            border-color: rgba(234, 179, 8, 0.3);
        }

        .inquiry-card.active {
            background: rgba(59, 130, 246, 0.18);
            border: 1px solid #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.25);
        }

        .inquiry-list-container {
            max-height: calc(100vh - 290px);
            overflow-y: auto;
            padding-right: 6px;
        }

        .inquiry-list-container::-webkit-scrollbar,
        .messenger-stream-box::-webkit-scrollbar {
            width: 6px;
        }

        .inquiry-list-container::-webkit-scrollbar-thumb,
        .messenger-stream-box::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
        }

        .reply-panel {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px 24px;
            min-height: calc(100vh - 290px);
            display: flex;
            flex-direction: column;
        }

        .canned-chip {
            background: rgba(234, 179, 8, 0.1);
            color: #facc15;
            border: 1px solid rgba(234, 179, 8, 0.3);
            border-radius: 20px;
            padding: 4px 11px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block;
            margin: 2px 4px 2px 0;
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

        <!-- TOP NOTIFICATION ALERT WHEN NEW INQUIRY ARRIVES -->
        <div v-if="newInquiryAlert" class="alert alert-warning border-0 rounded-0 shadow-lg text-dark fw-bold py-2.5 px-4 mb-0 new-alert-toast position-sticky top-0 start-0 w-100 z-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-bell fa-shake fs-5 me-2 text-danger"></i>
                <span>TIN NHẮN MỚI TỪ KHÁCH HÀNG: <b>@{{ latestMessagePreview }}</b></span>
            </div>
            <button type="button" class="btn-close" @click="newInquiryAlert = false"></button>
        </div>

        <!-- TOP NAVBAR -->
        <nav class="advisor-navbar py-3 px-4 sticky-top">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2">
                        <img src="{{ asset('image/Logo.png') }}" alt="PrimeLux" height="34" class="rounded">
                        <span class="fs-4 fw-extrabold text-white tracking-wider">PrimeLux <span class="text-warning">Advisor</span></span>
                    </a>
                    <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-2.5 py-1.5 ms-2">
                        <span class="pulse-online"></span> Bàn Trực Trực Tuyến 24/7
                    </span>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <div class="text-white small fw-bold">@{{ advisorName }}</div>
                        <div class="text-secondary" style="font-size: 11px;">
                            Đồng bộ lúc: @{{ lastSyncTime }}
                            <i class="fa-solid fa-arrows-rotate text-success ms-1" :class="{ 'fa-spin': isRefreshing }"></i>
                        </div>
                    </div>
                    <a href="{{ url('/admin') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-gauge me-1"></i> Trang Quản Trị
                    </a>
                </div>
            </div>
        </nav>

        <div class="container-fluid py-4 px-4">

            <!-- THỐNG KÊ NHANH (CARDS LỌC TRẠNG THÁI) -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div :class="['stat-card-advisor d-flex align-items-center justify-content-between', { 'active-all': statusFilter === 'all' }]"
                         @click="setFilter('all')" role="button">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase">Tổng Tin Nhắn</div>
                            <div class="fs-2 fw-bold text-white">@{{ stats.total }}</div>
                            <div class="text-secondary small">Cập nhật realtime</div>
                        </div>
                        <div class="p-3 rounded-3 bg-secondary bg-opacity-20 text-info fs-3">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div :class="['stat-card-advisor d-flex align-items-center justify-content-between', { 'active-pending': statusFilter === 'Chờ phản hồi' }]"
                         style="border-left: 4px solid #ef4444;"
                         @click="setFilter('Chờ phản hồi')" role="button">
                        <div>
                            <div class="text-danger small fw-bold text-uppercase">Chờ Phản Hồi Gấp</div>
                            <div class="fs-2 fw-bold text-danger">@{{ stats.pending }}</div>
                            <div class="text-secondary small">Khách đang chờ bạn</div>
                        </div>
                        <div class="p-3 rounded-3 bg-danger bg-opacity-20 text-danger fs-3">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div :class="['stat-card-advisor d-flex align-items-center justify-content-between', { 'active-progress': statusFilter === 'Đang tư vấn' }]"
                         style="border-left: 4px solid #3b82f6;"
                         @click="setFilter('Đang tư vấn')" role="button">
                        <div>
                            <div class="text-info small fw-bold text-uppercase">Đang Tư Vấn</div>
                            <div class="fs-2 fw-bold text-info">@{{ stats.inProgress }}</div>
                            <div class="text-secondary small">Đang trò chuyện</div>
                        </div>
                        <div class="p-3 rounded-3 bg-primary bg-opacity-20 text-primary fs-3">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div :class="['stat-card-advisor d-flex align-items-center justify-content-between', { 'active-resolved': statusFilter === 'Đã trả lời' }]"
                         style="border-left: 4px solid #10b981;"
                         @click="setFilter('Đã trả lời')" role="button">
                        <div>
                            <div class="text-success small fw-bold text-uppercase">Đã Giải Đáp Xong</div>
                            <div class="fs-2 fw-bold text-success">@{{ stats.resolved }}</div>
                            <div class="text-secondary small">Khách hài lòng</div>
                        </div>
                        <div class="p-3 rounded-3 bg-success bg-opacity-20 text-success fs-3">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BỘ LỌC VÀ Ô TÌM KIẾM -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div class="btn-group" role="group">
                    <button type="button" @click="setFilter('all')" :class="['btn btn-sm', statusFilter === 'all' ? 'btn-primary' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-list me-1"></i> Tất Cả (@{{ stats.total }})
                    </button>
                    <button type="button" @click="setFilter('Chờ phản hồi')" :class="['btn btn-sm', statusFilter === 'Chờ phản hồi' ? 'btn-danger' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-clock me-1"></i> Chờ Phản Hồi (@{{ stats.pending }})
                    </button>
                    <button type="button" @click="setFilter('Đang tư vấn')" :class="['btn btn-sm', statusFilter === 'Đang tư vấn' ? 'btn-info text-white' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-spinner me-1"></i> Đang Tư Vấn (@{{ stats.inProgress }})
                    </button>
                    <button type="button" @click="setFilter('Đã trả lời')" :class="['btn btn-sm', statusFilter === 'Đã trả lời' ? 'btn-success' : 'btn-dark border-secondary text-secondary']">
                        <i class="fa-solid fa-check-double me-1"></i> Đã Giải Đáp (@{{ stats.resolved }})
                    </button>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: 280px;">
                        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fa-solid fa-search"></i></span>
                        <input type="text" v-model="searchQuery" class="form-control bg-dark border-secondary text-white" placeholder="Tìm tên, SĐT, nội dung...">
                        <button v-if="searchQuery" class="btn btn-outline-secondary" type="button" @click="searchQuery = ''"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" @click="fetchRealtimeFeed" title="Cập nhật ngay">
                        <i class="fa-solid fa-rotate" :class="{ 'fa-spin': isRefreshing }"></i>
                    </button>
                </div>
            </div>

            <!-- WORKSPACE 2 CỘT: DANH SÁCH KHÁCH HÀNG & LUỒNG CHAT MESSENGER -->
            <div class="row g-4">
                
                <!-- CỘT TRÁI: DANH SÁCH CUỘC TRÒ CHUYỆN / YÊU CẦU -->
                <div class="col-lg-5 col-xl-4">
                    <div class="p-3 rounded-4 bg-dark border border-secondary">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-white small text-uppercase">
                                <i class="fa-solid fa-inbox text-warning me-1"></i> Cuộc Trò Chuyện (@{{ filteredInquiries.length }})
                            </span>
                            <span class="text-secondary small"><i class="fa-solid fa-bolt text-warning me-1"></i>1.5s realtime</span>
                        </div>

                        <div class="inquiry-list-container">
                            <div v-for="item in filteredInquiries" 
                                 :key="item.ma_tin"
                                 :class="['inquiry-card', { active: activeInquiryId === item.ma_tin }]" 
                                 @click="selectInquiry(item.ma_tin)">
                                
                                <div class="d-flex justify-content-between align-items-start mb-1.5">
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

                                <p class="text-light small mb-2 text-truncate" style="line-height: 1.4;">
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
                                <p class="mb-0">Không tìm thấy cuộc trò chuyện phù hợp.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI: LUỒNG CHAT MESSENGER THỜI GIAN THỰC CÙNG KHÁCH HÀNG -->
                <div class="col-lg-7 col-xl-8">
                    <div class="reply-panel">
                        
                        <div v-if="activeInquiry">
                            <!-- HEADER THÔNG TIN KHÁCH HÀNG -->
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

                            <!-- LUỒNG TRÒ CHUYỆN TOÀN DIỆN DẠNG MESSENGER (CHRONOLOGICAL STREAM) -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label text-warning small fw-bold text-uppercase mb-0">
                                        <i class="fa-solid fa-comments me-1"></i> Luồng Trò Chuyện Trực Tiếp (Messenger Stream):
                                    </label>
                                    <span class="text-secondary small" style="font-size: 11px;">
                                        <i class="fa-solid fa-bolt text-warning me-1"></i>Tự động cập nhật 1.5s
                                    </span>
                                </div>

                                <div class="messenger-stream-box p-3 rounded-3" 
                                     id="advisorMessengerStream"
                                     style="height: 290px; overflow-y: auto; background-color: #0b1120; border: 1px solid rgba(255, 255, 255, 0.1); display: flex; flex-direction: column; gap: 10px;">
                                    
                                    <div v-for="msg in activeThreadMessages" :key="msg.id || msg.ma_tin" 
                                         :class="['d-flex flex-column', msg.sender_type === 'consultant' ? 'align-items-end' : 'align-items-start']">
                                        
                                        <div class="d-flex align-items-center gap-1 mb-1 small" style="font-size: 11px;">
                                            <strong :class="msg.sender_type === 'consultant' ? 'text-warning' : 'text-info'">
                                                <i :class="msg.sender_type === 'consultant' ? 'fa-solid fa-headset me-1' : 'fa-solid fa-user me-1'"></i>
                                                @{{ msg.nguoi_gui || (msg.sender_type === 'consultant' ? 'Tư Vấn Viên' : 'Khách hàng') }}
                                            </strong>
                                            <span class="text-secondary">• @{{ msg.thoi_gian }}</span>
                                        </div>

                                        <div :class="['px-3 py-2 rounded-4', msg.sender_type === 'consultant' ? 'bg-warning text-dark fw-medium' : 'bg-secondary bg-opacity-25 text-white border border-secondary']"
                                             style="font-size: 13.5px; line-height: 1.5; max-width: 85%; word-break: break-word;">
                                            @{{ msg.noi_dung }}
                                        </div>
                                    </div>

                                    <div v-if="activeThreadMessages.length === 0" class="text-center py-4 text-secondary small my-auto">
                                        <i class="fa-regular fa-comment-dots fa-2x mb-2 d-block text-muted"></i>
                                        Chưa có tin nhắn nào trong luồng trò chuyện này.
                                    </div>
                                </div>
                            </div>

                            <!-- MẪU PHẢN HỒI NHANH CHO CHUYÊN VIÊN -->
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold mb-1">
                                    <i class="fa-solid fa-bolt text-warning me-1"></i> Câu Trả Lời Mẫu Nhanh (Click để chèn):
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

                            <!-- KHUNG SOẠN TIN NHẮN TRẢ LỜI (ENTER ĐỂ GỬI NGAY) -->
                            <form @submit.prevent="sendReply" class="mt-auto">
                                <div class="mb-2">
                                    <textarea v-model="replyText" 
                                              @keydown.enter.exact.prevent="sendReply"
                                              class="form-control bg-dark border-secondary text-white p-3" 
                                              rows="3" 
                                              required 
                                              placeholder="Nhập nội dung tư vấn cho khách hàng (Nhấn Enter để gửi ngay, Shift+Enter xuống dòng)..." 
                                              style="border-radius: 12px; font-size: 13.5px;"></textarea>
                                </div>

                                <div class="row g-2 align-items-center">
                                    <div class="col-md-4">
                                        <input type="text" v-model="advisorName" placeholder="Tên Chuyên viên" class="form-control form-control-sm bg-dark border-secondary text-white">
                                    </div>
                                    <div class="col-md-4">
                                        <select v-model="selectedStatus" class="form-select form-select-sm bg-dark border-secondary text-white">
                                            <option value="Đã trả lời">Đã Giải Đáp (Hoàn tất)</option>
                                            <option value="Đang tư vấn">Đang Tư Vấn (Tiếp tục trao đổi)</option>
                                            <option value="Chờ phản hồi">Chờ Phản Hồi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                        <button type="submit" class="btn btn-warning fw-bold text-dark w-100" :disabled="isSubmitting">
                                            <span v-if="isSubmitting"><i class="fa-solid fa-spinner fa-spin me-1"></i> Đang gửi...</span>
                                            <span v-else><i class="fa-solid fa-paper-plane me-1"></i> Gửi Tin Nhắn (Enter)</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div v-else class="text-center py-5 my-auto text-secondary">
                            <i class="fa-solid fa-inbox fa-4x mb-3 text-muted"></i>
                            <h4 class="text-white">Không Có Cuộc Trò Chuyện Nào Được Chọn</h4>
                            <p>Vui lòng chọn một cuộc trò chuyện từ danh sách bên trái để phản hồi tư vấn cho khách hàng.</p>
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
                    threadMessages: [],
                    statusFilter: 'all',
                    searchQuery: '',
                    replyText: '',
                    advisorName: 'Chuyên Viên Tư Vấn PrimeLux',
                    selectedStatus: 'Đã trả lời',
                    isSubmitting: false,
                    isRefreshing: false,
                    newInquiryAlert: false,
                    latestMessagePreview: '',
                    lastSyncTime: new Date().toLocaleTimeString('vi-VN'),
                    cannedReplies: initialCannedReplies || [],
                    pollTimer: null,
                    audioContext: null
                };
            },
            computed: {
                stats() {
                    const total = this.inquiries.length;
                    const pending = this.inquiries.filter(i => i.trang_thai === 'Chờ phản hồi').length;
                    const inProgress = this.inquiries.filter(i => i.trang_thai === 'Đang tư vấn').length;
                    const resolved = this.inquiries.filter(i => i.trang_thai === 'Đã trả lời').length;
                    return { total, pending, inProgress, resolved };
                },

                filteredInquiries() {
                    const query = this.searchQuery.toLowerCase().trim();
                    return this.inquiries.filter(item => {
                        const matchStatus = (this.statusFilter === 'all') || (item.trang_thai === this.statusFilter);
                        if (!matchStatus) return false;

                        if (!query) return true;

                        const matin = (item.ma_tin || '').toLowerCase();
                        const sender = (item.nguoi_gui || '').toLowerCase();
                        const phone = (item.sdt_khach || '').toLowerCase();
                        const content = (item.noi_dung || '').toLowerCase();

                        return matin.includes(query) || sender.includes(query) || phone.includes(query) || content.includes(query);
                    });
                },

                activeInquiry() {
                    if (this.filteredInquiries.length === 0) {
                        return null;
                    }
                    const found = this.filteredInquiries.find(i => i.ma_tin === this.activeInquiryId);
                    return found || this.filteredInquiries[0];
                },

                activeThreadMessages() {
                    if (this.threadMessages.length > 0) {
                        return this.threadMessages;
                    }
                    if (this.activeInquiry) {
                        const defaultMsgs = [];
                        defaultMsgs.push({
                            id: this.activeInquiry.id,
                            sender_type: 'customer',
                            nguoi_gui: this.activeInquiry.nguoi_gui,
                            noi_dung: this.activeInquiry.noi_dung,
                            thoi_gian: this.activeInquiry.thoi_gian
                        });
                        if (this.activeInquiry.tra_loi_tu_van) {
                            defaultMsgs.push({
                                id: 'rep-' + this.activeInquiry.id,
                                sender_type: 'consultant',
                                nguoi_gui: this.activeInquiry.ten_tu_van || 'Chuyên Viên Tư Vấn',
                                noi_dung: this.activeInquiry.tra_loi_tu_van,
                                thoi_gian: this.activeInquiry.thoi_gian_tra_loi || 'Vừa xong'
                            });
                        }
                        return defaultMsgs;
                    }
                    return [];
                }
            },
            methods: {
                playNotificationSound() {
                    try {
                        const AudioContext = window.AudioContext || window.webkitAudioContext;
                        if (!AudioContext) return;
                        if (!this.audioContext) this.audioContext = new AudioContext();
                        if (this.audioContext.state === 'suspended') this.audioContext.resume();

                        const now = this.audioContext.currentTime;
                        // Tone 1
                        const o1 = this.audioContext.createOscillator();
                        const g1 = this.audioContext.createGain();
                        o1.type = "sine";
                        o1.frequency.setValueAtTime(523.25, now);
                        g1.gain.setValueAtTime(0.2, now);
                        g1.gain.exponentialRampToValueAtTime(0.01, now + 0.3);
                        o1.connect(g1);
                        g1.connect(this.audioContext.destination);
                        o1.start(now);
                        o1.stop(now + 0.3);

                        // Tone 2
                        const o2 = this.audioContext.createOscillator();
                        const g2 = this.audioContext.createGain();
                        o2.type = "sine";
                        o2.frequency.setValueAtTime(659.25, now + 0.15);
                        g2.gain.setValueAtTime(0.2, now + 0.15);
                        g2.gain.exponentialRampToValueAtTime(0.01, now + 0.5);
                        o2.connect(g2);
                        g2.connect(this.audioContext.destination);
                        o2.start(now + 0.15);
                        o2.stop(now + 0.5);
                    } catch(e) {}
                },

                setFilter(status) {
                    this.statusFilter = status;
                    this.$nextTick(() => {
                        if (this.filteredInquiries.length > 0) {
                            const exists = this.filteredInquiries.some(i => i.ma_tin === this.activeInquiryId);
                            if (!exists) {
                                this.selectInquiry(this.filteredInquiries[0].ma_tin);
                            }
                        }
                    });
                },

                selectInquiry(maTin) {
                    this.activeInquiryId = maTin;
                    this.replyText = '';
                    const item = this.inquiries.find(i => i.ma_tin === maTin);
                    if (item) {
                        this.selectedStatus = item.trang_thai;
                    }
                    this.fetchThreadMessages();
                },

                async fetchThreadMessages() {
                    if (!this.activeInquiry) return;
                    const sid = this.activeInquiry.session_id || this.activeInquiry.ma_tin;
                    try {
                        const res = await fetch(`/api/consultant/thread-messages?session_id=${encodeURIComponent(sid)}&ma_tin=${encodeURIComponent(this.activeInquiry.ma_tin)}`);
                        const data = await res.json();
                        if (data.success && Array.isArray(data.messages)) {
                            this.threadMessages = data.messages;
                            this.scrollStreamBottom();
                        }
                    } catch (e) {
                        console.log("Thread fetch note:", e);
                    }
                },

                scrollStreamBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById("advisorMessengerStream");
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                },

                insertCanned(text) {
                    this.replyText = text;
                },

                getStatusBadgeClass(status) {
                    if (status === 'Chờ phản hồi') return 'status-badge-pending';
                    if (status === 'Đang tư vấn') return 'status-badge-progress';
                    return 'status-badge-resolved';
                },

                // GỬI PHẢN HỒI CHO KHÁCH HÀNG & CẬP NHẬT TRẠNG THÁI REALTIME
                async sendReply() {
                    if (!this.activeInquiry || !this.replyText.trim()) return;

                    this.isSubmitting = true;
                    const textToSend = this.replyText.trim();
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    // Optimistic update vào luồng chat
                    const tempId = 'temp-' + Date.now();
                    this.threadMessages.push({
                        id: tempId,
                        sender_type: 'consultant',
                        nguoi_gui: this.advisorName.trim(),
                        noi_dung: textToSend,
                        thoi_gian: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })
                    });
                    this.replyText = '';
                    this.scrollStreamBottom();

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
                                session_id: this.activeInquiry.session_id || this.activeInquiry.ma_tin,
                                tra_loi: textToSend,
                                ten_tu_van: this.advisorName.trim(),
                                trang_thai: this.selectedStatus
                            })
                        });

                        const res = await response.json();
                        if (res.success) {
                            const current = this.inquiries.find(i => i.ma_tin === this.activeInquiry.ma_tin);
                            if (current) {
                                current.tra_loi_tu_van = textToSend;
                                current.ten_tu_van = this.advisorName.trim();
                                current.trang_thai = this.selectedStatus;
                                current.thoi_gian_tra_loi = res.data.thoi_gian;
                            }
                            this.fetchThreadMessages();
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

                // ĐỒNG BỘ REALTIME TỰ ĐỘNG KHÔNG CẦN F5 (1.5s POLLING)
                async fetchRealtimeFeed() {
                    this.isRefreshing = true;
                    try {
                        const res = await fetch("{{ route('api.consultant.realtime-feed') }}");
                        const data = await res.json();

                        if (data.success && Array.isArray(data.inquiries)) {
                            // Kiểm tra có tin nhắn mới xuất hiện không
                            if (data.inquiries.length > this.inquiries.length) {
                                const newest = data.inquiries[0];
                                this.latestMessagePreview = (newest.nguoi_gui || 'Khách hàng') + ': ' + (newest.noi_dung || '');
                                this.newInquiryAlert = true;
                                this.playNotificationSound();
                                document.title = "(1) 💬 TIN NHẮN MỚI TỪ KHÁCH! - PrimeLux Advisor";
                                setTimeout(() => { this.newInquiryAlert = false; }, 6000);
                            }

                            this.inquiries = data.inquiries;
                            this.lastSyncTime = data.timestamp;

                            if (!this.inquiries.some(i => i.ma_tin === this.activeInquiryId) && this.inquiries.length > 0) {
                                this.activeInquiryId = this.inquiries[0].ma_tin;
                            }

                            // Cập nhật lại thread messages của inquiry đang chọn
                            this.fetchThreadMessages();
                        }
                    } catch (err) {
                        console.log("Realtime sync note:", err);
                    } finally {
                        this.isRefreshing = false;
                    }
                },

                initContinuousRealtime() {
                    // Polling mỗi 1.5 giây để tin nhắn hiển thị tức thì
                    this.pollTimer = setInterval(() => {
                        this.fetchRealtimeFeed();
                    }, 1500);
                }
            },
            mounted() {
                this.initContinuousRealtime();
                this.fetchThreadMessages();

                window.addEventListener("focus", () => {
                    document.title = "Cổng Chuyên Viên Tư Vấn Trực Tuyến - PrimeLux Advisor Portal";
                });
            },
            beforeUnmount() {
                if (this.pollTimer) clearInterval(this.pollTimer);
            }
        }).mount('#advisorApp');
    </script>
</body>

</html>
