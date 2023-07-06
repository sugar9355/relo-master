<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorageInsuranceDetails extends Model
{
    protected $fillable = ['user_storage_request_id', 'qty', 'insurance_type', 'category_name', 'ratio'];
}
