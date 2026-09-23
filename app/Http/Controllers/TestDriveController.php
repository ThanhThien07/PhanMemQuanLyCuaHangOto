<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::getAllCars();
        $selectedCar = $request->query('car', '');
        return view('test-drive', compact('cars', 'selectedCar'));
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

        $code = 'TD-' . strtoupper(substr(uniqid(), -5));

        $testDrive = \App\Models\TestDrive::create([
            'ma_lich' => $code,
            'ho_ten' => $validated['ho_ten'],
            'sdt' => $validated['sdt'],
            'email' => $validated['email'] ?? 'N/A',
            'ten_xe' => $validated['ten_xe'],
            'showroom' => $validated['showroom'],
            'thoi_gian' => $validated['thoi_gian'],
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
                'date' => $testDrive->thoi_gian,
                'status' => $testDrive->trang_thai,
            ]
        ]);
    }
}

