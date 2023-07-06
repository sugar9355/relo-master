<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMovingRequestItem extends Model
{

    protected $fillable = ['user_moving_request_id', 'name', 'options', 'price'];

    public function item()
    {
        return $this->belongsTo(Inventory::class, 'name', 'name');
    }
}
