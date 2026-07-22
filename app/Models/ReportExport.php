<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportExport extends Model
{

    protected $fillable=[
        'generated_by',
        'report_type',
        'parameters',
        'file_path',
        'file_type',
        'generated_at'
    ];


    protected $casts=[
        'parameters'=>'array',
        'generated_at'=>'datetime'
    ];


    public function generatedBy()
    {
        return $this->belongsTo(User::class,'generated_by');
    }
}