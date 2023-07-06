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
        'first_name', 'last_name', 'gender', 'email', 'mobile', 'picture', 'password', 'device_type','device_token','login_by', 'payment_mode','social_unique_id','device_id','wallet_balance'
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
	
	public static function GetUserProfileByDeviceId($device_id,$role_id = null)
    {
		
        return DB::table('users as u')->selectRaw('u.id, u.first_name, u.last_name, u.payment_mode, u.email, u.gender, u.mobile, u.device_token, u.device_id, u.device_type,r.role_id')
		->join('role_user as r', 'u.id', '=', 'r.user_id')
		->where('r.role_id',$role_id)
		->where('u.device_id',$device_id);
    }
	
	public static function GetAllCaptains($param = null)
    {
		
        return DB::table('users as u')->selectRaw('u.id, u.first_name, u.last_name, u.payment_mode, u.email, u.gender, u.mobile, u.device_token, u.device_id, u.device_type,r.role_id')
		->join('role_user as r', 'u.id', '=', 'r.user_id')
		->where('r.role_id',4);
		
    }
	
	public static function InsertPaymentInfo($payment)
    {
        DB::table('payment_info')->insert($payment);
    }
	
	public static function UpdatePaymentInfo($payment,$where)
    {
        DB::table('payment_info')->where($where)->update($payment);
    }
	
}
