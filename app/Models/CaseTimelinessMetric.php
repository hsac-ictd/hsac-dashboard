<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseTimelinessMetric extends Model
{
    protected $fillable = [
        'case_type',
        'total_disposed',
        'total_ripe',
        'month_year',
        'year',
    ];
}
