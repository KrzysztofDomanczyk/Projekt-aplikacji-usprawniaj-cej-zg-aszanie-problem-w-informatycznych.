<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'creator_id'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function addUser($userMail)
    {
        $user = User::where('email', $userMail)->get()->first();

        if(empty($user)) {
            return ['status'=>'error', "msg" => "Have no user like " . $userMail];
        }

        if($this->users()->get()->contains($user->id)) {
            return ['status'=>'error', "msg" => "This user is attached to this project"];
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
            return ['status'=>'error', "msg" => "This user is not attached to this project"];
        }

        $this->users()->detach($user->id);
        return ['status'=>'success', "msg" => "User deleted correctly"];
    }

    public function isOwner($user)
    {
        return $this->creator->id == $user;
    }

    
}
