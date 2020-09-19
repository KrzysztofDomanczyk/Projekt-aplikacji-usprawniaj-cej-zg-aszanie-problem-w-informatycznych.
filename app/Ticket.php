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
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
