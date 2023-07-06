<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\ShufflePeakFactor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Exception;

class ShufflePeakFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->btn_last) || isset($request->btn_next)) {
            if(isset($request->btn_next)) {
                $c_date = $request->btn_next;
            }
            if(isset($request->btn_last)) {
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

        } else {
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

        $collection = ShufflePeakFactor::orderBy('id', 'DESC');
        $collection = $collection->where('month', $c_date['now_month']);
        $collection = $collection->where('year', $c_date['now_year']);
        $peakFactor1 = $collection->pluck('pickup_value', 'day');
        $peakFactor2 = $collection->pluck('dropoff_value', 'day');

        $calendar = $this->GetCalendar(date("Y"));

        $CustomerDemand = ShufflePeakFactor::GetCustomerDemand();

        return view('admin.shufflePeakFactors.index', compact('peakFactor1', 'peakFactor2', 'calendar', 'c_date', 'CustomerDemand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->btn_customer_demand) && $request->btn_customer_demand) {
            $demands = json_decode($request->demands, true);
            foreach ($demands as $demand) {
                DB::table('shuffle_customer_demand')->where(["id" => $demand['id']])->update([
                    "min" => $demand["min"],
                    "max" => $demand["max"],
                    "color" => $demand['color'],
                    "updated_at" => time(),
                ]);
            }
            return redirect()->route('admin.shufflepeakfactor.index');
        } elseif (isset($request->btn_last) || isset($request->btn_next)) {
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
            
            $collection = ShufflePeakFactor::orderBy('id', 'DESC');
            $collection = $collection->where('month', $c_date['now_month']);
            $collection = $collection->where('year', $c_date['now_year']);
            $peakFactor1 = $collection->pluck('pickup_value', 'day');
            $peakFactor2 = $collection->pluck('dropoff_value', 'day');
    
            $calendar = $this->GetCalendar(date("Y"));
    
            $CustomerDemand = ShufflePeakFactor::GetCustomerDemand();
    
            return view('admin.shufflePeakFactors.index', compact('peakFactor1', 'peakFactor2', 'calendar', 'c_date', 'CustomerDemand'));
        } else {
            ShufflePeakFactor::where('month', $request->month)->delete();
            
            foreach($request->peak as $key => $days)
            {
                foreach($days as $k => $val)
                {
                    $insert[$k]['year'] = $request->year;
                    $insert[$k]['month'] = $key;
                    $insert[$k]['day'] = $k;
                    $insert[$k]['pickup_value'] = $val[0];
                    $insert[$k]['dropoff_value'] = $val[1];
                    $insert[$k]['status'] = 1;
                    $insert[$k]['created_at'] = time();
                    $insert[$k]['updated_at'] = time();
                }
            }
            
            ShufflePeakFactor::insert($insert);
            return redirect()->route('admin.shufflepeakfactor.index');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\shuffle_peak_factor  $shuffle_peak_factor
     * @return \Illuminate\Http\Response
     */
    public function show(shuffle_peak_factor $shuffle_peak_factor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\shuffle_peak_factor  $shuffle_peak_factor
     * @return \Illuminate\Http\Response
     */
    public function edit(shuffle_peak_factor $shuffle_peak_factor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\shuffle_peak_factor  $shuffle_peak_factor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shuffle_peak_factor $shuffle_peak_factor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\shuffle_peak_factor  $shuffle_peak_factor
     * @return \Illuminate\Http\Response
     */
    public function destroy(shuffle_peak_factor $shuffle_peak_factor)
    {
        //
    }

    function GetCalendar($year) 
    {
        $res = $year >= 1970;
        if ($res) {
            // this line gets and sets same timezone, don't ask why :)
            date_default_timezone_set(date_default_timezone_get());

            $dt = strtotime("-1 day", strtotime("$year-01-01 00:00:00"));
            $res = array();
            $week = array_fill(1, 7, false);
            $last_month = 1;
            $w = 1;

            do {
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
            } while ($dta['year'] == $year);
        }
        return $res;
    }
}
