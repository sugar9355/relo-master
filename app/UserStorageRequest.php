<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStorageRequest extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function userMovingRequestItems()
    {
        return $this->hasMany(UserStorageRequestItem::class);
    }
    
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    
    public function locations()
    {
        return $this->hasMany(StorageLocation::class);
    }
    
    public function insuranceDetails()
    {
        return $this->hasMany(StorageInsuranceDetails::class);
    }
}
