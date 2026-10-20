<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\Xe;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    public function index(Request $request)
    {
        return view('hoadon');
    }

    /**
     * Tra cứu hóa đơn thực tế từ CSDL theo Mã hóa đơn hoặc Số điện thoại
     */
    public function lookup(Request $request)
    {
        $rawQuery = trim($request->input('query', ''));
        if (empty($rawQuery)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập Mã Hóa Đơn hoặc Số Điện Thoại để tra cứu.',
            ], 400);
        }

        // Tìm hóa đơn theo mã HĐ hoặc SĐT khách hàng
        $invoice = HoaDon::with(['customer.tier'])
            ->where(function ($q) use ($rawQuery) {
                $q->where('ma_hd', $rawQuery)
                    ->orWhere('ma_hd', 'LIKE', '%'.$rawQuery.'%')
                    ->orWhereHas('customer', function ($cq) use ($rawQuery) {
                        $cq->where('sdt', $rawQuery)
                            ->orWhere('sdt', 'LIKE', '%'.$rawQuery.'%');
                    });
            })
            ->latest('id')
            ->first();

        if (! $invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy hóa đơn nào khớp với thông tin: '.htmlspecialchars($rawQuery),
            ]);
        }

        $customer = $invoice->customer;
        $custName = $customer ? $customer->ho_ten : 'Khách hàng';
        $custPhone = $customer ? $customer->sdt : 'N/A';
        $tierName = ($customer && $customer->tier) ? $customer->tier->ten_hang : 'Hội Viên PrimeLux Club';
        $tierBadge = ($customer && $customer->tier) ? ($customer->tier->mau_badge ?? 'warning') : 'warning';

        // Lấy tên xe từ danh mục
        $carName = 'Mercedes-Maybach S 680 4MATIC (VIP Edition)';
        $defaultCar = Xe::first();
        if ($defaultCar) {
            $carName = $defaultCar->ten_xe;
        }

        $isPendingDownPayment = str_contains((string) $invoice->trang_thai, 'Chờ thanh toán') || str_contains((string) $invoice->trang_thai, 'Chờ duyệt');
        $downPaymentAmount = round($invoice->tong_tien_thanh_toan * 0.3);

        return response()->json([
            'success' => true,
            'invoice' => [
                'code' => $invoice->ma_hd,
                'date' => date('d/m/Y', strtotime($invoice->ngay_lap ?? $invoice->created_at)),
                'customer' => $custName,
                'phone' => $custPhone,
                'tier' => $tierName,
                'tierBadge' => $tierBadge,
                'car' => $carName,
                'price' => number_format($invoice->tong_tien_goc, 0, ',', '.').' VNĐ',
                'discount' => number_format($invoice->giam_gia_hang, 0, ',', '.').' VNĐ',
                'total' => number_format($invoice->tong_tien_thanh_toan, 0, ',', '.').' VNĐ',
                'points' => '+'.number_format($invoice->diem_thuong_nhan ?? 0, 0, ',', '.').' Điểm',
                'statusText' => $invoice->trang_thai ?? 'Đã xác nhận',
                'statusBadge' => $isPendingDownPayment ? 'warning text-dark' : 'success',
                'hasDownPaymentWaiting' => $isPendingDownPayment,
                'downPaymentAmount' => number_format($downPaymentAmount, 0, ',', '.').' VNĐ',
                'warranty' => $invoice->thoi_gian_bh ?? '36 Tháng Chính Hãng',
            ],
        ]);
    }
}
