<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyCaseWorkload extends Model
{
    protected $fillable = [
        'total_disposed',
        'total_handled',
        'month_year',
        'year',
    ];
}
