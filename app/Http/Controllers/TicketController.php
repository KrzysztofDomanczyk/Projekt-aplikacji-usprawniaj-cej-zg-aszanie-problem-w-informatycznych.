<?php

namespace App\Http\Controllers;

use  App\Libraries\Mail\EmailGetter;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function getUnSeenMail()
    {
        
        $emails = new EmailGetter();
        // dd($emails->getUnSeenMail());
    }
}
