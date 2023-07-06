<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    protected $fillable = [
        'name',
        'label',
        'hourly_rate',
        'charging_customer',
    ];
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->attach($permission);
    }
    
    public function removePermissionTo(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
}
