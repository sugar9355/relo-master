<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable = ['time', 'time_med', 'time_max' ,'ramp' ,'ptime' ,'ptimemed' ,'ptimemax' ,'mtime' ,'mtimemed' ,'mtimemax','ctime','ctimemed','ctimemax','etime','etimemed','etimemax','dtime','dtimemed','dtimemax','decription' ];
}
