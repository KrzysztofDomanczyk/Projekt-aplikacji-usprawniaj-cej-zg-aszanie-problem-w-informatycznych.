<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use App\Project;

class User extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany(Project::class);
    // }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)
            ->orderBy('seen', 'desc')
            ->orderBy('created_at', 'ASC');
    }


    public function isAttachedToProject($projectId)
    {
        foreach ($this->projects as $project) {
            if($project->id == $projectId){
                return true;
            }
        }
       return false;
    }


}
