<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware bảo vệ trang Admin.
 * - Kiểm tra session có role 'admin' không.
 * - Thêm header no-cache để ngăn browser back-button vào lại sau khi logout.
 */
class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('user');

        if (! $user || $user['role'] !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần quyền Quản Trị Viên để thực hiện thao tác này.',
                ], 403);
            }

            return redirect()->route('dangnhap', ['role' => 'admin'])
                ->with('error', 'Bạn cần đăng nhập với quyền Quản Trị Viên để truy cập trang này.');
        }

        $response = $next($request);

        // Ngăn browser cache trang admin — fix back-button bypass sau logout
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
