<?php

namespace App\Http\Controllers;

use App\Libraries\Mail\EmailGetter;
use Illuminate\Http\Request;
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
        $emailGetter = new EmailGetter();
        $emails = $emailGetter->getUnseenMessages();        
        return view('home', ['emails' => $emails]);
    }
}
