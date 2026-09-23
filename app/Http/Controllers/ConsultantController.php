<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\Customer;
use App\Models\LoyaltyTier;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    /**
     * Display the Consultant / Live Advisor Portal
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'all');

        $query = ChatLog::orderBy('id', 'desc');
        if ($statusFilter !== 'all' && !empty($statusFilter)) {
            $query->where('trang_thai', $statusFilter);
        }

        $chatLogs = $query->get();

        // Attach customer VIP tier details
        foreach ($chatLogs as $log) {
            $log->customer_info = null;
            if ($log->sdt_khach) {
                $cust = Customer::with('tier')->where('sdt', $log->sdt_khach)->first();
                if ($cust) {
                    $log->customer_info = [
                        'name' => $cust->ho_ten,
                        'code' => $cust->ma_kh,
                        'points' => $cust->diem_tich_luy,
                        'tier_name' => $cust->tier ? $cust->tier->ten_hang : 'Hạng Bạc',
                        'badge' => $cust->tier ? $cust->tier->mau_badge : 'secondary',
                        'discount' => $cust->tier ? $cust->tier->ti_le_chiet_khau : 0,
                        'total_spent' => $cust->tong_chi_tieu,
                    ];
                }
            }
        }

        // Stats counters
        $allLogs = ChatLog::all();
        $totalInquiries = $allLogs->count();
        $pendingCount = $allLogs->where('trang_thai', 'Chờ phản hồi')->count();
        $inProgressCount = $allLogs->where('trang_thai', 'Đang tư vấn')->count();
        $resolvedCount = $allLogs->where('trang_thai', 'Đã trả lời')->count();

        // Sample quick replies for consultant
        $cannedReplies = [
            [
                'title' => 'Báo giá & Thời gian giao xe sẵn',
                'text' => 'Chào Quý khách! Hiện tại Showroom PrimeLux đang có sẵn mẫu xe theo yêu cầu với đầy đủ tùy chọn màu sắc và nội thất cao cấp. Thời gian bàn giao hoàn thiện thủ tục biển số từ 2 - 3 ngày làm việc. Chuyên viên xin phép gửi bảng báo giá chi tiết qua Zalo/SĐT của Quý khách ạ.'
            ],
            [
                'title' => 'Tư vấn đặt lịch lái thử tận nơi',
                'text' => 'Dạ chào Quý khách! PrimeLux cung cấp dịch vụ mang siêu xe đến tận tư gia hoặc cơ quan để Quý khách trải nghiệm lái thử hoàn toàn miễn phí. Quý khách vui lòng xác nhận địa chỉ và khung giờ thuận tiện nhất để chuyên viên sắp xếp xe chuyên dụng đưa xe đến phục vụ ạ.'
            ],
            [
                'title' => 'Tư vấn gói vay trả góp 80% lãi suất ưu đãi',
                'text' => 'Chào Quý khách! Đối với dòng xe này, ngân hàng đối tác VIP của PrimeLux (Vietcombank, Techcombank, Shinhan) hỗ trợ hạn mức vay lên đến 80% giá trị xe trong thời gian tối đa 8 năm. Lãi suất ưu đãi chỉ từ 6.8%/năm và phê duyệt hồ sơ trong vòng 2 giờ.'
            ],
            [
                'title' => 'Chính sách đặc quyền bảo hành & bảo dưỡng VIP',
                'text' => 'Dạ thưa Quý khách, tất cả xe phân phối tại PrimeLux đều được áp dụng chế độ bảo hành 36 - 60 tháng chính hãng không giới hạn số km. Ngoài ra, Quý khách còn được tặng dịch vụ cứu hộ chuyên dụng 24/7 toàn quốc và dịch vụ bảo dưỡng tận nhà Mobile Service.'
            ],
            [
                'title' => 'Quy trình Thu cũ đổi mới (Trade-in Siêu xe)',
                'text' => 'Chào Quý khách! Đội ngũ chuyên gia thẩm định xe của PrimeLux sẵn sàng đến tận nơi kiểm tra xe cũ của Quý khách theo tiêu chuẩn 165 điểm trong vòng 30 phút, cam kết thu mua với mức giá cạnh tranh nhất thị trường để Quý khách đổi sang siêu xe mới nhanh chóng.'
            ]
        ];

        return view('consultant.index', compact(
            'chatLogs',
            'statusFilter',
            'totalInquiries',
            'pendingCount',
            'inProgressCount',
            'resolvedCount',
            'cannedReplies'
        ));
    }

    /**
     * Consultant replies to a customer question
     */
    public function reply(Request $request)
    {
        $validated = $request->validate([
            'ma_tin' => 'required|string',
            'tra_loi' => 'required|string',
            'ten_tu_van' => 'nullable|string|max:100',
            'trang_thai' => 'nullable|string|max:50',
        ]);

        $log = ChatLog::where('ma_tin', $validated['ma_tin'])->first();
        if (!$log) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy câu hỏi này']);
        }

        $log->tra_loi_tu_van = $validated['tra_loi'];
        $log->ten_tu_van = $validated['ten_tu_van'] ?? 'Chuyên Viên Tư Vấn PrimeLux';
        $log->thoi_gian_tra_loi = now();
        $log->trang_thai = $validated['trang_thai'] ?? 'Đã trả lời';
        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi câu trả lời tư vấn thành công!',
            'data' => [
                'ma_tin' => $log->ma_tin,
                'tra_loi' => $log->tra_loi_tu_van,
                'ten_tu_van' => $log->ten_tu_van,
                'thoi_gian' => now()->format('H:i d/m/Y'),
                'trang_thai' => $log->trang_thai,
            ]
        ]);
    }

    /**
     * Update inquiry status
     */
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'ma_tin' => 'required|string',
            'trang_thai' => 'required|string',
        ]);

        $log = ChatLog::where('ma_tin', $validated['ma_tin'])->first();
        if (!$log) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy câu hỏi']);
        }

        $log->trang_thai = $validated['trang_thai'];
        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!',
            'new_status' => $log->trang_thai
        ]);
    }

    /**
     * Submit question from Website Chatbox
     */
    public function submitQuestion(Request $request)
    {
        $validated = $request->validate([
            'noi_dung' => 'required|string',
            'sdt_khach' => 'nullable|string|max:20',
            'nguoi_gui' => 'nullable|string|max:100',
            'loai_cau_hoi' => 'nullable|string|max:50',
            'phan_hoi_bot' => 'nullable|string',
        ]);

        $maTin = 'MSG-' . strtoupper(substr(uniqid(), -5));

        $chatLog = ChatLog::create([
            'ma_tin' => $maTin,
            'thoi_gian' => now()->format('H:i'),
            'nguoi_gui' => $validated['nguoi_gui'] ?? 'Khách hàng Web',
            'sdt_khach' => $validated['sdt_khach'] ?? null,
            'noi_dung' => $validated['noi_dung'],
            'loai_cau_hoi' => $validated['loai_cau_hoi'] ?? 'cau_hoi_rieng',
            'phan_hoi_bot' => $validated['phan_hoi_bot'] ?? 'Yêu cầu của bạn đã được chuyển đến Cổng Chuyên Viên Tư Vấn.',
            'trang_thai' => 'Chờ phản hồi',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi câu hỏi tới chuyên viên tư vấn!',
            'ma_tin' => $maTin,
            'thoi_gian' => $chatLog->thoi_gian,
        ]);
    }

    /**
     * Realtime Feed endpoint for reactive framework auto-updates
     */
    public function getRealtimeFeed(Request $request)
    {
        $chatLogs = ChatLog::orderBy('id', 'desc')->get();

        foreach ($chatLogs as $log) {
            $log->customer_info = null;
            if ($log->sdt_khach) {
                $cust = Customer::with('tier')->where('sdt', $log->sdt_khach)->first();
                if ($cust) {
                    $log->customer_info = [
                        'name' => $cust->ho_ten,
                        'code' => $cust->ma_kh,
                        'points' => $cust->diem_tich_luy,
                        'tier_name' => $cust->tier ? $cust->tier->ten_hang : 'Hạng Bạc',
                        'badge' => $cust->tier ? $cust->tier->mau_badge : 'secondary',
                        'discount' => $cust->tier ? $cust->tier->ti_le_chiet_khau : 0,
                        'total_spent' => $cust->tong_chi_tieu,
                    ];
                }
            }
        }

        $totalInquiries = $chatLogs->count();
        $pendingCount = $chatLogs->where('trang_thai', 'Chờ phản hồi')->count();
        $inProgressCount = $chatLogs->where('trang_thai', 'Đang tư vấn')->count();
        $resolvedCount = $chatLogs->where('trang_thai', 'Đã trả lời')->count();

        return response()->json([
            'success' => true,
            'timestamp' => now()->format('H:i:s d/m/Y'),
            'inquiries' => $chatLogs,
            'stats' => [
                'total' => $totalInquiries,
                'pending' => $pendingCount,
                'in_progress' => $inProgressCount,
                'resolved' => $resolvedCount,
            ]
        ]);
    }

    /**
     * Server-Sent Events (SSE) Stream for continuous realtime updates
     */
    public function sseStream(Request $request)
    {
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () {
            // Send initial ping and data
            $chatLogs = ChatLog::orderBy('id', 'desc')->get();
            echo "event: initial\n";
            echo 'data: ' . json_encode(['count' => $chatLogs->count(), 'time' => now()->toIso8601String()]) . "\n\n";
            ob_flush();
            flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

    /**
     * Check reply for a specific message code
     */
    public function checkReply(Request $request)
    {
        $maTin = $request->query('ma_tin');
        if (!$maTin) {
            return response()->json(['success' => false, 'message' => 'Thiếu mã tin nhắn']);
        }

        $log = ChatLog::where('ma_tin', $maTin)->first();
        if (!$log) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy tin']);
        }

        return response()->json([
            'success' => true,
            'has_reply' => !empty($log->tra_loi_tu_van),
            'reply' => $log->tra_loi_tu_van,
            'advisor_name' => $log->ten_tu_van ?? 'Chuyên Viên Tư Vấn PrimeLux',
            'status' => $log->trang_thai,
            'reply_time' => $log->thoi_gian_tra_loi ? date('H:i d/m/Y', strtotime($log->thoi_gian_tra_loi)) : null,
        ]);
    }
}
