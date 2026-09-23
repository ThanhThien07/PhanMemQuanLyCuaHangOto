<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'customer');
        return view('auth.login', compact('role'));
    }

    /**
     * Process login submission and establish session
     */
    public function login(Request $request)
    {
        $role = $request->input('role', 'customer');
        $account = $request->input('account', '');

        if ($role === 'admin') {
            session([
                'user' => [
                    'name' => 'Quản Trị Viên (Admin)',
                    'role' => 'admin',
                    'badge' => 'Administrator',
                    'email' => $account ?: 'admin@primelux.vn',
                    'avatar' => 'https://ui-avatars.com/api/?name=Admin&background=f59e0b&color=000&bold=true',
                ]
            ]);
            return redirect('/admin')->with('success', 'Đăng nhập thành công với quyền Quản Trị Viên!');
        }

        if ($role === 'advisor') {
            session([
                'user' => [
                    'name' => 'Chuyên Viên Tư Vấn',
                    'role' => 'advisor',
                    'badge' => 'Advisor Desk',
                    'email' => $account ?: 'tuvanvien@primelux.vn',
                    'avatar' => 'https://ui-avatars.com/api/?name=Advisor&background=06b6d4&color=fff&bold=true',
                ]
            ]);
            return redirect('/consultant')->with('success', 'Đăng nhập thành công vào Bàn Tư Vấn Realtime!');
        }

        // Customer
        $customer = Customer::with('tier')
            ->where('sdt', $account)
            ->orWhere('email', $account)
            ->first();

        $custName = $customer->ho_ten ?? 'Nguyễn Văn A';
        $custTier = $customer->tier->ten_hang ?? 'Diamond VIP';
        $custPhone = $customer->sdt ?? ($account ?: '0901234567');

        session([
            'user' => [
                'name' => $custName,
                'role' => 'customer',
                'badge' => $custTier,
                'phone' => $custPhone,
                'email' => $customer->email ?? 'khachhang@gmail.com',
                'points' => $customer->diem_tich_luy ?? 12500,
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($custName) . '&background=2563eb&color=fff&bold=true',
            ]
        ]);

        return redirect('/loyalty?phone=' . urlencode($custPhone))->with('success', 'Đăng nhập thành công vào Cổng Khách Hàng VIP!');
    }

    /**
     * Process logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Bạn đã đăng xuất khỏi hệ thống an toàn.');
    }
}
