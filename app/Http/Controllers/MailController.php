<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Hospital Appointment',
            'body' => 'Your appointment has been booked sucessfully !!!'
        ];

        Mail::to('shreezanpandit@gmail.com')->send(new AppointmentMail($mailData));

        dd("Email is sent successfully.");
    }
}
