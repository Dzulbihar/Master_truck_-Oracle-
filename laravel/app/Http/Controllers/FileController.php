<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

	public function tamplate(Request $request)
	{
		if(Storage::disk('local')->exists("pdf/$request->file")){
			$path = Storage::disk('local')->path("pdf/$request->file");
			$content = file_get_contents($path);
			return response($content)->withHeaders([
				'Content-Type' => mime_content_type($path)
			]);
		}
		return redirect('/404');
	}

    //fungsi mengirim email
    public function sendEmail(Request $request){
        //siapkan data
        $email = $request->email;
        $data = array(
        	'subject' => $request->name,
            'name' => $request->name,
            'email_body' => $request->email_body
        );

        //kirim email
        Mail::send('email_template', $data, function($mail) use($email){
            $mail->to($email, $email)
                ->subject($subject);
            $mail->from('ahmaddzulbihar69@gmail.com','Testing');
        });

        //cek kegagalan
        if (Mail::failures()){
        	return redirect('/to_email')->with('success', 'Gagal mengirim Email');
        }
        return redirect('/to_email')->with('success', 'Email berhasil dikirim');
        // return " Email berhasil dikirim";
    }

}
