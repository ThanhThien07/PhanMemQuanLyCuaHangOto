<?php

namespace App\Services;

use App\Models\ThongBaoDaKenh;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * Gửi thông báo xác nhận lịch lái thử qua Zalo ZNS & SMS
     */
    public static function sendTestDriveConfirmation(array $data): ThongBaoDaKenh
    {
        $code = 'TB-ZNS-'.strtoupper(Str::random(5));
        $customerName = $data['ho_ten'] ?? 'Quý khách';
        $carName = $data['ten_xe'] ?? 'Xe sang PrimeLux';
        $time = $data['thoi_gian'] ?? now()->format('H:i d/m/Y');
        $showroom = $data['showroom'] ?? 'PrimeLux Auto Sài Gòn Flagship';

        $title = "Xác nhận lịch lái thử VIP: {$carName}";
        $content = "Kính gửi Quý khách {$customerName}, Showroom PrimeLux Auto đã tiếp nhận và xác nhận lịch trải nghiệm mẫu xe {$carName} vào lúc {$time} tại {$showroom}. Tư vấn viên chuyên trách sẽ đón tiếp Quý khách.";

        return ThongBaoDaKenh::create([
            'ma_thong_bao' => $code,
            'loai_kenh' => 'Zalo ZNS',
            'muc_dich' => 'Xác nhận Lịch Lái Thử VIP',
            'nguoi_nhan' => $customerName,
            'sdt_email' => $data['sdt'] ?? '',
            'tieu_de' => $title,
            'noi_dung' => $content,
            'trang_thai' => 'Đã gửi thành công',
            'thoi_gian_gui' => now(),
        ]);
    }

    /**
     * Gửi thông báo thăng hạng điểm thưởng VIP
     */
    public static function sendVipTierUpgrade(string $name, string $phone, string $tierName, int $points): ThongBaoDaKenh
    {
        $code = 'TB-SMS-'.strtoupper(Str::random(5));
        $title = "Chúc mừng thăng hạng {$tierName} PrimeLux Club";
        $content = "PRIMELUX AUTO: Chúc mừng Quý khách {$name} đã tích lũy {$points} điểm và được thăng hạng {$tierName}. Quý khách được hưởng toàn bộ đặc quyền chiết khấu trực tiếp và hỗ trợ kỹ thuật VIP 24/7.";

        return ThongBaoDaKenh::create([
            'ma_thong_bao' => $code,
            'loai_kenh' => 'SMS Brandname',
            'muc_dich' => 'Thông báo Thăng hạng VIP',
            'nguoi_nhan' => $name,
            'sdt_email' => $phone,
            'tieu_de' => $title,
            'noi_dung' => $content,
            'trang_thai' => 'Đã gửi thành công',
            'thoi_gian_gui' => now(),
        ]);
    }

    /**
     * Gửi biên lai đặt cọc / thanh toán qua Email
     */
    public static function sendPaymentReceipt(string $name, string $email, string $carName, float $amount, string $refCode): ThongBaoDaKenh
    {
        $code = 'TB-EML-'.strtoupper(Str::random(5));
        $formattedAmount = number_format($amount, 0, ',', '.').' VNĐ';
        $title = "Biên Lai Xác Nhận Thanh Toán Trực Tuyến PrimeLux Auto #{$refCode}";
        $content = "Kính gửi Quý khách {$name}, Hệ thống PrimeLux Auto xác nhận đã nhận thanh toán số tiền {$formattedAmount} cho mẫu xe {$carName} (Mã GD: {$refCode}). Mẫu xe đã được bảo lưu độc quyền trong 72 giờ.";

        return ThongBaoDaKenh::create([
            'ma_thong_bao' => $code,
            'loai_kenh' => 'Email',
            'muc_dich' => 'Hóa đơn Điện tử & Biên lai Cọc xe',
            'nguoi_nhan' => $name,
            'sdt_email' => $email ?: 'khachhang@primelux.vn',
            'tieu_de' => $title,
            'noi_dung' => $content,
            'trang_thai' => 'Đã gửi thành công',
            'thoi_gian_gui' => now(),
        ]);
    }
}
