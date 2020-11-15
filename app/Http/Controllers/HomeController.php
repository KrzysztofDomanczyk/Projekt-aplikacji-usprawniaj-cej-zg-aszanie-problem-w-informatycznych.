<?php

namespace App\Http\Controllers;

use App\Events\TicketCreated;
use App\Libraries\Mail\IMAP;
use App\Libraries\Mail\TicketMessageCatcher;
use App\Ticket;
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
      
        return view('home');
    }

    public function catchTicketMessage(){
        try {
            $catcher = new TicketMessageCatcher();
            $catcher->catch();
        } catch (\Throwable  $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function getUnseenMessages()
    {
        try {
            $imap = new IMAP(Auth::user());
            $emails = $imap->getUnseenMessages();
        } catch (\Throwable  $e) {
            return response()->json(['message' => $e->getMessage()], 401);;
        }

        return response()->json($emails);
    }

    public function markAsSeen($uid)
    {
        $imap = new IMAP(Auth::user());
        $imap->setSeenFlag($uid);
    }
}
