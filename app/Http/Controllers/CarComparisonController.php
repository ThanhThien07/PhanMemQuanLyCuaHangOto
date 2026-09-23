<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarPriceSource;
use Illuminate\Http\Request;

class CarComparisonController extends Controller
{
    /**
     * Display comparison page for a car
     */
    public function compare(Request $request, $id = null)
    {
        $allCars = Car::getAllCars();
        
        // Find selected car
        $selectedId = $id ?? $request->query('car_id', '1');
        
        $car = collect($allCars)->first(function ($c) use ($selectedId) {
            return (string)$c['id'] === (string)$selectedId
                || (string)$c['id'] === 'car-' . str_pad($selectedId, 2, '0', STR_PAD_LEFT)
                || (isset($c['name']) && stripos($c['name'], $selectedId) !== false);
        }) ?? ($allCars[0] ?? null);

        // Find database record for car ID (1-6)
        $dbCar = null;
        if (isset($car['id'])) {
            $dbCar = Car::where('id', $selectedId)
                ->orWhere('ma_xe', $car['id'])
                ->orWhere('ten_xe', $car['name'])
                ->first();
        }

        $carDbId = $dbCar->id ?? 1;

        // Retrieve external price sources ordered by price ASCENDING (từ thấp đến cao)
        $sources = CarPriceSource::where('car_id', $carDbId)
            ->orderBy('price', 'asc')
            ->get();

        // Calculate market analytics
        $primeLuxPrice = (float)($car['price'] ?? 0);
        $minPrice = $sources->min('price') ?? $primeLuxPrice;
        $maxPrice = $sources->max('price') ?? $primeLuxPrice;
        $avgPrice = $sources->avg('price') ?? $primeLuxPrice;

        return view('cars.compare', compact(
            'car',
            'allCars',
            'sources',
            'primeLuxPrice',
            'minPrice',
            'maxPrice',
            'avgPrice'
        ));
    }

    /**
     * Default index redirects to compare first car
     */
    public function index(Request $request)
    {
        $carId = $request->query('car_id', 1);
        return $this->compare($request, $carId);
    }

    /**
     * Refresh / live update search simulation
     */
    public function refresh(Request $request, $id)
    {
        $carDbId = is_numeric($id) ? $id : 1;
        CarPriceSource::where('car_id', $carDbId)->update(['fetched_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đồng bộ và cập nhật dữ liệu giá mới nhất từ các sàn xe trực tuyến!',
            'synced_at' => now()->format('H:i:s d/m/Y'),
        ]);
    }
}
