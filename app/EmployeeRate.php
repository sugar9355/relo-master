<?php

namespace App;

use App\Notifications\ProviderResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmployeeRate extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
	protected $fillable = [];
	protected $table = 'employee_amount';

   
}
