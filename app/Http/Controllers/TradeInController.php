<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Xe;
use App\Models\YeuCauThuDoiXe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TradeInController extends Controller
{
    /**
     * Trang Thẩm Định Xe Cũ & Thu Cũ Đổi Mới (Trade-In Portal)
     */
    public function index(Request $request)
    {
        $cars = Xe::getAllCars();
        $selectedCar = $request->query('target_car', '');

        // Danh sách định giá tham khảo gần đây
        $recentRequests = YeuCauThuDoiXe::where('trang_thai', '!=', 'Đã hủy')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('tradein.index', compact('cars', 'selectedCar', 'recentRequests'));
    }

    /**
     * Tính toán giá định giá sơ bộ tức thì qua API (Instant Valuation Algorithm)
     */
    public function calculateValuation(Request $request)
    {
        $brand = $request->input('hang_xe', 'Mercedes-Benz');
        $model = $request->input('dong_xe', 'C-Class');
        $year = (int) $request->input('nam_sx', 2022);
        $odo = (int) $request->input('so_km', 30000);
        $condition = $request->input('tinh_trang', 'good');

        // Bảng giá cơ sở ước lượng xe mới theo thương hiệu
        $basePrices = [
            'Mercedes-Benz' => 2400000000,
            'BMW' => 2300000000,
            'Porsche' => 4500000000,
            'Audi' => 2200000000,
            'Lexus' => 3100000000,
            'Land Rover' => 3800000000,
            'Khác' => 1800000000,
        ];

        $base = $basePrices[$brand] ?? 2000000000;

        // Khấu hao theo năm (mỗi năm giảm 7-9%)
        $currentYear = 2026;
        $age = max(0, $currentYear - $year);
        $depreciationYear = min(0.60, $age * 0.08);

        // Khấu hao theo ODO (mỗi 10,000 km giảm ~1.5%)
        $depreciationOdo = min(0.25, ($odo / 10000) * 0.015);

        // Hệ số tình trạng
        $conditionMultipliers = [
            'excellent' => 1.05, // Xe lướt như mới
            'good' => 1.00,      // Nguyên bản, bảo dưỡng hãng
            'fair' => 0.90,      // Có trầy xước nhẹ
        ];
        $condMultiplier = $conditionMultipliers[$condition] ?? 1.00;

        $estimatedPrice = round(($base * (1 - $depreciationYear - $depreciationOdo) * $condMultiplier) / 10000000) * 10000000;
        $estimatedPrice = max(500000000, $estimatedPrice);

        return response()->json([
            'success' => true,
            'estimated_price' => $estimatedPrice,
            'formatted_price' => number_format($estimatedPrice, 0, ',', '.').' VNĐ',
            'brand' => $brand,
            'year' => $year,
            'odo' => $odo,
            'age' => $age,
        ]);
    }

    /**
     * Gửi yêu cầu Thu cũ đổi mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:120',
            'sdt' => 'required|string|max:25',
            'email' => 'nullable|email|max:120',
            'hang_xe' => 'required|string|max:80',
            'dong_xe' => 'required|string|max:120',
            'nam_sx' => 'required|integer|min:2010|max:2026',
            'so_km' => 'required|integer|min:0',
            'tinh_trang' => 'nullable|string',
            'xe_du_dinh_doi' => 'nullable|string|max:150',
            'ghi_chu' => 'nullable|string',
        ]);

        $valuationRes = $this->calculateValuation($request);
        $valData = $valuationRes->getData(true);
        $estimated = $valData['estimated_price'] ?? 1000000000;

        $code = 'TI-'.date('Y').'-'.strtoupper(Str::random(4));

        $tradeIn = YeuCauThuDoiXe::create([
            'ma_yeu_cau' => $code,
            'ho_ten' => $validated['ho_ten'],
            'sdt' => $validated['sdt'],
            'email' => $validated['email'] ?? null,
            'hang_xe' => $validated['hang_xe'],
            'dong_xe' => $validated['dong_xe'],
            'nam_sx' => $validated['nam_sx'],
            'so_km' => $validated['so_km'],
            'tinh_trang' => $validated['tinh_trang'] ?? 'Nguyên bản, không tai nạn thủy kích',
            'xe_du_dinh_doi' => $validated['xe_du_dinh_doi'] ?? 'Xe sang PrimeLux',
            'gia_dinh_gia_so_bo' => $estimated,
            'ghi_chu' => $validated['ghi_chu'] ?? null,
            'trang_thai' => 'Chờ thẩm định',
        ]);

        // Ghi nhận Audit Log
        try {
            AuditLog::create([
                'user_name' => $tradeIn->ho_ten,
                'user_role' => 'Khách hàng',
                'action' => 'Gửi yêu cầu Thu cũ đổi mới',
                'details' => "Mã #{$code}: Đề xuất đổi xe {$tradeIn->hang_xe} {$tradeIn->dong_xe} ({$tradeIn->nam_sx}) lấy {$tradeIn->xe_du_dinh_doi}. Giá ước tính: ".number_format($estimated, 0, ',', '.').' VNĐ.',
                'ip_address' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
        }

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu thẩm định Thu cũ đổi mới đã được gửi thành công! Chuyên gia PrimeLux sẽ liên hệ đặt lịch kiểm tra 176 hạng mục.',
            'data' => [
                'ma_yeu_cau' => $code,
                'gia_dinh_gia_so_bo' => number_format($estimated, 0, ',', '.').' VNĐ',
                'xe_doi' => $tradeIn->xe_du_dinh_doi,
                'trang_thai' => $tradeIn->trang_thai,
            ],
        ]);
    }

    /**
     * Quản lý yêu cầu Trade-In trong Admin
     */
    public function adminList(Request $request)
    {
        $tradeIns = YeuCauThuDoiXe::orderBy('id', 'desc')->get();

        return view('admin.tradein', compact('tradeIns'));
    }

    /**
     * Cập nhật trạng thái và giá chốt Trade-In
     */
    public function updateStatus(Request $request, $id)
    {
        $tradeIn = YeuCauThuDoiXe::where('id', $id)->orWhere('ma_yeu_cau', $id)->first();
        if (! $tradeIn) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy yêu cầu thẩm định'], 404);
        }

        $status = $request->input('trang_thai', $tradeIn->trang_thai);
        $finalPrice = $request->input('gia_chot');

        $tradeIn->trang_thai = $status;
        if ($finalPrice !== null) {
            $tradeIn->gia_chot = (float) $finalPrice;
        }
        $tradeIn->save();

        try {
            AuditLog::create([
                'user_name' => session('user.name', 'Quản trị viên'),
                'user_role' => session('user.role', 'Quản lý bán hàng'),
                'action' => 'Cập nhật thẩm định Thu cũ đổi mới',
                'details' => "Mã #{$tradeIn->ma_yeu_cau}: Trạng thái đổi thành {$status}".($finalPrice ? ', giá chốt: '.number_format($finalPrice, 0, ',', '.').' VNĐ' : ''),
                'ip_address' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thẩm định xe cũ thành công!',
            'data' => $tradeIn,
        ]);
    }
}
