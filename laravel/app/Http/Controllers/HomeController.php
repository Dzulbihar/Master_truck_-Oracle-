<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Chassis_code;
use App\Models\Merk;
use App\Models\Kota;
use App\Models\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {          
        $title = "home";
        $company = auth()->user()->company;

        return view('home', [
            'title' => $title,
            'company' => $company
        ]);
    }



}
