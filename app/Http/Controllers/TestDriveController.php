<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\TestDrive;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::getAllCars();
        $selectedCar = $request->query('car', '');

        $existingBookings = [];
        try {
            $existingBookings = TestDrive::where('trang_thai', '!=', 'Đã hủy')
                ->select('showroom', 'thoi_gian')
                ->get()
                ->map(function ($b) {
                    return [
                        'showroom' => $b->showroom,
                        'thoi_gian' => substr($b->thoi_gian, 0, 16),
                    ];
                })->toArray();
        } catch (\Throwable $e) {
        }

        return view('test-drive', compact('cars', 'selectedCar', 'existingBookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:150',
            'sdt' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'ten_xe' => 'required|string|max:150',
            'showroom' => 'required|string|max:150',
            'thoi_gian' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ]);

        $thoiGian = str_replace('T', ' ', $validated['thoi_gian']);
        if (strlen($thoiGian) === 16) {
            $thoiGian .= ':00';
        }

        $code = 'TD-'.strtoupper(substr(uniqid(), -5));

        $testDrive = TestDrive::create([
            'ma_lich' => $code,
            'ho_ten' => $validated['ho_ten'],
            'sdt' => $validated['sdt'],
            'email' => $validated['email'] ?? 'N/A',
            'ten_xe' => $validated['ten_xe'],
            'showroom' => $validated['showroom'],
            'thoi_gian' => $thoiGian,
            'ghi_chu' => $validated['ghi_chu'] ?? null,
            'trang_thai' => 'Đang chờ duyệt',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký lịch lái thử thành công!',
            'data' => [
                'id' => $code,
                'name' => $testDrive->ho_ten,
                'phone' => $testDrive->sdt,
                'carName' => $testDrive->ten_xe,
                'showroom' => $testDrive->showroom,
                'date' => $testDrive->thoi_gian,
                'status' => $testDrive->trang_thai,
            ],
        ]);
    }
}
