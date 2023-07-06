<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeCharges extends Model
{
	protected $table = 'time_charges';
    protected $fillable = ['start_time', 'end_time','value'];
}
