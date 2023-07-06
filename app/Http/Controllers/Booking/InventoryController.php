<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\HomeController;
use App\Category;
use App\Inventory;
use App\Question;
use App\Truck;
use App\Preset;
use App\VehicleSchedule;
use App\Booking;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class InventoryController extends HomeController
{

    public function add_preset(Request $request, $booking_id) {
        // dd($request->all());
        $agent = new Agent();
        foreach ($request->item_id as $id) {
            DB::beginTransaction();
            $booking_truck = booking::get_booking_truck(array('booking_id' => $booking_id, 'status' => 1))->first();
            $inventory = Inventory::where(array('id' => $id))->first();
            $data['item_id'] = $inventory->id;
            $data['truck_id'] = $booking_truck->truck_id;
            $data['item_name'] = $inventory->name;
            $data['item_image'] = isset($inventory->item_image) ? $inventory->item_image : 0;
            $data['file_path'] = $inventory->file_path;
            $data['quantity'] = $request->quantity[$id];
            $data['breadth'] = $inventory->breadth;
            $data['height'] = $inventory->height;
            $data['width'] = $inventory->width;
            $data['volume'] = $inventory->width * $inventory->height * $inventory->breadth;
            $data['weight'] = $inventory->weight;
            $data['similar'] = $inventory->similar;

            if(isset($request->ranking[$id]) && !empty($request->ranking[$id]))
            {
                $data['ranking'] = $request->ranking[$id];
            }
            else
            {
                $data['ranking'] = null;
            }

            $data['pick_up_loc_id']  = $request->pick_up_loc_id[$id];
            $data['drop_off_loc_id'] = $request->drop_off_loc_id[$id];
            $data['booking_id']      = $booking_id;
            $data['created_at']      = now();
            $data['updated_at']      = now();
            $booking_item_id = booking::save_item($data);

            $update_item['pick_up_time']  = $this->item_moving_time($data, 'pick_up');
            $update_item['drop_off_time'] = $this->item_moving_time($data, 'drop_off');
            $where['booking_item_id'] = $booking_item_id;
            $booking_item_id = booking::update_item($update_item, $where);

            if(isset($request->answer[$id]))
            {
                foreach($request->answer[$id] as $q_id => $val)
                {
                    $item_answer['booking_id'] = $booking_id;
                    $item_answer['item_id'] = $id;
                    $item_answer['question_id'] = $q_id;
                    $item_answer['answer'] = $val;
                    booking::save_answer($item_answer);
                }
            }
            
            if ($request->hasFile('picture') && !empty($booking_item_id))
            {
                $this->upload_picture($request, $booking_id, $booking_item_id);
            }    
    
            $truck_schedule = VehicleSchedule::where('booking_id', $booking_id)->where('truck_id', $data['truck_id'])->first();
            
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
                    VehicleSchedule::where('truck_id', $data['truck_id'])->update($vehicle_sch);
                }
            }

            DB::commit();
        }
        if($agent->isMobile()){

        return $this->mob_get_selected_items($booking_id);
        }
        else{
          return $this->get_selected_items($booking_id);  
        }
        
    }

    public function add_item(Request $request, $booking_id)
    {
        $agent = new Agent();
        DB::beginTransaction();
        
        $booking_truck = booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();
        
        $inventory = Inventory::where(array('id'=>$request->item_id))->first();
        
        $data['item_id']         = $inventory->id;
        $data['truck_id']         = $booking_truck->truck_id;
        $data['item_name']         = $inventory->name;
        $data['item_image']      = isset($inventory->item_image) ? $inventory->item_image : 0;
        $data['file_path']          = $inventory->file_path;
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
        
        
        $data['pick_up_loc_id']  = $request->pick_up_loc_id;
        $data['drop_off_loc_id'] = $request->drop_off_loc_id;
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
        
        if ($request->hasFile('picture') && !empty($booking_item_id)) 
        {
            $this->upload_picture($request,$booking_id,$booking_item_id);
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
        
        return $this->get_selected_items($booking_id);

    }
    
    public function get_selected_items($booking_id)
    {
        $agent = new Agent();
        $booking = booking::where('booking_id',$booking_id)->first();
        
        $items = Inventory::all();
                    foreach($items as $itm)
                    {
                        $item_ids[] = $itm->id;
                    }
        $booking_location = booking::get_booking_location($booking_id);
        $selected_items = booking::get_booking_items($booking_id);
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
        
        $item_images = booking::get_item_images(array('booking_id'=>$booking_id))->get();

        $question = Question::whereIn('item_id',$item_ids)->get();
        
        $presets = Preset::orderBy('created_at', 'desc')->get();
        $equipments = Inventory::GetInventoryEquipment();
        $categories = Category::orderBy('created_at', 'desc')->get();
        
        $booking_truck_exist = booking::get_booking_truck(array('booking_id'=>$booking_id))->count();
        
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

        $v_types = DB::table('vehicle_types')->select('*')->get()->toArray();

        if($agent->isMobile()){

         return view('booking.inventory.mob_selected_items', compact('booking','booking_location','booking_form_truck','items','item_images','selected_items','selected_item_answers','question','ranking','categories', 'v_types'));
        }
        else{
           return view('booking.inventory.selected_items', compact('booking','booking_location','booking_form_truck','items','item_images','selected_items','selected_item_answers','question','ranking','categories', 'v_types'));
        }
        
       
    }    
    
    public function item_moving_time($item,$action)
    {
        
        $inventory = Inventory::where('id',$item['item_id'])->first();
        
        if($action == 'pick_up')
        {
            $loc = DB::table('booking_form_location')->where('booking_loc_id',$item['pick_up_loc_id'])->first();
        }
        if($action == 'drop_off')
        {
            $loc = DB::table('booking_form_location')->where('booking_loc_id',$item['drop_off_loc_id'])->first();
        }
            
        // Get Total Number Of Stairs of Pick Or Drop location
        $flight_no = $loc->flights;
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
    
    public function delete_item($booking_id,$booking_item_id) // Delete Items
    {
        $agent = new Agent();
        booking::delete_item(array('booking_item_id'=>$booking_item_id));
        if($agent->isMobile()){
            return $this->mob_get_selected_items($booking_id);
        }else{
            return $this->get_selected_items($booking_id);  
        }
        
    }
    
    public function update_item_info($booking_id, Request $request) {
        DB::table('booking_form_items')->where([
            'booking_item_id' => $request->booking_item_id,
        ])->update([
            'quantity' => isset($request->quantity) ? $request->quantity : 1,
            'breadth' => isset($request->breadth) ? $request->breadth : 1,
            'height' => isset($request->height) ? $request->height : 1,
            'width' => isset($request->width) ? $request->width : 1,
            'weight' => isset($request->weight) ? $request->weight : 1,
        ]);

        $agent = new Agent();
        if($agent->isMobile()) {
            return $this->mob_get_selected_items($booking_id);
        }else{
            return $this->get_selected_items($booking_id);
        }
    }

    public function quantity(Request $request,$booking_id)
    {
        if(isset($request->action) && $request->action == "+")
        { 
            if($request->quantity > 0)
            {
                $update_item['quantity']  = $request->quantity + 1;
                $where['booking_item_id'] = $request->booking_item_id;
                $booking_item_id = booking::update_item($update_item,$where);
            }
        }
        elseif(isset($request->action) && $request->action == "-")
        { 
            if($request->quantity > 1)
            {
                $update_item['quantity']  = $request->quantity - 1;
                $where['booking_item_id'] = $request->booking_item_id;
                $booking_item_id = booking::update_item($update_item,$where);
            }
        }
        
        return $this->get_selected_items($booking_id);
        
    }
    
    
    public function packaging(Request $request,$booking_id)
    {
        echo $booking_id;
        return;
        if(isset($request->booking_id) && isset($request->booking_item_id))
        {
        
            if(isset($request->packaging))
            {
                $update_items['pakaging'] = 1;
                $where_items['booking_item_id'] = $request->booking_item_id;
                $where_items['booking_id'] = $request->booking_id;
                booking::update_item($update_items,$where_items);
            }
            if(isset($request->junkremoval))
            {
                $update_items['junk_removal'] = 1;
                $where_items['booking_item_id'] = $request->booking_item_id;
                $where_items['booking_id'] = $request->booking_id;
                booking::update_item($update_items,$where_items);
            }
        }
        
    }
    
    public function accuracy(Request $request, $booking_id)
    {
        $data = array();
        $where = array();
        $step_update = array();
        $data['accuracy'] = $request->accuracy;
        $where['booking_id'] = $booking_id;
        DB::beginTransaction();
        booking::update_accuracy($data, $where);

        $step_update['step'] = 6;
        booking::where('booking_id', $booking_id)->update($step_update);
        DB::commit();

        return redirect()->to('booking/'.$booking_id.'/6');
    }


     public function mob_get_selected_items($booking_id)
    {   
        $agent = new Agent();
        $booking = booking::where('booking_id',$booking_id)->first();
        
        $items = Inventory::all();
                    foreach($items as $itm)
                    {
                        $item_ids[] = $itm->id;
                    }
        $booking_location = booking::get_booking_location($booking_id);
        $selected_items = booking::get_booking_items($booking_id);
        
        $booking_item_answers = booking::get_booking_item_answers($booking_id);

        $selected_item_answers = array();
        foreach($booking_item_answers as $answers)
        {
            $selected_item_answers[$answers->question_id] = $answers;
        }
        

        // Get Ranking
        $ranking = Inventory::GetRanking();
        
        $item_images = booking::get_item_images(array('booking_id'=>$booking_id))->get();

        $question = Question::whereIn('item_id',$item_ids)->get();
        
        $presets = Preset::orderBy('created_at', 'desc')->get();
        $equipments = Inventory::GetInventoryEquipment();
        $categories = Category::orderBy('created_at', 'desc')->get();
        
        $booking_truck_exist = booking::get_booking_truck(array('booking_id'=>$booking_id))->count();
        
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

        $v_types = DB::table('vehicle_types')->select('*')->get()->toArray();
        if($agent->isMobile()){
return view('booking.inventory.mob_selected_items', compact('booking','booking_location','booking_form_truck','items','item_images','selected_items','selected_item_answers','question','ranking','categories', 'v_types'));
        }else{
          return view('booking.inventory.selected_items', compact('booking','booking_location','booking_form_truck','items','item_images','selected_items','selected_item_answers','question','ranking','categories', 'v_types'));  
        }
        
    } 
    
}
