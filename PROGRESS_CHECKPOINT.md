# BÁO CÁO TIẾN ĐỘ & CHECKPOINT DỰ ÁN PRIMELUX AUTO SHOWROOM
*(File lưu vết tiến độ chi tiết - Đọc file này là có thể tiếp tục ngay lập tức mọi phiên làm việc)*

## 1. TỔNG HỢP TOÀN BỘ CÁC YÊU CẦU NGƯỜI DÙNG & TÌNH TRẠNG GIẢI QUYẾT

### Yêu cầu 0: Lưu lại checkpoint tiến độ khi hết token
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết:** File `PROGRESS_CHECKPOINT.md` được duy trì liên tục ở root dự án, ghi rõ trạng thái từng file, logic đã xử lý, cách cấu hình và vị trí code để bất kỳ bot nào phiên sau cũng nắm bắt ngay mà không cần làm lại từ đầu.

---

### Yêu cầu 1: Đăng ký thành viên, đăng nhập bằng Google, gửi email hóa đơn về Gmail
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Trang đăng ký riêng (`/register`, `/dangky`):** Tạo mới view `resources/views/dangnhap/register.blade.php` chuẩn sang trọng, đầy đủ các trường họ tên, số điện thoại, email, mật khẩu (mã hóa bcrypt qua `Hash::make`), địa chỉ. Tự động cấp mã hội viên `KHxxx` và hạng hội viên ban đầu `Silver Member`.
  2. **Trang đăng nhập riêng (`/login`, `/dangnhap`):** Đã phân tách rành mạch trong `resources/views/dangnhap/index.blade.php` cho Khách Hàng VIP, có nút "Đăng Nhập Nhanh Bằng Tài Khoản Google" chính thức (icon SVG đa sắc chuẩn Google Identity).
  3. **Đăng nhập Google (`/auth/google` & `/auth/google/callback`):** Xử lý trong `DangNhapController@redirectToGoogle` và `@handleGoogleCallback`. Tự động nhận diện tài khoản Google, tự động tạo tài khoản Khách Hàng và đăng nhập session với avatar Google cao cấp.
  4. **Tự động gửi hóa đơn về Gmail khi mua xe:**
     - Tạo Mailable `app/Mail/HoaDonXacNhanMail.php` và template email `resources/views/emails/hoadon.blade.php` (chuẩn showroom siêu xe: logo PrimeLux, mã hóa đơn, thông tin xe, chiết khấu hạng thành viên, chi phí trả trước, bảo hành 36 tháng, chính sách bàn giao 5 sao).
     - Tích hợp gửi email trong `ThanhToanController.php` (khi thanh toán trực tuyến tiền trả trước hoàn tất) và `SepayWebhookController.php` (khi webhook ngân hàng SePay ghi nhận tiền về tài khoản).
     - Bổ sung chức năng "Gửi lại Hóa Đơn Email" trực tiếp trong Admin tại `/admin/invoices/{id}/resend-email` (`QuanTriController@resendInvoiceEmail`).

---

### Yêu cầu 2: Bảo mật Cổng bàn trực tư vấn viên (`/consultant`), không để khách tự do vào tài khoản
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. Tạo Middleware `app/Http/Middleware/AdvisorAuth.php`: Chỉ cho phép người dùng có session role là `advisor` hoặc `admin`. Khách vãng lai truy cập lập tức bị chuyển hướng 302 về trang đăng nhập với thông báo yêu cầu quyền tư vấn viên.
  2. Xóa bỏ hoàn toàn link `<a href="/consultant">Cổng Bàn Trực</a>` từng bị đặt lộ liễu trên header của Chatbox khách hàng trong cả 2 file `public/js/trolyao.js` và `public/js/chatbot.js`.

---

### Yêu cầu 3: Dọn dẹp liên kết nhanh ở footer, cấm tuyệt đối để lộ link dẫn vào trang Admin
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  - Rà soát toàn bộ footer trong `resources/views/layouts/giaodien.blade.php` và `resources/views/layouts/client.blade.php`.
  - Đã loại bỏ 100% link dẫn tới `/admin`, dashboard hay các trang quản trị.
  - Footer public hiện chỉ gồm các liên kết dịch vụ công khai: *Danh Sách Mẫu Xe, Đăng Ký Lái Thử, Tra Cứu Hóa Đơn, Thu Cũ Đổi Mới, Dịch Vụ Bảo Trì, Đăng Nhập Khách Hàng VIP, Đăng Ký Thành Viên*.

