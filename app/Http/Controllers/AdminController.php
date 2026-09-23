<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ChatLog;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\LoyaltyTier;
use App\Models\PointsHistory;
use App\Models\TestDrive;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $cars = Car::getAllCars();
        $testDrives = TestDrive::getAllBookings();
        $invoices = Invoice::getAllInvoices();
        $chatLogs = ChatLog::orderBy('id', 'desc')->get();

        $customers = Customer::with('tier')->get();
        if ($customers->count() === 0) {
            // Fallback default customers if not yet seeded
            $customers = collect([
                (object)[
                    'ma_kh' => 'KH001',
                    'ho_ten' => 'Nguyễn Văn A',
                    'sdt' => '0901234567',
                    'email' => 'khachhang@gmail.com',
                    'diem_tich_luy' => 12500,
                    'tong_chi_tieu' => 31980000000,
                    'tier' => (object)['ten_hang' => 'Hạng Kim Cương (Diamond VIP)', 'mau_badge' => 'primary', 'ti_le_chiet_khau' => 3.0]
                ],
                (object)[
                    'ma_kh' => 'KH002',
                    'ho_ten' => 'Trần Thị Mai',
                    'sdt' => '0912987654',
                    'email' => 'mai.tran@gmail.com',
                    'diem_tich_luy' => 2800,
                    'tong_chi_tieu' => 9550000000,
                    'tier' => (object)['ten_hang' => 'Hạng Vàng (Gold)', 'mau_badge' => 'warning', 'ti_le_chiet_khau' => 1.0]
                ]
            ]);
        }

        $tiers = LoyaltyTier::all();
        if ($tiers->count() === 0) {
            $tiers = collect([
                (object)['ma_hang' => 'SILVER', 'ten_hang' => 'Hạng Bạc', 'diem_toi_thieu' => 0, 'ti_le_chiet_khau' => 0, 'dac_quyen' => 'Tích 1% điểm, giảm 5% phụ kiện', 'mau_badge' => 'secondary'],
                (object)['ma_hang' => 'GOLD', 'ten_hang' => 'Hạng Vàng', 'diem_toi_thieu' => 1000, 'ti_le_chiet_khau' => 1, 'dac_quyen' => 'Giảm 1% giá xe, tặng 1 năm bảo dưỡng', 'mau_badge' => 'warning'],
                (object)['ma_hang' => 'PLATINUM', 'ten_hang' => 'Hạng Bạch Kim', 'diem_toi_thieu' => 5000, 'ti_le_chiet_khau' => 2, 'dac_quyen' => 'Giảm 2% giá xe, tặng bảo hiểm thân vỏ', 'mau_badge' => 'info'],
                (object)['ma_hang' => 'DIAMOND', 'ten_hang' => 'Hạng Kim Cương', 'diem_toi_thieu' => 10000, 'ti_le_chiet_khau' => 3, 'dac_quyen' => 'Giảm 3% mọi siêu xe, phủ Ceramic, VIP quốc tế', 'mau_badge' => 'primary']
            ]);
        }

        $totalCars = count($cars);
        $totalDrives = count($testDrives);
        $totalChats = $chatLogs->count();
        $totalValue = array_sum(array_column($cars, 'price'));
        $totalCustomers = count($customers);
        $totalPoints = $customers->sum('diem_tich_luy');

        return view('admin.dashboard', compact(
            'cars',
            'testDrives',
            'invoices',
            'customers',
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
        $points = (int)$request->input('so_diem');
        $reason = $request->input('ly_do', 'Quản trị viên điều chỉnh điểm');

        $customer = Customer::where('ma_kh', $custCode)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy khách hàng']);
        }

        $customer->diem_tich_luy = max(0, $customer->diem_tich_luy + $points);

        // Auto update tier
        $allTiers = LoyaltyTier::orderBy('diem_toi_thieu', 'desc')->get();
        foreach ($allTiers as $t) {
            if ($customer->diem_tich_luy >= $t->diem_toi_thieu) {
                $customer->ma_hang = $t->ma_hang;
                break;
            }
        }
        $customer->save();

        PointsHistory::create([
            'ma_kh' => $customer->ma_kh,
            'ma_hd' => null,
            'so_diem' => $points,
            'hanh_dong' => $reason,
            'ngay_tao' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật điểm thành công!',
            'new_points' => $customer->diem_tich_luy,
            'new_tier' => $customer->tier ? $customer->tier->ten_hang : $customer->ma_hang
        ]);
    }
}
