<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    
    protected $fillable = ['name','hourly_rate','role','validaity','description','created_at','updated_at'];
	protected $table = 'job_opportunity';
	
	public static function GetCurrentHourlyRate($param = null)
	{
				
		$job_opportunity = DB::table('job_opportunity');
		
		if(!empty($param['role']))
		{
			$job_opportunity = $job_opportunity->where('role','=',$param['role']);
		}
		
		$job_opportunity = $job_opportunity->whereRaw('YEAR(created_at) = '.date("Y"));
		$job_opportunity = $job_opportunity->whereRaw('MONTH(created_at) = '.date("m"));
		$job_opportunity = $job_opportunity->orderBy('created_at','DESC');
		
		return $job_opportunity;
	}
	
}
