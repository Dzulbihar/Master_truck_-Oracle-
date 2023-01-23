<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Truck;
use DB;

class RFID_Controller extends Controller
{
    public function rfid()
    {
        $title = "rfid";
        $user = \App\Models\User::all();
        $company = \App\Models\Company::all();
        $trucks = \App\Models\Truck::orderBy('status', 'ASC')
        ->get();
        // ->orderBy('id', 'DESC');
        // $trucks = \App\Models\Truck::all()->where('status', !0); //selain 0

        return view('rfid.index',
            [
            'title' => $title,
            'user' => $user,
            'company' => $company, 
            'trucks' => $trucks,
        ]);
    }
}
