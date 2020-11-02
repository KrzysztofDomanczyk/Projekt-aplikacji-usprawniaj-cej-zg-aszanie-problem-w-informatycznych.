<?php

namespace App\Http\Controllers;

use App\Events\TicketCreated;
use App\Libraries\Mail\IMAP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Email;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
  
        $imap = new IMAP(Auth::user());
        $emails = $imap->getUnseenMessages();

        return view('home', ['emails' => $emails]);
    }
}
