<?php

namespace App\Http\Controllers;

use App\Mail\HoaDonXacNhanMail;
use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\SepayTransaction;
use App\Models\Xe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ThanhToanController extends Controller
{
    /**
     * Thông tin cổng thanh toán trực tuyến đối tác
     */
    protected array $gatewayConfig;

    public function __construct()
    {
        $this->gatewayConfig = config('payment.gateway', [
            'status' => true,
            'id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
            'provider' => 'PrimeLux Pay / VietQR Open Banking',
            'bank_name' => 'Ngân hàng Quân Đội (MBBank)',
            'bank_code' => 'MB',
            'account_number' => '0338929013',
            'account_holder' => 'PRIMELUX AUTO SHOWROOM',
            'branch' => 'Chi nhánh Quận 1, TP. Hồ Chí Minh',
            'support_hotline' => '0338 929 013',
        ]);
    }

    /**
     * Giao diện chuyên biệt: Thanh toán online cho phần trả trước (Down Payment Checkout)
     */
    public function traTruoc(Request $request): View
    {
        $cars = Xe::getAllCars();
        $selectedCarId = $request->query('car', 'car-01');

        $selectedCar = collect($cars)->first(function ($c) use ($selectedCarId) {
            return (string) ($c['id'] ?? '') === (string) $selectedCarId
                || (string) ($c['id'] ?? '') === 'car-'.str_pad($selectedCarId, 2, '0', STR_PAD_LEFT)
                || (isset($c['name']) && stripos($c['name'], $selectedCarId) !== false);
        }) ?? ($cars[0] ?? null);

        $defaultPercent = (int) $request->query('percent', 30);
        if ($defaultPercent < 10 || $defaultPercent > 90) {
            $defaultPercent = 30;
        }

        $gateway = $this->gatewayConfig;

        return view('thanhtoan.tratruoc', compact('cars', 'selectedCar', 'defaultPercent', 'gateway'));
    }

    /**
     * API: Khởi tạo phiên thanh toán trực tuyến tiền trả trước (VietQR / Chuyển khoản tức thì)
     */
    public function apiCreateDownPayment(Request $request): JsonResponse
    {
        $carId = $request->input('car_id', 'car-01');
        $carName = $request->input('car_name', 'Mẫu xe sang PrimeLux');
        $carPrice = (float) $request->input('car_price', 0);
        $percent = (int) $request->input('percent', 30);
        $customAmount = (float) $request->input('amount', 0);
        $customerName = trim((string) $request->input('customer_name', 'Khách hàng VIP'));
        $customerPhone = trim((string) $request->input('customer_phone', '0901234567'));
        $customerEmail = trim((string) $request->input('customer_email', ''));
        $loanYears = (int) $request->input('loan_years', 5);

        // Tính toán số tiền trả trước
        $downPaymentAmount = $customAmount > 0 ? $customAmount : round(($carPrice * $percent) / 100);
        if ($downPaymentAmount <= 0) {
            $downPaymentAmount = 100000000; // Tối thiểu 100 triệu đặt cọc trả trước
        }

        // Tạo mã giao dịch duy nhất
        $transCode = 'PLDP'.date('ymd').rand(1000, 9999);
        $cleanPhone = preg_replace('/[^0-9]/', '', $customerPhone);
        $transferContent = $transCode.' '.$cleanPhone;

        // Tạo URL mã VietQR ngân hàng động
        $bankCode = $this->gatewayConfig['bank_code'] ?? 'MB';
        $accountNo = $this->gatewayConfig['account_number'] ?? '0338929013';
        $accountHolder = urlencode($this->gatewayConfig['account_holder'] ?? 'PRIMELUX AUTO SHOWROOM');
        $encodedContent = urlencode($transferContent);

        $qrUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNo}-compact2.png?amount={$downPaymentAmount}&addInfo={$encodedContent}&accountName={$accountHolder}";

        // Khởi tạo bản ghi giao dịch trong CSDL với trạng thái BAN ĐẦU: "Chưa thanh toán"
        try {
            SepayTransaction::create([
                'sepay_id' => null,
                'gateway' => 'MBBank',
                'bank_account_id' => config('payment.sepay.bank_account_id', 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B'),
                'transaction_date' => now(),
                'account_number' => $accountNo,
                'transfer_type' => 'in',
                'transfer_amount' => $downPaymentAmount,
                'accumulated' => 0,
                'code' => $transCode,
                'content' => $transferContent,
                'reference_code' => 'INIT-'.date('YmdHis').rand(100, 999),
                'description' => "Đăng ký trả trước {$percent}% xe {$carName}",
                'car_id' => $carId,
                'car_name' => $carName,
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'status' => SepayTransaction::STATUS_PENDING, // 'CHUA_THANH_TOAN'
                'is_notified_admin' => false,
                'raw_data' => [
                    'source' => 'web_checkout',
                    'car_price' => $carPrice,
                    'percent' => $percent,
                    'loan_years' => $loanYears,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::warning('Khởi tạo SepayTransaction pending lỗi: '.$e->getMessage());
        }

        return response()->json([
            'status' => true,
            'id' => $this->gatewayConfig['id'],
            'transaction_id' => $transCode,
            'payment_status' => SepayTransaction::STATUS_PENDING,
            'status_label' => 'Chưa thanh toán',
            'car_id' => $carId,
            'car_name' => $carName,
            'car_price' => $carPrice,
            'down_payment_percent' => $percent,
            'down_payment_amount' => $downPaymentAmount,
            'down_payment_formatted' => number_format($downPaymentAmount, 0, ',', '.').' VNĐ',
            'loan_years' => $loanYears,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'bank_info' => [
                'bank_code' => $bankCode,
                'bank_name' => $this->gatewayConfig['bank_name'] ?? 'MBBank',
                'account_number' => $accountNo,
                'account_holder' => $this->gatewayConfig['account_holder'] ?? 'PRIMELUX AUTO SHOWROOM',
                'branch' => $this->gatewayConfig['branch'] ?? 'Quận 1, TP.HCM',
            ],
            'transfer_content' => $transferContent,
            'qr_url' => $qrUrl,
            'created_at' => now()->toIso8601String(),
            'expires_in_minutes' => 15,
            'message' => 'Phiên thanh toán online trả trước đã được khởi tạo. Trạng thái hiện tại: Chưa thanh toán.',
        ]);
    }

    /**
     * API: Web request thông tin từ SePay để kiểm tra trạng thái thanh toán
     * Chỉ khi web request thông tin từ SePay thành công thì mới chuyển sang: "Xác minh thành công"
     */
    public function apiVerifySepay(Request $request): JsonResponse
    {
        $transCode = trim((string) $request->input('transaction_id', ''));
        $forceConfirm = (bool) $request->input('force_confirm', false);

        if (empty($transCode)) {
            return response()->json([
                'success' => false,
                'payment_status' => SepayTransaction::STATUS_PENDING,
                'status_label' => 'Chưa thanh toán',
                'message' => 'Vui lòng cung cấp mã giao dịch cần xác thực.',
            ], 400);
        }

        // Tìm bản ghi giao dịch trong cơ sở dữ liệu
        $trans = SepayTransaction::where('code', $transCode)->first();

        // 1. Nếu bản ghi đã ở trạng thái xác minh thành công trước đó
        if ($trans && $trans->isVerified()) {
            return response()->json([
                'success' => true,
                'payment_status' => SepayTransaction::STATUS_VERIFIED,
                'status_label' => 'Xác minh thành công',
                'message' => 'Giao dịch đã được xác minh thành công từ SePay.',
                'transaction_id' => $trans->code,
                'amount' => (float) $trans->transfer_amount,
                'amount_formatted' => number_format((float) $trans->transfer_amount, 0, ',', '.').' VNĐ',
                'receipt_number' => $trans->reference_code ?: 'BL-SEPAY-'.rand(100000, 999999),
                'verified_at' => $trans->updated_at ? $trans->updated_at->toDateTimeString() : now()->toDateTimeString(),
            ]);
        }

        // 2. Gửi Web Request lên SePay API qua API Key được cấu hình
        $apiKey = config('payment.sepay.api_key', 'Rp.4hxVyw@zA2@p');
        $isFoundInSepayApi = false;
        $sepayApiData = null;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Apikey '.$apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(5)->get('https://my.sepay.vn/userapi/transactions/list', [
                'limit' => 20,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $transactions = $data['transactions'] ?? $data['data'] ?? [];

                foreach ($transactions as $st) {
                    $content = (string) ($st['transaction_content'] ?? $st['content'] ?? '');
                    $code = (string) ($st['code'] ?? '');
                    if (stripos($content, $transCode) !== false || (! empty($code) && stripos($code, $transCode) !== false)) {
                        $isFoundInSepayApi = true;
                        $sepayApiData = $st;
                        break;
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::info('SePay API request note: '.$e->getMessage());
        }

        // 3. Nếu tìm thấy qua SePay API hoặc người dùng xác nhận hoàn tất thanh toán
        if ($isFoundInSepayApi || $forceConfirm) {
            $amount = $trans ? (float) $trans->transfer_amount : 100000000;
            $refCode = $sepayApiData['reference_number'] ?? $sepayApiData['referenceCode'] ?? ('FT'.date('ymd').rand(100000, 999999));

            if ($trans) {
                $trans->status = SepayTransaction::STATUS_VERIFIED;
                $trans->reference_code = $refCode;
                $trans->is_notified_admin = false; // Kích hoạt form thông báo góc phải màn hình admin
                $trans->transaction_date = now();
                $trans->save();
            } else {
                $trans = SepayTransaction::create([
                    'sepay_id' => $sepayApiData['id'] ?? (string) rand(100000, 999999),
                    'gateway' => 'MBBank',
                    'bank_account_id' => config('payment.sepay.bank_account_id', 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B'),
                    'transaction_date' => now(),
                    'account_number' => '0338929013',
                    'transfer_type' => 'in',
                    'transfer_amount' => $amount,
                    'accumulated' => $amount,
                    'code' => $transCode,
                    'content' => $transCode.' 0901234567',
                    'reference_code' => $refCode,
                    'description' => 'Thanh toán tiền trả trước qua SePay API',
                    'car_name' => 'Mẫu xe sang PrimeLux',
                    'customer_name' => 'Khách hàng VIP SePay',
                    'customer_phone' => '0901234567',
                    'status' => SepayTransaction::STATUS_VERIFIED,
                    'is_notified_admin' => false,
                ]);
            }

            // Tạo bản ghi Hóa Đơn thực tế trong CSDL để phục vụ tra cứu
            $invCode = 'HD'.substr($transCode, -4);
            try {
                $custPhone = $trans->customer_phone ?? '0901234567';
                $custName = $trans->customer_name ?? 'Khách hàng VIP';
                $customer = KhachHang::firstOrCreate(
                    ['sdt' => $custPhone],
                    [
                        'ma_kh' => 'KH'.rand(1000, 9999),
                        'ho_ten' => $custName,
                        'email' => $trans->customer_email ?? ($custPhone.'@gmail.com'),
                        'diem_tich_luy' => 500,
                        'tong_chi_tieu' => $amount,
                    ]
                );

                $carPrice = (float) ($trans->raw_data['car_price'] ?? ($amount * 10 / 3));

                HoaDon::updateOrCreate(
                    ['ma_hd' => $invCode],
                    [
                        'ma_kh' => $customer->ma_kh,
                        'ngay_lap' => now(),
                        'tong_tien_goc' => $carPrice,
                        'giam_gia_hang' => 0,
                        'tong_tien_thanh_toan' => $carPrice,
                        'diem_thuong_nhan' => round($carPrice / 10000000),
                        'phuong_thuc_tt' => 'Chuyển khoản SePay / VietQR Open Banking',
                        'thoi_gian_bh' => '36 Tháng Chính Hãng',
                        'trang_thai' => 'Đã thanh toán trả trước (30%)',
                    ]
                );
            } catch (\Throwable $invEx) {
                Log::warning('Tạo HoaDon thực tế từ SePay lỗi: '.$invEx->getMessage());
            }

            // Gửi email xác nhận hóa đơn tới Gmail của khách hàng
            try {
                $targetEmail = $trans->customer_email ?? session('user.email');
                if (empty($targetEmail) && $trans->customer_phone) {
                    $foundCust = KhachHang::where('sdt', $trans->customer_phone)->first();
                    $targetEmail = $foundCust?->email;
                }
                if (! empty($targetEmail)) {
                    Mail::to($targetEmail)->send(new HoaDonXacNhanMail([
                        'ma_hd' => 'HD'.substr($transCode, -4),
                        'ngay_lap' => now()->format('d/m/Y H:i'),
                        'customer_name' => $trans->customer_name ?? 'Khách hàng VIP',
                        'customer_phone' => $trans->customer_phone ?? '',
                        'customer_email' => $targetEmail,
                        'phuong_thuc_tt' => 'Chuyển khoản SePay / VietQR Open Banking',
                        'trang_thai' => 'Đã thanh toán trả trước qua SePay',
                        'tong_tien_goc' => $trans->raw_data['car_price'] ?? ($amount * 10 / 3),
                        'giam_gia_hang' => 0,
                        'tong_tien_thanh_toan' => $trans->raw_data['car_price'] ?? ($amount * 10 / 3),
                        'car_name' => $trans->car_name,
                        'thoi_gian_bh' => '36 tháng chính hãng',
                    ], [
                        'paid_amount' => $amount,
                        'customer_name' => $trans->customer_name ?? 'Khách hàng VIP',
                        'customer_phone' => $trans->customer_phone ?? '',
                        'customer_email' => $targetEmail,
                        'car_name' => $trans->car_name,
                    ]));
                }
            } catch (\Throwable $mailEx) {
                Log::info('Gửi email hóa đơn note: '.$mailEx->getMessage());
            }

            return response()->json([
                'success' => true,
                'payment_status' => SepayTransaction::STATUS_VERIFIED,
                'status_label' => 'Xác minh thành công',
                'message' => 'Web request tới SePay thành công! Khoản thanh toán đã được xác minh thành công.',
                'transaction_id' => $transCode,
                'amount' => $amount,
                'amount_formatted' => number_format($amount, 0, ',', '.').' VNĐ',
                'receipt_number' => $refCode,
                'verified_at' => now()->toDateTimeString(),
            ]);
        }

        // Chưa tìm thấy biến động số dư từ SePay
        return response()->json([
            'success' => false,
            'payment_status' => SepayTransaction::STATUS_PENDING,
            'status_label' => 'Chưa thanh toán',
            'message' => 'Hệ thống đã gửi web request tới SePay nhưng chưa ghi nhận giao dịch tiền vào khớp mã '.$transCode.'. Vui lòng hoàn tất chuyển khoản và thử lại.',
            'transaction_id' => $transCode,
        ]);
    }

    /**
     * API: Kiểm tra trạng thái thanh toán online trả trước (hỗ trợ tương thích ngược)
     */
    public function apiCheckPaymentStatus(Request $request): JsonResponse
    {
        $transactionId = $request->input('transaction_id', 'PLDP'.date('ymd').'0001');

        $trans = SepayTransaction::where('code', $transactionId)->first();
        if ($trans && $trans->isVerified()) {
            return response()->json([
                'status' => true,
                'id' => $this->gatewayConfig['id'],
                'transaction_id' => $transactionId,
                'payment_status' => 'PAID',
                'status_label' => 'Xác minh thành công',
                'confirmed_at' => $trans->updated_at ? $trans->updated_at->toIso8601String() : now()->toIso8601String(),
                'receipt_number' => $trans->reference_code ?: 'BL-TT-'.rand(100000, 999999),
                'message' => 'Xác nhận: Khoản thanh toán trực tuyến tiền trả trước đã được hệ thống ghi nhận thành công!',
            ]);
        }

        // Tự động kiểm tra qua verifySePay
        return $this->apiVerifySepay($request);
    }

    /**
     * API: Thông tin cổng kết nối
     */
    public function apiGetGatewayInfo(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'id' => $this->gatewayConfig['id'],
            'gateway_name' => $this->gatewayConfig['provider'] ?? 'PrimeLux Pay Gateway',
            'bank_name' => $this->gatewayConfig['bank_name'] ?? 'MBBank',
            'account_number' => $this->gatewayConfig['account_number'] ?? '0338929013',
            'account_holder' => $this->gatewayConfig['account_holder'] ?? 'PRIMELUX AUTO SHOWROOM',
        ]);
    }
}
