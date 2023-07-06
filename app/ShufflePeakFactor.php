<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ShufflePeakFactor extends Model
{
    public static function GetCustomerDemand() {
        return DB::table('shuffle_customer_demand')->get();
    }
}
