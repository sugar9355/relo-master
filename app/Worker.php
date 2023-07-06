<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'avatar',
        'rating',
        'status',
        'latitude',
        'longitude',
        'otp'
    ];
    
    public function device()
    {
        return $this->hasOne(WorkerDevice::class);
    }
    
}
