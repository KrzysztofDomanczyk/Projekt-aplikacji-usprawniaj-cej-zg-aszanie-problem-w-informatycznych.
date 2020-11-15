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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function userHasAccess($user)
    {
       return $user->isAttachedToProject($this->project_id);
    }

    public function getUrlBody()
    {
        return route('ticket.body', ['id' => $this->id]);
    }

    public function addUser($userMail)
    {
        $user = User::where('email', $userMail)->get()->first();

        if(empty($user)) {
            return ['status'=>'error', "msg" => "Have no user like " . $userMail];
        }

        if($this->users()->get()->contains($user->id)) {
            return ['status'=>'error', "msg" => "This user is attached to this ticket"];
        }

        $this->users()->attach($user->id);
        return ['status'=>'success', "msg" => "User added correctly"];
    }

    public function deleteUser($userMail)
    {
        $user = User::where('email', $userMail)->get()->first();

        if(empty($user)) {
            return ['status'=>'error', "msg" => "Have no user like " . $userMail];
        }

        if(!$this->users()->get()->contains($user->id)) {
            return ['status'=>'error', "msg" => "This user is not attached to this ticket"];
        }

        $this->users()->detach($user->id);
        return ['status'=>'success', "msg" => "User deleted correctly"];
    }
}
