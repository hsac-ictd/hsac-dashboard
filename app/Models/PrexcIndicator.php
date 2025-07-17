<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrexcIndicator extends Model
{
    protected $fillable = [
        'indicator',
        'target',
        'accomplishment',
        'year',
        'percentage_of_accomplishment',
        'description',
    ];
}
