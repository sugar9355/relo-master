<?php

namespace App\Http\Controllers;

use Setting;
use DateTime;
use App\Category;
use App\TimeCharges;
use App\Accuracy;
use App\PropertyInsurance;
use App\InsuranceCategory;
use App\Inventory;
use App\Question;
use App\Service;
use App\Truck;
use App\Dlevel;
use App\UserSchedule;
use App\Preset;
use App\PeakFactor;
use App\ShufflePeakFactor;
use App\ShuffleFee;
use App\VehicleSchedule;
use App\Booking;
use App\Role;
use App\UserMovingRequest;
use App\User;
use App\ZoneType;
use Illuminate\Support\Facades\Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Stripe;
use App\Helpers\Helper;
use Twilio\TwiML\MessagingResponse;

use Jenssegers\Agent\Agent;
use Mailgun\Mailgun;

class HomeController extends Controller
{

    public function replyhook(Request $request){
  
    $from  = $request->input('From');
    $body = $request->input('Body');

    $updated = DB::table('msgs')->increment('count_msg', 1, ['phone_number' =>$from]);
    $response = new MessagingResponse();
    $message = $response->message('');
    $message->body($from.$body); 
     return response($response)->header('Content-Type', 'application/xml');
    }



    public function save_step1($request,$booking_id)
    {
        $service['step'] = 2;
        $service['user_id'] = Auth::user()->id;
        $service['service_type_id'] = $request->service_type_id;
        $booking_id = $booking = booking::insertGetId($service);
        return redirect()->to('booking/'.$booking_id);
    }
    public function save_step2($request,$booking_id)
    {
        $validator = Validator::make($request->all(),
        [
            'location' => 'required',
        ]);
        
        if($validator->fails()) 
        {
            return back()->withErrors($validator);
        }
        else
        {
            DB::beginTransaction();
            
                booking::delete_location($booking_id);
            
                foreach($request->location as $k => $location)
                {
                    if($k == 0)
                    {
                        $step_update['s_address'] = $location;
                        
                        $data['location'] = $location;
                        $data['lat'] = $request->s_lat;
                        $data['lng'] = $request->s_lng;
                        $data['zip_code'] = $request->s_zipcode;
                        $data['curbside'] = isset($request->curbside[$k]) ? 1 : 0;
                    }
                    if($k > 0)
                    {
                        $step_update['d_address'] = $location;
                        
                        $data['location'] = $location;
                        $data['lat'] = $request->d_lat;
                        $data['lng'] = $request->d_lng;
                        $data['zip_code'] = $request->d_zipcode;
                        $data['curbside'] = isset($request->curbside[$k]) ? 1 : 0;
                    }
                    
                    $data['booking_id'] = $booking_id;
                    $data['location'] = $location;
                    booking::save_location($data);
                }
                
                $way_points = array();
                if(isset($request->waypoints))
                {
                    foreach($request->waypoints as $k => $loc)
                    {
                        $way_points[$k]['booking_id'] = $booking_id;
                        $way_points[$k]['location'] = $loc['location'];
                        $way_points[$k]['lat'] = $loc['lat'];
                        $way_points[$k]['lng'] = $loc['lng'];
                        $way_points[$k]['curbside'] = isset($request->curbside[$k + 2]) ? 1 : 0;
                    }
                }
                
                booking::save_location($way_points);
                
                $step_update['s_lat'] = $request->s_lat;
                $step_update['s_lng'] = $request->s_lng;
                $step_update['d_lat'] = $request->d_lat;
                $step_update['d_lng'] = $request->d_lng;
                
                $time_H_A = $this->GetHubTime($request->s_lat,$request->s_lng);
                $time_B_H = $this->GetHubTime($request->d_lat,$request->d_lng);
                
                if($time_H_A && $time_B_H)
                {
                    $step_update['time_from_hub'] = $time_H_A;
                    $step_update['time_to_hub']   = $time_B_H;
                }
                else
                {
                    session()->put("msg", 'Something is wrong (Hub Time Not Found)');
                    return redirect()->to('booking/'.$booking_id);
                }
                
                $step_update['distance'] = $request->distance;
                $step_update['minutes'] = $request->minutes;
                
                $step_update['step'] = 4;
                booking::where('booking_id',$booking_id)->update($step_update);
            
            DB::commit();
            
            return redirect()->to('booking/'.$booking_id);
        }
    }
    // public function save_step3($request,$booking_id)
    // {
        // //dd($request);
        // booking::delete_booking_dates($booking_id);
        
        // foreach($request->booking_date as $k => $booking_date)
        // {
            // if(!empty($booking_date['date']) && !empty($booking_date['start_time']) && !empty($booking_date['end_time']))
            // {
            
                // $date = date('Y-m-d',strtotime($booking_date['date']));
                
                // if($k == 0)
                // {
                    // $data['step'] = 4;
                    // $data['flexibilty'] = 'SS';
                    // $data['primary_date'] = $date;
                    // $data['booking_date'] = $date;
                    // $data['start_time'] = '9';
                    // booking::where('booking_id',$booking_id)->update($data);
                // }
                
                // if($k == 1)
                // {
                    // $data['step'] = 4;
                    // $data['flexibilty'] = 'SS';    
                    // $data['secondary_date'] = $date;
                    // booking::where('booking_id',$booking_id)->update($data);
                // }
    
                // $dates['booking_id']      = $booking_id;
                // $dates['booking_date']      = $date;
                // $dates['start_time']      = $booking_date['start_time'];
                // $dates['end_time']          = $booking_date['end_time'];
                // $dates['status']          = 1;
                // $dates['created_at']      = now();
                // $dates['updated_at']      = now();
                
                // booking::save_booking_dates($dates);
            // }
        // }
        
        // return redirect()->to('booking/'.$booking_id);
    // }
    
    public function save_step4($request,$booking_id)
    {

        $validator = Validator::make($request->all(), 
        [
            'floor'         => 'required',
            'stair_kind'    => 'required',
            'building_type'     => 'required',
            // 'flights'         => 'required',
            'parking'         => 'required',
        ]);
        
        if($validator->fails()) 
        {
            session()->put("msg", 'Please Enter Complusory Information');
            return back()->withErrors($validator);

        }
        else
        {
            $number_locations = count($request->booking_location_pk);
            DB::beginTransaction();
            $data_temp = array();
            
            for($i=0; $i < $number_locations; $i++)
            {
                $data['floor']                = $request->floor[$i];
                $data['stair_kind']         = $request->stair_kind[$i];
                $data['building_type']         = $request->building_type[$i];
                $data['stair_type']         = isset($request->stair_type[$i]) ? $request->stair_type[$i] : null;
                $data['step_num']             = isset($request->step_num[$i]) ? $request->step_num[$i] : null;
                $data['ex_stair']             = isset($request->ex_stair[$i]) ? (int)$request->ex_stair[$i] : null;
                $data['stair_floor_num']     = isset($request->stair_floor_num[$i]) ? $request->stair_floor_num[$i] : null;
                $data['floor_num']             = isset($request->floor_num[$i]) ? $request->floor_num[$i] : null;
                $data['evelator_type']         = isset($request->evelator_type[$i]) ? $request->evelator_type[$i] : null;
                $data['flights']             = isset($request->flights[$i]) ? $request->flights[$i] : null;
                $data['parking']             = isset($request->parking[$i]) ? $request->parking[$i] : null;
                $data['walk']                 = $request->walk[$i];
                $data['walk_time']            = $request->walk_min[$i] + $request->walk_sec[$i];
                $data['walk_min']             = $request->walk_min[$i];
                $data['walk_sec']             = $request->walk_sec[$i];
                if(isset($request->walk_time[$i]) && !empty($request->walk_time[$i]))
                {
                    $data['walk_time'] = $request->walk_time[$i];
                }
                else
                {
                    $data['walk_time'] = 0;
                }
                
                $data['comments']         = isset($request->comments[$i]) ? $request->comments[$i] : '';
                array_push($data_temp, $data);
                
                $booking_location_id     = $request->booking_location_pk[$i];
                
                booking::update_location($data,$booking_id,$booking_location_id);
            }
            // dd($data_temp);
            
            $step_update['step'] = 5;
            booking::where('booking_id',$booking_id)->update($step_update);
            
            DB::commit();
            return redirect()->to('booking/'.$booking_id);
        }
    }
    

    // public function save_step5($request,$booking_id) // Shop
    // {
        
        // DB::beginTransaction();
        
        // $booking_truck = booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();
        
        // $inventory = Inventory::where(array('id'=>$request->item_id))->first();
        
        // $data['item_id']         = $inventory->id;
        // $data['truck_id']         = $booking_truck->truck_id;
        // $data['item_name']         = $inventory->name;
        // $data['item_image']      = isset($inventory->item_image) ? $inventory->item_image : 0;
        // $data['file_path']          = $inventory->file_path;
        // $data['quantity']          = 1;
        // $data['breadth']          = $inventory->breadth;
        // $data['height']          = $inventory->height;
        // $data['width']               = $inventory->width;
        // $data['volume']          = $inventory->width * $inventory->height * $inventory->breadth;
        // $data['weight']          = $inventory->weight;
        // $data['similar']          = $inventory->similar;
        
        // if(isset($request->ranking) && !empty($request->ranking))
        // {
            // $data['ranking'] = $request->ranking;
        // }
        // else
        // {
            // $data['ranking'] = null;
        // }        
        
        
        // $data['pick_up_loc_id']  = $request->pick_up_loc_id;
        // $data['drop_off_loc_id'] = $request->drop_off_loc_id;
        // $data['booking_id']      = $booking_id;
        // $data['created_at']      = now();
        // $data['updated_at']      = now();
        // $data['booking_item_id'] = $booking_item_id = booking::save_item($data);
        
        
        // $update_item['pick_up_time']  = $this->item_moving_time($request,$data,'pick_up');
        // $update_item['drop_off_time'] = $this->item_moving_time($request,$data,'drop_off');
        // $where['booking_item_id'] = $booking_item_id;
        // $booking_item_id = booking::update_item($update_item,$where);
        
        
        // if(isset($request->answer))
        // {
            // foreach($request->answer as $q_id => $val)
            // {
                // $item_answer['booking_id'] = $booking_id;
                // $item_answer['item_id'] = $request->item_id;
                // $item_answer['question_id'] = $q_id;
                // $item_answer['answer'] = $val;
                // booking::save_answer($item_answer);    
            // }
        // }
        
        // if ($request->hasFile('picture') && !empty($booking_item_id)) 
        // {
            // $this->upload_picture($request,$booking_id,$booking_item_id);
        // }    

        // $truck_schedule = VehicleSchedule::where('booking_id',$booking_id)->where('truck_id',$data['truck_id'])->first();
        
        // if(isset($truck_schedule->id))
        // {
            // $p['booking_id'] = $booking_id;
            // $booking_items = booking::get_booking_items($p);
            
            
            // $item_total_volume = 0;
            // foreach($booking_items as $item_volume)
            // {
                // $item_total_volume = $item_total_volume + ($item_volume->volume * $item_volume->quantity);
            // }
            
            // if($item_total_volume < $booking_truck->volume)
            // {
                // $moving_time = $update_item['pick_up_time'] + $update_item['drop_off_time'];
                // $vehicle_sch['end_time'] = date('g:i A', strtotime("+{$moving_time} minutes", strtotime($truck_schedule->end_time)));
                // VehicleSchedule::where('truck_id',$data['truck_id'])->update($vehicle_sch);
            // }
        // }
        
        // DB::commit();
        
        // return redirect()->to('booking/'.$booking_id);
    // }
    
    
    
    public function save_step6($request,$booking_id)
    {
        
        //dd($request->all());
        
        $insuranceCategories = InsuranceCategory::all();
        
        DB::beginTransaction();
        
        
        if(isset($insuranceCategories[0]))
        {
            
            booking::delete_insurance($booking_id);
            
            foreach($request->items as $key => $insurance)
            {
                $data['booking_id'] = $booking_id;
                $data['booking_item_id'] = $key;
                $data['insurance_id'] = $insurance['insurance'];
                
                foreach($insuranceCategories as $k => $ins)
                {
                    if($ins->id == $insurance['insurance'])
                    {
                        $data['insurance_type'] = $ins->name;
                        $data['ratio'] = $ins->ratio;
                        
                        if($insurance['you_pay'] > 0)
                        {
                        $data['we_pay'] = ($insurance['you_pay'] * explode(':',$ins->ratio)[1]);
                        $data['you_pay'] = $insurance['you_pay'];
                        }
                        else
                        {
                            $data['we_pay'] = 0;
                            $data['you_pay'] = 0;    
                        }
                        
                    }
                }
                
                booking::save_insurance($data);
            }
            //dd($request->property_items);
            // foreach($request->property_items as $key => $property)
            // {
                // $prop_data['booking_id'] = $booking_id;
                // $prop_data['name'] = $property['name'];
                // $prop_data['insurance_id'] = $property['insurance'];
                
                // foreach($insuranceCategories as $k => $ins)
                // {
                    // if($ins->id == $property['insurance'])
                    // {
                        // $prop_data['insurance_type'] = $ins->name;
                        // $prop_data['ratio'] = $ins->ratio;
                        
                        // if($property['you_pay'] > 0)
                        // {
                            // $prop_data['we_pay'] = ($property['you_pay'] * explode(':',$ins->ratio)[1]);
                            // $prop_data['you_pay'] = $property['you_pay'];
                        // }
                        // else
                        // {
                            // $prop_data['we_pay'] = 0;
                            // $prop_data['you_pay'] = 0;
                        // }
                        
                    // }
                // }
                
                // booking::save_property_insurance($prop_data);
            // }
            
        }
        
        
        $step_update['step'] = 7;
        booking::where('booking_id',$booking_id)->update($step_update);
        
        DB::commit();
        
        return redirect()->to('booking/'.$booking_id);
    
    }
    
    public function save_finish($request,$booking_id)
    {
        DB::beginTransaction();
        
        if(isset($request->items))
        {
            foreach($request->items as $key => $items)
            {
                $update_items['pakaging'] = isset($items['pakaging']) ? $items['pakaging'] : 0;
                $update_items['junk_removal'] = isset($items['junk_removal']) ? $items['junk_removal'] : 0;
                $where_items['booking_item_id'] = $key;
                booking::update_item($update_items,$where_items);
            }
        }
        
        //$step_update['accuracy'] = $request->accuracy;
        $step_update['step'] = 8;    
        booking::where('booking_id',$booking_id)->update($step_update);
        
        DB::commit();
        
        return redirect()->to('summary/'.$booking_id);
    }
    
    public function checkout($request,$booking_id)
    {
    
        DB::beginTransaction();
        
            $step_update['step'] = 0;    
            booking::where('booking_id',$booking_id)->update($step_update);
            
        DB::commit();
        
        $this->get_available_truck($booking_id);
        
        return redirect()->to('dashboard');
    }
    
