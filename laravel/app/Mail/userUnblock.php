<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Email;

class userUnblock extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emails = \App\Models\Email::all();

        return $this->subject('Status Akun User Diaktifkan kembali')
                    ->view('emails.user_tidak_blokir', [
            'emails' => $emails
        ]);
    }
}
