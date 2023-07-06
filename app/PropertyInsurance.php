<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyInsurance extends Model
{
protected $table = 'popertyinsurances';
    protected $fillable = ['name', 'value'];
}
