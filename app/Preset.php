<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    protected $fillable = ['name', 'image','item_ids'];
}
