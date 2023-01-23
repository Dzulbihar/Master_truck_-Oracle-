<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\user;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Truck;
use App\Models\Violation;
use App\Models\Violation_history;
use App\Models\PelanggaranJenis;
use App\Models\PelanggaranBentuk;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class ViolationController extends Controller
{
    public function index($id)
    {
        $title = "master_driver";
        $company = \App\Models\Company::find($id);
        $driver = \App\Models\Driver::find($id);
        $violation = \App\Models\Violation::all();
        $violations = \App\Models\Violation::where('driver_id',$id)->get();

        return view('master_driver.violation.index', [
            'title' => $title,
            'company' => $company,
            'driver' => $driver,
            'violation' => $violation,
            'violations' => $violations,
        ]);
    }

    public function add($id)
    {
        $title = "master_driver";
        $company = \App\Models\Company::find($id);
        $driver = \App\Models\Driver::find($id);
        $truck = \App\Models\Truck::all();
        $violation = \App\Models\violation::all();
        $violations = \App\Models\Violation::where('driver_id',$id)->get();
        $jenis_pelanggaran = \App\Models\PelanggaranJenis::all()->where('status', 'Aktif');

        return view('master_driver.violation.add', [
            'title' => $title,
            'company' => $company,
            'driver' => $driver,
            'truck' => $truck,
            'violation' => $violation,
            'violations' => $violations,
            'jenis_pelanggaran'=>$jenis_pelanggaran
        ]);
    }

    public function getPelanggaranBentuk(Request $request){
        $bentuk_pelanggaran = PelanggaranBentuk::where("bentuk_jenis",$request->kabID)
        ->where('status', "Aktif")
        ->pluck('bentuk_pelanggaran');
        return response()->json($bentuk_pelanggaran);
    }

    public function addviolation(Request $request ,$iddriver)
    {
        $messages = [
            'mimes' => '*upload dengan format jpg, jpeg, pdf! dan silakan isi kembali datanya',
            // 'min' => '*upload file minimal 1 mb !',
            'max' => '*upload file maksimal 4 mb! dan silakan isi kembali datanya',
        ];
 
        $this->validate($request,[
            'foto' => 'mimes:pdf,jpg,jpeg|file|max:4096',
        ],$messages);

        $driver = \App\Models\Driver::find($iddriver);
        $request->request->add(['driver_id' => $driver->id ]);
        $request->request->add(['nama_perusahaan' => $driver->owner_name ]);
        $request->request->add(['nama_driver' => $driver->name ]);

        // $request->request->add(['jumlah_kejadian' => $id ]);

        $violation = \App\Models\Violation::create($request->all());

        //tambah foto
        if($request->hasFile('foto'))
        {
            $file_foto = time()."_".$request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('images/',$file_foto);
            $violation->foto = $file_foto;
            $violation->save();
        }

        return redirect('violation/'.$iddriver.'/index')->with('success', 'Data Pelanggaran Sopir Berhasil Dimasukkan');
    }

    public function edit($driverid, $violationid)
    {
        $title = "master_driver";
        $company = auth()->user()->company;
        $driver = \App\Models\Driver::find($driverid);
        $violation = \App\Models\violation::all();
        $truck = \App\Models\Truck::all();

        $violation = \App\Models\Violation::find($violationid);
        $jenis_pelanggaran = \App\Models\PelanggaranJenis::all()->where('status', 'Aktif');

        return view('master_driver.violation.edit', [
          'title' => $title,
          'company' => $company,
          'driver' => $driver,
          'truck' => $truck,
          'violation' => $violation,
          'violation' => $violation,
          'jenis_pelanggaran' => $jenis_pelanggaran
        ]);
    }

    public function update(Request $request, $driverid, $violationid)
    {       
        $messages = [
            'mimes' => '*upload dengan format jpg, jpeg, pdf!, silakan ulangi kembali pengisiannya',
            // 'min' => '*upload file minimal 1 mb !',
            'max' => '*upload file maksimal 4 mb!, silakan ulangi kembali pengisiannya',
        ];
 
        $this->validate($request,[
            'foto' => 'mimes:pdf,jpg,jpeg|file|max:4096',
        ],$messages);


        if (!isset($_POST['submit'])){
            $id = $_POST['id'];
            $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
            $bentuk_pelanggaran = $_POST['bentuk_pelanggaran'];
            $alasan = $_POST['alasan'];
            $kapan = $_POST['kapan'];
            $dimana = $_POST['dimana'];
            $police_no = $_POST['police_no'];

            $foto = $_FILES["foto"]["name"];
            $tmp_name_foto = $_FILES["foto"]["tmp_name"];

            // foto
            if (! empty($foto)) {
                move_uploaded_file($tmp_name_foto, "images/".time()."_".$foto);

                $query = "UPDATE VIOLATIONS SET foto ='".time()."_".$foto."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }

            $query = "UPDATE VIOLATIONS SET jenis_pelanggaran ='".$jenis_pelanggaran."', bentuk_pelanggaran ='".$bentuk_pelanggaran."', alasan ='".$alasan."', kapan ='".$kapan."', dimana ='".$dimana."', police_no ='".$police_no."' WHERE ID = '".$id."' ";

            $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
            $statement = oci_parse($koneksi,$query);

            $r = oci_execute($statement,OCI_DEFAULT);
            $res = oci_commit($koneksi);
        }

        return redirect ('violation/'.$driverid.'/index')->with('success', 'Data Pelanggaran Sopir Berhasil Diupdate');
    }

    public function delete($driverid, $violationid)
    {
        $company = auth()->user()->company;
        ////////////////////////////////////
        $driver = \App\Models\Driver::find($driverid);
        $violation = \App\Models\Violation::find($violationid);

        //memindahkan data violations ke data violations_history
        $violations_history = new \App\Models\Violation_history;

        $login = Auth::user()->owner_name;
        $violations_history->penghapus = $login;
        $violations_history->alasan_dihapus = 'Salah ketik';

        $violations_history->id = $violation->id;
        $violations_history->driver_id = $violation->driver_id;
        $violations_history->nama_perusahaan = $violation->nama_perusahaan;
        $violations_history->nama_driver = $violation->nama_driver;
        $violations_history->bentuk_pelanggaran = $violation->bentuk_pelanggaran;
        $violations_history->jenis_pelanggaran = $violation->jenis_pelanggaran;
        $violations_history->alasan = $violation->alasan;
        $violations_history->kapan = $violation->kapan;
        $violations_history->dimana = $violation->dimana;
        $violations_history->jumlah_kejadian = $violation->jumlah_kejadian;
        $violations_history->pelanggaran = $violation->pelanggaran;
        $violations_history->foto = $violation->foto;
        $violations_history->police_no = $violation->police_no;
        $violations_history->save();
        //////////////////////////////////////////////////

        $violation = \App\Models\Violation::find($violationid);
        $violation->delete($violation);

        return redirect('violation/'.$driverid.'/index')->with('success', 'Data Pelanggaran Sopir Berhasil Dihapus');
    }


    public function recycle_bin($id)
    {
        $title = "master_driver";
        $company = \App\Models\Company::find($id);
        $driver = \App\Models\Driver::find($id);
        $violations_history = \App\Models\Violation_history::all();

        return view('master_driver.violation.recycle_bin', [
            'title' => $title,
            'company' => $company,
            'driver' => $driver,
            'violations_history' => $violations_history,
        ]);
    }

    public function restore($driverid, $violationid)
    {
        $company = auth()->user()->company;
        ////////////////////////////////////
        $driver = \App\Models\Driver::find($driverid);
        $violations_history = \App\Models\Violation_history::find($violationid);
        //memindahkan data driver_history ke data driver
        $violation = new \App\Models\Violation;

        $violation->id = $violations_history->id;
        $violation->driver_id = $violations_history->driver_id;
        $violation->nama_perusahaan = $violations_history->nama_perusahaan;
        $violation->nama_driver = $violations_history->nama_driver;
        $violation->bentuk_pelanggaran = $violations_history->bentuk_pelanggaran;
        $violation->jenis_pelanggaran = $violations_history->jenis_pelanggaran;
        $violation->alasan = $violations_history->alasan;
        $violation->kapan = $violations_history->kapan;
        $violation->dimana = $violations_history->dimana;
        $violation->jumlah_kejadian = $violations_history->jumlah_kejadian;
        $violation->pelanggaran = $violations_history->pelanggaran;
        $violation->foto = $violations_history->foto;
        $violation->police_no = $violations_history->police_no;
        $violation->save();

        //////////////////////////////////////////////////
        $violations_history = \App\Models\Violation_history::find($violationid);
        $violations_history->delete($violations_history);      

        return redirect('violation/'.$driverid.'/recycle_bin')->with('success', 'Data Pelanggaran Sopir Berhasil Dipulihkan');
    }

    public function clear($id)
    {
        //cara php native
        $username ="DASHBOARD";
        $password ="123456";
        $database ="LOCALHOST/orcl";
        $koneksi=oci_connect ($username,$password,$database);
        $sql = "DELETE FROM VIOLATIONS_HISTORY";
        $parsesql = oci_parse($koneksi, $sql);
        $q = oci_execute($parsesql) or die(oci_error());

        // GAGAL
        // $driver_history = \App\Models\driver_history::all();
        // $driver_history->delete($driver_history);      

        return redirect('violation/'.$id.'/recycle_bin')->with('success', 'Data Pelanggaran Sopir Berhasil Dibersihkan');
    }


    public function rekapan_pelanggaran()
    {
        $title = "master_driver";
        $violations = \App\Models\Violation::orderBy('jenis_pelanggaran', 'DESC')
        ->get();

        return view('master_driver.violation.rekapan_pelanggaran', [
            'title' => $title,
            'violations' => $violations,
        ]);
    }




}