---

### Yêu cầu 4: Nhật ký kiểm toán (Audit Log) không được ghi lại hành động của Super Admin
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  - Can thiệp trực tiếp vào model lifecycle `app/Models/AuditLog.php` tại sự kiện `static::creating`: Nếu người thao tác là `Super Admin` (role `superadmin`, email hoặc tên chứa Super Admin) thì tự động hủy lưu bản ghi (`return false;`).
  - Giao diện `resources/views/admin/audit.blade.php` hiển thị rõ thẻ thông tin: *Super Admin nắm quyền quản trị tối thượng và được miễn trừ theo dõi nhật ký.*

---

### Yêu cầu 5: Khu vực Quản lý & Chi tiết Hóa Đơn riêng cho Admin, dời Showroom xuống cuối trang
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Hóa đơn bên Admin:**
     - Tạo Route nhóm `/admin/invoices` trong middleware `admin.auth` (`routes/web.php`).
     - Viết các phương thức `invoices()`, `invoiceDetail()`, `updateInvoiceStatus()`, `resendInvoiceEmail()` trong `app/Http/Controllers/QuanTriController.php` truy vấn trực tiếp model `HoaDon` và `InvoiceDetail` từ CSDL, không phụ thuộc hay gọi API tra cứu của khách vãng lai.
     - Tạo giao diện quản trị hóa đơn toàn diện `resources/views/admin/invoices.blade.php`: 4 thẻ KPI thống kê (Tổng hóa đơn, Tổng doanh thu, Đã thanh toán, Chờ thanh toán), bộ lọc tìm kiếm mã HĐ / tên / SĐT, bảng danh sách chi tiết, modal xem & in hóa đơn, dropdown đổi trạng thái 1 chạm và nút gửi lại hóa đơn qua email.
     - Sửa link hóa đơn trên Dashboard Admin (`resources/views/quantri/dashboard.blade.php`) trỏ chính xác sang `/admin/invoices` thay vì link ra ngoài trang khách.
  2. **Dời thông tin Showroom:**
     - Toàn bộ thông tin chuỗi showroom (TP.HCM, Hà Nội, hotline) được đặt cố định ở chân trang (Footer).
     - Đã xóa mục "Showroom" thừa thãi trên thanh navbar của `layouts/giaodien.blade.php` và `layouts/client.blade.php`.

---

### Yêu cầu 6: Bỏ phần thanh toán online bị nhúng thừa thãi trong trang tra cứu hóa đơn
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  - Tách rời triệt để: Trang `/invoices` (`resources/views/hoadon.blade.php` và `resources/views/invoices.blade.php`) chỉ phục vụ duy nhất chức năng tra cứu hóa đơn xe chính hãng cho khách vãng lai.
  - Tab 2 thanh toán online trùng lặp đã bị xóa hoàn toàn. Khách có nhu cầu thanh toán trả trước được điều hướng sang cổng thanh toán riêng biệt `/thanh-toan-tra-truoc`.

---

