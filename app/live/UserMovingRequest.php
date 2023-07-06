<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserMovingRequest extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function userMovingRequestItems()
    {
        return $this->hasMany(UserMovingRequestItem::class, 'user_moving_request_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
    
    public function insuranceDetails()
    {
        return $this->hasMany(InsuranceDetails::class);
    }
	
	public static function GetAllAssignedTrucks($param = null)
	{
				
		$UserMovingRequest = DB::table('user_moving_requests')
		->selectRaw('id,user_id,truck_id,from_unixtime(int_start_time)as s_time,from_unixtime(int_end_time) as e_time ,int_start_time,int_end_time,start_time,end_time,s_lat,s_lng,d_lat,d_lng,prefer_date');
		
		$UserMovingRequest = $UserMovingRequest->whereNotNull('truck_id');
		$UserMovingRequest = $UserMovingRequest->where('status','Pending');
		
		if(!empty($param['prefer_date']))
		{
			$UserMovingRequest = $UserMovingRequest->where('prefer_date',$param['prefer_date']);
		}

        // $UserMovingRequest = $UserMovingRequest->groupBy('truck_id');
        $UserMovingRequest = $UserMovingRequest->orderBy('int_start_time','ASC');
		// $UserMovingRequest = $UserMovingRequest->having('cnt', '>', 1);
		$UserMovingRequest = $UserMovingRequest->get();
		
		return $UserMovingRequest;
	}
	
	public static function GetAvailableJobs($param = null)
	{
				
		$available = DB::table('user_moving_requests as r');
		$available = $available->selectRaw('*,r.id as booking_id');
		$available = $available->join('job_assigned_users as j', 'j.booking_id', '=', 'r.id');
		
		$available = $available->whereNotNull('r.truck_id');
		$available = $available->where('r.status','Pending');
		//$available = $available->where('j.captain_id',null);
		
		if(!empty($param['prefer_date']))
		{
			$available = $available->where('r.prefer_date','>=',now());
		}
		
		if(!empty($param['captain_id']))
		{
			$available = $available->where('j.captain_id','=',$param['captain_id']);
		}
		
		if(!empty($param['prefer_date']))
		{
			$available = $available->where('r.prefer_date','=',$param['prefer_date']);
		}
		
		return $available;
	}
	
	public static function GetAvailableHelpers($param = null)
	{
		$available = DB::table('users as u');
		$available = $available->select('u.first_name','u.last_name','u.email','u.mobile','r.role_id','u.id as helper_id');
		$available = $available->join('role_user as r', 'r.user_id', '=', 'u.id');
		$available = $available->leftjoin('job_assigned_users as j', 'j.helper_id', '=', 'u.id');
		$available = $available->where('j.helper_id',null);
		$available = $available->where('r.role_id',5);
		return $available;
	}
	
	public static function GetAvailableTechnician($param = null)
	{
				
		$available = DB::table('users as u');
		$available = $available->select('u.first_name','u.last_name','u.email','u.mobile','r.role_id','u.id as technician_id');
		$available = $available->join('role_user as r', 'r.user_id', '=', 'u.id');
		$available = $available->leftjoin('job_assigned_users as j', 'j.technician_id', '=', 'u.id');
		$available = $available->where('j.technician_id',null);
		$available = $available->where('r.role_id',6);
		
		return $available;
	}
	
	
	public static function AddAssignedJobUsers($job)
	{
		DB::table('job_assigned_users')->insert($job);
	}
	
	public static function UpdateAssignedJobUsers($job,$booking_id)
	{
		DB::table('job_assigned_users')->where('booking_id',$booking_id)->update($job);
	}
	
	public static function UpdateHelper($update,$where)
	{
		$helper = DB::table('job_assigned_users');
		$helper = $helper->where('booking_id','=',$where['booking_id']);
		
		if(!empty($param['captain_id']))
		{
			$helper = $helper->where('captain_id','=',$where['captain_id']);
		}
		if(!empty($param['status']))
		{
			$helper = $helper->where('status','=',$where['status']);
		}
		
		$helper->update($update);
	}
	
	public static function UpdateTchnician($update,$where)
	{
		$helper = DB::table('job_assigned_users');
		$helper = $helper->where('booking_id','=',$where['booking_id']);
		
		if(!empty($param['captain_id']))
		{
			$helper = $helper->where('captain_id','=',$where['captain_id']);
		}
		if(!empty($param['status']))
		{
			$helper = $helper->where('status','=',$where['status']);
		}
		
		$helper->update($update);
	}
	
	public static function check_in($update,$where)
	{
		$helper = DB::table('job_assigned_users');
		$helper = $helper->where('booking_id','=',$where['booking_id']);
		
		if(!empty($param['captain_id']))
		{
			$helper = $helper->where('captain_id','=',$where['captain_id']);
		}
		
		if(!empty($param['status']))
		{
			$helper = $helper->where('status','=',$where['status']);
		}
		
		if(!empty($param['shift_start']))
		{
			$helper = $helper->where('shift_start','=',$where['shift_start']);
		}
		
		$helper->update($update);
	}
	
	public static function check_out($update,$where)
	{
		$helper = DB::table('job_assigned_users');
		$helper = $helper->where('booking_id','=',$where['booking_id']);
		
		if(!empty($param['captain_id']))
		{
			$helper = $helper->where('captain_id','=',$where['captain_id']);
		}
		
		if(!empty($param['status']))
		{
			$helper = $helper->where('status','=',$where['status']);
		}
		
		if(!empty($param['shift_end']))
		{
			$helper = $helper->where('shift_end','=',$where['shift_end']);
		}
		
		$helper->update($update);
	}
	
}
