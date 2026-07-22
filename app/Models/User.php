<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'nic_number',
        'whatsapp_mobile',
        'station_id',
        'password',
        'role_id',
        'status'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at'=>'datetime',
        'last_login_at'=>'datetime'
    ];


    public function role()
    {
        return $this->belongsTo(UserRole::class,'role_id');
    }


    public function station()
    {
        return $this->belongsTo(Station::class);
    }


    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }


    public function passwordChanges()
    {
        return $this->hasMany(PasswordChangeHistory::class);
    }


    public function notifications()
    {
        return $this->hasMany(SystemNotification::class);
    }


    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}