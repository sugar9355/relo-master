<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HubLocation extends Model
{
    
    protected $fillable = ['name','label','address','lat','lng' ];
    
   
}
