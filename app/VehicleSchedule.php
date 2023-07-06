<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class VehicleSchedule extends Model
{
    protected $fillable = ['name', 'color'];
	
	public static function GetAllTrucksSchedule($param)
	{
		// $schedule = DB::table('user_moving_requests as r');
		// $schedule = $schedule->join('users as u', 'u.id', '=', 'r.user_id')->addSelect('u.first_name','u.last_name');
		// $schedule = $schedule->join('trucks as t', 't.id', '=', 'r.user_id')->addSelect('t.name','t.type');
		// $schedule = $schedule->join('vehicle_schedules as v', 'v.request_id', '=', 'r.id')->addSelect('v.id','v.assigned_on','v.start_time','v.end_time');
		
		
		$schedule = DB::table('vehicle_schedules as v')->addSelect('v.id','v.assigned_on','v.start_time','v.end_time');
		$schedule = $schedule->join('users as u', 'u.id', '=', 'v.user_id')->addSelect('u.first_name','u.last_name');
		$schedule = $schedule->join('trucks as t', 't.id', '=', 'v.truck_id')->addSelect('t.name','t.type');
		
		if(isset($param['vehicle_schedule_id']))
		{
			$schedule = $schedule->where('v.id',$param['vehicle_schedule_id']);	
		}
		
		if(isset($param['limit']))
		{
			$schedule = $schedule->paginate($param['limit']);	
		}
		else
		{
			$schedule = $schedule->get();	
		}
		
		return $schedule;
	}
	
}
