<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'hoa_don';

    protected $fillable = [
        'ma_hd',
        'ma_kh',
        'ngay_lap',
        'tong_tien_goc',
        'giam_gia_hang',
        'tong_tien_thanh_toan',
        'diem_thuong_nhan',
        'phuong_thuc_tt',
        'thoi_gian_bh',
        'trang_thai',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'ma_kh', 'ma_kh');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'ma_hd', 'ma_hd');
    }

    public static function formatInvoice($inv): array
    {
        $custName = $inv->customer->ho_ten ?? 'Khách hàng Vãng lai';
        $custPhone = $inv->customer->sdt ?? '0901234567';
        $custTier = $inv->customer->tier->ten_hang ?? 'Hạng Thành Viên VIP';
        $custTierBadge = $inv->customer->tier->mau_badge ?? 'warning';

        $carName = 'Mercedes-Maybach S 680 4MATIC';
        $carPrice = number_format($inv->tong_tien_goc, 0, ',', '.') . ' VNĐ';

        if ($inv->details && $inv->details->count() > 0) {
            $firstDetail = $inv->details->first();
            $carObj = Car::where('ma_xe', $firstDetail->ma_xe)->first();
            if ($carObj) {
                $carName = $carObj->ten_xe;
                $carPrice = number_format($firstDetail->don_gia, 0, ',', '.') . ' VNĐ';
            }
        }

        return [
            'code' => $inv->ma_hd,
            'customer_name' => $custName,
            'customer_phone' => $custPhone,
            'customer_tier' => $custTier,
            'customer_tier_badge' => $custTierBadge,
            'car_name' => $carName,
            'quantity' => 1,
            'unit_price' => $carPrice,
            'original_total' => number_format($inv->tong_tien_goc, 0, ',', '.') . ' VNĐ',
            'tier_discount' => number_format($inv->giam_gia_hang, 0, ',', '.') . ' VNĐ',
            'total_price' => number_format($inv->tong_tien_thanh_toan, 0, ',', '.') . ' VNĐ',
            'points_earned' => $inv->diem_thuong_nhan ?? 0,
            'warranty_months' => $inv->thoi_gian_bh ?? '36 Tháng',
            'invoice_date' => date('d/m/Y', strtotime($inv->ngay_lap)),
            'status' => $inv->trang_thai,
        ];
    }

    public static function getAllInvoices(): array
    {
        try {
            $dbInvoices = self::with(['customer.tier', 'details'])->orderBy('id', 'desc')->get();
            if ($dbInvoices->count() > 0) {
                return $dbInvoices->map(fn($inv) => self::formatInvoice($inv))->toArray();
            }
        } catch (\Throwable $e) {}

        return self::getDefaultInvoices();
    }

    public static function getDefaultInvoices(): array
    {
        return [
            [
                'code' => 'HD0001',
                'customer_name' => 'Nguyễn Văn A',
                'customer_phone' => '0901234567',
                'customer_tier' => 'Hạng Kim Cương (Diamond VIP)',
                'customer_tier_badge' => 'primary',
                'car_name' => 'Mercedes-Maybach S 680 4MATIC',
                'quantity' => 1,
                'unit_price' => '15,990,000,000 VNĐ',
                'original_total' => '15,990,000,000 VNĐ',
                'tier_discount' => '479,700,000 VNĐ',
                'total_price' => '15,510,300,000 VNĐ',
                'points_earned' => 1551,
                'warranty_months' => '36 Tháng',
                'invoice_date' => '16/09/2026',
                'status' => 'Đã thanh toán'
            ]
        ];
    }
}
