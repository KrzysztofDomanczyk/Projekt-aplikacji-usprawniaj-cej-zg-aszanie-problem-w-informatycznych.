<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketMessageSent extends Mailable
{
    use Queueable, SerializesModels;

    private $ticket;
    private $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $content)
    {
        $this->ticket = $ticket;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("[IT#" . $this->ticket->id . "]". $this->ticket->subject_mail)->to($this->ticket->email)->markdown('emails.tickets.messageSent')->with([
            'ticket' => $this->ticket,
            'content' => $this->content,
        ]);
    }
}
