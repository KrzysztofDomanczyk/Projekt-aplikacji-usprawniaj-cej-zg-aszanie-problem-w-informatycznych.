<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Mail\TicketCreated as MailTicketCreated; 
use App\Libraries\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail as IlluminateMail;

class SendTicketCreatedInformation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketCreated  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        IlluminateMail::send(new MailTicketCreated($event->ticket));
    }
}
