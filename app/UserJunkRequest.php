<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserJunkRequest extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function userMovingRequestItems()
    {
        return $this->hasMany(UserJunkRequestItem::class);
    }
    
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function locations()
    {
        return $this->hasMany(JunkLocation::class);
    }
    
    public function insuranceDetails()
    {
        return $this->hasMany(JunkInsuranceDetails::class);
    }
}
