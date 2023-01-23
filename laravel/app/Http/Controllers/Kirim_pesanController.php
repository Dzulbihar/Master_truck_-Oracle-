<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\WA_jadwal_ujian;
use App\Models\Company;
use App\Models\Driver;
use Carbon\Carbon;

class Kirim_pesanController extends Controller
{

    public function index($id)
    {
    	$company = \App\Models\Company::find($id);
        $driver = \App\Models\Driver::find($id);
        $ujian = \App\Models\WA_jadwal_ujian::all()->where('id', 1);

        return view('master_driver.kirim_pesan.index', [
            'company' => $company,
            'driver' => $driver,
            'ujian' => $ujian
        ]);
    }

    public function pesan(Request $request)
    {
		if (isset($_POST['submit'])) {
			$pesan	= $request->pesan;
            $tanggal    = date('d F Y', strtotime($request->tanggal));
			$noWa	= $_POST['noWa'];
            
			header("location:https://api.whatsapp.com/send?phone=$noWa&text=$pesan%20%0DPada Tanggal : $tanggal%20%0D%20%0D%20%0D(Admin Pelindo III Semarang)");
		}
		else {
			echo "
				<script>
					window.location=histoty.go(-1);
				<script>
			";
		}
    }

    public function file(Request $request)
    {
        if (isset($_POST['submit'])) {

            $noWa   = $_POST['noWa'];
            
            header("location:https://api.whatsapp.com/send?phone=$noWa");
        }
        else {
            echo "
                <script>
                    window.location=histoty.go(-1);
                <script>
            ";
        }
    }

//////////////////////////////////////////////////////////////////////////////////



}
