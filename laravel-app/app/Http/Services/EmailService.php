<?php

namespace App\Http\Services;

use Mail;
use Illuminate\Mail\Mailable;

class EmailService
{
    public function __construct()
    {
    }

    public function sendEmail(Mailable $mailable,string $email)
    {
        Mail::to($email)->send($mailable);
    }
}
