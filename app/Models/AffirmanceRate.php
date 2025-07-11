<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffirmanceRate extends Model
{
    protected $fillable = [
        'court',
        'outcome',
        'total',
        'month_year',
    ];
}
