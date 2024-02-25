<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Naslov';
        $body = 'Test';

        Mail::to('hrvlionme@gmail.com')->send(new WelcomeMail($title, $body));

        return "Email sent successfully!";
    }
}