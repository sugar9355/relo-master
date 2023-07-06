<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStorageRequestItem extends Model
{
    protected $fillable = ['user_storage_request_id', 'name', 'options', 'price', 'qty'];
    
    public function item()
    {
        return $this->belongsTo(Inventory::class, 'name', 'name');
    }
}
