<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Rworker extends Model
{
    protected $fillable = ['num_crews', 'weight', 'volume', 'categories', 'items', 'wei_min', 'wei_max', 'vol_min', 'vol_max'];
    //
}
