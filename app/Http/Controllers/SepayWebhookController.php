<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\SepayTransaction;
use App\Models\Xe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SepayWebhookController extends Controller
{
    /**
     * Tiếp nhận Webhook từ SePay khi có biến động số dư tiền vào
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        // Ghi log để tiện tra cứu và debug
        Log::info('SePay Webhook Received:', $request->all());

        // Lấy dữ liệu payload từ SePay (hỗ trợ cả các biến thể field của SePay)
        $sepayId = (string) ($request->input('id') ?? $request->input('transaction_id') ?? '');
        $gateway = (string) ($request->input('gateway') ?? 'MBBank');
        $accountNumber = (string) ($request->input('accountNumber') ?? $request->input('account_number') ?? '0338929013');
        $subAccount = $request->input('subAccount') ?? $request->input('sub_account');
        $transferType = (string) ($request->input('transferType') ?? $request->input('transfer_type') ?? 'in');

        // Số tiền giao dịch
        $amount = (float) ($request->input('transferAmount') ?? $request->input('amountIn') ?? $request->input('amount') ?? 0);
        $accumulated = (float) ($request->input('accumulated') ?? 0);

        // Nội dung và mã đơn
        $content = (string) ($request->input('content') ?? $request->input('transactionContent') ?? $request->input('description') ?? '');
        $code = (string) ($request->input('code') ?? '');
        $referenceCode = (string) ($request->input('referenceCode') ?? $request->input('reference_code') ?? '');
        $description = (string) ($request->input('description') ?? 'Chuyển khoản SePay');
        $transactionDate = $request->input('transactionDate') ?? now()->toDateTimeString();

        // Tự động phân tích mã đơn trả trước dạng PLDP... nếu code chưa có
        if (empty($code) && ! empty($content)) {
            if (preg_match('/(PLDP[A-Za-z0-9]+)/i', $content, $matches)) {
                $code = strtoupper($matches[1]);
            } elseif (preg_match('/(HD\d+)/i', $content, $matches)) {
                $code = strtoupper($matches[1]);
            }
        }

        // Tìm thông tin xe và khách hàng liên quan nếu có
        $carId = null;
        $carName = null;
        $customerName = null;
        $customerPhone = null;
        $status = 'MATCHED';

        // Trích xuất SĐT từ nội dung nếu có
        if (preg_match('/(0[3|5|7|8|9]\d{8})/i', $content, $phoneMatches)) {
            $customerPhone = $phoneMatches[1];
        }

        // Khớp với đơn hoặc xe tương ứng
        if (! empty($code)) {
            if (str_starts_with(strtoupper($code), 'HD')) {
                try {
                    $invoice = HoaDon::where('ma_hd', $code)->first();
                    if ($invoice) {
                        $invoice->trang_thai = 'Đã thanh toán trả trước (SePay)';
                        $invoice->save();
                    }
                } catch (\Throwable $e) {
                }
            }

            // Gán tên xe theo mã mẫu xe nếu có trong mã giao dịch
            $cars = Xe::getAllCars();
            foreach ($cars as $c) {
                if (stripos($content, $c['id']) !== false || stripos($code, $c['id']) !== false) {
                    $carId = $c['id'];
                    $carName = $c['name'];
                    break;
                }
            }
        }

        // Lưu vào bảng sepay_transactions
        try {
            $transaction = SepayTransaction::create([
                'sepay_id' => $sepayId ?: (string) rand(100000, 999999),
                'gateway' => $gateway,
                'bank_account_id' => config('payment.sepay.bank_account_id', 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B'),
                'transaction_date' => $transactionDate,
                'account_number' => $accountNumber,
                'sub_account' => $subAccount,
                'transfer_type' => $transferType,
                'transfer_amount' => $amount,
                'accumulated' => $accumulated,
                'code' => $code ?: ('PLDP'.date('ymd').rand(1000, 9999)),
                'content' => $content,
                'reference_code' => $referenceCode ?: ('FT'.date('ymd').rand(100000, 999999)),
                'description' => $description,
                'car_id' => $carId,
                'car_name' => $carName ?: 'Mẫu xe sang PrimeLux',
                'customer_name' => $customerName ?: 'Khách hàng thanh toán SePay',
                'customer_phone' => $customerPhone ?: '0901234567',
                'status' => $status,
                'raw_data' => $request->all(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'SePay Webhook processed and saved successfully.',
                'transaction_id' => $transaction->id,
                'code' => $transaction->code,
                'amount' => $transaction->transfer_amount,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('SePay Webhook Error: '.$e->getMessage());

            // Vẫn trả về success: true để SePay không retry nếu chỉ do lỗi duplicate hoặc format DB
            return response()->json([
                'success' => true,
                'message' => 'Acknowledged with note: '.$e->getMessage(),
            ], 200);
        }
    }

    /**
     * Bắn Webhook giả lập để Quản trị viên kiểm tra trực tiếp trên Admin
     */
    public function simulateWebhook(Request $request): JsonResponse
    {
        $cars = Xe::getAllCars();
        $randomCar = $cars[array_rand($cars)];

        $amount = (float) ($request->input('amount') ?: round($randomCar['price'] * 0.3));
        $code = 'PLDP'.date('ymd').rand(1000, 9999);
        $phone = $request->input('phone') ?: '0988776655';
        $content = "{$code} {$phone} ".strtoupper($randomCar['id']);

        $simulatedPayload = [
            'id' => rand(100000, 999999),
            'gateway' => 'MBBank',
            'transactionDate' => now()->toDateTimeString(),
            'accountNumber' => '0338929013',
            'subAccount' => null,
            'code' => $code,
            'content' => $content,
            'transferType' => 'in',
            'description' => 'Thanh toán tiền trả trước '.$randomCar['name'],
            'transferAmount' => $amount,
            'referenceCode' => 'MB'.date('YmdHis').rand(100, 999),
            'accumulated' => $amount,
        ];

        // Tạo transaction
        $trans = SepayTransaction::create([
            'sepay_id' => (string) $simulatedPayload['id'],
            'gateway' => $simulatedPayload['gateway'],
            'bank_account_id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
            'transaction_date' => $simulatedPayload['transactionDate'],
            'account_number' => $simulatedPayload['accountNumber'],
            'transfer_type' => 'in',
            'transfer_amount' => $amount,
            'accumulated' => $amount,
            'code' => $code,
            'content' => $content,
            'reference_code' => $simulatedPayload['referenceCode'],
            'description' => $simulatedPayload['description'],
            'car_id' => $randomCar['id'],
            'car_name' => $randomCar['name'],
            'customer_name' => $request->input('customer_name') ?: 'Khách Hàng VIP (Test SePay)',
            'customer_phone' => $phone,
            'status' => SepayTransaction::STATUS_VERIFIED,
            'is_notified_admin' => false,
            'raw_data' => $simulatedPayload,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi thành công Webhook SePay giả lập! Thông báo popup đã được kích hoạt cho Admin.',
            'transaction' => $trans,
        ]);
    }

    /**
     * API: Lấy thông tin giao dịch vừa được xác minh thành công để hiện Popup thông báo nhỏ góc phải Admin
     */
    public function getLatestVerifiedForAdmin(Request $request): JsonResponse
    {
        // Tìm giao dịch mới nhất có status Xác minh thành công / MATCHED mà chưa hiển thị thông báo
        $unnotified = SepayTransaction::where(function ($q) {
            $q->where('status', SepayTransaction::STATUS_VERIFIED)
                ->orWhere('status', 'MATCHED')
                ->orWhere('status', 'SUCCESS')
                ->orWhere('status', 'PAID');
        })
            ->where('is_notified_admin', false)
            ->orderBy('id', 'desc')
            ->first();

        if ($unnotified) {
            return response()->json([
                'has_new' => true,
                'transaction' => [
                    'id' => $unnotified->id,
                    'code' => $unnotified->code,
                    'customer_name' => $unnotified->customer_name ?: 'Khách hàng chuyển khoản',
                    'customer_phone' => $unnotified->customer_phone ?: '0901234567',
                    'car_name' => $unnotified->car_name ?: 'Mẫu xe sang PrimeLux',
                    'transfer_amount' => (float) $unnotified->transfer_amount,
                    'transfer_amount_formatted' => number_format((float) $unnotified->transfer_amount, 0, ',', '.').' VNĐ',
                    'gateway' => $unnotified->gateway ?: 'MBBank',
                    'account_number' => $unnotified->account_number ?: '0338929013',
                    'status_label' => 'Xác minh thành công',
                    'reference_code' => $unnotified->reference_code ?: 'FT'.rand(100000, 999999),
                    'time_human' => $unnotified->created_at ? $unnotified->created_at->diffForHumans() : 'Vừa xong',
                    'time_formatted' => $unnotified->created_at ? $unnotified->created_at->format('H:i:s d/m/Y') : now()->format('H:i:s d/m/Y'),
                ],
            ]);
        }

        return response()->json([
            'has_new' => false,
        ]);
    }

    /**
     * API: Đánh dấu giao dịch đã hiển thị thông báo góc phải Admin để không lặp lại
     */
    public function markNotified(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $code = $request->input('code');

        if ($id) {
            SepayTransaction::where('id', $id)->update(['is_notified_admin' => true]);
        } elseif ($code) {
            SepayTransaction::where('code', $code)->update(['is_notified_admin' => true]);
        } else {
            // Đánh dấu tất cả giao dịch hiện tại đã báo
            SepayTransaction::where('is_notified_admin', false)->update(['is_notified_admin' => true]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * API: Request đồng bộ giao dịch từ SePay API (sử dụng API Key Rp.4hxVyw@zA2@p)
     */
    public function syncFromSepayApi(Request $request): JsonResponse
    {
        $apiKey = config('payment.sepay.api_key', 'Rp.4hxVyw@zA2@p');
        $syncedCount = 0;
        $errorMsg = null;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Apikey '.$apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(8)->get('https://my.sepay.vn/userapi/transactions/list', [
                'limit' => 20,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $items = $data['transactions'] ?? $data['data'] ?? [];

                foreach ($items as $item) {
                    $sepayId = (string) ($item['id'] ?? '');
                    if (! $sepayId) {
                        continue;
                    }

                    $exists = SepayTransaction::where('sepay_id', $sepayId)->exists();
                    if (! $exists) {
                        $content = (string) ($item['transaction_content'] ?? $item['content'] ?? '');
                        $code = (string) ($item['code'] ?? '');
                        if (empty($code) && preg_match('/(PLDP[A-Za-z0-9]+)/i', $content, $m)) {
                            $code = strtoupper($m[1]);
                        }

                        $amount = (float) ($item['amount_in'] ?? $item['transferAmount'] ?? $item['amount'] ?? 0);

                        SepayTransaction::create([
                            'sepay_id' => $sepayId,
                            'gateway' => $item['bank_brand_name'] ?? 'MBBank',
                            'bank_account_id' => config('payment.sepay.bank_account_id', 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B'),
                            'transaction_date' => $item['transaction_date'] ?? now(),
                            'account_number' => $item['account_number'] ?? '0338929013',
                            'transfer_type' => 'in',
                            'transfer_amount' => $amount,
                            'accumulated' => $amount,
                            'code' => $code ?: ('PLDP'.date('ymd').rand(1000, 9999)),
                            'content' => $content,
                            'reference_code' => $item['reference_number'] ?? ('FT'.rand(100000, 999999)),
                            'description' => 'Đồng bộ tự động từ SePay API',
                            'car_name' => 'Mẫu xe sang PrimeLux',
                            'customer_name' => 'Khách hàng SePay API',
                            'customer_phone' => '0901234567',
                            'status' => SepayTransaction::STATUS_VERIFIED,
                            'is_notified_admin' => false,
                            'raw_data' => $item,
                        ]);
                        $syncedCount++;
                    }
                }
            } else {
                $errorMsg = 'SePay API trả về mã lỗi: '.$response->status();
            }
        } catch (\Throwable $e) {
            $errorMsg = $e->getMessage();
        }

        return response()->json([
            'success' => true,
            'synced_count' => $syncedCount,
            'api_key_used' => substr($apiKey, 0, 4).'***'.substr($apiKey, -3),
            'message' => $syncedCount > 0
                ? "Đã đồng bộ thành công {$syncedCount} giao dịch mới từ SePay API!"
                : 'Không có giao dịch mới nào từ SePay API ('.($errorMsg ?: 'Dữ liệu đã mới nhất').').',
        ]);
    }
}
