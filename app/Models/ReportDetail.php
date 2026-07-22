<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{

    protected $fillable=[
        'monthly_report_id',
        'designation_id',
        'approved_cadre',
        'staff_on_duty',
        'vacancies',
        'relief_inward',
        'relief_outward',
        'relief_work_station',
        'temp_transfer_inward',
        'temp_transfer_outward',
        'temp_transfer_work_station',
        'excess',
        'foreign_leave_overseas',
        'retirements_details'
    ];


    public function monthlyReport()
    {
        return $this->belongsTo(MonthlyReport::class);
    }


    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}