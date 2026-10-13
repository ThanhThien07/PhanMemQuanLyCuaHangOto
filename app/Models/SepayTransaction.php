<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SepayTransaction extends Model
{
    protected $table = 'sepay_transactions';

    public const STATUS_PENDING = 'CHUA_THANH_TOAN';

    public const STATUS_VERIFIED = 'XAC_MINH_THANH_CONG';

    public const STATUS_FAILED = 'THAT_BAI';

    protected $fillable = [
        'sepay_id',
        'gateway',
        'bank_account_id',
        'transaction_date',
        'account_number',
        'sub_account',
        'transfer_type',
        'transfer_amount',
        'accumulated',
        'code',
        'content',
        'reference_code',
        'description',
        'car_id',
        'car_name',
        'customer_name',
        'customer_phone',
        'status',
        'is_notified_admin',
        'raw_data',
    ];

    protected $casts = [
        'transfer_amount' => 'decimal:2',
        'accumulated' => 'decimal:2',
        'transaction_date' => 'datetime',
        'is_notified_admin' => 'boolean',
        'raw_data' => 'array',
    ];

    /**
     * Lấy nhãn trạng thái hiển thị bằng tiếng Việt chuẩn
     */
    public function getStatusLabelAttribute(): string
    {
        $status = strtoupper((string) $this->status);
        if ($status === self::STATUS_VERIFIED || $status === 'MATCHED' || $status === 'SUCCESS' || $status === 'PAID') {
            return 'Xác minh thành công';
        }

        if ($status === self::STATUS_PENDING || $status === 'PENDING' || $status === 'UNPAID') {
            return 'Chưa thanh toán';
        }

        return 'Chưa thanh toán';
    }

    /**
     * Kiểm tra giao dịch đã được xác minh thành công chưa
     */
    public function isVerified(): bool
    {
        $status = strtoupper((string) $this->status);

        return in_array($status, [self::STATUS_VERIFIED, 'MATCHED', 'SUCCESS', 'PAID'], true);
    }

    /**
     * Lấy danh sách giao dịch mẫu ban đầu nếu bảng còn trống
     */
    public static function seedSampleTransactionsIfEmpty(): void
    {
        if (self::count() === 0) {
            $samples = [
                [
                    'sepay_id' => '92701',
                    'gateway' => 'MBBank',
                    'bank_account_id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
                    'transaction_date' => now()->subHours(2),
                    'account_number' => '0338929013',
                    'transfer_type' => 'in',
                    'transfer_amount' => 4797000000,
                    'accumulated' => 4797000000,
                    'code' => 'PLDP2610138901',
                    'content' => 'PLDP2610138901 0988776655',
                    'reference_code' => 'FT261013998811',
                    'description' => 'Thanh toán tiền trả trước 30% xe Mercedes-Maybach S 680',
                    'car_id' => 'car-01',
                    'car_name' => 'Mercedes-Maybach S 680 4MATIC',
                    'customer_name' => 'Lê Hoàng Long',
                    'customer_phone' => '0988776655',
                    'status' => 'MATCHED',
                ],
                [
                    'sepay_id' => '92702',
                    'gateway' => 'MBBank',
                    'bank_account_id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
                    'transaction_date' => now()->subDay(),
                    'account_number' => '0338929013',
                    'transfer_type' => 'in',
                    'transfer_amount' => 100000000,
                    'accumulated' => 4897000000,
                    'code' => 'PLDP2610123344',
                    'content' => 'PLDP2610123344 0912987654',
                    'reference_code' => 'FT261012443322',
                    'description' => 'Đặt cọc giữ chỗ mua xe Porsche Taycan Turbo S',
                    'car_id' => 'car-02',
                    'car_name' => 'Porsche Taycan Turbo S',
                    'customer_name' => 'Trần Thị Mai',
                    'customer_phone' => '0912987654',
                    'status' => 'MATCHED',
                ],
                [
                    'sepay_id' => '92703',
                    'gateway' => 'MBBank',
                    'bank_account_id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
                    'transaction_date' => now()->subDays(2),
                    'account_number' => '0338929013',
                    'transfer_type' => 'in',
                    'transfer_amount' => 1649700000,
                    'accumulated' => 6546700000,
                    'code' => 'PLDP2610115566',
                    'content' => 'PLDP2610115566 0901234567',
                    'reference_code' => 'FT261011112233',
                    'description' => 'Trả trước 30% hợp đồng mua xe BMW 740i',
                    'car_id' => 'car-03',
                    'car_name' => 'BMW 740i Pure Excellence',
                    'customer_name' => 'Nguyễn Văn A',
                    'customer_phone' => '0901234567',
                    'status' => 'MATCHED',
                ],
            ];

            foreach ($samples as $item) {
                self::create($item);
            }
        }
    }
}
