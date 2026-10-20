<?php

namespace App\Mail;

use App\Models\HoaDon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HoaDonXacNhanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Khởi tạo Mailable với thông tin hóa đơn
     */
    public function __construct(
        public HoaDon|array $invoice,
        public array $extraData = []
    ) {}

    /**
     * Tiêu đề email và người gửi
     */
    public function envelope(): Envelope
    {
        $code = is_array($this->invoice) ? ($this->invoice['ma_hd'] ?? 'HD'.date('Ymd')) : $this->invoice->ma_hd;

        return new Envelope(
            from: new Address(
                config('mail.from.address', 'billing@primelux.vn'),
                config('mail.from.name', 'PrimeLux Auto Showroom')
            ),
            subject: '【PrimeLux Auto】Xác Nhận Hóa Đơn & Đặt Cọc Mua Xe Thành Công #'.$code,
        );
    }

    /**
     * Template nội dung email
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.hoadon',
        );
    }

    /**
     * Tệp đính kèm (nếu có)
     */
    public function attachments(): array
    {
        return [];
    }
}
