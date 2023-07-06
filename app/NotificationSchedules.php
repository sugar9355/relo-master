<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSchedules extends Model
{
    protected $fillable = ['days', 'message', 'status', 'sms', 'email'];
}
