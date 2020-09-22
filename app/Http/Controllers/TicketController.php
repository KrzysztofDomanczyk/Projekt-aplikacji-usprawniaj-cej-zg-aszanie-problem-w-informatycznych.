<?php

namespace App\Http\Controllers;

use App\Libraries\Mail\EmailGetter;
use App\Project;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\Exception;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $email = null;
        if($id != null) {
            $emailGetter = new EmailGetter(Auth::user());
            $email = $emailGetter->getMessageByUid($id);
        }
       
        $projects = User::find(Auth::id())->projects;

        return view('ticket.form',['email' => $email, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = Ticket::create($request->except('_token') + ['creator_id' => Auth::id()]);
        return redirect(route('projects.show', ['project' => $request->input('project_id')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mailBody($id)
    {
        $emailGetter = new EmailGetter(Auth::user());
        $email = $emailGetter->getMessageByUid($id);

        return view('ticket.mail-body', ['email' => $email]);
    }
}
