<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $fillable = [
        'content', 'sender_email', 'ticket_id',
    ];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getUrlBody()
    {
        return route('ticketMessages.body', ['id' => $this->id]);
    }
}