### Yêu cầu 7: Rà soát sửa triệt để các lỗi logic hệ thống & Nâng cấp Chatbox
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Lỗi logic bấm nút "Quay lại" (Back) sau khi đăng xuất vẫn xem được trang:**
     - Xử lý kép (Dual-layer defense):
       - *Phía Server:* `AdminAuth` và `AdvisorAuth` middleware thiết lập HTTP Header: `Cache-Control: no-store, no-cache, must-revalidate, max-age=0`, `Pragma: no-cache`, `Expires: Sat, 01 Jan 2000 00:00:00 GMT`.
       - *Phía Logout:* `DangNhapController@logout` thực hiện `forget('user')`, `flush()`, `regenerate()` và gửi header no-cache.
       - *Phía Client:* Nhúng script lắng nghe sự kiện `pageshow`: nếu trình duyệt load trang từ bộ nhớ đệm lịch sử (`event.persisted` hoặc navigation back), trang tự động `window.location.reload()` và lập tức bị middleware chặn đứng, đẩy về trang đăng nhập.
  2. **Nâng cấp Chatbox chuẩn widget thương mại hiện đại (Intercom/Crisp):**
     - Đồng bộ cả 2 file `public/js/trolyao.js` và `public/js/chatbot.js`.
     - Nút chat tròn nổi ở góc màn hình có hiệu ứng pulse, badge số tin nhắn chưa đọc màu đỏ.
     - Header chuyên nghiệp: Avatar tư vấn viên / AI với chấm xanh online trực tiếp, trạng thái phản hồi tức thì.
     - Nút chức năng trên header: Làm mới / xóa lịch sử chat (`fa-rotate-right`), Đóng widget (`fa-xmark`), hoàn toàn không còn bất kỳ link lộ cổng admin/consultant nào.
     - Tích hợp thông minh 2 chế độ:
       - *Tư Vấn Trực Tiếp (Live Chat):* Khách nhắn tin được chuyển thẳng vào hàng đợi SSE / Realtime của Bàn trực chuyên viên qua `/api/consultant/submit-question`.
       - *Trợ Lý AI Tự Động (Bot Mode):* Kết nối trực tiếp backend `AiConsultantService` qua route `/api/ai/ask`, tra cứu thông số kỹ thuật xe thực tế, giá bán, gói vay 80%, chi phí lăn bánh, hiển thị hiệu ứng bong bóng 3 chấm đang gõ (typing indicator) và gợi ý câu hỏi liên quan 1 chạm (Quick chips).
     - Lưu trữ lịch sử tin nhắn trong `localStorage` (`primelux_chat_history_v2`) giúp khách tải lại trang không bị mất nội dung cuộc trò chuyện.
     - Tích hợp âm thanh pop/ding-dong khi gửi/nhận tin nhắn qua Web Audio API không phụ thuộc file mp3 ngoài.

### Yêu cầu 8: Khắc phục triệt để 3 lỗi hiển thị theo ảnh chụp thực tế của User
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Ảnh 1 - Thiếu nút Đăng Ký và Navbar phơi bày dropdown chọn cổng nội bộ:**
     - *Hiện trạng cũ:* Trên Navbar chỉ có duy nhất nút dropdown "ĐĂNG NHẬP" và xổ ra menu chứa cả "Chuyên Viên Tư Vấn" lẫn "Quản Trị Admin" cho khách vãng lai, không có nút "Đăng Ký".
     - *Đã khắc phục:* Trong cả `resources/views/layouts/giaodien.blade.php` và `resources/views/layouts/client.blade.php`, đã xóa bỏ hoàn toàn dropdown chọn cổng này. Thay thế bằng 2 nút riêng biệt, nổi bật, sang trọng cho khách hàng:
       - Nút **"Đăng Ký"** (`/register`): Viền vàng sang trọng, icon `fa-user-plus`.
       - Nút **"Đăng Nhập"** (`/login`): Nút xanh bo tròn pill, icon `fa-right-to-bracket`.
       - Chỉ khi người dùng đã đăng nhập session thực tế (`@if(session()->has('user'))`), hệ thống mới hiển thị avatar và menu tài khoản tương ứng.
  2. **Ảnh 2 - Chatbox vẫn hiển thị "💻 Cổng Bàn Trực" do Browser Cache:**
     - *Hiện trạng cũ:* Mặc dù mã nguồn `trolyao.js` và `chatbot.js` đã xóa sạch link này, nhưng trình duyệt của người dùng vẫn đọc file JS bundle cũ từ disk cache (BFCache / Browser Disk Cache) do đường dẫn script chưa có tham số cache-busting.
     - *Đã khắc phục:* Đã bổ sung cơ chế Cache-Busting `?v={{ time() }}` cho toàn bộ các file JS và CSS trong cả `layouts/giaodien.blade.php` và `layouts/client.blade.php` (`trolyao.js`, `chatbot.js`, `cars-realtime.js`, `trangchu.js`, `Index.js`, `giaodien.css`, `trolyao.css`, `chatbot.css`, `Style.css`). Mỗi lần tải trang, trình duyệt bắt buộc phải fetch trực tiếp file JS mới từ server, triệt tiêu 100% việc dính cache cũ.
  3. **Ảnh 3 - Footer còn khối "Liên Kết Nhanh":**
     - *Hiện trạng cũ:* Cột thứ 3 ở chân trang có tiêu đề "Liên Kết Nhanh" chứa các link lặp lại và link đăng nhập/đăng ký gây rối mắt và từng chứa link nội bộ.
     - *Đã khắc phục:* Đã xóa bỏ hoàn toàn cột "Liên Kết Nhanh" khỏi cả 2 file layout. Thay thế bằng khối **"Cam Kết & Đặc Quyền 5 Sao"** chuẩn Showroom Siêu Xe:
       - 🛡️ *Bảo Hành 36 Tháng:* Tiêu chuẩn chính hãng quốc tế hoặc 100.000 km.
       - 🛟 *Cứu Hộ VIP 24/7:* Xe nâng chuyên dụng toàn quốc không chạm gầm.
       - 🔍 *Kiểm Định 176 Hạng Mục:* Cam kết xe nguyên bản, minh bạch lịch sử.
       - ⏱️ *Giờ Mở Cửa:* 08:00 - 20:00 (Phục vụ 7 ngày/tuần kể cả Lễ & Tết).

