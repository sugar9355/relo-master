<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\HomeController;
use App\Booking;
use App\Dlevel;
use App\Role;
use App\InsuranceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\Helper;

class BookingDateController extends HomeController
{
    public function save_date($booking_id, $date, Request $request)
    {
        $time['booking_date']      = $date;
        $time['flexible'] = $request->flexible;
        booking::where('booking_id',$booking_id)->update($time);
        
        $booking = booking::where('booking_id',$booking_id)->first();
        // return redirect()->to('booking/'.$booking_id);
        
        // $join['booking_form_insurance_left'] = true;
        // $join['inventories'] = true;
        // $selected_items = booking::get_booking_items($booking_id,$join);
        
        // $accuracy = Accuracy::get();
        // $accuracy_value = 0;
        // foreach($accuracy as $accu)
        // {
            // if($accu->id == $booking->accuracy)
            // {
                // $accuracy_value = $accu->value;
            // }
        // }
        
        //$booking_form_truck = booking::get_booking_truck(array('booking_id'=>$booking_id))->get();        
        
        // $inventory_time = 0;
        // foreach($selected_items as $item)
        // {
             // $inventory_time = $inventory_time + $item->pick_up_time + $item->drop_off_time;
        // }
        
        $calender = Helper::GetCelender(date("Y"),true,true);
        
        $selected_crew = $this->crew_assignment($booking);
        $booking = $this->crew_availability($booking,$selected_crew,$calender);
        
        //$mileage_time = $booking_form_truck[0]->mileage;
        // $result = $this->calculate_charges($booking,$selected_items,$selected_crew,$mileage_time);
        // $booking = $result[0];
        // $charges = $result[1];
        
        $working_hours = 0;
        if($booking->exist_hours == false)
        {
            $working_hours = DB::table('working_hours')->get();    
        }
        
        // print_r($selected_crew);
        // exit;
        return 'success';
        // return view('booking.summary.date_time',compact('booking','selected_crew','working_hours'));
    }

    public function save_shuffle_date($booking_id, $date, $type, Request $request) {
        DB::table('booking_form_shuffle')->where([
            'booking_id' => $booking_id,
            'type' => $request->type
        ])->delete();

        DB::table('booking_form_shuffle')->insert([
            'booking_id' => $booking_id,
            'type' => $request->type,
            'date' => $request->date
        ]);

        $booking = array();
        
        $booking = booking::where('booking_id',$booking_id)->first();
        $booking_location = booking::get_booking_location($booking_id);

        $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $booking_id)->get();

        $selected_items = booking::get_booking_items($booking_id);
        $join['booking_form_insurance_left'] = true;
        $join['inventories'] = true;
        $selected_items = booking::get_booking_items($booking_id,$join);

        // $charges = $this->calculate_charges_shuffle($booking, $selected_items, $booking_location, $booking_dates);
        // $total_charge = 0;
        // foreach ($charges as $key => $charge) {
        //     if ($key != 'shuffle_price' && $key != 'peak_factor' && $key != 'pickup_items' && $key != 'dropoff_items')
        //         $total_charge += $charge;
        // }
        // $total_charge = number_format($total_charge, 2);

        $pickup_date ='';
        $dropoff_date ='';
        if(count($booking_dates) > 0) {
            foreach ($booking_dates as $b_data) {
                if ($b_data->type == 0) {
                    $pickup_date = $b_data->date;
                }
                if ($b_data->type == 1) {
                    $dropoff_date = $b_data->date;
                }
            }
        }

        $count = count($booking_dates);

        return json_encode([
            // 'total_charge' => $total_charge,
            'pickup_date' => $pickup_date,
            'dropoff_date' => $dropoff_date,
            'count' => $count
        ]);

    }

    public function save_shuffle_date_time($booking_id, Request $request) {
        // get insurance price part
        $temp = DB::table('booking_form_insurance')->where('booking_id', $booking_id)->get()->toArray();
        if (empty($temp)) {
            $insurance_price = InsuranceCategory::where('name', 'Recommended')->first()->you_pay;
        } else {
            $insurance_id = $temp[0]['insurance_id'];
            $insurance_price = InsuranceCategory::where('id', $insurance_id)->first()->you_pay;
            foreach ($temp as $ins) {
                $insurance_price += $ins['you_pay'];
            }
        }

        $temp = DB::table('booking_form_shuffle')->where([
            'booking_id' => $booking_id,
            'type' => $request->type
        ])->get();

        if (count($temp) > 0) {
            DB::table('booking_form_shuffle')->where([
                'booking_id' => $booking_id,
                'type' => $request->type
            ])->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date
            ]);
        } else {
            DB::table('booking_form_shuffle')->insert([
                'booking_id' => $booking_id,
                'type' => $request->type,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date' => $request->date
            ]);
        }
        $booking = array();
        
        $booking = booking::where('booking_id',$booking_id)->first();
        $booking_location = booking::get_booking_location($booking_id);

        $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $booking_id)->get();

        $selected_items = booking::get_booking_items($booking_id);
        $join['booking_form_insurance_left'] = true;
        $join['inventories'] = true;
        $selected_items = booking::get_booking_items($booking_id,$join);

        $pickup_date ='';
        $dropoff_date ='';
        if(count($booking_dates) > 0) {
            foreach ($booking_dates as $b_data) {
                if ($b_data->type == 0) {
                    $pickup_date = $b_data->date;
                }
                if ($b_data->type == 1) {
                    $dropoff_date = $b_data->date;
                }
            }
        }

        $count = count($booking_dates);

        return json_encode([
            // 'total_charge' => $total_charge,
            'insurance_price' => $insurance_price,
            'pickup_date' => $pickup_date,
            'dropoff_date' => $dropoff_date,
            'count' => $count
        ]);

    }
    
    public function save_time($booking_id,$start,$end)
    {
        
        $booking = booking::where('booking_id',$booking_id)->select('booking_date','minutes','over_all_minutes')->first();
        
        $time['start_time']      = $start;
        $time['end_time']      = $end;
        
        // if(!empty($booking->over_all_minutes))
        // {
            // $end_time = date('g:i A', strtotime("+{$booking->over_all_minutes} minutes", strtotime($start)));
            // $time['end_time'] = $end_time;
        // }
        // elseif(!empty($booking->minutes))
        // {
            // $end_time = date('g:i A', strtotime("+{$booking->minutes} minutes", strtotime($start)));
            // $time['end_time'] = $end_time;
        // }
        
        booking::where('booking_id',$booking_id)->update($time);
    }

    public function save_recommended_date($booking_id, Request $request) {
        // Get the last booking's data
        $latest_booking = booking::latest('booking_id')->where([
            ['booking_id', '!=', $booking_id],
            ['step', '=', '0']
        ])->first();

        // Get truck info of similar booking
        $truck = DB::table('booking_form_truck')->where('booking_id', $latest_booking->booking_id)->first();

        $time = [
            'booking_date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ];
        booking::where('booking_id', $booking_id)->update($time);
        DB::table('booking_form_truck')->where('booking_id', $booking_id)->update([
            'truck_id' => $truck->truck_id,
            'truck_volume' => $truck->truck_volume,
            'truck_name' => $truck->truck_name,
            'volume' => $truck->volume,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return 'success';
    }
}
