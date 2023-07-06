<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Exception;
use Setting;
use Storage;
use Auth;
use App\User;
use App\Provider;
use App\EmployeeRate;
use App\UserSchedule;
use App\UserRequestPayment;
use App\UserRequests;
use App\Helpers\Helper;

class EmployeeRates extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!Helper::authorized('captains')){
            return abort(404);
        }
        
        $this->middleware('demo', ['only' => [ 'store', 'update', 'destroy', 'disapprove']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$rates = EmployeeRate::where('status',1)->get();
		            
        return view('admin.employee_rate.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employee_rate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	
		
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:employee_rate,email|email|max:255',
            'mobile' => 'digits_between:6,13',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
        ]);

        // try{

            $provider = $request->all();

            $provider['password'] = bcrypt($request->password);
            if($request->hasFile('avatar')) {
                //$provider['avatar'] = $request->avatar->store('provider/profile');
                $provider['avatar'] = Helper::upload_picture($request->avatar);
            }

			DB::beginTransaction();
            $provider = User::create($provider);
			
			
			$update['user_id'] = $provider->id;

			$update['Mon'] = $request->monday;
			$update['Tue'] = $request->tuesday;
			$update['Wed'] = $request->wednesday;
			$update['Thu'] = $request->thursday;
			$update['Fri'] = $request->friday;
			$update['time'] = $request->hours.''.$request->unit;

			$update['created_at'] = time();
			$update['update_at'] = time();
			$update['created_by'] = 1;
			$update['update_by'] = 1;

			UserSchedule::create($update);
			
			DB::commit();

            return back()->with('flash_success','Provider Details Saved Successfully');

        // } 

        // catch (Exception $e) {
            // return back()->with('flash_error', 'Provider Not Found');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $provider = Provider::findOrFail($id);
            return view('admin.employee_rate.provider-details', compact('provider'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try 
		{
			$join['payment_claim'] = true;
			
            $employee = User::GetAllCaptains(null,$join)->first();
			$schedule = UserSchedule::where('user_id',$id)->first();
			
			$param['user_id'] = $id;
			//$payment_info = User::GetPaymentInfo($param)->first();
			$payment_info = array();
			
			$referal = User::where('refer_id',$id)->select('id','first_name','last_name','email','mobile','gender','device_id','refer_token','created_at','updated_at')->get();
			
			$weeks = array('Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday','Sun'=>'Sunday');
			
			$working_hours = UserSchedule::GetWorkingHours('captain_id',$id)->get();
			
			$last_claim = UserSchedule::GetLastPaymentRecievedDate('user_id',$id)->first();
			
			$hours = 0;
			foreach($working_hours as $total_hour)
			{
				$hours = $hours + $total_hour->hours;
			}
			
			$p_amount['captain'] = true;
			$employee_amount = UserSchedule::GetAmount($p_amount)->first();
			
			if(!empty($employee_amount))
			{
				$total_amount = $hours * $employee_amount->captain_per_hour;
			}
			else
			{
				$total_amount = 0;
			}
			
			$refer_user = User::where('refer_id',$id)->get();
			$ref_hours_arr = array();
			$refer_working_hours = array();
			if(isset($refer_user[0]))
			{
				foreach($refer_user as $usr)
				{
					$helper_ids[] = $usr->id;
					//$tech_ids[] = $usr->id;
				}
				$p['refer_ids'] = $helper_ids;
				
				$refer_working_hours = UserSchedule::GetWorkingHours($p)->get();
				
				$ref_hours = 0;
				foreach($refer_working_hours as $ref_w_h)
				{
					$ref_hours_arr[$ref_w_h->helper_id]['minutes'] = $ref_hours = $ref_hours + $ref_w_h->minutes;
				}
				
				foreach($ref_hours_arr as $k => $v)
				{
					foreach($refer_user as $usr)
					{
						if($k == $usr->id)
						{
							$ref_hours_arr[$k]['refer_user'] = $usr->first_name .' '. $usr->last_name;
						}
					}
				}
			}
			
            return view('admin.employee_rate.edit',compact('employee','schedule','payment_info','weeks','referal','ref_hours_arr','working_hours','refer_working_hours','last_claim','employee_amount','hours','total_amount'));
			
        } 
		catch (ModelNotFoundException $e) 
		{
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	
		if(isset($request->update_hourly_rate))
		{
			$user = User::findOrFail($id);
			// $demand_rates = json_decode($request->demand_rates, true);
			// DB::table('user_demand_rate')->where([
			// 	'user_id' => $id,
			// ])->delete();
			// foreach ($demand_rates as $rate) {
			// 	DB::table('user_demand_rate')->insert([
			// 		'user_id' => $id,
			// 		'demand_id' => $rate['demand_id'],
			// 		'rate' => $rate['rate'],
			// 	]);
			// }
			$user->hourly_rate = $request->hourly_rate;
			$user->update();
		}
		
	
		if($request->update_employee == true)
		{
			$this->validate($request, [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'mobile' => 'digits_between:6,13',
			'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
			]);

			
			$user = User::findOrFail($id);

			if($request->hasFile('avatar')) 
			{
				if($user->avatar) 
				{
					Storage::delete($user->avatar);
				}
			
				$user->avatar = Helper::upload_picture($request->avatar);
			}

			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->mobile = $request->mobile;
			$user->save();
			
		}
		
		
		if($request->update_claim == true)
		{
			$where['user_id'] 	= $id;
			$where['role_id'] = User::GetUserRoleByUserId($id)->first()->role_id;
			
			$claim['payment_recieved'] = $request->amount;
			$claim['updated_at'] = now();
			$claim['updated_by'] = $user->id;
			
			UserSchedule::UpdatePaymentClaim($claim,$where);
		}
			
	
		if($request->update_schedule == true)
		{
			$update['user_id'] = $id;
			$schedule = UserSchedule::where('user_id',$update['user_id'])->first();
			
			$update['Mon'] = isset($request->monday) ? $request->monday : 0;
			$update['Tue'] = isset($request->tuesday) ? $request->tuesday : 0;
			$update['Wed'] = isset($request->wednesday) ? $request->wednesday : 0;
			$update['Thu'] = isset($request->thursday) ? $request->thursday : 0;
			$update['Fri'] = isset($request->friday) ? $request->friday : 0;
			
			$update['start_time'] = $request->start_time;
			$update['start_unit'] = $request->start_unit;
			$update['end_time'] = $request->end_time;
			$update['end_unit'] = $request->end_unit;
			
			$update['created_at'] = now();
			$update['updated_at'] = now();
			$update['created_by'] = Auth::user()->id;
			$update['updated_by'] = Auth::user()->id;
			
			if(!empty($schedule))
			{
				UserSchedule::where('user_id',$update['user_id'])->update($update);
			}
			else
			{
				UserSchedule::create($update);
			}
		}
		
		if($request->update_payment_info == true)
		{
			$pay_update['role_id'] = User::GetUserRoleByUserId($id)->first()->role_id;
			$pay_update['beneficiary'] = $request->beneficiary;
			$pay_update['bank_account'] = $request->bank_account;
			$pay_update['paypal_account'] = $request->paypal_account;
			$pay_update['address'] = $request->address;
			$pay_update['country'] = $request->country;
			$pay_update['state'] = $request->state;
			$pay_update['city'] = $request->city;
			$pay_update['zipcode'] = $request->zipcode;
			$pay_update['updated_at'] = now();
			$pay_update['updated_by'] =Auth::user()->id;
			
			$param['user_id'] = $id;
			$payment_info = User::GetPaymentInfo($param)->first();
			
			if(!empty($payment_info))
			{
				$where['user_id'] = $id;
				User::UpdatePaymentInfo($pay_update,$where);
			}
			else
			{
				$pay_update['user_id'] = $id;
				User::InsertPaymentInfo($pay_update);
			}
		}
	
		return redirect()->route('admin.provider.index')->with('flash_success', 'Provider Updated Successfully');    
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            Provider::find($id)->delete();
            return back()->with('message', 'Provider deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Provider Not Found');
        }
    }

}
