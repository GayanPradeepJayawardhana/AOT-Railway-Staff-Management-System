<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable=[
        'designation_name',
        'designation_code',
        'sort_order',
        'status'
    ];


    public function reportDetails()
    {
        return $this->hasMany(ReportDetail::class);
    }
}