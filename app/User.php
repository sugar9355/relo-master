<?php

namespace App;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'email', 'mobile', 'picture', 'password', 'device_type','device_token','login_by', 'payment_mode','social_unique_id','device_id','hourly_rate','wallet_balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at'
    ];


    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany('App\UserRequests','user_id','id');
    }
    
    public static function insertRole($role)
    {
        DB::table('role_user')->insert($role);
    }
    
    public static function GetPaymentInfo($param)
    {
        $pay_info = DB::table('payment_info');
        
        if(!empty($param['user_id']))
        {
            $pay_info = $pay_info->where('user_id',$param['user_id']);
        }
        
        return  $pay_info;
        
    }
    
    public static function GetUserRoleByUserId($user_id)
    {
        
        return DB::table('role_user')->where('user_id',$user_id);
    }
    
    public static function GetUserProfileByDeviceId($device_id,$role_id = null)
    {
        
        return DB::table('users as u')->selectRaw('u.id, u.first_name, u.last_name, u.payment_mode, u.email, u.gender, u.mobile, u.device_token, u.device_id, u.device_type,r.role_id')
        ->join('role_user as r', 'u.id', '=', 'r.user_id')
        ->where('r.role_id',$role_id)
        ->where('u.device_id',$device_id);
    }
    
    public static function GetUserWithRole($param = null,$join = null,$select = null,$group = null)
    {
        $user = DB::table('users as u');
        $user = $user->selectRaw('u.id, u.first_name, u.last_name, u.payment_mode, u.email, u.gender, u.mobile, u.device_token, u.device_id,u.hourly_rate, u.device_type,r.id as role_id,r.name as role_name,alpha_role, ul.level_id, ul.level_name');
        $user = $user->join('role_user as ur', 'u.id', '=', 'ur.user_id');
        $user = $user->join('roles as r', 'r.id', '=', 'ur.role_id');
        $user = $user->join('user_level as ul', 'ul.user_id', '=', 'u.id');
        
        if(!empty($param['user_id']))
        {
            $user = $user->where('u.id',$param['user_id']);    
        }
        
        if(!empty($param['role_id']))
        {
            $user = $user->where('r.id',$param['role_id']);    
        }
        
        if(!empty($param['role_ids']))
        {
            $user = $user->whereIn('r.id',$param['role_ids']);    
        }
        
        if(!empty($param['hourly_rate']) && $param['hourly_rate'] == 'Not Null')
        {
            $user = $user->where('hourly_rate','<>','');    
        }
        
        if(!empty($group['roles']))
        {
            $user = $user->groupBy('r.id');    
        }
        
        return $user; 
        
    }
    
    public static function InsertPaymentInfo($payment)
    {
        DB::table('payment_info')->insert($payment);
    }
    
    public static function UpdatePaymentInfo($payment,$where)
    {
        DB::table('payment_info')->where($where)->update($payment);
    }
    
    public static function GetAllEmployee($param = null)
    {
        $roles = array(4,5,6,7,8);
        return DB::table('users as u')
        ->selectRaw('u.id, u.first_name, u.last_name, u.payment_mode, u.email, u.gender, u.mobile, u.device_token, u.device_id, u.hourly_rate, u.device_type,r.role_id,rs.name as role_name,p.payment_recieved,p.hours, ul.level_name, ul.level, ul.level_id')
        ->addSelect('j.shift_start','j.shift_end')
        ->join('role_user as r', 'u.id', '=', 'r.user_id')
        ->join('roles as rs', 'rs.id', '=', 'r.role_id')
        ->LeftJoin('job_assigned_users as j', 'j.user_id', '=', 'u.id')
        ->LeftJoin('payment_claim as p', 'p.user_id', '=', 'u.id')->where('p.payment_recieved',null)
        ->LeftJoin('user_level as ul', 'ul.user_id', '=', 'u.id')
        ->whereIn('r.role_id',$roles);
        
    }
    
    public static function GetAcceptedJobs($param = null)
    {
        $job = DB::table('job_assigned_users');
        
        if(!empty($param['captain_id']))
        {
            $job = $job->where('captain_id','=',$param['captain_id']);
        }
        if(!empty($param['helper_id']))
        {
            $job = $job->where('helper_id','=',$param['helper_id']);
        }
        if(!empty($param['techinician_id']))
        {
            $job = $job->where('techinician_id','=',$param['techinician_id']);
        }
        if(!empty($param['status']))
        {
            $job = $job->where('status','=',$param['status']);
        }
        // if(!empty($param['role_id']))
        // {
            // $job = $job->where('role_id','=',$param['role_id']);
        // }
        
        return $job;
        
    }
    
    
    public static function GetAllCaptain()
    {
        return DB::table('users as u')
        ->selectRaw('u.id,u.first_name,u.last_name,u.mobile')
        ->join('role_user as r', 'u.id', '=', 'r.user_id')
        ->join('roles as rs', 'rs.id', '=', 'r.role_id')
        ->where('r.role_id',4);
        
    }
    
    

    
}
