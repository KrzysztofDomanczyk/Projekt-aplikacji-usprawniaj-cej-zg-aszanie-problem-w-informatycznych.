<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'body_mail',
        'status', 'subject_mail', 'start_date',
        'end_date', 'project_id', 'creator_id',
        'email_uid', 'email'
    ];

    public function messages()
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at', 'desc');
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }


    public function userHasAccess($user)
    {
       return $user->isAttachedToProject($this->project_id);
    }

    public function getUrlBody()
    {
        return route('ticket.body', ['id' => $this->id]);
    }
}
