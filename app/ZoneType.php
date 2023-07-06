<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneType extends Model
{
    protected $fillable = ['name', 'zip_code', 'color' ,'flag', 'sh_price'];
}
