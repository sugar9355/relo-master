<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookingNotify extends Model
{
      public $timestamps = false;


      public static function getNotify(){
      	$notify = DB::table('booking_notify')

            ->selectRaw('*')

            ->where('status',1)
            
            ->get();

            return $notify;
      }
}
