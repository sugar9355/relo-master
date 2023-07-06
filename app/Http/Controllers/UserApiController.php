<?php

namespace App\Http\Controllers;

use Aloha\Twilio\Twilio;
use App\EmailLog;
use App\UserJunkRequest;
use App\UserMovingRequest;
use App\UserSchedule;
use App\Opportunity;
use App\UserStorageRequest;
use App\Truck;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use App;
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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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
		//$number = "03062223332";
		//$number = "03452866202";
		//$message = 'Hello How are you';
		
		//$this->sendMessage($number,$message);
		
		// $validator = Validator::make($request->all(), 
		// [
			// 'device_id' => 'required',
			// 'first_name' => 'required|max:255',
			// 'last_name' => 'required|max:255',
			// 'email' => 'required|email|max:255|unique:users',
			// 'mobile' => 'required|unique:users',
			// 'role' => 'required|in:captain,helper,technician',
		// ]);
		
		// if ($validator->fails()) 
		// {
			// $messages = '';
			// foreach($validator->errors()->messages() as $key => $error)
			// {
				// $messages .= $error[0] . '<br>' ;
			// }
			
			$response = array('status' => 0, 'message' => 123);
			return response()->json([array('response' => $response)], 500);
		// }
		
    }

    public function signup(Request $request)
    {
		
		$validator = Validator::make($request->all(), [
			'device_type' => 'required|in:android,ios',
			'device_token' => 'required',
			'device_id' => 'required|unique:users',
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'mobile' => 'required|unique:users',
			'password' => 'required|min:6',
			'role' => 'required|in:captain,helper,technician',
		]);
		
		if ($validator->fails())
		{
			$messages = '';
			foreach($validator->errors()->messages() as $key => $error)
			{
				$messages .= $error[0] . '<br>' ;
			}
			
			$response = array('status' => 0, 'message' => $messages);
			return response()->json([array('response' => $response)], 500);
		}
		
		try
		{
			
            $User = $request->all();
            $User['payment_mode'] = 'CASH';
			$User['hourly_rate'] = Opportunity::GetCurrentHourlyRate(array('role'=>$request->role))->first()->hourly_rate;
            $c['password'] = bcrypt($request->password);
			
			DB::beginTransaction();
			
				$User = User::create($User);
				
				$role['user_id'] = $User->id;
				$role['role_id'] = Role::where('name',$request->role)->first()->id;
				$role['created_at'] = time();
				$role['updated_at'] = time();
			
				User::insertRole($role);
				
			
			DB::commit();
			
			$response = array('status' => 1, 'message' => 'success');
			return response()->json([array('user_info' => $User,'response' => $response)], 200);
            
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
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
		try
		{
           $user =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			
			if(!empty($user))
			{
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('driver_details' => $user,'response' => $response)], 200);
			}
			else
			{
				$response = array('status' => 0, 'message' => 'User Not Found');
				return response()->json([array('response' => $response)], 500);
			}
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function helper_details(Request $request)
    {
		try
		{
           $user =  User::GetUserProfileByDeviceId($request->device_id,5)->first();
			
			if(!empty($user))
			{
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('driver_details' => $user,'response' => $response)], 200);
			}
			else
			{
				$response = array('status' => 0, 'message' => 'User Not Found');
				return response()->json([array('response' => $response)], 500);
			}
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function technician_details(Request $request)
    {
		try
		{
           $user =  User::GetUserProfileByDeviceId($request->device_id,6)->first();
			
			if(!empty($user))
			{
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('driver_details' => $user,'response' => $response)], 200);
			}
			else
			{
				$response = array('status' => 0, 'message' => 'User Not Found');
				return response()->json([array('response' => $response)], 500);
			}
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
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
				return response()->json([array('available_jobs' => $available_jobs,'response' => $response)], 200);
				
			}
			else
			{
				$response = array('status' => 0, 'message' => 'Jobs Not Found');
				return response()->json([array('response' => $response)], 500);
			}
            
        } 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }

    }
	
	public function job_assigned(Request $request)
    {
		try
		{
			$this->validate($request, ['role' => 'required|in:captain,helper,technician']);
			
			$role_id = Role::where('name',$request->role)->first()->id;
			$captain =  User::GetUserProfileByDeviceId($request->device_id,$role_id)->first();
			
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
				
				$helpers =  UserMovingRequest::GetAvailableHelpers()->get();
				$technician =  UserMovingRequest::GetAvailableTechnician()->get();
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('job_assigned'=>$job_assigned,'helpers'=> $helpers,'technician'=>$technician,'response' => $response)], 200);
				
			}
			else
			{
				$response = array('status' => 0, 'message' => 'Jobs Not Found');
				return response()->json([array('response' => $response)], 500);
			}
            
			
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function job_today(Request $request)
    {
		try
		{
			$this->validate($request,['role' => 'required|in:captain,helper,technician']);
			
			$role_id = Role::where('name',$request->role)->first()->id;
			$captain =  User::GetUserProfileByDeviceId($request->device_id,$role_id)->first();
			
			$param['captain_id'] = $captain->id;
			//$param['prefer_date'] = now();
			$job_assigned =  UserMovingRequest::GetAvailableJobs($param)->first();
			
			if(!empty($job_assigned))
			{
				$users_array = array();
				
				$users_array[] = $job_assigned->user_id;
				$users_array[] = $job_assigned->helper_id;
				$users_array[] = $job_assigned->technician_id;
				
				$member = User::whereIn('id',$users_array)->pluck('first_name','id');
			
				$job_assigned->customer = $member[$job_assigned->user_id];
				$job_assigned->helper = isset($member[$job_assigned->helper_id]) ? $member[$user->helper_id] : null;
				$job_assigned->technician = isset($member[$job_assigned->technician_id]) ? $member[$user->technician_id] : null;
				
				$truck =  Truck::where('id',$job_assigned->truck_id)->first();
				$available_helpers =  UserMovingRequest::GetAvailableHelpers()->get();
				$available_technician =  UserMovingRequest::GetAvailableTechnician()->get();
				
				$helpers =  UserMovingRequest::GetAvailableHelpers()->get();
				$technician =  UserMovingRequest::GetAvailableTechnician()->get();
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('job_today'=>$job_assigned,'helpers'=> $helpers,'technician'=>$technician,'truck'=>$truck,'response' => $response)], 200);
				
			}
			else
			{
				$response = array('status' => 0, 'message' => 'Job Not Available');
				return response()->json([array('response' => $response)], 500);
			}
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function job_accept(Request $request)
    {
		try
		{
			$this->validate($request, ['booking_id' => 'required']);
			
			DB::beginTransaction();
			
			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			
			$job['captain_id'] = $captain->id;
			$job['updated_at'] = time();
			$job['updated_by'] = $captain->id;
			
			$where['booking_id'] = $request->booking_id;
			$where['captain_id'] = null;
			$where['status'] = 'Pending';
			
			UserMovingRequest::UpdateAssignedJobUsers($job,$where);
		
			DB::commit();
		
			$response = array('status' => 1, 'message' => 'success');
			return response()->json([array('response' => $response)], 200);
			
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function invite_helper(Request $request)
    {
        try
		{
			$this->validate($request, [
                'booking_id' => 'required',
				'captain_id' => 'required',
				'helper_id' => 'required',
            ]);
			
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
		
			$response = array('status' => 1, 'message' => 'success');
			return response()->json([array('response' => $response)], 200);
			
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }

    }
	
	public function invite_technician(Request $request)
    {
        try
		{
			
			$this->validate($request, [
                'booking_id' => 'required',
				'captain_id' => 'required',
				'technician_id' => 'required',
            ]);
			
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
		
			$response = array('status' => 1, 'message' => 'success');
			return response()->json([array('response' => $response)], 200);
			
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function job_schedule(Request $request)
    {
		try
		{
			$this->validate($request, ['role' => 'required|in:captain,helper,technician']);
			
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
					'end_unit' => 'required'
				]);
		   
				DB::beginTransaction();
				
					$role_id = Role::where('name',$request->role)->first()->id;
					$user = User::GetUserProfileByDeviceId($request->device_id,$role_id)->first();
					
					if(isset($request->Mon)){$user_schedules['Mon'] = $request->Mon;}
					if(isset($request->Tue)){$user_schedules['Tue'] = $request->Tue;}
					if(isset($request->Wed)){$user_schedules['Wed'] = $request->Wed;}
					if(isset($request->Thu)){$user_schedules['Thu'] = $request->Thu;}
					if(isset($request->Fri)){$user_schedules['Fri'] = $request->Fri;}
					
					$user_schedules['start_time'] 	= $request->start_time;
					$user_schedules['start_unit'] 	= $request->start_unit;
					$user_schedules['end_time'] 	= $request->end_time;
					$user_schedules['end_unit'] 	= $request->end_unit;
					
					$schedule = UserSchedule::where('user_id',$user->id)->first();
					
					if(!empty($schedule))
					{
						$where['user_id'] = $user->id;
						$user_schedules['updated_at'] = now();
						$user_schedules['updated_by'] = $user->id;
						UserSchedule::where($where)->update($user_schedules);
					}
					else
					{
						$user_schedules['user_id'] = $user->id;
						$user_schedules['created_at'] = now();
						$user_schedules['created_by'] = $user->id;
						$user_schedules['updated_at'] = now();
						$user_schedules['updated_by'] = $user->id;
						UserSchedule::insert($user_schedules);
					}
					
				DB::commit();
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('response' => $response)], 200);

			}
			else
			{
				$role_id = Role::where('name',$request->role)->first()->id;
				$user =  User::where('device_id',$request->device_id,$role_id)->first();
				$schedule = UserSchedule::getSchedule(array('user_id' => $user->id))->first();
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('schedule' => $schedule,'response' => $response)], 200);
			}
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function check_in(Request $request)
    {
		try
		{
			
			$this->validate($request, ['booking_id' => 'required']);
			
			DB::beginTransaction();

			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();
			$booking =  UserMovingRequest::where($request->booking_id)->first();

			if(!empty($captain))
			{	
				$update['shift_start'] = now();
				$update['updated_at'] = time();
				$update['updated_by'] = $captain->id;

				$where['booking_id'] = $request->booking_id;
				$where['captain_id'] = $captain->id;
				$where['status'] = 'Pending';
				$where['shift_start'] = null;

				if(!empty($booking) && $booking->prefer_date == now())
				{
					UserMovingRequest::check_in($update,$where);
					DB::commit();
					$response = array('status' => 1, 'message' => 'success');
					return response()->json([array('response' => $response)], 200);
					
				}
				else
				{
					$response = array('status' => 0, 'message' => 'error');
					return response()->json([array('response' => $response)], 500);
				}
			}
			else
			{
				$response = array('status' => 0, 'message' => 'error');
				return response()->json([array('response' => $response)], 500);
			}
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function check_out(Request $request)
    {
		try
		{
			$this->validate($request, ['booking_id' => 'required']);

			DB::beginTransaction();

			$captain =  User::GetUserProfileByDeviceId($request->device_id,4)->first();

			if(!empty($captain))
			{
				$update['shift_end'] = now();
				$update['status'] = 'Completed';
				$update['updated_at'] = time();
				$update['updated_by'] = $captain->id;

				$where['booking_id'] = $request->booking_id;
				$where['captain_id'] = $captain->id;
				$where['status'] = 'Pending';
				$where['shift_end'] = null;

				UserMovingRequest::check_out($update,$where);
			}

			DB::commit();
			
			$response = array('status' => 1, 'message' => 'success');
			return response()->json([array('response' => $response)], 200);
		
		} 
		catch (Exception $e) 
		{
			$response = array('status' => 0, 'message' => 'error');
			return response()->json([array('response' => $response)], 500);
        }
    }
	
	public function payment_info(Request $request)
    {
		if(isset($request->submit))
		{
			$this->validate($request, 
			[
				//'booking_id' => 'required',
				'role' => 'required|in:captain,helper,technician',
				'beneficiary' => 'required',
				'bank_account' => 'required',
				'paypal_account' => 'required',
				'address' => 'required',
				'country' => 'required',
				'state' => 'required',
				'city' => 'required',
				'zipcode'=> 'required'
			]);

			try
			{
				DB::beginTransaction();

				$role_id = Role::where('name',$request->role)->first()->id;
				$user =  User::GetUserProfileByDeviceId($request->device_id,$role_id)->first();
				
				//$pay['booking_id'] =  $request->booking_id;
				$pay['role_id'] =  $role_id;
				$pay['beneficiary'] =  $request->beneficiary;
				$pay['bank_account'] =  $request->bank_account;
				$pay['paypal_account'] =  $request->paypal_account;
				$pay['address'] =  $request->address;
				$pay['country'] =  $request->country;
				$pay['state'] =  $request->state;
				$pay['city'] =  $request->city;
				$pay['zipcode'] =  $request->zipcode;
				
				$param['user_id'] = $user->id;
				$payment_info = User::GetPaymentInfo($param)->first();
				
				if(!empty($payment_info))
				{
					$pay['updated_at'] = now();
					$pay['updated_by'] = $user->id;
					User::UpdatePaymentInfo($pay);	
				}
				else
				{
					$pay['user_id'] = $user->id;
					$pay['created_at'] = now();
					$pay['updated_at'] = now();
					$pay['created_by'] = $user->id;
					$pay['updated_by'] = $user->id;
					User::InsertPaymentInfo($pay);
				}
				
				DB::commit();
			
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('payment_info' => $pay,'response' => $response)], 200);
			
			} 
			catch (Exception $e) 
			{
				$response = array('status' => 0, 'message' => 'error');
				return response()->json([array('response' => $response)], 500);
			}
		
		}
		else
		{
			try
			{
				$role_id = Role::where('name',$request->role)->first()->id;
				$user =  User::GetUserProfileByDeviceId($request->device_id,$role_id)->first();
				$payment_info = User::GetPaymentInfo( array('user_id'=>$user->id) )->first();
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('payment_info' => $payment_info,'response' => $response)], 200);
			} 
			catch (Exception $e) 
			{
				$response = array('status' => 0, 'message' => 'error');
				return response()->json([array('response' => $response)], 500);
			}
		}
    }
	
	public function refer_user(Request $request)
    {
		if(isset($request->submit))
		{
			// try
			// {
				// $validator = Validator::make($request->all(), 
				// [
					// 'device_id' => 'required',
					// 'first_name' => 'required|max:255',
					// 'last_name' => 'required|max:255',
					// 'email' => 'required|email|max:255|unique:users',
					// 'mobile' => 'required|unique:users',
					// 'role' => 'required|in:captain,helper,technician',
				// ]);
				
				// if ($validator->fails()) 
				// {
					// $messages = '';
					// foreach($validator->errors()->messages() as $key => $error)
					// {
						// $messages .= $error[0] . '<br>' ;
					// }
					
					// $response = array('status' => 0, 'message' => $messages);
					// return response()->json([array('response' => $response)], 500);
				// }
				// else
				// {
					DB::beginTransaction();

					$user = User::where('device_id',$request->device_id)->first();
					
					if(!empty($user))
					{
						$str_random = str_random(15);
						$refer['first_name'] =  $request->first_name;
						$refer['last_name'] =  $request->last_name;
						$refer['email'] =  $request->email;
						$refer['mobile'] =  $request->mobile;
						$refer['refer_id'] =  $user->id;
						$refer['refer_token'] = $str_random;
						$refer['password'] = bcrypt($str_random);
						$refer['created_at'] = now();
						$refer['updated_at'] = now();
						
						User::insert($refer);
						
						$refer_user =  User::where('refer_token',$str_random)->first()->id;
						
						if(!empty($refer_user))
						{
							$role['user_id'] = $refer_user;
							$role['role_id'] = Role::where('name',$request->role)->first()->id;
							$role['created_at'] = time();
							$role['updated_at'] = time();
							
							User::insertRole($role);	
						}
						
						//$this->sendMessage($refer['mobile'],$refer['refer_token']);
						
						DB::commit();		
					}
				
					$response = array('status' => 1, 'message' => 'Request Sent Successfully');
					return response()->json([array('response' => $refer)], 200);
				// }
			
			// } 
			// catch (Exception $e) 
			// {
				// $response = array('status' => 0, 'message' => 'error');
				// return response()->json([array('response' => $response)], 500);
			// }
		}
    }
	
	public function refer_token(Request $request)
    {
		if(isset($request->submit))
		{
			try
			{
				$validator = Validator::make($request->all(), 
				[
					'device_type' => 'required|in:android,ios',
					'device_id' => 'required|unique:users',
					'mobile' => 'required',
					'refer_token' => 'required|min:15',
					//'role' => 'required|in:captain,helper,technician',
					'password' => 'required|min:6',
				]);
				
				if ($validator->fails()) 
				{
					$messages = '';
					foreach($validator->errors()->messages() as $key => $error)
					{
						$messages .= $error[0] . '<br>' ;
					}
					
					$response = array('status' => 0, 'message' => $messages);
					return response()->json([array('response' => $response)], 500);
				}
				else
				{
					DB::beginTransaction();

					$valid_token =  User::where('refer_token',$request->refer_token)->where('mobile',$request->mobile)->first();
					
					if(!empty($valid_token))
					{
						$refer['device_id'] =  $request->device_id;
						$refer['password'] = bcrypt($request->password);
						$refer['updated_at'] = now();
						
						$where['mobile'] =  $request->mobile;
						$where['refer_token'] =  $request->refer_token;
						
						User::where($where)->update($refer);
						
						// $role['user_id'] = $valid_token->id;
						// $role['role_id'] = Role::where('name',$request->role)->first()->id;
						// $role['created_at'] = time();
						// $role['updated_at'] = time();
						
						// User::insertRole($role);
						
						DB::commit();
						
						$response = array('status' => 1, 'message' => 'Token Verified Successfully');
						return response()->json([array('response' => $response)], 200);
						
					}
					else
					{
						$response = array('status' => 0, 'message' => 'error');
						return response()->json([array('response' => $response)], 500);
					}
				}
			} 
			catch (Exception $e) 
			{
				$response = array('status' => 0, 'message' => 'error');
				return response()->json([array('response' => $response)], 500);
			}
		}
    }
	
	public function payment_claim(Request $request)
    {
		// try
		// {
			if(isset($request->submit))
			{
				$validator = Validator::make($request->all(), [
					'device_type' => 'required|in:android,ios',
					'device_token' => 'required',
					'role' => 'required|in:captain,helper,technician',
				]);
				
				if ($validator->fails()) 
				{
					$messages = '';
					foreach($validator->errors()->messages() as $key => $error)
					{
						$messages .= $error[0] . '<br>' ;
					}
					
					$response = array('status' => 0, 'message' => $messages);
					return response()->json([array('response' => $response)], 500);
				}
				else
				{
		   
					DB::beginTransaction();
					
						$role_id = Role::where('name',$request->role)->first()->id;
						$user = User::GetUserProfileByDeviceId($request->device_id,$role_id)->first();
						
						$p['user_id'] = $user->id;
						$p['role_id'] = $role_id;
						$p['payment_recieved'] = true;
						
						$last_payment_recieved = UserSchedule::GetLastPaymentRecievedDate($p)->first();
			
						$param['captain_id'] = $user->id;
						
						if(!empty($last_payment_recieved))
						{
							$param['start_date'] = $last_payment_recieved->end_date;	
						}
						
						$working_hours = UserSchedule::GetWorkingHours($param)->get();
						
						$total_hours = 0;
						foreach($working_hours as $hour)
						{
							$total_hours = $total_hours + $hour->hours;
						}
						
						$p_amount['captain'] = true;
						$employee_amount = UserSchedule::GetAmount($p_amount)->first();
						$total_amount = $total_hours * $employee_amount->captain_per_hour;
						
						$shift_start = $working_hours->first()->shift_start;
						$shift_end = $working_hours->last()->shift_end;
						
						$claim['amount'] 	= $total_amount;
						$claim['hours'] 	= $total_hours;
						
						if(!empty($working_hours))
						{
							$last_claim['user_id'] =  $user->id;
							$last_claim['role_id'] =  $role_id;
							$last_claim['payment_recieved'] = null;
							$payment_claim = UserSchedule::GetLastPaymentRecievedDate($last_claim)->first();
							
							if(!empty($payment_claim))
							{
								$where['user_id'] 	= $user->id;
								$where['role_id'] 	= $role_id;
								
								$claim['updated_at'] = now();
								$claim['updated_by'] = $user->id;
								UserSchedule::UpdatePaymentClaim($claim,$where);
								
								DB::commit();
					
								$response = array('status' => 1, 'message' => 'Claim Request Updated');
								return response()->json([array('response' => $response)], 200);
							}
							else
							{
								$claim['user_id'] = $user->id;
								$claim['role_id'] = $role_id;
								$claim['start_date'] = $shift_start;
								$claim['end_date'] = $shift_end;
								$claim['created_at'] = now();
								$claim['created_by'] = $user->id;
								$claim['updated_at'] = now();
								$claim['updated_by'] = $user->id;
								
								UserSchedule::InsertPaymentClaim($claim);
								
								DB::commit();
					
								$response = array('status' => 1, 'message' => 'Claim Request Sent');
								return response()->json([array('response' => $response)], 200);
							}
						}
						
					
				
				}

			}
			else
			{
				$role_id = Role::where('name',$request->role)->first()->id;
				$user =  User::where('device_id',$request->device_id,$role_id)->first();
				
				$param['captain_id'] = $user->id;
				$param['start_date'] = UserSchedule::GetLastPaymentRecievedDate(array('user_id',$user->id));
				$param['end_date'] = now();
				//$param['groupBy'] = true;
						
				$working_hours = UserSchedule::GetWorkingHours($param)->get();
				
				$total_hours = 0;
				foreach($working_hours as $hour)
				{
					$total_hours = $total_hours + $hour->hours;
				}
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('hours' => $total_hours,'response' => $param)], 200);
			}
		// } 
		// catch (Exception $e) 
		// {
			// $response = array('status' => 0, 'message' => 'error');
			// return response()->json([array('response' => $response)], 500);
        // }
    }
	
	public function job_opportunity(Request $request)
    {
		// try
		// {
            $Opportunity = Opportunity::get();
			
			if(!empty($Opportunity[0]))
			{
				
				$response = array('status' => 1, 'message' => 'success');
				return response()->json([array('Opportunity' => $Opportunity,'response' => $response)], 200);
				
			}
			else
			{
				$response = array('status' => 0, 'message' => 'Opportunity Not Found');
				return response()->json([array('response' => $response)], 500);
			}
            
        // } 
		// catch (Exception $e) 
		// {
			// $response = array('status' => 0, 'message' => 'error');
			// return response()->json([array('response' => $response)], 500);
        // }

    }
	
	public function sendMessage($number,$message)
    {
        if (Str::startsWith($number, 0)) 
		{
            $number = substr($number, 1);
        }
		
        $number = "+92" . $number;
		
		// $accountId = getenv("TWILIO_SID");
		// $token = getenv("TWILIO_AUTH_TOKEN");
		// $fromNumber = getenv("TWILIO_NUMBER");
		
        $accountId = 'ACc5886f183282fbcace065280d142130f';
        $token = '7f03c89f925819851bdf5873e99b3b29';
        $fromNumber = '+16176558341';
		
        $twilio = new Twilio($accountId, $token, $fromNumber);
		$message = $message . 'token : '.$message;
        $twilio->message($number, $message);
		
        // try 
		// {
            // $messageLog = new MessageLog($request->all());
            // $messageLog->save();
            // return response()->json([], 200);
			
        // } 
		// catch (Exception $exception) 
		// {
            // return response()->json([], 500);
        // }
    }

}
