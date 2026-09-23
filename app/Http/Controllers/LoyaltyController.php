<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LoyaltyTier;
use App\Models\PointsHistory;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    public function index(Request $request)
    {
        $tiers = LoyaltyTier::orderBy('diem_toi_thieu', 'asc')->get();
        $query = $request->query('phone') ?? $request->query('q', '');

        $customer = null;
        $pointsHistory = [];
        $nextTier = null;
        $pointsToNextTier = 0;
        $progressPercent = 0;

        if (!empty($query)) {
            $customer = Customer::where('sdt', $query)
                ->orWhere('email', $query)
                ->orWhere('ma_kh', $query)
                ->first();

            if ($customer) {
                $pointsHistory = PointsHistory::where('ma_kh', $customer->ma_kh)
                    ->orderBy('ngay_tao', 'desc')
                    ->get();

                // Calculate progress to next tier
                $currentPoints = $customer->diem_tich_luy;
                $higherTiers = LoyaltyTier::where('diem_toi_thieu', '>', $currentPoints)
                    ->orderBy('diem_toi_thieu', 'asc')
                    ->get();

                if ($higherTiers->count() > 0) {
                    $nextTier = $higherTiers->first();
                    $pointsToNextTier = $nextTier->diem_toi_thieu - $currentPoints;
                    $currentTierMin = $customer->tier ? $customer->tier->diem_toi_thieu : 0;
                    $range = $nextTier->diem_toi_thieu - $currentTierMin;
                    $progressPercent = $range > 0 ? min(100, round((($currentPoints - $currentTierMin) / $range) * 100)) : 100;
                } else {
                    $progressPercent = 100; // Max tier (Diamond)
                }
            }
        }

        return view('loyalty.index', compact('tiers', 'customer', 'query', 'pointsHistory', 'nextTier', 'pointsToNextTier', 'progressPercent'));
    }

    public function check(Request $request)
    {
        $phone = $request->input('phone') ?? $request->query('phone');
        if (empty($phone)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập số điện thoại']);
        }

        $customer = Customer::where('sdt', $phone)
            ->orWhere('email', $phone)
            ->orWhere('ma_kh', $phone)
            ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin thành viên với SĐT này'
            ]);
        }

        $tier = $customer->tier;

        return response()->json([
            'success' => true,
            'customer' => [
                'name' => $customer->ho_ten,
                'code' => $customer->ma_kh,
                'phone' => $customer->sdt,
                'points' => $customer->diem_tich_luy,
                'tier_code' => $customer->ma_hang,
                'tier_name' => $tier ? $tier->ten_hang : 'Hạng Bạc',
                'discount_percent' => $tier ? (float)$tier->ti_le_chiet_khau : 0,
                'badge' => $tier ? $tier->mau_badge : 'secondary',
            ]
        ]);
    }
}
