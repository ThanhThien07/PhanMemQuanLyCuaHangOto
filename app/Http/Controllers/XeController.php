<?php

namespace App\Http\Controllers;

use App\Models\Xe;
use Illuminate\Http\Request;

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
            return (string)$c['id'] === (string)$carId 
                || (string)$c['id'] === 'car-' . str_pad($carId, 2, '0', STR_PAD_LEFT)
                || (isset($c['name']) && stripos($c['name'], $carId) !== false);
        }) ?? ($cars[0] ?? null);

        return view('xe.chitiet', compact('car', 'cars'));
    }
}
