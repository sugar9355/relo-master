<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceCategory extends Model
{
    protected $fillable = [ 'name', 'ratio','badge_required', 'you_pay'];
}
