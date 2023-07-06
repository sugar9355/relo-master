<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    
    protected $fillable = [
        'name',
        'bonus',
		'ref_bonus',
        'level',
        'hours',
        'days',
        'time',
        'time_med',
        'time_max'
    ];
	
	public static function GetLevelsFactors($param=null,$join=null)
	{
		$lvl_factors = DB::table('level_factors as lf');
		
		$lvl_factors = $lvl_factors->select('lf.factor_id','lf.role_A','lf.role_B','lf.role_C','level_id','factor_name');
		$lvl_factors = $lvl_factors->join('designation_factors as df', 'df.factor_id', '=', 'lf.factor_id');
		
		if(!empty($join['level']))
		{
			$lvl_factors = $lvl_factors->join('levels as l', 'l.id', '=', 'lf.level_id');
			$lvl_factors = $lvl_factors->addSelect('name as level_name');
		}
		
		if(!empty($param['level_ids']))
		{
			$lvl_factors = $lvl_factors->whereIn('lf.level_id',$param['level_ids']);
		}
		
		return $lvl_factors;
	}

	
	public static function GetLevelFactors($param=null)
	{
		$lvl_factors = DB::table('designation_factors as df');
		
		$lvl_factors = $lvl_factors->select('df.factor_id','df.badge_type_id','df.factor_name','df.factor_description','df.role_A as df_role_A','df.role_B as df_role_B','df.role_C as df_role_C');
		$lvl_factors = $lvl_factors->addSelect('lf.factor_id as lf_factor_id','lf.factor_value','lf.role_A as lf_role_A','lf.role_B as lf_role_B','lf.role_C as lf_role_C');
		$lvl_factors = $lvl_factors->addSelect('df.factor_value as df_factor_value');
		
		
		$lvl_factors = $lvl_factors->leftJoin('level_factors as lf', function($q) use ($param)
        {
            $q->on('lf.factor_id', '=', 'df.factor_id')->where('lf.level_id', '=', $param['level_id']);
        });
		
		if(!empty($param['level_ids']))
		{
			$lvl_factors = $lvl_factors->whereIn('lf.level_id',$param['level_ids']);
		}
		
		return $lvl_factors;
	}
	
	public static function SaveLevelFactors($param)
	{
		DB::table('level_factors')->insert($param);
	}
	
	public static function DeleteLevelFactors($where)
	{
		DB::table('level_factors')->where($where)->delete();
	}
	
	
}
