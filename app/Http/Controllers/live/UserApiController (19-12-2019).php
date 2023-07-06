<?php

namespace App\Http\Controllers;

use App\UserJunkRequest;
use App\UserMovingRequest;
use App\UserSchedule;
use App\UserStorageRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Illuminate\Http\Response;
use Log;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Notification;

use Carbon\Carbon;
use App\Helpers\Helper;

use App\Card;
use App\User;
use App\Role;
use App\Provider;
use App\Promocode;
use App\ServiceType;
use App\UserRequests;
use App\RequestFilter;
use App\PromocodeUsage;
use App\WalletPassbook;
use App\PromocodePassbook;
use App\ProviderService;
use App\UserRequestRating;
use App\Http\Controllers\ProviderResources\TripController;


class UserApiController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */

	public function services_test(Request $request)
    {
        return response()->json(array('test' => 123), 200);
    }

    public function signup(Request $request)
    {
		$this->validate($request, [
                'device_type' => 'required|in:android,ios',
                'device_token' => 'required',
                'device_id' => 'required|unique:users',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'mobile' => 'required',
                'password' => 'required|min:6',
				'role' => 'required|in:captain,helper,technician',
            ]);
        try
		{
            $User = $request->all();
            $User['payment_mode'] = 'CASH';
            $User['password'] = bcrypt($request->password);
			
			DB::beginTransaction();
			
				$User = User::create($User);
				
				$role['user_id'] = $User->id;
				$role['role_id'] = Role::where('name',$request->role)->first()->id;
				$role['created_at'] = time();
				$role['updated_at'] = time();
				
				User::insertRole($role);
			
			DB::commit();
			
			$response = array('status' => 1, 'message' => 'success');
			return response()->json(['user_info' => $User,'response' => $response], 200);
            
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json(['response' => $response], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function logout(Request $request)
    {
        try {
            User::where('id', $request->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function change_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'old_password' => 'required',
            ]);

        $User = Auth::user();

        if(Hash::check($request->old_password, $User->password))
        {
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            }else{
                return back()->with('flash_success', 'Password Updated');
            }

        } else {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.user.change_password')], 500);
            }else{
                return back()->with('flash_error',trans('api.user.change_password'));
            }
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function update_location(Request $request){

        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        if($user = User::find(Auth::user()->id)){

            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->save();

            return response()->json(['message' => trans('api.user.location_updated')]);

        }else{

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function details(Request $request){

        $this->validate($request, [
            'device_type' => 'in:android,ios',
        ]);

        try{

            if($user = User::find(Auth::user()->id)){

                if($request->has('device_token')){
                    $user->device_token = $request->device_token;
                }

                if($request->has('device_type')){
                    $user->device_type = $request->device_type;
                }

                if($request->has('device_id')){
                    $user->device_id = $request->device_id;
                }

                $user->save();

                $user->currency = Setting::get('currency');
                $user->sos = Setting::get('sos_number', '911');
                return $user;

            } else {
                return response()->json(['error' => trans('api.user.user_not_found')], 500);
            }
        }
        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function update_profile(Request $request)
    {

        $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'max:255',
                'email' => 'email|unique:users,email,'.Auth::user()->id,
                'mobile' => 'required',
                'picture' => 'mimes:jpeg,bmp,png',
            ]);

         try {

            $user = User::findOrFail(Auth::user()->id);

            if($request->has('first_name')){ 
                $user->first_name = $request->first_name;
            }
            
            if($request->has('last_name')){
                $user->last_name = $request->last_name;
            }
            
            if($request->has('email')){
                $user->email = $request->email;
            }
        
            if($request->has('mobile')){
                $user->mobile = $request->mobile;
            }

            if ($request->picture != "") {
                Storage::delete($user->picture);
              //  $user->picture = $request->picture->store('user/profile');
                $user->picture = Helper::upload_picture($request->picture);
            }

            $user->save();

            if($request->ajax()) {
                return response()->json($user);
            }else{
                return back()->with('flash_success', trans('api.user.profile_updated'));
            }
        }

        catch (ModelNotFoundException $e) {
             return response()->json(['error' => trans('api.user.user_not_found')], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function services() 
	{
		
        if($serviceList = ServiceType::all()) 
		{
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	 /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function driver_details(Request $request)
    {
        if($request->all()) 
		{
			$user =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			
			if(!empty($user))
			{
				return response()->json($user, 200);
			}
			else
			{
				return response()->json(['error' => 'User Not Found'], 500);	
			}
            
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function helper_details(Request $request)
    {
        if($request->all()) 
		{
			$user =  User::GetUserProfileByDeviceId($request->device_id,5)->first();
			
			if(!empty($user))
			{
				return response()->json($user, 200);
			}
			else
			{
				return response()->json(['error' => 'User Not Found'], 500);	
			}
            
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function technician_details(Request $request)
    {
        if($request->all()) 
		{
			$user =  User::GetUserProfileByDeviceId($request->device_id,6)->first();
			
			if(!empty($user))
			{
				return response()->json($user, 200);
			}
			else
			{
				return response()->json(['error' => 'User Not Found'], 500);	
			}
            
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function job_available(Request $request)
    {
		try
		{
            $available_jobs =  UserMovingRequest::GetAvailableJobs(array('captain_id' => null))->get();
			
			if(!empty($available_jobs[0]))
			{
				$users_array = array();
				foreach($available_jobs as $key => $user)
				{
					$users_array[] = $user->user_id;
				}
				
				$customer = User::whereIn('id',$users_array)->pluck('first_name','id');
				
				foreach($available_jobs as $key => $user)
				{
					$user->customer = $customer[$user->user_id];
				}
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json(['available_jobs' => $available_jobs,'response' => $response], 200);
				
			}
			else
			{
				$response = array('status' => 0, 'message' => 'Jobs Not Found');
				return response()->json(['response' => $response], 500);
			}
            
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json(['response' => $response], 500);
        }

    }
	
	public function job_assigned(Request $request)
    {
        if($request->all()) 
		{
			$captain =  User::GetUserProfileByDeviceId($request->device_id,$request->role_id)->first();
			
			$param['captain_id'] = $captain->id;
			$job_assigned =  UserMovingRequest::GetAvailableJobs($param)->get();
			
			if(!empty($job_assigned[0]))
			{
				$users_array = array();
				foreach($job_assigned as $key => $user)
				{
					$users_array[] = $user->user_id;
					$users_array[] = $user->helper_id;
					$users_array[] = $user->technician_id;
				}
				
				$member = User::whereIn('id',$users_array)->pluck('first_name','id');
			
				foreach($job_assigned as $key => $user)
				{
					$user->customer = $member[$user->user_id];
					$user->helper = isset($member[$user->helper_id]) ? $member[$user->helper_id] : null;
					$user->technician = isset($member[$user->technician_id]) ? $member[$user->technician_id] : null;
				}
				
				$available_helpers =  UserMovingRequest::GetAvailableHelpers()->get();
				$available_technician =  UserMovingRequest::GetAvailableTechnician()->get();
				
				$result['available_helpers'] = $available_helpers;
				$result['available_technician'] = $available_technician;
				$result['job_assigned'] = $job_assigned;
				
				return response()->json($result, 200);	
				
			}
			else
			{
				return response()->json(['error' => 'Jobs Not Found'], 500);	
			}
            
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function job_accept(Request $request)
    {
		 $this->validate($request, [
                'booking_id' => 'required',
            ]);
		
        if($request->all()) 
		{
			DB::beginTransaction();
			
			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			
			$job['captain_id'] = $captain->id;
			$job['updated_at'] = time();
			$job['updated_by'] = $captain->id;
			
			UserMovingRequest::UpdateAssignedJobUsers($job,$request->booking_id);
		
			DB::commit();
		
			return response()->json(['msg' => 'Accepted Successfully'], 200);
			
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }
    }
	
	public function invite_helper(Request $request)
    {
		 $this->validate($request, [
                'booking_id' => 'required',
				'captain_id' => 'required',
				'helper_id' => 'required',
            ]);
		
        if($request->all()) 
		{
			DB::beginTransaction();
			
			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			
			$update['helper_id'] = $request->helper_id;
			$update['updated_at'] = time();
			$update['updated_by'] = $captain->id;
			
			$where['booking_id'] = $request->booking_id;
			$where['captain_id'] = $captain->id;
			$where['status'] = 'Pending';
			
			UserMovingRequest::UpdateHelper($update,$where);
		
			DB::commit();
		
			return response()->json(['msg' => 'Helper Assigned Successfully'], 200);
			
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function invite_technician(Request $request)
    {
		 $this->validate($request, [
                'booking_id' => 'required',
				'captain_id' => 'required',
				'technician_id' => 'required',
            ]);
		
        if($request->all()) 
		{
			DB::beginTransaction();
			
			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			
			$update['technician_id'] = $request->technician_id;
			$update['updated_at'] = time();
			$update['updated_by'] = $captain->id;
			
			$where['booking_id'] = $request->booking_id;
			$where['captain_id'] = $captain->id;
			$where['status'] = 'Pending';
			
			UserMovingRequest::UpdateHelper($update,$where);
		
			DB::commit();
		
			return response()->json(['msg' => 'Technician Assigned Successfully'], 200);
			
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function job_schedule(Request $request)
    {
		if($request->all()) 
		{
			if(isset($request->submit))
			{
		
				$this->validate($request, [
					'Mon' => 'required_without_all:Tue,Wed,Thu,Fri,Sat,Sun',
					'Tue' => 'required_without_all:Mon,Wed,Thu,Fri,Sat,Sun',
					'Wed' => 'required_without_all:Mon,Tue,Thu,Fri,Sat,Sun',
					'Thu' => 'required_without_all:Mon,Tue,Wed,Fri,Sat,Sun',
					'Fri' => 'required_without_all:Mon,Tue,Wed,Thu,Sat,Sun',
					'start_time' => 'required',
					'start_unit' => 'required',
					'end_time' => 'required',
					'end_unit' => 'required',
				]);
			
		   
				DB::beginTransaction();
				
					$captain =  User::GetUserProfileByDeviceId($request->device_id)->first();
					
					if(isset($request->Mon)){$user_schedules['Mon'] = $request->Mon;}
					if(isset($request->Tue)){$user_schedules['Tue'] = $request->Tue;}
					if(isset($request->Wed)){$user_schedules['Wed'] = $request->Wed;}
					if(isset($request->Thu)){$user_schedules['Thu'] = $request->Thu;}
					if(isset($request->Fri)){$user_schedules['Fri'] = $request->Fri;}
					
					$user_schedules['start_time'] 	= $request->start_time;
					$user_schedules['start_unit'] 	= $request->start_unit;
					$user_schedules['end_time'] 	= $request->end_time;
					$user_schedules['end_unit'] 	= $request->end_unit;
					$user_schedules['user_id'] = $captain->id;
					$user_schedules['created_at'] = now();
					$user_schedules['created_by'] = $captain->id;
					$user_schedules['updated_at'] = now();
					$user_schedules['updated_by'] = $captain->id;
					
					UserSchedule::AddUserSchedule($user_schedules,$request->booking_id);
			
				DB::commit();
			
				return response()->json(['msg' => 'Inserted Successfully'], 200);	
			
			}
			else
			{
				$captain =  User::GetUserProfileByDeviceId($request->device_id)->first();
				$schedule = UserSchedule::getSchedule(array('user_id' => $captain->id))->first();
				
				return response()->json(['shchedule' => $schedule], 200);
			}
			
			
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }
	
	public function check_in(Request $request)
    {
		$this->validate($request, ['booking_id' => 'required']);

		DB::beginTransaction();

			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();

			if(!empty($captain))
			{	
				$update['shift_start'] = now();
				$update['updated_at'] = time();
				$update['updated_by'] = $captain->id;

				$where['booking_id'] = $request->booking_id;
				$where['captain_id'] = $captain->id;
				$where['status'] = 'Pending';
				$where['shift_start'] = null;

				UserMovingRequest::check_in($update,$where);
			}

		DB::commit();

		return response()->json(['msg' => 'Your Job Starts Now'], 200);
    }
	
	public function check_out(Request $request)
    {
		$this->validate($request, ['booking_id' => 'required']);

		DB::beginTransaction();

			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();

			if(!empty($captain))
			{
				$update['shift_end'] = now();
				$update['updated_at'] = time();
				$update['updated_by'] = $captain->id;

				$where['booking_id'] = $request->booking_id;
				$where['captain_id'] = $captain->id;
				$where['status'] = 'Pending';
				$where['shift_end'] = null;

				UserMovingRequest::check_out($update,$where);
			}

		DB::commit();

		return response()->json(['msg' => 'Job Accomplished'], 200);
    }


    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function send_request(Request $request) {

        $this->validate($request, [
                's_latitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                'promo_code' => 'exists:promocodes,promo_code',
                'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:CASH,CARD,PAYPAL',
                'card_id' => ['required_if:payment_mode,CARD','exists:cards,card_id,user_id,'.Auth::user()->id],
            ]);

        Log::info('New Request from User: '.Auth::user()->id);
        Log::info('Request Details:', $request->all());

        $ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();

        if($ActiveRequests > 0) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.ride.request_inprogress')], 500);
            } else {
                return redirect('dashboard')->with('flash_error', 'Already request is in progress. Try again later');
            }
        }

        if($request->has('schedule_date') && $request->has('schedule_time')){
            $beforeschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->subHour(1);
            $afterschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->addHour(1);

            $CheckScheduling = UserRequests::where('status','SCHEDULED')
                            ->where('user_id', Auth::user()->id)
                            ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                            ->count();


            if($CheckScheduling > 0){
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
                }else{
                    return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
                }
            }

        }

        $distance = Setting::get('provider_search_radius', '10');
        $latitude = $request->s_latitude;
        $longitude = $request->s_longitude;
        $service_type = $request->service_type;

        $Providers = Provider::with('service')
            ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id')
            ->where('status', 'approved')
            ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
            ->whereHas('service', function($query) use ($service_type){
                        $query->where('status','active');
                        $query->where('service_type_id',$service_type);
                    })
            ->orderBy('distance','asc')
            ->take(10)
            ->get();

        // List Providers who are currently busy and add them to the filter list.

        if(count($Providers) == 0) {
            if($request->ajax()) {
                // Push Notification to User
                return response()->json(['message' => trans('api.ride.no_providers_found')]); 
            }else{
                return back()->with('flash_success', 'No Providers Found! Please try again.');
            }
        }

        try{

            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".Setting::get('map_key');

            $json = curl($details);

            $details = json_decode($json, TRUE);

            $route_key = $details['routes'][0]['overview_polyline']['points'];

            $UserRequest = new UserRequests;
            $UserRequest->booking_id = Helper::generate_booking_id();
            $UserRequest->user_id = Auth::user()->id;
            
            if((Setting::get('manual_request',0) == 0) && (Setting::get('broadcast_request',0) == 0)){
                $UserRequest->current_provider_id = $Providers[0]->id;
            }else{
                $UserRequest->current_provider_id = 0;
            }

            $UserRequest->service_type_id = $request->service_type;
            $UserRequest->payment_mode = $request->payment_mode;
            
            $UserRequest->status = 'SEARCHING';

            $UserRequest->s_address = $request->s_address ? : "";
            $UserRequest->d_address = $request->d_address ? : "";

            $UserRequest->s_latitude = $request->s_latitude;
            $UserRequest->s_longitude = $request->s_longitude;

            $UserRequest->d_latitude = $request->d_latitude;
            $UserRequest->d_longitude = $request->d_longitude;
            $UserRequest->distance = $request->distance;
            
            
             $UserRequest->track_latitude  = $request->s_latitude;
             $UserRequest->track_longitude = $request->s_longitude;

            if(Auth::user()->wallet_balance > 0){
                $UserRequest->use_wallet = $request->use_wallet ? : 0;
            }

            if(Setting::get('track_distance', 0) == 1){
                $UserRequest->is_track = "YES";
            }

            $UserRequest->assigned_at = Carbon::now();
            $UserRequest->route_key = $route_key;

            if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
                $UserRequest->surge = 1;
            }

            if($request->has('schedule_date') && $request->has('schedule_time')){
                $UserRequest->schedule_at = date("Y-m-d H:i:s",strtotime("$request->schedule_date $request->schedule_time"));
            }

             if((Setting::get('manual_request',0) == 0) && (Setting::get('broadcast_request',0) == 0)){
                Log::info('New Request id : '. $UserRequest->id .' Assigned to provider : '. $UserRequest->current_provider_id);
                (new SendPushNotification)->IncomingRequest($Providers[0]->id);
            }

            $UserRequest->save();


           

            // update payment mode 

            User::where('id',Auth::user()->id)->update(['payment_mode' => $request->payment_mode, 'latitude' => $latitude, 'longitude' => $longitude]);

            if($request->has('card_id')){

                Card::where('user_id',Auth::user()->id)->update(['is_default' => 0]);
                Card::where('card_id',$request->card_id)->update(['is_default' => 1]);
            }

            if(Setting::get('manual_request',0) == 0){
                foreach ($Providers as $key => $Provider) {

                    if(Setting::get('broadcast_request',0) == 1){
                       (new SendPushNotification)->IncomingRequest($Provider->id); 
                    }

                    $Filter = new RequestFilter;
                    // Send push notifications to the first provider
                    // incoming request push to provider
                    
                    $Filter->request_id = $UserRequest->id;
                    $Filter->provider_id = $Provider->id; 
                    $Filter->save();
                }
            }

            if($request->ajax()) {
                return response()->json([
                        'message' => 'New request Created!',
                        'request_id' => $UserRequest->id,
                        'current_provider' => $UserRequest->current_provider_id,
                    ]);
            }else{
                return redirect('dashboard');
            }

        } catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.');
            }
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function cancel_request(Request $request) {

        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id,user_id,'.Auth::user()->id,
        ]);

        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);

            if($UserRequest->status == 'CANCELLED')
            {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_cancelled')], 500); 
                }else{
                    return back()->with('flash_error', 'Request is Already Cancelled!');
                }
            }

            if(in_array($UserRequest->status, ['SEARCHING','STARTED','ARRIVED','SCHEDULED'])) {

                if($UserRequest->status != 'SEARCHING'){
                    $this->validate($request, [
                        'cancel_reason'=> 'max:255',
                    ]);
                }

                $UserRequest->status = 'CANCELLED';
                $UserRequest->cancel_reason = $request->cancel_reason;
                $UserRequest->cancelled_by = 'USER';
                $UserRequest->save();

                RequestFilter::where('request_id', $UserRequest->id)->delete();

                if($UserRequest->status != 'SCHEDULED'){

                    if($UserRequest->provider_id != 0){

                        ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' => 'active']);

                    }
                }

                 // Send Push Notification to User
                (new SendPushNotification)->UserCancellRide($UserRequest);

                if($request->ajax()) {
                    return response()->json(['message' => trans('api.ride.ride_cancelled')]); 
                }else{
                    return redirect('dashboard')->with('flash_success','Request Cancelled Successfully');
                }

            } else {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_onride')], 500); 
                }else{
                    return back()->with('flash_error', 'Service Already Started!');
                }
            }
        }

        catch (ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }else{
                return back()->with('flash_error', 'No Request Found!');
            }
        }

    }

    /**
     * Show the request status check.
     *
     * @return Response
     */

    public function request_status_check() {

        try{
            $check_status = ['CANCELLED', 'SCHEDULED'];

            $UserRequests = UserRequests::UserRequestStatusCheck(Auth::user()->id, $check_status)
                                        ->get()
                                        ->toArray();
                                        

            $search_status = ['SEARCHING','SCHEDULED'];
            $UserRequestsFilter = UserRequests::UserRequestAssignProvider(Auth::user()->id,$search_status)->get(); 

             //Log::info($UserRequestsFilter);

            $Timeout = Setting::get('provider_select_timeout', 180);

            if(!empty($UserRequestsFilter)){
                for ($i=0; $i < sizeof($UserRequestsFilter); $i++) {
                    $ExpiredTime = $Timeout - (time() - strtotime($UserRequestsFilter[$i]->assigned_at));
                    if($UserRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime < 0) {
                        $Providertrip = new TripController();
                        $Providertrip->assign_next_provider($UserRequestsFilter[$i]->id);
                    }else if($UserRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime > 0){
                        break;
                    }
                }
            }

            return response()->json(['data' => $UserRequests]);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */


    public function rate_provider(Request $request) {

        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id,user_id,'.Auth::user()->id,
                'rating' => 'required|integer|in:1,2,3,4,5',
                'comment' => 'max:255',
            ]);
    
        $UserRequests = UserRequests::where('id' ,$request->request_id)
                ->where('status' ,'COMPLETED')
                ->where('paid', 0)
                ->first();

        if ($UserRequests) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.user.not_paid')], 500);
            } else {
                return back()->with('flash_error', 'Service Already Started!');
            }
        }

        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);
            
            if($UserRequest->rating == null) {
                UserRequestRating::create([
                        'provider_id' => $UserRequest->provider_id,
                        'user_id' => $UserRequest->user_id,
                        'request_id' => $UserRequest->id,
                        'user_rating' => $request->rating,
                        'user_comment' => $request->comment,
                    ]);
            } else {
                $UserRequest->rating->update([
                        'user_rating' => $request->rating,
                        'user_comment' => $request->comment,
                    ]);
            }

            $UserRequest->user_rated = 1;
            $UserRequest->save();

            $average = UserRequestRating::where('provider_id', $UserRequest->provider_id)->avg('user_rating');

            Provider::where('id',$UserRequest->provider_id)->update(['rating' => $average]);

            // Send Push Notification to Provider 
            if($request->ajax()){
                return response()->json(['message' => trans('api.ride.provider_rated')]); 
            }else{
                return redirect('dashboard')->with('flash_success', 'Driver Rated Successfully!');
            }
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something went wrong');
            }
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */


    public function modifiy_request(Request $request) {

        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id,user_id,'.Auth::user()->id,
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'address' => 'required'
            ]);

        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);
            $UserRequest->d_latitude = $request->latitude?:$UserRequest->d_latitude;
            $UserRequest->d_longitude = $request->longitude?:$UserRequest->d_longitude;
            $UserRequest->d_address =  $request->address?:$UserRequest->d_address;
            $UserRequest->save();

            // Send Push Notification to Provider 
            if($request->ajax()){
                return response()->json(['message' => trans('api.ride.request_modify_location')]); 
            }else{
                return redirect('dashboard')->with('flash_success', 'User Changed Destination Address Successfully!');
            }
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something went wrong');
            }
        }

    } 


    /**
     * Show the application dashboard.
     *
     * @return array
     */

    public function trips() {
    
        try{
            $userRequests = UserMovingRequest::with('userMovingRequestItems', 'User')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
            
            $userStorageRequests = UserStorageRequest::with('userMovingRequestItems', 'User')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
    
            $userJunkRequests = UserJunkRequest::with('userMovingRequestItems', 'User')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
            
            return [$userRequests, $userStorageRequests, $userJunkRequests];
        }
        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function estimated_fare(Request $request){
        \Log::info('Estimate', $request->all());
        $this->validate($request,[
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
            ]);

        try{

            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".Setting::get('map_key');

            $json = curl($details);

            $details = json_decode($json, TRUE);

            $meter = $details['rows'][0]['elements'][0]['distance']['value'];
            $time = $details['rows'][0]['elements'][0]['duration']['text'];
            $seconds = $details['rows'][0]['elements'][0]['duration']['value'];

            $kilometer = round($meter/1000);
            $minutes = round($seconds/60);

            $tax_percentage = Setting::get('tax_percentage');
            $commission_percentage = Setting::get('commission_percentage');
            $service_type = ServiceType::findOrFail($request->service_type);
            
            $price = $service_type->fixed;

            if($service_type->calculator == 'MIN') {
                $price += $service_type->minute * $minutes;
            } else if($service_type->calculator == 'HOUR') {
                $price += $service_type->minute * 60;
            } else if($service_type->calculator == 'DISTANCE') {
                $price += ($kilometer * $service_type->price);
            } else if($service_type->calculator == 'DISTANCEMIN') {
                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
            } else if($service_type->calculator == 'DISTANCEHOUR') {
                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
            } else {
                $price += ($kilometer * $service_type->price);
            }

            $tax_price = ( $tax_percentage/100 ) * $price;
            $total = $price + $tax_price;

            $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)->get()->pluck('provider_id');

            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->s_latitude;
            $longitude = $request->s_longitude;

            $Providers = Provider::whereIn('id', $ActiveProviders)
                ->where('status', 'approved')
                ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->get();

            $surge = 0;
            
            if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
                $surge_price = (Setting::get('surge_percentage')/100) * $total;
                $total += $surge_price;
                $surge = 1;
            }

            /*
            * Reported by Jeya, previously it was hardcoded. we have changed as based on surge percentage.
            */ 
            $surge_percentage = 1+(Setting::get('surge_percentage')/100)."X";

            return response()->json([
                    'estimated_fare' => round($total,2), 
                    'distance' => $kilometer,
                    'time' => $time,
                    'surge' => $surge,
                    'surge_value' => $surge_percentage,
                    'tax_price' => $tax_price,
                    'base_price' => $service_type->fixed,
                    'wallet_balance' => Auth::user()->wallet_balance
                ]);

        } catch(Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function trip_details(Request $request) {

         $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);
    
        try{
            $UserRequests = UserRequests::UserTripDetails(Auth::user()->id,$request->request_id)->get();
            if(!empty($UserRequests)){
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=".$value->s_latitude.",".$value->s_longitude.
                            "&markers=".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=AIzaSyAU_wVxqJqy7HFuLXlcSRxeQkAbJJTWJdE";
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * get all promo code.
     *
     * @return Response
     */

    public function promocodes() {
        try{
            $this->check_expiry();

            return PromocodeUsage::Active()
                    ->where('user_id', Auth::user()->id)
                    ->with('promocode')
                    ->get();

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    } 


    public function check_expiry(){
        try{
            $Promocode = Promocode::all();
            foreach ($Promocode as $index => $promo) {
                if(date("Y-m-d") > $promo->expiration){
                    $promo->status = 'EXPIRED';
                    $promo->save();
                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'EXPIRED']);
                }else{
                    PromocodeUsage::where('promocode_id', $promo->id)
                            ->where('status','<>','USED')
                            ->update(['status' => 'ADDED']);

                    PromocodePassbook::create([
                            'user_id' => Auth::user()->id,
                            'status' => 'ADDED',
                            'promocode_id' => $promo->id
                        ]);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * add promo code.
     *
     * @return Response
     */

    public function add_promocode(Request $request) {

        $this->validate($request, [
                'promocode' => 'required|exists:promocodes,promo_code',
            ]);

        try{

            $find_promo = Promocode::where('promo_code',$request->promocode)->first();

            if($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_expired'), 
                        'code' => 'promocode_expired'
                    ]);

                }else{
                    return back()->with('flash_error', trans('api.promocode_expired'));
                }

            }elseif(PromocodeUsage::where('promocode_id',$find_promo->id)->where('user_id', Auth::user()->id)->whereIN('status',['ADDED','USED'])->count() > 0){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_already_in_use'), 
                        'code' => 'promocode_already_in_use'
                        ]);

                }else{
                    return back()->with('flash_error', 'Promocode Already in use');
                }

            }else{

                $promo = new PromocodeUsage;
                $promo->promocode_id = $find_promo->id;
                $promo->user_id = Auth::user()->id;
                $promo->status = 'ADDED';
                $promo->save();

                PromocodePassbook::create([
                            'user_id' => Auth::user()->id,
                            'status' => 'ADDED',
                            'promocode_id' => $find_promo->id
                        ]);

                if($request->ajax()){

                    return response()->json([
                            'message' => trans('api.promocode_applied') ,
                            'code' => 'promocode_applied'
                         ]); 

                }else{
                    return back()->with('flash_success', trans('api.promocode_applied'));
                }
            }

        }

        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something Went Wrong');
            }
        }

    } 

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function upcoming_trips() {
    
        try{
            $userRequests = UserMovingRequest::with('userMovingRequestItems', 'User')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
    
            $userStorageRequests = UserStorageRequest::with('userMovingRequestItems', 'User')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
    
            $userJunkRequests = UserJunkRequest::with('userMovingRequestItems', 'User')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
    
            return [$userRequests, $userStorageRequests, $userJunkRequests];
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function upcoming_trip_details(Request $request) {

         $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);
    
        try{
            $UserRequests = UserRequests::UserUpcomingTripDetails(Auth::user()->id,$request->request_id)->get();
            if(!empty($UserRequests)){
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=".$value->s_latitude.",".$value->s_longitude.
                            "&markers=".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=AIzaSyAU_wVxqJqy7HFuLXlcSRxeQkAbJJTWJdE";
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }


    /**
     * Show the nearby providers.
     *
     * @return Response
     */

    public function show_providers(Request $request) {

        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'service' => 'numeric|exists:service_types,id',
            ]);

        try{

            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            if($request->has('service')){

                $ActiveProviders = ProviderService::AvailableServiceProvider($request->service)
                                    ->get()->pluck('provider_id');

                $Providers = Provider::with('service')->whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();

            } else {

                $ActiveProviders = ProviderService::where('status', 'active')
                                    ->get()->pluck('provider_id');

                $Providers = Provider::with('service')->whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();
            }

        
            return $Providers;

        } catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.');
            }
        }
    }


    /**
     * Forgot Password.
     *
     * @return Response
     */


    public function forgot_password(Request $request){

        $this->validate($request, [
                'email' => 'required|email|exists:users,email',
            ]);

        try{  
            
            $user = User::where('email' , $request->email)->first();

            $otp = mt_rand(100000, 999999);

            $user->otp = $otp;
            $user->save();
            
            $to = $request->email;
            $subject = "Password Reset";
            
            $message = "
            <html>
            <head>
            <title>Password Reset</title>
            </head>
            <body>
            Dear Sir,<br>
            <p>You are receiving this email because we received a password reset request for your account. Your OTP is.</p>
            <p><strong>".$otp."</strong></p>
            <p>If you did not request a password reset, no further action is required.</p>
            <br><br>
            Kind Regards,<br>
            Fidarides.pk
            </body>
            </html>
            ";
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <no-reply@Fidarides.pk>' . "\r\n";
           // $headers .= 'Cc: myboss@example.com' . "\r\n";
            
            mail($to,$subject,$message,$headers);
            
            //Notification::send($user, new ResetPasswordOTP($otp));

            return response()->json([
                'message' => 'OTP sent to your email!',
                'user' => $user
            ]);

        }catch(Exception $e){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Reset Password.
     *
     * @return Response
     */

    public function reset_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'id' => 'required|numeric|exists:users,id'

            ]);

        try{

            $User = User::findOrFail($request->id);
            // $UpdatedAt = date_create($User->updated_at);
            // $CurrentAt = date_create(date('Y-m-d H:i:s'));
            // $ExpiredAt = date_diff($UpdatedAt,$CurrentAt);
            // $ExpiredMin = $ExpiredAt->i;
            $User->password = bcrypt($request->password);
            $User->save();
            if($request->ajax()) {
                return response()->json(['message' => 'Password Updated']);
            }
           
            

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }

    /**
     * help Details.
     *
     * @return Response
     */

    public function help_details(Request $request){

        try{

            if($request->ajax()) {
                return response()->json([
                    'contact_number' => Setting::get('contact_number',''), 
                    'contact_email' => Setting::get('contact_email','')
                     ]);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }


    /**
     * Show the email availability.
     *
     * @return Response
     */

    public function verify(Request $request)
    {
        $this->validate($request, [
                'email' => 'required|email|max:255|unique:users',
            ]);

        try{
            
            return response()->json(['message' => trans('api.email_available')]);

        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }



    /**
     * Show the wallet usage.
     *
     * @return Response
     */

    public function wallet_passbook(Request $request)
    {
        try{
            
            return WalletPassbook::where('user_id',Auth::user()->id)->get();

        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Show the promo usage.
     *
     * @return Response
     */

    public function promo_passbook(Request $request)
    {
        try{
            
            return PromocodePassbook::where('user_id',Auth::user()->id)->with('promocode')->get();

        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

}
