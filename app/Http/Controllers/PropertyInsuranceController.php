<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\PropertyInsurance;
use App\Booking;
use App\PeakFactorDevice;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Exception;

class PropertyInsuranceController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('propertyInsurance')){
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
		
		$properties = PropertyInsurance::get();
		
        return view('admin.propertyInsurance.index', compact('properties'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
	
        return view('admin.propertyInsurance.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		 $PropertyInsurance = new PropertyInsurance;
		 $PropertyInsurance->name = $request->name;
		 $PropertyInsurance->value = $request->value;
		 $PropertyInsurance->created_at = now();
		 $PropertyInsurance->updated_at = now();
		 $PropertyInsurance->save();
		//PropertyInsurance::insert($request->all());
		
		return redirect()->route('admin.propertyInsurance.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param PeakFactor $peakFactor
     * @return Response
     */
    public function edit(PropertyInsurance $PropertyInsurance)
    {

        return view('admin.propertyInsurance.edit', compact('PropertyInsurance'));
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
        return redirect()->route('admin.propertyInsurance.index');
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
