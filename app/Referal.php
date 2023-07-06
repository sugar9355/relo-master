<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    
    protected $fillable = [
        'name',
        'bonus',
        'level',
        'hours',
        'days',
        'time',
        'time_med',
        'time_max'
    ];
}
