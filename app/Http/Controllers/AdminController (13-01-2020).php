<?php

namespace App\Http\Controllers;

use App\PercentageSetting;
use App\UserJunkRequest;
use App\UserMovingRequest;
use App\UserStorageRequest;
use App\VehicleSchedule;
use App\VehicleType;
use App\ZoneType;
use Illuminate\Http\Request;

use App\Helpers\Helper;

use Auth;
use Illuminate\Http\Response;
use Setting;
use Exception;
use \Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;

use App\Booking;
use App\User;
use App\Fleet;
use App\Admin;
use App\Provider;
use App\UserPayment;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\CustomPush;

class AdminController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('demo', ['only' => [
            'settings_store',
            'settings_payment_store',
            'profile_update',
            'password_update',
            'send_push',
        ]]);
    }
    
    
    /**
     * Dashboard.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function dashboard()
    {
        if (!Helper::authorized('dashboard')) {
            return redirect()->route('admin.profile');
        }
        
        try {
            //Moving Request
            $movingAll = UserMovingRequest::all();
            $movingAssigned = UserMovingRequest::where('status', '=', 'ASSIGNED')->get();
            $movingUnAssigned = UserMovingRequest::where('status', '=', 'UNASSIGNED')->get();
            $movingCompleted = UserMovingRequest::where('status', '=', 'COMPLETED')->get();
            $movingPending = UserMovingRequest::where('status', '=', 'Pending')->get();
            
            //Storage Request
            $storageAll = UserStorageRequest::all();
            $storageAssigned = UserStorageRequest::where('status', '=', 'ASSIGNED')->get();
            $storageUnAssigned = UserStorageRequest::where('status', '=', 'UNASSIGNED')->get();
            $storageCompleted = UserStorageRequest::where('status', '=', 'COMPLETED')->get();
            $storagePending = UserStorageRequest::where('status', '=', 'Pending')->get();
            
            //Junk Request
            $junkAll = UserJunkRequest::all();
            $junkAssigned = UserJunkRequest::where('status', '=', 'ASSIGNED')->get();
            $junkUnAssigned = UserJunkRequest::where('status', '=', 'UNASSIGNED')->get();
            $junkCompleted = UserJunkRequest::where('status', '=', 'COMPLETED')->get();
            $junkPending = UserJunkRequest::where('status', '=', 'Pending')->get();
            
            $all = $movingAll->count() + $storageAll->count() + $junkAll->count();
            $assigned = $movingAssigned->count() + $storageAssigned->count() + $junkAssigned->count();
            $unAssigned = $movingUnAssigned->count() + $storageUnAssigned->count() + $junkUnAssigned->count();
            $completed = $movingCompleted->count() + $storageCompleted->count() + $junkCompleted->count();
            $pending = $movingPending->count() + $storagePending->count() + $junkPending->count();
			
			
			
			$jobs = Booking::get_booking()->whereRaw(' MONTH(primary_date) = 01 ')->get();
			
			foreach($jobs as $k => $job)
			{
				$date = '';
				
				if (!empty($job->primary_date))
				{
					$date = explode('-',$job->primary_date);
					
					$jobs[$k]->month = $date[1];
					$jobs[$k]->day = $date[2];
				}
			}
			
			// echo '<pre>';
				// print_r($jobs);
			// echo '</pre>';
			// die;
			
            $calender = $this->year2array(date("Y"));
			
            return view('admin.dashboard', compact('all', 'assigned', 'unAssigned', 'completed', 'pending','jobs','calender'));
        } 
		catch (Exception $e) 
		{
            return redirect()->route('admin.user.index')->with('flash_error', 'Something Went Wrong with Dashboard!');
        }
		
		
    }
	
	function year2array($year) 
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
	
	 public function getAllEvents(Request $request)
    {
		$userMovingRequests = Booking::get_booking()->get();
		
		$data = [];
		$additionalIndex = 0;
		$increment = false;
		$junkIncrement = false;
		foreach ($userMovingRequests as $index => $movingRequest) 
		{
			$v = '';
			if($movingRequest->truck_id == '')
			{
				$v = 'Truck Not Assigned';
			}
			
			$increment = true;
			// $vehicleType = VehicleType::where('id', '=', $movingRequest->vehicle_type)->first();
			// $vehicleSchedule = VehicleSchedule::where('request_id', '=', $movingRequest->id)->first();
			// $color = '#f4a7a1';
			
			// if (isset($vehicleType) &&  sizeof($vehicleType) > 0) 
			// {
				// $color = $vehicleType->color;
			// }
			// else{
				// $color = '';
			// }
			
			// $textColor = '#fff';
			// if (isset($vehicleSchedule) && sizeof($vehicleSchedule) > 0) 
			// {
				// $textColor = $vehicleSchedule->color;
			// }
			// else{
				// $textColor = '';
			// }
			
			$zoneTypes = $movingRequest->zonetype;
			$zoneColor1 = "#ccc";
			$zoneColor2 = "#ccc";
			if ($zoneTypes != null) {
				$zoneTypeArray = explode(',', $zoneTypes);
				$match = $zoneTypeArray[0] == $zoneTypeArray[1];
				$zoneTypes = ZoneType::whereIn('zip_code', $zoneTypeArray)->get();
				foreach ($zoneTypes as $i => $zoneType) {
					if ($i == 0) {
						$zoneColor1 = $zoneType->color;
					} else {
						$zoneColor2 = $zoneType->color;
					}
				}
				if ($match) {
					$zoneColor2 = $zoneColor1;
				}
			}
			
			if(isset($movingRequest->user->first_name) && isset($movingRequest->user->last_name))
			{
				$name = $movingRequest->user->first_name . ' ' . $movingRequest->user->last_name;	
			}
			else
			{
				$name = '';
			}
			
			
			$content = "$name  <br/>
						Start: $movingRequest->s_address <br/>
						End: $movingRequest->d_address <br/>";
			$data[$index]['id'] = $movingRequest->booking_id;
			$data[$index]['name'] = $name;
			$data[$index]['description'] = $content;
			$data[$index]['title'] = 
				"<div class=\"container\">\n" .
				"        <div class=\"row\">\n" .
				"            <div class=\"col-md-9 boxex\" style=\"border: solid 3px pink; background-color: pink;\">\n" .
				"                <div class=\"row\">\n" .
				"                    <div class=\"col-md-6 time\" style=\"color: #969696;\">\n" . $movingRequest->start_time .
				"                    </div>\n" .
				"                    <div class='col-md-3 first-icon'>\n" .
				"                    <i class=\"fa fa-circle first-icon\" style=\"color: $zoneColor1;\"></i>\n" .
				"                    </div>\n" .
				"                    <div class='col-md-3 second-icon'>\n" .
				"                    <i class=\"fa fa-circle second-icon\" style=\"color: $zoneColor2;\"></i>\n" .
				"                    </div>\n" .
				"                </div>\n" .
				"                <div class=\"row\">\n" .
				"                    <div class=\"col-md-6 time\" style=\"color: #969696;\">\n" . $name .
				"                    </div>\n" .
				"                    <div class='col-md-3 first-icon'>\n" .
				"                    <i class=\"fa fa-circle first-icon\" style=\"color: $zoneColor1;\"></i>\n" .
				"                    </div>\n" .
				"                    <div class='col-md-3 second-icon'>\n" .
				"                    <i class=\"fa fa-circle second-icon\" style=\"color: $zoneColor2;\"></i>\n" .
				"                    </div>\n" .
				"                </div>\n" .
				
				"                <div class=\"row\" style='font-size: 14px'>\n" .
				"                    <div class=\"col-md-3\">\n" .
				"                        <span class=\"text-danger\">".$v."</span>\n" .
				"                    </div>\n" .
				"                </div>\n" .
				"            </div>\n" .
				"        </div>\n" .
				"    </div>";
				
			$data[$index]['start'] = $movingRequest->booking_date;
			$data[$index]['endpoint'] = 'user_request';
		}
  
		return response()->json($data, 200);
    }
    
    public function getAllEventss(Request $request)
    {
		
        // try {
			
            $userMovingRequests = UserMovingRequest::with('userMovingRequestItems', 'User')->whereBetween('booking_date', array('2019-12-01','2020-01-12'))->get();
            $userStorageRequests = UserStorageRequest::with('userMovingRequestItems', 'User')->whereBetween('booking_date', array('2019-12-01','2020-01-12'))->get();
            $userJunkRequests = UserJunkRequest::with('userMovingRequestItems', 'User')->whereBetween('booking_date', array('2019-12-01','2020-01-12'))->get();
			
            $data = [];
            $additionalIndex = 0;
            $increment = false;
            $junkIncrement = false;
            foreach ($userMovingRequests as $index => $movingRequest) 
			{
				$v = '';
				if($movingRequest->truck_id == '')
				{
					$v = 'Truck Not Assigned';
				}
				
                $increment = true;
                $vehicleType = VehicleType::where('id', '=', $movingRequest->vehicle_type)->first();
                $vehicleSchedule = VehicleSchedule::where('request_id', '=', $movingRequest->id)->first();
                $color = '#f4a7a1';
				
                if (isset($vehicleType) &&  sizeof($vehicleType) > 0) 
				{
                    $color = $vehicleType->color;
                }
				else{
					$color = '';
				}
				
                $textColor = '#fff';
                if (isset($vehicleSchedule) && sizeof($vehicleSchedule) > 0) 
				{
                    $textColor = $vehicleSchedule->color;
                }
				else{
					$textColor = '';
				}
				
                $zoneTypes = $movingRequest->zonetype;
                $zoneColor1 = "#ccc";
                $zoneColor2 = "#ccc";
                if ($zoneTypes != null) {
                    $zoneTypeArray = explode(',', $zoneTypes);
                    $match = $zoneTypeArray[0] == $zoneTypeArray[1];
                    $zoneTypes = ZoneType::whereIn('zip_code', $zoneTypeArray)->get();
                    foreach ($zoneTypes as $i => $zoneType) {
                        if ($i == 0) {
                            $zoneColor1 = $zoneType->color;
                        } else {
                            $zoneColor2 = $zoneType->color;
                        }
                    }
                    if ($match) {
                        $zoneColor2 = $zoneColor1;
                    }
                }
				
				if(isset($movingRequest->user->first_name) && isset($movingRequest->user->last_name))
				{
					$name = $movingRequest->user->first_name . ' ' . $movingRequest->user->last_name;	
				}
				else
				{
					$name = '';
				}
                
				
                $content = "$name  <br/>
                            Start: $movingRequest->s_address <br/>
                            End: $movingRequest->d_address <br/>
                            Vehicle Size: $movingRequest->vehicle_type <br/>
                            Job Difficulty: $movingRequest->vehicle_schedule <br/>";
                $data[$index]['id'] = $movingRequest->id;
                $data[$index]['name'] = $name;
                $data[$index]['description'] = $content;
                $data[$index]['title'] = "<div class=\"container\">\n" .
                    "        <div class=\"row\">\n" .
                    "            <div class=\"col-md-9 boxex\" style=\"border: solid 3px $textColor; background-color: $color;\">\n" .
                    "                <div class=\"row\">\n" .
                    "                    <div class=\"col-md-6 time\" style=\"color: #969696;\">\n" . $userMovingRequests[0]->time .
                    "                    </div>\n" .
                    "                    <div class='col-md-3 first-icon'>\n" .
                    "                    <i class=\"fa fa-circle first-icon\" style=\"color: $zoneColor1;\"></i>\n" .
                    "                    </div>\n" .
                    "                    <div class='col-md-3 second-icon'>\n" .
                    "                    <i class=\"fa fa-circle second-icon\" style=\"color: $zoneColor2;\"></i>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span>Truck Size</span>\n" .
                    "                    </div>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <b><span class=\"jeep\" style=\"color: #66ff34;\">$movingRequest->vehicle_type</span></b>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span>Truck Schedule</span>\n" .
                    "                    </div>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <b><span style='color: $textColor;'>$movingRequest->vehicle_schedule</span></b>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
					"                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span class=\"text-danger\">".$v."</span>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "            </div>\n" .
                    "        </div>\n" .
                    "    </div>";
					
                $data[$index]['start'] = $movingRequest->booking_date;
                $data[$index]['endpoint'] = 'user_request';
            }
			
            if ($userMovingRequests->count() > 0) {
                $additionalIndex = $userMovingRequests->count() - 1;
            }
            
            foreach ($userStorageRequests as $index => $movingRequest) {
                if ($increment) {
                    $index += $additionalIndex + 1;
                }
                $junkIncrement = true;
                $vehicleType = VehicleType::where('name', '=', $movingRequest->vehicle_type)->first();
                $vehicleSchedule = VehicleSchedule::where('name', '=', $movingRequest->vehicle_schedule)->first();
                $color = '#f4a7a1';
                if (sizeof($vehicleType) > 0) {
                    $color = $vehicleType->color;
                }
                $textColor = '#fff';
                if (sizeof($vehicleSchedule) > 0) {
                    $textColor = $vehicleSchedule->color;
                }
                $zoneTypes = $movingRequest->zonetype;
                $zoneColor1 = "#ccc";
                $zoneColor2 = "#ccc";
                if ($zoneTypes != null) {
                    $zoneTypeArray = explode(',', $zoneTypes);
                    $match = $zoneTypeArray[0] == $zoneTypeArray[1];
                    $zoneTypes = ZoneType::whereIn('zip_code', $zoneTypeArray)->get();
                    foreach ($zoneTypes as $i => $zoneType) {
                        if ($i == 0) {
                            $zoneColor1 = $zoneType->color;
                        } else {
                            $zoneColor2 = $zoneType->color;
                        }
                    }
                    if ($match) {
                        $zoneColor2 = $zoneColor1;
                    }
                }
                $name = $movingRequest->user->first_name . ' ' . $movingRequest->user->last_name;
                $content = "$name  <br/>
                            Start: $movingRequest->s_address <br/>
                            End: $movingRequest->d_address <br/>
                            Vehicle Size: $movingRequest->vehicle_type <br/>
                            Job Difficulty: $movingRequest->vehicle_schedule <br/>";
                $data[$index]['id'] = $movingRequest->id;
                $data[$index]['name'] = $name;
                $data[$index]['description'] = $content;
                $data[$index]['title'] = "<div class=\"container\">\n" .
                    "        <div class=\"row\">\n" .
                    "            <div class=\"col-md-9 boxex\" style=\"border: solid 3px $textColor; background-color: $color;\">\n" .
                    "                <div class=\"row\">\n" .
                    "                    <div class=\"col-md-6 time\" style=\"color: #969696;\">\n" . $movingRequest->time .
                    "                    </div>\n" .
                    "                    <div class='col-md-3 first-icon'>\n" .
                    "                    <i class=\"fa fa-circle first-icon\" style=\"color: $zoneColor1;\"></i>\n" .
                    "                    </div>\n" .
                    "                    <div class='col-md-3 second-icon'>\n" .
                    "                    <i class=\"fa fa-circle second-icon\" style=\"color: $zoneColor2;\"></i>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span>Truck Size</span>\n" .
                    "                    </div>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <b><span class=\"jeep\" style=\"color: #66ff34;\">$movingRequest->vehicle_type</span></b>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span>Truck Schedule</span>\n" .
                    "                    </div>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <b><span style='color: $textColor;'>$movingRequest->vehicle_schedule</span></b>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "            </div>\n" .
                    "        </div>\n" .
                    "    </div>";
                $data[$index]['start'] = $movingRequest->booking_date;
                $data[$index]['endpoint'] = 'user_storage_request';
            }

            if ($userStorageRequests->count() > 0) {
                $additionalIndex = $userStorageRequests->count() - 1;
            }
            
            foreach ($userJunkRequests as $index => $movingRequest) {
                
                if ($junkIncrement) {
                    $index += $additionalIndex + 1;
                }
                
                $vehicleType = VehicleType::where('name', '=', $movingRequest->vehicle_type)->first();
                $vehicleSchedule = VehicleSchedule::where('name', '=', $movingRequest->vehicle_schedule)->first();
                $color = '#f4a7a1';
                if (sizeof($vehicleType) > 0) {
                    $color = $vehicleType->color;
                }
                $textColor = '#fff';
                if (sizeof($vehicleSchedule) > 0) {
                    $textColor = $vehicleSchedule->color;
                }
                $zoneTypes = $movingRequest->zonetype;
                $zoneColor1 = "#ccc";
                $zoneColor2 = "#ccc";
                if ($zoneTypes != null) {
                    $zoneTypeArray = explode(',', $zoneTypes);
                    $match = $zoneTypeArray[0] == $zoneTypeArray[1];
                    $zoneTypes = ZoneType::whereIn('zip_code', $zoneTypeArray)->get();
                    foreach ($zoneTypes as $i => $zoneType) {
                        if ($i == 0) {
                            $zoneColor1 = $zoneType->color;
                        } else {
                            $zoneColor2 = $zoneType->color;
                        }
                    }
                    if ($match) {
                        $zoneColor2 = $zoneColor1;
                    }
                }
                $name = $movingRequest->user->first_name . ' ' . $movingRequest->user->last_name;
                $content = "$name  <br/>
                            Start: $movingRequest->s_address <br/>
                            End: $movingRequest->d_address <br/>
                            Vehicle Size: $movingRequest->vehicle_type <br/>
                            Job Difficulty: $movingRequest->vehicle_schedule <br/>";
                $data[$index]['id'] = $movingRequest->id;
                $data[$index]['name'] = $name;
                $data[$index]['description'] = $content;
                $data[$index]['title'] = "<div class=\"container\">\n" .
                    "        <div class=\"row\">\n" .
                    "            <div class=\"col-md-9 boxex\" style=\"border: solid 3px $textColor; background-color: $color;\">\n" .
                    "                <div class=\"row\">\n" .
                    "                    <div class=\"col-md-6 time\" style=\"color: #969696;\">\n" . $movingRequest->time .
                    "                    </div>\n" .
                    "                    <div class='col-md-3 first-icon'>\n" .
                    "                    <i class=\"fa fa-circle first-icon\" style=\"color: $zoneColor1;\"></i>\n" .
                    "                    </div>\n" .
                    "                    <div class='col-md-3 second-icon'>\n" .
                    "                    <i class=\"fa fa-circle second-icon\" style=\"color: $zoneColor2;\"></i>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span>Truck Size</span>\n" .
                    "                    </div>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <b><span class=\"jeep\" style=\"color: #66ff34;\">$movingRequest->vehicle_type</span></b>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "                <div class=\"row\" style='font-size: 14px'>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <span>Truck Schedule</span>\n" .
                    "                    </div>\n" .
                    "                    <div class=\"col-md-3\">\n" .
                    "                        <b><span style='color: $textColor;'>$movingRequest->vehicle_schedule</span></b>\n" .
                    "                    </div>\n" .
                    "                </div>\n" .
                    "            </div>\n" .
                    "        </div>\n" .
                    "    </div>";
                $data[$index]['start'] = $movingRequest->booking_date;
                $data[$index]['endpoint'] = 'user_junk_request';
            }
            
			
            /*if ($userJunkRequests->count() > 0){
                $additionalIndex = $userJunkRequests->count() - 1;
            }*/
            
            return response()->json($data, 200);
			
        // } 
		// catch (Exception $e) 
		// {
            // return response()->json(['data' => []], 400);
        // }
    }
    
    public function updateDate($requestId, $date)
    {
        $request = UserMovingRequest::find($requestId);
        $request->booking_date = $date;
        $request->save();
        echo true;
    }
    
    
    /**
     * Heat Map.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function heatmap()
    {
        try {
            $rides = UserRequests::has('user')->orderBy('id', 'desc')->get();
            $providers = Provider::take(10)->orderBy('rating', 'desc')->get();
            return view('admin.heatmap', compact('providers', 'rides'));
        } catch (Exception $e) {
            return redirect()->route('admin.user.index')->with('flash_error', 'Something Went Wrong with Dashboard!');
        }
    }
    
    /**
     * Map of all Users and Drivers.
     *
     * @return Response
     */
    public function map_index()
    {
        return view('admin.map.index');
    }
    
    /**
     * Map of all Users and Drivers.
     *
     * @return Response
     */
    public function map_ajax()
    {
        try {
            
            $Providers = Provider::where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->with('service')
                ->get();
            
            $Users = User::where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->get();
            
            for ($i = 0; $i < sizeof($Users); $i++) {
                $Users[$i]->status = 'user';
            }
            
            $All = $Users->merge($Providers);
            
            return $All;
            
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function settings()
    {
        if (!Helper::authorized('site_settings')) {
            return abort(404);
        }
        
        return view('admin.settings.application');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function settings_store(Request $request)
    {
        $this->validate($request, [
            'site_title' => 'required',
            'site_icon'  => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'site_logo'  => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);
        
        if ($request->hasFile('site_icon')) {
            $site_icon = Helper::upload_picture($request->file('site_icon'));
            Setting::set('site_icon', $site_icon);
        }
        
        if ($request->hasFile('site_logo')) {
            $site_logo = Helper::upload_picture($request->file('site_logo'));
            Setting::set('site_logo', $site_logo);
        }
        
        if ($request->hasFile('site_email_logo')) {
            $site_email_logo = Helper::upload_picture($request->file('site_email_logo'));
            Setting::set('site_email_logo', $site_email_logo);
        }
        
        Setting::set('site_title', $request->site_title);
        Setting::set('store_link_android', $request->store_link_android);
        Setting::set('store_link_ios', $request->store_link_ios);
        Setting::set('provider_select_timeout', $request->provider_select_timeout);
        Setting::set('provider_search_radius', $request->provider_search_radius);
        Setting::set('sos_number', $request->sos_number);
        Setting::set('contact_number', $request->contact_number);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('site_copyright', $request->site_copyright);
        Setting::set('social_login', $request->social_login);
        Setting::set('map_key', $request->map_key);
        Setting::set('fb_app_version', $request->fb_app_version);
        Setting::set('fb_app_id', $request->fb_app_id);
        Setting::set('fb_app_secret', $request->fb_app_secret);
        Setting::set('manual_request', $request->manual_request == 'on' ? 1 : 0);
        Setting::set('broadcast_request', $request->broadcast_request == 'on' ? 1 : 0);
        Setting::set('track_distance', $request->track_distance == 'on' ? 1 : 0);
        Setting::save();
        
        return back()->with('flash_success', 'Settings Updated Successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function settings_payment()
    {
        if (!Helper::authorized('payment_settings')) {
            return abort(404);
        }
        
        return view('admin.payment.settings');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function settings_percentage()
    {
        if (!Helper::authorized('percentage_settings')) {
            return abort(404);
        }
        
        $percentageSettings = PercentageSetting::all();
        return view('admin.percentage.settings', compact('percentageSettings'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function settings_percentage_store(Request $request)
    {
        PercentageSetting::truncate();
        $allOptions = $request->only('max', 'percentage', 'is_flat', 'flat');
        foreach ($request->get('max') as $index => $max) {
            if ($max != "" && $allOptions['percentage'][$index] != "" && $allOptions['flat'][$index] != "") {
                $options = [
                    'max'        => $max,
                    'percentage' => $allOptions['percentage'][$index],
                    'is_flat'    => $allOptions['is_flat'][$index],
                    'flat'       => $allOptions['flat'][$index],
                ];
                $newPercentageSetting = new PercentageSetting($options);
                $newPercentageSetting->save();
            }
            
        }
        return redirect()->back();
    }
    
    /**
     * Save payment related settings.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function settings_payment_store(Request $request)
    {
        
        $this->validate($request, [
            'CARD'                           => 'in:on',
            'CASH'                           => 'in:on',
            'stripe_secret_key'              => 'required_if:CARD,on|max:255',
            'stripe_publishable_key'         => 'required_if:CARD,on|max:255',
            'daily_target'                   => 'required|integer|min:0',
            'tax_percentage'                 => 'required|numeric|min:0|max:100',
            'surge_percentage'               => 'required|numeric|min:0|max:100',
            'commission_percentage'          => 'required|numeric|min:0|max:100',
            'provider_commission_percentage' => 'required|numeric|min:0|max:100',
            'upfront_charge_percentage'      => 'required|numeric|min:0|max:100',
            'surge_trigger'                  => 'required|integer|min:0',
            'currency'                       => 'required'
        ]);
        
        Setting::set('CARD', $request->has('CARD') ? 1 : 0);
        Setting::set('CASH', $request->has('CASH') ? 1 : 0);
        Setting::set('stripe_secret_key', $request->stripe_secret_key);
        Setting::set('stripe_publishable_key', $request->stripe_publishable_key);
        Setting::set('daily_target', $request->daily_target);
        Setting::set('tax_percentage', $request->tax_percentage);
        Setting::set('surge_percentage', $request->surge_percentage);
        Setting::set('commission_percentage', $request->commission_percentage);
        Setting::set('provider_commission_percentage', $request->provider_commission_percentage);
        Setting::set('upfront_charge_percentage', $request->upfront_charge_percentage);
        Setting::set('surge_trigger', $request->surge_trigger);
        Setting::set('currency', $request->currency);
        Setting::set('booking_prefix', $request->booking_prefix);
        Setting::save();
        
        return back()->with('flash_success', 'Settings Updated Successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function profile()
    {
        return view('admin.account.profile');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function profile_update(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required|max:255',
            'email'   => 'required|max:255|email|unique:admins',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);
        
        try {
            $admin = Auth::guard('admin')->user();
            $admin->name = $request->name;
            $admin->email = $request->email;
            
            if ($request->hasFile('picture')) {
                $admin->picture = $request->picture->store('admin/profile');
            }
            $admin->save();
            
            return redirect()->back()->with('flash_success', 'Profile Updated');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function password()
    {
        return view('admin.account.change-password');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function password_update(Request $request)
    {
        
        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ]);
        
        try {
            
            $Admin = Admin::find(Auth::guard('admin')->user()->id);
            
            if (password_verify($request->old_password, $Admin->password)) {
                $Admin->password = bcrypt($request->password);
                $Admin->save();
                
                return redirect()->back()->with('flash_success', 'Password Updated');
            }
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function payment()
    {
        if (!Helper::authorized('payment_history')) {
            return abort(404);
        }
        
        try {
            $payments = UserRequests::where('paid', 1)
                ->has('user')
                ->has('provider')
                ->has('payment')
                ->orderBy('user_requests.created_at', 'desc')
                ->get();
            
            return view('admin.payment.payment-history', compact('payments'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function help()
    {
        try {
            $str = file_get_contents('http://appoets.com/help.json');
            $Data = json_decode($str, true);
            return view('admin.help', compact('Data'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * User Rating.
     *
     * @return Response
     */
    public function user_review()
    {
        if (!Helper::authorized('rating')) {
            return abort(404);
        }
        
        try {
            $Reviews = UserRequestRating::where('user_id', '!=', 0)->with('user', 'provider')->get();
            return view('admin.review.user_review', compact('Reviews'));
        } catch (Exception $e) {
            return redirect()->route('admin.setting')->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * Provider Rating.
     *
     * @return Response
     */
    public function provider_review()
    {
        if (!Helper::authorized('rating')) {
            return abort(404);
        }
        
        try {
            $Reviews = UserRequestRating::where('provider_id', '!=', 0)->with('user', 'provider')->get();
            return view('admin.review.provider_review', compact('Reviews'));
        } catch (Exception $e) {
            return redirect()->route('admin.setting')->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ProviderService
     * @return Response
     */
    public function destory_provider_service($id)
    {
        try {
            ProviderService::find($id)->delete();
            return back()->with('message', 'Service deleted successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * Testing page for push notifications.
     *
     * @return Response
     */
    public function push_index()
    {
        
        $data = \PushNotification::app('IOSUser')
            ->to('3911e9870e7c42566b032266916db1f6af3af1d78da0b52ab230e81d38541afa')
            ->send('Hello World, i`m a push message');
        dd($data);
    }
    
    /**
     * Testing page for push notifications.
     *
     * @return Response
     */
    public function push_store(Request $request)
    {
        try {
            ProviderService::find($id)->delete();
            return back()->with('message', 'Service deleted successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    /**
     * privacy.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    
    public function privacy()
    {
        return view('admin.pages.static')
            ->with('title', "Privacy Page")
            ->with('page', "privacy");
    }
    
    /**
     * pages.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function pages(Request $request)
    {
        $this->validate($request, [
            'page'    => 'required|in:page_privacy',
            'content' => 'required',
        ]);
        
        Setting::set($request->page, $request->content);
        Setting::save();
        
        return back()->with('flash_success', 'Content Updated!');
    }
    
    /**
     * account statements.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function statement($type = 'individual')
    {
        if (!Helper::authorized('statements')) {
            return abort(404);
        }
        
        try {
            
            $page = 'Ride Statement';
            
            if ($type == 'individual') {
                $page = 'Provider Ride Statement';
            } elseif ($type == 'today') {
                $page = 'Today Statement - ' . date('d M Y');
            } elseif ($type == 'monthly') {
                $page = 'This Month Statement - ' . date('F');
            } elseif ($type == 'yearly') {
                $page = 'This Year Statement - ' . date('Y');
            }
            
            $rides = UserRequests::with('payment')->orderBy('id', 'desc');
            $cancel_rides = UserRequests::where('status', 'CANCELLED');
            $revenue = UserRequestPayment::select(\DB::raw(
                'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
            ));
            
            if ($type == 'today') {
                
                $rides->where('created_at', '>=', Carbon::today());
                $cancel_rides->where('created_at', '>=', Carbon::today());
                $revenue->where('created_at', '>=', Carbon::today());
                
            } elseif ($type == 'monthly') {
                
                $rides->where('created_at', '>=', Carbon::now()->month);
                $cancel_rides->where('created_at', '>=', Carbon::now()->month);
                $revenue->where('created_at', '>=', Carbon::now()->month);
                
            } elseif ($type == 'yearly') {
                
                $rides->where('created_at', '>=', Carbon::now()->year);
                $cancel_rides->where('created_at', '>=', Carbon::now()->year);
                $revenue->where('created_at', '>=', Carbon::now()->year);
                
            }
            
            $rides = $rides->get();
            $cancel_rides = $cancel_rides->count();
            $revenue = $revenue->get();
            
            return view('admin.providers.statement', compact('rides', 'cancel_rides', 'revenue'))
                ->with('page', $page);
            
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    
    /**
     * account statements today.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function statement_today()
    {
        if (!Helper::authorized('statements')) {
            return abort(404);
        }
        
        return $this->statement('today');
    }
    
    /**
     * account statements monthly.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function statement_monthly()
    {
        if (!Helper::authorized('statements')) {
            return abort(404);
        }
        
        return $this->statement('monthly');
    }
    
    /**
     * account statements monthly.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function statement_yearly()
    {
        if (!Helper::authorized('statements')) {
            return abort(404);
        }
        
        return $this->statement('yearly');
    }
    
    
    /**
     * account statements.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function statement_provider()
    {
        
        if (!Helper::authorized('statements')) {
            return abort(404);
        }
        
        try {
            
            $Providers = Provider::all();
            
            foreach ($Providers as $index => $Provider) {
                
                $Rides = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');
                
                $Providers[$index]->rides_count = $Rides->count();
                
                $Providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(\DB::raw(
                        'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission'
                    ))->get();
            }
            
            return view('admin.providers.provider-statement', compact('Providers'))->with('page', 'Providers Statement');
            
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function translation()
    {
        
        try {
            return view('admin.translation');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function push()
    {
        
        try {
            $Pushes = CustomPush::orderBy('id', 'desc')->get();
            return view('admin.push', compact('Pushes'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    
    /**
     * pages.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function send_push(Request $request)
    {
        
        
        $this->validate($request, [
            'send_to'            => 'required|in:ALL,USERS,PROVIDERS',
            'user_condition'     => ['required_if:send_to,USERS', 'in:ACTIVE,LOCATION,RIDES,AMOUNT'],
            'provider_condition' => ['required_if:send_to,PROVIDERS', 'in:ACTIVE,LOCATION,RIDES,AMOUNT'],
            'user_active'        => ['required_if:user_condition,ACTIVE', 'in:HOUR,WEEK,MONTH'],
            'user_rides'         => 'required_if:user_condition,RIDES',
            'user_location'      => 'required_if:user_condition,LOCATION',
            'user_amount'        => 'required_if:user_condition,AMOUNT',
            'provider_active'    => ['required_if:provider_condition,ACTIVE', 'in:HOUR,WEEK,MONTH'],
            'provider_rides'     => 'required_if:provider_condition,RIDES',
            'provider_location'  => 'required_if:provider_condition,LOCATION',
            'provider_amount'    => 'required_if:provider_condition,AMOUNT',
            'message'            => 'required|max:100',
        ]);
        
        try {
            
            $CustomPush = new CustomPush;
            $CustomPush->send_to = $request->send_to;
            $CustomPush->message = $request->message;
            
            if ($request->send_to == 'USERS') {
                
                $CustomPush->condition = $request->user_condition;
                
                if ($request->user_condition == 'ACTIVE') {
                    $CustomPush->condition_data = $request->user_active;
                } elseif ($request->user_condition == 'LOCATION') {
                    $CustomPush->condition_data = $request->user_location;
                } elseif ($request->user_condition == 'RIDES') {
                    $CustomPush->condition_data = $request->user_rides;
                } elseif ($request->user_condition == 'AMOUNT') {
                    $CustomPush->condition_data = $request->user_amount;
                }
                
            } elseif ($request->send_to == 'PROVIDERS') {
                
                $CustomPush->condition = $request->provider_condition;
                
                if ($request->provider_condition == 'ACTIVE') {
                    $CustomPush->condition_data = $request->provider_active;
                } elseif ($request->provider_condition == 'LOCATION') {
                    $CustomPush->condition_data = $request->provider_location;
                } elseif ($request->provider_condition == 'RIDES') {
                    $CustomPush->condition_data = $request->provider_rides;
                } elseif ($request->provider_condition == 'AMOUNT') {
                    $CustomPush->condition_data = $request->provider_amount;
                }
            }
            
            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                $CustomPush->schedule_at = date("Y-m-d H:i:s", strtotime("$request->schedule_date $request->schedule_time"));
            }
            
            $CustomPush->save();
            
            if ($CustomPush->schedule_at == '') {
                $this->SendCustomPush($CustomPush->id);
            }
            
            return back()->with('flash_success', 'Message Sent to all ' . $request->segment);
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    
    public function SendCustomPush($CustomPush)
    {
        
        try {
            
            \Log::notice("Starting Custom Push");
            
            $Push = CustomPush::findOrFail($CustomPush);
            
            if ($Push->send_to == 'USERS') {
                
                $Users = [];
                
                if ($Push->condition == 'ACTIVE') {
                    
                    if ($Push->condition_data == 'HOUR') {
                        
                        $Users = User::whereHas('trips', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subHour());
                        })->get();
                        
                    } elseif ($Push->condition_data == 'WEEK') {
                        
                        $Users = User::whereHas('trips', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subWeek());
                        })->get();
                        
                    } elseif ($Push->condition_data == 'MONTH') {
                        
                        $Users = User::whereHas('trips', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subMonth());
                        })->get();
                        
                    }
                    
                } elseif ($Push->condition == 'RIDES') {
                    
                    $Users = User::whereHas('trips', function ($query) use ($Push) {
                        $query->where('status', 'COMPLETED');
                        $query->groupBy('id');
                        $query->havingRaw('COUNT(*) >= ' . $Push->condition_data);
                    })->get();
                    
                    
                } elseif ($Push->condition == 'LOCATION') {
                    
                    $Location = explode(',', $Push->condition_data);
                    
                    $distance = Setting::get('provider_search_radius', '10');
                    $latitude = $Location[0];
                    $longitude = $Location[1];
                    
                    $Users = User::whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                        ->get();
                    
                }
                
                
                foreach ($Users as $key => $user) {
                    (new SendPushNotification)->sendPushToUser($user->id, $Push->message);
                }
                
            } elseif ($Push->send_to == 'PROVIDERS') {
                
                
                $Providers = [];
                
                if ($Push->condition == 'ACTIVE') {
                    
                    if ($Push->condition_data == 'HOUR') {
                        
                        $Providers = Provider::whereHas('trips', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subHour());
                        })->get();
                        
                    } elseif ($Push->condition_data == 'WEEK') {
                        
                        $Providers = Provider::whereHas('trips', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subWeek());
                        })->get();
                        
                    } elseif ($Push->condition_data == 'MONTH') {
                        
                        $Providers = Provider::whereHas('trips', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subMonth());
                        })->get();
                        
                    }
                    
                } elseif ($Push->condition == 'RIDES') {
                    
                    $Providers = Provider::whereHas('trips', function ($query) use ($Push) {
                        $query->where('status', 'COMPLETED');
                        $query->groupBy('id');
                        $query->havingRaw('COUNT(*) >= ' . $Push->condition_data);
                    })->get();
                    
                } elseif ($Push->condition == 'LOCATION') {
                    
                    $Location = explode(',', $Push->condition_data);
                    
                    $distance = Setting::get('provider_search_radius', '10');
                    $latitude = $Location[0];
                    $longitude = $Location[1];
                    
                    $Providers = Provider::whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                        ->get();
                    
                }
                
                
                foreach ($Providers as $key => $provider) {
                    (new SendPushNotification)->sendPushToProvider($provider->id, $Push->message);
                }
                
            } elseif ($Push->send_to == 'ALL') {
                
                $Users = User::all();
                foreach ($Users as $key => $user) {
                    (new SendPushNotification)->sendPushToUser($user->id, $Push->message);
                }
                
                $Providers = Provider::all();
                foreach ($Providers as $key => $provider) {
                    (new SendPushNotification)->sendPushToProvider($provider->id, $Push->message);
                }
                
            }
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    
    
}
