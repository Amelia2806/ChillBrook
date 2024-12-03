<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public function __construct(array $data) //menginisialisasi object yang digunakan pada template email
    {
        $this->data = $data;
    }
    public function build()//mengatur struktur email yang lebih spesifik
    {
        // dd('aaa');
        return $this->subject($this->data['subject'])
                    ->view('emails.sendemail');
    }
}
