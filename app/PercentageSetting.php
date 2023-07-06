<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PercentageSetting extends Model
{
    protected $fillable = ['max', 'percentage', 'is_flat', 'flat'];
}
