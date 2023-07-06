<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    protected $fillable = ['user_id','Mon','Tue','Wed','Thu','Fri','Sat', 'Sun', 'start_time', 'start_unit', 'end_time', 'end_unit', 'created_at', 'updated_at','created_by','updated_by'];
    
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
    
    public static function GetLastPaymentRecievedDate($param = null)
    {
        $job = DB::table('payment_claim');
        
        $job = $job->select('*');
        
        if(!empty($param['user_id']))
        {
            $job = $job->where('user_id','=',$param['user_id']);
        }
        
        if(!empty($param['role_id']))
        {
            $job = $job->where('role_id','=',$param['role_id']);
        }
        
        $job = $job->where('start_date','<>',null);
        $job = $job->where('end_date','<>',null);
        
        if(!empty($param['payment_recieved']))
        {
            $job = $job->where('payment_recieved','<>',null);
        }
        
        $job = $job->orderBy('claim_id','DESC');
        return $job;
    }
    
    public static function GetWorkingHours($param = null)
    {
        $job = DB::table('job_assigned_users');
        
        $job = $job->selectRaw('captain_id,helper_id,technician_id,shift_start,shift_end,HOUR(shift_end) - HOUR(shift_start) as hours,minute(shift_end) - minute(shift_start) as minutes');
        
        if(!empty($param['captain_id']))
        {
            $job = $job->where('captain_id','=',$param['captain_id']);
        }
        
        if(!empty($param['refer_ids']))
        {
            $job = $job->whereIn('helper_id',$param['refer_ids']);
            //$job = $job->whereIn('technician_id',$param['refer_ids']);
        }
        
        if(!empty($param['start_date']))
        {
            $job = $job->where('shift_start','>=',$param['start_date']);
        }
        
        if(!empty($param['end_date']))
        {
            $job = $job->where('shift_end','<=',$param['end_date']);
        }
        
        if(!empty($param['status']))
        {
            $job = $job->where('status',$param['status']);
        }
        
        $job = $job->where('shift_start','<>',null);
        $job = $job->where('shift_end','<>',null);
        
        if(!empty($param['groupBy']))
        {
            $job = $job->groupBy('captain_id');
        }
        
        return $job;
    }
    
    public static function CalculateWorkingHours($param = null)
    {
        $job = DB::table('job_assigned_users');
        
        if(!empty($param['captain']))
        {
            $job = $job->selectRaw('captain_id,sum(HOUR(shift_end) - HOUR(shift_start)) as hours');
            $job = $job->where('captain_id','<>',null);
            $job = $job->groupBy('captain_id');
        }
        if(!empty($param['helper']))
        {
            $job = $job->selectRaw('helper_id,sum(HOUR(shift_end) - HOUR(shift_start)) as hours');
            $job = $job->where('helper_id','<>',null);
            $job = $job->groupBy('helper_id');
        }
        if(!empty($param['technician']))
        {
            $job = $job->selectRaw('technician_id,sum(HOUR(shift_end) - HOUR(shift_start)) as hours');
            $job = $job->where('technician_id','<>',null);
            $job = $job->groupBy('technician_id');
        }
        if(!empty($param['status']))
        {
            $job = $job->where('status',$param['status']);
        }
        
        $job = $job->where('shift_start','<>',null);
        $job = $job->where('shift_end','<>',null);
        
        return $job;
    }
    
    public static function GetLastClaim($claim,$where)
    {
        $last_claim = DB::table('payment_claim');
        
        $last_claim = $last_claim->where('shift_start','<>',null);
        $last_claim = $last_claim->where('shift_end','<>',null);
        $last_claim = $last_claim->where('payment_recieved','<>',null);
        
    }
    
    public static function UpdatePaymentClaim($claim,$where)
    {
        DB::table('payment_claim')->where($where)->Update($claim);
    }
    
    public static function UpdateUserBadges($badge)
    {
        DB::table('user_badges')->insert($badge);
    }
    
    public static function InsertPaymentClaim($claim)
    {
        DB::table('payment_claim')->insert($claim);
    }
    
    public static function GetAmount($param = null)
    {
        $amount = DB::table('employee_amount');
        $amount = $amount->where('status',1);
        return $amount;
    }
    
}
