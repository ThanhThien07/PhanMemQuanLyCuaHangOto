<?php

namespace App\Http\Controllers;

use App\Models\DatLichDichVu;
use App\Models\DichVu;
use App\Models\Xe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DichVuController extends Controller
{
    /**
     * Hiển thị trang Dịch Vụ Đẳng Cấp Thượng Lưu (Mercedes-Benz Inspired)
     */
    public function index(Request $request)
    {
        $allServices = DichVu::where('trang_thai', 'Đang hoạt động')->get();

        $baoTri  = $allServices->where('loai_dv', 'bao_tri');
        $baoHiem = $allServices->where('loai_dv', 'bao_hiem');
        $cuuHo   = $allServices->where('loai_dv', 'cuu_ho');
        $suaChua = $allServices->where('loai_dv', 'sua_chua');
        $uuDai   = $allServices->where('loai_dv', 'uu_dai');

        $cars = Xe::getAllCars();

        $currentUser = session('user');

        return view('dichvu.index', compact('baoTri', 'baoHiem', 'cuuHo', 'suaChua', 'uuDai', 'cars', 'currentUser'));
    }

    /**
     * Đặt lịch hẹn dịch vụ bảo trì, sửa chữa, bảo hiểm trực tuyến (AJAX)
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'ho_ten'            => 'required|string|max:120',
            'sdt'               => 'required|string|max:25',
            'email'             => 'nullable|email|max:120',
            'bien_so'           => 'nullable|string|max:30',
            'ten_xe'            => 'nullable|string|max:150',
            'showroom'          => 'required|string|max:150',
            'loai_dich_vu'      => 'required|string|max:80',
            'ten_dich_vu_cu_the'=> 'nullable|string|max:150',
            'thoi_gian_hen'     => 'required|string',
            'ghi_chu'           => 'nullable|string',
        ]);

        $thoiGian = str_replace('T', ' ', $validated['thoi_gian_hen']);
        if (strlen($thoiGian) === 16) {
            $thoiGian .= ':00';
        }

        $code = 'SER-' . date('Y') . '-' . strtoupper(Str::random(4));

        $booking = DatLichDichVu::create([
            'ma_dat_lich'        => $code,
            'ho_ten'             => $validated['ho_ten'],
            'sdt'                => $validated['sdt'],
            'email'              => $validated['email'] ?? null,
            'bien_so'            => strtoupper($validated['bien_so'] ?? ''),
            'ten_xe'             => $validated['ten_xe'] ?? 'Chưa xác định',
            'showroom'           => $validated['showroom'],
            'loai_dich_vu'       => $validated['loai_dich_vu'],
            'ten_dich_vu_cu_the' => $validated['ten_dich_vu_cu_the'] ?? null,
            'thoi_gian_hen'      => $thoiGian,
            'ghi_chu'            => $validated['ghi_chu'] ?? null,
            'trang_thai'         => 'Đang chờ tiếp nhận',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt lịch dịch vụ thành công! Chuyên viên PrimeLux Service sẽ liên hệ xác nhận trong 15 phút.',
            'data'    => [
                'ma_dat_lich'  => $booking->ma_dat_lich,
                'ho_ten'       => $booking->ho_ten,
                'sdt'          => $booking->sdt,
                'ten_xe'       => $booking->ten_xe,
                'loai_dich_vu' => $booking->loai_dich_vu,
                'thoi_gian'    => $booking->thoi_gian_hen,
                'showroom'     => $booking->showroom,
                'trang_thai'   => $booking->trang_thai,
            ]
        ]);
    }

    /**
     * Yêu cầu Cứu hộ khẩn cấp 24/7 (AJAX SOS)
     */
    public function storeEmergency(Request $request)
    {
        $validated = $request->validate([
            'ho_ten'        => 'required|string|max:120',
            'sdt'           => 'required|string|max:25',
            'bien_so'       => 'nullable|string|max:30',
            'ten_xe'        => 'nullable|string|max:150',
            'vi_tri_cuu_ho' => 'required|string|max:255',
            'ghi_chu'       => 'nullable|string',
        ]);

        $code = 'RES-' . date('Y') . '-' . strtoupper(Str::random(4));

        $emergency = DatLichDichVu::create([
            'ma_dat_lich'        => $code,
            'ho_ten'             => $validated['ho_ten'],
            'sdt'                => $validated['sdt'],
            'bien_so'            => strtoupper($validated['bien_so'] ?? ''),
            'ten_xe'             => $validated['ten_xe'] ?? 'Xe cần cứu hộ khẩn cấp',
            'showroom'           => 'Trung Tâm Cứu Hộ Giao Thông PrimeLux 24/7',
            'loai_dich_vu'       => 'Cứu Hộ Khẩn Cấp 24/7',
            'ten_dich_vu_cu_the' => 'Dịch Vụ Cứu Hộ Giao Thông 24/7 Chuyên Dụng',
            'thoi_gian_hen'      => now(),
            'vi_tri_cuu_ho'      => $validated['vi_tri_cuu_ho'],
            'ghi_chu'            => $validated['ghi_chu'] ?? 'Yêu cầu cứu hộ khẩn cấp từ website',
            'trang_thai'         => 'Đang xử lý',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu cứu hộ khẩn cấp 24/7 đã được tiếp nhận! Đội xe cứu hộ chuyên dụng đang xuất phát.',
            'data'    => [
                'ma_dat_lich'  => $emergency->ma_dat_lich,
                'ho_ten'       => $emergency->ho_ten,
                'sdt'          => $emergency->sdt,
                'vi_tri'       => $emergency->vi_tri_cuu_ho,
                'trang_thai'   => $emergency->trang_thai,
            ]
        ]);
    }

    /**
     * Tra cứu trạng thái lịch hẹn dịch vụ & cứu hộ theo Mã hoặc SĐT (AJAX API)
     */
    public function traCuu(Request $request)
    {
        $query = trim($request->input('query', ''));

        if (empty($query)) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập Mã lịch hẹn hoặc Số điện thoại.'], 400);
        }

        $results = DatLichDichVu::where('ma_dat_lich', $query)
            ->orWhere('sdt', $query)
            ->orderBy('id', 'desc')
            ->get();

        if ($results->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy hồ sơ dịch vụ tương ứng với thông tin trên.'], 44);
        }

        return response()->json([
            'success' => true,
            'count'   => $results->count(),
            'data'    => $results->map(function ($item) {
                return [
                    'id'                 => $item->id,
                    'ma_dat_lich'        => $item->ma_dat_lich,
                    'ho_ten'             => $item->ho_ten,
                    'sdt'                => $item->sdt,
                    'bien_so'            => $item->bien_so ?: 'N/A',
                    'ten_xe'             => $item->ten_xe,
                    'showroom'           => $item->showroom,
                    'loai_dich_vu'       => $item->loai_dich_vu,
                    'ten_dich_vu_cu_the' => $item->ten_dich_vu_cu_the,
                    'thoi_gian_hen'      => date('H:i d/m/Y', strtotime($item->thoi_gian_hen)),
                    'vi_tri_cuu_ho'      => $item->vi_tri_cuu_ho,
                    'ghi_chu'            => $item->ghi_chu,
                    'trang_thai'         => $item->trang_thai,
                    'badge'              => $item->trang_thai_badge,
                ];
            })
        ]);
    }

    /**
     * Cập nhật trạng thái đặt lịch (Dành cho Quản trị viên / Cố vấn dịch vụ)
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('trang_thai');
        $item = DatLichDichVu::where('id', $id)->orWhere('ma_dat_lich', $id)->first();

        if ($item) {
            $item->trang_thai = $status;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái dịch vụ thành công!',
                'data' => [
                    'id' => $item->id,
                    'ma_dat_lich' => $item->ma_dat_lich,
                    'trang_thai' => $item->trang_thai,
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy yêu cầu dịch vụ.'], 404);
    }
}
