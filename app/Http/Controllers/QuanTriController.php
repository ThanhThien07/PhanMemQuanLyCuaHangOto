<?php

namespace App\Http\Controllers;

use App\Models\Xe;
use App\Models\KhachHang;
use App\Models\HoaDon;
use App\Models\LaiThu;
use App\Models\HangThanhVien;
use App\Models\LichSuDiem;
use App\Models\NhatKyChat;
use Illuminate\Http\Request;

class QuanTriController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách xe
        $cars = Xe::getAllCars();

        // Lấy danh sách khách hàng + hạng thành viên
        try {
            $customers = KhachHang::with('tier')->orderBy('tong_chi_tieu', 'desc')->get();
        } catch (\Throwable $e) {
            $customers = collect([]);
        }

        // Lấy hóa đơn
        try {
            $invoices = HoaDon::with(['customer', 'details'])->orderBy('ngay_lap', 'desc')->get();
        } catch (\Throwable $e) {
            $invoices = collect([]);
        }

        // Lấy lịch lái thử
        try {
            $testDrives = LaiThu::orderBy('id', 'desc')->get();
        } catch (\Throwable $e) {
            $testDrives = collect([]);
        }

        // Lấy hạng thành viên
        try {
            $tiers = HangThanhVien::orderBy('diem_toi_thieu', 'asc')->get();
        } catch (\Throwable $e) {
            $tiers = collect([]);
        }

        // Lấy lịch sử chat
        try {
            $chatLogs = NhatKyChat::orderBy('id', 'desc')->get();
        } catch (\Throwable $e) {
            $chatLogs = collect([]);
        }

        // Thống kê tổng quan
        $totalCars = count($cars);
        $totalDrives = $testDrives->count();
        $totalChats = $chatLogs->count();
        $totalValue = array_sum(array_column($cars, 'price'));
        $totalCustomers = $customers->count();
        $totalPoints = $customers->sum('diem_tich_luy');

        return view('quantri.dashboard', compact(
            'cars',
            'customers',
            'invoices',
            'testDrives',
            'tiers',
            'chatLogs',
            'totalCars',
            'totalDrives',
            'totalChats',
            'totalValue',
            'totalCustomers',
            'totalPoints'
        ));
    }

    public function adjustPoints(Request $request)
    {
        $custCode = $request->input('ma_kh');
        $points   = (int) $request->input('so_diem');
        $reason   = $request->input('ly_do', 'Quản trị viên điều chỉnh điểm');

        $customer = KhachHang::where('ma_kh', $custCode)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy khách hàng']);
        }

        $customer->diem_tich_luy = max(0, $customer->diem_tich_luy + $points);

        // Tự động cập nhật hạng thành viên
        $allTiers = HangThanhVien::orderBy('diem_toi_thieu', 'desc')->get();
        foreach ($allTiers as $t) {
            if ($customer->diem_tich_luy >= $t->diem_toi_thieu) {
                $customer->ma_hang = $t->ma_hang;
                break;
            }
        }
        $customer->save();

        // Ghi lịch sử điểm
        try {
            LichSuDiem::create([
                'ma_kh'    => $customer->ma_kh,
                'ma_hd'    => null,
                'so_diem'  => $points,
                'hanh_dong' => $reason,
                'ngay_tao' => now(),
            ]);
        } catch (\Throwable $e) {
            // Bỏ qua nếu bảng chưa tồn tại
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Cập nhật điểm thành công!',
            'new_points' => $customer->diem_tich_luy,
            'new_tier'  => $customer->tier ? $customer->tier->ten_hang : $customer->ma_hang,
        ]);
    }
}