    public function save_step7($request, $booking_id) {
        $booking = booking::where('booking_id', $booking_id)->first();

        // checking the booking date

        if ($booking->service_type_id != 6) {
            $today = new DateTime();
            $booking_date = new DateTime($booking->booking_date);
            $diff = date_diff($today, $booking_date);
            if ($diff->d > 5) {
                return redirect()->to('booking/' . $booking_id . '?show_alert=true&reason=date');
            } else {
    
                // checking difficulty level
    
                $dlevel = Dlevel::where('id', $booking->dlevel)->first()->dlevel;
                if(explode('-', $dlevel)[1] > 3) {
                    return redirect()->to('booking/' . $booking_id . '?show_alert=true&reason=dlevel');
                } else {
                    // crew assignment
                    $crew_combination = $this->get_crew_combination($booking->dlevel, $booking->crew_count);
    
                    if (!$crew_combination) {
                        return redirect()->to('booking/' . $booking_id . '?show_alert=true&reason=crew_combination');
                    } else {
                        $crew_roles = explode(',', $crew_combination->roles);
                        $crew_levels = explode(',', $crew_combination->levels);
                        $selected_crews_data = array();
                        foreach ($crew_roles as $i => $item) {
                            $selected_crews_data[$i]['role'] = $crew_roles[$i];
                            $selected_crews_data[$i]['level'] = $crew_levels[$i];
                        }
    
                        $crews = DB::table('users as u')
                        ->selectRaw('u.id,first_name,last_name,ur.role_id as role,ul.level')
                        ->join('role_user as ur', 'ur.user_id', '=', 'u.id')
                        ->join('roles as r', 'r.id', '=', 'ur.role_id')
                        ->join('user_level as ul', 'ul.user_id', '=', 'u.id')->get();
    
                        foreach($selected_crews_data as $k => $data) {
                            $worker[$data['role']] = [];
                            foreach($crews as $crew) {
                                if($data['role'] == $crew->role && $data['level'] == $crew->level) {
                                    array_push($worker[$data['role']], array(
                                        'role' => $crew->role,
                                        'id' => $crew->id
                                    ));
                                }
                            }
                        }
    
                        $booking_day = substr(date('l', strtotime($booking->booking_date)), 0, 3);
                        $booking_start_time = strtotime($booking->start_time);
                        $booking_end_time = strtotime($booking->end_time);
    
                        // checking crew availability
                        $assigned_crews = array();
                        foreach($worker as $w) {
                            foreach ($w as $e) {
                                // Checking Scheduled Time
    
                                $schedule_time = UserSchedule::where([
                                    'user_id' => $e['id']
                                ])->first();
                                if (isset($schedule_time) && $schedule_time->toArray()[$booking_day]) {
                                    $schedule_start_time = strtotime($schedule_time->start_time . ' ' . $schedule_time->start_unit);
                                    $schedule_end_time = strtotime($schedule_time->end_time . ' ' . $schedule_time->end_unit);
                                    if ($schedule_start_time <= $booking_start_time && $schedule_end_time >= $booking_end_time) {
    
                                        // Checking Available Time
                                        $field_name = '';
                                        switch($e['role']) {
                                            case 4:
                                                $field_name = 'captain_id';
                                                break;
                                            case 5:
                                                $field_name = 'helper_id';
                                                break;
                                            case 6:
                                                $field_name = 'technician_id';
                                                break;
                                            case 7:
                                                $field_name = 'hauler_id';
                                                break;
                                        }
    
                                        $assigned_bookings = DB::table('job_assigned_users')->where($field_name, $e['id'])->get();
                                        if (count($assigned_bookings) == 0) {
                                            // TODO: Checking Badges
                                            $assigned_crews[$e['role']] = $e['id'];
                                        } else {
                                            foreach ($assigned_bookings as $b) {
                                                $other_booking = Booking::where('booking_id', $b->booking_id)->first();
                                                if (isset($other_booking) && ($booking->booking_date == $other_booking->booking_date)) {
                                                    if (($booking->start_time > $other_booking->end_time) || ($booking->end_time < $other_booking->start_time) ) {
    
                                                        // TODO: Checking Badges
                                                        $assigned_crews[$e['role']] = $e['id'];
    
                                                    } else {
                                                        break;
                                                    }
                                                } elseif (isset($other_booking) && ($booking->booking_date != $other_booking->booking_date)) {
                                                        // TODO: Checking Badges
                                                        $assigned_crews[$e['role']] = $e['id'];
                                                }
                                            }
                                        }
    
                                    } else {
                                        break;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                        if (count($assigned_crews) == $booking->crew_count) {
                            DB::table('job_assigned_users')->insert([
                                'booking_id' => $booking->booking_id,
                                'user_id' => $booking->user_id,
                                'captain_id' => isset($assigned_crews[4]) ? $assigned_crews[4] : null,
                                'helper_id' => isset($assigned_crews[5]) ? $assigned_crews[5] : null,
                                'technician_id' => isset($assigned_crews[6]) ? $assigned_crews[6] : null,
                                'hauler_id' => isset($assigned_crews[7]) ? $assigned_crews[7] : null,
                                'specialist_id' => isset($assigned_crews[8]) ? $assigned_crews[8] : null,
                                'created_by' => $booking->user_id,
                                'updated_by' => $booking->user_id,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
    
                            DB::table('booking_form_charges')->insert([
                                'booking_id' => $booking_id,
                                'mob_charges' => $request->mobilization_charges,
                                'crew_charges' => $request->crew_charges,
                                'additional_charges' => $request->additional_charges,
                                'insurance_charges' => $request->insurance_charges,
                                'total_charges' => isset($request->total_charges) ? $request->total_charges : 0
                            ]);
                            $step_update['step'] = 7;
                            booking::where('booking_id', $booking_id)->update($step_update);
                            return redirect()->to('booking/' . $booking_id);
    
                        } else {
                            return redirect()->to('booking/' . $booking_id . '?show_alert=true&reason=nocrews');
                        }
                    }
                }
            }
        } else {
            DB::table('booking_form_charges')->insert([
                'booking_id' => $booking_id,
                'mob_charges' => $request->mobilization_charges,
                'crew_charges' => $request->crew_charges,
                'additional_charges' => $request->additional_charges,
                'insurance_charges' => $request->insurance_charges,
                'total_charges' => isset($request->total_charges) ? $request->total_charges : 0
            ]);
            $step_update['step'] = 7;
            booking::where('booking_id', $booking_id)->update($step_update);
            return redirect()->to('booking/' . $booking_id);
        }
    }

    public function save_submit($request, $booking_id) {
        $validator = Validator::make($request->all(), [
            'pay_card_num' => 'required',
            'pay_phone_num' => 'required',
            'per_first_name' => 'required',
            'per_last_name' => 'required',
            'per_phone_num' => 'required',
            'per_email' => 'required',
            'per_str_addy' => 'required',
            'per_city' => 'required',
            'per_state' => 'required',
            'per_zip_code' => 'required',
        ]);
        if($validator->fails()) {
            session()->put("msg", 'Please Enter Complusory Information');
            return back()->withErrors($validator);
        } else {
            DB::table('booking_payment_info')->insert([
                'booking_id' => $booking_id,
                'first_name_card' => isset($request->pay_first_name) ? $request->pay_first_name : null,
                'last_name_card' => isset($request->pay_last_name) ? $request->pay_last_name : null,
                'card_number' => $request->pay_card_num,
                'expire_month' => isset($request->pay_expire_mon) ? $request->pay_expire_mon : null,
                'expire_year' => isset($request->pay_expire_year) ? $request->pay_expire_year : null,
                'cvv' => isset($request->pay_cvv) ? $request->pay_cvv : null,
                'phone_number' => $request->pay_phone_num,
                'billing_address' => isset($request->billing_addy) ? $request->billing_addy : null,
            ]);
            DB::table('booking_personal_info')->insert([
                'booking_id' => $booking_id,
                'first_name' => $request->per_first_name,
                'last_name' => $request->per_last_name,
                'phone_number' => $request->per_phone_num,
                'email' => $request->per_email,
                'street_name' => $request->per_str_addy,
                'city_name' => $request->per_city,
                'apt_number' => $request->per_apt_num,
                'state' => $request->per_state,
                'zip_code' => $request->per_zip_code,
            ]);

            $template = DB::table('mail_templates')

            ->selectRaw('template_id,from_email,template_subject,template')

            ->where('template_id','0')

            ->get();

            $mgClient = Mailgun::create(env('MAIL_GUN_PRIVATE'));
            $domain = env('MAIL_GUN_DOMAIN');
            $params = array(
                'from'    => $template[0]->from_email,
                'to'      => $request->per_email,
                'subject' => $template[0]->template_subject,
                'html'    => $template[0]->template  
            );
            # Make the call to the client.
            // $mgClient->messages()->send($domain, $params);
            $step_update['step'] = 0;
            booking::where('booking_id', $booking_id)->update($step_update);
            return redirect()->to('booking/' . $booking_id);
        }
    }
    
    public function dashboard(Request $request,$booking_id=null)
    {
        if (!Auth::User()) 
        {
            return redirect()->to('showLoginForm/');
        }
        
        $page="dashboard";
        
        $user = Auth::User()->find(Auth::User()->id);
        //dd($user->first_name);
        
        if($booking_id == null)
        {
            $user_bookings = booking::where('user_id',Auth::User()->id)->where('step',0)->get();
            
            $booking_ids = '';
            foreach($user_bookings as $booking)
            {
                $booking_ids .= $booking->booking_id .',';    
            }    
            
            $booking_ids = rtrim($booking_ids,',');
            
            $booking_items = booking::get_booking_items_count($booking_ids);
            
            $item_count = array();        
            foreach($booking_items as $k => $v)
            {
                $item_count[$v->booking_id] = $v->count;
            }    
        }
        else
        {
            $booking = booking::where('booking_id',$booking_id)->where('step',0);
            $booking = $booking->first();
            
            $join['booking_form_insurance'] = true;
            $selected_items = booking::get_booking_items($booking_id,$join);
            
        }
        $user_bookings = array();
        $item_count = 0;
        return view('booking.dashboard', compact('page','user','booking_id','user_bookings','booking','item_count'));
    }
    
    public function payment(Request $request,$booking_id = null)
    {
        
        $page = 'dashboard';
        return view('booking.payment',compact('page'));    
        
    }
    
    public function summary(Request $request,$booking_id = null,$step = null)
    {
        if(!empty($booking_id))
        {
            $booking = array();
            $services = Service::all();
            
            $booking = booking::where('booking_id',$booking_id)->first();
            $booking_location = booking::get_booking_location($booking_id);
            
            if ($booking->service_type_id == 6) {
                $calender1 = Helper::GetShuffleCalendar(date("Y"), true, true)[0];
                $calender2 = Helper::GetShuffleCalendar(date("Y"), true, true)[1];
            } else {
                $calender = Helper::GetCelender(date("Y"),true,true);
            }
            $demand = PeakFactor::GetCustomerDemand();
                
            $booking_dates = booking::get_booking_dates($booking_id);
            
            $time_charges = TimeCharges::get();
            
            $items = Inventory::all();

            $selected_items = booking::get_booking_items($booking_id);
                
            $booking_item_answers = booking::get_booking_item_answers($booking_id);

            $selected_item_answers = array();
            foreach($booking_item_answers as $answers)
            {
                $selected_item_answers[$answers->question_id] = $answers;
            }
                

            // Get Ranking
            $ranking = Inventory::GetRanking();

            foreach($items as $itm)
            {
                $item_ids[] = $itm->id;
            }
                
            $item_images = booking::get_item_images(array('booking_id'=>$booking_id))->get();

            $question = Question::whereIn('item_id',$item_ids)->get();
                                    
            foreach($items as $k => $item)
            {
                $items[$k]->question = false;
                foreach($question as $q)
                {
                    if($q->item_id == $item->id)
                    {
                        $items[$k]->question = true;
                        break;
                    }
                }
            }
                
            $presets = Preset::all();
            $equipments = Inventory::GetInventoryEquipment();
            $categories = Category::orderBy('created_at', 'desc')->get();
            $insuranceCategories = InsuranceCategory::all();
            $PropertyInsurance = PropertyInsurance::all();
                
            $booking_form_truck = booking::get_booking_truck(array('booking_id'=>$booking_id))->get();
            
            $join['booking_form_insurance_left'] = true;
            $join['inventories'] = true;
            $selected_items = booking::get_booking_items($booking_id,$join);
            
            $booking = $this->difficulty_level($booking,$selected_items,$booking_location);
            $selected_crew = $this->crew_assignment($booking);

            if ($booking->service_type_id == 6) {
                $demands = DB::table('shuffle_customer_demand')->get();
                $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $booking_id)->get();
                $selected_crew = $this->crew_assignment($booking);
                $charges = $this->calculate_charges_shuffle($booking, $selected_items, $booking_location, $booking_dates,$selected_crew)[0];
                $chargess['difficulty_level'] = $this->calculate_charges_shuffle($booking, $selected_items, $booking_location, $booking_dates,$selected_crew)[1]['difficulty_level'];
                $insurance_data = array();
                $insurance_data_temp = InsuranceCategory::get();
                foreach ($insurance_data_temp as $i_temp) {
                    $insurance_data[$i_temp->name]['ratio'] = (int)explode(':', $i_temp->ratio)[1] / (int)explode(':', $i_temp->ratio)[0];
                    $insurance_data[$i_temp->name]['you_pay'] = $i_temp->you_pay;
                }
            } else {
                $booking = $this->crew_availability($booking,$selected_crew,$calender);
                $mileage_time = $booking_form_truck[0]->mileage;
                $result = $this->calculate_charges($booking,$selected_items,$selected_crew,$mileage_time, $booking_location);
                $booking = $result[0];
                $charges = $result[1];
                
                $working_hours = DB::table('working_hours')->get();
                $demands = DB::table('customer_demand')->get();
                
                $accuracy = Accuracy::get();
                $accuracy_min = 0;
                $accuracy_max = 0;
                foreach($accuracy as $a)
                {
                    if($a->id == $booking->accuracy)
                    {
                        $accuracy_min = $a->min;
                        $accuracy_max = $a->max;
                    }
                }
    
                $total_weight = 0;
                $total_volume = 0;
                $categories_rw = [];
                $items_rw = [];
    
                foreach ($selected_items as $i) {
                    $total_weight += ($i->quantity * $i->weight);
                    $total_volume += ($i->quantity * $i->volume);
                    isset($i->category_id) ? array_push($categories_rw, $i->category_id) : array_push($categories_rw, 0);
                    isset($i->item_name) ? array_push($items_rw, $i->item_name) : array_push($items_rw, '');
                }
    
                $rec_nums = $this->recommended_num($total_weight, $total_volume, $categories_rw, $items_rw);
    
                $slot = false;
                foreach (explode(',',$booking->exist_hours) as $k => $exist_hours) {
                    $seg = explode('-',$exist_hours);
                    $first_seg = current($seg);
                    $end_seg = end($seg);
                    if ($first_seg == $booking->start_time && $end_seg == $booking->end_time) {
                        $slot = true;
                        break;
                    }
                }
                if (!isset($booking->start_time) || !isset($booking->end_time)) {
                    $slot = true;
                }
    
                $date_recommending = false;
    
                // Get the last booking's data
                $latest_booking = booking::latest('booking_id')->where([
                    ['booking_id', '!=', $booking_id],
                    ['step', '=', '0'],
                    ['service_type_id', '!=', 6],
                    ['booking_date', '>=', date('Y-m-d')]
                ])->first();
    
                $recommended_data = array();
                if(isset($latest_booking)) {
                    // Calculate the distance radius
                    $distance_radius = $this->get_directions_info($booking->s_lat, $booking->s_lng, $latest_booking->d_lat, $latest_booking->d_lng, 'distance');
                    $limit_value = Setting::get('distance_radius');
                    echo '<pre>chekcing distance radius<br>';
                    print_r($limit_value);
                    echo '<br>';
                    print_r($distance_radius);
                    echo '<br>latest booking id: ';
                    print_r($latest_booking->booking_id);
                    echo '<br>latest booking end time:  ';
                    print_r($latest_booking->end_time);
                    echo'</pre>';
    
                    if (!isset($booking->booking_date)) {
                        if ($distance_radius <= $limit_value && $latest_booking->end_time != '6:00 PM') {
                            $recommended_data['booking_date'] = $latest_booking->booking_date;
                            if ($latest_booking->end_time == '8:00 AM') {
                                $recommended_data['start_time'] = '8:00 AM';
                                $recommended_data['end_time'] = '10:00 AM';
                            } elseif ($latest_booking->end_time == '10:00 AM') {
                                $recommended_data['start_time'] = '10:00 AM';
                                $recommended_data['end_time'] = '12:00 PM';
                            } elseif ($latest_booking->end_time == '12:00 PM') {
                                $recommended_data['start_time'] = '12:00 PM';
                                $recommended_data['end_time'] = '2:00 PM';
                            } elseif ($latest_booking->end_time == '2:00 PM') {
                                $recommended_data['start_time'] = '2:00 PM';
                                $recommended_data['end_time'] = '4:00 PM';
                            } elseif ($latest_booking->end_time == '4:00 PM') {
                                $recommended_data['start_time'] = '4:00 PM';
                                $recommended_data['end_time'] = '6:00 PM';
                            }
                            $date_recommending = true;
                        }
                    }
                }
            }
            
            $survival_kit = ShuffleFee::first()->survival_kit;
            $supplies_kit = ShuffleFee::first()->supplies_kit;

            if ($booking->service_type_id == 6) {
                $font_info_flexible = DB::table('text_define')->where('id', 2)->first();
                $font_info_unflexible = DB::table('text_define')->where('id', 3)->first();
                return view('booking.summary_shuffle', compact('services','chargess', 'booking', 'booking_location', 'calender1', 'calender2', 'selected_items', 'demands', 'booking_dates', 'charges', 'insurance_data', 'survival_kit', 'supplies_kit', 'font_info_flexible', 'font_info_unflexible'));
            } else {
                if (isset($request->show_alert)) {
                    $show_alert = true;
                    $reason = $request->reason;
                    return view('booking.summary',compact('services','booking','booking_location','booking_dates','booking_form_truck','categories','equipments','presets','question','item_images','ranking','items','selected_items','time_charges','calender','insuranceCategories','PropertyInsurance','charges','working_hours', 'demands', 'accuracy_min', 'accuracy_max', 'rec_nums', 'slot', 'date_recommending', 'recommended_data', 'show_alert', 'reason'));
                } else {
                    return view('booking.summary',compact('services','booking','booking_location','booking_dates','booking_form_truck','categories','equipments','presets','question','item_images','ranking','items','selected_items','time_charges','calender','insuranceCategories','PropertyInsurance','charges','working_hours', 'demands', 'accuracy_min', 'accuracy_max', 'rec_nums', 'slot', 'date_recommending', 'recommended_data'));
                }
            }
        }
    }

    public function summary_shuffle(Request $request, $booking_id = null, $step = null) {
        if (!empty($booking_id)) {
            $services = Service::all();
            $booking = booking::where('booking_id', $booking_id)->first();
            $booking_location = booking::get_booking_location($booking_id);

            $calenders = Helper::GetShuffleCalendar(date("Y"), true, true);
            $calender1 = $calenders[0];
            $calender2 = $calenders[1];

            $join['booking_form_insurance_left'] = true;
            $join['inventories'] = true;
            $selected_items = booking::get_booking_items($booking_id, $join);

            $booking = $this->difficulty_level($booking,$selected_items,$booking_location);
            $selected_crew = $this->crew_assignment($booking);

            $demands = DB::table('shuffle_customer_demand')->get();
            $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $booking_id)->get();
            $selected_crew = $this->crew_assignment($booking);
            $temp = $this->calculate_charges_shuffle($booking, $selected_items, $booking_location, $booking_dates, $selected_crew);
            $charges = $temp[0];
            $chargess['difficulty_level'] = $temp[1]['difficulty_level'];
            $storages = $temp[2];
            $pickup_prices = $temp[3];
            $dropoff_prices = $temp[4];
            $item_names = $temp[5];
            $insurance_data = array();
            $insurance_data_temp = InsuranceCategory::get();
            foreach ($insurance_data_temp as $i_temp) {
                $insurance_data[$i_temp->name]['ratio'] = (int)explode(':', $i_temp->ratio)[1] / (int)explode(':', $i_temp->ratio)[0];
                $insurance_data[$i_temp->name]['you_pay'] = $i_temp->you_pay;
            }

            $survival_kit = ShuffleFee::first()->survival_kit;
            $supplies_kit = ShuffleFee::first()->supplies_kit;

            $font_info_flexible = DB::table('text_define')->where('id', 2)->first();
            $font_info_unflexible = DB::table('text_define')->where('id', 3)->first();

            return view('booking.summary_shuffle', compact('services', 'chargess', 'booking', 'booking_location', 'calender1', 'calender2', 'selected_items', 'demands', 'booking_dates', 'charges', 'insurance_data', 'survival_kit', 'supplies_kit', 'font_info_flexible', 'font_info_unflexible', 'storages', 'pickup_prices', 'dropoff_prices', 'item_names'));
        }
    }

    public function calculate_charges_shuffle($booking, $selected_items, $booking_location, $booking_dates,$selected_crew) {
        $base_rate = ShuffleFee::first()->base_rate;
        // calculation of zone charges
        $shuffle_price = array();
        $peak_factor = [0, 0];
        $zones = ZoneType::get();

        if (isset($booking->kit)) {
            $kits = explode(',', $booking->kit);
            $fees = ShuffleFee::first()->toArray();
            foreach($kits as $kit)
                if(isset($fees[$kit . '_kit'])) {
                    $charge[$kit . '_kit'] = $fees[$kit . '_kit'];
                    echo '<pre class="ml-3 text-danger">' . $kit . '_kit: <br>';
                    print_r($charge[$kit . '_kit']);
                    echo '</pre>';
                }
        }
        
        foreach ($booking_location as $k => $location) {
            // getting shuffle price
            foreach ($zones as $zone) {
                
                if (in_array($location->zip_code, explode(',', $zone->zip_code))) {
                    if (isset($zone->sh_price)) {
                        $shuffle_price[$k] = $zone->sh_price;
                    } else {
                        $shuffle_price[$k] = 0;
                    }
                }
            }
            // getting peak factor
            foreach ($booking_dates as $b_data) {
                if (isset($b_data)) {
                    list($year, $month, $date) = explode('-', $b_data->date);
                    if ($b_data->type == 0) {
                        $temp = ShufflePeakFactor::where([
                            'year' => $year,
                            'month' => $month,
                            'day' => $date
                        ])->select('pickup_value')->first();
                        if (isset($temp)) {
                            $peak_factor[0] = $temp->pickup_value;
                        } else {
                            $peak_factor[0] = 0;
                        }
                    } elseif ($b_data->type == 1) {
                        $temp = ShufflePeakFactor::where([
                            'year' => $year,
                            'month' => $month,
                            'day' => $date
                        ])->select('dropoff_value')->first();
                        if (isset($temp)) {
                            $peak_factor[1] = $temp->dropoff_value;
                        } else {
                            $peak_factor[1] = 0;
                        }
                    }
                }
            }
        }
        $charge['zones'] = $shuffle_price[0] * $peak_factor[0] + $shuffle_price[1] * $peak_factor[1];

        $booking_id = $booking->booking_id;

        // getting loading/unloading time
        $drop_off_location_info = DB::table('booking_form_items as i')->select('*')->join('inventories as ivn', 'ivn.id', '=', 'i.item_id')->join('booking_form_location as d_loc', 'i.drop_off_loc_id', '=', 'd_loc.booking_loc_id')->addSelect('ivn.ranking_id as inventory_ranking')->where('i.booking_id', $booking_id)->get();
        foreach ($drop_off_location_info as $item) {
            $inventory = json_decode(json_encode($item), true);

            // Formula is (min_time + med_time + max_time) / 3 * quantity
            if ($inventory["stair_kind"] == "stairs") {
                $times = $this->get_flight_times($item->item_id, 2, $item->flights, 1);
                $stair_factor = $this->get_stair_time_factor($item->item_id, 2, $item->stair_type);
                if (!isset($times)) {
                    $drop_off_times[$item->item_id] = 0;
                } else {
                    $drop_off_times[$item->item_id] = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $item->quantity / 3;
                }
            } else if ($inventory["stair_kind"] == "elevator" || $inventory["stair_kind"] == "both") {
                $times = $this->get_elevator_times($item->item_id, 2, $item->floor_num, 1);
                if (count($times) == 0) {
                    $drop_off_times[$item->item_id] = 0;
                } else {
                    if ($item->evelator_type == 'reserved_freight') {
                        $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                        $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                    } else {
                        $time = json_decode(json_encode($times), true)[0][$item->evelator_type . '_time'];
                        $delay = json_decode(json_encode($times), true)[0][$item->evelator_type . '_delay'];
                    }
                    $drop_off_times[$item->item_id] = ($time + $delay) * $inventory["quantity"];
                }
            } else if ($inventory["stair_kind"] == 'groundfloor') {
                $times = $this->get_bulkhead_times($item->item_id, 2, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$item->item_id] = 0;
                } else {
                    $drop_off_times[$item->item_id] = ($times->groundfloor_min + $times->groundfloor_med + $times->groundfloor_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'bulkhead') {
                $times = $this->get_bulkhead_times($item->item_id, 2, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$item->item_id] = 0;
                } else {
                    $drop_off_times[$item->item_id] = ($times->bulkhead_min + $times->bulkhead_med + $times->bulkhead_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'entrance') {
                $times = $this->get_bulkhead_times($item->item_id, 2, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$item->item_id] = 0;
                } else {
                    $drop_off_times[$item->item_id] = ($times->en_steps_min + $times->en_steps_med + $times->en_steps_max) * $item->quantity;
                }
            }
        }

        $pick_up_location_info = DB::table('booking_form_items as i')->select('*')->join('inventories as ivn', 'ivn.id', '=', 'i.item_id')->join('booking_form_location as p_loc', 'i.pick_up_loc_id', '=', 'p_loc.booking_loc_id')->addSelect('ivn.ranking_id as inventory_ranking')->where('i.booking_id', $booking_id)->get();
        foreach ($pick_up_location_info as $item) {
            $inventory = json_decode(json_encode($item), true);

            if ($inventory["stair_kind"] == "stairs") {
                $times = $this->get_flight_times($item->item_id, 2, $item->flights, 0);
                $stair_factor = $this->get_stair_time_factor($item->item_id, 2, $item->stair_type);
                if (!isset($times)) {
                    $pick_up_times[$item->item_id] = 0;
                } else {
                    $pick_up_times[$item->item_id] = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $item->quantity / 3;
                }
            } else if ($inventory["stair_kind"] == "elevator" || $inventory["stair_kind"] == "both") {
                $times = $this->get_elevator_times($item->item_id, 2, $item->floor_num, 0);
                if (count($times) == 0) {
                    $pick_up_times[$item->item_id] = 0;
                } else {
                    if ($item->evelator_type == 'reserved_freight') {
                        $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                        $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                    } else {
                        $time = json_decode(json_encode($times), true)[0][$item->evelator_type . '_time'];
                        $delay = json_decode(json_encode($times), true)[0][$item->evelator_type . '_delay'];
                    }
                    $pick_up_times[$item->item_id] = ($time + $delay) * $inventory["quantity"];
                }
            } else if ($inventory["stair_kind"] == 'groundfloor') {
                $times = $this->get_bulkhead_times($item->item_id, 2, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$item->item_id] = 0;
                } else {
                    $pick_up_times[$item->item_id] = ($times->groundfloor_min + $times->groundfloor_med + $times->groundfloor_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'bulkhead') {
                $times = $this->get_bulkhead_times($item->item_id, 2, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$item->item_id] = 0;
                } else {
                    $pick_up_times[$item->item_id] = ($times->bulkhead_min + $times->bulkhead_med + $times->bulkhead_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'entrance') {
                $times = $this->get_bulkhead_times($item->item_id, 2, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$item->item_id] = 0;
                } else {
                    $pick_up_times[$item->item_id] = ($times->en_steps_min + $times->en_steps_med + $times->en_steps_max) * $item->quantity;
                }
            }
        }

        // calculate item charges & storage charges
        $storages = array();
        $pickup_prices = array();
        $dropoff_prices = array();
        $item_names = array();
        $charge['storage'] = 0;
        $charge['items'] = 0;
        $charge['pickup_items'] = 0;
        $charge['dropoff_items'] = 0;
        $charge['items_price'] = array();
        foreach ($selected_items as $s_i => $item) {
            $charge['storage'] += $item->storage_price * $item->quantity;
            // $storages[$item->pk_booking_item_id] = $item->storage_price * $item->quantity;
            $storages[$s_i] = $item->storage_price * $item->quantity;
            // $item_names[$item->pk_booking_item_id] = $item->item_name;
            $item_names[$s_i] = $item->item_name;
            $charge['items_price'][$item->item_name] = 0;
            foreach ($booking_location as $k => $loc) {
                if ($loc->stair_kind == 'stairs' || $loc->stair_kind == 'elevator') {
                    if ($loc->stair_kind == 'stairs') {
                        $temp = DB::table('inventory_shuffle_values')->where([
                            'item_id' => $item->item_id,
                            'moving_type' => 'flight',
                            'num_flights' => $loc->flights,
                            'location_type' => $k
                        ])->first();
                        if (isset($temp)) {
                            $mul_value[$k] = $temp->mul_value;
                        } else {
                            $mul_value[$k] = 1;
                        }

                    } else {
                        switch ($loc->evelator_type) {
                            case 'passenger':
                                $temp = DB::table('inventory_shuffle_values')->where([
                                    'item_id' => $item->item_id,
                                    'moving_type' => 'passenger',
                                    'num_flights' => $loc->floor_num,
                                    'location_type' => $k
                                ])->first();
                                if (isset($temp)) {
                                    $mul_value[$k] = $temp->mul_value;
                                } else {
                                    $mul_value[$k] = 1;
                                }
                                break;
                            case 'reserved_freight':
                                $temp = DB::table('inventory_shuffle_values')->where([
                                    'item_id' => $item->item_id,
                                    'moving_type' => 'rs_freight',
                                    'num_flights' => $loc->floor_num,
                                    'location_type' => $k
                                ])->first();
                                if (isset($temp)) {
                                    $mul_value[$k] = $temp->mul_value;
                                } else {
                                    $mul_value[$k] = 1;
                                }
                                break;
                            case 'freight':
                                $temp = DB::table('inventory_shuffle_values')->where([
                                    'item_id' => $item->item_id,
                                    'moving_type' => 'freight',
                                    'num_flights' => $loc->floor_num,
                                    'location_type' => $k
                                ])->first();
                                if (isset($temp)) {
                                    $mul_value[$k] = $temp->mul_value;
                                } else {
                                    $mul_value[$k] = 1;
                                }
                                break;
                        }
                    }
                    // $charge['items'] += $shuffle_price[$k] * $mul_value[$k];
                    if ($k == 0) {
                        // $charge['pickup_items'] += $item->pickup_price * $mul_value[$k] * $peak_factor[$k];
                        // $charge['items'] += $item->pickup_price * $mul_value[$k] * $peak_factor[$k];
                        $temp = Inventory::where('id', $item->item_id)->first()->pickup_price;
                        if ($temp == 0) {
                            $charge['pickup_items'] += $pick_up_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            $charge['items'] += $pick_up_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            $charge['items_price'][$item->item_name] += $pick_up_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            // $pickup_prices[$item->pk_booking_item_id] = $pick_up_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            $pickup_prices[$s_i] = $pick_up_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                        } else {
                            $charge['pickup_items'] += $temp;
                            $charge['items'] += $temp;
                            $charge['items_price'][$item->item_name] += $temp;
                            // $pickup_prices[$item->pk_booking_item_id] = $temp;
                            $pickup_prices[$s_i] = $temp;
                        }
                    } elseif ($k == 1) {
                        // $charge['dropoff_items'] += $item->dropoff_price * $mul_value[$k] * $peak_factor[$k];
                        // $charge['items'] += $item->dropoff_price * $mul_value[$k] * $peak_factor[$k];
                        $temp = Inventory::where('id', $item->item_id)->first()->dropoff_price;
                        if ($temp == 0) {
                            $charge['dropoff_items'] += $drop_off_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            $charge['items'] += $drop_off_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            $charge['items_price'][$item->item_name] += $drop_off_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            // $dropoff_prices[$item->pk_booking_item_id] = $drop_off_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                            $dropoff_prices[$s_i] = $drop_off_times[$item->item_id] / 3600 * $base_rate * $mul_value[$k];
                        } else {
                            $charge['dropoff_items'] += $temp;
                            $charge['items'] += $temp;
                            $charge['items_price'][$item->item_name] += $temp;
                            // $dropoff_prices[$item->pk_booking_item_id] = $temp;
                            $dropoff_prices[$s_i] = $temp;
                        }
                    }
                } else {
                    $charge['items'] += 0;
                }
            }
        }

        // calculate flat fees
        $shuffle_fees = ShuffleFee::first();

        $charge['parking_fees'] = 0;
        foreach ($booking_location as $k => $loc) {
            $parking_fees = json_decode($shuffle_fees->parking_fees, true);
            if (!empty($parking_fees[$loc->parking])) {
                $charge['parking_fees'] += $parking_fees[$loc->parking];
                if ($k == 0)
                    $charge['pickup_items'] += $parking_fees[$loc->parking];
                elseif ($k == 1)
                    $charge['dropoff_items'] += $parking_fees[$loc->parking];
            }
        }

        $charge['dis_assem_fees'] = 0;
        foreach ($selected_items as $item) {
            $temp = DB::table('inventory_dis_assembly')->where('item_id', $item->item_id)->get()->toArray();
            if (!empty($temp)) {
                $dis_assem_fees = json_decode($shuffle_fees->dis_assem_fee, true);
                foreach ($dis_assem_fees as $fee) {
                    $charge['dis_assem_fees'] += $fee * 2;
                    $charge['pickup_items'] += $fee;
                    $charge['dropoff_items'] += $fee;
                }
            }
        }

        $charge['long_walk_fees'] = 0;
        $charge['curbside_fees'] = 0;
        foreach ($booking_location as $i => $loc) {
            if ($loc->walk == 1) {
                $vol_mins = json_decode($shuffle_fees->vol_min, true);
                $vol_maxs = json_decode($shuffle_fees->vol_max, true);
                $long_walk_fees = json_decode($shuffle_fees->long_walk_fee, true);
                $total_volume = 0;
                foreach ($selected_items as $item) {
                    $total_volume += $item->volume * $item->quantity;
                }
                foreach ($long_walk_fees as $k => $fee) {
                    if ($total_volume >= $vol_mins[$k] && $total_volume <= $vol_maxs[$k]) {
                        $charge['long_walk_fees'] += $fee;
                        if ($i == 0)
                            $charge['pickup_items'] += $fee;
                        elseif ($i == 1)
                            $charge['dropoff_items'] += $fee;
                    }
                }
            }
            if ($loc->curbside == 1) {
                $charge['curbside_fees'] += $shuffle_fees->curbside_fee;
                if ($i == 0)
                    $charge['pickup_items'] -= $shuffle_fees->curbside_fee;
                elseif ($i == 1)
                    $charge['dropoff_items'] -= $shuffle_fees->curbside_fee;
            }
        }

        $charge['shuffle_price'] = $shuffle_price;
        $peak_factor_data = ShufflePeakFactor::orderBy('id', 'DESC')->get();

        $peak_factor = array();
        foreach ($peak_factor_data as $data) {
            $date = strtotime($data->year . '-' . $data->month . '-' . $data->day);
            $peak_factor[$date]['pickup'] = $data->pickup_value;
            $peak_factor[$date]['dropoff'] = $data->dropoff_value;
        }
        $charge['peak_factor'] = $peak_factor;

        $charges['difficulty_level'] = Dlevel::select('dlevel')->where(['id' => $selected_crew->dlevel_id])->get()->toArray()[0]['dlevel'];

        return array($charge,$charges, $storages, $pickup_prices, $dropoff_prices, $item_names);
    }
    
    public function crew_availability($booking,$selected_crew,$calender)
    {
        $booking_date = $booking->booking_date;
        
        $weeks = array(0=>'Sun',1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat');
        
        $day = $weeks[date('w', strtotime($booking_date))];
        
        $assigned_crew = DB::table('booking_form')
        ->where('booking_date',$booking_date)
        ->where('booking_id','<>',$booking->booking_id)
        ->where('crew','<>','')
        ->where('start_time','<>','')
        ->where('end_time','<>','')
        ->select('booking_id','booking_date','start_time','end_time','crew')
        ->orderBy('start_time','ASC')
        ->get();

        if(isset($assigned_crew[0]))
        {
            $inc_crew = '';
            foreach($assigned_crew as $user)
            {
                if($inc_crew == '')
                {
                    if(!empty($user->crew))
                    {
                        $inc_crew = $user->crew;    
                    }
                }
                else
                {
                    if(!empty($user->crew))
                    {
                        $inc_crew = $inc_crew.','.$user->crew;
                    }
                }
            }
            
            if(!empty($inc_crew))
            {
                $inc_crew = explode(',',$inc_crew);    
            }
            else
            {
                $inc_crew = '';
            }
            
        }
        
        $crews = DB::table('users as u')
        ->selectRaw('u.id,first_name,last_name,ur.role_id as role,ul.level')
        ->join('role_user as ur', 'ur.user_id', '=', 'u.id')
        ->join('roles as r', 'r.id', '=', 'ur.role_id')
        ->join('user_level as ul', 'ul.user_id', '=', 'u.id')->get();
        // ->join('user_schedules as us', 'us.user_id', '=', 'u.id')

        // if(!empty($inc_crew))
        // {
        //     $crews = $crews->whereIn('u.id',$inc_crew); // In Bookings this selected date  
        // }
        
        // $crews = $crews->where("us.$day",1) // Schedule Available
        // ->get();
        
        $hours = array('6'=>1,'7'=>2,'8'=>3,'9'=>4,'10'=>5,'11'=>6,'12'=>7,'1'=>8,'2'=>9,'3'=>10,'4'=>11,'5'=>12);
        $mode = array('6'=>'AM','7'=>'AM','8'=>'AM','9'=>'AM','10'=>'AM','11'=>'AM','12'=>'AM','1'=>'AM','2'=>'AM','3'=>'AM','4'=>'AM','5'=>'AM');
        
        $booking->dhours = $dhours  = array_flip($hours);
        
        $crew_roles = explode(',',$selected_crew->roles);        
        $crew_levels = explode(',', $selected_crew->levels);
        $selected_crews_data = array();
        foreach ($crew_roles as $i => $item) {
            $selected_crews_data[$i]['role'] = $crew_roles[$i];
            $selected_crews_data[$i]['level'] = $crew_levels[$i];
        }

        $role_name = DB::table('roles')->pluck('name','id');
        $worker = array();
        $booking_crew_data = '';
        $index = 1;
        if(isset($assigned_crew[0]) && isset($crews[0]))
        {
            foreach($selected_crews_data as $k => $data)
            {
                $worker[$data['role']] = [];
                foreach($crews as $crew)
                {
                    if($data['role'] == $crew->role && $data['level'] == $crew->level)
                    {
                        // $worker[$k]['role'] = $crew->role;
                        // $worker[$k]['id'] = $crew->id;
                        array_push($worker[$data['role']], array(
                            'role' => $crew->role,
                            'id' => $crew->id
                        ));
                        // foreach($assigned_crew as $b => $val)
                        // {
                            
                        //     $booking_crew = explode(',',$val->crew);
                        //     if(in_array($crew->id, $booking_crew))
                        //     {
                                
                        //         $worker[$k]['id'] = $crew->id;
                        //         // $worker[$k]['name'] = $crew->first_name.' '.$crew->last_name;
                                
                        //         // if(!isset($worker[$k]['minute']))
                        //         // {
                        //             // $tot_time = $worker[$k]['minute'] = 780;    
                        //         // }
                                
                        //         $time = explode(" ", $val->start_time);
                        //         $h = explode(":", $time[0])[0];
                        //         $m = explode(":", $time[0])[1];
                        //         $start_mm = ($hours[$h] * 60) + $m;
                                
                        //         $time = explode(" ", $val->end_time);
                        //         $h = explode(":", $time[0])[0];
                        //         $m = explode(":", $time[0])[1];
                        //         $end_mm = ($hours[$h] * 60) + $m; 
                                
                        //         $s_min[$index]  = $start_mm .','. $end_mm;
                        //         $index = $index + 1;
                                
                        //     }
                        // }
                    }    
                }
            }


            foreach ($worker as $k => $w) {
                $new_worker[$k] = [];
                foreach ($w as $i_e) {
                    foreach ($assigned_crew as $a_c) {
                        if (!in_array($i_e['id'], explode(',', $a_c->crew))) {
                            array_push($new_worker[$k], $i_e);
                        }
                    }
                }
            }

            // foreach ()

            // $chk = array(); // Remove Duplicate segments 
            // for($i=1;$i<=count($s_min);$i++)
            // {
            //     for($j=$i+1;$j<=count($s_min);$j++)
            //     {
            //         if($s_min[$i] == $s_min[$j])
            //         {
            //             $chk[] = $j;
            //         }
            //     }
            // }
            // // echo '<pre>';
            // // print_r($chk);
            // // echo '</pre>';
            
            // foreach($chk as $c){unset($s_min[$c]);}
            
            // $s_min = array_values($s_min);
            
            // // echo '<pre>';
            // // print_r($s_min);
            // // echo '</pre>';exit;
            
            
            // for($i=0;$i<count($s_min);$i++)
            // {
            //     for($j=0;$j<count($s_min);$j++)
            //     {
            //         $left  = explode(',',$s_min[$i]);
            //         $right = explode(',',$s_min[$j]);
                    
            //         $left_min = $left[0];
            //         $left_max = $left[1];
                    
            //         $right_min = $right[0];
            //         $right_max = $right[1];
                    
            //         // echo $i.'-'.$j.'  ';
                
                    
            //         if(($left_min <= $right_min) && ($right_min <= $left_max))
            //         {
            //             //echo '('.$left_min .'<'. $right_min .') - ('. $right_min .'<'. $left_max .')';
            //             //echo ' <font color="green">true</font>';
                        
            //             if($left_max < $right_max)
            //             {
            //                 $s_min[$i] = $s_min[$j] = $left_min.','.$right_max;
            //                 $j = 0;
            //             }
                        
            //             if($left_max > $right_max)
            //             {
            //                 $s_min[$i] = $s_min[$j] = $left_min.','.$left_max;
            //                 $j = 0;
            //             }
                        
            //         }
            //         else
            //         {
            //             // echo ' <font color="red">false</font>';
            //         }
                    
            //             // echo '('.$right_min .'<'. $left_min .') - ('. $left_min .'<'. $right_max .')';
            //         if(($right_min <= $left_min) && ($left_min <= $right_max))
            //         {
            //             // echo '('.$right_min .'<'. $left_min .') - ('. $left_min .'<'. $right_max .')';
            //             // echo ' <font color="green">true</font>';
                        
            //             if($right_max < $left_max)
            //             {
            //                 $s_min[$i] = $s_min[$j] = $right_min.','.$left_max;    
            //                 $j = 0;
            //             }
                        
            //             if($right_max > $left_max)
            //             {
            //                 $s_min[$i] = $s_min[$j] = $right_min.','.$right_max;    
            //                 $j = 0;
            //             }
            //         }
            //         else
            //         {
            //             // echo ' <font color="red">false</font>';
            //         }
                    
            //         // echo $left_min.','.$right_max.' <br>';
            //     }
            // }
            
            // // ======= Remove Duplication ============//
            //     $chk = array();
            //     for($i=0;$i<count($s_min);$i++){for($j=$i+1;$j<count($s_min);$j++){if($s_min[$i] == $s_min[$j]){$chk[] = $j;}}}
            //     foreach($chk as $c){unset($s_min[$c]);}
            // // ======= Remove Duplication ============//
            
            // // echo '<pre>';
            // // print_r($s_min);
            // // echo '</pre>';
            
            // // ======= Order minutes ============//
            //     foreach($s_min as $v){$v = explode(',',$v);$j_min[$v[0]] = $v[1];}
            //     ksort($j_min);unset($s_min);
            //     foreach($j_min as $k => $v){$s_min[] = $k.','.$v;}
            // // ======= Order minutes ============//
            
            // // echo '<pre>';
            // // print_r($s_min);
            // // echo '</pre>';
            
            // $slote =  implode("-", $s_min);
            
            // // echo $slote . '<br>';
            
            // $inventory_time = 0;
            // $selected_items = booking::get_booking_items($booking->booking_id);
            // foreach($selected_items as $item)
            // {
            //     $inventory_time = $inventory_time + $item->pick_up_time + $item->drop_off_time;
            // }
            
            // $booking_time = $inventory_time + $booking->minutes + $booking->time_from_hub + $booking->time_to_hub;
            
            // // echo $booking_time.'<br><br>';exit;
            
            // $segments = explode(',',$slote);
            
            // $new_slote = '';
            // foreach($segments as $k => $val)
            // {
            //     if($k == 0 && $val > 60)
            //     {
            //         $val = '60-'.$val;
            //     }
                
            //     if($k == count($segments)-1 && $val > 60)
            //     {
            //         $val = $val.'-60';
            //     }
            //     //echo $val.'<br>';
            //     $s = explode('-',$val);
                
            //     // if(!empty($s[0]) && !empty($s[1]))
            //     // {
            //         // $mins = Intval($s[1]) - Intval($s[0]);
            //         // if($mins > $booking_time)
            //         // {
            //             // $new_slote = $new_slote.''.$val.',';
            //         // }
            //     // }
                
            //     if(!empty($s[0]) && !empty($s[1]))
            //     {
            //         $mins = Intval($s[1]) - Intval($s[0]);
            //         if($mins > $booking_time)
            //         {
            //             $division = intdiv($mins, $booking_time);
            //             $min_seg = Intval($s[0]);
                        
            //             for($i=1;$i<=$division;$i++)
            //             {
            //                 $max_seg = $min_seg + $booking_time ;
            //                 $new_slote = $new_slote.''.$min_seg.'-'.$max_seg.',';
            //                 //$new_slote = $new_slote.''.$val.',';
            //                 $min_seg = $max_seg;
                            
            //             }
            //         }
            //     }
            // }
            
            // $new_slote = rtrim($new_slote,',');
            // // echo $new_slote.'<br>';
            
            // $slote = explode(',',$new_slote);
            
            // // echo '<pre>';
            // // print_r($slote);
            // // echo '</pre>';
            
            // $time_slote = '';
            // if(isset($slote[0]) && $slote[0] != '')
            // {
            // foreach($slote as $k => $v)
            // {
            //     $g = explode('-',$v);
                
            //     $first_seg = $dhours[floor($g[0] / 60)].':'.$g[0] % 60;
                
            //     $first_seg = explode(':',$first_seg);
                
            //     if($first_seg[1] == 0)
            //     {
            //         $first_seg[1] = '00';
            //     }
                
            //     $min_time = $first_seg[0].':'.$first_seg[1].' '.$mode[$first_seg[0]];
                
            //     $second_seg = $dhours[floor($g[1] / 60)].':'.$g[1] % 60;
                
            //     $second_seg = explode(':',$second_seg);
                
            //     if($second_seg[1] == 0)
            //     {
            //         $second_seg[1] = '00';
            //     }
                
            //     $max_time = $second_seg[0].':'.$second_seg[1].' '.$mode[$second_seg[0]];
                
            //     $time_slote = $time_slote.''.$min_time. '-' .$max_time.',';
            // }
            
            // $time_slote = rtrim($time_slote,' , ');
            // }
            // //echo $time_slote.'<br>';
            
            // if($time_slote == '')
            // {
            //     $booking->exist_hours = 'hours_not_available';
            // }
            // else
            // {
            //     $booking->exist_hours = $time_slote;
            // }
            
        }
        elseif(isset($crews[0]))
        {
            foreach($selected_crews_data as $k => $data)
            {
                foreach($crews as $crew)
                {
                    if($data['role'] == $crew->role && $data['level'] == $crew->level)
                    {
                        // $worker[$k]['role'] = $role;
                        $worker[$k]['id'] = $crew->id;
                        $booking_crew_data .= $crew->id . ',';
                        // $worker[$k]['name'] = $crew->first_name.' '.$crew->last_name;
                    }
                }
            }
        }

        if(count($crew_roles) <= count($worker))
        {
            $available_crew = implode(',',$crew_roles);
            //Booking::where('booking_id',$booking->booking_id)->update(array('crew'=>$available_crew));
            $booking->crew = $available_crew;
            
        }
        else
        {
            $booking->crew = null;
        }

        $booking->exist_hours = '6:00 AM-8:00 AM,8:00 AM-10:00 AM,10:00 AM-12:00 PM,12:00 PM-2:00 PM,2:00 PM-4:00 PM,4:00 PM-6:00 PM';

        // DB::table('booking_form')->where([
        //     'booking_id' => $booking->booking_id,
        // ])->update([
        //     'crew' => $booking->crew
        // ]);
        
        return $booking;
    }
    
    public function booking(Request $request,$booking_id = null,$step = null)
    {
        $agent = new Agent();
        
        if (!Auth::User()) 
        {
            return redirect()->to('showLoginForm/');
        }
        $booking = array();
        $services = Service::all();
        
        $this->btn_save_step($booking_id,$step);
        
        if(isset($request->btn_new_truck))
        {
            $this->create_booking_truck($request,$booking_id);
            return redirect()->to('booking/'.$booking_id);
        }

        if ($request->create_item) {
                
            $item = new Inventory();
            $item->name = $request->get('name');
            $item->category_id = 13;

            $item->weight_min = 0;
            $item->itemdimensiontype = $request->get('itemdimensiontype');
            $item->itemWighttype = $request->get('itemWighttype');
            if($request->get('itemWighttype')==''){
                $item->weight_max = $request->get('dimensionname'); 
            }else{
                $itemWeightss =  DB::table('item_weights')
                    ->selectRaw('max,min')
                    ->where('id',$item->itemdimensiontype)
                    ->get();

                $item->weight_max = $itemWeightss[0]->max; 
                $item->weight_min = $itemWeightss[0]->min; 
            }
            if($request->get('itemdimensiontype')==''){
   
            $item->height = $request->get('itemheight');
            $item->breadth = $request->get('itemwidth');

            }else{
                $item_dimensionss =   DB::table('item_dimensions')

            ->selectRaw('*')

            ->where('id',$request->get('itemdimensiontype'))
            
            ->get();
            $item->height = $item_dimensionss[0]->height;
            $item->breadth = $item_dimensionss[0]->length;
            $item->category_id = json_decode($item_dimensionss[0]->category_json)[0];

            }

          
            $item->volume =  ($item->height * $item->breadth)/2;
           

            $item->R_A = 0;
            $item->R_B = 0;
            $item->R_C = 0;
            $item->R_D = 0;
            $item->R_E = 0;

            $category_data = Category::where(['id' => $item->category_id])->select('*')->get()->first();

            $item->hoisting = $category_data->hoisting;
            $item->equipments = $category_data->equipments;
            $item->ranking_id = $category_data->ranking_id;
            $item->ranking_time = $category_data->ranking_time;

            $item->stair_windy = $category_data->stair_windy;
            $item->stair_narrow = $category_data->stair_narrow;
            $item->stair_wide = $category_data->stair_wide;
            $item->stair_spiral = $category_data->stair_spiral;
            $item->elevator_passenger = $category_data->elevator_passenger;
            $item->elevator_freight = $category_data->elevator_freight;
            $item->elevator_reserved_freight = $category_data->elevator_reserved_freight;

            $item->time_0_min = $category_data->time_0_min;
            $item->time_0_med = $category_data->time_0_med;
            $item->time_0_max = $category_data->time_0_max;
            $item->time_1_min = $category_data->time_1_min;
            $item->time_1_med = $category_data->time_1_med;
            $item->time_1_max = $category_data->time_1_max;
            $item->time_2_min = $category_data->time_2_min;
            $item->time_2_med = $category_data->time_2_med;
            $item->time_2_max = $category_data->time_2_max;
            $item->time_3_min = $category_data->time_3_min;
            $item->time_3_med = $category_data->time_3_med;
            $item->time_3_max = $category_data->time_3_max;
            $item->time_4_min = $category_data->time_4_min;
            $item->time_4_med = $category_data->time_4_med;
            $item->time_4_max = $category_data->time_4_max;
            $item->time_5_min = $category_data->time_5_min;
            $item->time_5_med = $category_data->time_5_med;
            $item->time_5_max = $category_data->time_5_max;
            $item->time_6_min = $category_data->time_6_min;
            $item->time_6_med = $category_data->time_6_med;
            $item->time_6_max = $category_data->time_6_max;
            $item->customer_created = true;

            $item->save();




            DB::table('inventory_questions')->insert(
                [
                'item_id'=>$item->id,
                'title'=>'how much heavy ?',
                'allow'=>1]
            );

            $item_id = $item->id;
            if ($request->hasFile('file') && !empty($item_id)) 
            {
                $ext = ltrim(strstr($_FILES['file']['name'], '.'), '.');
                $path = public_path() . "/uploads/inventory";
                
                $file_name = $item_id.'_'.$_FILES['file']['name'];
                $target_file = $path.'/'. $file_name;
                
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
                {
                    $update['file_path']     = "/uploads/inventory/".$file_name;
                    $update['file_name']     = $_FILES['file']['name'];
                    $update['file_size']     = $_FILES['file']['size'];
                    $update['file_type']     = $_FILES['file']['type'];
                    $update['extension']     = $ext;
                    $where2['id'] = $item_id;
                    Inventory::update_item_image($update,$where2);
                }
            }

            $category_id = $item->category_id;
            // get dis-assembly data from category
            $dis_assem_temp = DB::table('category_dis_assembly')->where(['category_id' => $category_id])->get();
            if(!empty($dis_assem_temp->toArray())) {
                foreach($dis_assem_temp as $d_a_item) {
                    DB::table('inventory_dis_assembly')->insert([
                        'item_id' => $item_id,
                        'num_worker' => $d_a_item->num_worker,
                        'R_A' => $d_a_item->R_A,
                        'R_B' => $d_a_item->R_B,
                        'R_C' => $d_a_item->R_C,
                        'R_D' => $d_a_item->R_D,
                        'R_E' => $d_a_item->R_E,
                    ]);
                }
            }

            // TODO::get questions from category

            // get shuffle values from category
            $shuffle_values_temp = DB::table('category_shuffle_values')->where(['category_id' => $category_id])->get();
            if(!empty($shuffle_values_temp->toArray())) {
                foreach($shuffle_values_temp as $s_v_item) {
                    DB::table('inventory_shuffle_values')->insert([
                        'item_id' => $item_id,
                        'moving_type' => $s_v_item->moving_type,
                        'num_flights' => $s_v_item->num_flights,
                        'num_floor' => $s_v_item->num_floor,
                        'location_type' => $s_v_item->location_type,
                        'mul_value' => $s_v_item->mul_value,
                    ]);
                }
            }

            // get time factors for stair type from category
            $stair_time_factors_temp = DB::table('category_stair_time_factor')->where(['category_id' => $category_id])->get();
            if(!empty($stair_time_factors_temp->toArray())) {
                foreach($stair_time_factors_temp as $s_t_f_item) {
                    DB::table('inventory_stair_time_factor')->insert([
                        'item_id' => $item_id,
                        'num_worker' => $s_t_f_item->num_worker,
                        'windy' => $s_t_f_item->windy,
                        'narrow' => $s_t_f_item->narrow,
                        'wide' => $s_t_f_item->wide,
                        'spiral' => $s_t_f_item->spiral,
                    ]);
                }
            }

            // get time for elevators from category
            $time_elevator_temp = DB::table('category_time_elevator')->where(['category_id' => $category_id])->get();
            if(!empty($time_elevator_temp->toArray())) {
                foreach($time_elevator_temp as $t_e_item) {
                    DB::table('inventory_time_elevator')->insert([
                        'item_id' => $item_id,
                        'num_worker' => $t_e_item->num_worker,
                        'num_floor' => $t_e_item->num_floor,
                        'location_type' => $t_e_item->location_type,
                        'passenger_time' => $t_e_item->passenger_time,
                        'passenger_delay' => $t_e_item->passenger_delay,
                        'freight_time' => $t_e_item->freight_time,
                        'freight_delay' => $t_e_item->freight_delay,
                        'rs_freight_time' => $t_e_item->rs_freight_time,
                        'rs_freight_delay' => $t_e_item->rs_freight_delay,
                    ]);
                }
            }

            // get time for flights from cateogry
            $time_flight_temp = DB::table('category_time_flights')->where(['category_id' => $category_id])->get();
            if(!empty($time_flight_temp->toArray())) {
                foreach($time_flight_temp as $t_f_item) {
                    DB::table('inventory_time_flights')->insert([
                        'item_id' => $item_id,
                        'num_worker' => $t_f_item->num_worker,
                        'num_flights' => $t_f_item->num_flights,
                        'location_type' => $t_f_item->location_type,
                        'time_min' => $t_f_item->time_min,
                        'time_med' => $t_f_item->time_med,
                        'time_max' => $t_f_item->time_max,
                    ]);
                }
            }

            // get time for extra from cateogry
            $time_extra_temp = DB::table('category_time_extra')->where(['category_id' => $category_id])->get();
            if(!empty($time_extra_temp->toArray())) {
                foreach($time_extra_temp as $t_ex_item) {
                    DB::table('inventory_time_extra')->insert([
                        'item_id' => $item_id,
                        'num_worker' => $t_ex_item->num_worker,
                        'num_stairs' => $t_ex_item->num_stairs,
                        'location_type' => $t_ex_item->location_type,
                        'groundfloor_min' => $t_ex_item->groundfloor_min,
                        'groundfloor_med' => $t_ex_item->groundfloor_med,
                        'groundfloor_max' => $t_ex_item->groundfloor_max,
                        'bulkhead_min' => $t_ex_item->bulkhead_min,
                        'bulkhead_med' => $t_ex_item->bulkhead_med,
                        'bulkhead_max' => $t_ex_item->bulkhead_max,
                        'en_steps_min' => $t_ex_item->en_steps_min,
                        'en_steps_med' => $t_ex_item->en_steps_med,
                        'en_steps_max' => $t_ex_item->en_steps_max,
                    ]);
                }
            }

            DB::beginTransaction();
                
            $booking_truck = booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();
            
            $inventory = Inventory::where(array('id'=>$item->id))->first();
            
            $data['item_id']         = $inventory->id;
            $data['truck_id']         = $booking_truck->truck_id;
            $data['item_name']         = $inventory->name;
            $data['item_image']      = isset($inventory->item_image) ? $inventory->item_image : 0;
            $data['file_path']          = $inventory->file_path=='/no_item.jpg'?:$inventory->file_path;
            $data['quantity']          = $request->quantity;
            $data['breadth']          = $inventory->breadth;
            $data['height']          = $inventory->height;
            $data['width']               = $inventory->width;
            $data['volume']          = $inventory->width * $inventory->height * $inventory->breadth;
            $data['weight']          = $inventory->weight;
            $data['similar']          = $inventory->similar;
            
            if(isset($request->ranking) && !empty($request->ranking))
            {
                $data['ranking'] = $request->ranking;
            }
            else
            {
                $data['ranking'] = null;
            }        
            
            $locationData = DB::table('booking_form_location')

                ->selectRaw('distinct(booking_loc_id) as booking_loc_id')

                ->where('booking_id',$booking_id)
                
                ->get();
            $data['pick_up_loc_id']  = $locationData[0]->booking_loc_id;
            $data['drop_off_loc_id'] = $locationData[1]->booking_loc_id;
            $data['booking_id']      = $booking_id;
            $data['created_at']      = now();
            $data['updated_at']      = now();
            $data['booking_item_id'] = $booking_item_id = booking::save_item($data);
            
            
            $update_item['pick_up_time']  = $this->item_moving_time($data,'pick_up');
            $update_item['drop_off_time'] = $this->item_moving_time($data,'drop_off');
            $where['booking_item_id'] = $booking_item_id;
            $booking_item_id = booking::update_item($update_item,$where);
            
            
            if(isset($request->answer))
            {
                foreach($request->answer as $q_id => $val)
                {
                    $item_answer['booking_id'] = $booking_id;
                    $item_answer['item_id'] = $request->item_id;
                    $item_answer['question_id'] = $q_id;
                    $item_answer['answer'] = $val;
                    booking::save_answer($item_answer);    
                }
            }

            $truck_schedule = VehicleSchedule::where('booking_id',$booking_id)->where('truck_id',$data['truck_id'])->first();
            
            if(isset($truck_schedule->id))
            {
                $p['booking_id'] = $booking_id;
                $booking_items = booking::get_booking_items($p);
                
                
                $item_total_volume = 0;
                foreach($booking_items as $item_volume)
                {
                    $item_total_volume = $item_total_volume + ($item_volume->volume * $item_volume->quantity);
                }
                
                if($item_total_volume < $booking_truck->volume)
                {
                    $moving_time = $update_item['pick_up_time'] + $update_item['drop_off_time'];
                    $vehicle_sch['end_time'] = date('g:i A', strtotime("+{$moving_time} minutes", strtotime($truck_schedule->end_time)));
                    VehicleSchedule::where('truck_id',$data['truck_id'])->update($vehicle_sch);
                }
            }
            
            DB::commit();


            // echo '<pre>';
            // print_r($_FILES);
            // echo '</pre>';
            // exit;
            
            // $ext = ltrim(strstr($_FILES['picture']['name'], '.'), '.');
            // $path = public_path() . "/uploads/inventory";
            
            // $file_name = $item->id.'_'.$_FILES['picture']['name'];
            // $target_file = $path.'/'. $file_name;
            
            // if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file))
            // {
            //     $update['file_path']     = "/uploads/inventory/".$file_name;
            //     $update['file_name']     = $_FILES['picture']['name'];
            //     $update['file_size']     = $_FILES['picture']['size'];
            //     $update['file_type']     = $_FILES['picture']['type'];
            //     $update['extension']     = $ext;
            //     $where['id'] = $item->id;
            //     Inventory::update_item_image($update,$where);
            // } 
    
            return redirect()->to('booking/'.$booking_id . '?show_alert=n_i_c');
        }
        
        if(isset($request->btn_submit))
        {
            if($request->btn_submit == 1)
            {
                return $this->save_step1($request,$booking_id);
            }
            if($request->btn_submit == 2)
            {
                return $this->save_step2($request,$booking_id);
            }
            if($request->btn_submit == 3)
            {
                return $this->save_step3($request,$booking_id);
            }
            if($request->btn_submit == 4)
            {    
                    
                return $this->save_step4($request,$booking_id);
            }
            if($request->btn_submit == 5)
            {

                if(isset($request->update_quantity))
                {
                    $param['quantity'] = $request->quantity;
                    $where['booking_item_id'] = $request->booking_item_id;
                    
                    if($request->truck_limit == 'close' && $request->quantity > $request->quantity_limit)
                    {
                        return redirect()->to('booking/'.$booking_id);
                    }                    
                    else
                    {
                        
                        Booking::update_quantity($param,$where);
                    
                        $booking_truck = booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();
                        $truck_schedule = VehicleSchedule::where('booking_id',$booking_id)->where('truck_id',$request->truck_id)->first();
            
                        if(isset($truck_schedule->id))
                        {
                            $p['booking_id'] = $booking_id;
                            $booking_items = booking::get_booking_items($p);
                            
                            
                            $item_total_volume = 0;
                            foreach($booking_items as $item_volume)
                            {
                                $item_total_volume = $item_total_volume + ($item_volume->volume * $item_volume->quantity);
                            }
                            
                            if($item_total_volume < $booking_truck->volume)
                            {
                                $moving_time = $update_item['pick_up_time'] + $update_item['drop_off_time'];
                                $vehicle_sch['end_time'] = date('g:i A', strtotime("+{$moving_time} minutes", strtotime($truck_schedule->end_time)));
                                VehicleSchedule::where('truck_id',$data['truck_id'])->update($vehicle_sch);
                            }
                        }
                    }
                    
                    return redirect()->to('booking/'.$booking_id);
                }
                elseif(isset($request->create_item))
                {
                    $this->add_new_item($request,$booking_id);
                    return redirect()->to('booking/'.$booking_id);
                }
                else
                {
                    return $this->save_step5($request,$booking_id);    
                }
            }
            if($request->btn_submit == 6)
            {
                return $this->save_step6($request,$booking_id);
            }
            if($request->btn_submit == 'preview')
            {
                return $this->save_finish($request,$booking_id);
            }
            
            if($request->btn_submit == 'checkout')
            {
                return $this->checkout($request,$booking_id);
            }
            if ($request->btn_submit == 7) {
                return $this->save_step7($request, $booking_id);
            }
            if ($request->btn_submit == 0) {
                return $this->save_submit($request, $booking_id);
            }
            
            
        }
        elseif($request->btn_delete == 5)
        {
            return $this->delete_item($request,$booking_id);
        }
        elseif (isset($request->btn_kit_check)) {
            if($request->btn_kit_check == 1) {
                if(isset($request->kit)) {
                    $kit = implode(',', $request->kit);
                    //save kit to booking_form
                    DB::table('booking_form')->where([
                        'booking_id' => $booking_id
                    ])->update([
                        'kit' => $kit
                    ]);
                }
            } else {
                DB::table('booking_form')->where([
                    'booking_id' => $booking_id
                ])->update([
                    'kit' => 'none'
                ]);
            }
            return $this->save_step7($request,$booking_id);
        }

        // booking flow in each step
        else
        {
            if(!empty($booking_id))
            {
                $booking = booking::where('booking_id',$booking_id);
                $booking = $booking->first();
                
                //dd($booking);
                
                if($booking->step == 1)
                {
                    return view('booking.services', compact('services','booking'));        
                }
                elseif($booking->step == 2)
                {
                    $booking_location = booking::get_booking_location($booking_id);

                    // $building_types = Booking::where('booking_id', $booking_id)->select('s_building_type', 'd_building_type')->first();
                    $Textdefine = DB::table('text_define')

                    ->selectRaw('name,color,font_size')
                    ->where('id',1)

                    ->get();

                    // echo '<pre>';
                    // print_r($booking_location->toArray());
                    // echo '</pre>';
                    // exit;

                    return view('booking.map', compact('services','booking','booking_location', 'Textdefine'));

                }
                elseif($booking->step == 3)
                {
                    $calender = Helper::GetCelender(date("Y"));
                    $demand = PeakFactor::GetCustomerDemand();
                    //dd($demand);
                    $c_date['now_year'] = date('Y'); 
                    $peak = PeakFactor::where('year',$c_date['now_year'])->get();
                    $booking_dates = booking::get_booking_dates($booking_id);
                    
                    foreach ($calender as $month => $value) 
                    {
                        foreach ($value as $k =>$week) 
                        {                
                            foreach($week as $week_k =>  $day) 
                            {
                                $calender[$month][$k][$week_k] = array($day,'N');
                                foreach($peak as $p) 
                                {
                                    if($p->month == $month && $p->day == $day && $p->value > 0)
                                    {
                                        if($p->value >= $demand[0]->high)
                                        {
                                            $calender[$month][$k][$week_k][1] = 'high';
                                        }
                                        if($p->value < $demand[0]->high &&  $p->value > $demand[0]->low)
                                        {
                                            $calender[$month][$k][$week_k][1] = 'moderate';
                                        }
                                        if($p->value <= $demand[0]->low)
                                        {
                                            $calender[$month][$k][$week_k][1] = 'low';
                                        }
                                        
                                    }
                                }
                            }                        
                        }
                    }
                    // echo '<pre>';
                    // print_r($calender);
                    // echo '</pre>';
                    
                    $time_charges = TimeCharges::get();
                    
                    return view('booking.date_time', compact('services','booking','booking_dates','calender','peak','time_charges'));        
                }
                elseif($booking->step == 4)
                {
                    $booking_location = booking::get_booking_location($booking_id);
                    
                    // echo '<pre>';
                    // print_r($booking_location->toArray());
                    // echo '</pre>';
                    // exit;
                    if($agent->isMobile()){
                        return view('booking.mob_location', compact('services','booking','booking_location'));
                    }else{
                        return view('booking.location', compact('services','booking','booking_location'));
                    }
                    
                }
                elseif($booking->step == 5)
                {
                    $search = $truck = null;
                    $preset_show = false;
                    if($request->btn_preset == true)
                    {
                        $param['item_ids'] = json_decode($request->btn_preset)->item_ids;
                        $items = Inventory::SearchInventoryItems($param);

                        $quantities = explode(',', json_decode($request->btn_preset)->item_quantity);
                        foreach (explode(',', json_decode($request->btn_preset)->item_ids) as $k => $id) {
                            foreach ($items as $item) {
                                if ($item->id == $id) {
                                    if (isset($quantities[$k])) {
                                        $item->preset_quantity = ($quantities[$k] == '') ? 0 : $quantities[$k];
                                    } else {
                                        $item->preset_quantity = 0;
                                    }
                                }
                            }
                        }
                        $preset_show = true;
                        $search = 'exist';
                    }
                    elseif($request->btn_search == true)
                    {
                        $search = $param['item_search'] = $request->item_search;
                        $items = Inventory::SearchInventoryItems($param);
                        $preset_show = true;
                    }
                    else
                    {
                        $selected_items = booking::get_booking_items($booking_id);
                        $selected_item_ids = array();
                        foreach($selected_items as $item) {
                            $selected_item_ids[] = $item->item_id;
                        }
                        $items = Inventory::whereIn('id', $selected_item_ids)->get();
                    }

                    $booking_location = booking::get_booking_location($booking_id);
                    
                    $selected_items = booking::get_booking_items($booking_id);
                    foreach ($selected_items as $selected_item) {
                        $dis_assems = DB::table('inventory_dis_assembly')->where(['item_id' => $selected_item->item_id])->get();
                        $selected_item->dis_assems = count($dis_assems);
                    }
                    
                    $booking_item_answers = booking::get_booking_item_answers($booking_id);

                    $selected_item_answers = array();
                    foreach($booking_item_answers as $answers)
                    {
                        $selected_item_answers[$answers->question_id] = $answers;
                    }
                    

                    // Get Ranking
                    $ranking = Inventory::GetRanking();

                    foreach($items as $itm)
                    {
                        $item_ids[] = $itm->id;
                    }
                    
                    $item_images = booking::get_item_images(array('booking_id'=>$booking_id))->get();

                    if (isset($item_ids)) {
                        $question = Question::whereIn('item_id',$item_ids)->get();
                    } else {
                        $question = [];
                    }
                                        
                    // foreach($items as $k => $item)
                    // {
                    //     $items[$k]->question = false;
                    //     foreach($question as $q)
                    //     {
                    //         if($q->item_id == $item->id)
                    //         {
                    //             $items[$k]->question = true;
                    //             break;
                    //         }
                    //     }
                    // }
                    
                    $presets = Preset::orderBy('created_at', 'desc')->get();
                    $equipments = Inventory::GetInventoryEquipment();
                    $categories = Category::orderBy('created_at', 'desc')->get();
                    
                    $booking_truck_exist = booking::get_booking_truck(array('booking_id'=>$booking_id))->count();
                    
                    // dd($booking_truck_exist);
                    $available_trucks = $this->get_truck_availability($booking);
                     //dd($available_trucks[0]->id);
                    if($booking_truck_exist == 0 && isset($available_trucks[0]))
                    {
                        $truck_add['booking_id'] = $booking_id;
                        $truck_add['truck_id'] = $available_trucks[0]->id;
                        $truck_add['truck_name'] = $available_trucks[0]->name;
                        $truck_add['item_ids'] = 0;
                        $truck_add['truck_volume'] = $available_trucks[0]->volume;
                        $truck_add['item_volume'] = 0;
                        $truck_add['status'] = 1;
                        $truck_add['created_at'] = now();
                        $truck_add['updated_at'] = now();
                        booking::add_booking_truck($truck_add);    
                        
                        $vehicle_sch['booking_id']    = $booking_id;
                        $vehicle_sch['user_id']        = $booking->user_id;
                        $vehicle_sch['truck_id']    = $available_trucks[0]->id;
                        $vehicle_sch['assigned_on']    = now();
                        $vehicle_sch['start_time']    = $booking->start_time;
                        $vehicle_sch['end_time']    = date('g:i A', strtotime("+{$booking->minutes} minutes", strtotime($booking->start_time)));
                        $vehicle_sch['created_at']    = now();
                        $vehicle_sch['updated_at']    = now();
                        
                        VehicleSchedule::insert($vehicle_sch);
                        
                    }
                    
                    $booking_form_truck = booking::get_booking_truck(array('booking_id'=>$booking_id))->get();
                    //echo 1; return ;
                    //dd($booking_form_truck);
                    
                    $accuracy = Accuracy::get();

                    // Get questions for items
                    $questions = DB::table('inventory_questions')->select('*')->get()->toArray();
                    // Get questions for categories
                    $c_questions = DB::table('category_questions')->select('*')->get()->toArray();

                    // Get questions for each item
                    foreach ($items as $i) {
                        $q_temp = [];
                        foreach ($questions as $q) {
                            if ($q->item_id == $i->id) {
                                array_push($q_temp, array(
                                    'title' => $q->title,
                                    'id' => $q->id,
                                    'allow' => $q->allow,
                                ));
                            }
                        }
                        foreach ($c_questions as $cq) {
                            if($cq->category_id == $i->category_id) {
                                array_push($q_temp, array(
                                    'title' => $cq->title,
                                    'id' => $cq->question_id,
                                    'allow' => $cq->allow,
                                ));
                            }
                        }
                        $i->question = json_encode($q_temp);
                    }

                    // Get vehicle types
                    $v_types = DB::table('vehicle_types')->select('*')->get()->toArray();
                    $total_items = Inventory::all();

                    $R = array();
                    if (isset($item_ids)) {
                        $R_temp = DB::table('inventory_dis_assembly')->whereIn('item_id', $item_ids)->get();
                        foreach ($item_ids as $id) {
                            foreach ($R_temp as $temp) {
                                if ($temp->item_id == $id) {
                                    $R[$id][] = $temp;
                                }
                            }
                        }
                    }

                    $items_weight =  DB::table('item_weights')
                    ->selectRaw('id,name')
                    ->get();

                    $item_dimension = DB::table('item_dimensions')
                    ->selectRaw('id,name')
                    ->get();

                    $survival_kit = ShuffleFee::first()->survival_kit;
                    $supplies_kit = ShuffleFee::first()->supplies_kit;

                    $items_array = array();
                    foreach ($total_items as $k => $item) {
                        $items_array[] = $item->name;
                    }

                    $selected_array = array();
                    foreach ($selected_items->toArray() as $item) {
                        $selected_array[$item->item_id]['quantity'] = $item->quantity;
                        $selected_array[$item->item_id]['booking_item_id'] = $item->booking_item_id;
                    }

                    if($agent->isMobile()){
                       return view('booking.mob_inventory', compact('services','booking','booking_location','items','item_images','selected_items','selected_item_answers','question','ranking','presets','equipments','categories','search','available_trucks','booking_form_truck','accuracy', 'v_types', 'preset_show', 'total_items', 'R','items_weight','item_dimension', 'survival_kit', 'supplies_kit','items_array', 'selected_array'));
                    }else{
                        if (isset($request->show_alert)) {
                            $show_alert = 'n_i_c';
                            return view('booking.inventory', compact('services','booking','booking_location','items','item_images','selected_items','selected_item_answers','question','ranking','presets','equipments','categories','search','available_trucks','booking_form_truck','accuracy', 'v_types', 'preset_show', 'total_items', 'R','items_weight','item_dimension', 'survival_kit', 'supplies_kit','items_array', 'selected_array', 'show_alert'));
                        } else {
                            return view('booking.inventory', compact('services','booking','booking_location','items','item_images','selected_items','selected_item_answers','question','ranking','presets','equipments','categories','search','available_trucks','booking_form_truck','accuracy', 'v_types', 'preset_show', 'total_items', 'R','items_weight','item_dimension', 'survival_kit', 'supplies_kit','items_array', 'selected_array'));
                        }
                    }

                
                }
                // elseif($booking->step == 6)
                // {
                    // $join['booking_form_insurance_left'] = true;
                    // $selected_items = booking::get_booking_items($booking_id,$join);
                    // $insuranceCategories = InsuranceCategory::all();
                    // $PropertyInsurance = PropertyInsurance::all();
                    // return view('booking.insurance', compact('services','booking','selected_items','insuranceCategories','PropertyInsurance'));
                // }
                // elseif($booking->step == 7)
                // {
                    // $items = Inventory::all();
                    
                    // $selected_items = booking::get_booking_items($booking_id);
                    // $selected_item_answers = booking::get_booking_item_answers($booking_id);

                    // // Get Ranking
                    // $ranking = Inventory::GetRanking();

                    // foreach($items as $itm)
                    // {
                        // $item_ids[] = $itm->id;
                    // }

                    // $question = Question::whereIn('item_id',$item_ids)->get();
                    
                    // $presets = Preset::all();
                    // $distanceAndMinutes = session()->get("mapLocationDetails");
                    
                    // return view('booking.checkout', compact('services','booking','items','selected_items','question','ranking'));
                // }
                elseif($booking->step == 6)
                {
                    if ($booking->service_type_id != 6) {
                        if (isset($request->show_alert)) {
                            return redirect()->to('summary/'.$booking_id . '?show_alert=' . true . '&reason=' . $request->reason);
                        } else {
                            return redirect()->to('summary/'.$booking_id);
                        }
                    } else {
                        return redirect()->to('summary_shuffle/'.$booking_id);
                    }
                } else if ($booking->step == 7) {
                    $charges = DB::table('booking_form_charges')->where([
                        'booking_id' => $booking_id
                    ])->get();

                    $booking_location = booking::get_booking_location($booking_id);

                    $additional_location = DB::table('booking_form_add_billing_loc')->where([
                        'booking_id' => $booking_id
                    ])->get()->toArray();

                    return view('booking.final', compact('charges', 'booking', 'booking_location', 'additional_location'));
                } else if ($booking->step == 0) {
                    $end_booking = 1;
                    return view('booking.services', compact('services', 'booking', 'end_booking'));
                }
            }
            else
            {
                return view('booking.services', compact('services','booking'));
            }
        }
    }
    
    public function btn_save_step($booking_id,$step)
    {
        if(!empty($step))
        {
            $step_update['step'] = $step;
            booking::where('booking_id',$booking_id)->update($step_update);
            return redirect()->to('booking/'.$booking_id);
        }
    }
    
    
    
    function get_truck_availability($booking)
    {
        $param['created_at'] = $booking->primary_date;
        $param['start_time'] = $booking->start_time;
        $truck_count = Truck::GetAvailableTruck($param)->count();
        if($truck_count > 0)
        {
            $trucks = Truck::GetAvailableTruck($param)->get();
        }
        else
        {
            //$p['created_at'] = null;
            $trucks = Truck::get();
        }
        
        return $trucks;
    }
    
    function get_available_truck($booking_id)
    {
        $booking = booking::where('booking_id',$booking_id)->first();
        
        $result = $this->calculate_job_time($booking);
        
        $total_job_time = $result[0];
        $total_volume     = $result[1];
        $total_weight     = $result[2];
        
        // Get All Assigned Trucks Of date Current or greater then job date
        $v_param['primary_date'] = $booking->primary_date;
        $v_param['start_time'] = $booking->start_time;
        $v_param['over_all_minutes']  = $total_job_time;
        
        $job_start_time = new DateTime($v_param['primary_date'].' '.$v_param['start_time']);
        $job_end_time   = new DateTime($v_param['primary_date'].' '.$v_param['start_time']);
        $job_end_time->modify("+{$v_param['over_all_minutes']} minutes");
        
        $assigned_truck = Booking::whereNotNull('truck_id')->where('booking_date',$booking->booking_date)->where('status','Pending')->get();
        
        if(isset($assigned_truck[0]))
        {
            $truck_ids = array();
            $invalid_trucks = array();
            
            foreach($assigned_truck as $key => $time)
            {
                $start_time = new DateTime($time->prefer_date.' '.$time->start_time);
                $end_time = new DateTime($time->prefer_date.' '.$time->end_time);
            
                if( ($job_start_time <= $start_time  &&  $start_time <= $job_end_time) ||  ($job_start_time <= $end_time  &&  $end_time <= $job_end_time) )
                {
                    // Don't Include Truck 
                    $invalid_trucks[$time->id] = $time->truck_id;
                }
                $truck_ids[] = $time->truck_id;
            }
            
            $truck_volumes = Truck::whereIn('id',$truck_ids)->where('volume','<',$total_volume)->pluck('volume','id as truck_id');
            
            foreach($truck_volumes as  $key => $volume)
            {
                $invalid_trucks[$key] = $volume;
            }
            
            foreach($assigned_truck as  $key => $time)
            {
                if(!in_array($time->truck_id,$invalid_trucks))
                {
                    $start_time = new DateTime($time->primary_date.' '.$time->start_time);
                    $end_time = new DateTime($time->primary_date.' '.$time->end_time);
                    
                    // Prevoius job time
                    if( $end_time < $job_start_time )
                    {
                        $valid_trucks_arr[$time->truck_id]['truck_id'] = $time->truck_id;
                        $valid_trucks_arr[$time->truck_id]['left_d_lat'] = $time->d_lat;
                        $valid_trucks_arr[$time->truck_id]['left_d_lng'] = $time->d_lng;
                        $valid_trucks_arr[$time->truck_id]['start_time'] = $time->start_time;
                        $valid_trucks_arr[$time->truck_id]['end_time'] = $time->end_time;
                        $valid_trucks_arr[$time->truck_id]['primary_date'] = $time->primary_date;
                    }
                    
                    // Next job time
                    if( $start_time > $job_end_time )
                    {
                        // $valid_trucks_arr[$time->truck_id]['truck_id'] = $time->truck_id;
                        // $valid_trucks_arr[$time->truck_id]['right_s_lat'] = $time->s_lat;
                        // $valid_trucks_arr[$time->truck_id]['right_s_lng'] = $time->s_lng;
                        // $valid_trucks_arr[$time->truck_id]['start_time'] = $time->start_time;
                        // $valid_trucks_arr[$time->truck_id]['end_time'] = $time->end_time;
                    }
                    
                    $valid_trucks_arr[$time->truck_id]['job_lat'] = $booking->s_lat;
                    $valid_trucks_arr[$time->truck_id]['job_lng'] = $booking->s_lng;

                }
            }
            
            if(!empty($valid_trucks_arr))
            {
                $valid_trucks_dist = array();
                foreach($valid_trucks_arr as  $k => $truck)
                {
                    if(!empty($truck['truck_id']) && !empty($truck['left_d_lat']) && !empty($truck['left_d_lng']))
                    {
                        $start_point = $truck['left_d_lat'] .','. $truck['left_d_lng'];
                        $end_point = $truck['job_lat'] .','. $truck['job_lng'];
                        
                        $origins = 'origins='.$start_point;
                        $destination = 'destinations='.$end_point;
                        
                        $key = 'key='. Setting::get('map_key');
                        
                        $url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
                        $url .= '&'.$origins.'&'.$destination.'&'.$key;
                        
                        // get the json response from url
                        $resp = json_decode(file_get_contents($url), true);
                        
                        if($resp['rows'][0]['elements'][0]['duration']['text'])
                        {
                            $valid_trucks_arr[$k]['dist_time'] = $resp['rows'][0]['elements'][0]['duration']['text'];
                            $valid_trucks_dist[$k] = $resp['rows'][0]['elements'][0]['duration']['text'];
                        }
                    }
                }
                
                // Get smaller number
                
                if(!empty($valid_trucks_dist))
                {
                    $dist_time = 0;
                    foreach($valid_trucks_dist as  $key => $travel_time)
                    {
                        if($dist_time == 0)
                        {
                            $dist_time = $travel_time;
                        }
                        
                        if($travel_time <= $dist_time)
                        {
                            $valid_truck = $valid_trucks_arr[$key];
                        }
                    }
                    
                    $start_time = new DateTime($valid_truck['primary_date'].' '.$valid_truck['start_time']);
                    $end_time = new DateTime($valid_truck['primary_date'].' '.$valid_truck['end_time']);
                    $end_time->modify($valid_truck['dist_time']);
                    
                    if( ($job_start_time <= $start_time  &&  $start_time <= $job_end_time) ||  ($job_start_time <= $end_time  &&  $end_time <= $job_end_time))
                    {
                        // Time Exceeded of prevoius job
                        $valid_truck = null;
                    }
                }
            }
        }    
        
        if(isset($valid_truck) && $valid_truck != null)
        {
            $truck_id = $valid_truck['truck_id'];
        }
        else
        {
            // Assign One Available Truck which Volume is Greater than Request Items Volume
            $t_param['volume'] = $total_volume;
            $t_param['primary_date'] = $v_param['primary_date'];
            $available_trucks = Truck::GetAllAvailableTruck($t_param);
            //echo 123; return;
            
            if(!empty($available_trucks))
            {
                $truck_id = $available_trucks->id;    
            }
            else
            {
                $truck_id = 0;    
            }
        }
            
        // Insert Truck Id into Request
        if(isset($truck_id))
        {
            $req_update['truck_id'] = $truck_id;
        }
        
        $req_update['start_time'] = $v_param['start_time'];
        $req_update['end_time'] = date('g:i A', strtotime("+{$total_job_time} minutes", strtotime($v_param['start_time'])));
        //$req_update['exp_end_time'] = $req_update['end_time'];
        
        $req_update['items_volume'] = $total_volume;
        $req_update['items_weight'] = $total_weight;
        
        $req_update['over_all_minutes'] = $v_param['over_all_minutes'];
        
        Booking::where('booking_id',$booking->booking_id)->update($req_update);
        
        $start_time = session()->get("dateDetails")['time'];
        
        $vehicle_sch['booking_id']    = $booking_id;
        $vehicle_sch['user_id']        = $booking->user_id;
        $vehicle_sch['truck_id']    = $truck_id;
        $vehicle_sch['assigned_on']    = now();
        $vehicle_sch['start_time']    = $start_time;
        $vehicle_sch['created_at']    = now();
        $vehicle_sch['updated_at']    = now();
        
        VehicleSchedule::insert($vehicle_sch);
        
        $job['booking_id'] = $booking_id;
        $job['user_id'] = Auth::user()->id;
        $job['created_at'] = time();
        $job['updated_at'] = time();
        $job['created_by'] = Auth::user()->id;
        $job['updated_by'] = Auth::user()->id;
        
        UserMovingRequest::AddAssignedJobUsers($job);
    }

    public function calculate_job_time($booking)
    {
        
        // Get Ranking
        $ranking = array();
        $ranking_obj = Inventory::GetRanking();
        foreach($ranking_obj as $r_k=>$r_v){$ranking[$r_v->ranking_id] = $r_v;}
        
        $booking_items = booking::get_inventory_booking_items($booking->booking_id);
        $location = booking::get_booking_location($booking->booking_id);
        //dd($location);
        //dd($booking_items);
        $total_volume = 0;
        $total_weight = 0;
        $total_item_move_time = 0;
        
        foreach($booking_items as $k => $item)
        {
            // Get Volume Inventory Items
            $total_volume = $total_volume + $item->volume;
            $total_weight = $total_weight + $item->weight; 
            
            foreach($location as $loc)
            {
                // Get Total Number Of Stairs of Pick and Drop location
                $flight_no = $loc->flights;
                if($flight_no == 0)
                {
                    $avg_time = ($item->time_0_min + $item->time_0_med + $item->time_0_max)/3;
                }
                if($flight_no == 1)
                {
                    $avg_time = ($item->time_1_min + $item->time_1_med + $item->time_1_max)/3;
                }
                if($flight_no == 2)
                {
                    $avg_time = ($item->time_2_min + $item->time_2_med + $item->time_2_max)/3;
                }
                if($flight_no == 3)
                {
                    $avg_time = ($item->time_3_min + $item->time_3_med + $item->time_3_max)/3;
                }
                if($flight_no == 4)
                {
                    $avg_time = ($item->time_4_min + $item->time_4_med + $item->time_4_max)/3;
                }
                if($flight_no == 5)
                {
                    $avg_time = ($item->time_5_min + $item->time_5_med + $item->time_5_max)/3;
                }
                if($flight_no == 6)
                {
                    $avg_time = ($item->time_6_min + $item->time_6_med + $item->time_6_max)/3;
                }
                
                $total_item_move_time = $total_item_move_time + $avg_time;
                
                // If Stairs type is windy helper take less time  
                if($loc->stair_type == 'windy')
                {
                    $total_item_move_time = $total_item_move_time + $item->stair_windy;
                }
                
                // If Stairs type is narrow helper take more time 
                if($loc->stair_type == 'narrow')
                {
                    $total_item_move_time = $total_item_move_time + $item->stair_narrow;
                }
                
                //3. Calculate Assembling / Disassembling Items Time
                if(isset($item->ranking))
                {
                    if($ranking[$item->ranking]->alphabet == "A")
                    {
                        $total_item_move_time = $total_item_move_time + $item->R_A;
                    }
                    elseif($ranking[$item->ranking]->alphabet == "B")
                    {
                        $total_item_move_time = $total_item_move_time + $item->R_B;
                    }
                    elseif($ranking[$item->ranking]->alphabet == "C")
                    {
                        $total_item_move_time = $total_item_move_time + $item->R_C;
                    }
                    elseif($ranking[$item->ranking]->alphabet == "D")
                    {
                        $total_item_move_time = $total_item_move_time + $item->R_D;
                    }
                    elseif($ranking[$item->ranking]->alphabet == "E")
                    {
                        $total_item_move_time = $total_item_move_time + $item->R_E;
                    }
                }
            }
        }
        
        // echo '<pre>';
        // print($total_item_move_time);
        // echo '</pre>';
        // die;
        // echo '<pre>56';
        // print($booking->minutes);
        // echo '</pre>';
        // die;
        
        if($booking->minutes > 0)
        {
            $total_job_time = $booking->minutes + $total_item_move_time;    
        }
        else
        {
            $total_job_time = 0 + $total_item_move_time;    
        }
        
        // print_r($total_job_time);
        // die;
        return array($total_job_time,$total_volume,$total_weight);
        
    }

    public function add_new_item($request,$booking_id)
    {
        DB::beginTransaction();
        
            $item = new Inventory;
            $item->name = $request->get('name');
            $item->category_id = $request->get('category');
            $item->weight = $request->get('weight');
            $item->width = $request->get('width');
            $item->height = $request->get('height');
            $item->breadth = $request->get('breadth');
            $item->volume = $item->width * $item->height * $item->breadth;
            
            $item->ranking_id = $request->get('ranking');
            
            $item->equipments = implode(',',$request->get('equipments'));
            
            $item->stair_windy = $request->get('stair_time_windy');
            $item->stair_narrow = $request->get('stair_time_narrow');
            $item->stair_wide = $request->get('stair_time_wide');
            $item->stair_spiral = $request->get('stair_time_spiral');
            $item->elevator_passenger = $request->get('elevator_time_passenger');
            $item->elevator_freight = $request->get('elevator_time_freight');
            $item->elevator_reserved_freight = $request->get('elevator_time_rs_freight');
            
            $item->R_A = $request->get('R_A');
            $item->R_B = $request->get('R_B');
            $item->R_C = $request->get('R_C');
            $item->R_D = $request->get('R_D');
            $item->R_E = $request->get('R_E');
            
            $item->time_0_min = $request->time_0_min;
            $item->time_0_med = $request->time_0_med;
            $item->time_0_max = $request->time_0_max;
            $item->time_1_min = $request->time_1_min;
            $item->time_1_med = $request->time_1_med;
            $item->time_1_max = $request->time_1_max;
            $item->time_2_min = $request->time_2_min; 
            $item->time_2_med = $request->time_2_med; 
            $item->time_2_max = $request->time_2_max; 
            $item->time_3_min = $request->time_3_min; 
            $item->time_3_med = $request->time_3_med; 
            $item->time_3_max = $request->time_3_max; 
            $item->time_4_min = $request->time_4_min; 
            $item->time_4_med = $request->time_4_med; 
            $item->time_4_max = $request->time_4_max;
            $item->time_5_min = $request->time_5_min;
            $item->time_5_med = $request->time_5_med; 
            $item->time_5_max = $request->time_5_max; 
            $item->time_6_min = $request->time_6_min; 
            $item->time_6_med = $request->time_6_med; 
            $item->time_6_max = $request->time_6_max; 
            
            //dd($item);
            $item->save();
            $item_id = $item->id;
        
        if ($request->hasFile('picture')) 
        {
            $this->upload_picture($request,$booking_id,$booking_item_id);
        }        
            
        DB::commit();
    }

    public static function create_booking_truck($request,$booking_id)
    {
        $new_truck = explode(',',$request->btn_new_truck);
        
        $truck_add['booking_id'] = $booking_id;
        $truck_add['truck_id'] = $new_truck[0]; // truck id
        $truck_add['truck_name'] = $new_truck[1];// truck name
        $truck_add['item_ids'] = 0;
        $truck_add['truck_volume'] = $new_truck[2];// truck volume
        $truck_add['item_volume'] = 0;
        $truck_add['status'] = 1;
        $truck_add['created_at'] = now();
        $truck_add['updated_at'] = now();
        
        $update['status'] = 0;
        booking::update_truck_availability($booking_id,$update);
        
        booking::add_booking_truck($truck_add);
        
        $booking = booking::where('booking_id',$booking_id)->first();
        $end_time = date('g:i A', strtotime("+{$booking->minutes} minutes", strtotime($booking->start_time)));
        
        $vehicle_sch['booking_id']    = $booking_id;
        $vehicle_sch['user_id']        = $booking->user_id;
        $vehicle_sch['truck_id']    = $new_truck[0];
        $vehicle_sch['assigned_on']    = now();
        $vehicle_sch['start_time']    = $booking->start_time;
        $vehicle_sch['end_time']    = $end_time;
        $vehicle_sch['created_at']    = now();
        $vehicle_sch['updated_at']    = now();
        
        VehicleSchedule::insert($vehicle_sch);
        
    }
    public static function upload_picture($request,$booking_id,$booking_item_id)
    {
        
        $ext = ltrim(strstr($_FILES['picture']['name'], '.'), '.');
        
        $data['booking_id']         = $booking_id;
        $data['booking_item_id']     = $booking_item_id;
        $data['file_name']          = $_FILES['picture']['name'];
        $data['file_size']          = $_FILES['picture']['size'];
        $data['file_type']          = $_FILES['picture']['type'];
        $data['extension']          = $ext;
        $data['status']  = 1;
        $data['created_at'] = time();
        $data['updated_at'] = time();
        $file_id = booking::save_item_image($data);
        
        $file_name = $booking_id.'-'.$booking_item_id.'-'.$file_id;
        
        if ($file_id) 
        {
            
            //$path = public_path() . "/uploads/booking/".$booking_id;
            // if(!dir($path))
            // {
                // mkdir($path);    
            // }
            
            $path = public_path() . "/uploads/booking";
            
            $target_file = $path.'/'. $file_name . "." . $ext;
            
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) 
            {
                $update['file_path'] = "/uploads/booking/".$file_name. "." . $ext;
                
                $where['booking_item_id'] = $booking_item_id;
                booking::update_item_image($update,$where);
                return true;
            } 
            else 
            {
                return false;
            }
            
            
        }
    }
    
    public function difficulty_level($booking,$selected_items,$booking_location)
    {
        $difficulty = Dlevel::orderBy('dlevel','ASC')->get();

        $dlevel_id = $difficulty[0]->id;
        
        foreach($difficulty as $k => $v){$difficulty[$k]->dlevel = explode('-',$v->dlevel)[1];}
        
        // echo '<pre>';
        // print_r($selected_items);
        // echo '</pre>';
        // die;
        
        $level = array();
        foreach($difficulty as $k => $lvl)
        {
        
            $level[$k]['id'] = $lvl->id;
            $level[$k]['dlevel'] = $lvl->dlevel;
            $level[$k]['flights'] = 0;
            $level[$k]['stairs_type'] = 0;
            $level[$k]['elevator'] = 0;
            $level[$k]['weight'] = 0;
            $level[$k]['groundfloor'] = 0;
            $level[$k]['entrance'] = 0;
            $level[$k]['bulkhead'] = 0;
            
            foreach($booking_location as $loc)
            {
                if(in_array($loc->flights,explode(',',$lvl->stairs)))
                {
                    if($level[$k]['flights'] == 0){$level[$k]['flights'] = $loc->flights;}else{$level[$k]['flights'] = isset($level[$k]['flights']) ? $level[$k]['flights'].','.$loc->flights : $loc->flights;}
                }
                
                if(in_array($loc->stair_type,explode(',',$lvl->stair_type)))
                {
                    if($level[$k]['stairs_type'] == 0){$level[$k]['stairs_type'] = $loc->stair_type;}else{$level[$k]['stairs_type'] = $level[$k]['stairs_type'].','.$loc->stair_type;}
                }
                
                if(in_array($loc->evelator_type,explode(',',$lvl->elevator)))
                {
                    if($level[$k]['elevator'] == 0){$level[$k]['elevator'] = $loc->evelator_type;}else{$level[$k]['elevator'] = $level[$k]['elevator'].','.$loc->evelator_type;}
                }

                if (($loc->stair_kind == 'groundfloor') && in_array($loc->step_num, explode(',', $lvl->groundfloor))) {
                    $level[$k]['groundfloor']++;
                }

                if (($loc->stair_kind == 'bulkhead') && in_array($loc->step_num, explode(',', $lvl->bulkhead))) {
                    $level[$k]['bulkhead']++;
                }

                if (($loc->stair_kind == 'entrance') && in_array($loc->step_num, explode(',', $lvl->entrance))) {
                    $level[$k]['entrance']++;
                }
            }
            
            foreach($selected_items as $item)
            {
                if(in_array($item->item_name,explode(',',$lvl->items)))
                {
                    $level[$k]['item_name'] = isset($level[$k]['item_name']) ? $level[$k]['item_name'].','.$item->item_name : $item->item_name;
                }
                
                if($item->hoisting == $lvl->hoisting && $lvl->hoisting > 0)
                {
                    $level[$k]['hoisting'] = isset($level[$k]['hoisting']) ? $level[$k]['hoisting'].','.$item->hoisting : $item->hoisting;
                }
                
                if(in_array($item->ranking_id,explode(',',$lvl->ranking)) && $lvl->ranking > 0)
                {
                    $level[$k]['ranking'] = isset($level[$k]['ranking']) ? $level[$k]['ranking'].','.$item->ranking_id : $item->ranking_id;
                }
            }

            if (!empty($lvl->weight)) {
                foreach($selected_items as $item) {
                    if ($item->weight <= explode('-', $lvl->weight)[1] && $item->weight >= explode('-', $lvl->weight)[0]) {
                        $level[$k]['weight'] = 1;
                    }
                }
            }
        }
        
        //$this->printer($selected_items,$level);
        
        foreach($difficulty as $k => $d)
        {
            if($d->dlevel == $level[$k]['dlevel'])
            {
                if($level[$k]['stairs_type'] > 0 || $level[$k]['elevator'] > 0)
                {
                    $confirm_level[$d->id][] = 'stairs';
                }
                if ($level[$k]['weight'] > 0) {
                    $confirm_level[$d->id][] = 'weight';
                }
                if(isset($level[$k]['flights']) && $level[$k]['flights'] > 0)
                {
                    $confirm_level[$d->id][] = 'flights';
                }
                if(isset($level[$k]['hoisting']) && count(explode(',',$level[$k]['hoisting'])) > 0)
                {
                    $confirm_level[$d->id][] = 'hoisting';
                }
                if(isset($level[$k]['ranking']) && count(explode(',',$level[$k]['ranking'])) > 0)
                {
                    $confirm_level[$d->id][] = 'ranking';
                }
                if($level[$k]['groundfloor'] > 0) {
                    $confirm_level[$d->id][] = 'groundfloor';
                }
                if($level[$k]['bulkhead'] > 0) {
                    $confirm_level[$d->id][] = 'bulkhead';
                }
                if($level[$k]['entrance'] > 0) {
                    $confirm_level[$d->id][] = 'entrance';
                }
            }
        }

        if(!empty($confirm_level))
        {
            $count = 0;
            foreach($confirm_level as $k => $c)
            {
                if(count($c) > $count)
                {
                    $count = count($c);
                    $dlevel_id = $k;
                }
            }
        }        
        
        // echo '<pre>';
        // print_r($dlevel_id);
        // echo '</pre>';
        // exit;

        Booking::where('booking_id',$booking->booking_id)->update(array('dlevel'=>$dlevel_id));
        
        $booking->dlevel = $dlevel_id;
        
        return $booking;
        
    }
    
    public function crew_assignment($booking)
    {
        $dlevel_id = $booking->dlevel;
        
        $selected_crew = array();
        if(isset($dlevel_id) && $dlevel_id > 0)
        {
            $combination = Dlevel::GetCrewCombination(array('dlevel'=> $dlevel_id ))->get();

            if($booking->crew_count == 0)
            {
                $booking->crew_count = 3;
                Booking::where('booking_id',$booking->booking_id)->update(array('crew_count'=>3));
            }
            
            if(isset($combination[0]->roles) && $booking->crew_count > 0)
            {
                foreach($combination as $k => $crew)
                {
                    $crew_roles = 0;
                    $crew_roles = explode(',',$crew->roles);
                    
                    if(count($crew_roles) == $booking->crew_count)
                    {
                        $selected_crew = $crew;
                        break;
                    }
                }
            }
            
            
            
            if(empty($selected_crew)) // crew does not exist assign first crew by default 
            {
                $selected_crew = $combination[0];    
            }
            
            // $hourly_rate = Role::where('hourly_rate','<>','')->select('id','name','hourly_rate')->get();
        
            $crew_roles = array();
            
            if(isset($selected_crew->roles))
            {
                $crew_roles = explode(',',$selected_crew->roles);    
                $crew_levels = explode(',', $selected_crew->levels);
                $total_hourly_rate = 0;

                // Get all employees data
                $employees =  User::GetAllEmployee()->get();

                foreach ($crew_roles as $role) {
                    foreach ($employees as $employee) {
                        if ($employee->role_id == $role && in_array($employee->level, $crew_levels)) {
                            $selected_crew->crew_id = isset($selected_crew->crew_id) ? $selected_crew->crew_id . ',' . $employee->id : $employee->id;
                            $selected_crew->rate = isset($selected_crew->rate) ? $selected_crew->rate . ',' . $employee->hourly_rate : $employee->hourly_rate;
                            $total_hourly_rate += $employee->hourly_rate;
                        }
                    }
                }
                
                // foreach($hourly_rate as $rate)
                // {
                //     if(in_array($rate->id,$crew_roles))
                //     {
                //         $total_hourly_rate = $total_hourly_rate + $rate->hourly_rate; 
                //         $selected_crew->rate = isset($selected_crew->rate) ? $selected_crew->rate.','.$rate->hourly_rate : $rate->hourly_rate;
                //     }
                // }
                
                $selected_crew->total_rate = $total_hourly_rate;
            }
        }
        else
        {
            echo '<font color="red"> Difficulty Level not Found</font>';
        }
        
        return $selected_crew;
        
    }
    
    public function printer($selected_items,$level)
    {
        echo '<style>#customers {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;} #customers td, #customers th {border: 1px solid #ddd;padding: 8px;} #customers tr:nth-child(even){background-color: #f2f2f2;} #customers tr:hover {background-color: #ddd;} #customers th {padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white;}</style>';
                
        $s_items = '<table id="customers" class="table table-bordered table-striped">';
        $s_items.= '<tr><th>Item</th><th>flights</th><th>stairs_type</th><th>hoisting</th><th>elevator</th><th>ranking</th></tr>';
        foreach($selected_items as $item)
        {
            $s_items.= '<tr><td>'.$item->name.'</td><td>'.$item->flights.'</td><td>'.$item->stair_type.'</td><td>'.$item->hoisting.'</td><td>'.$item->evelator_type.'</td><td>'.$item->inventory_ranking.'</td></tr>';
        }
        $s_items.= '</table>';
        
        $s_lvl =  '<table id="customers" class="table table-bordered table-striped">';
        $s_lvl .= '<tr><th>Id</th><th>Dlevel</th><th>Item</th><th>flights</th><th>stairs_type</th><th>hoisting</th><th>elevator</th><th>ranking</th><th>Match</th><th>Count</th></tr>';
        
        foreach($level as $lvl)
        {
            $s_lvl .= '<tr>';
            $s_lvl .= isset($lvl['id']) ? '<td>'.$lvl['id'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['dlevel']) ? '<td>'.$lvl['dlevel'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['item_name']) ? '<td>'.$lvl['item_name'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['flights']) ? '<td>'.$lvl['flights'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['stairs_type']) ? '<td>'.$lvl['stairs_type'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['hoisting']) ? '<td>'.$lvl['hoisting'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['elevator']) ? '<td>'.$lvl['elevator'].'</td>' : '<td></td>';
            $s_lvl .= isset($lvl['ranking']) ? '<td>'.$lvl['ranking'].'</td>' : '<td></td>';
            
            $match = 0;
            $match_itm = array();
            
            if($lvl['stairs_type'] > 0 || $lvl['elevator'] > 0)
            {
                $match_itm[] = 'stairs';
                $match = $match + 1;
            }
            if(isset($lvl['flights']) && count(explode(',',$lvl['flights'])) > 0 && ($lvl['flights'] > 0))
            {
                $match_itm[] = 'flights';
                $match = $match + 1;
            }
            if(isset($lvl['hoisting']) && count(explode(',',$lvl['hoisting'])) > 0)
            {
                $match_itm[] = 'hoisting';
                $match = $match + 1;
            }
            if(isset($lvl['ranking']) && count(explode(',',$lvl['ranking'])) > 0)
            {
                $match_itm[] = 'ranking';
                $match = $match + 1;
            }
            
            $s_lvl .= '<td>'.implode('<br>',$match_itm).'</td>';
            $s_lvl .= '<td>'.$match.'</td>';
            $s_lvl .= '</tr>';
        }
        $s_lvl .= '</table>';
        
        echo $s_items;
        echo $s_lvl;
        
    }
    
    // public function item_moving_time($request,$item,$action)
    // {
        
        // $inventory = Inventory::where('id',$item['item_id'])->first();
        
        // if($action == 'pick_up')
        // {
            // $loc = DB::table('booking_form_location')->where('booking_loc_id',$item['pick_up_loc_id'])->first();
        // }
        // if($action == 'drop_off')
        // {
            // $loc = DB::table('booking_form_location')->where('booking_loc_id',$item['drop_off_loc_id'])->first();
        // }
            
        // // Get Total Number Of Stairs of Pick Or Drop location
        // $flight_no = $loc->flights;
        // if($flight_no == 0)
        // {
            // $avg_time = ($inventory->time_0_min + $inventory->time_0_med + $inventory->time_0_max)/3;
        // }
        // if($flight_no == 1)
        // {
            // $avg_time = ($inventory->time_1_min + $inventory->time_1_med+ $inventory->time_1_max)/3;
        // }
        // if($flight_no == 2)
        // {
            // $avg_time = ($inventory->time_2_min +$inventory->time_2_med +$inventory->time_2_max)/3;
        // }
        // if($flight_no == 3)
        // {
            // $avg_time = ($inventory->time_3_min+ $inventory->time_3_med +$inventory->time_3_max)/3;
        // }
        // if($flight_no == 4)
        // {
            // $avg_time = ($inventory->time_4_min +$inventory->time_4_med +$inventory->time_4_max)/3;
        // }
        // if($flight_no == 5)
        // {
            // $avg_time = ($inventory->time_5_min +$inventory->time_5_med +$inventory->time_5_max)/3;
        // }
        // if($flight_no == 6)
        // {
            // $avg_time = ($inventory->time_6_min + $inventory->time_6_med +$inventory->time_6_max)/3;
        // }
        
        // // If Stairs type is windy helper take less time  
        // if($loc->stair_type == 'windy')
        // {
            // $avg_time = $avg_time + $inventory->stair_windy;
        // }
        
        // // If Stairs type is narrow helper take more time 
        // if($loc->stair_type == 'narrow')
        // {
            // $avg_time = $avg_time + $inventory->stair_narrow;
        // }
        
        // $avg_time = $avg_time + $item['ranking'];
        
        // return $avg_time;
    // }
    
    
    
    public function update_crew($booking_id, Request $request)
    {
        $update['crew_count'] = $request->crew;
        booking::where('booking_id',$booking_id)->update($update);
        return redirect()->to('booking/'.$booking_id);
        
        // $booking = booking::where('booking_id',$booking_id)->first();
        // //$booking_location = booking::get_booking_location($booking_id);
        
        // $join['booking_form_insurance_left'] = true;
        // $join['inventories'] = true;
        // $selected_items = booking::get_booking_items($booking_id,$join);
        
        // $accuracy = Accuracy::get();
        // $accuracy_value = 0;
        // foreach($accuracy as $accu)
        // {
        //     if($accu->id == $booking->accuracy)
        //     {
        //         $accuracy_value = $accu->value;
        //     }
        // }
        
        // $booking_form_truck = booking::get_booking_truck(array('booking_id'=>$booking_id))->get();        
        
        // $inventory_time = 0;
        // foreach($selected_items as $item)
        // {
        //      $inventory_time = $inventory_time + $item->pick_up_time + $item->drop_off_time;
        // }
        
        // $calender = Helper::GetCelender(date("Y"),true,true);
        
        // $selected_crew = $this->crew_assignment($booking);
        // $booking = $this->crew_availability($booking,$selected_crew,$calender);
        
        // //$selected_crew = $this->difficulty_level($booking,$selected_items,$booking_location);
        // // echo '<pre>';
        // // print_r($selected_crew);
        // // echo '</pre>';
        // // die;
        
        // $mileage_time = $booking_form_truck[0]->mileage;
        // $result = $this->calculate_charges($booking,$selected_items,$selected_crew,$mileage_time);
        // $booking = $result[0];
        // $charges = $result[1];
        
        // // echo '<pre>';
        // // print_r($charges);
        // // echo '</pre>';
        
        // $working_hours = 0;
        // if($booking->exist_hours == false)
        // {
        //     $working_hours = DB::table('working_hours')->get();    
        // }

        // $demands = DB::table('customer_demand')->get();
        
        // $accuracy = Accuracy::get();
        // $accuracy_value = 0;
        // foreach($accuracy as $accu)
        // {
        //     if($accu->id == $booking->accuracy)
        //     {
        //         $accuracy_value = $accu->value;
        //     }
        // }

        // return view('booking.summary.pricing_date_time',compact('booking','selected_crew','charges','working_hours', 'demands', 'accuracy_value'));
        
    }
    
    function GetHubTime($lat,$lng)
    {        
        //$start_point = '42.320605,-71.079494';        
        $hub = DB::table('hub_locations')->first();
        $start_point = $hub->lat.','.$hub->lng;

        $end_point = $lat .','. $lng;
        
        $origins = 'origins='.$start_point;
        $destination = 'destinations='.$end_point;
        
        $key = 'key=AIzaSyBIUaBvvlXdLIxkhAVVqQJC7jhSg98g7NE';
        
        $url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
        $url .= '&'.$origins.'&'.$destination.'&'.$key;
        
        //echo $url.'<br>'; die;
        // get the json response from url
        $resp = json_decode(file_get_contents($url), true);
        
        if(isset($resp['rows'][0]['elements'][0]['duration']['text']))
        {
            $dist_time = $resp['rows'][0]['elements'][0]['duration']['text'];
            $dist_time = explode(' ',$dist_time);
            return $dist_time[0];
        }
        
        return false;
    }
    
    public function update_insurance($booking_id,$amount)
    {
        Booking::where('booking_id',$booking_id)->update(array('insurance'=>$amount));
        
        $update['you_pay'] =  $amount;
        $where['booking_id'] = $booking_id;
        
        booking::update_insurance($update,$where);
        
        $booking = booking::where('booking_id',$booking_id)->first();
        
        return view('booking.summary.insurance_charges',compact('booking'));
    }
    
    public function update_item_insurance($booking_id,$booking_item_id,$amount)
    {
        $update['you_pay'] =  $amount;
        $where['booking_id'] = $booking_id;
        $where['booking_item_id'] = $booking_item_id;
        booking::update_insurance($update,$where);
    }
    
    public function calculate_charges($booking,$selected_items,$selected_crew,$mileage_time, $booking_location)
    {
        $fixed_add_time = DB::table('fixed_add_times')->sum('time');
        $total_fixed_time = $fixed_add_time;
        foreach ($booking_location as $loc) {
            if ($loc->parking == 7) {
                $fixed_time = 0;
            } else {
                $fixed_time = DB::table('fixed_times')->where(['id' => $loc->parking])->first()->time;
            }
            $total_fixed_time += $fixed_time;
        }

        echo '<pre>';
        echo "<span style='color: red'>Fixed time:  </span>";
        print_r($total_fixed_time);
        echo '</pre>';

        $rounded_fixed_time = $this->roundupToAny($total_fixed_time, 15) / 60;
        echo '<pre>';
        echo "<span style='color: red'>Rounded up Fixed time:  </span>";
        print_r($rounded_fixed_time);
        echo '</pre>';

        $walk_time = -30;
        foreach ($booking_location as $l) {
            if ($l->walk == 1) {
                $walk_time += ($l->walk_min * 60 + $l->walk_sec);
            }
        }
        if ($walk_time == -30) {
            $walk_time = 0;
        }

        $total_quantity = 0;
        foreach ($selected_items as $s) {
            $total_quantity += $s->quantity;
        }

        $walk_time_basic = ($walk_time / 3600) * $total_quantity / $selected_crew->crew_ratio * 2;

        // Get distance and time values for mobilization charge
        $mobi_data = DB::table('booking_form')->select('time_from_hub', 'time_to_hub', 'time_a_b', 'dis_from_hub', 'dis_to_hub', 'dis_a_b')->where([
            'booking_id' => $booking->booking_id
        ])->first();
        $hub = DB::table('hub_locations')->first();

        $distance_H_A = isset($mobi_data->dis_from_hub) ? $mobi_data->dis_from_hub : $this->get_directions_info($hub->lat, $hub->lng, $booking->s_lat, $booking->s_lng, 'distance');
        $time_H_A = isset($mobi_data->time_from_hub) ? $mobi_data->time_from_hub : $this->get_directions_info($hub->lat, $hub->lng, $booking->s_lat, $booking->s_lng, 'time');
        $distance_B_H = isset($mobi_data->dis_to_hub) ? $mobi_data->dis_to_hub : $this->get_directions_info($booking->d_lat, $booking->d_lng, $hub->lat, $hub->lng, 'distance');
        $time_B_H = isset($mobi_data->time_to_hub) ? $mobi_data->time_to_hub : $this->get_directions_info($booking->d_lat, $booking->d_lng, $hub->lat, $hub->lng, 'time');

        if (!isset($mobi_data->dis_a_b)) {
            $array = $booking_location->toArray();
            $out = array_splice($array, 1, 1);
            $length = count($array);
            $booking_location = array_replace($array, array($length => $out[0]));
    
            $distance_A_B = 0;
            $time_A_B = 0;
            foreach ($booking_location as $k => $l) {
                if (isset($booking_location[$k+1])) {
                    $distance = $this->get_directions_info($l->lat, $l->lng, $booking_location[$k+1]->lat, $booking_location[$k+1]->lng, 'distance');
                    $distance_A_B += $distance;
                    $time = $this->get_directions_info($l->lat, $l->lng, $booking_location[$k+1]->lat, $booking_location[$k+1]->lng, 'time');
                    $time_A_B += $time;
                    DB::table('booking_form_location')->where([
                        'booking_loc_id' => $booking_location[$k+1]->booking_loc_id,
                        'booking_id' => $booking->booking_id
                    ])->update([
                        'dis_from' => $distance,
                        'time_from' => $time,
                    ]);
                    echo "<pre>";
                    echo "<span style='color: red'>Distance " . $k . ":</span>  ";
                    print_r($distance);
                    echo "<span style='color: red'>Time " . $k . ":</span>  ";
                    print_r($time);
                    echo "</pre>";
                    echo "<br>";
                }
            }
        } else {
            $distance_A_B = $mobi_data->dis_a_b;
            $time_A_B = $mobi_data->time_a_b;
        }
        DB::table('booking_form')->where([
            'booking_id' => $booking->booking_id
        ])->update([
            'time_from_hub' => $time_H_A,
            'time_to_hub' => $time_B_H,
            'time_a_b' => $time_A_B,
            'dis_from_hub' => $distance_H_A,
            'dis_to_hub' => $distance_B_H,
            'dis_a_b' => $distance_A_B
        ]);

        // rounding up total distance
        $total_distance = $distance_H_A + $distance_A_B + $distance_B_H;
        $rounded_t_distance = 0;
        if ($total_distance <= 15) {
            $rounded_t_distance = 15;
        } else {
            $rounded_t_distance = $this->roundupToAny($total_distance, 5);
        }
        echo "<pre>";
        echo "<span style='color: red'>Rounded Up total Distance(miles):  </span>  ";
        print_r($rounded_t_distance);
        echo '</pre>';

        // round up time values for mob charges
        $mob_time = ($time_H_A + $time_B_H); // Unit is mins
        $rounded_mob_time = $this->roundupToAny($mob_time, 15) / 60;

        $rounded_trv_time = $this->roundupToAny($time_A_B, 15) / 60;
        echo "<pre>";
        echo "<span style='color: red'>Rounded Up time_H_A + time_B_H(hours):  </span>  ";
        print_r($rounded_mob_time);
        echo '</pre>';

        echo "<pre>";
        echo "<span style='color: red'>Rounded Up time_A_B(hours):  </span>  ";
        print_r($rounded_trv_time);
        echo '</pre>';

        // Get truck ID
        $truck_id = DB::table('booking_form_truck')->where([
            'booking_id' => $booking->booking_id
        ])->select('truck_id')->get()->first()->truck_id;

        $truck_data = Truck::where([
            'id' => $truck_id
        ])->select('*')->get()->first();

        if ($truck_data->name != 'PM-G-17-497 (Yellow)') {
            $charges['additional_charges'] = DB::table('vehicle_types')->where([
                'name' => $truck_data->type
            ])->first()->add_charges;
        }
        $num_worker = $booking->crew_count;

        // Additional time based on dis-assembly
        $additional_time = 0;
        foreach ($selected_items as $item) {
            if (isset($item->ranking)) {
                $alphabet = DB::table('ranking')->where([
                    'ranking_id' => $item->ranking
                ])->select('alphabet')->first()->alphabet;
                $inventory = json_decode(json_encode($item), true);
                $dis_assembly = $this->get_dis_assembly($inventory['item_id'], $num_worker, $alphabet);
                $additional_time += $dis_assembly * $inventory['quantity'];
            }
        }

        // Get time for unloading inventories for crew charge
        $booking_id = $booking->booking_id;

        $drop_off_location_info = DB::table('booking_form_items as i')->select('*')->join('inventories as ivn', 'ivn.id', '=', 'i.item_id')->join('booking_form_location as d_loc', 'i.drop_off_loc_id', '=', 'd_loc.booking_loc_id')->addSelect('ivn.ranking_id as inventory_ranking')->where('i.booking_id', $booking_id)->get();
        $i = 0;
        $total_drop_off_time = 0;
        foreach ($drop_off_location_info as $item) {
            $inventory = json_decode(json_encode($item), true);

            // Formula is (min_time + med_time + max_time) / 3 * quantity
            if ($inventory["stair_kind"] == "stairs") {
                $times = $this->get_flight_times($item->item_id, $num_worker, $item->flights, 1);
                $stair_factor = $this->get_stair_time_factor($item->item_id, $num_worker, $item->stair_type);
                if (!isset($times)) {
                    $drop_off_times[$i] = 0;
                } else {
                    $drop_off_times[$i] = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $item->quantity / 3;
                }
            } else if ($inventory["stair_kind"] == "elevator" || $inventory["stair_kind"] == "both") {
                $times = $this->get_elevator_times($item->item_id, $num_worker, $item->floor_num, 1);
                if (count($times) == 0) {
                    $drop_off_times[$i] = 0;
                } else {
                    if ($item->evelator_type == 'reserved_freight') {
                        $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                        $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                    } else {
                        $time = json_decode(json_encode($times), true)[0][$item->evelator_type . '_time'];
                        $delay = json_decode(json_encode($times), true)[0][$item->evelator_type . '_delay'];
                    }
                    $drop_off_times[$i] = ($time + $delay) * $inventory["quantity"];
                }
            } else if ($inventory["stair_kind"] == 'groundfloor') {
                $times = $this->get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$i] = 0;
                } else {
                    $drop_off_times[$i] = ($times->groundfloor_min + $times->groundfloor_med + $times->groundfloor_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'bulkhead') {
                $times = $this->get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$i] = 0;
                } else {
                    $drop_off_times[$i] = ($times->bulkhead_min + $times->bulkhead_med + $times->bulkhead_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'entrance') {
                $times = $this->get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 1);
                if (!isset($times)) {
                    $drop_off_times[$i] = 0;
                } else {
                    $drop_off_times[$i] = ($times->en_steps_min + $times->en_steps_med + $times->en_steps_max) * $item->quantity;
                }
            }
            DB::table('booking_form_items')->where([
                'booking_item_id' => $item->booking_item_id
            ])->update([
                'drop_off_time' => $drop_off_times[$i]
            ]);

            $total_drop_off_time += $drop_off_times[$i];
            $i++;
        }

        // Get time for loading inventories for crew charge
        
        $pick_up_location_info = DB::table('booking_form_items as i')->select('*')->join('inventories as ivn', 'ivn.id', '=', 'i.item_id')->join('booking_form_location as p_loc', 'i.pick_up_loc_id', '=', 'p_loc.booking_loc_id')->addSelect('ivn.ranking_id as inventory_ranking')->where('i.booking_id', $booking_id)->get();
        $i = 0;
        $total_pick_up_time = 0;
        foreach ($pick_up_location_info as $item) {
            $inventory = json_decode(json_encode($item), true);

            if ($inventory["stair_kind"] == "stairs") {
                $times = $this->get_flight_times($item->item_id, $num_worker, $item->flights, 0);
                $stair_factor = $this->get_stair_time_factor($item->item_id, $num_worker, $item->stair_type);
                if (!isset($times)) {
                    $pick_up_times[$i] = 0;
                } else {
                    $pick_up_times[$i] = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $item->quantity / 3;
                }
            } else if ($inventory["stair_kind"] == "elevator" || $inventory["stair_kind"] == "both") {
                $times = $this->get_elevator_times($item->item_id, $num_worker, $item->floor_num, 0);
                if (count($times) == 0) {
                    $pick_up_times[$i] = 0;
                } else {
                    if ($item->evelator_type == 'reserved_freight') {
                        $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                        $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                    } else {
                        $time = json_decode(json_encode($times), true)[0][$item->evelator_type . '_time'];
                        $delay = json_decode(json_encode($times), true)[0][$item->evelator_type . '_delay'];
                    }
                    $pick_up_times[$i] = ($time + $delay) * $inventory["quantity"];
                }
            } else if ($inventory["stair_kind"] == 'groundfloor') {
                $times = $this->get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$i] = 0;
                } else {
                    $pick_up_times[$i] = ($times->groundfloor_min + $times->groundfloor_med + $times->groundfloor_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'bulkhead') {
                $times = $this->get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$i] = 0;
                } else {
                    $pick_up_times[$i] = ($times->bulkhead_min + $times->bulkhead_med + $times->bulkhead_max) * $item->quantity;
                }
            } else if ($inventory["stair_kind"] == 'entrance') {
                $times = $this->get_bulkhead_times($item->item_id, $num_worker, $item->step_num, 0);
                if (!isset($times)) {
                    $pick_up_times[$i] = 0;
                } else {
                    $pick_up_times[$i] = ($times->en_steps_min + $times->en_steps_med + $times->en_steps_max) * $item->quantity;
                }
            }
            DB::table('booking_form_items')->where([
                'booking_item_id' => $item->booking_item_id
            ])->update([
                'pick_up_time' => $pick_up_times[$i]
            ]);

            $total_pick_up_time += $pick_up_times[$i];
            $i++;
        }

        // round up time values for loading and unloading time
        $rounded_crew_time = $this->roundupToAny($total_pick_up_time + $total_drop_off_time, 15) / 3600;
        echo "<pre>";
        echo "<span style='color: red'>Rounded Up loading + unloading time(hours):  </span>  ";
        print_r($rounded_crew_time);
        echo '</pre>';

        // Original Vehicle rate
        $org_vehicle_rate = DB::table('trucks')->where([
            'id' => $truck_id
        ])->first()->mileage;
        $charges['org_vehicle_mileage'] = $org_vehicle_rate;

        echo "<pre>";
        echo "<span style='color: red'>Original vehicle mileage : </span>  ";
        print_r($org_vehicle_rate);
        echo "</pre>";
        echo "<br>";

        $vehicle_data = DB::table('vehicle_demand_rate')->where([
            'vehicle_id' => $truck_id
        ])->select('*')->get();
        $charges['vehicle_data'] = $vehicle_data;

        if (!$booking->booking_date) {

            // Get vehicle hourly rate for mobilization charge
            $vehicle_rate = $org_vehicle_rate;

            // Get crew rates
            $single_rates = [];
            $total_crew_rate = 0;
            $crew_roles = explode(',', $selected_crew->roles);
            foreach ($crew_roles as $c) {
                $single_rates[$i] = DB::table('roles')->where([
                    'id' => $c
                ])->select('charging_customer')->first()->charging_customer;
                $total_crew_rate += $single_rates[$i];
                $i++;
            }

            // Mobilization charges
            // $charges['mob_H_A'] = ($distance_H_A * $vehicle_rate) + ($time_H_A * $total_crew_rate);
            // $charges['mob_B_H'] = ($distance_B_H * $vehicle_rate) + ($time_B_H * $total_crew_rate);

            $charges['mob_charges'] = $rounded_t_distance * $vehicle_rate + $rounded_mob_time * $total_crew_rate;

            // Crew charges
            $charges['total_crew_charge'] = ($rounded_trv_time + $rounded_crew_time + $additional_time / 60 + $walk_time_basic + $rounded_fixed_time) * $total_crew_rate;

            $charges['total_crew_time'] = $rounded_crew_time + $additional_time / 60 + $rounded_trv_time + $rounded_fixed_time;

            $charges['crew_hourly_rates'] = $single_rates;
            $charges['total_crew_rate'] = $total_crew_rate;
            // $charges['crew_charges_A_B'] = $distance_A_B * $vehicle_rate;
            $charges['walk_charge'] = $walk_time_basic * $total_crew_rate;

            $charges['total_charges'] = $charges['mob_charges'] + $charges['total_crew_charge'];

            // Basic info for charges in each date
            $charges['basic_crew_charges'] = ($rounded_mob_time + $rounded_trv_time + $rounded_crew_time + $additional_time / 60 + $walk_time_basic + $rounded_fixed_time) * $total_crew_rate;
            $charges['total_distance'] = $rounded_t_distance;

        } else {
            list($year, $month, $date) = explode('-', $booking->booking_date);
            $peak_factor = PeakFactor::where([
                'year' => $year,
                'month' => $month,
                'day' => $date
            ])->select('value')->get()->first();

            $demand = null;

            $demands = DB::table('customer_demand')->get();
            foreach ($demands as $d) {
                if (isset($peak_factor)) {
                    if ($peak_factor->value >= $d->min && $peak_factor->value <= $d->max) {
                        $demand = $d;
                        break;
                    }
                }
            }

            if ($demand != null) {
                $vehicle_data = DB::table('vehicle_demand_rate')->where([
                    'demand_id' => $demand->id,
                    'vehicle_id' => $truck_id
                ])->select('rate', 'reservation_fee')->first();
                $vehicle_rate = $vehicle_data->rate;
                $reservation_fee = $vehicle_data->reservation_fee;
            } else {
                $vehicle_rate = $org_vehicle_rate;
                $reservation_fee = 0;
            }

            $i = 0;
            $single_rates = [];
            $total_crew_rate = 0;
            $crew_roles = explode(',', $selected_crew->roles);
            foreach ($crew_roles as $c) {
                $single_rates[$i] = DB::table('roles')->where([
                    'id' => $c
                ])->select('charging_customer')->first()->charging_customer;
                $total_crew_rate += $single_rates[$i];
                $i++;
            }

            // Mobilization charges
            if (isset($peak_factor) && $peak_factor->value != '') {
                // $charges['mob_H_A'] = $time_H_A * ($total_crew_rate * $peak_factor->value) + $distance_H_A * $vehicle_rate;
                // $charges['mob_B_H'] = $time_B_H * ($total_crew_rate * $peak_factor->value) + $distance_B_H * $vehicle_rate;
                $charges['mob_charges'] = $rounded_t_distance * $vehicle_rate + $rounded_mob_time * ($total_crew_rate * $peak_factor->value);
                $charges['total_crew_charge'] = $total_crew_rate * $peak_factor->value * ($rounded_trv_time + $rounded_crew_time + $additional_time / 60 + $walk_time_basic + $rounded_fixed_time);
                $charges['total_crew_rate'] = $total_crew_rate * $peak_factor->value;
                $charges['walk_charge'] = $walk_time_basic * $total_crew_rate * $peak_factor->value;
            } else {
                // $charges['mob_H_A'] = $time_H_A * $total_crew_rate + $distance_H_A * $vehicle_rate;
                // $charges['mob_B_H'] = $time_B_H * $total_crew_rate + $distance_B_H * $vehicle_rate;
                $charges['mob_charges'] = $rounded_t_distance * $vehicle_rate + $rounded_mob_time * $total_crew_rate;
                $charges['total_crew_charge'] = ($rounded_trv_time + $rounded_crew_time + $additional_time / 60 + $walk_time_basic + $rounded_fixed_time) * $total_crew_rate;
                $charges['total_crew_rate'] = $total_crew_rate;
                $charges['walk_charge'] = $walk_time_basic * $total_crew_rate;
            }
            $charges['reservation_fee'] = $reservation_fee;

            // Crew charges
            $charges['total_crew_time'] = $rounded_crew_time + $additional_time / 60 + $rounded_trv_time + $rounded_fixed_time;

            $charges['crew_hourly_rates'] = $single_rates;
            // $charges['crew_charges_A_B'] = $distance_A_B * $vehicle_rate;

            $charges['total_charges'] = $charges['mob_charges'] + $charges['reservation_fee'] + $charges['total_crew_charge'];

            // Basic info for charges in each date
            $charges['basic_crew_charges'] = ($rounded_mob_time + $rounded_trv_time + $rounded_crew_time + $additional_time / 60 + $walk_time_basic + $rounded_fixed_time) * $total_crew_rate;
            $charges['total_distance'] = $rounded_t_distance;

            echo "<span style='color: red'>Truck mileage:</span>  ";
            print_r($vehicle_rate);
            echo "<br><br>";

            echo "<span style='color: red'>Reservation Fee:</span>  ";
            print_r($reservation_fee);
            echo "<br><br>";

            echo "<span style='color: red'>Peak factor:</span>  ";
            print_r((isset($peak_factor)) ? $peak_factor->value : null);
            echo "<br><br>";
    
        }

        echo "<pre>";
        echo "<span style='color: red'>Distance from Hub to A:</span>  ";
        print_r($distance_H_A);
        echo "<br>";
        echo "<span style='color: red'>Time from Hub to A:</span>  ";
        print_r($time_H_A);
        echo "<br>";
        echo "<span style='color: red'>Distance from B to Hub:</span>  ";
        print_r($distance_B_H);
        echo "<br>";
        echo "<span style='color: red'>time from B to Hub:</span>  ";
        print_r($time_B_H);
        echo "<br>";
        echo "<span style='color: red'>Distance from A to B:</span>  ";
        print_r($distance_A_B);
        echo "<br><br>";
        echo "<span style='color: red'>time from A to B:</span>  ";
        print_r($time_A_B);
        echo "<br><br>";

        echo "<span style='color: red'>Crew hourly rates:</span>  ";
        print_r($single_rates);
        echo "<br><br>";

        echo "<span style='color: red'>Total loading time:</span>  ";
        print_r($total_pick_up_time);
        echo "<br><br>";

        echo "<span style='color: red'>Dis-assembly:</span>  ";
        print_r($additional_time);
        echo "<br><br>";

        echo "<span style='color: red'>Truck id:</span>  ";
        print_r($truck_id);
        echo "<br><br>";

        echo "<span style='color: red'>Total unloading time:</span>  ";
        print_r($total_drop_off_time);
        echo "<br><br>";

        echo "<span style='color: red'>Difficulty level:</span>  ";
        print_r(Dlevel::select('dlevel')->where(['id' => $selected_crew->dlevel_id])->get()->toArray()[0]['dlevel']);
        echo "<br><br></pre>";
        $charges['difficulty_level'] = Dlevel::select('dlevel')->where(['id' => $selected_crew->dlevel_id])->get()->toArray()[0]['dlevel'];

        // End updated parts

        // $accuracy = Accuracy::get();
        // $accuracy_value = 0;
        // foreach($accuracy as $accu)
        // {
        //     if($accu->id == $booking->accuracy)
        //     {
        //         $accuracy_value = $accu->value;
        //     }
        // }
        
        // $inventory_time = 0;
        // foreach($selected_items as $item)
        // {
        //      $inventory_time = $inventory_time + $item->pick_up_time + $item->drop_off_time;
        // }
        
        
        // $year = date('Y');
        // $month = Intval(date('m'));
        // $day = Intval(date('d'));
        // $peakfactor = PeakFactor::where('year',$year)->where('month',$month)->where('day',$day)->first();
        
        // $peakfactor = 1;
        // if(isset($peakfactor->value) && !empty($peakfactor->value)){$peakfactor    = $peakfactor->value;}
        
        // $time_H_A = $booking->time_from_hub;
        // $time_A_B = $booking->minutes;
        // $time_B_H = $booking->time_to_hub;
        
        // // echo 'time_H_A : '.$time_H_A.'<br>';
        // // echo 'time_A_B : '.$time_A_B.'<br>';
        // // echo 'time_B_H : '.$time_B_H.'<br>';
        // // echo '<br>';
        // $travel_time = $booking->time_from_hub + $booking->minutes + $booking->time_to_hub;
        
        // // echo 'travel_time : '.$travel_time.'<br>';
        
        // $dvd_time_H_A = ($time_H_A / $travel_time);
        // $dvd_time_A_B = ($time_A_B / $travel_time);
        // $dvd_time_B_H = ($time_B_H / $travel_time);
        
        // $q = 15;
        // $loop = 1;
        
        // for($i=1; $i<=$loop; $i++)
        // {
        //     if($travel_time <= $q)
        //     {
                
        //         $add = $q - $travel_time;
        //         $travel_time = $travel_time + $add;
        //     }
        //     else
        //     {
        //         $q = $q + 15;
        //         $loop = $loop + 1;
        //     }
        // }
        
        // // echo 'travel_time : '.$travel_time.' (Round) <br><br>';
        
        // $charges['time_H_A']  = $time_H_A = $dvd_time_H_A * $travel_time;
        // $charges['time_A_B']  = $time_A_B = $dvd_time_A_B * $travel_time;
        // $charges['time_B_H']  = $time_B_H = $dvd_time_B_H * $travel_time;
        
        // // echo 'time_H_A : '.$time_H_A.' (Round)<br>';
        // // echo 'time_A_B : '.$time_A_B.' (Round)<br>';
        // // echo 'time_B_H : '.$time_B_H.' (Round)<br>';
        
        // //===============================================================
        // // Crew Charges:
        // //===============================================================
        // $crew_hourly_rate  = array();
        // $tot_crew_hourly_rate = 0;
        
        // if(isset($selected_crew->rate))
        // {
        //     $single_rate = explode(',',$selected_crew->rate);
            
        //     foreach($single_rate as $r=>$rate)
        //     {
        //         $crew_hourly_rate[] = ($inventory_time + $time_A_B) * ($rate / 60) * $peakfactor;
        //         $charges['tot_crew_hourly_rate'] = $tot_crew_hourly_rate = $tot_crew_hourly_rate + ( $inventory_time + $time_A_B) * ($rate / 60) * $peakfactor;
        //     }
        // }
        
        // // echo'<pre>';
        // // print_r($crew_hourly_rate);
        // // echo'</pre>';
        
        // $charges['crew_hourly_rate'] = $crew_hourly_rate;
        // $mileage_rate_A_B = ($time_A_B) * ($mileage_time / 60);
        
        // //===============================================================
        
        // //===============================================================
        // // Mobilization Charge:
        // //===============================================================
        
        // $mob_crew_rate = array();
        // $tot_mob_crew_rate = 0;
        // $charges['tot_mob_crew_rate'] = 0;
        // if(isset($single_rate))
        // {
        //     foreach($single_rate as $rate)
        //     {
        //         $mob_crew_rate[] = ( $time_H_A + $time_B_H ) * ($rate / 60) * $peakfactor;;
        //         $charges['tot_mob_crew_rate'] = $tot_mob_crew_rate = $tot_mob_crew_rate + ( $time_H_A + $time_B_H ) * ($rate / 60)  * $peakfactor;
        //     }
        // }
        
        // $charges['mob_crew_rate'] = $mob_crew_rate;
        // $mileage_rate_H_A = ($time_H_A) * ($mileage_time / 60);
        // $mileage_rate_B_H = ($time_B_H) * ($mileage_time / 60);
        
        // //===============================================================
        
        // // echo '<br>';echo '<br>';
        // // echo 'mileage_rate_A_B : '.$mileage_rate_A_B.'<br>';
        // // echo 'mileage_rate_H_A : '.$mileage_rate_H_A.'<br>';
        // // echo 'mileage_rate_B_H : '.$mileage_rate_B_H.'<br>';
        
        // // echo '<br>';
        // $total_mileage_rate = $mileage_rate_H_A + $mileage_rate_A_B + $mileage_rate_B_H;
        
        // $dvd_mileage_rate_H_A = ($mileage_rate_H_A / $total_mileage_rate);
        // $dvd_mileage_rate_A_B = ($mileage_rate_A_B / $total_mileage_rate);
        // $dvd_mileage_rate_B_H = ($mileage_rate_B_H / $total_mileage_rate);
        
        // // echo 'total_mileage_rate : '.$total_mileage_rate.'<br>';
        
        // $q = 5;
        // $loop = 1;
        
        // for($i=1; $i<=$loop; $i++)
        // {
        //     //echo $total_mileage_rate .'<'. $q .'<br>';
            
        //     if($total_mileage_rate < 15)
        //     {
        //         $total_mileage_rate = 15;
        //     }
            
        //     if($total_mileage_rate <= $q)
        //     {
        //         $add = $q - $total_mileage_rate;
        //         $total_mileage_rate = $total_mileage_rate + $add;
        //     }
        //     else
        //     {
        //         $q = $q + 5;
        //         $loop = $loop + 1;
        //     }
        // }
        
        // // echo 'total_mileage_rate : '.$total_mileage_rate.' (Round) <br>';
        
        // $charges['mileage_rate_H_A']  = $mileage_rate_H_A = $dvd_mileage_rate_H_A * $total_mileage_rate * $peakfactor;
        // $charges['mileage_rate_A_B']  = $mileage_rate_A_B = $dvd_mileage_rate_A_B * $total_mileage_rate * $peakfactor;
        // $charges['mileage_rate_B_H']  = $mileage_rate_B_H = $dvd_mileage_rate_B_H * $total_mileage_rate * $peakfactor;
        
        // // echo '<br>';
        
        // // echo 'mileage_rate_A_B : '.$mileage_rate_A_B.' (Round)<br>';
        // // echo 'mileage_rate_H_A : '.$mileage_rate_H_A.' (Round)<br>';
        // // echo 'mileage_rate_B_H : '.$mileage_rate_B_H.' (Round)<br>';
        // $hourly_time = 0;
        // $mileage_time = 0;
        // $booking->total_rate = 0;
        // if(isset($selected_crew->total_rate))
        // {            
        //     $charges['hourly_time']  = $hourly_time = (($inventory_time/$selected_crew->crew_ratio) + $travel_time) * ($selected_crew->total_rate / 60);            
        //     $charges['mileage_time'] = $mileage_time = (($inventory_time/$selected_crew->crew_ratio) + $travel_time) * ($mileage_time / 60);            
        // }
        
        // $booking->total_rate = $hourly_time + $mileage_time;
        
        
        // $booking->min = $booking->total_rate - $accuracy_value;
        // $booking->max = $booking->total_rate + $accuracy_value;
        
        // $we_pay = 0;
        // $you_pay = 0;
        
        // $insurance = Booking::get_booking_insurance($booking->booking_id);
        
        // foreach($insurance as $item)
        // {
        //     $charges['we_pay']  = $we_pay = $we_pay + $item->we_pay;
        //     $charges['you_pay'] = $you_pay = $you_pay + $item->you_pay;
        // }
        
        // $charges['total_charges'] = $tot_mob_crew_rate + $tot_crew_hourly_rate + $mileage_rate_A_B + $mileage_rate_H_A + $mileage_rate_B_H;
        // $charges['crew_charges'] = $tot_crew_hourly_rate + $mileage_rate_A_B;
        // $charges['mob_charges']  = $mileage_rate_H_A + $tot_mob_crew_rate + $mileage_rate_B_H;
        
        // echo '<pre>';
        // print_r($charges);
        // echo '</pre>';
        

        return array($booking,$charges);
        
    }
    
    // Return directions time or distance value with google maps api
    static function get_directions_info($origin_lat, $origin_lng, $des_lat, $des_lng, $info_type) {
        $key = Setting::get('map_key');
        $api_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
        $url = $api_url . '&origins=' . $origin_lat . ',' . $origin_lng . '&destinations=' . $des_lat . ',' . $des_lng . '&key=' . $key;
        $res = json_decode(file_get_contents($url), true);

        if ($info_type == 'time') {
            if (isset($res['rows'][0]['elements'][0]['duration']['value'])) {
                return $res['rows'][0]['elements'][0]['duration']['value'] / 3600;
            } else {
                return 0;
            }
        } else if ($info_type == 'distance') {
            if (isset($res['rows'][0]['elements'][0]['distance']['value'])) {
                return $res['rows'][0]['elements'][0]['distance']['value'] / 1609.34;
            } else {
                return 0;
            }
        }
    }

    // Return vehicle data for customer selection
    public function check_vehicle($v_type) {
        $vehicles = Truck::where(['type' => $v_type])->count();
        return $vehicles;
    }

    public function change_vehicle($booking_id, Request $request) {
        $validator = Validator::make($request->all(), [
            'vtype_name' => 'required',
        ]);
        
        if($validator->fails()) {
            session()->put("msg", 'Please Enter Complusory Information');
            return back()->withErrors($validator);
        } else {
            $booking = booking::where('booking_id', $booking_id)->first();
            $available_trucks = $this->get_truck_availability($booking);
            foreach ($available_trucks as $t) {
                if ($t->type == $request->vtype_name) {
                    DB::table('booking_form_truck')->where([
                        'booking_id' => $booking_id
                    ])->update([
                        'truck_id' => $t->id,
                        'truck_volume' => $t->volume,
                        'truck_name' => $t->name
                    ]);
                    DB::table('booking_form_items')->where([
                        'booking_id' => $booking_id,
                    ])->update([
                        'truck_id' => $t->id
                    ]);
                    VehicleSchedule::where([
                        'booking_id' => $booking_id
                    ])->update([
                        'truck_id' => $t->id
                    ]);
                    break;
                }
            }
            return redirect()->to('booking/' . $booking_id);
        }
    }

    // Get recommended workers number
    public function recommended_num($total_weight, $total_volume, $categories, $items) {
        $r_nums_data = DB::table('rworkers')->get();
        $nums_data = [];
        $factors = [];
        foreach ($r_nums_data as $data) {
            $factors[$data->id] = 0;
            $nums_data[$data->id] = $data->num_crews;
            if ($total_weight >= explode('-', $data->weight)[0] && $total_weight <= explode('-', $data->weight)[1]) {
                $factors[$data->id]++;
            }
            if ($total_volume >= explode('-', $data->volume)[0] && $total_volume <= explode('-', $data->volume)[1]) {
                $factors[$data->id]++;
            }
            $items_data = explode(',', $data->items);
            foreach ($items as $i) {
                if (in_array($i, $items_data)) {
                    $factors[$data->id]++;
                }
            }
        }

        $rec_nums = [];

        foreach ($factors as $k => $fac) {
            if ($fac == max($factors)) {
                array_push($rec_nums, $nums_data[$k]);
            }
        }
        return $rec_nums;
    }

    public function save_loc(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required'
        ]);
        
        if($validator->fails()) 
        {
            return 'input_error';
        }
        else {
            DB::table('booking_form_add_billing_loc')->insert([
                'booking_id' => $request->booking_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
                'apt' => (isset($request->apt)) ? $request->apt : null
            ]);
            return $request->zipcode . ' ' . $request->street . ' ' . $request->city . ' ' . $request->state . ' USA';
        }
    }

    function roundupToAny($n, $x = 5) {
        return (ceil($n) % $x === 0) ? ceil($n) : round(($n + $x / 2) / $x) * $x;
    }

    function get_dis_assembly($item_id, $num_worker, $alphabet) {
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

    function get_flight_times($item_id, $num_worker, $num_flights, $location_type) {
        $times = DB::table('inventory_time_flights')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
            'num_flights' => $num_flights,
            'location_type' => $location_type
        ])->first();
        return $times;
    }

