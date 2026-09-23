<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\HangThanhVien;
use App\Models\LichSuDiem;
use Illuminate\Http\Request;

class TichDiemController extends Controller
{
    public function index(Request $request)
    {
        $tiers = HangThanhVien::orderBy('diem_toi_thieu', 'asc')->get();
        $query = $request->query('phone') ?? $request->query('q', '');

        $customer = null;
        $pointsHistory = [];
        $nextTier = null;
        $pointsToNextTier = 0;
        $progressPercent = 0;

        if (!empty($query)) {
            $customer = KhachHang::where('sdt', $query)
                ->orWhere('email', $query)
                ->orWhere('ma_kh', $query)
                ->first();

            if ($customer) {
                $pointsHistory = LichSuDiem::where('ma_kh', $customer->ma_kh)
                    ->orderBy('ngay_tao', 'desc')
                    ->get();

                $currentPoints = $customer->diem_tich_luy;
                $higherTiers = HangThanhVien::where('diem_toi_thieu', '>', $currentPoints)
                    ->orderBy('diem_toi_thieu', 'asc')
                    ->get();

                if ($higherTiers->count() > 0) {
                    $nextTier = $higherTiers->first();
                    $pointsToNextTier = $nextTier->diem_toi_thieu - $currentPoints;
                    $currentTierMin = $customer->tier ? $customer->tier->diem_toi_thieu : 0;
                    $range = $nextTier->diem_toi_thieu - $currentTierMin;
                    $progressPercent = $range > 0 ? min(100, round((($currentPoints - $currentTierMin) / $range) * 100)) : 100;
                } else {
                    $progressPercent = 100;
                }
            }
        }

        return view('tichdiem.index', compact('tiers', 'customer', 'query', 'pointsHistory', 'nextTier', 'pointsToNextTier', 'progressPercent'));
    }

    public function check(Request $request)
    {
        $phone = $request->input('phone') ?? $request->query('phone');
        if (empty($phone)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập số điện thoại']);
        }

        $customer = KhachHang::with('tier')->where('sdt', $phone)->first();
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin khách hàng với số điện thoại này.'
            ]);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'name' => $customer->ho_ten,
                'phone' => $customer->sdt,
                'tier' => $customer->tier->ten_hang ?? 'Bạc',
                'discount' => $customer->tier->ti_le_chiet_khau ?? 0,
                'points' => $customer->diem_tich_luy,
                'badge' => $customer->tier->mau_badge ?? 'secondary'
            ]
        ]);
    }
}
