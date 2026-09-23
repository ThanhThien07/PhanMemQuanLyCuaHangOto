<?php

namespace App\Http\Controllers;

use App\Models\Xe;
use Illuminate\Http\Request;

class TrangChuController extends Controller
{
    public function index(Request $request)
    {
        $cars = Xe::getAllCars();
        return view('trangchu', compact('cars'));
    }
}
