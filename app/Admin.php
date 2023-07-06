<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'last_name', 'first_name'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }
    
    public function hasRole($role)
    {
        if (is_string($role))
            return $this->roles->contains('name', $role);
        
        return !! $role->intersect($this->roles)->count();
    }
    
    public function isSuperAdmin()
    {
        if (auth()->guard('admin')->user()->id === 1)
            return true;
        
        return false;
    }
    
}
