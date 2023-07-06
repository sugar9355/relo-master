<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JunkLocation extends Model
{
    protected $fillable = ['user_junk_request_id', 'floor', 'zip_code', 'location_question1', 'flight', 'stair_type', 'location_question2', 'elevator_type', 'detail_address', 'location_note'];
}
