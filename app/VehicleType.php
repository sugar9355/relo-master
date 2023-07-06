<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
//    protected $table = 'vehicle_types';
    protected $fillable = ['name', 'abbreviation', 'color', 'width', 'height', 'breadth', 'volume', 'add_charges'];
}
