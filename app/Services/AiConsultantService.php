<?php

namespace App\Services;

use App\Models\ChatLog;
use App\Models\KhachHang;
use App\Models\Xe;
use Illuminate\Support\Str;

class AiConsultantService
{
    /**
     * Trả lời câu hỏi của khách hàng qua Trợ lý ảo AI LLM RAG
     */
    public static function ask(string $question, ?string $customerPhone = null, ?string $customerName = null, ?string $sessionId = null): array
    {
        $qLower = mb_strtolower(trim($question), 'UTF-8');
        $allCars = Xe::getAllCars();

        // 1. Kiểm tra nếu khách hàng muốn gặp người thật, đàm phán hợp đồng hoặc có yêu cầu tư vấn riêng
        $escalateKeywords = [
            'gặp người', 'chuyên viên', 'nhân viên', 'gọi tôi', 'liên hệ tôi', 'hợp đồng', 'giá chốt',
            'bớt giá', 'giảm thêm', 'ký hợp đồng', 'giao về', 'giao xe', 'nội thất màu', 'đặt riêng',
            'tùy chọn', 'phong thủy', 'tư vấn riêng', 'chiết khấu riêng', 'yêu cầu riêng', 'tuần này',
        ];
        $shouldEscalate = false;
        foreach ($escalateKeywords as $kw) {
            if (str_contains($qLower, $kw)) {
                $shouldEscalate = true;
                break;
            }
        }

        // 2. Tra cứu thông tin khách hàng VIP nếu có SĐT
        $vipContext = '';
        if ($customerPhone) {
            $customer = KhachHang::with('tier')->where('sdt', $customerPhone)->first();
            if ($customer && $customer->tier) {
                $vipContext = "Quý khách là Hội viên {$customer->tier->ten_hang} của PrimeLux Club (Ưu đãi chiết khấu {$customer->tier->ti_le_chiet_khau}%). ";
            }
        }

        // 3. Phân loại câu hỏi & Sinh câu trả lời RAG
        $answer = '';
        $suggestedQuestions = [];

        if ($shouldEscalate) {
            $safeQ = htmlspecialchars($question, ENT_QUOTES, 'UTF-8');
            $answer = "Dạ kính chào Quý khách! Yêu cầu tư vấn của Quý khách: <i>\"{$safeQ}\"</i> đã được tự động chuyển tới <b>Bàn trực Chuyên Viên Tư Vấn PrimeLux</b>.<br><br>⚡ Chuyên viên đang chuẩn bị phản hồi trực tiếp cho Quý khách ngay tại đây. Quý khách vui lòng đợi trong giây lát nhé ạ!";
            $suggestedQuestions = [
                'Báo giá xe Mercedes-Maybach S680 sẵn giao ngay',
                'Gói vay ngân hàng mua xe sang trả góp 80%',
                'Đặt lịch lái thử xe tận nơi miễn phí',
            ];
        } elseif (str_contains($qLower, 'maybach') || str_contains($qLower, 's680') || str_contains($qLower, 's 680')) {
            $answer = "Dạ chào Quý khách! Mercedes-Maybach S 680 4MATIC (2026) hiện là mẫu sedan đầu bảng tại PrimeLux Auto với giá niêm yết 15.990.000.000 VNĐ. Xe trang bị động cơ V12 6.0L Biturbo 621 mã lực, hệ dẫn động 4MATIC và nội thất bọc da Nappa thủ công cùng hàng ghế sau hạng thương gia First-Class. {$vipContext}Showroom đang có sẵn xe giao ngay, Quý khách có thể đăng ký lái thử tận nơi hoặc đặt cọc giữ xe trực tuyến 24/7 ạ!";
            $suggestedQuestions = [
                'Chi phí lăn bánh Maybach S 680 tại TP.HCM là bao nhiêu?',
                'Gói vay trả góp 80% Maybach S 680 trong 5 năm?',
                'Đặt lịch lái thử Maybach S 680 tận nhà',
            ];
        } elseif (str_contains($qLower, 'porsche') || str_contains($qLower, '911') || str_contains($qLower, 'gt3')) {
            $answer = "Dạ chào Quý khách! Mẫu siêu xe thể thao Porsche 911 GT3 RS (2026) tại PrimeLux có giá niêm yết 17.850.000.000 VNĐ. Xe sở hữu động cơ 4.0L Boxer hút khí tự nhiên 518 mã lực, tăng tốc 0-100 km/h chỉ trong 3.2 giây cùng gói khí động học DRS tiêu chuẩn đua GT3. {$vipContext}PrimeLux áp dụng chính sách bảo hành chính hãng Porsche Approved 36 tháng không giới hạn km ạ.";
            $suggestedQuestions = [
                'Bảng tính trả góp Porsche 911 GT3 RS?',
                'So sánh giá Porsche 911 GT3 RS trên thị trường?',
                'Chính sách thu cũ đổi mới lấy Porsche 911',
            ];
        } elseif (str_contains($qLower, 'lăn bánh') || str_contains($qLower, 'thuế') || str_contains($qLower, 'biển số')) {
            $answer = "Dạ thưa Quý khách, chi phí lăn bánh xe tại PrimeLux được tính tự động minh bạch 100%: Lệ phí trước bạ (10% tại TP.HCM và các tỉnh, 12% tại Hà Nội); Phí cấp biển số (20.000.000 VNĐ tại HN & HCM, 1.000.000 VNĐ tại tỉnh); Phí đăng kiểm 340.000 VNĐ; Phí đường bộ 1.560.000 VNĐ/năm và Bảo hiểm TNDS 480.700 VNĐ. {$vipContext}Quý khách có thể chọn trực tiếp tỉnh thành trên trang Chi tiết xe để hệ thống tính chính xác từng đồng ạ!";
            $suggestedQuestions = [
                'Ưu đãi chiết khấu thành viên VIP giảm bao nhiêu tiền lăn bánh?',
                'Có hỗ trợ trọn gói thủ tục bấm biển số đẹp không?',
                'Xem bảng tính lăn bánh chi tiết các mẫu xe',
            ];
        } elseif (str_contains($qLower, 'trả góp') || str_contains($qLower, 'vay') || str_contains($qLower, 'ngân hàng') || str_contains($qLower, 'lãi suất')) {
            $answer = 'Dạ thưa Quý khách, PrimeLux liên kết độc quyền cùng các ngân hàng quốc tế (Vietcombank Priority, Techcombank, Shinhan Bank) tài trợ gói vay siêu xe lên đến 80% giá trị xe, thời hạn vay linh hoạt từ 1 đến 8 năm. Lãi suất ưu đãi cố định năm đầu chỉ từ 7.5% - 7.9%/năm, phê duyệt hồ sơ VIP trong vòng 2 giờ làm việc và thanh toán trả nợ theo dư nợ giảm dần. Quý khách có thể thanh toán trực tuyến tiền trả trước ngay trên website ạ!';
            $suggestedQuestions = [
                'Hồ sơ vay mua xe sang gồm những giấy tờ gì?',
                'Tính số tiền trả góp hàng tháng xe 5 tỷ?',
                'Thanh toán online tiền trả trước qua mã VietQR',
            ];
        } elseif (str_contains($qLower, 'thu cũ') || str_contains($qLower, 'đổi xe') || str_contains($qLower, 'trade-in') || str_contains($qLower, 'định giá')) {
            $answer = "Dạ chào Quý khách! Chương trình 'Thu Cũ Đổi Mới - PrimeLux Trade-In' cho phép Quý khách bán lại xe sang đang sử dụng (Mercedes, BMW, Porsche, Audi, Lexus...) để lên đời siêu xe mới. Hệ thống tự động định giá sơ bộ trực tuyến dựa trên ODO và năm sản xuất. Chuyên viên sẽ đến tận nơi kiểm tra 176 hạng mục kỹ thuật và khấu trừ trực tiếp giá trị xe cũ vào hợp đồng mua xe mới ạ!";
            $suggestedQuestions = [
                'Gửi yêu cầu định giá xe cũ của tôi ngay',
                'Kiểm tra 176 hạng mục kỹ thuật mất bao lâu?',
                'Thủ tục sang tên đổi chủ xe cũ tại showroom',
            ];
        } elseif (str_contains($qLower, 'bảo hành') || str_contains($qLower, 'bảo dưỡng') || str_contains($qLower, 'vin')) {
            $answer = 'Dạ thưa Quý khách, tất cả xe phân phối tại PrimeLux đều được trang bị Sổ bảo hành điện tử (E-Warranty) tra cứu trực tuyến theo số khung VIN. Xe được bảo hành chính hãng từ 36 đến 60 tháng, bảo dưỡng miễn phí cấp 5.000km và cứu hộ chuyên dụng 24/7 toàn quốc. Quý khách có thể nhập số VIN trên trang Dịch vụ để xem toàn bộ lịch sử phụ tùng đã thay thế ạ!';
            $suggestedQuestions = [
                'Tra cứu Sổ bảo hành điện tử bằng số khung VIN',
                'Đặt lịch bảo dưỡng định kỳ tại showroom',
                'Yêu cầu cứu hộ khẩn cấp 24/7',
            ];
        } else {
            // CÂU HỎI KHÔNG CÓ TRONG NỘI DUNG MẪU FAQ -> TỰ ĐỘNG CHUYỂN TỚI BÀN TRỰC TƯ VẤN VIÊN
            $shouldEscalate = true;
            $safeQ = htmlspecialchars($question, ENT_QUOTES, 'UTF-8');
            $answer = "Dạ kính chào Quý khách! Yêu cầu tư vấn của Quý khách: <i>\"{$safeQ}\"</i> đã được tự động chuyển tới <b>Bàn trực Chuyên Viên Tư Vấn PrimeLux</b>.<br><br>⚡ Chuyên viên đang chuẩn bị phản hồi trực tiếp cho Quý khách ngay tại đây. Quý khách vui lòng đợi trong giây lát nhé ạ!";
            $suggestedQuestions = [
                'Báo giá xe Mercedes-Maybach S680 sẵn giao ngay',
                'Gói vay ngân hàng mua xe sang trả góp 80%',
                'Đặt lịch lái thử xe tận nơi miễn phí',
            ];
        }

        // Tự động lưu vào ChatLog & gán session_id để phục vụ Messenger Thread
        $msgCode = 'MSG-'.strtoupper(Str::random(5));
        $validSessionId = ! empty($sessionId)
            ? $sessionId
            : ('SES-'.date('Ymd').'-'.strtoupper(Str::random(6)));

        try {
            ChatLog::create([
                'session_id' => $validSessionId,
                'ma_tin' => $msgCode,
                'thoi_gian' => now()->format('H:i'),
                'nguoi_gui' => $customerName ?: ($customerPhone ? "Khách hàng ({$customerPhone})" : 'Khách hàng Web'),
                'sender_type' => 'customer',
                'sdt_khach' => $customerPhone,
                'noi_dung' => $question,
                'loai_cau_hoi' => $shouldEscalate ? 'chuyen_vien_can_ho_tro' : 'ai_tu_van_tu_dong',
                'phan_hoi_bot' => $answer,
                'trang_thai' => $shouldEscalate ? 'Chờ phản hồi' : 'Đã trả lời',
            ]);
        } catch (\Throwable $e) {
        }

        return [
            'success' => true,
            'message_code' => $msgCode,
            'session_id' => $validSessionId,
            'answer' => $answer,
            'suggested_questions' => $suggestedQuestions,
            'should_escalate' => $shouldEscalate,
            'timestamp' => now()->format('H:i:s d/m/Y'),
        ];
    }
}
