<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserJunkRequestItem extends Model
{
    protected $fillable = ['user_junk_request_id', 'name', 'options', 'price'];
    
    public function item()
    {
        return $this->belongsTo(Inventory::class, 'name', 'name');
    }
}
