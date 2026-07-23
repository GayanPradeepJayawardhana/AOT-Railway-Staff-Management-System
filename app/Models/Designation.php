<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Designation extends Model
{
    protected $fillable = [
        'designation_name',
        'designation_code',
        'sort_order',
        'status'
    ];

    public function reportDetails(): HasMany
    {
        return $this->hasMany(ReportDetail::class);
    }

    /**
     * Scope a query to only include active designations.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}