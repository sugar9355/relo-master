<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Model
{
    
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'picture',
    ];
}
