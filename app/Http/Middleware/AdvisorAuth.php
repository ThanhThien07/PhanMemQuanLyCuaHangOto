<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware bảo vệ trang Tư Vấn Viên.
 * Chỉ cho phép user có role 'advisor' hoặc 'admin'.
 */
class AdvisorAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('user');

        if (! $user || ! in_array($user['role'], ['advisor', 'admin'])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần quyền Chuyên Viên Tư Vấn để thực hiện thao tác này.',
                ], 403);
            }

            return redirect()->route('dangnhap', ['role' => 'advisor'])
                ->with('error', 'Bạn cần đăng nhập với tư cách Tư Vấn Viên để truy cập bàn tư vấn.');
        }

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }
}
