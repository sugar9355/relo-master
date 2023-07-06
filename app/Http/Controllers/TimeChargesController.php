<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\TimeCharges;
use App\Booking;
use App\PeakFactorDevice;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Exception;

class TimeChargesController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('timeCharges')){
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
		
		$time_charges = TimeCharges::get();
		
		
        return view('admin.timeCharges.index', compact('time_charges'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
	
		$time_range = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$time_mode = array('AM','PM');
		$interval = array(':00',':30');
		
        return view('admin.timeCharges.create', compact('time_range','time_mode','interval'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		//dd($request->all());

		TimeCharges::where('int_start',$request->digit_start_time_am)->where('int_end',$request->digit_end_time_am)->delete();
		TimeCharges::where('int_start',$request->digit_start_time_pm)->where('int_end',$request->digit_end_time_pm)->delete();
		
		if(isset($request->start_time_am) && isset($request->end_time_am) && isset($request->value_am) && isset($request->digit_start_time_am) && isset($request->digit_end_time_am))
		{
			$TimeChargesAM = new TimeCharges;
			$TimeChargesAM->start_time = $request->start_time_am;
			$TimeChargesAM->end_time = $request->end_time_am;
			$TimeChargesAM->value = $request->value_am;
			$TimeChargesAM->int_start = $request->digit_start_time_am;
			$TimeChargesAM->int_end = $request->digit_end_time_am;
			$TimeChargesAM->created_at = now();
			$TimeChargesAM->updated_at = now();
			$TimeChargesAM->save();
		}

		if(isset($request->start_time_pm) && isset($request->end_time_pm) && isset($request->value_pm) && isset($request->digit_start_time_pm) && isset($request->digit_end_time_pm))
		{
			$TimeChargesPM = new TimeCharges;
			$TimeChargesPM->start_time = $request->start_time_pm;
			$TimeChargesPM->end_time = $request->end_time_pm;
			$TimeChargesPM->value = $request->value_pm;
			$TimeChargesPM->int_start = $request->digit_start_time_pm;
			$TimeChargesPM->int_end = $request->digit_end_time_pm;
			$TimeChargesPM->created_at = now();
			$TimeChargesPM->updated_at = now();
			$TimeChargesPM->save();
		}	
		
		return redirect()->route('admin.timecharges.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param PeakFactor $timeCharge
     * @return Response
     */
    public function edit(TimeCharges $timecharges)
    {
	
		$time_range = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$time_mode = array('AM','PM');
		$interval = array(':00',':30');
        return view('admin.timeCharges.edit', compact('timecharges','time_range','time_mode','interval'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PeakFactor $timeCharge
     * @return Response
     */
    public function update(Request $request, TimeCharges $timeCharge)
    {
        $timeCharge->update($request->all());
        $timeCharge->save();
        return redirect()->route('admin.timecharges.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param PeakFactor $timeCharge
     * @return Response
     */
    public function destroy(TimeCharges $timeCharge,$id)
    {
       TimeCharges::where('id',$id)->delete();
	   return redirect()->route('admin.timecharges.index');
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
