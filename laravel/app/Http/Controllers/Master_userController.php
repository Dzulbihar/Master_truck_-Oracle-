<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Company;
use App\Models\Email;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class Master_userController extends Controller
{
    public function index()
    {
        $title = "master_user";
    	$users = \App\Models\User::
        // ->where('role', 'user')
        orderBy('role', 'ASC')
        ->get();
        $company = \App\Models\Company::all();

    	return view('master_user.index',
            [
            'title' => $title,
            'users' => $users,
            'company' => $company
        ]);
    }

    public function cari(Request $request)
    {
        $title = "master_user";
        // menangkap data pencarian
        $cari = $request->cari;

        // mengambil data dari table pegawai sesuai pencarian data
        $users = DB::table('users')
        // ->where('ROLE','user')
        ->where('STATUS',$cari)
        ->orderBy('role', 'ASC')
        ->get();
        // ->paginate();

        // mengirim data pegawai ke view index
        return view('master_user.index',
            [
            'users' => $users,
            'title' => $title
        ]);
    }

    public function add()
    {
        $title = "master_user";
        $user = \App\Models\User::all();
        $company = \App\Models\Company::all();

        return view('master_user.add',
            [
            'title' => $title,
            'user' => $user,
            'company' => $company, 
        ]);
    }

    public function create(Request $request)
    {
        $password = $request->password;
        // Validasi kekuatan password
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
         
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {

            return redirect ('/master_user/add')->with('success', 'Pasword setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka, dan spesial karakter.');

        }else{
            
            if ($_POST['password']==$_POST['password2'] ) {

                $messages = [
                    'required' => '*kolom wajib diisi ya!!!',
                    'mimes' => '*upload dengan format jpg, jpeg, pdf!',
                    // 'min' => '*upload file minimal 1 mb !',
                    'max' => '*upload file maksimal 4 mb!',
                    'unique' => 'Email sudah terdaftar! silakan ulangi pendaftaran',
                    // 'alpha' => '*kolom hanya boleh disi huruf ya!!!',
                    // 'numeric' => '*kolom hanya boleh disi angka ya!!!',
                    // 'email' => '*kolom hanya boleh disi email ya!!!',
                ];
         
                $this->validate($request,[
                    'email' => ['required', 'max:255',Rule::unique('users')->where('email', $request->email)],
                    'file_nib_company' => 'mimes:pdf,jpg,jpeg|file|max:4096',
                    'file_npwp_company' => 'mimes:pdf,jpg,jpeg|file|max:4096',
                    'file_pmku_company' => 'mimes:pdf,jpg,jpeg|file|max:4096',
                    // 'email' => 'required|email|min:5|max:30',
                    'statement_form' => 'mimes:pdf,jpg,jpeg|file|max:4096',
                ],$messages);

                //input pendaftaran sebagai user dulu
                $user = new \App\Models\User;
                $user->role = $request->role;
                $user->owner_name = $request->owner_name;
                $user->status = 'Aktif';
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->password2 = bcrypt($request->password2);
                $user->tgl_pengajuan = Carbon::now();
               // $user->remember_token = str_random(60);
                $user->save();
            
                //insert ke tabel company
                $request->request->add(['id' => $user->id ]);
                $request->request->add(['user_id' => $user->id ]);
                $request->request->add(['owner_name' => $user->owner_name ]);
                $request->request->add(['email' => $user->email ]);

                $company = \App\Models\Company::create($request->all());

                // Mail::to('ahmad.dzulbihar69@gmail.com')->send(new userDaftar());

                return redirect ('/master_user')->with('success', 'Data Pendaftaran Berhasil Dikirim');

            }else {
                return redirect ('/master_user/add')->with('success', 'Password yang Anda Masukan Tidak Sama! Silakan ulangi kembali!');
            }
        }
    }

    public function edit($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);
        $company = \App\Models\Company::find($id);

        return view('master_user.edit', [
            'title' => $title,
            'user' => $user,
        ]);
    }

    public function update(Request $request ,$id)
    {       
        $user = \App\Models\User::find($id);
        $user->update($request->all());

        return redirect ('/master_user')->with('success', 'Data User Berhasil Diupdate');
    }

    public function status($id)
    {
        $emails = \App\Models\Email::all();

        //lihat data
        $user = \DB::table('users')->where('id',$id)->first();
        //lihat status sekarang
        $status_sekarang = $user->status;
        //kondisi
        if($status_sekarang == 'Tidak Aktif'){
            \DB::table('users')->where('id',$id)->update([
                'status'=>'Aktif'
            ]);
            \DB::table('users')->where('id',$id)->update([
                'tgl_disetujui'=>Carbon::now(),'disetujui_oleh'=>Auth::user()->owner_name
            ]);

            //////////////////////////////////////////////////////////////
            $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
            $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
            oci_execute($emails);
            while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
            {
                $subjek= $email['SUBJEK_USER_AKTIF'];
                $header= $email['HEADER_USER_AKTIF'];
                $body_1= $email['BODY_1_USER_AKTIF'];
                $body_2= $email['BODY_2_USER_AKTIF'];
                $footer= $email['FOOTER_USER_AKTIF'];
                $pengirim= $email['NAMA_PENGIRIM_ADMIN'];
            }
            //Siapkan data
            $subjek_user_aktif = $subjek;
            $header_user_aktif = $header;
            $body_1_user_aktif = $body_1;
            $body_2_user_aktif = $body_2;
            $footer_user_aktif = $footer;
            $nama_pengirim_admin = $pengirim;
            $data = array(
                'header_user_aktif' => $header,
                'body_1_user_aktif' => $body_1,
                'body_2_user_aktif' => $body_2,
                'footer_user_aktif' => $footer,
            );

            $user = \App\Models\User::find($id);
            Mail::send('emails.user_aktif', $data, function($mail) use($subjek_user_aktif, $user, $nama_pengirim_admin ){
                $mail->to($user->email, 'no-reply')
                    ->subject($subjek_user_aktif, 'no-reply');
                $mail->from($user->email, $nama_pengirim_admin );
            });
            //////////////////////////////////////////////////////////////
            // $user = \App\Models\User::find($id);
            // \Mail::to($user->email)->send(new \App\Mail\userAktif());

            return redirect('master_user/'.$id.'/detail')->with('success', ' Akun User Berhasil Diaktifkan');

        }elseif($status_sekarang == 'Aktif'){
            \DB::table('users')->where('id',$id)->update([
                'status'=>'Tidak Aktif'
            ]);
            \DB::table('users')->where('id',$id)->update([
                'tgl_disetujui'=>'','disetujui_oleh'=>''
            ]);

            //////////////////////////////////////////////////////////////
            $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
            $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
            oci_execute($emails);
            while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
            {
                $subjek= $email['SUBJEK_USER_TIDAK_AKTIF'];
                $header= $email['HEADER_USER_TIDAK_AKTIF'];
                $body_1= $email['BODY_1_USER_TIDAK_AKTIF'];
                $body_2= $email['BODY_2_USER_TIDAK_AKTIF'];
                $footer= $email['FOOTER_USER_TIDAK_AKTIF'];
                $pengirim= $email['NAMA_PENGIRIM_ADMIN'];
            }
            //Siapkan data
            $subjek_user_tidak_aktif = $subjek;
            $header_user_tidak_aktif = $header;
            $body_1_user_tidak_aktif = $body_1;
            $body_2_user_tidak_aktif = $body_2;
            $footer_user_tidak_aktif = $footer;
            $nama_pengirim_admin = $pengirim;
            $data = array(
                'header_user_tidak_aktif' => $header,
                'body_1_user_tidak_aktif' => $body_1,
                'body_2_user_tidak_aktif' => $body_2,
                'footer_user_tidak_aktif' => $footer,
            );

            $user = \App\Models\User::find($id);
            Mail::send('emails.user_tidak_aktif', $data, function($mail) use($subjek_user_tidak_aktif, $user, $nama_pengirim_admin ){
                $mail->to($user->email, 'no-reply')
                    ->subject($subjek_user_tidak_aktif, 'no-reply');
                $mail->from($user->email, $nama_pengirim_admin );
            });
            //////////////////////////////////////////////////////////////
            // $user = \App\Models\User::find($id);
            // \Mail::to($user->email)->send(new \App\Mail\userTidakAktif());

            return redirect('master_user/'.$id.'/detail')->with('success', ' Akun User Batal Diaktifkan');

        }elseif($status_sekarang == 'Blokir'){
            \DB::table('users')->where('id',$id)->update([
                'status'=>'Aktif'
            ]);
            \DB::table('users')->where('id',$id)->update([
                'alasan_blokir'=>''
            ]);

            //////////////////////////////////////////////////////////////
            $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
            $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
            oci_execute($emails);
            while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
            {
                $subjek= $email['SUBJEK_USER_UNBLOCK'];
                $header= $email['HEADER_USER_UNBLOCK'];
                $body_1= $email['BODY_1_USER_UNBLOCK'];
                $body_2= $email['BODY_2_USER_UNBLOCK'];
                $footer= $email['FOOTER_USER_UNBLOCK'];
                $pengirim= $email['NAMA_PENGIRIM_ADMIN'];
            }
            //Siapkan data
            $subjek_user_unblock = $subjek;
            $header_user_unblock = $header;
            $body_1_user_unblock = $body_1;
            $body_2_user_unblock = $body_2;
            $footer_user_unblock = $footer;
            $nama_pengirim_admin = $pengirim;
            $data = array(
                'header_user_unblock' => $header,
                'body_1_user_unblock' => $body_1,
                'body_2_user_unblock' => $body_2,
                'footer_user_unblock' => $footer,
            );

            $user = \App\Models\User::find($id);
            Mail::send('emails.user_tidak_blokir', $data, function($mail) use($subjek_user_unblock, $user, $nama_pengirim_admin ){
                $mail->to($user->email, 'no-reply')
                    ->subject($subjek_user_unblock, 'no-reply');
                $mail->from($user->email, $nama_pengirim_admin );
            });
            //////////////////////////////////////////////////////////////
            // $user = \App\Models\User::find($id);
            // \Mail::to($user->email)->send(new \App\Mail\userUnblock());

            return redirect('master_user/'.$id.'/detail')->with('success', ' Akun User Berhasil Diaktifkan kembali');
        }
        // \Session::flash('success','Status berhasil di update');
        
    }

    public function edit_blokir($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);

        return view('master_user.edit_blokir', [
            'title' => $title,
            'user' => $user
        ]);
    }

    public function update_blokir(Request $request ,$id)
    {       
        $user = \App\Models\User::find($id);
        $user->update($request->all());

        //lihat data
        $user = \DB::table('users')->where('id',$id)->first();
        //lihat status sekarang
        $status_sekarang = $user->status;
        //kondisi
        if($status_sekarang == 'Aktif'){
            \DB::table('users')->where('id',$id)->update([
                'status'=>'Blokir'
            ]);

            //////////////////////////////////////////////////////////////
            $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");
            $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
            oci_execute($emails);
            while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
            {
                $subjek= $email['SUBJEK_USER_BLOCK'];
                $header= $email['HEADER_USER_BLOCK'];
                $body_1= $email['BODY_1_USER_BLOCK'];
                $body_2= $email['BODY_2_USER_BLOCK'];
                $footer= $email['FOOTER_USER_BLOCK'];
                $pengirim= $email['NAMA_PENGIRIM_ADMIN'];
            }
            //Siapkan data
            $subjek_user_block = $subjek;
            $header_user_block = $header;
            $body_1_user_block = $body_1;
            $body_2_user_block = $body_2;
            $footer_user_block = $footer;
            $nama_pengirim_admin = $pengirim;
            $data = array(
                'header_user_block' => $header,
                'body_1_user_block' => $body_1,
                'body_2_user_block' => $body_2,
                'footer_user_block' => $footer,
            );

            $user = \App\Models\User::find($id);
            Mail::send('emails.user_blokir', $data, function($mail) use($subjek_user_block, $user, $nama_pengirim_admin ){
                $mail->to($user->email, 'no-reply')
                    ->subject($subjek_user_block, 'no-reply');
                $mail->from($user->email, $nama_pengirim_admin );
            });
            //////////////////////////////////////////////////////////////
            // $user = \App\Models\User::find($id);
            // \Mail::to($user->email)->send(new \App\Mail\userBlock());

        }

        return redirect ('master_user/'.$id.'/detail')->with('success', 'Akun User Berhasil Diblokir');
    }

    public function delete($id)
    {
        $User = \App\Models\User::find($id);
        $User->delete($User);

        return redirect('/master_user')->with('success', 'Data User berhasil dihapus');
    }

