<?php

namespace App\Http\Controllers;

use DB;
use Aloha\Twilio\Twilio;
use App\EmailLog;
use App\Helpers\Helper;
use App\Inventory;
use App\Truck;
use App\MessageLog;
use App\Notifications\BookingConfirmed;
use App\Notifications\CustomEmailNotification;
use App\PercentageSetting;
use App\Service;
use App\User;
use App\UserMovingRequest;
use App\UserMovingRequestItem;
use App\Location;
use App\Booking;
use App\Designation;
use App\Question;
use App\VehicleSchedule;
use App\VehicleType;
use App\ZoneType;
use Exception;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Setting;

class UserRequestController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('moving_request')){
            return abort(404);
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $status = request()->get('status');
		
        //$requests = UserMovingRequest::with('userMovingRequestItems', 'User')->get();
		
		$requests = Booking::where('step',0)->get();
		
		
		
        // if ($status == 'ASSIGNED' || $status == 'UNASSIGNED' || $status == 'COMPLETED' || $status == 'Pending' || $status == 'SAVE') 
		// {
            // $requests = UserMovingRequest::with('userMovingRequestItems', 'User')->where('status', '=', $status)->get();
        // }
		
        return view('admin.movingRequest.index', compact('requests'));
    }
    
    public function sendMessage(Request $request)
    {
        $number = $request->get("mobile");
        if (Str::startsWith($number, 0)) {
            $number = substr($number, 1);
        }
        $number = "+1" . $number;
        $message = $request->get("message");
        $accountId = 'ACc5886f183282fbcace065280d142130f';
        $token = '7f03c89f925819851bdf5873e99b3b29';
        $fromNumber = '+16176558341';
        $twilio = new Twilio($accountId, $token, $fromNumber);
        $twilio->message($number, $message);
        try {
            $messageLog = new MessageLog($request->all());
            $messageLog->save();
            return response()->json([], 200);
        } catch (Exception $exception) {
            return response()->json([], 500);
        }
    }
    
    public function sendEmail(Request $request)
    {
        $attachments = [];
        $images = $request->file('image');
        foreach ($images as $image) {
            $attachments[$image->getPathname()] = [
                "as"   => $image->getClientOriginalName(),
                "mime" => $image->getClientMimeType(),
            ];
        }
        
        $user = new User();
        $user->email = $request->get('email');
        $user->notify(new CustomEmailNotification($request->get('message'), $attachments));
        
        try {
            $emailLog = new EmailLog($request->all());
            $emailLog->save();
            return response()->json([], 200);
        } catch (Exception $exception) {
            return response()->json([], 500);
        }
    }
    
    public function messageLog()
    {
        if (!Helper::authorized('message_log')){
            return abort(404);
        }
        
        $logs = MessageLog::orderBy('id', 'desc')->get();
        return view('admin.logs.message', compact('logs'));
    }
    
    public function emailLog()
    {
        if (!Helper::authorized('email_log')){
            return abort(404);
        }
        
        $logs = EmailLog::orderBy('id', 'desc')->get();
        return view('admin.logs.email', compact('logs'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    
    public function show($booking_id)
    {
		
		$booking = booking::get_booking_form($booking_id);
		$location = booking::get_booking_location($booking_id);
		$items = booking::get_inventory_booking_items($booking_id);
		
		
		
		$services = Service::all();
		$inventory = Inventory::all();
		
		
		// Get Ranking
		$ranking = array();
		$ranking_obj = Inventory::GetRanking();
		foreach($ranking_obj as $r_k=>$r_v){$ranking[$r_v->ranking_id] = $r_v;}
		
		$equipments = Inventory::GetInventoryEquipment();
		
		$user = User::where('id',$booking->user_id)->first();
		
		if(isset($items[0]))
		{
			foreach($items as $itm)
			{
				$item_ids[] = $itm->booking_item_id;
			}
			
			$question = Question::whereIn('item_id',$item_ids)->get();
			$answers = booking::get_booking_item_answers($booking_id);
		}
		
		$insurance = booking::get_booking_insurance($booking_id);
		
		foreach($location as $loc)
		{
			$flight[] =  $loc->flights;
			$stair_type[] =  $loc->stair_type;
		}
		
		$result = $this->GetInventoryItems($items,$location,$ranking,$flight,$stair_type);
		
		$total_time = $result[0];
		$ranking = $result[1];
		//$location = $result[2];
		$total_volume = $result[3];
		$total_weight = $result[4];
		$stair_time = $result[5];
		$MovingItems = $result[6];
		
		$item_load_time = $this->GetInventoryLoadTime($items,$location,$ranking,$flight,$stair_type,0);
		$item_Unload_time = $this->GetInventoryLoadTime($items,$location,$ranking,$flight,$stair_type,1);
		
		
		$captains = $this->CheckForBadges($booking_id,$insurance);
		
        return view('admin.movingRequest.show', compact('captains','user','services','booking','location','inventory','equipments','items','question','answers','ranking','insurance','total_time','item_load_time','item_Unload_time'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    
    public function edit($id)
    {
		
		$request = UserMovingRequest::with('userMovingRequestItems', 'locations', 'User', 'insuranceDetails')->findOrFail($id);
		$UserMovingRequestItems = UserMovingRequestItem::where('user_moving_request_id',$id)->get();
			
		foreach($UserMovingRequestItems as $ite)
		{
			$items[] = $ite->name;
		}
		
		$inventory_items = Inventory::whereIn('name',$items)->get(); 
		$location = Location::where('user_moving_request_id',$id)->get();
		
		// Get Ranking
		$ranking = Inventory::GetRanking();
		
		foreach($location as $loc)
		{
			$flight[] =  explode('to',$loc->flight)[1];
			$stair_type[] =  $loc->stair_type;
		}
		
		$result = $this->GetInventoryItems($UserMovingRequestItems,$inventory_items,$location,$ranking,$flight,$stair_type);
		$item_load_time = $this->GetInventoryLoadTime($UserMovingRequestItems,$inventory_items,$location,$ranking,$flight,$stair_type,0);
		$item_Unload_time = $this->GetInventoryLoadTime($UserMovingRequestItems,$inventory_items,$location,$ranking,$flight,$stair_type,1);
		
		
		
		$total_time = $result[0];
		$inventory_items = $result[1];
		$ranking = $result[2];
		$location = $result[3];
		$total_volume = $result[4];
		$total_weight = $result[5];
		$stair_time = $result[6];
		$MovingItems = $result[7];
		//$stair_time = $result[10];
		
        $zoneTypes = ZoneType::all();
        $vehicleSchedules = VehicleSchedule::all();
        $vehicleTypes = VehicleType::all();
        $request = UserMovingRequest::with('userMovingRequestItems', 'User', 'locations')->findOrFail($id);
		
		if(isset($request->truck_id))
		{
			$assigned_truck = Truck::where('id',$request->truck_id)->first();
		}
		
		$items = array();
		foreach($request->userMovingRequestItems as $item)
		{
			$items[] = $item->name;
		}
		
		$items = Inventory::whereIn('name',$items)->get();
		
		if(!empty($items))
		{
			$sum_volume = 0;
			foreach($items as $val)
			{
				$sum_volume = $sum_volume + $val->volume;
			}
		}
		
		$skip_loc = array('id','user_moving_request_id','stair_typ','updated_at');
		
		//dd($request->getOriginal());
		
        return view('admin.movingRequest.edit', compact('MovingItems','request', 'zoneTypes', 'vehicleSchedules', 'vehicleTypes','sum_volume','assigned_truck','total_time','inventory_items','ranking','location','total_volume','total_weight','stair_time','ranking_time','total','skip_loc','item_load_time','item_Unload_time'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    
    public function editOrder($id)
    {
        $serviceTypes = Service::all();
        $items = Inventory::all();
        $request = UserMovingRequest::with('userMovingRequestItems.item.questions.answers', 'User', 'locations')->findOrFail($id);
        $locations = null;
        $locations[] = $request->s_address;
        $locations = array_merge($locations, json_decode($request->waypoints, true));
        $locations[] = $request->d_address;
        $locations = json_encode($locations);
        return view('admin.movingRequest.edit_order', compact('request', 'serviceTypes', 'items', 'locations'));
    }
    
    public function getItemById($id)
    {
        $item = Inventory::with('questions.answers')->find($id);
        return response()->json($item, 200);
    }
    
    public function getEventsCount(Request $request)
    {
        $userMovingRequests = UserMovingRequest::with('userMovingRequestItems', 'User')
            ->where("status", "=", "ASSIGNED")
            ->whereBetween('booking_date', $request->only('start', 'end'))
            ->orderBy("time", "ASC")
            ->get();
        
        $data = [];
        $date = null;
        $i = 0;
        $counts = [];
        foreach ($userMovingRequests as $bookingDate) {
            
            if ($date != $bookingDate->booking_date) {
                $counts[$bookingDate->booking_date] = 0;
                $date = $bookingDate->booking_date;
            }
            
            $counts[$bookingDate->booking_date] += 1;
        }
        $date = null;
        foreach ($userMovingRequests as $index => $userMovingRequest) {
            if ($date != $userMovingRequest->booking_date) {
                $data[$index + $i]['name'] = "count";
                $data[$index + $i]['title'] = "<h5>Assigned " . $counts[$userMovingRequest->booking_date] . " </h5>";
                $data[$index + $i]['start'] = $userMovingRequest->booking_date;
                $date = $userMovingRequest->booking_date;
                $i++;
            }
            $name = $userMovingRequest->user->first_name . ' ' . $userMovingRequest->user->last_name;
            $data[$index + $i]['name'] = $name;
            $data[$index + $i]['title'] = $userMovingRequest->time;
            $data[$index + $i]['start'] = $userMovingRequest->booking_date;
        }
        
        return response()->json($data, 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateOrder(Request $request, $id)
    {
        /*$serviceType = $request->get('serviceType');
        
        UserMovingRequest::find($id)->update([
            'serviceType' => $serviceType
        ]);*/
        
        UserMovingRequestItem::where('user_moving_request_id', '=', $id)->delete();
        $items = $request->get('item');
        
        foreach ($items as $itemIndex => $item) {
            $questions = Inventory::with('questions')->where('name', '=', $item)->first()->questions;
            $answerArray = [];
            
            foreach ($questions as $questionIndex => $question) {
                $requestIndex = 'answer_' . $itemIndex . '_' . $questionIndex;
                $answerArray[] = $request->get($requestIndex);
            }
            
            $additionalInformation = $request->get('additional_information')[$itemIndex];
            $pickup = $request->get('pickup')[$itemIndex];
            $drop = $request->get('drop')[$itemIndex];
            
            $itemOptions = [
                "answersArray"    => $answerArray,
                "additional_info" => $additionalInformation,
                "pickup"          => $pickup,
                "drop"            => $drop
            ];
            
            $newItem = [
                "user_moving_request_id" => $id,
                "name"                   => $item,
                "options"                => json_encode($itemOptions),
                "price"                  => 0
            ];
            
            $newItem = new UserMovingRequestItem($newItem);
            $newItem->save();
        }
        
        return redirect()->route('admin.user_request.index');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
	 
	
    public function update(Request $request, $id)
    {
		if(isset($request->assign_captain)) // Assign Captain on Job
		{
			$this->AssignCaptain($request, $id);
			return redirect()->to('admin/user_request/'.$id);
		}
		elseif(isset($request->un_assign_captain)) // UnAssign Captain on Job
		{
			$this->UnAssignCaptain($request, $id);
			return redirect()->to('admin/user_request/'.$id);
		}
		else
		{
			$status = 'Pending';
			$UserMovingRequest = UserMovingRequest::with('user')->find($id);
			
			if ($UserMovingRequest->status == 'ASSIGNED') 
			{
				$UserMovingRequest->update([
					'status' => 'COMPLETED'
				]);
			}
			
			if ($UserMovingRequest->status == 'UNASSIGNED') 
			{
				$options = $request->only('zonetype', 'vehicle_schedule', 'vehicle_type');
				$options['status'] = 'ASSIGNED';
				$UserMovingRequest->update($options);
			}
			
			
			if ($UserMovingRequest->quotation == null) 
			{
				
				$min = $request->get('min');
				$max = $request->get('max');
				$booking_date = $request->get('booking_date');
				$values = [$min, $max];
				$average = array_sum($values) / count($values);
				$quotation = $average;
				$time = $request->get('time');
				$end_time = $start_time = $time;
				
				if (Str::endsWith($UserMovingRequest->date_type, "F")) {
					
					if ($time != null) {
						$timeArray = explode(' to ', $time);
						$start_time = $timeArray[0];
						$end_time = $timeArray[1];
					}
					
				}
				
				if ($UserMovingRequest->quotation == null && $quotation != null) {
					$status = "SAVE";
				}
				$percentages = PercentageSetting::all();
				$percentageMin = 0;
				$count = count($percentages) - 1;
				$charge = 0;
				
				foreach ($percentages as $index => $percentage) {
					
					if ($percentageMin < $average && $percentage->max > $average) {
						$charge = $percentage->flat;
						if ($percentage->is_flat == 0) {
							$charge = $average / 100 * $percentage->percentage;
						}
					}
					
					if ($count == $index) {
						$charge = $percentage->flat;
						if ($percentage->is_flat == 0) {
							$charge = $average / 100 * $percentage->percentage;
						}
					}
					
					$percentageMin = $percentage->max;
				}
				
				
				$user = $UserMovingRequest->user;
				//$user->notify(new BookingConfirmed($charge, $booking_date, $start_time, $id));
				
				$UserMovingRequest->update([
					'status'         => $status,
					'quotation'      => $quotation,
					'min'            => $min,
					'max'            => $max,
					'charge_deposit' => $charge,
					'booking_date'   => $booking_date,
					'date'           => $booking_date,
					'vehicle_type'   => $request->vehicle_type,
					'date_type'      => 'SS'
				]);
				
				
				if ($time != null) {
					$UserMovingRequest['time'] = $time;
					$UserMovingRequest['start_time'] = $start_time;
					$UserMovingRequest['end_time'] = $end_time;
				}
				
			}
			$UserMovingRequest->save();
			return redirect()->to(route('admin.user_request.index'));
		}
    }
	
	
	public function GetInventoryLoadTime($MovingItems,$location,$ranking,$flight,$stair_type,$j)
    {
		
		$total_volume = 0;
		$total_weight = 0;
		$stair_time = array();
		$ranking_time = 0;
		$total_time = 0;
		
		$row_count = array();
		
		foreach($MovingItems as $k => $item)
		{
			//echo $moving_item->item_id . '<br>';
			// Get Volume Inventory Items
			$total_volume = $total_volume + $item->volume;
			$total_weight = $total_weight + $item->weight; 
			
			if( isset($flight) && $flight[$j] > 0)
			{
					// Get Total Number Of Stairs of Pick and Drop location
					
					$flight_no = $flight[$j];
					
					if($flight_no == 0)
					{
						$MovingItems[$k]->avg_time = ($item->time_0_min + $item->time_0_med + $item->time_0_max)/3;
					}
					if($flight_no == 1)
					{
						$MovingItems[$k]->avg_time = ($item->time_1_min + $item->time_1_med + $item->time_1_max)/3;
					}
					if($flight_no == 2)
					{
						$MovingItems[$k]->avg_time = ($item->time_2_min + $item->time_2_med + $item->time_2_max)/3;
					}
					if($flight_no == 3)
					{
						$MovingItems[$k]->avg_time = ($item->time_3_min + $item->time_3_med + $item->time_3_max)/3;
					}
					if($flight_no == 4)
					{
						$MovingItems[$k]->avg_time = ($item->time_4_min + $item->time_4_med + $item->time_4_max)/3;
					}
					if($flight_no == 5)
					{
						$MovingItems[$k]->avg_time = ($item->time_5_min + $item->time_5_med + $item->time_5_max)/3;
					}
					if($flight_no == 6)
					{
						$MovingItems[$k]->avg_time = ($item->time_6_min + $item->time_6_med + $item->time_6_max)/3;
					}
					
					//echo 'Avg: ' . round($MovingItems[$k]->avg_time) .'-';
					
					// If Stairs type is windy helper take less time  
					if( strtolower($stair_type[$j]) == 'windy' )
					{
						$MovingItems[$k]->total_time = round($MovingItems[$k]->avg_time) + $item->stair_windy;
						//echo 'windy: ' . $MovingItems[$k]->total_time.'-';
					}
					
					// If Stairs type is narrow helper take more time 
					if( strtolower($stair_type[$j]) == 'narrow' )
					{
						$MovingItems[$k]->total_time = round($MovingItems[$k]->avg_time)  + $item->stair_narrow;
						//echo 'narrow: ' . $MovingItems[$k]->total_time.'-';
					}
					
					$total_time = $total_time + $MovingItems[$k]->total_time;
					
					foreach($ranking as $rank)
					{
						
						if($rank->ranking_id == $item->ranking_id)
						{	
							//echo $rank->ranking_id . '-' . $item->ranking_id . '<br>';
							$prop = 'R_'.$rank->alphabet;
							//echo $item->$prop . '-';
					
							$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->$prop;
							//echo 'rank: ('.$k.') '. $MovingItems[$k]->total_time . '-';
						}
					}
					
					if(isset($row_count[$k]))
					{
						$row_count[$k] = $row_count[$k] + $MovingItems[$k]->total_time;
					}
					else
					{
						$row_count[$k] = $MovingItems[$k]->total_time;
					}
					
					//echo 'rank: ('.$k.') '. $MovingItems[$k]->total_time . '-';
					
					//echo $MovingItems[$k]->total_time = $MovingItems[$k]->total_time;
				
				
				//echo '<br>';
						
				$MovingItems[$k]->total_row_time = $row_count[$k];
			}
			
			//dd($MovingItems);
			
			
		//	echo $MovingItems[$k]->total_row_time.'<br>';

		}
		//die;
		$total_time = 0;
		foreach($MovingItems as $k => $moving_item)
		{
			$total_time = $total_time + $moving_item->total_row_time;
		}
		
        return $total_time;
    }
	public function GetInventoryItems($MovingItems,$location,$ranking,$flight,$stair_type)
    {
		//dd($location);
		$total_volume = 0;
		$total_weight = 0;
		$stair_time = array();
		$ranking_time = 0;
		$total_time = 0;
		$row_count = array();
		
	
		foreach($MovingItems as $k => $item)
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
					$MovingItems[$k]->avg_time = ($item->time_0_min + $item->time_0_med + $item->time_0_max)/3;
				}
				if($flight_no == 1)
				{
					$MovingItems[$k]->avg_time = ($item->time_1_min + $item->time_1_med + $item->time_1_max)/3;
				}
				if($flight_no == 2)
				{
					$MovingItems[$k]->avg_time = ($item->time_2_min + $item->time_2_med + $item->time_2_max)/3;
				}
				if($flight_no == 3)
				{
					$MovingItems[$k]->avg_time = ($item->time_3_min + $item->time_3_med + $item->time_3_max)/3;
				}
				if($flight_no == 4)
				{
					$MovingItems[$k]->avg_time = ($item->time_4_min + $item->time_4_med + $item->time_4_max)/3;
				}
				if($flight_no == 5)
				{
					$MovingItems[$k]->avg_time = ($item->time_5_min + $item->time_5_med + $item->time_5_max)/3;
				}
				if($flight_no == 6)
				{
					$MovingItems[$k]->avg_time = ($item->time_6_min + $item->time_6_med + $item->time_6_max)/3;
				}
	
				// If Stairs type is windy helper take less time  
				if($loc->stair_type == 'windy')
				{
					$MovingItems[$k]->total_time = round($MovingItems[$k]->avg_time) + $item->stair_windy;
				}
				
				// If Stairs type is narrow helper take more time 
				if($loc->stair_type == 'narrow')
				{
					$MovingItems[$k]->total_time =round($MovingItems[$k]->avg_time) + $item->stair_narrow;
				}
				
				//3. Calculate Assembling / Disassembling Items Time
				if($ranking[$item->ranking]->alphabet == "A")
				{
					$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->R_A;
				}
				elseif($ranking[$item->ranking]->alphabet == "B")
				{
					$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->R_B;
				}
				elseif($ranking[$item->ranking]->alphabet == "C")
				{
					$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->R_C;
				}
				elseif($ranking[$item->ranking]->alphabet == "D")
				{
					$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->R_D;
				}
				elseif($ranking[$item->ranking]->alphabet == "E")
				{
					$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->R_E;
				}
				
				if(isset($MovingItems[$k]->total_row_time))
				{
					$MovingItems[$k]->total_row_time = $MovingItems[$k]->total_row_time + $MovingItems[$k]->total_time;
				}
				else
				{
					$MovingItems[$k]->total_row_time = $MovingItems[$k]->total_time;
				}
				
				$total_time = $total_time + $MovingItems[$k]->total_time;
				
				//echo 'rank: ('.$k.') '. $MovingItems[$k]->total_time . '-';
				
				//echo $MovingItems[$k]->total_time = $MovingItems[$k]->total_time;
			}
		}
		
		// echo '<pre>';
		// print_r($MovingItems);
		// echo '</pre>';
		// die;
		
		//	echo $MovingItems[$k]->total_row_time.'<br>';
		// echo '<pre>';
		// print_r($MovingItems);
		// echo '</pre>';
		// die;
		//die;
		
		$total_time = 0;
		foreach($MovingItems as $k => $moving_item)
		{
			$total_time = $total_time + $moving_item->total_row_time;
		}
		
        return array($total_time,$ranking,$location,$total_volume,$total_weight,$stair_time,$MovingItems);
    }
	
	public function CheckForBadges($booking_id,$insurance)
	{
		$items = booking::get_inventory_insurance_booking_items($booking_id);
		
		// Get All Badges
		$badges = Designation::GetBadgesFactor();
		$req_badge = array();
		
		foreach($items as $k => $item)
		{
			foreach($badges as $key => $badge)
			{
				if($badge->factor_id == 100) // (1) Hulk Badge - Heavy lifting required on an inventory item
				{
					if($item->weight >= $badge->factor_value)
					{
						$req_badge[$badge->factor_id] = $badge->factor_name;
					}
				}	
				
				if($badge->factor_id == 109) // (2) Mechnanics - Comp Dis/assembly (Level 1,2,3 Disassembly)
				{
					if($item->ranking == 1 || $item->ranking == 2 || $item->ranking == 3) 
					{
						$req_badge[$badge->factor_id] = $badge->factor_name;
					}
				}	
				
				if($badge->factor_id == 111) // (3) Mechnanics (2) - Level 4,5 Disassembly
				{
					if($item->ranking == 4 || $item->ranking == 5) 
					{
						$req_badge[$badge->factor_id] = $badge->factor_name;
					}
				}	
				
				if($badge->factor_id == 112) // (4) Packer - Packing is selected by the customer on the booking form
				{
					if($item->Pakaging == true) 
					{
						$req_badge[$badge->factor_id] = $badge->factor_name;
					}
				}	
			}
		}
		
		foreach($insurance as $k => $item)
		{
			foreach($badges as $key => $badge)
			{
				if($badge->factor_id == 108) // (1) Padder Badge - Created upon Insurance opted by the customer > an amount
				{
					if($item->we_pay >= $badge->factor_value)
					{
						$req_badge[$badge->factor_id] = $badge->factor_name;
					}
				}	
			}
		}
		
		$badge_ids = array();
		
		foreach($req_badge as $b_k => $b_v)
		{
			$badge_ids[] = $b_k;
		}
		
		$param['role_name'] = 'captain';
		//$param['badge_ids'] = $badge_ids;
		
		$captains = User::GetAllCaptain()->get();
		
		$captain_ids = array();
		foreach($captains as $cap)
		{
			$captain_ids[] = $cap->id;
		}
		
		$param['captain_ids'] = $captain_ids;
		$captain_badges = Designation::GetUserBadgeByRole($param);
		
		$captain_with_badges = array();
		
		foreach($captains as $k => $cap)
		{
			foreach($captain_badges as  $c_k => $badge)
			{
				if(!isset($cap->badge_name))
				{
					$cap->badge_name = '';
				}
				
				if($badge->user_id == $cap->id && (in_array($badge->badge_id,$badge_ids)))
				{
					$captain_with_badges[$k] = $cap;
					if(isset($captain_with_badges[$k]->badge_name))
					{
						$captain_with_badges[$k]->badge_name = $captain_with_badges[$k]->badge_name .','. $badge->badge_name;	
					}
					else
					{
						$captain_with_badges[$k]->badge_name = $badge->badge_name;	
					}
				}
			}
		}
		
		$captains =  $captain_with_badges;
		
		return $captains;
	}
	
	public function AssignCaptain($request,$id)
    {
		DB::beginTransaction();
			
			$booking = DB::table('booking_form')->where('booking_id',$id)->first();
		
			$update['captain_id'] = $request->assign_captain;
			$where['booking_id'] = $id;
			UserMovingRequest::AssignCaptain($update,$where);
			
			$job_assigned_users = DB::table('job_assigned_users')->where('booking_id',$id)->first();
			
			if(empty($job_assigned_users))
			{
				$insert_sch['booking_id'] = $id;
				$insert_sch['captain_id'] = $request->assign_captain;
				$insert_sch['user_id'] = $booking->user_id;
				$insert_sch['shift_start'] = null;
				$insert_sch['status'] = 'Pending';
				$insert_sch['created_at'] = time();
				$insert_sch['created_by'] = 1;
				$insert_sch['updated_at'] = time();
				$insert_sch['updated_by'] = 1;
				
				DB::table('job_assigned_users')->insert($insert_sch);
			}
			else
			{
				$update_sch['shift_start'] = now();
				$update_sch['updated_at'] = time();
				$update_sch['updated_by'] = $request->assign_captain;

				$where['booking_id'] = $id;
				$where['status'] = 'Pending';
				$where['shift_start'] = null;
				
				UserMovingRequest::check_in($update,$where);
			}
		
		DB::commit();
	}
	
	public function UnAssignCaptain($request,$id)
    {
		DB::beginTransaction();
			
			$update['captain_id'] = 0;
			$where['booking_id'] = $id;
			UserMovingRequest::AssignCaptain($update,$where);
			
			
			$update_sch['captain_id'] = null;
			$update_sch['updated_at'] = time();
			$update_sch['updated_by'] = 1;

			$where['booking_id'] = $id;
			$where['status'] = 'Pending';
			$where['shift_start'] = null;
			
			UserMovingRequest::check_in($update,$where);
			
		DB::commit();
	}
}


