<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cấu Hình Cổng Thanh Toán Trực Tuyến (Online Payment Gateway)
    |--------------------------------------------------------------------------
    | Quản lý thông tin cổng thanh toán trực tuyến cho các khoản trả trước (down payment),
    | đặt cọc giữ xe và hợp đồng mua bán của PrimeLux Auto Showroom.
    */

    'gateway' => [
        'status' => true,
        'id' => 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B',
        'provider' => 'PrimeLux Pay / VietQR Open Banking',
        'bank_name' => 'Ngân hàng Quân Đội (MBBank)',
        'bank_code' => 'MB',
        'account_number' => '0338929013',
        'account_holder' => 'PRIMELUX AUTO SHOWROOM',
        'branch' => 'Chi nhánh Quận 1, TP. Hồ Chí Minh',
        'support_hotline' => '0338 929 013',
    ],

    'downpayment' => [
        'min_percent' => 20,
        'max_percent' => 80,
        'default_percent' => 30,
        'deposit_fixed' => 100000000, // 100 triệu VNĐ đặt cọc trả trước tối thiểu
        'interest_rate_default' => 7.9, // 7.9% / năm
        'max_loan_years' => 8,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cấu Hình SePay Webhook & Tự Động Khớp Lệnh Biến Động Số Dư
    |--------------------------------------------------------------------------
    | Tiếp nhận thông báo tiền vào tức thì từ SePay webhook khi khách hàng
    | quét mã QR chuyển khoản ngân hàng thành công.
    */
    'sepay' => [
        'enabled' => true,
        'bank_account_id' => env('SEPAY_BANK_ACCOUNT_ID', 'ba_0VXvtCFwZHBJL8Lb7GYukenOW9B'),
        'api_key' => env('SEPAY_API_KEY', 'Rp.4hxVyw@zA2@p'),
        'webhook_token' => env('SEPAY_WEBHOOK_TOKEN', 'sepay_secret_token_primelux_2026'),
        'webhook_url_path' => env('SEPAY_WEBHOOK_URL', '/hooks/sepay-payment'),
        'auto_match_downpayment' => true,
    ],
];
