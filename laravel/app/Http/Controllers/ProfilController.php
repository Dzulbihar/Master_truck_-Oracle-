<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Mail\userDaftar;
use Illuminate\Support\Facades\Mail;
use Auth;

class ProfilController extends Controller
{

    public function profilperusahaan() 
    {
        $title = "profilperusahaan";
        $company = auth()->user()->company;
        return view('profil.profilperusahaan', compact(['company','title']));
    }

    public function edit($id)
    {
        $title = "profilperusahaan";
        $company = \App\Models\Company::find($id);

        return view('profil.profilperusahaan_edit', [
            'title' => $title,
        	'company' => $company
        ]);
    }

    public function update(Request $request ,$id)
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

        return redirect ('/home')->with('success', 'Data berhasil diupdate');
    }

    public function approver_admin()
    {
        $koneksi=oci_connect ("dashboard","123456","LOCALHOST/orcl");

        $emails = oci_parse($koneksi, "SELECT * FROM MS_EMAIL WHERE ID='1'");
        oci_execute($emails);

        while(($email = oci_fetch_array($emails, OCI_BOTH)) != false)
        {
            $subjek= $email['SUBJEK_USER_DAFTAR'];
            $header= $email['HEADER_USER_DAFTAR'];
            $body_1= $email['BODY_1_USER_DAFTAR'];
            $body_2= $email['BODY_2_USER_DAFTAR'];
            $footer= $email['FOOTER_USER_DAFTAR'];
            $alamat= $email['ALAMAT_EMAIL_ADMIN'];
        }

        //Siapkan data
        $pengirim = Auth::user()->owner_name;;
        $subjek_user_daftar = $subjek;
        $header_user_daftar = $header;
        $body_1_user_daftar = $body_1;
        $body_2_user_daftar = $body_2;
        $footer_user_daftar = $footer;
        $alamat_email_admin = $alamat;
        
        $data = array(
            'header_user_daftar' => $header,
            'body_1_user_daftar' => $body_1,
            'body_2_user_daftar' => $body_2,
            'footer_user_daftar' => $footer,
        );

        Mail::send('emails.user_daftar', $data, function($mail) use($subjek_user_daftar, $alamat_email_admin, $pengirim ){
            $mail->to($alamat_email_admin, 'no-reply')
                ->subject($subjek_user_daftar, 'no-reply');
            $mail->from($alamat_email_admin, $pengirim );
        });

        // \Mail::to('ahmad.dzulbihar69@gmail.com')->send(new userDaftar());

        return redirect ('/home')->with('success', 'Data Profil Anda Berhasil Dikirim! Pengajuan Anda sedang kami proses. Silakan menunggu persetujuan dari Admin HSSE melalui notifikasi email!');

    }

}
