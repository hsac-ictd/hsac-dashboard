<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndigentLitigant extends Model
{
    protected $fillable = [
        'rab',
        'month_year',
        'total_indigents',
        'with_certificate',
    ];
}
