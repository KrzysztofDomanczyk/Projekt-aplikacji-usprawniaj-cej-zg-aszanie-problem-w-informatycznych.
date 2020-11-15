<?php

namespace App\Listeners;

use App\Events\RecivedTicketMessage;
use App\Notification;
use App\Ticket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateNotification
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
     * @param  RecivedTicketMessage  $event
     * @return void
     */
    public function handle(RecivedTicketMessage $event)
    {
        $ticket = Ticket::find($event->ticketMessage->ticket_id);

        if (!$ticket->users->isEmpty()) {
            foreach ($ticket->users as $user) {
                $notification = new Notification();
                $notification->content = $event->ticketMessage->content;
                $notification->target = route('ticket.edit', ['ticket'=> $ticket->id, 'project' => $ticket->project->id]);
                $notification->user_id = $user->id;
                $notification->save();
            }
        }
    }
}
