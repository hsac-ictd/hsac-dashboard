<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabCase extends Model
{
    protected $fillable = [
        'rab',
        'status',
        'case_type',
        'total',
        'month_year',
    ];
}
