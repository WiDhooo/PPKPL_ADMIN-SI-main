<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SantriRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct($pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Ditolak')
                    ->view('emails.santri_rejected');
    }
}
