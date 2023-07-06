<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceDetails extends Model
{
    protected $fillable = ['user_moving_request_id', 'qty', 'insurance_type', 'category_name', 'ratio'];
}
