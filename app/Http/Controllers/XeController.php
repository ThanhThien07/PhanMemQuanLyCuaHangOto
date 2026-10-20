<?php

namespace App\Http\Controllers;

use App\Models\Xe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class XeController extends Controller
{
    public function index(Request $request)
    {
        $cars = Xe::getAllCars();

        return view('xe.danhsach', compact('cars'));
    }

    public function show(Request $request, $id = null)
    {
        $carId = $id ?? $request->query('id', 'car-01');
        $cars = Xe::getAllCars();

        $car = collect($cars)->first(function ($c) use ($carId) {
            return (string) $c['id'] === (string) $carId
                || (string) $c['id'] === 'car-'.str_pad($carId, 2, '0', STR_PAD_LEFT)
                || (isset($c['name']) && stripos($c['name'], $carId) !== false);
        }) ?? ($cars[0] ?? null);

        return view('xe.chitiet', compact('car', 'cars'));
    }

    /**
     * API: Lấy toàn bộ danh sách xe đang phân phối (JSON)
     */
    public function apiIndex(Request $request)
    {
        $cars = Xe::getAllCars();
        $version = Cache::get('primelux_cars_version', (string) now()->timestamp);

        return response()->json([
            'success' => true,
            'version' => (string) $version,
            'cars' => $cars,
            'total' => count($cars),
        ]);
    }

    /**
     * API: Thăm dò feed xe siêu nhẹ theo version (Smart Polling Feed)
     * Trả về updated=false nếu phiên bản chưa đổi, giảm tải 99% băng thông
     */
    public function apiFeed(Request $request)
    {
        $currentVersion = (string) Cache::get('primelux_cars_version', '1');
        $lastSync = (string) $request->query('last_sync', '');

        if ($lastSync !== '' && $lastSync === $currentVersion) {
            return response()->json([
                'success' => true,
                'updated' => false,
                'version' => $currentVersion,
            ]);
        }

        $cars = Xe::getAllCars();

        return response()->json([
            'success' => true,
            'updated' => true,
            'version' => $currentVersion,
            'cars' => $cars,
            'total' => count($cars),
        ]);
    }
}
