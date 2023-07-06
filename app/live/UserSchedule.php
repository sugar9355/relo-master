<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    protected $fillable = ['user_id','Mon','Tue','Wed','Thu','Fri','time','created_at', 'updated_at','created_by','updated_by'];
	
	public static function getSchedule($param = null)
	{
		
		$schedule = DB::table('user_schedules as us')->Select('*');
		$schedule = $schedule->join('users as u', 'u.id', '=', 'us.user_id');
				
		if(isset($param['user_schedule_id']))
		{
			$schedule = $schedule->where('us.id',$param['user_schedule_id']);	
		}
		
		if(isset($param['user_id']))
		{
			$schedule = $schedule->where('us.user_id',$param['user_id']);	
		}
		
		return $schedule;
	}
	
	
	public static function AddUserSchedule($schedule)
	{
		DB::table('user_schedules')->insert($schedule);
	}
	
}
