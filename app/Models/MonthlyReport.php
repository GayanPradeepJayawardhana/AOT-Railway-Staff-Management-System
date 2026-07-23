<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{

    protected $fillable=[
        'report_identifier',
        'station_id',
        'user_id',
        'year',
        'month',
        'month_full',
        'submission_status',
        'submitted_at'
    ];


    protected $casts=[
        'submitted_at'=>'datetime'
    ];


    public function station()
    {
        return $this->belongsTo(Station::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function reportDetails()
    {
        return $this->hasMany(ReportDetail::class);
    }
}