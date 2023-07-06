<?php

namespace App\Http\Controllers;

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
        $requests = UserMovingRequest::with('userMovingRequestItems', 'User')->get();
        if ($status == 'ASSIGNED' || $status == 'UNASSIGNED' || $status == 'COMPLETED' || $status == 'Pending' || $status == 'SAVE') {
            $requests = UserMovingRequest::with('userMovingRequestItems', 'User')->where('status', '=', $status)->get();
        }
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
    
    public function show($id)
    {

        $request = UserMovingRequest::with('userMovingRequestItems', 'locations', 'User', 'insuranceDetails')->findOrFail($id);
		
		$MovingItems = $UserMovingRequestItems = UserMovingRequestItem::where('user_moving_request_id',$id)->get();
		
		foreach($UserMovingRequestItems as $ite)
		{
			$items[] = $ite->name;
		}
		
		$inventory_items = Inventory::whereIn('name',$items)->get(); 
		
		//dd($inventory_items);
		
		// echo 1;
		// return;
		// dd($inventory_items);
		
		$location = Location::where('user_moving_request_id',$id)->get();
		
		// Get Ranking
		$ranking = Inventory::GetRanking();
		
		foreach($location as $loc)
		{
			$flight[] =  explode('to',$loc->flight)[1];
			$stair_type[] =  $loc->stair_type;
		}
		
		$total_volume = 0;
		$total_weight = 0;
		$stair_time = 0;
		$ranking_time = 0;
		$total_time = 0;
		
		foreach($inventory_items as $k => $item)
		{
			// Get Volume Inventory Items
			$total_volume = $total_volume + $item->volume;
			$total_weight = $total_weight + $item->weight; 
			
			if( count($flight) > 0)
			{
				for($j=0; $j<count($flight); $j++)
				{
					// Get Total Number Of Stairs of Pick and Drop location
					
					$flight_no = $flight[$j];
					
					if($flight_no == 0)
					{
						$inventory_items[$k]->avg_time = ($item->time_0_min + $item->time_0_med + $item->time_0_max)/3;
					}
					if($flight_no == 1)
					{
						$inventory_items[$k]->avg_time = ($item->time_1_min + $item->time_1_med + $item->time_1_max)/3;
					}
					if($flight_no == 2)
					{
						$inventory_items[$k]->avg_time = ($item->time_2_min + $item->time_2_med + $item->time_2_max)/3;
					}
					if($flight_no == 3)
					{
						$inventory_items[$k]->avg_time = ($item->time_3_min + $item->time_3_med + $item->time_3_max)/3;
					}
					if($flight_no == 4)
					{
						$inventory_items[$k]->avg_time = ($item->time_4_min + $item->time_4_med + $item->time_4_max)/3;
					}
					if($flight_no == 5)
					{
						$inventory_items[$k]->avg_time = ($item->time_5_min + $item->time_5_med + $item->time_5_max)/3;
					}
					if($flight_no == 6)
					{
						$inventory_items[$k]->avg_time = ($item->time_6_min + $item->time_6_med + $item->time_6_max)/3;
					}
					
					$stair_time = 0;
					// If Stairs type is windy helper take less time  
					if( strtolower($stair_type[$j]) == 'windy' )
					{
						$stair_time =  0.1;
					}
					
					// If Stairs type is narrow helper take more time 
					if( strtolower($stair_type[$j]) == 'narrow' )
					{
						$stair_time = $stair_time + 0.5;
					}
					
					$inventory_items[$k]->total_time = round($inventory_items[$k]->avg_time + $stair_time);
					
				}
				
				foreach($ranking as $rank)
				{
					if($rank->ranking_id == $item->ranking_id)
					{	
						$prop = 'R_'.$rank->alphabet;
				
						$inventory_items[$k]->total_time = $inventory_items[$k]->total_time + $item->$prop + $item->$prop;
						//echo  $inventory_items[$k]->total_time . '<br>';
					}
				}
				
				$total_time = $total_time + $inventory_items[$k]->total_time;
			}
		}
		
		$total = $ranking_time + $stair_time + $request->minutes;
		
        return view('admin.movingRequest.show', compact('request','MovingItems','total_time','inventory_items','ranking','location','total_volume','total_weight','stair_time','ranking_time','total'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    
    public function edit($id)
    {
		
		$result = $this->GetInventoryItems($id);
		
		
		
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
		
        return view('admin.movingRequest.edit', compact('MovingItems','request', 'zoneTypes', 'vehicleSchedules', 'vehicleTypes','sum_volume','assigned_truck','total_time','inventory_items','ranking','location','total_volume','total_weight','stair_time','ranking_time','total','skip_loc'));
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
	
	public function GetInventoryItems($id)
    {

        $request = UserMovingRequest::with('userMovingRequestItems', 'locations', 'User', 'insuranceDetails')->findOrFail($id);
		
		$MovingItems = $UserMovingRequestItems = UserMovingRequestItem::where('user_moving_request_id',$id)->get();
		
		
		//dd($MovingItems);
		
		foreach($UserMovingRequestItems as $ite)
		{
			$items[] = $ite->name;
		}
		
		$inventory_items = Inventory::whereIn('name',$items)->get(); 
		
		//dd($inventory_items);
		
		// echo 1;
		// return;
		// dd($inventory_items);
		
		$location = Location::where('user_moving_request_id',$id)->get();
		
		//dd($location);
		
		// Get Ranking
		$ranking = Inventory::GetRanking();
		
		foreach($location as $loc)
		{
			$flight[] =  explode('to',$loc->flight)[1];
			$stair_type[] =  $loc->stair_type;
		}
		

		$total_volume = 0;
		$total_weight = 0;
		$stair_time = array();
		$ranking_time = 0;
		$total_time = 0;
		
		foreach($MovingItems as $k => $moving_item)
		{
			foreach($inventory_items as $key => $item)
			{
				if($moving_item->name == $item->name)
				{
					// Get Volume Inventory Items
					$total_volume = $total_volume + $item->volume;
					$total_weight = $total_weight + $item->weight; 
					
					if(isset($flight) && count($flight) > 0)
					{
						for($j=0; $j<count($flight); $j++)
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
							
							$str_time = 0;
							// If Stairs type is windy helper take less time  
							if( strtolower($stair_type[$j]) == 'windy' )
							{
								$str_time = -0.5;
								$stair_time[$moving_item->id][$j] =  -0.5;
							}
							
							// If Stairs type is narrow helper take more time 
							if( strtolower($stair_type[$j]) == 'narrow' )
							{
								$str_time = +0.5;
								$stair_time[$moving_item->id][$j] =  '+0.5';
							}
							
							$MovingItems[$k]->total_time = round($MovingItems[$k]->avg_time) + $str_time;
							
							$total_time = $total_time + $MovingItems[$k]->total_time;
							
						}
						
						foreach($ranking as $rank)
						{
							if($rank->ranking_id == $item->ranking_id)
							{	
								$prop = 'R_'.$rank->alphabet;
						
								$MovingItems[$k]->total_time = $MovingItems[$k]->total_time + $item->$prop + $item->$prop;
								//echo  $inventory_items[$k]->total_time . '<br>';
							}
						}
					}
				}
				break;
			}
		}
		
        return array($total_time,$inventory_items,$ranking,$location,$total_volume,$total_weight,$stair_time,$MovingItems);
    }
}
