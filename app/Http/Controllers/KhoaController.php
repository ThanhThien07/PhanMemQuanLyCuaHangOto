<?php

namespace App\Http\Controllers;

use App\Models\Khoa;
use Illuminate\Http\Request;

class KhoaController extends Controller
{
    public function index(){
        $khoas = Khoa::all();
        return view("khoas.index")->with("khoas",$khoas);
    }
}