### Yêu cầu 9: Tổng rà soát và khắc phục triệt để các lỗi logic tiềm ẩn trên toàn bộ hệ thống
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Khắc phục lỗi rendering xung đột CSS giữa badge và text-clip (Ảnh Logo):**
     - Tách rời hoàn toàn thẻ `<span class="badge">` ra khỏi thẻ cha `<span class="brand-text">` trong `resources/views/dangnhap/index.blade.php` và `resources/views/layouts/admin.blade.php`. Ngăn chặn hoàn toàn hiện tượng Chromium render lớp nền xanh dương đè lên text VIP CLUB và ADMIN PORTAL.
  2. **Vá lỗ hổng rò rỉ dữ liệu tư vấn & thông tin khách hàng VIP:**
     - Trước đây, 2 API `GET /api/consultant/realtime-feed` và `GET /api/consultant/sse-stream` nằm ngoài middleware `advisor.auth`, khiến người ngoài có thể gọi API lấy toàn bộ tin nhắn, SĐT, điểm thưởng và chi tiêu của khách.
     - Đã chuyển 2 route này vào trong nhóm `Route::middleware(['advisor.auth'])`.
  3. **Chuẩn hóa phản hồi REST API cho các Middleware bảo vệ:**
     - Cập nhật cả `AdminAuth.php` và `AdvisorAuth.php`: Nếu request gửi dạng JSON (`$request->expectsJson()`), hệ thống trả về mã trạng thái chuẩn `403 Forbidden` kèm JSON thông báo thay vì redirect 302, ngăn chặn lỗi xử lý phía client frontend.
  4. **Khắc phục lỗi hiển thị hardcode thông tin khách giả trong thanh toán trả trước:**
     - Trong `resources/views/thanhtoan/tratruoc.blade.php`, ô họ tên và SĐT trước đây bị hardcode sẵn `'Nguyễn Văn Long'` và `'0901234567'`, khiến khách vãng lai tưởng bị lộ thông tin hoặc lỗi session. Đã sửa thành `value="{{ session('user.name') ?? '' }}"` và `value="{{ session('user.phone') ?? '' }}"`.
  5. **Đồng bộ Autofill cho Khách Hàng VIP trên toàn bộ các form:**
     - Tự động điền Họ tên, SĐT, Email từ session cho form Đặt lịch lái thử xe ([`laithu.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/laithu.blade.php) & [`test-drive.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/test-drive.blade.php)) và form Thu cũ đổi mới ([`tradein/index.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/tradein/index.blade.php)).
     - Tự động điền SĐT và kích hoạt tra cứu hóa đơn tức thì trên [`hoadon.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/hoadon.blade.php).
     - Bổ sung nút liên kết trực tiếp *"Đặt Cọc & Trả Trước Online (VietQR)"* trên trang chi tiết xe [`xe/chitiet.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/xe/chitiet.blade.php).

---

### Yêu cầu 10: Đồng bộ hóa Realtime 2 chiều không cần F5 (Khách hỏi câu ngoài mẫu <-> Bàn trực Tư vấn viên) & Dọn sạch dữ liệu mẫu phục vụ Demo
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Dọn sạch toàn bộ dữ liệu mẫu cũ trong CSDL:**
     - Đã dọn sạch các bảng: `chat_logs` (0 bản ghi), `hoa_don` (0 bản ghi), `dang_ky_lai_thu` (0 bản ghi), `sepay_transactions` (0 bản ghi).
     - **Giữ nguyên 100% danh mục siêu xe:** Bảng `xe` (6 xe siêu sang đầy đủ hình ảnh, thông số kỹ thuật).
     - Đã làm sạch `DatabaseSeeder.php` và `RevenueSeeder.php` để không tự động chèn các bản ghi mock `HD0001`, `HD0002`, `HD0003`... khi reseed.
     - Cập nhật `app/Models/Invoice.php` và `app/Models/TestDrive.php`: Trả về mảng rỗng `[]` khi CSDL chưa có giao dịch, chấm dứt hoàn toàn việc tiêm dữ liệu mẫu ảo khi bảng trống.
  2. **Khắc phục triệt để trang Tra Cứu Hóa Đơn ([`resources/views/hoadon.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/hoadon.blade.php)):**
     - Xóa bỏ hoàn toàn object hardcode `const sampleInvoices = { 'HD0001': ..., 'HD0002': ..., 'HD0003': ... }`.
     - Xóa các gợi ý hardcode tên khách `Nguyễn Văn A`, `Trần Thị Mai`, `Lê Hoàng Long` và các mã giả.
     - Xây dựng API thực tế [`/api/invoices/lookup`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/app/Http/Controllers/HoaDonController.php) trong `HoaDonController`: Truy vấn trực tiếp model `HoaDon` và `Customer` theo Mã Hóa Đơn hoặc Số Điện Thoại.
     - Tích hợp tự động lưu `HoaDon` thực tế trong [`ThanhToanController.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/app/Http/Controllers/ThanhToanController.php) ngay khi khách hàng xác nhận thanh toán trả trước trực tuyến.
     - Trạng thái hiện tại: Khi chưa có giao dịch demo -> hiển thị "Chưa có hóa đơn nào khớp với thông tin". Khi thao tác demo thanh toán trả trước hoặc tạo đơn -> tra cứu hiển thị ngay hóa đơn thật!
  3. **Hoàn thiện luồng đồng bộ Realtime 2 chiều Khách Hàng <-> Tư Vấn Viên tức thì không cần F5:**
     - *Phía Khách Hàng:* Trong [`public/js/trolyao.js`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/public/js/trolyao.js) & [`public/js/chatbot.js`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/public/js/chatbot.js):
       - Khi khách hỏi bất kỳ câu hỏi nào ngoài bộ câu hỏi mẫu FAQ (yêu cầu riêng, giao xe tỉnh, phong thủy, màu sắc...), backend [`AiConsultantService.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/app/Services/AiConsultantService.php) tự động gán `should_escalate = true`, lưu bản ghi với `trang_thai = 'Chờ phản hồi'` và gán đúng `session_id`.
       - Widget chatbox tự động kích hoạt `startFastPolling()` thăm dò mỗi 1.5 giây.
     - *Phía Bàn Trực Tư Vấn Viên:* Trong [`resources/views/consultant/index.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/consultant/index.blade.php) & [`resources/views/tuvanvien/index.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/tuvanvien/index.blade.php):
       - Vue.js reactive polling 1.5s qua `/api/consultant/realtime-feed`.
       - Ngay khi khách hỏi câu ngoài mẫu, tin nhắn lập tức nhảy vào danh sách bên trái, chuông thông báo Web Audio API vang lên, title tab nhấp nháy `(1) 💬 TIN NHẮN MỚI TỪ KHÁCH! - PrimeLux Advisor` và tự động chọn cuộc trò chuyện đó lên màn hình **MÀ KHÔNG CẦN F5**.
       - Chuyên viên gõ câu trả lời và nhấn "Gửi câu trả lời" (`POST /consultant/reply`).
     - *Phản hồi ngược về cho Khách Hàng:*
       - Khung chat của khách nhận được câu trả lời từ chuyên viên qua `/api/consultant/check-reply` trong vòng 1.5 giây, phát âm thanh ding-dong và bong bóng câu trả lời của Chuyên viên tư vấn xuất hiện ngay lập tức **MÀ KHÔNG CẦN F5**.

