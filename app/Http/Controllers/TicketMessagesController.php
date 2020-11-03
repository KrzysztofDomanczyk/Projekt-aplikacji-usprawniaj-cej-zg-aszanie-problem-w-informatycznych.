<?php

namespace App\Http\Controllers;

use App\Mail\TicketMessageSent;
use App\Ticket;
use App\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\Exception;

class TicketMessagesController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeViaPanel(Request $request) 
    {
        $ticket = Ticket::find($request->input('ticket_id'));
        $rules = [
            'content' => 'required',
            'email' => 'nullable'
        ];

        if($ticket->email == null) {
            $rules['email'] = 'required';
            $ticket->email = $request->input('email');
        }

        $request->validate($rules);
        $this->sendMessage($ticket, $request);
        $this->store($request);

        return back()->with('success','Message sent correctly.');
    }

    public function store($request)
    {
        TicketMessage::create($request->except('_token') + ['sender_email' => Auth::user()->email]);   
    }

    public function sendMessage($ticket, $request) : void
    {
        Mail::send(new TicketMessageSent($ticket, $request->input('content')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TicketMessage  $ticketMessage
     * @return \Illuminate\Http\Response
     */
    public function show(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketMessage  $ticketMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketMessage  $ticketMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketMessage  $ticketMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketMessage $ticketMessage)
    {
        //
    }
}