//////////////////////////////////////////////////////////


    public function detail($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);
        $company = \App\Models\Company::find($id);
        
        return view('master_user.detail', [
            'title' => $title,
            'user' => $user,
            'company' => $company
        ]);
    }

    public function detail_edit($id)
    {
        $title = "master_user";
        $company = \App\Models\Company::find($id);

        return view('master_user.detail_edit', [
            'title' => $title,
            'company' => $company
        ]);
    }

    public function detail_update(Request $request ,$id)
    {       
        $messages = [
            'mimes' => '*upload dengan format jpg, jpeg, pdf!',
            'max' => '*upload file maksimal 4 mb!',
        ];
 
        $this->validate($request,[
            'file_nib_company' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'file_npwp_company' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'file_pmku_company' => 'mimes:pdf,jpg,jpeg|file|max:4096',
            'statement_form' => 'mimes:pdf,jpg,jpeg|file|max:4096',
        ],$messages);

        if (isset($_POST["hasil"])){
            $owner_name = $_POST['owner_name'];
            $contact = $_POST['contact'];
            $addr_company = $_POST['addr_company'];
            $nib_company = $_POST['nib_company'];
            $npwp_company = $_POST['npwp_company'];
            $pmku_company = $_POST['pmku_company'];
            $pic_nama = $_POST['pic_nama'];
            $pic_contact = $_POST['pic_contact'];

            $file_nib_company = $_FILES["file_nib_company"]["name"];
            $tmp_name_file_nib_company = $_FILES["file_nib_company"]["tmp_name"];
            $file_npwp_company = $_FILES["file_npwp_company"]["name"];
            $tmp_name_file_npwp_company = $_FILES["file_npwp_company"]["tmp_name"];
            $file_pmku_company = $_FILES["file_pmku_company"]["name"];
            $tmp_name_file_pmku_company = $_FILES["file_pmku_company"]["tmp_name"];
            $statement_form = $_FILES["statement_form"]["name"];
            $tmp_name_statement_form = $_FILES["statement_form"]["tmp_name"];

            // file_nib_company
            if (! empty($file_nib_company)) {
                move_uploaded_file($tmp_name_file_nib_company, "images/".time()."_".$file_nib_company);

                $query = "UPDATE COMPANY SET file_nib_company ='".time()."_".$file_nib_company."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }

            // file_npwp_company
            if (! empty($file_npwp_company)) {
                move_uploaded_file($tmp_name_file_npwp_company, "images/".time()."_".$file_npwp_company);
                
                $query = "UPDATE COMPANY SET file_npwp_company ='".time()."_".$file_npwp_company."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }

            // file_pmku_company
            if (! empty($file_pmku_company)) {
                move_uploaded_file($tmp_name_file_pmku_company, "images/".time()."_".$file_pmku_company);
                
                $query = "UPDATE COMPANY SET file_pmku_company ='".time()."_".$file_pmku_company."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }

            // statement_form
            if (! empty($statement_form)) {
                move_uploaded_file($tmp_name_statement_form, "images/".time()."_".$statement_form);
                
                $query = "UPDATE COMPANY SET statement_form ='".time()."_".$statement_form."' WHERE ID = '".$id."' ";
                $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
                $statement = oci_parse($koneksi,$query);
                $r = oci_execute($statement,OCI_DEFAULT);
                $res = oci_commit($koneksi);
            }                        

            $query = "UPDATE COMPANY SET owner_name ='".$owner_name."', contact ='".$contact."', addr_company ='".$addr_company."', nib_company ='".$nib_company."', npwp_company ='".$npwp_company."', pmku_company ='".$pmku_company."', pic_nama ='".$pic_nama."', pic_contact ='".$pic_contact."' WHERE ID = '".$id."' ";

            $koneksi=oci_connect ("DASHBOARD","123456","LOCALHOST/orcl");
            $statement = oci_parse($koneksi,$query);

            $r = oci_execute($statement,OCI_DEFAULT);
            $res = oci_commit($koneksi);
        }

        return redirect ('master_user/'.$id.'/detail')->with('success', 'Data berhasil diupdate');
    }

////////////////////////////////////////////////////////////

    public function foto_nib_perusahaan($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);
        $company = \App\Models\Company::find($id);
        
        return view('master_user.foto_nib_perusahaan', [
            'title' => $title,
            'user' => $user,
            'company' => $company
        ]);
    }

    public function foto_npwp_perusahaan($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);
        $company = \App\Models\Company::find($id);
        
        return view('master_user.foto_npwp_perusahaan', [
            'title' => $title,
            'user' => $user,
            'company' => $company
        ]);
    }

    public function form_pernyataan($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);
        $company = \App\Models\Company::find($id);
        
        return view('master_user.form_pernyataan', [
            'title' => $title,
            'user' => $user,
            'company' => $company
        ]);
    }

    public function file_pmku_company($id)
    {
        $title = "master_user";
        $user = \App\Models\User::find($id);
        $company = \App\Models\Company::find($id);
        
        return view('master_user.file_pmku_company', [
            'title' => $title,
            'user' => $user,
            'company' => $company
        ]);
    }

}
