<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    protected $fillable = ['mobile', 'message'];
}
