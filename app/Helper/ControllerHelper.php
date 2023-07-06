<?php

namespace App\Helpers;

use Auth;
use File;
use Gate;
use Setting;
use App\PeakFactor;
use App\ShufflePeakFactor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class Helper
{
    
    public static function upload_picture(File $picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;
            
            $s3_url = url('/') . '/uploads/' . $local_url;
            
            return $s3_url;
        }
        return "";
    }
    
    
    public static function delete_picture($picture)
    {
        File::delete(public_path() . "/uploads/" . basename($picture));
        return true;
    }
    
    public static function generate_booking_id()
    {
        return Setting::get('booking_prefix') . mt_rand(100000, 999999);
    }
    
    public static function site_sendmail($user)
    {
        
        $site_details = Setting::all();
        
        
        Mail::send('emails.invoice', ['user' => $user, 'site_details' => $site_details], function ($mail) use ($user, $site_details) {
            // $mail->from('harapriya@appoets.com', 'Your Application');
            
            $mail->to($user->user->email, $user->user->first_name . ' ' . $user->user->last_name)->subject('Invoice');
        });
        
        return true;
    }
    
    public static function authorized($permission)
    {
        
        $user = Auth::guard('admin')->user();
        
        
        /*if (is_array($permission)) {
            $output = false;
            
            foreach ($permission as $value) {
                $result = Gate::forUser($user)->allows($value);
                if ($result){
                    return true;
                }
            }
            
            return $output;
        }*/
        
        return Gate::forUser($user)->allows($permission);
    }

    public static function GetShuffleCalendar($year = null, $peak = false, $off_hours = false) {
        $res = $year >= 1970;
        if ($res) {
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
                if (($dta['mon'] != $last_month) || ($wday == 1)) {
                    if ($week[1] || $week[7]) $res[$last_month][] = $week;
                    $week = array_fill(1, 7, false);
                    $last_month = $dta['mon'];
                }
                $week[$wday] = $dta['mday'];
            } while ($dta['year'] == $year);

            if ($peak == true) {
                $demand = ShufflePeakFactor::GetCustomerDemand();
                $peak = ShufflePeakFactor::where('year', $year)->get();

                foreach ($res as $month => $value) {
                    foreach ($value as $k => $week) {
                        foreach ($week as $week_k => $day) {
                            $calendar1[$month][$k][$week_k] = array($day,'N', null, null, 'N', 'N');
                            $calendar2[$month][$k][$week_k] = array($day,'N', null, null, 'N', 'N');
                            foreach ($peak as $p) {
                                if($p->month == $month && $p->day == $day && $p->pickup_value > 0)
                                {
                                    foreach ($demand as $d) {
                                        if ($p->pickup_value >= $d->min && $p->pickup_value <= $d->max) {
                                            $calendar1[$month][$k][$week_k][1] = $d->color;
                                            $calendar1[$month][$k][$week_k][4] = $p->value;
                                            $calendar1[$month][$k][$week_k][5] = $d->id;
                                        }
                                    }
                                }
                                foreach ($peak as $p) {
                                    if($p->month == $month && $p->day == $day && $p->dropoff_value > 0)
                                    {
                                        foreach ($demand as $d) {
                                            if ($p->dropoff_value >= $d->min && $p->dropoff_value <= $d->max) {
                                                $calendar2[$month][$k][$week_k][1] = $d->color;
                                                $calendar2[$month][$k][$week_k][4] = $p->value;
                                                $calendar2[$month][$k][$week_k][5] = $d->id;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if($off_hours == true) {
                $weeks = array(
                    1 => 'monday',
                    2 => 'tuesday',
                    3 => 'wednesday',
                    4 => 'thursday',
                    5 => 'friday',
                    6 => 'saturday',
                    7 => 'sunday'
                );

                $working_hours = DB::table('working_hours')->get();

                foreach ($res as $month => $value) {
                    foreach ($value as $k => $week) {
                        foreach($week as $week_k => $day) {
                            $week_day = $weeks[$week_k];
                            $calendar1[$month][$k][$week_k][2] = $week_day;
                            $calendar2[$month][$k][$week_k][2] = $week_day;

                            $line = '#ffffff00';
                            for($i = 0; $i <= count($working_hours); $i++) {
                                if(isset($working_hours[$i+1]->$week_day)) {
                                    if($working_hours[$i]->$week_day != $working_hours[$i+1]->$week_day) {
                                        if($working_hours[$i]->$week_day == 1) {
                                            $line = $line .$working_hours[$i]->percent.'% , red '.$working_hours[$i]->percent.'% ';
                                        }

                                        // if($working_hours[$i]->$week_day == 0) {
                                        //     $line = $line .$working_hours[$i-1]->percent.'% , #ffffff00 '.$working_hours[$i-1]->percent.'% ';
                                        // }
                                    }
                                }
                            }
                            
                            $calendar1[$month][$k][$week_k][3] = "linear-gradient(to right, $line)";
                            $calendar2[$month][$k][$week_k][3] = "linear-gradient(to right, $line)";
                        }
                    }
                }
            }
            $calendar = [$calendar1, $calendar2];
            return $calendar;
        }
    }

    public static function GetCelender($year=null,$peak=false,$off_hours=false) 
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
        
        $calender = $res;
        
        if($peak == true)
        {
            
            $demand = PeakFactor::GetCustomerDemand();
            $peak = PeakFactor::where('year',$year)->get();
            
            foreach ($calender as $month => $value) 
            {
                foreach ($value as $k =>$week) 
                {                
                    foreach($week as $week_k =>  $day) 
                    {
                        $calender[$month][$k][$week_k] = array($day,'N', null, null, 'N', 'N');
                        foreach($peak as $p) 
                        {
                            if($p->month == $month && $p->day == $day && $p->value > 0)
                            {
                                foreach ($demand as $d) {
                                    if ($p->value >= $d->min && $p->value <= $d->max) {
                                        $calender[$month][$k][$week_k][1] = $d->color;
                                        $calender[$month][$k][$week_k][4] = $p->value;
                                        $calender[$month][$k][$week_k][5] = $d->id;
                                    }
                                }
                            }
                        }
                    }                        
                }
            }
        }
        
        
        
        if($off_hours == true)
        {
            
            $weeks = array(1=>'monday',2=>'tuesday',3=>'wednesday',4=>'thursday',5=>'friday',6=>'saturday',7=>'sunday');
            
            $working_hours = DB::table('working_hours')->get();
            
            foreach ($calender as $month => $value) 
            {
                foreach ($value as $k =>$week) 
                {                
                    foreach($week as $week_k => $day) 
                    {
                        $week_day = $weeks[$week_k];
                        $calender[$month][$k][$week_k][2] = $week_day;
                        
                        $line = '#ffffff00 ';
                        for($i=0; $i<=count($working_hours); $i++)
                        {
                            if(isset($working_hours[$i+1]->$week_day))
                            {
                                if($working_hours[$i]->$week_day != $working_hours[$i+1]->$week_day)
                                {
                                    if($working_hours[$i]->$week_day == 1)
                                    {    
                                        $line = $line .$working_hours[$i]->percent.'% , red '.$working_hours[$i]->percent.'% ';
                                    }
                                    
                                    // if($working_hours[$i]->$week_day == 0)
                                    // {    
                                    //     $line = $line .$working_hours[$i-1]->percent.'% , #ffffff00 '.$working_hours[$i-1]->percent.'% ';
                                    // }
                                }
                            }
                        }
                        
                        $calender[$month][$k][$week_k][3] = "linear-gradient(to right, $line)";
                    }
                }
            }
        }
        
        return $calender;
    }

    
    public static function get_loading_time($booking_id, $num_worker) {
        $pick_up_location_info = DB::table('booking_form_items as i')->select('*')->join('inventories as ivn', 'ivn.id', '=', 'i.item_id')->join('booking_form_location as p_loc', 'i.pick_up_loc_id', '=', 'p_loc.booking_loc_id')->addSelect('ivn.ranking_id as inventory_ranking')->where('i.booking_id', $booking_id)->get();
        $pick_up_times = array();
        foreach ($pick_up_location_info as $item) {
            $inventory = json_decode(json_encode($item), true);

            if ($inventory["stair_kind"] == "stairs") {
                $times = Helper::get_flight_times($item->item_id, $num_worker, $item->flights, 0);
                $stair_factor = Helper::get_stair_time_factor($item->item_id, $num_worker, $item->stair_type);
                if (!isset($times)) {
                    $pick_up_times[$item->item_name] = 0;
                } else {
                    $pick_up_times[$item->item_name] = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $item->quantity / 3;
                }
            } else if ($inventory["stair_kind"] == "elevator" || $inventory["stair_kind"] == "both") {
                $times = Helper::get_elevator_times($item->item_id, $num_worker, $item->floor_num, 0);
                if (count($times) == 0) {
                    $pick_up_times[$item->item_name] = 0;
                } else {
                    if ($item->evelator_type == 'reserved_freight') {
                        $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                        $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                    } else {
                        $time = json_decode(json_encode($times), true)[0][$item->evelator_type . '_time'];
                        $delay = json_decode(json_encode($times), true)[0][$item->evelator_type . '_delay'];
                    }
                    $pick_up_times[$item->item_name] = ($time + $delay) * $inventory["quantity"];
                }
            } else if ($inventory["stair_kind"] == 'groundfloor') {
                $times = Helper::get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$item->item_name] = 0;
                } else {
                    $pick_up_times[$item->item_name] = ($times->groundfloor_min + $times->groundfloor_med + $times->groundfloor_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'bulkhead') {
                $times = Helper::get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$item->item_name] = 0;
                } else {
                    $pick_up_times[$item->item_name] = ($times->bulkhead_min + $times->bulkhead_med + $times->bulkhead_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'entrance') {
                $times = Helper::get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$item->item_name] = 0;
                } else {
                    $pick_up_times[$item->item_name] = ($times->en_steps_min + $times->en_steps_med + $times->en_steps_max) * $item->quantity;
                }
            }
            DB::table('booking_form_items')->where([
                'booking_item_id' => $item->booking_item_id
            ])->update([
                'pick_up_time' => $pick_up_times[$item->item_name]
            ]);
        }
        return $pick_up_times;

    }

    public static function get_unloading_time($booking_id, $num_worker) {
        $drop_off_location_info = DB::table('booking_form_items as i')->select('*')->join('inventories as ivn', 'ivn.id', '=', 'i.item_id')->join('booking_form_location as d_loc', 'i.drop_off_loc_id', '=', 'd_loc.booking_loc_id')->addSelect('ivn.ranking_id as inventory_ranking')->where('i.booking_id', $booking_id)->get();
        $total_drop_off_time = array();
        foreach ($drop_off_location_info as $item) {
            $inventory = json_decode(json_encode($item), true);

            // Formula is (min_time + med_time + max_time) / 3 * quantity
            if ($inventory["stair_kind"] == "stairs") {
                $times = Helper::get_flight_times($item->item_id, $num_worker, $item->flights, 1);
                $stair_factor = Helper::get_stair_time_factor($item->item_id, $num_worker, $item->stair_type);
                if (!isset($times)) {
                    $drop_off_times[$item->item_name] = 0;
                } else {
                    $drop_off_times[$item->item_name] = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $item->quantity / 3;
                }
            } else if ($inventory["stair_kind"] == "elevator" || $inventory["stair_kind"] == "both") {
                $times = Helper::get_elevator_times($item->item_id, $num_worker, $item->floor_num, 1);
                if (count($times) == 0) {
                    $drop_off_times[$item->item_name] = 0;
                } else {
                    if ($item->evelator_type == 'reserved_freight') {
                        $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                        $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                    } else {
                        $time = json_decode(json_encode($times), true)[0][$item->evelator_type . '_time'];
                        $delay = json_decode(json_encode($times), true)[0][$item->evelator_type . '_delay'];
                    }
                    $drop_off_times[$item->item_name] = ($time + $delay) * $inventory["quantity"];
                }
            } else if ($inventory["stair_kind"] == 'groundfloor') {
                $times = Helper::get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$item->item_name] = 0;
                } else {
                    $drop_off_times[$item->item_name] = ($times->groundfloor_min + $times->groundfloor_med + $times->groundfloor_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'bulkhead') {
                $times = Helper::get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$item->item_name] = 0;
                } else {
                    $drop_off_times[$item->item_name] = ($times->bulkhead_min + $times->bulkhead_med + $times->bulkhead_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'entrance') {
                $times = Helper::get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$item->item_name] = 0;
                } else {
                    $drop_off_times[$item->item_name] = ($times->en_steps_min + $times->en_steps_med + $times->en_steps_max) * $item->quantity;
                }
            }
            DB::table('booking_form_items')->where([
                'booking_item_id' => $item->booking_item_id
            ])->update([
                'drop_off_time' => $drop_off_times[$item->item_name]
            ]);
        }
        return $drop_off_times;

    }

    public static function get_dis_assembly_time($selected_items, $num_worker) {
        $additional_time = array();
        // echo '<pre>';
        foreach ($selected_items as $item) {
            // print_r($item);
            if (isset($item->ranking)) {
                $alphabet = DB::table('ranking')->where([
                    'ranking_id' => $item->ranking
                ])->select('alphabet')->first()->alphabet;
                $additional_time[$item->item_name] = Helper::get_dis_assembly($item->item_id, $num_worker, $alphabet);
            }
        }
        // exit;
        return $additional_time;
    }

    static function roundupToAny($n, $x = 5) {
        return (ceil($n) % $x === 0) ? ceil($n) : round(($n + $x / 2) / $x) * $x;
    }

    static function get_dis_assembly($item_id, $num_worker, $alphabet) {
        $data = DB::table('inventory_dis_assembly')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker
        ])->select('R_' . $alphabet)->get();
        if (count($data) == 0) {
            return 0;
        } else {
            return json_decode(json_encode($data->toArray()[0]), true)['R_' . $alphabet];
        }
    }

    static function get_flight_times($item_id, $num_worker, $num_flights, $location_type) {
        $times = DB::table('inventory_time_flights')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
            'num_flights' => $num_flights,
            'location_type' => $location_type
        ])->first();
        return $times;
    }

    static function get_stair_time_factor($item_id, $num_worker, $type) {
        $factor = DB::table('inventory_stair_time_factor')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
        ])->select($type)->get();
        if (count($factor) == 0) {
            return 0;
        } else {
            return json_decode(json_encode($factor->toArray()[0]), true)[$type];
        }
    }

    static function get_elevator_times($item_id, $num_worker, $num_floor, $location_type) {
        $times = DB::table('inventory_time_elevator')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
            'num_floor' => $num_floor,
            'location_type' => $location_type
        ])->get();
        return $times;
    }

    static function get_bulkhead_times($item_id, $num_worker, $num_stairs, $location_type) {
        $times = DB::table('inventory_time_extra')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
            'num_stairs' => $num_stairs,
            'location_type' => $location_type
        ])->first();
        return $times;
    }

}
