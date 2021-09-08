<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\EmailService;
use App\Mail\NewDoctorNotification;
use App\Models\Doctor;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $doctor, $password;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor, string $password)
    {
        $this->doctor = $doctor;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailService $emailService)
    {
        $emailService->sendEmail(new NewDoctorNotification($this->doctor,$this->password),$this->doctor->email);
    }
}
