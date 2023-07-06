<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    
    protected $fillable = [
        'storage_hub_id',
        'name',
        'sq_feet'
    ];
    
}
