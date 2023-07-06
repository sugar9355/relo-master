<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShuffleFee extends Model
{
    protected $fillable = ['base_rate', 'charge_cb_ft', 'curbside_fee', 'parking_situations', 'parking_fees', 'vol_min', 'vol_max', 'long_walk_fee', 'dis_assem_fee'];
}