    function get_stair_time_factor($item_id, $num_worker, $type) {
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

    function get_elevator_times($item_id, $num_worker, $num_floor, $location_type) {
        $times = DB::table('inventory_time_elevator')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
            'num_floor' => $num_floor,
            'location_type' => $location_type
        ])->get();
        return $times;
    }

    function get_bulkhead_times($item_id, $num_worker, $num_stairs, $location_type) {
        $times = DB::table('inventory_time_extra')->where([
            'item_id' => $item_id,
            'num_worker' => $num_worker,
            'num_stairs' => $num_stairs,
            'location_type' => $location_type
        ])->first();
        return $times;
    }

    static function get_crew_combination($dlevel, $crew_count) {
        $combinations = DB::table('crew_combination')->where('dlevel_id', $dlevel)->get();
        foreach($combinations as $combination) {
            if (count(explode(',', $combination->roles)) == $crew_count) {
                return $combination;
                break;
            }
        }
        return false;
    }
    public function item_moving_time($item,$action)
    {
        $flight_no = 0;
        $inventory = Inventory::where('id',$item['item_id'])->first();
        
        if($action == 'pick_up')
        {
            $loc = DB::table('booking_form_location')->where('booking_loc_id',$item['pick_up_loc_id'])->first();
        }
        if($action == 'drop_off')
        {
            $loc = DB::table('booking_form_location')->where('booking_loc_id',$item['drop_off_loc_id'])->first();
            $flight_no = $loc->flights;
        }
            
        // Get Total Number Of Stairs of Pick Or Drop location
        if($flight_no == 0)
        {
            $avg_time = ($inventory->time_0_min + $inventory->time_0_med + $inventory->time_0_max)/3;
        }
        if($flight_no == 1)
        {
            $avg_time = ($inventory->time_1_min + $inventory->time_1_med+ $inventory->time_1_max)/3;
        }
        if($flight_no == 2)
        {
            $avg_time = ($inventory->time_2_min +$inventory->time_2_med +$inventory->time_2_max)/3;
        }
        if($flight_no == 3)
        {
            $avg_time = ($inventory->time_3_min+ $inventory->time_3_med +$inventory->time_3_max)/3;
        }
        if($flight_no == 4)
        {
            $avg_time = ($inventory->time_4_min +$inventory->time_4_med +$inventory->time_4_max)/3;
        }
        if($flight_no == 5)
        {
            $avg_time = ($inventory->time_5_min +$inventory->time_5_med +$inventory->time_5_max)/3;
        }
        if($flight_no == 6)
        {
            $avg_time = ($inventory->time_6_min + $inventory->time_6_med +$inventory->time_6_max)/3;
        }
        
        // If Stairs type is windy helper take less time  
        if($loc->stair_type == 'windy')
        {
            $avg_time = $avg_time + $inventory->stair_windy;
        }
        
        // If Stairs type is narrow helper take more time 
        if($loc->stair_type == 'narrow')
        {
            $avg_time = $avg_time + $inventory->stair_narrow;
        }
        
        if (isset($item['ranking'])) {
            $avg_time = $avg_time + $item['ranking'];
        }
        
        return $avg_time;
    }

    public function show_chosen_preset($booking_id, Request $request) {
        $param['item_ids'] = json_decode($request->preset)->item_ids;
        $items = Inventory::SearchInventoryItems($param);
        $quantities = explode(',', json_decode($request->preset)->item_quantity);
        foreach (explode(',', json_decode($request->preset)->item_ids) as $k => $id) {
            foreach ($items as $item) {
                if ($item->id == $id) {
                    if (isset($quantities[$k])) {
                        $item->preset_quantity = ($quantities[$k] == '') ? 0 : $quantities[$k];
                    } else {
                        $item->preset_quantity = 0;
                    }
                }
            }
        }

        $selected_array = array();
        $selected_items = booking::get_booking_items($booking_id);
        foreach ($selected_items->toArray() as $item) {
            $selected_array[$item->item_id]['quantity'] = $item->quantity;
            $selected_array[$item->item_id]['booking_item_id'] = $item->booking_item_id;
        }

        $preset_show = true;
        $search = '';

        $booking = booking::where('booking_id',$booking_id)->first();
        $booking_location = booking::get_booking_location($booking_id);

        return view('booking.inventory.items', compact('items', 'selected_array', 'search', 'preset_show', 'booking', 'booking_location'));
    }

    public function show_searched_item($booking_id, Request $request) {
        $search = $param['item_search'] = $request->item_search;
        $items = Inventory::SearchInventoryItems($param);
        $preset_show = true;

        $selected_array = array();
        $selected_items = booking::get_booking_items($booking_id);
        foreach ($selected_items->toArray() as $item) {
            $selected_array[$item->item_id]['quantity'] = $item->quantity;
            $selected_array[$item->item_id]['booking_item_id'] = $item->booking_item_id;
        }

        $booking = booking::where('booking_id',$booking_id)->first();
        $booking_location = booking::get_booking_location($booking_id);

        return view('booking.inventory.items', compact('items', 'selected_array', 'search', 'preset_show', 'booking', 'booking_location'));
    }

    public function show_selected_items($booking_id) {
        $selected_array = array();
        $selected_items = booking::get_booking_items($booking_id);
        foreach ($selected_items->toArray() as $item) {
            $selected_array[$item->item_id]['quantity'] = $item->quantity;
            $selected_array[$item->item_id]['booking_item_id'] = $item->booking_item_id;
        }

        $item_ids = array();
        foreach($selected_items as $item) {
            $item_ids[] = $item->item_id;
        }
        $param['item_ids'] = implode(',', $item_ids);
        $items = Inventory::SearchInventoryItems($param);

        $booking = booking::where('booking_id',$booking_id)->first();
        $booking_location = booking::get_booking_location($booking_id);

        $preset_show = false;
        $search = '';

        return view('booking.inventory.items', compact('selected_array', 'search', 'preset_show', 'booking', 'booking_location', 'items'));
    }

    public function remove_item_preview($booking_id, Request $request) {
        booking::delete_item(array('booking_item_id'=>$request->booking_item_id));

        $booking = booking::where('booking_id', $booking_id)->first();
        $booking_location = booking::get_booking_location($booking_id);

        $join['booking_form_insurance_left'] = true;
        $join['inventories'] = true;
        $selected_items = booking::get_booking_items($booking_id, $join);

        $booking = $this->difficulty_level($booking, $selected_items, $booking_location);
        $selected_crew = $this->crew_assignment($booking);

        $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $booking_id)->get();
        $selected_crew = $this->crew_assignment($booking);
        $temp = $this->calculate_charges_shuffle($booking, $selected_items, $booking_location, $booking_dates, $selected_crew);
        // $charges = $temp[0];
        $storages = $temp[2];
        $pickup_prices = $temp[3];
        $dropoff_prices = $temp[4];
        $item_names = $temp[5];

        // $insurance_price = $request->insurance_price;

        // $result = array();
        // $result['total_price'] = $charges['zones'] + $charges['storage'] + $charges['items'] + $charges['parking_fees'] + $charges['dis_assem_fees'] + $charges['long_walk_fees'] + $charges['curbside_fees'] + $insurance_price;

        // $result['view'] = view('booking.summary.price_shuffle', compact('charges', 'storages', 'pickup_prices', 'dropoff_prices', 'item_names', 'insurance_price'));

        // return $result;
    }

    public function update_qty_item_preview($booking_id, Request $request) {
        $current_qty = DB::table('booking_form_items')->where('booking_item_id', $request->booking_item_id)->first()->quantity;
        if ($request->type == '-') {
            DB::table('booking_form_items')->where('booking_item_id', $request->booking_item_id)->update(array('quantity' => $current_qty - 1));
        } elseif ($request->type == '+') {
            DB::table('booking_form_items')->where('booking_item_id', $request->booking_item_id)->update(array('quantity' => $current_qty + 1));
        }
        return 'success';
    }
}
