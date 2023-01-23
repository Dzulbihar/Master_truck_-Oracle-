<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Email;

class driverUnblock extends Mailable
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

        return $this->subject('RFID Driver Eksternal Anda kami aktifkan kembali')
                    ->view('emails.driver_unblock', [
            'emails' => $emails
        ]);
    }
}
