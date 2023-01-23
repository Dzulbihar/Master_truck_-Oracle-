<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;
use App\Models\Company;
use App\Models\Truck;
use App\Models\Truck_history;
use App\Models\Chassis_code;
use App\Models\Chassis_parameter;
use App\Models\Merk;
use App\Models\Kota;
use PDF;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Email;

class TruckController extends Controller
{
    public function index($id)
    {
        $title = "truck";
        $company = \App\Models\Company::find($id);
        $trucks = \App\Models\Truck::where('company_id',$id)
        // ->where('status', 2)
        // ->whereIn('status',[0,1])
        ->orderBy('status', 'ASC')
        ->get();

        return view('truck.index', [
            'title' => $title,
            'company' => $company,
            'trucks' => $trucks
        ]);
    }

    public function add($id)
    {
        $title = "truck";
        $company = \App\Models\Company::find($id);
        $ms_chassis_code = \App\Models\Chassis_code::all()->where('status', 'Aktif');
        $merk_truck = \App\Models\Merk::all()->where('status', 'Aktif');
        $state_truck = \App\Models\Kota::all()->where('status', 'Aktif');

        $trucks = \App\Models\Truck::where('company_id',$id)
        // ->where('status', 2)
        // ->whereIn('status',[0,1])
        ->get();

        return view('truck.add', [
            'title' => $title,
            'ms_chassis_code' => $ms_chassis_code,
            'merk_truck' => $merk_truck,
            'state_truck' => $state_truck,
            'company' => $company,
            'trucks' => $trucks
        ]);
    }

    public function addtruck(Request $request ,$idcompany)
    {
        $messages = [
            'mimes' => 'Upload dengan format jpg, jpeg, pdf! dan silakan isi kembali datanya',
            // 'min' => '*upload file minimal 1 mb !',
            'max' => 'Upload file maksimal 4 mb! dan silakan isi kembali datanya',
            'unique' => 'Nomor polisi tidak boleh sama!  dan silakan isi kembali datanya',
        ];
         
        $this->validate($request,[
            'police_no' => ['required', 'max:255',Rule::unique('truck')->where('police_no', $request->police_no)],
            'machine_no' => ['required', 'max:255',Rule::unique('truck')->where('machine_no', $request->machine_no)],
            'design_no' => ['required', 'max:255',Rule::unique('truck')->where('design_no', $request->design_no)],            
            'foto_stnk' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_truck' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_kir_truck' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_chassis' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_kir_chassis' => 'mimes:pdf,jpg,jpeg|file|max:4096',
        ],$messages);

        $company = \App\Models\Company::find($idcompany);

        $request->request->add(['company_id' => $company->id ]);
        $request->request->add(['owner_name' => $company->owner_name ]);
        $request->request->add(['pic_nama' => $company->pic_nama ]);
        $request->request->add(['email' => $company->email ]);

        $request->request->add(['status' => 'Proses Pengajuan' ]);
        $request->request->add(['tanggal_pengajuan' => Carbon::now() ]);

        $truck = \App\Models\Truck::create($request->all());

        //tambah foto_stnk
        if($request->hasFile('foto_stnk'))
        {
            $file_foto_stnk = time()."_".$request->file('foto_stnk')->getClientOriginalName();
            $request->file('foto_stnk')->move('images/',$file_foto_stnk);
            $truck->foto_stnk = $file_foto_stnk;
            $truck->save();
        }

        //tambah foto_truck
        if($request->hasFile('foto_truck'))
        {
            $file_foto_truck = time()."_".$request->file('foto_truck')->getClientOriginalName();
            $request->file('foto_truck')->move('images/',$file_foto_truck);
            $truck->foto_truck = $file_foto_truck;
            $truck->save();
        }

        //tambah foto_kir_truck
        if($request->hasFile('foto_kir_truck'))
        {
            $file_foto_kir_truck = time()."_".$request->file('foto_kir_truck')->getClientOriginalName();
            $request->file('foto_kir_truck')->move('images/',$file_foto_kir_truck);
            $truck->foto_kir_truck = $file_foto_kir_truck;
            $truck->save();
        }

        //tambah foto_chassis
        if($request->hasFile('foto_chassis'))
        {
            $file_foto_chassis = time()."_".$request->file('foto_chassis')->getClientOriginalName();
            $request->file('foto_chassis')->move('images/',$file_foto_chassis);
            $truck->foto_chassis = $file_foto_chassis;
            $truck->save();
        }

        //tambah foto_kir_chassis
        if($request->hasFile('foto_kir_chassis'))
        {
            $file_foto_kir_chassis = time()."_".$request->file('foto_kir_chassis')->getClientOriginalName();
            $request->file('foto_kir_chassis')->move('images/',$file_foto_kir_chassis);
            $truck->foto_kir_chassis = $file_foto_kir_chassis;
            $truck->save();
        }        

        $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
        $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
        oci_execute($emails);

        while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
        {
            $subjek= $email['SUBJEK_TRUCK_DAFTAR'];
            $header= $email['HEADER_TRUCK_DAFTAR'];
            $body_1= $email['BODY_1_TRUCK_DAFTAR'];
            $body_2= $email['BODY_2_TRUCK_DAFTAR'];
            $footer= $email['FOOTER_TRUCK_DAFTAR'];
            $alamat= $email['ALAMAT_EMAIL_ADMIN'];
        }

        //Siapkan data
        $pengirim = Auth::user()->owner_name;
        $subjek_truck_daftar = $subjek;
        $header_truck_daftar = $header;
        $body_1_truck_daftar = $body_1;
        $body_2_truck_daftar = $body_2;
        $footer_truck_daftar = $footer;
        $alamat_email_admin = $alamat;
        
        $data = array(
            'header_truck_daftar' => $header,
            'body_1_truck_daftar' => $body_1,
            'body_2_truck_daftar' => $body_2,
            'footer_truck_daftar' => $footer,
        );

        Mail::send('emails.truck_daftar', $data, function($mail) use($subjek_truck_daftar, $alamat_email_admin, $pengirim ){
            $mail->to($alamat_email_admin, 'no-reply')
                ->subject($subjek_truck_daftar, 'no-reply');
            $mail->from($alamat_email_admin, $pengirim );
        });

        //\Mail::to('ahmad.dzulbihar69@gmail.com')->send(new \App\Mail\truckDaftar());

        return redirect('truck/'.$idcompany.'/index')->with('success', 'Pendaftaran RFID Truck Trailer berhasil! Pengajuan Anda sedang kami proses. Silakan menunggu persetujuan dari Admin HSSE melalui notifikasi email!');
    }

