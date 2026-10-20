<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::getAllCars();

        return view('home', compact('cars'));
    }
}
