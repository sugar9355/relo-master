<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\PeakFactor;
use App\Booking;
use App\PeakFactorDevice;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Exception;

class PeakFactorController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('peakFactors')){
            return abort(404);
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
		
		
		if(isset($request->btn_last) || isset($request->btn_next))
		{
			if(isset($request->btn_next))
			{
				$c_date = $request->btn_next;
			}
			if(isset($request->btn_last))
			{
				$c_date = $request->btn_last;
			}
			
			
			$c_date = explode('-',$c_date);
			
			$last_date = date('m-Y', strtotime('-1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));
			
			$last_month = intval(explode('-',$last_date)[0]);
			$last_year = explode('-',$last_date)[1];		
			
			$c_date['last_date'] = $last_month.'-'.$last_year;
			
			$month = intval(date("m", mktime(0, 0, 0, $c_date[0], 10)));
			$year = $c_date[1];
			$c_date['now_month'] = $month;
			$c_date['now_year'] = $year;
			$c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
			
			$next_date = date('m-Y', strtotime('+1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));
			
			$next_month = intval(explode('-',$next_date)[0]);
			$next_year = explode('-',$next_date)[1];		
			
			$c_date['next_date'] = $next_month.'-'.$next_year;
			
		}
		else
		{	
			$c_date['now_month'] =$month = intval(date('m')); 
			$c_date['now_year'] = $year = date('Y'); 
			$c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
			
			$last_date = date('m-Y', strtotime('-1 month', strtotime(now())));
			
			$c_date['last_month'] = $last_month = intval(explode('-',$last_date)[0]);
			$c_date['last_year'] = $last_year = explode('-',$last_date)[1];		
			
			$c_date['last_date'] = $last_month.'-'.$last_year;
			
			$next_date = date('m-Y', strtotime('+1 month', strtotime(now())));
			
			$c_date['next_month'] = $next_month = intval(explode('-',$next_date)[0]);
			$c_date['next_year'] = $next_year = explode('-',$next_date)[1];		
			
			$c_date['next_date'] = $next_month.'-'.$next_year;
		}
		
		$peakFactor = PeakFactor::orderBy('id', 'DESC');
		$peakFactor = $peakFactor->where('month',$c_date['now_month']);
		$peakFactor = $peakFactor->where('year',$c_date['now_year']);
		$peakFactor = $peakFactor->pluck('value','day');
		
		$calender = $this->GetCelender(date("Y"));
		
		$CustomerDemand = PeakFactor::GetCustomerDemand();
		
		
        return view('admin.peakFactors.index', compact('peakFactor','calender','c_date','CustomerDemand'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.peakFactors.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		
		if($request->btn_customer_demand == true)
		{	
			$insert['high'] = $request->high_demand;
			$insert['moderate'] = $request->moderate_demand;
			$insert['low'] = $request->low_demand;
			$insert['status'] = 1;
			$insert['created_at'] = time();
			$insert['updated_at'] = time();
			PeakFactor::AddCustomerDemand($insert);
		}
		else
		{
			//dd($request->all());
			PeakFactor::where('month',$request->month)->delete();
			
			foreach($request->peak as $key => $days)
			{
				foreach($days as $k => $val)	
				{
					$insert[$k]['year'] 		= $request->year;
					$insert[$k]['month'] 		= $key;
					$insert[$k]['day'] 			= $k;
					$insert[$k]['value'] 		= $val;
					$insert[$k]['status'] 		= 1;
					$insert[$k]['created_at'] 	= time();
					$insert[$k]['updated_at']	= time();
				}
			}
			
			PeakFactor::insert($insert);
		}
		return redirect()->route('admin.peakfactor.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param PeakFactor $peakFactor
     * @return Response
     */
    public function edit(PeakFactor $peakFactor)
    {
        return view('admin.peakFactors.edit', compact('peakFactor'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PeakFactor $peakFactor
     * @return Response
     */
    public function update(Request $request, PeakFactor $peakFactor)
    {
        $peakFactor->update($request->all());
        $peakFactor->save();
        return redirect()->route('admin.peakfactor.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param PeakFactor $peakFactor
     * @return Response
     */
    public function destroy(PeakFactor $peakFactor)
    {
       
    }
	
	function GetCelender($year) 
	{
	
		$res = $year >= 1970;
		if ($res) 
		{
		  // this line gets and sets same timezone, don't ask why :)
		  date_default_timezone_set(date_default_timezone_get());

		  $dt = strtotime("-1 day", strtotime("$year-01-01 00:00:00"));
		  $res = array();
		  $week = array_fill(1, 7, false);
		  $last_month = 1;
		  $w = 1;
		  
		  do 
			{
				$dt = strtotime('+1 day', $dt);
				$dta = getdate($dt);
				$wday = $dta['wday'] == 0 ? 7 : $dta['wday'];
				if (($dta['mon'] != $last_month) || ($wday == 1)) 
				{
					if ($week[1] || $week[7]) $res[$last_month][] = $week;
					$week = array_fill(1, 7, false);
					$last_month = $dta['mon'];
				}
				$week[$wday] = $dta['mday'];
			}
			while ($dta['year'] == $year);
		}
		return $res;
	}
    
}
