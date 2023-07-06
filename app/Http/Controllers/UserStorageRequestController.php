<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\EmailLog;
use App\Helpers\Helper;
use App\Inventory;
use App\MessageLog;
use App\Notifications\BookingConfirmed;
use App\Notifications\CustomEmailNotification;
use App\PercentageSetting;
use App\Service;
use App\User;
use App\UserStorageRequest;
use App\UserStorageRequestItem;
use App\VehicleSchedule;
use App\VehicleType;
use App\ZoneType;
use Exception;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserStorageRequestController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('storage_request')){
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
        $requests = UserStorageRequest::with('userMovingRequestItems', 'User')->get();
        if ($status == 'ASSIGNED' || $status == 'UNASSIGNED' || $status == 'COMPLETED' || $status == 'Pending' || $status == 'SAVE') {
            $requestss = UserStorageRequest::with('userMovingRequestItems', 'User')->where('status', '=', $status)->get();
        }
        return view('admin.storageRequest.index', compact('requests'));
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
        $logs = MessageLog::orderBy('id', 'desc')->get();
        return view('admin.logs.message', compact('logs'));
    }
    
    public function emailLog()
    {
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
        $request = UserStorageRequest::with('userMovingRequestItems', 'locations', 'User', 'insuranceDetails')->findOrFail($id);
        return view('admin.storageRequest.show', compact('request'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    
    public function edit($id)
    {
        $zoneTypes = ZoneType::all();
        $vehicleSchedules = VehicleSchedule::all();
        $vehicleTypes = VehicleType::all();
        $request = UserStorageRequest::with('userMovingRequestItems', 'User', 'locations')->findOrFail($id);
        return view('admin.storageRequest.edit', compact('request', 'zoneTypes', 'vehicleSchedules', 'vehicleTypes'));
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
        $request = UserStorageRequest::with('userMovingRequestItems.item.questions.answers', 'User', 'locations')->findOrFail($id);
        $locations = null;
        $locations[] = $request->s_address;
        $locations = array_merge($locations, json_decode($request->waypoints, true));
        $locations[] = $request->d_address;
        $locations = json_encode($locations);
        return view('admin.storageRequest.edit_order', compact('request', 'serviceTypes', 'items', 'locations'));
    }
    
    public function getItemById($id)
    {
        $item = Inventory::with('questions.answers')->find($id);
        return response()->json($item, 200);
    }
    
    public function getEventsCount(Request $request)
    {
        $userMovingRequests = UserStorageRequest::with('userMovingRequestItems', 'User')
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
        
        UserStorageRequest::find($id)->update([
            'serviceType' => $serviceType
        ]);*/
        
        UserStorageRequestItem::where('user_moving_request_id', '=', $id)->delete();
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
            
            $newItem = new UserStorageRequestItem($newItem);
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
        $UserMovingRequest = UserStorageRequest::with('user')->find($id);
        if ($UserMovingRequest->status == 'ASSIGNED') {
            $UserMovingRequest->update([
                'status' => 'COMPLETED'
            ]);
        }
        
        if ($UserMovingRequest->status == 'UNASSIGNED') {
            $options = $request->only('zonetype', 'vehicle_schedule', 'vehicle_type');
            $options['status'] = 'ASSIGNED';
            $UserMovingRequest->update($options);
        }
        
        if ($UserMovingRequest->quotation == null) {
            
            $min = $request->get('min');
            $max = $request->get('max');
            $booking_date = $request->get('booking_date');
            $drop_booking_date = $request->get('drop_booking_date');
            $values = [$min, $max];
            $average = array_sum($values) / count($values);
            $quotation = $average;
            $time = $request->get('time');
            $drop_time = $request->get('drop_time');
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
            $user->notify(new BookingConfirmed($charge, $booking_date, $start_time, $id));
            
            $UserMovingRequest->update([
                'status'         => $status,
                'quotation'      => $quotation,
                'min'            => $min,
                'max'            => $max,
                'charge_deposit' => $charge,
                'booking_date'   => $booking_date,
                'date'           => $booking_date,
                'date_type'      => 'SS'
            ]);
            
            if ($time != null) {
                $UserMovingRequest['time'] = $time;
                $UserMovingRequest['start_time'] = $start_time;
                $UserMovingRequest['end_time'] = $end_time;
            }
            
        }
        $UserMovingRequest->save();
        return redirect()->to(route('admin.user_storage_request.index'));
    }
    
}
