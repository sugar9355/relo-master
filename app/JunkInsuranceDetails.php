<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JunkInsuranceDetails extends Model
{
    protected $fillable = ['user_junk_request_id', 'qty', 'insurance_type', 'category_name', 'ratio'];
}
