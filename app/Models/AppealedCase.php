<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppealedCase extends Model
{
    protected $fillable = [
        'status',
        'case_type',
        'total',
        'month_year',
    ];
}
