<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = 'users';


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



    // User Role Relationship

    public function role()
    {
        return $this->belongsTo(UserRole::class,'role_id');
    }



    // Role checks used by routes and navigation

    public function hasRole(string $roleSlug): bool
    {
        return $this->role?->role_slug === $roleSlug;
    }



    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }



    public function isStationUser(): bool
    {
        return $this->hasRole('station_user');
    }



    // Station Relationship

    public function station()
    {
        return $this->belongsTo(Station::class,'station_id');
    }



    // Monthly Reports

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class,'user_id');
    }



    // Password History

    public function passwordChanges()
    {
        return $this->hasMany(PasswordChangeHistory::class,'user_id');
    }



    // Notifications

    public function notifications()
    {
        return $this->hasMany(SystemNotification::class,'user_id');
    }



    // Audit Logs

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class,'user_id');
    }

}