<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordChangeHistory extends Model
{

    protected $table='password_change_history';


    protected $fillable=[
        'user_id',
        'changed_by',
        'change_type',
        'ip_address',
        'user_agent'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function changedBy()
    {
        return $this->belongsTo(User::class,'changed_by');
    }
}