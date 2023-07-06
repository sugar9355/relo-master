<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Helpers\Helper;
use App\PeakFactor;
use App\Booking;
use App\PeakFactorDevice;
use App\Truck;
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
			$demands = json_decode($request->demands, true);
			foreach ($demands as $demand) {
				DB::table('customer_demand')->where(["id" => $demand['id']])->update([
					"min" => $demand["min"],
					"max" => $demand["max"],
					"color" => $demand['color'],
					"updated_at" => time(),
				]);
			}
			return redirect()->route('admin.peakfactor.index');
		} else if ($request->customer_demand_remove) {
			DB::table('customer_demand')->where(["id" => $request->customer_demand_remove])->delete();
			// echo '<pre>';
			// print_r($request->customer_demand_remove);
			// echo '</pre>';
			// exit;
			return redirect()->route('admin.peakfactor.index');
		} else if (isset($request->btn_last) || isset($request->btn_next)) {
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
			
			$peakFactor = PeakFactor::orderBy('id', 'DESC');
			$peakFactor = $peakFactor->where('month',$c_date['now_month']);
			$peakFactor = $peakFactor->where('year',$c_date['now_year']);
			$peakFactor = $peakFactor->pluck('value','day');
			
			$calender = $this->GetCelender(date("Y"));
			
			$CustomerDemand = PeakFactor::GetCustomerDemand();

			return view('admin.peakFactors.index', compact('peakFactor','calender','c_date','CustomerDemand'));
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
			return redirect()->route('admin.peakfactor.index');
		}
		
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

	public function demand_create() {
		return view('admin.peakFactors.demand_create');
	}

	public function demand_store(Request $request) {
		$request->validate([
			'demand_name' => 'required',
			'min' => 'required',
			'max' => 'required',
			'color' => 'required',
		]);

		DB::table('customer_demand')->insert([
			'demand_name' => $request->demand_name,
			'min' => $request->min,
			'max' => $request->max,
			'color' => $request->color,
			'created_at' => time(),
			'updated_at' => time()
		]);

        return redirect()->route('admin.peakfactor.index');
	}

	public function reservation_fee(Request $request) {
		$trucks = Truck::select('id', 'name', 'type')->get();
		$demand_fees = DB::table('vehicle_demand_rate')->where([
			'demand_id' => $request->demand_id,
		])->select('*')->get();
		foreach ($trucks as $truck) {
			foreach ($demand_fees as $fee) {
				if ($truck->id == $fee->vehicle_id) {
					$truck->fee = $fee->reservation_fee;
				}
			}
			$truck->fee = ($truck->fee) ? $truck->fee : 0;
		}
		$demand_id = $request->demand_id;
		return view('admin.peakFactors.reservation_fee', compact('trucks', 'demand_id'));
	}

	public function reservation_fee_store(Request $request) {
		$fees = json_decode($request->fees, true);
		foreach ($fees as $fee) {
			$confirm = DB::table('vehicle_demand_rate')->where([
				'demand_id' => $request->demand_id,
				'vehicle_id' => $fee['vehicle_id']
			])->select('*')->get();
			if ($confirm->toArray() == []) {
				DB::table('vehicle_demand_rate')->insert([
					'demand_id' => $request->demand_id,
					'vehicle_id' => $fee['vehicle_id'],
					'reservation_fee' => $fee['fee']
				]);
			} else {
				DB::table('vehicle_demand_rate')->where([
					'demand_id' => $request->demand_id,
					'vehicle_id' => $fee['vehicle_id']
				])->update([
					'reservation_fee' => $fee['fee']
				]);
			}
		}

        return redirect()->route('admin.peakfactor.index');
	}
}
