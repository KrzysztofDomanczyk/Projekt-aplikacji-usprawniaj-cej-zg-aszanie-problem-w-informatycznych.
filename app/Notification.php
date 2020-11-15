<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Notification extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'seen'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        $carbonInstance = \Carbon\Carbon::instance($date);

        return $carbonInstance->toDateTimeString();
    }
}
