<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Doctor;

class NewDoctorNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $doctor, $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor, string $password)
    {
        $this->doctor = $doctor;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.new-doctor')
            ->with('name_arabic', $this->doctor->name_arabic)
            ->with('name_english',$this->doctor->name_english)
            ->with('mobile',$this->doctor->mobile)
            ->with('password',$this->password)
            ->subject('New Account');
    }
}