---

### Yêu cầu 11: Lọc và Sắp Xếp Lại Toàn Bộ File Dự Án (Dọn dẹp mã trùng lặp, chuẩn hóa kiến trúc MVC & loại bỏ file rác)
- **Tình trạng:** [HOÀN TẤT 100%]
- **Chi tiết thực hiện:**
  1. **Xóa bỏ trùng lặp và phân kỳ logic ở tầng Controller (Controllers Deduplication):**
     - Trước đây: Tồn tại 2 bộ Controller song song (Tiếng Việt và Tiếng Anh) với code bị phân kỳ nghiêm trọng (`LaiThuController` có thông báo Zalo ZNS/SMS, KPI, duyệt trạng thái nhưng `TestDriveController` lại thiếu; `DangNhapController` có Google OAuth và Đăng ký VIP nhưng `AuthController` là bản cũ).
     - Giải pháp chuẩn Clean Architecture: Chuyển đổi toàn bộ 8 Controller Tiếng Anh (`TestDriveController`, `AuthController`, `AdminController`, `CarComparisonController`, `CarController`, `HomeController`, `InvoiceController`, `LoyaltyController`) và `TuVanVienController` thành các Class kế thừa trực tiếp từ Controller xử lý chính thức (`extends`).
     - Lợi ích: Triệt tiêu 100% mã nguồn trùng lặp, bảo đảm mọi lời gọi qua URL/API hay class alias đều thừa hưởng toàn bộ logic mới nhất mà không lo phân kỳ logic.
  2. **Chuẩn hóa & Sắp xếp lại tầng Giao diện (Views Cleanup):**
     - Tập trung toàn bộ giao diện quản trị Admin về thư mục duy nhất [`resources/views/admin/`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin): [`dashboard.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/dashboard.blade.php), [`cars-management.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/cars-management.blade.php), [`test-drive-list.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/test-drive-list.blade.php), [`invoices.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/invoices.blade.php), [`payments.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/payments.blade.php), [`audit.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/audit.blade.php), [`tradein.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/admin/tradein.blade.php).
     - File [`resources/views/quantri/dashboard.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/quantri/dashboard.blade.php) được rút gọn thành `@include('admin.dashboard')`, giữ tương thích 100%.
     - Thay thế toàn bộ các file view sao chép trùng lặp ([`test-drive.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/test-drive.blade.php), [`cars/compare.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/cars/compare.blade.php), [`loyalty/index.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/loyalty/index.blade.php), [`tuvanvien/index.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/tuvanvien/index.blade.php), [`auth/login.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/auth/login.blade.php), [`welcome.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/welcome.blade.php)) bằng directive `@include` trỏ về view chính thống tương ứng.
     - Layouts: Thống nhất [`layouts/client.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/layouts/client.blade.php) mở rộng [`layouts/giaodien.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/layouts/giaodien.blade.php); [`layouts/app.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/layouts/app.blade.php) mở rộng [`layouts/admin.blade.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/resources/views/layouts/admin.blade.php).
  3. **Tối ưu hóa Database Seeders:**
     - Bổ sung [`RoadmapDataSeeder::class`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/database/seeders/RoadmapDataSeeder.php) vào [`DatabaseSeeder.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/database/seeders/DatabaseSeeder.php) để chỉ cần chạy 1 lệnh `php artisan db:seed` là toàn bộ dữ liệu mẫu (Sổ bảo hành VIN, cứu hộ, giá sàn đa nguồn, thương hiệu, ưu đãi VIP) đều được khởi tạo đầy đủ.
  4. **Định dạng code tự động:** Chạy Laravel Pint chuẩn PSR-12 trên toàn bộ các file sửa đổi.

---

## 2. KẾT QUẢ KIỂM THỬ HỆ THỐNG
- **Laravel Pint Code Style:** Đã chạy `vendor/bin/pint --format agent`, 100% file PHP tuân thủ tiêu chuẩn code PSR-12 / Laravel.
- **PHPUnit Test Suite:** Đã chạy `vendor/bin/phpunit --no-coverage`:
  - **Tổng số tests:** 47 tests
  - **Số assertion:** 291 assertions
  - **Kết quả:** 47 passed, 0 failed, 0 errors (100% PASS).
  - Bao phủ thêm Feature Test: [`tests/Feature/RealtimeSyncAndCleanDataTest.php`](file:///e:/btap/laragon/www/PhanMemQuanLyCuaHangOto/tests/Feature/RealtimeSyncAndCleanDataTest.php):
    1. Kiểm tra CSDL sạch dữ liệu mẫu, chỉ giữ 6 siêu xe trong kho (`test_database_has_clean_sample_data_while_keeping_cars`).
    2. Kiểm tra API Tra cứu Hóa đơn: Rỗng khi chưa có đơn, hiển thị dữ liệu thật khi có giao dịch (`test_invoice_lookup_api_returns_not_found_when_empty_and_real_data_after_order`).
    3. Kiểm tra Luồng Realtime 2 chiều: Khách hỏi câu ngoài mẫu -> Tự động nhảy sang Bàn trực -> Tư vấn viên reply -> Tự động nhảy về Chatbox khách hàng mà không cần F5 (`test_two_way_realtime_chat_sync_between_customer_and_advisor`).