    public function edit_data($companyid, $truckid)
    {
        $title = "truck";
        $company = auth()->user()->company;
        $truck = \App\Models\Truck::find($truckid);

        $ms_chassis_code = \App\Models\Chassis_code::all()->where('status', 'Aktif');
        $merk_truck = \App\Models\Merk::all()->where('status', 'Aktif');
        $state_truck = \App\Models\Kota::all()->where('status', 'Aktif');

        return view('truck.edit_data', [
          'title' => $title,
          'company' => $company,
          'truck' => $truck,
          'ms_chassis_code' => $ms_chassis_code,
          'merk_truck' => $merk_truck,
          'state_truck' => $state_truck
        ]);
    }

    public function edit_file($companyid, $truckid)
    {
        $title = "truck";
        $company = auth()->user()->company;
        $truck = \App\Models\Truck::find($truckid);

        return view('truck.edit_file', [
          'title' => $title,
          'company' => $company,
          'truck' => $truck
        ]);
    }

    public function update_data(Request $request, $companyid, $truckid)
    {       
        $truck = \App\Models\Truck::find($truckid);
        $truck->update($request->all());

        return redirect ('truck/'.$companyid.'/'.$truckid.'/detail')->with('success', 'Data Truck Berhasil Diupdate');
    }

    public function update_file(Request $request, $companyid, $truckid)
    {       
        $company = auth()->user()->company;
        $truck = \App\Models\Truck::find($truckid);

        $messages = [
            'mimes' => 'Upload dengan format jpg, jpeg, pdf! dan silakan isi kembali datanya',
            'max' => 'Upload file maksimal 4 mb!  dan silakan isi kembali datanya',
        ];
         
        $this->validate($request,[
            'foto_stnk' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_truck' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_kir_truck' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_chassis' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'foto_kir_chassis' => 'mimes:pdf,jpg,jpeg|file|max:4096',
        ],$messages);

        if (!isset($_POST['submit'])){
            $id = $_POST['id'];

            $foto_stnk = $_FILES["foto_stnk"]["name"];
            $tmp_name_foto_stnk = $_FILES["foto_stnk"]["tmp_name"];
            $foto_truck = $_FILES["foto_truck"]["name"];
            $tmp_name_foto_truck = $_FILES["foto_truck"]["tmp_name"];
            $foto_kir_truck = $_FILES["foto_kir_truck"]["name"];
            $tmp_name_foto_kir_truck = $_FILES["foto_kir_truck"]["tmp_name"];
            $foto_chassis = $_FILES["foto_chassis"]["name"];
            $tmp_name_foto_chassis = $_FILES["foto_chassis"]["tmp_name"];
            $foto_kir_chassis = $_FILES["foto_kir_chassis"]["name"];
            $tmp_name_foto_kir_chassis = $_FILES["foto_kir_chassis"]["tmp_name"];

            // foto_stnk
            if (! empty($foto_stnk)) {
                move_uploaded_file($tmp_name_foto_stnk, "images/".time()."_".$foto_stnk);

                $query = "UPDATE TRUCK SET foto_stnk ='".time()."_".$foto_stnk."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }
            // foto_truck
            if (! empty($foto_truck)) {
                move_uploaded_file($tmp_name_foto_truck, "images/".time()."_".$foto_truck);

                $query = "UPDATE TRUCK SET foto_truck ='".time()."_".$foto_truck."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }
            // foto_kir_truck
            if (! empty($foto_kir_truck)) {
                move_uploaded_file($tmp_name_foto_kir_truck, "images/".time()."_".$foto_kir_truck);

                $query = "UPDATE TRUCK SET foto_kir_truck ='".time()."_".$foto_kir_truck."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }
            // foto_chassis
            if (! empty($foto_chassis)) {
                move_uploaded_file($tmp_name_foto_chassis, "images/".time()."_".$foto_chassis);

                $query = "UPDATE TRUCK SET foto_chassis ='".time()."_".$foto_chassis."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }
            // foto_kir_chassis
            if (! empty($foto_kir_chassis)) {
                move_uploaded_file($tmp_name_foto_kir_chassis, "images/".time()."_".$foto_kir_chassis);

                $query = "UPDATE TRUCK SET foto_kir_chassis ='".time()."_".$foto_kir_chassis."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }

        }

        return redirect ('truck/'.$companyid.'/'.$truckid.'/detail')->with('success', 'Data Truck Berhasil Diupdate');
    }

    public function detail($companyid, $truckid)
    {
        $title = "truck";
        $company = auth()->user()->company;
        $truck = \App\Models\Truck::find($truckid);
        $email = \App\Models\Email::all()->where('id', 1);

        return view('truck.detail', 
            [
                'title' => $title,
                'company' => $company,
                'truck' => $truck,
                'email' => $email,
            ]);
    }

    public function delete(Request $request, $companyid, $truckid)
    {
        $company = auth()->user()->company;
        ////////////////////////////////////
        $truck = \App\Models\Truck::find($truckid);
        //memindahkan data truck ke data truck_history
        $truck_history = new \App\Models\Truck_history;

        $login = Auth::user()->owner_name;
        $truck_history->penghapus = $login;
        $truck_history->alasan_dihapus = 'Dihapus User';

        $truck_history->id = $truck->id;
        $truck_history->company_id = $truck->company_id;
        $truck_history->status = $truck->status;
        $truck_history->owner_name = $truck->owner_name;
        $truck_history->pic_nama = $truck->pic_nama;
        $truck_history->email = $truck->email;
        $truck_history->police_no = $truck->police_no;
        $truck_history->stnk_no = $truck->stnk_no;
        $truck_history->machine_no = $truck->machine_no;
        $truck_history->design_no = $truck->design_no;
        $truck_history->expired_lisence = $truck->expired_lisence;
        $truck_history->foto_stnk = $truck->foto_stnk;
        $truck_history->trade_mark = $truck->trade_mark;
        $truck_history->year_made = $truck->year_made;
        $truck_history->state = $truck->state;
        $truck_history->truck_weight = $truck->truck_weight;
        $truck_history->foto_truck = $truck->foto_truck;
        $truck_history->foto_kir_truck = $truck->foto_kir_truck;

        $truck_history->chassis_code = $truck->chassis_code;
        $truck_history->jenis_chassis = $truck->jenis_chassis;
        $truck_history->chassis_weight = $truck->chassis_weight;
        $truck_history->foto_chassis = $truck->foto_chassis;
        $truck_history->foto_kir_chassis = $truck->foto_kir_chassis;

        $truck_history->id_customer = $truck->id_customer;
        $truck_history->customer = $truck->customer;
        $truck_history->site_id = $truck->site_id;
        $truck_history->truck_code = $truck->truck_code;
        $truck_history->upd_ts = $truck->upd_ts;
        $truck_history->opername = $truck->opername;
        $truck_history->gate_no = $truck->gate_no;
        $truck_history->total_weiht_ht_ch = $truck->total_weiht_ht_ch;
        $truck_history->bbg_yn = $truck->bbg_yn;
        $truck_history->otl_yn = $truck->otl_yn;
        $truck_history->id_rfid = $truck->id_rfid;

        $truck_history->alasan_blokir = $truck->alasan_blokir;
        $truck_history->tanggal_blokir = $truck->tanggal_blokir;
        $truck_history->nama_blokir = $truck->nama_blokir;

        $truck_history->tanggal_pengajuan = $truck->tanggal_pengajuan;
        $truck_history->tanggal_setujui = $truck->tanggal_setujui;
        $truck_history->nama_setujui = $truck->nama_setujui;
        $truck_history->save();
        //////////////////////////////////////////////////

        $truck = \App\Models\Truck::find($truckid);
        $truck->delete($truck);

        return redirect('truck/'.$companyid.'/index')->with('success', 'Data Truck Berhasil Dihapus');
    }


    public function cetak_rfid($id)
    {
        $truck = \App\Models\Truck::find($id);
 
        $pdf = PDF::loadview('master_truck.rfid_truck',['truck'=>$truck])
        ->setPaper('a7', 'landscape')
        ;
        return $pdf->stream();
        // return $pdf->download('laporan-truck-pdf');
    }

    public function cetak_data_truck($id)
    {
        $truck = \App\Models\Truck::find($id);
        $truck->tanggal = Carbon::now()->isoFormat('D MMMM Y');
        $pdf = PDF::loadview('master_truck.cetak_data_truck',[
            'truck'=>$truck
        ])
        // ->setPaper('a7', 'patroit')
        ;
        return $pdf->stream();
        // return $pdf->download('laporan-truck-pdf');
    }


    public function pergantian_rfid(Request $request, $id)
    {
        $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
        $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
        oci_execute($emails);

        while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
        {
            $alamat= $email['ALAMAT_EMAIL_ADMIN'];
        }

        //Siapkan data
        $alamat_email_admin = $alamat;
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $isi = $request->isi;
        $file = $request->file;
        
        $data = array(
            'name' => $name,
            'subject' => $subject,
            'isi' => $isi,
            'file' => $file
        );

        Mail::send('truck.pergantian_rfid', $data, function($mail) use($subject, $alamat_email_admin, $email, $name ){
            $mail->to($alamat_email_admin, 'no-reply')
                ->subject($subject, 'no-reply');
            $mail->from($email, $name );
        });

        return redirect('truck/'.$id.'/index')->with('success', 'Email berhasil terkirim!');
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function tulis_pesan($id)
    {
        $title = "truck";
        $company = auth()->user()->company;
        $truck = \App\Models\Truck::find($id);

        return view('truck.tulis_pesan', 
            [
                'title' => $title,
                'company' => $company,
                'truck' => $truck
            ]);
    }

    public function kirim_pesan(Request $request, $id)
    {
        $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
        $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
        oci_execute($emails);

        while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
        {
            $alamat= $email['ALAMAT_EMAIL_ADMIN'];
        }

        //Siapkan data
        $alamat_email_admin = $alamat;
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $isi = $request->isi;
        
        $data = array(
            'name' => $name,
            'subject' => $subject,
            'isi' => $isi
        );

        Mail::send('truck.tulis_pesan_kirim', $data, function($mail) use($subject, $alamat_email_admin, $email, $name ){
            $mail->to($alamat_email_admin, 'no-reply')
                ->subject($subject, 'no-reply');
            $mail->from($email, $name );
        });

        return redirect('truck/'.$id.'/index')->with('success', 'Email berhasil terkirim!');
    }

}
