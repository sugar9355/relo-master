<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Accuracy extends Model
{
	protected $table = 'accuracy';
    protected $fillable = ['name','label','min', 'max'];
	
	// public static function AddCustomerDemand($data)
	// {
		// DB::table('customer_demand')->insert($data);
	// }
	
	// public static function GetCustomerDemand()
	// {
		// return DB::table('customer_demand')->get();
	// }
	
	// public static function DeleteCustomerDemand()
	// {
		// return DB::table('customer_demand')->delete();
	// }
	
	
}
