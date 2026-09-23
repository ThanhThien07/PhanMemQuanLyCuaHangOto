<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::getAllCars();
        return view('cars.index', compact('cars'));
    }

    public function show(Request $request, $id = null)
    {
        $carId = $id ?? $request->query('id', 'car-01');
        $cars = Car::getAllCars();

        $car = collect($cars)->first(function ($c) use ($carId) {
            return $c['id'] == $carId 
                || $c['id'] == 'car-' . str_pad($carId, 2, '0', STR_PAD_LEFT)
                || (isset($c['name']) && stripos($c['name'], $carId) !== false);
        }) ?? ($cars[0] ?? null);

        return view('cars.show', compact('car', 'cars'));
    }
}
