<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissingSubmissionTracking extends Model
{

    protected $table='missing_submissions_tracking';


    protected $fillable=[
        'station_id',
        'year',
        'month',
        'notification_sent',
        'notification_date',
        'reminder_count',
        'last_reminder_date'
    ];


    protected $casts=[
        'notification_date'=>'datetime',
        'last_reminder_date'=>'datetime'
    ];


    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}