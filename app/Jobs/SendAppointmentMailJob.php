<?php

namespace App\Jobs;

use App\Mail\AppointmentMail;
use App\Mail\DoctorAppointmentMail;
use App\Mail\PatientAppointmentMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAppointmentMailJob implements ShouldQueue
{
    use Queueable;
    protected $mailData;
    /**
     * Create a new job instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mailData['patient_email'])->send(new PatientAppointmentMail($this->mailData));
        Mail::to($this->mailData['doctor_email'])->send(new DoctorAppointmentMail($this->mailData));
    }
}
