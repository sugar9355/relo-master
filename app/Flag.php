<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $fillable = ['color', 'conditions', 'categories', 'items', 'num_flights', 'type_flights', 'zones', 'reason_title', 'description', 'addresses', 'apt'];
}
