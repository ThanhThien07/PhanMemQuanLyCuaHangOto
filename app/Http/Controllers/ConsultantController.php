<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConsultantController extends Controller
{
    /**
     * Display the Consultant / Live Advisor Portal
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'all');

        $query = ChatLog::orderBy('id', 'desc');
        if ($statusFilter !== 'all' && ! empty($statusFilter)) {
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
                'text' => 'Chào Quý khách! Hiện tại Showroom PrimeLux đang có sẵn mẫu xe theo yêu cầu với đầy đủ tùy chọn màu sắc và nội thất cao cấp. Thời gian bàn giao hoàn thiện thủ tục biển số từ 2 - 3 ngày làm việc. Chuyên viên xin phép gửi bảng báo giá chi tiết qua Zalo/SĐT của Quý khách ạ.',
            ],
            [
                'title' => 'Tư vấn đặt lịch lái thử tận nơi',
                'text' => 'Dạ chào Quý khách! PrimeLux cung cấp dịch vụ mang siêu xe đến tận tư gia hoặc cơ quan để Quý khách trải nghiệm lái thử hoàn toàn miễn phí. Quý khách vui lòng xác nhận địa chỉ và khung giờ thuận tiện nhất để chuyên viên sắp xếp xe chuyên dụng đưa xe đến phục vụ ạ.',
            ],
            [
                'title' => 'Tư vấn gói vay trả góp 80% lãi suất ưu đãi',
                'text' => 'Chào Quý khách! Đối với dòng xe này, ngân hàng đối tác VIP của PrimeLux (Vietcombank, Techcombank, Shinhan) hỗ trợ hạn mức vay lên đến 80% giá trị xe trong thời gian tối đa 8 năm. Lãi suất ưu đãi chỉ từ 6.8%/năm và phê duyệt hồ sơ trong vòng 2 giờ.',
            ],
            [
                'title' => 'Chính sách đặc quyền bảo hành & bảo dưỡng VIP',
                'text' => 'Dạ thưa Quý khách, tất cả xe phân phối tại PrimeLux đều được áp dụng chế độ bảo hành 36 - 60 tháng chính hãng không giới hạn số km. Ngoài ra, Quý khách còn được tặng dịch vụ cứu hộ chuyên dụng 24/7 toàn quốc và dịch vụ bảo dưỡng tận nhà Mobile Service.',
            ],
            [
                'title' => 'Quy trình Thu cũ đổi mới (Trade-in Siêu xe)',
                'text' => 'Chào Quý khách! Đội ngũ chuyên gia thẩm định xe của PrimeLux sẵn sàng đến tận nơi kiểm tra xe cũ của Quý khách theo tiêu chuẩn 165 điểm trong vòng 30 phút, cam kết thu mua với mức giá cạnh tranh nhất thị trường để Quý khách đổi sang siêu xe mới nhanh chóng.',
            ],
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
     * Consultant replies to a customer question or session thread
     */
    public function reply(Request $request)
    {
        $validated = $request->validate([
            'ma_tin' => 'nullable|string',
            'session_id' => 'nullable|string',
            'tra_loi' => 'required|string',
            'ten_tu_van' => 'nullable|string|max:100',
            'trang_thai' => 'nullable|string|max:50',
        ]);

        $advisorName = $validated['ten_tu_van'] ?? 'Chuyên Viên Tư Vấn PrimeLux';
        $newStatus = $validated['trang_thai'] ?? 'Đã trả lời';

        // Tìm tin nhắn theo ma_tin hoặc session_id
        $log = null;
        if (! empty($validated['ma_tin'])) {
            $log = ChatLog::where('ma_tin', $validated['ma_tin'])->first();
        }
        if (! $log && ! empty($validated['session_id'])) {
            $log = ChatLog::where('session_id', $validated['session_id'])->latest('id')->first();
        }

        if (! $log && empty($validated['session_id'])) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy câu hỏi này']);
        }

        $sessionId = $log ? ($log->session_id ?? $log->ma_tin) : $validated['session_id'];

        if ($log) {
            $log->tra_loi_tu_van = $validated['tra_loi'];
            $log->ten_tu_van = $advisorName;
            $log->thoi_gian_tra_loi = now();
            $log->trang_thai = $newStatus;
            $log->save();
        }

        // Cập nhật tất cả tin nhắn trong session đó
        if ($sessionId) {
            ChatLog::where('session_id', $sessionId)
                ->where('trang_thai', 'Chờ phản hồi')
                ->update(['trang_thai' => $newStatus]);
        }

        // Tạo bản ghi tin nhắn phản hồi từ chuyên viên để phục vụ Messenger thread
        $advisorMsg = ChatLog::create([
            'session_id' => $sessionId,
            'ma_tin' => 'ADV-'.strtoupper(substr(uniqid(), -5)),
            'thoi_gian' => now()->format('H:i'),
            'nguoi_gui' => $advisorName,
            'sender_type' => 'consultant',
            'sdt_khach' => $log ? $log->sdt_khach : null,
            'noi_dung' => $validated['tra_loi'],
            'loai_cau_hoi' => 'tu_van_tra_loi',
            'trang_thai' => $newStatus,
            'tra_loi_tu_van' => $validated['tra_loi'],
            'ten_tu_van' => $advisorName,
            'thoi_gian_tra_loi' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi câu trả lời tư vấn thành công!',
            'data' => [
                'id' => $advisorMsg->id,
                'ma_tin' => $log ? $log->ma_tin : $advisorMsg->ma_tin,
                'session_id' => $sessionId,
                'tra_loi' => $validated['tra_loi'],
                'ten_tu_van' => $advisorName,
                'thoi_gian' => now()->format('H:i d/m/Y'),
                'trang_thai' => $newStatus,
            ],
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
        if (! $log) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy câu hỏi']);
        }

        $log->trang_thai = $validated['trang_thai'];
        $log->save();

        if ($log->session_id) {
            ChatLog::where('session_id', $log->session_id)->update(['trang_thai' => $log->trang_thai]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!',
            'new_status' => $log->trang_thai,
        ]);
    }

    /**
     * Submit question / message from Website Chatbox
     */
    public function submitQuestion(Request $request)
    {
        $validated = $request->validate([
            'noi_dung' => 'required|string',
            'sdt_khach' => 'nullable|string|max:20',
            'nguoi_gui' => 'nullable|string|max:100',
            'loai_cau_hoi' => 'nullable|string|max:50',
            'phan_hoi_bot' => 'nullable|string',
            'session_id' => 'nullable|string|max:60',
        ]);

        $maTin = 'MSG-'.strtoupper(substr(uniqid(), -5));
        $sessionId = ! empty($validated['session_id'])
            ? $validated['session_id']
            : ('SES-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -6)));

        $chatLog = ChatLog::create([
            'session_id' => $sessionId,
            'ma_tin' => $maTin,
            'thoi_gian' => now()->format('H:i'),
            'nguoi_gui' => $validated['nguoi_gui'] ?? 'Khách hàng Web',
            'sender_type' => 'customer',
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
            'session_id' => $sessionId,
            'thoi_gian' => $chatLog->thoi_gian,
            'data' => [
                'id' => $chatLog->id,
                'ma_tin' => $chatLog->ma_tin,
                'session_id' => $sessionId,
                'noi_dung' => $chatLog->noi_dung,
                'sender_type' => 'customer',
                'thoi_gian' => $chatLog->thoi_gian,
            ],
        ]);
    }

    /**
     * Get all messages in a session thread (Messenger view)
     */
    public function getThreadMessages(Request $request)
    {
        $sessionId = $request->query('session_id');
        $maTin = $request->query('ma_tin');

        if (! $sessionId && ! $maTin) {
            return response()->json(['success' => false, 'message' => 'Thiếu session_id hoặc ma_tin']);
        }

        $query = ChatLog::query();
        if ($sessionId) {
            $query->where('session_id', $sessionId);
        } else {
            $query->where('ma_tin', $maTin);
        }

        $messages = $query->orderBy('id', 'asc')->get();

        return response()->json([
            'success' => true,
            'session_id' => $sessionId,
            'count' => $messages->count(),
            'messages' => $messages,
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
            ],
        ]);
    }

    /**
     * Server-Sent Events (SSE) Stream for continuous realtime updates
     */
    public function sseStream(Request $request)
    {
        $response = new StreamedResponse(function () {
            $chatLogs = ChatLog::orderBy('id', 'desc')->get();
            echo "event: initial\n";
            echo 'data: '.json_encode(['count' => $chatLogs->count(), 'time' => now()->toIso8601String()])."\n\n";
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
     * Check reply for a specific message code or session thread
     */
    public function checkReply(Request $request)
    {
        $sessionId = $request->query('session_id');
        $maTin = $request->query('ma_tin');
        $afterId = (int) $request->query('after_id', 0);

        if ($sessionId) {
            // Kiểm tra các tin nhắn phản hồi mới từ chuyên viên trong session
            $newAdvisorMessages = ChatLog::where('session_id', $sessionId)
                ->where('sender_type', 'consultant')
                ->when($afterId > 0, function ($q) use ($afterId) {
                    $q->where('id', '>', $afterId);
                })
                ->orderBy('id', 'asc')
                ->get();

            // Hoặc kiểm tra xem có tin nhắn nào của khách đã được chuyên viên cập nhật trả lời không
            $answeredLog = ChatLog::where('session_id', $sessionId)
                ->whereNotNull('tra_loi_tu_van')
                ->latest('id')
                ->first();

            $hasReply = $newAdvisorMessages->isNotEmpty() || ($answeredLog && ! empty($answeredLog->tra_loi_tu_van));
            $latest = $newAdvisorMessages->last() ?? $answeredLog;

            return response()->json([
                'success' => true,
                'has_reply' => $hasReply,
                'new_messages' => $newAdvisorMessages,
                'reply' => $latest ? ($latest->tra_loi_tu_van ?? $latest->noi_dung) : null,
                'advisor_name' => $latest ? ($latest->ten_tu_van ?? $latest->nguoi_gui ?? 'Chuyên Viên Tư Vấn PrimeLux') : 'Chuyên Viên Tư Vấn PrimeLux',
                'status' => $latest ? $latest->trang_thai : 'Chờ phản hồi',
                'reply_time' => $latest && $latest->thoi_gian_tra_loi ? date('H:i d/m/Y', strtotime($latest->thoi_gian_tra_loi)) : ($latest ? $latest->thoi_gian : null),
            ]);
        }

        if (! $maTin) {
            return response()->json(['success' => false, 'message' => 'Thiếu mã tin nhắn hoặc session_id']);
        }

        $log = ChatLog::where('ma_tin', $maTin)->first();
        if (! $log) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy tin']);
        }

        return response()->json([
            'success' => true,
            'has_reply' => ! empty($log->tra_loi_tu_van),
            'reply' => $log->tra_loi_tu_van,
            'advisor_name' => $log->ten_tu_van ?? 'Chuyên Viên Tư Vấn PrimeLux',
            'status' => $log->trang_thai,
            'reply_time' => $log->thoi_gian_tra_loi ? date('H:i d/m/Y', strtotime($log->thoi_gian_tra_loi)) : null,
        ]);
    }
}
