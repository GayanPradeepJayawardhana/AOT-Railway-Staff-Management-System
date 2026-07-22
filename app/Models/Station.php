<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'station_code',
        'station_name',
        'status'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }

    public function quarterlyReports()
    {
        return $this->hasMany(QuarterlyReportSummary::class);
    }

    public function missingSubmissions()
    {
        return $this->hasMany(MissingSubmissionTracking::class);
    }
}