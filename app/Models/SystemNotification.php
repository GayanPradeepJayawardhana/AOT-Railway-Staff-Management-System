<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{

    protected $fillable=[
        'user_id',
        'title',
        'message',
        'type',
        'read_status',
        'notification_type',
        'reference_id',
        'read_at'
    ];


    protected $casts=[
        'read_at'=>'datetime'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}