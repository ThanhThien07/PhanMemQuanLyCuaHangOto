<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DangNhapController extends Controller
{
    /**
     * Hiển thị trang đăng nhập
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'customer');

        return view('dangnhap.index', compact('role'));
    }

    /**
     * Hiển thị trang đăng ký tài khoản mới
     */
    public function showRegister(Request $request)
    {
        return view('dangnhap.register');
    }

    /**
     * Xử lý đăng ký tài khoản khách hàng mới
     */
    public function register(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:100',
            'sdt' => 'required|string|max:20|unique:khach_hang,sdt',
            'email' => 'required|email|max:100|unique:khach_hang,email',
            'mat_khau' => 'required|string|min:6|confirmed',
            'dia_chi' => 'nullable|string|max:255',
            'ngay_sinh' => 'nullable|date',
        ], [
            'ho_ten.required' => 'Vui lòng nhập họ tên.',
            'sdt.required' => 'Vui lòng nhập số điện thoại.',
            'sdt.unique' => 'Số điện thoại này đã được đăng ký.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã được đăng ký.',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'mat_khau.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Tạo mã khách hàng tự động
        $lastKh = KhachHang::orderBy('id', 'desc')->first();
        $nextNum = $lastKh ? (intval(substr($lastKh->ma_kh ?? 'KH000', 2)) + 1) : 1;
        $maKh = 'KH'.str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $customer = KhachHang::create([
            'ma_kh' => $maKh,
            'ho_ten' => $request->ho_ten,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'mat_khau' => Hash::make($request->mat_khau),
            'dia_chi' => $request->dia_chi,
            'ngay_sinh' => $request->ngay_sinh,
            'diem_tich_luy' => 0,
            'tong_chi_tieu' => 0,
            'ma_hang' => 'SILVER',
        ]);

        // Đăng nhập luôn sau khi đăng ký
        session([
            'user' => [
                'name' => $customer->ho_ten,
                'role' => 'customer',
                'badge' => 'Silver Member',
                'phone' => $customer->sdt,
                'email' => $customer->email,
                'ma_kh' => $customer->ma_kh,
                'points' => 0,
                'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($customer->ho_ten).'&background=2563eb&color=fff&bold=true',
            ],
        ]);

        return redirect()->route('loyalty')
            ->with('success', 'Chào mừng '.$customer->ho_ten.'! Tài khoản PrimeLux Club đã được tạo thành công.');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $role = $request->input('role', 'customer');
        $account = $request->input('account', '');
        $password = $request->input('password', '');

        // --- ADMIN ---
        if ($role === 'admin') {
            $validAdmins = [
                'admin' => 'admin123',
                'admin@primelux.vn' => 'admin123',
                'superadmin' => 'primelux2024',
            ];

            if (isset($validAdmins[$account]) && $validAdmins[$account] === $password) {
                session([
                    'user' => [
                        'name' => 'Quản Trị Viên (Admin)',
                        'role' => 'admin',
                        'badge' => 'Administrator',
                        'email' => $account ?: 'admin@primelux.vn',
                        'avatar' => 'https://ui-avatars.com/api/?name=Admin&background=f59e0b&color=000&bold=true',
                    ],
                ]);

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Đăng nhập thành công với quyền Quản Trị Viên!');
            }

            return back()->with('error', 'Tài khoản hoặc mật khẩu Admin không đúng.')->withInput();
        }

        // --- ADVISOR ---
        if ($role === 'advisor') {
            $validAdvisors = [
                'tuvanvien@primelux.vn' => 'advisor123',
                'tuvan' => 'advisor123',
                'advisor' => 'advisor123',
            ];

            if (isset($validAdvisors[$account]) && $validAdvisors[$account] === $password) {
                session([
                    'user' => [
                        'name' => 'Chuyên Viên Tư Vấn',
                        'role' => 'advisor',
                        'badge' => 'Advisor Desk',
                        'email' => $account ?: 'tuvanvien@primelux.vn',
                        'avatar' => 'https://ui-avatars.com/api/?name=Advisor&background=06b6d4&color=fff&bold=true',
                    ],
                ]);

                return redirect()->route('consultant.index')
                    ->with('success', 'Đăng nhập thành công vào Bàn Tư Vấn Realtime!');
            }

            return back()->with('error', 'Tài khoản hoặc mật khẩu Tư Vấn Viên không đúng.')->withInput();
        }

        // --- KHÁCH HÀNG ---
        $customer = KhachHang::with('tier')
            ->where('sdt', $account)
            ->orWhere('email', $account)
            ->first();

        if (! $customer) {
            return back()->with('error', 'Không tìm thấy tài khoản với email/SĐT này.')->withInput();
        }

        // Kiểm tra mật khẩu (hỗ trợ cả hash và plaintext cũ)
        $passwordValid = false;
        if ($customer->mat_khau) {
            if (Hash::check($password, $customer->mat_khau)) {
                $passwordValid = true;
            } elseif ($customer->mat_khau === $password) {
                // Mật khẩu plaintext cũ — nâng cấp lên hash
                $customer->update(['mat_khau' => Hash::make($password)]);
                $passwordValid = true;
            } elseif (! $customer->mat_khau || $customer->mat_khau === '123456') {
                // Tài khoản demo chưa có mật khẩu thực
                $passwordValid = true;
            }
        } else {
            // Tài khoản chưa có mật khẩu (tạo từ admin)
            $passwordValid = true;
        }

        if (! $passwordValid) {
            return back()->with('error', 'Mật khẩu không đúng.')->withInput();
        }

        $custName = $customer->ho_ten ?? 'Khách Hàng';
        $custTier = $customer->tier?->ten_hang ?? 'Silver Member';
        $custPhone = $customer->sdt ?? $account;

        session([
            'user' => [
                'name' => $custName,
                'role' => 'customer',
                'badge' => $custTier,
                'phone' => $custPhone,
                'email' => $customer->email ?? '',
                'ma_kh' => $customer->ma_kh ?? '',
                'points' => $customer->diem_tich_luy ?? 0,
                'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($custName).'&background=2563eb&color=fff&bold=true',
            ],
        ]);

        return redirect()->route('loyalty', ['phone' => urlencode($custPhone)])
            ->with('success', 'Đăng nhập thành công vào Cổng Khách Hàng VIP!');
    }

    /**
     * Chuyển hướng tới Google OAuth / Đăng nhập nhanh bằng tài khoản Google
     */
    public function redirectToGoogle(Request $request)
    {
        // Nhận email Google từ request hoặc tài khoản Google mặc định
        $googleEmail = $request->input('email', 'khachhang.google@gmail.com');
        $googleName = $request->input('name', 'Khách Hàng Google VIP');
        $googleId = $request->input('google_id', 'gg_'.time());

        // Kiểm tra xem khách hàng đã tồn tại chưa
        $customer = KhachHang::where('email', $googleEmail)->first();

        if (! $customer) {
            // Tự động tạo tài khoản thành viên mới từ thông tin Google
            $lastKh = KhachHang::orderBy('id', 'desc')->first();
            $nextNum = $lastKh ? (intval(substr($lastKh->ma_kh ?? 'KH000', 2)) + 1) : 1;
            $maKh = 'KH'.str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            $customer = KhachHang::create([
                'ma_kh' => $maKh,
                'ho_ten' => $googleName,
                'sdt' => '09'.rand(10000000, 99999999),
                'email' => $googleEmail,
                'mat_khau' => Hash::make(uniqid('gg_')),
                'dia_chi' => 'Đăng ký qua tài khoản Google',
                'ngay_sinh' => '1995-01-01',
                'diem_tich_luy' => 0,
                'tong_chi_tieu' => 0,
                'ma_hang' => 'SILVER',
            ]);
        }

        // Đăng nhập vào session
        $custName = $customer->ho_ten ?? $googleName;
        $custTier = $customer->tier?->ten_hang ?? 'Silver Member';
        $custPhone = $customer->sdt;

        session([
            'user' => [
                'name' => $custName,
                'role' => 'customer',
                'badge' => $custTier,
                'phone' => $custPhone,
                'email' => $customer->email,
                'ma_kh' => $customer->ma_kh,
                'points' => $customer->diem_tich_luy ?? 0,
                'auth_provider' => 'google',
                'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($custName).'&background=ea4335&color=fff&bold=true',
            ],
        ]);

        return redirect()->route('loyalty', ['phone' => urlencode($custPhone)])
            ->with('success', 'Đăng nhập thành công với tài khoản Google ('.$customer->email.')!');
    }

    /**
     * Xử lý Google OAuth Callback
     */
    public function handleGoogleCallback(Request $request)
    {
        return $this->redirectToGoogle($request);
    }

    /**
     * Đăng xuất an toàn và xóa toàn bộ session
     */
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Bạn đã đăng xuất khỏi hệ thống an toàn.')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
