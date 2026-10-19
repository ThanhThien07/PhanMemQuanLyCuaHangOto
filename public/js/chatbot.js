// PRIMELUX LIVE MESSENGER & AI ADVISOR CHATBOT ENGINE
// Hoạt động như Messenger thời gian thực: Khách nhắn tin -> Tư vấn viên nhận ngay, Tư vấn viên trả lời -> Khách thấy tức thì.

(function () {
    // 1. QUẢN LÝ SESSION VÀ THÔNG TIN KHÁCH HÀNG
    function getChatSessionId() {
        let sid = localStorage.getItem("primelux_chat_session_id");
        if (!sid) {
            sid = "SES-" + Date.now().toString(36).toUpperCase() + "-" + Math.random().toString(36).substring(2, 6).toUpperCase();
            localStorage.setItem("primelux_chat_session_id", sid);
        }
        return sid;
    }

    const sessionId = getChatSessionId();
    let currentMode = localStorage.getItem("primelux_chat_mode") || "live"; // "live" hoặc "bot"
    let customerName = localStorage.getItem("primelux_customer_name") || "Khách hàng Web";
    let customerPhone = localStorage.getItem("primelux_customer_phone") || "";
    let pollingInterval = null;
    let lastKnownMessageId = parseInt(localStorage.getItem("primelux_last_msg_id") || "0");
    let unreadCount = 0;

    // 2. TẠO ÂM THANH THÔNG BÁO BẰNG WEB AUDIO API (KHÔNG CẦN TẢI FILE MP3)
    let audioCtx = null;
    function getAudioContext() {
        if (!audioCtx) {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (AudioContext) audioCtx = new AudioContext();
        }
        if (audioCtx && audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
        return audioCtx;
    }

    // Tiếng "pop/ting" khi khách gửi
    function playSendSound() {
        try {
            const ctx = getAudioContext();
            if (!ctx) return;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = "sine";
            osc.frequency.setValueAtTime(580, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.1);
            gain.gain.setValueAtTime(0.12, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.12);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.12);
        } catch (e) {}
    }

    // Tiếng "ding-dong" êm ái khi Tư Vấn Viên phản hồi
    function playReceiveSound() {
        try {
            const ctx = getAudioContext();
            if (!ctx) return;
            const now = ctx.currentTime;
            // Tone 1
            const osc1 = ctx.createOscillator();
            const gain1 = ctx.createGain();
            osc1.type = "sine";
            osc1.frequency.setValueAtTime(659.25, now); // E5
            gain1.gain.setValueAtTime(0.18, now);
            gain1.gain.exponentialRampToValueAtTime(0.01, now + 0.25);
            osc1.connect(gain1);
            gain1.connect(ctx.destination);
            osc1.start(now);
            osc1.stop(now + 0.25);

            // Tone 2
            const osc2 = ctx.createOscillator();
            const gain2 = ctx.createGain();
            osc2.type = "sine";
            osc2.frequency.setValueAtTime(880, now + 0.12); // A5
            gain2.gain.setValueAtTime(0.18, now + 0.12);
            gain2.gain.exponentialRampToValueAtTime(0.01, now + 0.45);
            osc2.connect(gain2);
            gain2.connect(ctx.destination);
            osc2.start(now + 0.12);
            osc2.stop(now + 0.45);
        } catch (e) {}
    }

    // 3. TẠO HTML WIDGET VÀO BODY
    const widgetHTML = `
        <div class="chatbot-widget-btn" id="chatbotToggleBtn" title="Trò chuyện với Tư Vấn Viên & Trợ Lý PrimeLux">
            <i class="fa-solid fa-comments"></i>
            <span class="chatbot-unread-dot d-none" id="chatbotUnreadBadge">0</span>
        </div>

        <div class="chatbot-box" id="chatbotBox">
            <div class="chatbot-header">
                <div class="chatbot-header-top">
                    <div class="chatbot-title">
                        <div class="chatbot-avatar-wrap">
                            <i class="fa-solid fa-headset" id="headerAvatarIcon"></i>
                            <span class="chatbot-status-online"></span>
                        </div>
                        <div>
                            <strong style="font-size: 14.5px; display: block;" id="headerTitle">PrimeLux VIP Advisor</strong>
                            <div style="font-size: 11px; color: #4ade80; display: flex; align-items: center; gap: 4px;" id="headerSubtitle">
                                <span style="display:inline-block; width:6px; height:6px; background:#22c55e; border-radius:50%;"></span>
                                Chuyên viên trực tuyến • Nhắn là nhận ngay
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <a href="/consultant" target="_blank" style="color: #93c5fd; font-size: 11.5px; text-decoration: none;" title="Cổng Bàn trực dành cho Chuyên viên">
                            <i class="fa-solid fa-desktop"></i> Cổng Bàn Trực
                        </a>
                        <button id="chatbotCloseBtn" style="background: none; border: none; color: #94a3b8; font-size: 18px; cursor: pointer; padding: 2px 6px;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <!-- TABS CHUYỂN CHẾ ĐỘ: TƯ VẤN TRỰC TIẾP (MESSENGER) vs TRỢ LÝ AI (FAQ) -->
                <div class="chatbot-mode-tabs">
                    <button type="button" class="chatbot-mode-tab ${currentMode === 'live' ? 'active' : ''}" id="tabModeLive">
                        <i class="fa-solid fa-user-tie"></i> 💬 Tư Vấn Trực Tiếp (Live Chat)
                    </button>
                    <button type="button" class="chatbot-mode-tab ${currentMode === 'bot' ? 'active' : ''}" id="tabModeBot">
                        <i class="fa-solid fa-robot"></i> 🤖 Trợ Lý Tự Động (AI FAQ)
                    </button>
                </div>
            </div>

            <!-- THANH THÔNG TIN KHÁCH HÀNG NHANH -->
            <div class="chatbot-customer-bar" id="customerInfoBar">
                <span id="customerLabel"><i class="fa-solid fa-user-tag me-1 text-warning"></i> Đang trò chuyện với tư cách: <strong class="text-white" id="displayCustomerName">${customerName}</strong></span>
                <a id="btnEditCustomerInfo"><i class="fa-solid fa-pen-to-square me-1"></i>Đổi Tên/SĐT</a>
            </div>

            <!-- NỘI DUNG CUỘC TRÒ CHUYỆN (MESSENGER STREAM) -->
            <div class="chatbot-body" id="chatbotBody">
                <!-- Nội dung các bong bóng chat sẽ được append vào đây -->
            </div>

            <!-- KHUNG SOẠN TIN NHẮN VÀ GỬI (MESSENGER INPUT) -->
            <div class="chatbot-footer">
                <div class="chatbot-input-row">
                    <input type="text" id="chatbotInput" class="chatbot-input" 
                           placeholder="Nhập tin nhắn gửi tư vấn viên..." 
                           autocomplete="off">
                    <button class="chatbot-send-btn" id="chatbotSendBtn" title="Gửi tin nhắn (Enter)">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
                <div class="chatbot-hint">
                    <span id="modeHintText">⚡ Nhấn <b>Enter</b> để gửi ngay tới bàn trực Chuyên viên VIP</span>
                    <span id="sessionTag" style="font-family: monospace; font-size: 10px; color: #64748b;">${sessionId.slice(0, 10)}</span>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', widgetHTML);

    // 4. THAM CHIẾU DOM ELEMENTS
    const toggleBtn = document.getElementById("chatbotToggleBtn");
    const closeBtn = document.getElementById("chatbotCloseBtn");
    const chatBox = document.getElementById("chatbotBox");
    const chatBody = document.getElementById("chatbotBody");
    const chatInput = document.getElementById("chatbotInput");
    const sendBtn = document.getElementById("chatbotSendBtn");
    const unreadBadge = document.getElementById("chatbotUnreadBadge");
    const tabModeLive = document.getElementById("tabModeLive");
    const tabModeBot = document.getElementById("tabModeBot");
    const headerTitle = document.getElementById("headerTitle");
    const headerSubtitle = document.getElementById("headerSubtitle");
    const headerAvatarIcon = document.getElementById("headerAvatarIcon");
    const btnEditCustomerInfo = document.getElementById("btnEditCustomerInfo");
    const displayCustomerName = document.getElementById("displayCustomerName");
    const modeHintText = document.getElementById("modeHintText");

    // 5. CÁC HÀM HIỂN THỊ TIN NHẮN TRONG STREAM
    function appendBubble(sender, text, meta = {}) {
        const row = document.createElement("div");
        row.className = `chat-bubble-row ${sender}`;
        if (meta.id) row.dataset.msgId = meta.id;

        const time = meta.time || new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });

        if (sender === 'user') {
            row.innerHTML = `
                <div class="chat-msg">${escapeHtml(text)}</div>
                <div class="chat-bubble-meta">
                    <span>${time}</span>
                    <i class="fa-solid fa-check text-info" title="Đã gửi"></i>
                </div>
            `;
        } else if (sender === 'advisor') {
            const advisorName = meta.advisorName || 'Chuyên Viên Tư Vấn VIP';
            row.innerHTML = `
                <div class="chat-advisor-sender-badge">
                    <i class="fa-solid fa-shield-halved text-warning"></i> ${escapeHtml(advisorName)}
                </div>
                <div class="chat-msg">${text}</div>
                <div class="chat-bubble-meta">
                    <span>${time}</span>
                    <span class="text-success ms-1">• Đã trả lời trực tiếp</span>
                </div>
            `;
        } else { // bot
            row.innerHTML = `
                <div class="chat-msg">${text}</div>
                <div class="chat-bubble-meta">
                    <span>${time}</span>
                    <span class="text-secondary ms-1">• Trợ lý tự động</span>
                </div>
            `;
        }

        chatBody.appendChild(row);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function escapeHtml(string) {
        if (!string) return '';
        const div = document.createElement('div');
        div.textContent = string;
        return div.innerHTML;
    }

    // 6. KHỞI TẠO NỘI DUNG CHÀO ĐẦU TIÊN
    function renderWelcomeMessage() {
        chatBody.innerHTML = '';

        if (currentMode === 'live') {
            headerTitle.textContent = "PrimeLux VIP Advisor";
            headerSubtitle.innerHTML = `<span style="display:inline-block; width:6px; height:6px; background:#22c55e; border-radius:50%;"></span> Chuyên viên trực tuyến • Nhắn là nhận ngay`;
            headerAvatarIcon.className = "fa-solid fa-headset";
            modeHintText.innerHTML = `⚡ Nhấn <b>Enter</b> để nhắn tin trực tiếp tới Bàn trực Chuyên Viên`;

            const welcomeHTML = `
                👋 <b>Dạ kính chào Quý khách!</b> Em là Chuyên viên Trực tuyến của <b>PrimeLux Auto Showroom</b>.
                <br><br>
                Quý khách đang tìm kiếm mẫu xe nào hoặc cần nhận <b>Bảng báo giá lăn bánh, Gói vay trả góp 80%</b> hay <b>Đặt lịch lái thử tận nơi</b>, cứ nhắn trực tiếp tại đây em hỗ trợ ngay tức thì nhé ạ!
                <div class="quick-chips">
                    <button class="chip-btn" data-quick="Báo giá xe Maybach S680 sẵn giao ngay">🚗 Maybach S680</button>
                    <button class="chip-btn" data-quick="Tư vấn gói vay trả góp 80% lãi suất ưu đãi">💳 Gói vay 80%</button>
                    <button class="chip-btn" data-quick="Cách tính giá lăn bánh tại TP.HCM & Hà Nội">🧮 Giá lăn bánh</button>
                    <button class="chip-btn" data-quick="Đặt lịch lái thử xe tận nơi miễn phí">🏎️ Lái thử tận nơi</button>
                </div>
            `;
            appendBubble('advisor', welcomeHTML, { advisorName: 'Chuyên Viên Tư Vấn PrimeLux' });
        } else {
            headerTitle.textContent = "PrimeLux AI Assistant";
            headerSubtitle.innerHTML = `<span style="display:inline-block; width:6px; height:6px; background:#38bdf8; border-radius:50%;"></span> Trợ lý AI hỏi đáp nhanh 24/7`;
            headerAvatarIcon.className = "fa-solid fa-robot";
            modeHintText.innerHTML = `🤖 Trợ lý AI tự động tra cứu danh mục & giải đáp`;

            const botHTML = `
                👋 <b>Chào mừng Quý khách!</b> Tôi là Trợ lý Thông Minh AI của <b>PrimeLux Auto</b>.
                <br><br>
                Quý khách có thể bấm chọn nhanh các chủ đề dưới đây hoặc gõ câu hỏi để được tra cứu tức thời:
                <div class="quick-chips">
                    <button class="chip-btn" data-quick="Tư vấn dòng xe sang theo ngân sách">💰 Theo ngân sách</button>
                    <button class="chip-btn" data-quick="Cách tính giá lăn bánh xe?">🧮 Bảng tính lăn bánh</button>
                    <button class="chip-btn" data-quick="Chính sách tích điểm VIP PrimeLux Club">💎 Tích điểm VIP</button>
                    <button class="chip-btn" data-quick="Thủ tục mua xe trả góp và lãi suất">💳 Mua xe trả góp</button>
                    <button class="chip-btn" data-quick="Dịch vụ thu cũ đổi mới Trade-In">🔄 Thu cũ đổi mới</button>
                    <button class="chip-btn special" data-quick="chuyen_sang_tu_van_vien">👨‍💼 Gặp Chuyên Viên Tư Vấn VIP</button>
                </div>
            `;
            appendBubble('bot', botHTML);
        }

        // Tải lại lịch sử tin nhắn trong session nếu có
        loadSessionHistory();
    }

    // 7. TẢI LỊCH SỬ TIN NHẮN TỪ SERVER ĐỂ DUY TRÌ CUỘC TRÒ CHUYỆN
    async function loadSessionHistory() {
        try {
            const res = await fetch(`/api/consultant/thread-messages?session_id=${encodeURIComponent(sessionId)}`);
            const data = await res.json();
            if (data.success && Array.isArray(data.messages) && data.messages.length > 0) {
                // Xóa nội dung chào mẫu và vẽ lại toàn bộ lịch sử thực tế
                chatBody.innerHTML = '';
                data.messages.forEach(msg => {
                    const isAdvisor = msg.sender_type === 'consultant';
                    const sender = isAdvisor ? 'advisor' : 'user';
                    appendBubble(sender, msg.noi_dung, {
                        id: msg.id,
                        advisorName: msg.nguoi_gui || 'Chuyên Viên Tư Vấn PrimeLux',
                        time: msg.thoi_gian
                    });

                    // Cập nhật ID lớn nhất
                    if (msg.id > lastKnownMessageId) {
                        lastKnownMessageId = msg.id;
                        localStorage.setItem("primelux_last_msg_id", lastKnownMessageId.toString());
                    }
                });
            }
        } catch (e) {
            console.log("Load history note:", e);
        }
    }

    // 8. GỬI TIN NHẮN (OPTIMISTIC UI NHƯ MESSENGER)
    async function handleSendMessage(customText = null) {
        const text = customText || chatInput.value.trim();
        if (!text) return;

        // Xử lý chuyển chế độ nhanh nếu bấm chip đặc biệt
        if (text === "chuyen_sang_tu_van_vien") {
            switchMode("live");
            return;
        }

        // 1. Hiển thị ngay lên màn hình bên phía khách hàng (optimistic UI)
        playSendSound();
        appendBubble('user', text);
        if (!customText) chatInput.value = '';

        // 2. Kiểm tra nếu đang ở chế độ Trợ lý AI và có câu trả lời mẫu
        if (currentMode === 'bot') {
            const botReply = findPredefinedAnswer(text);
            if (botReply) {
                setTimeout(() => {
                    playReceiveSound();
                    appendBubble('bot', botReply);
                }, 400);
                return;
            }
        }

        // 3. GỬI TỚI BÀN TRỰC TƯ VẤN VIÊN (REALTIME BACKEND SYNC)
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

        // Tự động nhận diện số điện thoại trong tin nhắn nếu khách nhập
        const phoneMatch = text.match(/(0[3|5|7|8|9][0-9]{8})/);
        if (phoneMatch && !customerPhone) {
            customerPhone = phoneMatch[0];
            localStorage.setItem("primelux_customer_phone", customerPhone);
        }

        try {
            const response = await fetch('/api/consultant/submit-question', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    noi_dung: text,
                    sdt_khach: customerPhone || null,
                    nguoi_gui: customerName + (customerPhone ? ` (${customerPhone})` : ''),
                    loai_cau_hoi: currentMode === 'live' ? 'live_chat' : 'ai_faq'
                })
            });

            const data = await response.json();
            if (data.success && data.data && data.data.id) {
                if (data.data.id > lastKnownMessageId) {
                    lastKnownMessageId = data.data.id;
                    localStorage.setItem("primelux_last_msg_id", lastKnownMessageId.toString());
                }
            }

            // Kích hoạt ngay polling kiểm tra phản hồi từ tư vấn viên
            startFastPolling();
        } catch (err) {
            console.error("Gửi tin nhắn thất bại:", err);
        }
    }

    // 9. POLLING REALTIME: NHẬN PHẢN HỒI TỪ TƯ VẤN VIÊN TỨC THÌ (MỖI 1.5 GIÂY)
    function startFastPolling() {
        if (pollingInterval) clearInterval(pollingInterval);

        pollingInterval = setInterval(async () => {
            try {
                const res = await fetch(`/api/consultant/check-reply?session_id=${encodeURIComponent(sessionId)}&after_id=${lastKnownMessageId}`);
                const data = await res.json();

                if (data.success && Array.isArray(data.new_messages) && data.new_messages.length > 0) {
                    data.new_messages.forEach(msg => {
                        if (msg.id > lastKnownMessageId) {
                            lastKnownMessageId = msg.id;
                            localStorage.setItem("primelux_last_msg_id", lastKnownMessageId.toString());

                            // Hiển thị tin nhắn của chuyên viên
                            playReceiveSound();
                            appendBubble('advisor', msg.noi_dung, {
                                id: msg.id,
                                advisorName: msg.nguoi_gui || 'Chuyên Viên Tư Vấn PrimeLux',
                                time: msg.thoi_gian
                            });

                            // Nếu chatbox đang đóng -> tăng số badge chưa đọc
                            if (!chatBox.classList.contains("active")) {
                                unreadCount++;
                                unreadBadge.textContent = unreadCount;
                                unreadBadge.classList.remove("d-none");
                            }
                        }
                    });
                }
            } catch (e) {
                // Ignore network glitch
            }
        }, 1500); // 1.5s nhạy như Messenger
    }

    // 10. CHUYỂN ĐỔI CHẾ ĐỘ GIỮA TƯ VẤN TRỰC TIẾP & TRỢ LÝ TỰ ĐỘNG
    function switchMode(newMode) {
        currentMode = newMode;
        localStorage.setItem("primelux_chat_mode", currentMode);

        if (currentMode === 'live') {
            tabModeLive.classList.add("active");
            tabModeBot.classList.remove("active");
        } else {
            tabModeBot.classList.add("active");
            tabModeLive.classList.remove("active");
        }

        renderWelcomeMessage();
    }

    // 11. ĐỔI THÔNG TIN TÊN & SỐ ĐIỆN THOẠI KHÁCH HÀNG
    function editCustomerInfo() {
        const name = prompt("Nhập Họ & Tên của Quý khách:", customerName === "Khách hàng Web" ? "" : customerName);
        if (name !== null && name.trim()) {
            customerName = name.trim();
            localStorage.setItem("primelux_customer_name", customerName);
        }

        const phone = prompt("Nhập Số Điện Thoại / Zalo để nhận báo giá riêng:", customerPhone);
        if (phone !== null && phone.trim()) {
            customerPhone = phone.trim();
            localStorage.setItem("primelux_customer_phone", customerPhone);
        }

        displayCustomerName.textContent = customerName + (customerPhone ? ` (${customerPhone})` : '');
    }

    // 12. BỘ CÂU TRẢ LỜI MẪU CỦA BOT TỰ ĐỘNG
    function findPredefinedAnswer(input) {
        const lower = input.toLowerCase();
        if (lower.includes("ngân sách") || lower.includes("tư vấn dòng xe")) {
            return `💰 <b>PrimeLux phân phối các siêu xe theo khoảng ngân sách:</b><br>
            • <b>Dưới 6 Tỷ:</b> Audi e-tron GT (5.2 Tỷ), BMW 740i Pure Excellence (6.29 Tỷ)<br>
            • <b>Từ 6 - 10 Tỷ:</b> Porsche Taycan Turbo S (9.55 Tỷ), Lexus LX 600 VIP (9.61 Tỷ)<br>
            • <b>Trên 10 Tỷ:</b> Mercedes-Maybach S 680 (15.99 Tỷ), Range Rover Autobiography (11.69 Tỷ)<br>
            👉 Quý khách có thể chuyển sang <b>Tư Vấn Trực Tiếp</b> để chuyên viên gửi hồ sơ xe nhé!`;
        }
        if (lower.includes("lăn bánh") || lower.includes("thuế trước bạ")) {
            return `🧮 <b>Cách tính Giá Lăn Bánh:</b> Giá niêm yết + Thuế trước bạ (10-12%) + Phí biển số (20 triệu tại HN/HCM) + Bảo hiểm & Đăng kiểm.<br>
            <i>💡 Hội viên PrimeLux Club được giảm trực tiếp 1% - 3% giá mua xe!</i>`;
        }
        if (lower.includes("trả góp") || lower.includes("vay")) {
            return `💳 <b>Gói vay mua xe sang 80%:</b> Hỗ trợ vay tối đa 8 năm, lãi suất từ 6.8%/năm, duyệt hồ sơ VIP trong 2 giờ làm việc.`;
        }
        if (lower.includes("lái thử")) {
            return `🏎️ <b>Dịch vụ lái thử VIP tận nơi:</b> PrimeLux mang siêu xe đến tận tư gia hoặc cơ quan Quý khách trải nghiệm hoàn toàn miễn phí!`;
        }
        return null;
    }

    // 13. LẮNG NGHE SỰ KIỆN GIAO DIỆN
    toggleBtn.addEventListener("click", () => {
        chatBox.classList.toggle("active");
        if (chatBox.classList.contains("active")) {
            unreadCount = 0;
            unreadBadge.classList.add("d-none");
            chatInput.focus();
            getAudioContext(); // kích hoạt audio
            startFastPolling();
        }
    });

    closeBtn.addEventListener("click", () => {
        chatBox.classList.remove("active");
    });

    tabModeLive.addEventListener("click", () => switchMode("live"));
    tabModeBot.addEventListener("click", () => switchMode("bot"));

    btnEditCustomerInfo.addEventListener("click", editCustomerInfo);

    sendBtn.addEventListener("click", () => handleSendMessage());

    chatInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            handleSendMessage();
        }
    });

    // Bắt sự kiện click các chip câu hỏi nhanh (Event Delegation)
    chatBody.addEventListener("click", (e) => {
        const chip = e.target.closest(".chip-btn");
        if (chip && chip.dataset.quick) {
            handleSendMessage(chip.dataset.quick);
        }
    });

    // 14. KHỞI ĐỘNG BAN ĐẦU
    renderWelcomeMessage();
    startFastPolling();
})();
