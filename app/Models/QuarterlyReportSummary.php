<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuarterlyReportSummary extends Model
{

    protected $fillable=[
        'year',
        'quarter',
        'station_id',
        'total_staff',
        'total_vacancies',
        'total_relief_inward',
        'total_relief_outward',
        'total_temp_transfer_inward',
        'total_temp_transfer_outward',
        'total_excess',
        'total_foreign_leave',
        'retirements_summary'
    ];


    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}