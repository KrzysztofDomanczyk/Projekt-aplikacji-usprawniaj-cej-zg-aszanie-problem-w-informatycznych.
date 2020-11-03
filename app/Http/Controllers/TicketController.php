<?php

namespace App\Http\Controllers;

use App\Events\TicketCreated;
use App\Libraries\Mail\IMAP;
use App\Project;
use App\Ticket;
use App\TicketMessage;
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
            $imap = new IMAP(Auth::user());
            $email = $imap->getMessageByUid($id);
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
        if(isset($ticket->email_uid)) {
            event(new TicketCreated($ticket));
            $imap = new IMAP(Auth::user());
            $imap->setSeenFlag($ticket->email_uid);
        }
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
     * @param  int  $ticket
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($ticket)
    {
  
        $ticket = Ticket::where('id', $ticket)->get()->first();
        if ($ticket->userHasAccess(Auth::user())) {
            return view('ticket.edit', [
                'ticket' => $ticket, 
                'projects' => Auth::user()->projects
            ]);
        }
        abort(404);
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
        $ticket = Ticket::where('id', $id)->get()->first();
        if ($ticket->userHasAccess(Auth::user())) {
            $ticket->update($request->except(['_token', '_method']));
            return redirect(route('projects.show', ['project' => $ticket->project_id]))->with('success', 'Ticket updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ticket = Ticket::where('id', $request->input('ticketId'))->get()->first();
        if ($ticket->userHasAccess(Auth::user())) {
            $ticket->delete();
            return redirect(route('projects.show', ['project' => $request->input('projectId')]))
                    ->with('success', 'Ticket deleted');
        }
    }

    public function getMailBody($id)
    {
        //obsłuzyc brak maila
        $imap = new IMAP(Auth::user());
        $email = $imap->getMessageByUid($id);
        return view('ticket.mail-body', ['email' => $email]);
    }

    public function showBody($id)
    {
        $ticket = Ticket::where('id', $id)->get()->first();
        if ($ticket->userHasAccess(Auth::user())) {
            return view('ticket.body', ['ticket' => $ticket]);
        }
        
    }

}
