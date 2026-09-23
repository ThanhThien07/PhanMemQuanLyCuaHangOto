// SCRIPT CHATBOT TỰ ĐỘNG THÔNG MINH & KẾT NỐI CHUYÊN VIÊN TƯ VẤN (PRIMELUX AI & LIVE ADVISOR CHATBOT)

(function () {
    // 1. TẠO HTML WIDGET VÀ CHÈN VÀO CUỐI TRANG
    const chatbotHTML = `
        <div class="chatbot-widget-btn" id="chatbotToggleBtn" title="Chat với Trợ lý AI & Chuyên Viên Tư Vấn PrimeLux">
            <i class="fa-solid fa-headset"></i>
        </div>

        <div class="chatbot-box" id="chatbotBox">
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <i class="fa-solid fa-crown text-warning"></i>
                    <div>
                        <strong style="font-size: 15px; letter-spacing: 0.5px;">PrimeLux Assistant</strong>
                        <div style="font-size: 11px; color: #94a3b8; display: flex; align-items: center; gap: 5px;">
                            <span style="display:inline-block; width:7px; height:7px; background:#22c55e; border-radius:50%;"></span>
                            Trợ lý AI & Chuyên viên trực tuyến
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="/consultant" target="_blank" style="color: #93c5fd; font-size: 12px; text-decoration: none;" title="Cổng dành cho Chuyên viên tư vấn">
                        <i class="fa-solid fa-user-tie"></i> Cổng Tư Vấn
                    </a>
                    <button id="chatbotCloseBtn" style="background: none; border: none; color: #fff; font-size: 18px; cursor: pointer;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="chatbot-body" id="chatbotBody">
                <div class="chat-msg bot">
                    👋 <b>Kính chào Quý khách!</b> Tôi là Trợ lý Thông Minh của <b>PrimeLux Auto</b>.
                    <br><br>
                    Quý khách có thể bấm chọn nhanh các <b>câu hỏi mẫu có sẵn</b> dưới đây hoặc gõ trực tiếp câu hỏi riêng để được <b>Chuyên Viên Tư Vấn VIP</b> giải đáp riêng nhé:
                    
                    <div class="quick-chips">
                        <button class="chip-btn" onclick="sendQuickMessage('Tư vấn dòng xe sang theo ngân sách')">💰 Báo giá theo ngân sách</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Cách tính giá lăn bánh xe?')">🧮 Bảng tính giá lăn bánh</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Chính sách tích điểm VIP PrimeLux Club')">💎 Tích điểm & Ưu đãi VIP</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Thủ tục mua xe trả góp và lãi suất')">💳 Mua xe trả góp 80%</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Đăng ký lái thử xe VIP tận nhà')">🏎️ Đặt lịch lái thử xe</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Chính sách bảo hành và bảo dưỡng')">🛡️ Bảo hành & Cứu hộ 24/7</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Dịch vụ thu cũ đổi mới Trade-In')">🔄 Thu cũ đổi mới (Trade-In)</button>
                        <button class="chip-btn" onclick="sendQuickMessage('Địa chỉ Showroom và Hotline liên hệ')">📍 Showroom & Giờ mở cửa</button>
                        <button class="chip-btn special" onclick="sendQuickMessage('Tôi muốn đặt câu hỏi riêng cho Chuyên viên tư vấn')">👨‍💼 Đặt câu hỏi cho Tư Vấn Viên</button>
                    </div>
                </div>
            </div>

            <div class="chatbot-footer">
                <input type="text" id="chatbotInput" class="chatbot-input" placeholder="Nhập câu hỏi bất kỳ cho chuyên viên..." onkeypress="handleKeyPress(event)">
                <button class="chatbot-send-btn" onclick="sendUserMessage()" title="Gửi tin nhắn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', chatbotHTML);

    // 2. TƯƠNG TÁC ĐÓNG MỞ CHATBOX
    const toggleBtn = document.getElementById("chatbotToggleBtn");
    const closeBtn = document.getElementById("chatbotCloseBtn");
    const chatBox = document.getElementById("chatbotBox");

    toggleBtn.addEventListener("click", () => {
        chatBox.classList.toggle("active");
        if (chatBox.classList.contains("active")) {
            document.getElementById("chatbotInput").focus();
        }
    });

    closeBtn.addEventListener("click", () => {
        chatBox.classList.remove("active");
    });
})();

// THEO DÕI CÁC MÃ CÂU HỎI CHỜ CHUYÊN VIÊN TRẢ LỜI
let pendingAdvisorMessages = [];

// XỬ LÝ GỬI TIN NHẮN TỪ KHÁCH HÀNG
function sendUserMessage() {
    const input = document.getElementById("chatbotInput");
    const text = input.value.trim();
    if (!text) return;

    appendMessage(text, "user");
    input.value = "";

    processCustomerQuestion(text);
}

function sendQuickMessage(text) {
    appendMessage(text, "user");
    processCustomerQuestion(text);
}

function handleKeyPress(e) {
    if (e.key === "Enter") {
        sendUserMessage();
    }
}

function appendMessage(text, sender, meta = {}) {
    const body = document.getElementById("chatbotBody");
    const msgDiv = document.createElement("div");
    msgDiv.className = `chat-msg ${sender}`;

    if (sender === 'advisor') {
        msgDiv.innerHTML = `
            <div class="advisor-status-badge mb-1">
                <i class="fa-solid fa-headset"></i> ${meta.advisorName || 'Chuyên Viên Tư Vấn PrimeLux'}
            </div>
            <div>${text}</div>
            <div style="font-size: 10px; color: #94a3b8; text-align: right; margin-top: 4px;">${meta.time || 'Vừa xong'}</div>
        `;
    } else {
        msgDiv.innerHTML = text;
    }

    body.appendChild(msgDiv);
    body.scrollTop = body.scrollHeight;
}

// XỬ LÝ VÀ PHÂN LOẠI CÂU HỎI
function processCustomerQuestion(text) {
    // 1. Kiểm tra xem có khớp câu hỏi mẫu hay câu hỏi riêng
    const matchedResponse = findPredefinedAnswer(text);

    if (matchedResponse) {
        // Phản hồi mẫu tự động
        setTimeout(() => {
            appendMessage(matchedResponse, "bot");
            saveChatToAdmin(text, "mau_he_thong", matchedResponse);
        }, 500);
    } else {
        // CÂU HỎI RIÊNG NGOÀI MẪU -> CHUYỂN SANG BÀN CHUYÊN VIÊN TƯ VẤN
        setTimeout(async () => {
            const tempCode = "MSG-" + Date.now().toString().slice(-4);
            const botNotice = `
                👨‍💼 <b>Yêu cầu tư vấn riêng của Quý khách đã được gửi tới Cổng Trực Tuyến của Chuyên Viên Tư Vấn VIP</b> (Mã yêu cầu: <b style="color: #facc15;">#${tempCode}</b>).
                <br><br>
                Chuyên viên tư vấn đang tiếp nhận nội dung và sẽ gửi câu trả lời riêng cho Quý khách ngay tại đây.
                <br><br>
                <i>💡 Mẹo: Quý khách có thể gửi kèm Số Điện Thoại để chuyên viên chuẩn bị hồ sơ xe và bảng giá ưu đãi riêng gửi qua Zalo/Phone.</i>
            `;
            appendMessage(botNotice, "bot");

            // Gửi lên backend API để Chuyên viên tư vấn thấy trên Portal
            try {
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                // Tìm SĐT trong tin nhắn nếu có
                const phoneMatch = text.match(/(0[3|5|7|8|9][0-9]{8})/);
                const sdtKhach = phoneMatch ? phoneMatch[0] : null;

                const response = await fetch('/api/consultant/submit-question', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        noi_dung: text,
                        sdt_khach: sdtKhach,
                        nguoi_gui: sdtKhach ? `Khách (${sdtKhach})` : 'Khách hàng Web',
                        loai_cau_hoi: 'cau_hoi_rieng',
                        phan_hoi_bot: 'Đã chuyển tới Chuyên viên tư vấn'
                    })
                });

                const res = await response.json();
                if (res.success && res.ma_tin) {
                    pendingAdvisorMessages.push(res.ma_tin);
                    // Bắt đầu kiểm tra câu trả lời từ chuyên viên định kỳ
                    startPollingForAdvisorReply(res.ma_tin);
                }
            } catch (err) {
                console.log("Chat sync note:", err);
            }

            saveChatToAdmin(text, "cau_hoi_rieng", botNotice);
        }, 600);
    }
}

// BỘ CÂU HỎI MẪU & CÂU TRẢ LỜI CÓ SẴN (EXPANDED FAQ DATABASE)
function findPredefinedAnswer(input) {
    const lower = input.toLowerCase();

    // 1. TƯ VẤN DÒNG XE & NGÂN SÁCH
    if (lower.includes("ngân sách") || lower.includes("tư vấn dòng xe") || lower.includes("gợi ý xe")) {
        return `💰 <b>PrimeLux phân phối các siêu phẩm xe sang theo các khoảng ngân sách:</b><br><br>
        • <b>Dưới 6 Tỷ:</b><br>
          - <b>Audi e-tron GT:</b> 5.200.000.000 VNĐ (Thuần điện Gran Turismo, tăng tốc 0-100km/h trong 4.1s)<br>
          - <b>BMW 740i Pure Excellence:</b> 6.299.000.000 VNĐ (Rạp chiếu 8K 31.3 inch Theatre Screen)<br><br>
        • <b>Từ 6 - 10 Tỷ:</b><br>
          - <b>Porsche Taycan Turbo S:</b> 9.550.000.000 VNĐ (750 mã lực, sạc 5-80% trong 22 phút)<br>
          - <b>Lexus LX 600 VIP 4 Chỗ:</b> 9.610.000.000 VNĐ (Độc bản ghế thương gia massage đá nóng)<br><br>
        • <b>Trên 10 Tỷ:</b><br>
          - <b>Mercedes-Maybach S 680:</b> 15.990.000.000 VNĐ (Đỉnh cao V12 6.0L 612Hp, da Nappa độc quyền)<br>
          - <b>Range Rover Autobiography LWB:</b> 11.699.000.000 VNĐ (Quý tộc Anh Quốc, trục cơ sở kéo dài)<br><br>
        👉 <a href="/cars" style="color: #facc15; font-weight: bold; text-decoration: underline;">Bấm vào đây để xem toàn bộ Kho Xe</a>`;
    }

    // 2. MẪU XE CỤ THỂ
    if (lower.includes("maybach") || lower.includes("s680") || lower.includes("s 680")) {
        return `🌟 <b>Mercedes-Maybach S 680 4MATIC:</b><br>
        • <b>Giá niêm yết:</b> 15.990.000.000 VNĐ<br>
        • <b>Động cơ:</b> V12 6.0L Twin-Turbo (612 Mã lực, 900 Nm)<br>
        • <b>Nội thất:</b> Da Nappa Maybach độc quyền, tủ lạnh Champagne, âm thanh Burmester 4D High-End 31 loa.<br>
        • <b>Xe sẵn giao ngay:</b> Đen Ruby, Trắng Diamond, Đen Obsidian.<br>
        👉 <a href="/cars/car-01" style="color: #facc15; font-weight: bold; text-decoration: underline;">Xem chi tiết & Tính lăn bánh Maybach S680</a>`;
    }

    if (lower.includes("taycan") || lower.includes("porsche")) {
        return `⚡ <b>Porsche Taycan Turbo S:</b><br>
        • <b>Giá niêm yết:</b> 9.550.000.000 VNĐ<br>
        • <b>Động cơ:</b> Thuần điện kép (750 Mã lực, tăng tốc 0-100km/h: 2.8s)<br>
        • <b>Công nghệ sạc:</b> Hệ thống sạc 800V siêu nhanh, tặng kèm trạm sạc Wallbox 22kW 3 pha tại nhà.<br>
        👉 <a href="/cars/car-02" style="color: #facc15; font-weight: bold; text-decoration: underline;">Xem chi tiết Porsche Taycan Turbo S</a>`;
    }

    if (lower.includes("bmw") || lower.includes("740i")) {
        return `🇩🇪 <b>BMW 740i Pure Excellence:</b><br>
        • <b>Giá niêm yết:</b> 6.299.000.000 VNĐ<br>
        • <b>Điểm nhấn:</b> Đèn pha pha lê Swarovski Iconic Glow, màn hình giải trí sau 31.3 inch chuẩn rạp phim 8K, cửa tự động đóng mở thông minh.<br>
        👉 <a href="/cars/car-03" style="color: #facc15; font-weight: bold; text-decoration: underline;">Xem chi tiết BMW 740i</a>`;
    }

    if (lower.includes("range rover") || lower.includes("autobiography")) {
        return `👑 <b>Range Rover Autobiography LWB:</b><br>
        • <b>Giá niêm yết:</b> 11.699.000.000 VNĐ<br>
        • <b>Động cơ:</b> V8 4.4L Twin-Turbo 530 Mã lực.<br>
        • <b>Đẳng cấp:</b> Trục cơ sở kéo dài LWB, ghế thương gia hạng nhất Executive Class Comfort-Plus massage đá nóng, hệ thống đánh lái 4 bánh toàn thời gian.<br>
        👉 <a href="/cars/car-05" style="color: #facc15; font-weight: bold; text-decoration: underline;">Xem chi tiết Range Rover Autobiography</a>`;
    }

    if (lower.includes("lexus") || lower.includes("lx600") || lower.includes("lx 600")) {
        return `🇯🇵 <b>Lexus LX 600 VIP 4 Chỗ:</b><br>
        • <b>Giá niêm yết:</b> 9.610.000.000 VNĐ<br>
        • <b>Đặc điểm:</b> Cấu hình 4 chỗ thương gia độc bản, ngả lưng 48 độ với bệ đỡ bắp chân Ottoman, hệ thống treo khí nén biến thiên AVS.<br>
        👉 <a href="/cars/car-06" style="color: #facc15; font-weight: bold; text-decoration: underline;">Xem chi tiết Lexus LX 600 VIP</a>`;
    }

    // 3. TÍNH GIÁ LĂN BÁNH
    if (lower.includes("lăn bánh") || lower.includes("chi phí lăn bánh") || lower.includes("thuế trước bạ")) {
        return `🧮 <b>Cách tính Giá Lăn Bánh Xe Sang:</b><br>
        Giá Lăn Bánh = <b>Giá niêm yết</b> + <b>Thuế trước bạ</b> (10-12%) + <b>Phí biển số</b> (20 triệu tại TP.HCM/HN) + <b>Bảo hiểm vật chất</b> (1.5%) + <b>Phí đăng kiểm & đường bộ</b>.<br><br>
        <i>💡 Đặc biệt: Hội viên PrimeLux Club được <b>chiết khấu giảm trực tiếp 1% - 3%</b> trên giá trị xe!</i><br>
        👉 Quý khách có thể vào trang chi tiết mẫu xe bất kỳ để sử dụng <b>Bảng Tính Giá Lăn Bánh Tự Động</b> tích hợp chiết khấu VIP nhé.`;
    }

    // 4. CHÍNH SÁCH TÍCH ĐIỂM HỘI VIÊN PRIMELUX CLUB
    if (lower.includes("tích điểm") || lower.includes("hội viên") || lower.includes("hạng thành viên") || lower.includes("primelux club") || lower.includes("voucher") || lower.includes("điểm thưởng")) {
        return `💎 <b>Chương Trình Hội Viên VIP - PrimeLux Club:</b><br>
        Tỉ lệ: <b>10.000.000 VNĐ = 1 PrimePoint</b> tích lũy trọn đời.<br><br>
        • <b>Hạng Bạc (0 pts):</b> Tích điểm 1%, kiểm tra xe định kỳ 165 điểm miễn phí, giảm 5% phụ kiện.<br>
        • <b>Hạng Vàng (1.000 pts):</b> <b>Chiết khấu trực tiếp 1%</b> giá xe, tặng 1 năm bảo dưỡng miễn phí, giảm 10% phụ kiện.<br>
        • <b>Hạng Bạch Kim (5.000 pts):</b> <b>Chiết khấu trực tiếp 2%</b> giá xe, <b>tặng gói Bảo hiểm thân vỏ 1 năm</b> (đến 100 triệu), giao xe tận nhà bằng xe chuyên dụng.<br>
        • <b>Hạng Kim Cương (10.000 pts):</b> <b>Chiết khấu trực tiếp 3%</b> mọi siêu xe, tặng gói phủ Ceramic cao cấp + film cách nhiệt, vé VIP sự kiện quốc tế.<br><br>
        👉 <a href="/loyalty" style="color: #facc15; font-weight: bold; text-decoration: underline;">Bấm vào đây để Tra cứu Thẻ Hội Viên & Điểm Thưởng</a>`;
    }

    // 5. TRẢ GÓP & LÃI SUẤT
    if (lower.includes("trả góp") || lower.includes("vay") || lower.includes("ngân hàng") || lower.includes("lãi suất")) {
        return `💳 <b>Chính Sách Mua Xe Trả Góp Ưu Đãi VIP:</b><br>
        • <b>Hạn mức vay:</b> Hỗ trợ vay đến <b>80% - 85%</b> giá trị xe.<br>
        • <b>Thời hạn vay:</b> Linh hoạt từ 12 tháng đến <b>8 năm (96 tháng)</b>.<br>
        • <b>Lãi suất ưu đãi:</b> Chỉ từ <b>6.8%/năm</b> cố định năm đầu qua các ngân hàng đối tác: Vietcombank, Techcombank, Shinhan Bank, VPBank.<br>
        • <b>Hồ sơ đơn giản:</b> Duyệt hồ sơ nhanh chóng trong vòng <b>2 giờ làm việc</b>, hỗ trợ thủ tục tận nhà mà không cần chứng minh thu nhập phức tạp.<br><br>
        Quý khách cần bảng tạm tính trả góp hàng tháng vui lòng để lại SĐT để chuyên viên tài chính gửi bảng tính chi tiết.`;
    }

    // 6. LÁI THỬ XE
    if (lower.includes("lái thử") || lower.includes("đặt lịch") || lower.includes("trải nghiệm")) {
        return `🏎️ <b>Dịch Vụ Lái Thử Xe Sang Tận Nhà Hoặc Showroom:</b><br>
        • PrimeLux cung cấp dịch vụ mang siêu xe đến tận tư gia hoặc cơ quan để Quý khách trải nghiệm cảm giác lái đẳng cấp trong không gian riêng tư.<br>
        • Có chuyên viên kỹ thuật cao cấp đi cùng hướng dẫn chi tiết các tính năng an toàn và chế độ lái.<br><br>
        👉 <a href="/test-drive" style="color: #facc15; font-weight: bold; text-decoration: underline;">Bấm vào đây để Đăng Ký Lái Thử Online Trong 1 Phút</a>`;
    }

    // 7. BẢO HÀNH & BẢO DƯỠNG
    if (lower.includes("bảo hành") || lower.includes("bảo dưỡng") || lower.includes("cứu hộ") || lower.includes("sửa chữa")) {
        return `🛡️ <b>Chính Sách Bảo Hành & Dịch Vụ Hậu Mãi 5 Sao:</b><br>
        • <b>Bảo hành chính hãng:</b> Từ <b>36 đến 60 tháng</b> không giới hạn số km.<br>
        • <b>Cứu hộ 24/7 chuyên dụng:</b> Phục vụ khẩn cấp 24/7 trên toàn bộ 63 tỉnh thành bằng xe nâng chuyên dụng không chạm gầm.<br>
        • <b>Dịch vụ Mobile Service:</b> Đội ngũ kỹ thuật viên đến bảo dưỡng định kỳ tận nhà theo yêu cầu riêng của Quý khách.`;
    }

    // 8. THU CŨ ĐỔI MỚI (TRADE-IN)
    if (lower.includes("thu cũ") || lower.includes("đổi mới") || lower.includes("trade-in") || lower.includes("đổi xe") || lower.includes("bán xe cũ")) {
        return `🔄 <b>Dịch Vụ Thu Cũ Đổi Mới (PrimeLux Trade-In):</b><br>
        • Thẩm định xe cũ theo tiêu chuẩn 165 điểm kỹ thuật nghiêm ngặt ngay tại nhà Quý khách trong vòng 30 phút.<br>
        • Cam kết thu mua xe cũ với mức giá cao và cạnh tranh nhất thị trường.<br>
        • Bù trừ chênh lệch linh hoạt, hỗ trợ chuyển giao xe mới ngay trong ngày.<br><br>
        Quý khách vui lòng cho biết mẫu xe cũ (đời xe, số km) để chuyên viên định giá báo giá tham khảo tức thời.`;
    }

    // 9. ĐỊA CHỈ & SHOWROOM
    if (lower.includes("địa chỉ") || lower.includes("showroom") || lower.includes("ở đâu") || lower.includes("hotline") || lower.includes("liên hệ") || lower.includes("giờ làm việc")) {
        return `📍 <b>Hệ Thống Showroom Đẳng Cấp Của PrimeLux Auto:</b><br><br>
        • <b>Showroom TP. Hồ Chí Minh:</b> 111/28/33 Phạm Văn Chiêu, P. An Hội Tây, TP.HCM.<br>
        • <b>Showroom Hà Nội:</b> KĐT Vinhomes Riverside, Long Biên, Hà Nội.<br>
        • <b>Showroom Đà Nẵng:</b> Tuyến phố xe sang Nguyễn Văn Linh, Hải Châu, Đà Nẵng.<br><br>
        ⏰ <b>Giờ mở cửa:</b> 08:00 - 20:00 (Phục vụ 7 ngày/tuần kể cả Lễ, Tết).<br>
        📞 <b>Hotline VIP:</b> <b>0338 929 013</b> (Hỗ trợ 24/7).`;
    }

    // 10. YÊU CẦU GẶP CHUYÊN VIÊN TƯ VẤN
    if (lower.includes("chuyên viên") || lower.includes("tư vấn viên") || lower.includes("gặp người") || lower.includes("câu hỏi riêng")) {
        return null; // Trả về null để chuyển vào nhánh Câu hỏi riêng xử lý bởi Chuyên viên
    }

    return null; // Không khớp mẫu -> chuyển sang Chuyên viên tư vấn trả lời
}

// THEO DÕI CÂU TRẢ LỜI CỦA CHUYÊN VIÊN TƯ VẤN CHO KHÁCH HÀNG (POLLING)
function startPollingForAdvisorReply(maTin) {
    let attempts = 0;
    const interval = setInterval(async () => {
        attempts++;
        if (attempts > 60) { // Dừng sau 5 phút
            clearInterval(interval);
            return;
        }

        try {
            const res = await fetch(`/api/consultant/check-reply?ma_tin=${maTin}`);
            const data = await res.json();

            if (data.success && data.has_reply) {
                clearInterval(interval);
                // Hiển thị câu trả lời trực tiếp của chuyên viên tư vấn lên chatbox
                appendMessage(data.reply, "advisor", {
                    advisorName: data.advisor_name,
                    time: data.reply_time
                });

                // Xóa khỏi danh sách chờ
                pendingAdvisorMessages = pendingAdvisorMessages.filter(id => id !== maTin);
            }
        } catch (e) {
            console.log("Check reply polling note:", e);
        }
    }, 5000);
}

// LƯU LỊCH SỬ CHAT VÀO LOCALSTORAGE
function saveChatToAdmin(msg, type = "cau_hoi_rieng", botReply = "") {
    let history = JSON.parse(localStorage.getItem("prime_chat_logs")) || [];
    history.push({
        id: "MSG-" + Date.now().toString().slice(-4),
        time: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
        text: msg,
        sender: "Khách hàng Web",
        type: type,
        botReply: botReply
    });
    localStorage.setItem("prime_chat_logs", JSON.stringify(history));
}
