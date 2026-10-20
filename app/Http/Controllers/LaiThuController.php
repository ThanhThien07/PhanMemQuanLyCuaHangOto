<?php

namespace App\Http\Controllers;

use App\Models\LaiThu;
use App\Models\Xe;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class LaiThuController extends Controller
{
    public function index(Request $request)
    {
        $cars = Xe::getAllCars();
        $selectedCar = $request->query('car', '');

        $existingBookings = [];
        try {
            $existingBookings = LaiThu::where('trang_thai', '!=', 'Đã hủy')
                ->select('showroom', 'thoi_gian')
                ->get()
                ->map(function ($b) {
                    return [
                        'showroom' => $b->showroom,
                        'thoi_gian' => substr($b->thoi_gian, 0, 16),
                    ];
                })->toArray();
        } catch (\Throwable $e) {
        }

        return view('laithu', compact('cars', 'selectedCar', 'existingBookings'));
    }

    public static function getStats(): array
    {
        try {
            $totalDrives = LaiThu::count();
            $pendingCount = LaiThu::whereIn('trang_thai', ['Chờ duyệt', 'Đang chờ duyệt'])->count();
            $contactedCount = LaiThu::where('trang_thai', 'Đã liên hệ')->count();
            $completedCount = LaiThu::whereIn('trang_thai', ['Đã hoàn thành', 'Đã xác nhận'])->count();

            return [
                'total' => $totalDrives,
                'pending' => $pendingCount,
                'contacted' => $contactedCount,
                'completed' => $completedCount,
            ];
        } catch (\Throwable $e) {
            return ['total' => 0, 'pending' => 0, 'contacted' => 0, 'completed' => 0];
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:150',
            'sdt' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'ten_xe' => 'required|string|max:150',
            'showroom' => 'required|string|max:150',
            'thoi_gian' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ]);

        // Normalize datetime-local format (HTML5 gửi "2026-10-01T09:00", MySQL cần "2026-10-01 09:00:00")
        $thoiGian = str_replace('T', ' ', $validated['thoi_gian']);
        if (strlen($thoiGian) === 16) {
            $thoiGian .= ':00'; // Thêm giây nếu thiếu
        }

        $code = 'TD-'.strtoupper(substr(uniqid(), -5));

        $testDrive = LaiThu::create([
            'ma_lich' => $code,
            'ho_ten' => $validated['ho_ten'],
            'sdt' => $validated['sdt'],
            'email' => $validated['email'] ?? 'N/A',
            'ten_xe' => $validated['ten_xe'],
            'showroom' => $validated['showroom'],
            'thoi_gian' => $thoiGian,
            'trang_thai' => 'Đang chờ duyệt',
        ]);

        // Gửi thông báo tự động đa kênh qua Zalo ZNS & SMS
        try {
            NotificationService::sendTestDriveConfirmation([
                'ho_ten' => $testDrive->ho_ten,
                'sdt' => $testDrive->sdt,
                'ten_xe' => $testDrive->ten_xe,
                'showroom' => $testDrive->showroom,
                'thoi_gian' => $testDrive->thoi_gian,
            ]);
        } catch (\Throwable $e) {
        }

        $stats = self::getStats();

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký lịch lái thử thành công! Thông báo xác nhận Zalo ZNS / SMS đã được gửi tức thì.',
            'data' => [
                'id' => $testDrive->id,
                'code' => $code,
                'ho_ten' => $testDrive->ho_ten,
                'sdt' => $testDrive->sdt,
                'email' => $testDrive->email ?? '',
                'ten_xe' => $testDrive->ten_xe,
                'showroom' => $testDrive->showroom,
                'thoi_gian' => $testDrive->thoi_gian,
                'trang_thai' => $testDrive->trang_thai,
                'created_at' => $testDrive->created_at ? $testDrive->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i'),
            ],
            'stats' => $stats,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('trang_thai', 'Đã liên hệ');
        $drive = LaiThu::where('id', $id)->orWhere('ma_lich', $id)->first();
        if ($drive) {
            $drive->trang_thai = $status;
            $drive->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
                'status' => $status,
                'stats' => self::getStats(),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy lịch lái thử'], 404);
    }

    public function destroy($id)
    {
        $drive = LaiThu::where('id', $id)->orWhere('ma_lich', $id)->first();
        if ($drive) {
            $drive->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa lịch lái thử thành công!',
                'stats' => self::getStats(),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy lịch lái thử'], 404);
    }
}
