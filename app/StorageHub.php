<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorageHub extends Model
{
    
    protected $fillable = [
        'name',
        'lat',
        'lng',
        'day',
        'week',
        'month',
        'year',
        'time',
        'total_sq_feet',
        'sq_feet'
    ];
    
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    
}
