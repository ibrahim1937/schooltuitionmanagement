<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    public static function sendmail($title, $body, $url, $emailto){
        $details = [
            'title' => $title,
            'body' => $body,
            'url' => $url
        ];

        Mail::to($emailto)->send(new TestMail($details));
        return true;
    }
}
