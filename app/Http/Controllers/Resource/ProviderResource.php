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
use App\Role;
use App\Level;
use App\Designation;
use App\Provider;
use App\UserSchedule;
use App\UserRequestPayment;
use App\UserRequests;
use App\Booking;
use App\Helpers\Helper;

class ProviderResource extends Controller
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
        $employees =  User::GetAllEmployee()->get();
        
        $p_amount['captain'] = true;
        // $employee_amount = UserSchedule::GetAmount($p_amount)->first();
        // //dd($employee_amount);
        // if(!empty($employee_amount))
        // {
            // foreach($employees as $key => $val)
            // {
                // $employees[$key]->employee_amount = $val->hours * $employee_amount->captain_per_hour;
                // $employees[$key]->unit = $employee_amount->unit;
            // }
        // }
        
        // $AllProviders = Provider::with('service','accepted','cancelled')->orderBy('id', 'DESC');

        // if(request()->has('fleet'))
        // {
            // $providers = $AllProviders->where('fleet',$request->fleet)->get();
        // }
        // else
        // {
            // $providers = $AllProviders->get();
        // }
                    
        return view('admin.providers.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get roles information
        $roles = DB::table('roles')->select('id', 'name')->where(['operator' => '1'])->get()->toArray();

        // Get levels information
        $levels = DB::table('levels')->select('id', 'level')->orderBy('level')->get()->toArray();
        return view('admin.providers.create', compact('roles', 'levels'));
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
            'email' => 'required|unique:providers,email|email|max:255',
            'mobile' => 'digits_between:6,13',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'level' => 'required',
        ]);

        // try{

            $provider = $request->all();

            $provider['password'] = bcrypt($request->password);
            if($request->hasFile('avatar')) {
                //$provider['avatar'] = $request->avatar->store('provider/profile');
                $provider['avatar'] = Helper::upload_picture($request->avatar);
            }
            
            $provider['hourly_rate'] = (empty($request->hourly_rate)) ? (Role::where(['id' => $request->role])->select('hourly_rate')->get()->toArray()[0]['hourly_rate']) : $request->hourly_rate;

            DB::beginTransaction();
            $provider = User::create($provider);
            $user_id = $provider->id;

            // Set data for user's role table
            $role['user_id'] = $provider->id;
            $role['role_id'] = $request->role;
            $role['created_at'] = time();
            $role['updated_at'] = time();

            User::insertRole($role);

            // Set data for user's level table
            $level['user_id'] = $provider->id;
            $level['level_id'] = $request->level;
            $level['level_name'] = 'Level-' . Level::where(['id' => $request->level])->select('level')->get()->toArray()[0]['level'];
            $level['level'] = Level::where(['id' => $request->level])->select('level')->get()->toArray()[0]['level'];
            $level['bonus'] = Level::where(['id' => $request->level])->select('bonus')->get()->toArray()[0]['bonus'];
            $level['hours'] = '';

            DB::table('user_level')->insert($level);
            
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
            return view('admin.providers.provider-details', compact('provider'));
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
            
            $param['user_id'] = $id;
            $employee = User::GetUserWithRole($param)->first();

            $schedule = UserSchedule::where('user_id',$id)->first();
            
            $param['user_id'] = $id;
            //$payment_info = User::GetPaymentInfo($param)->first();
            $payment_info = array();
            
            $referal = User::where('refer_id',$id)->select('id','first_name','last_name','email','mobile','gender','device_id','refer_token','created_at','updated_at')->get();

            $weeks = array('Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday','Sun'=>'Sunday');
            
            
            //=======================================================================
            //                         User Working Hours
            //=======================================================================
                $working_hours = UserSchedule::GetWorkingHours(array('captain_id'=>$id))->get();
                $last_claim = UserSchedule::GetLastPaymentRecievedDate(array('user_id'=>$id))->first();

                $hours = 0;
                foreach($working_hours as $total_hour)
                {
                    $hours = $hours + $total_hour->hours;
                }
                
                $total_amount = $hours * $employee->hourly_rate;
                
                $level = Level::get();
                
                $employee_level = 0;
                foreach($level as $lvl)
                {
                    if($hours >= $lvl->hours)
                    {
                        $employee_level = $lvl->level;
                    }
                }
                
                $my_badges = Designation::GetUserAssignedBadges(array('user_id'=>$id))->get();
                
                $user_role = User::GetUserRoleByUserId($id)->first()->role_id;
                
                // Get Badges According to User Role
                $badges = Designation::get();
                $available_badges = array();
                foreach ($badges as $badge) {
                    if (in_array($user_role, explode(',', $badge->roles))) {
                        array_push($available_badges, $badge);
                    }
                }
                
                // if($employee->role_name == 'captain')
                // {
                //     $available_badges = Designation::where('role_A',$user_role)->get();    
                // }
                // elseif($employee->role_name == 'helper')
                // {
                //     $available_badges = Designation::where('role_B',$user_role)->get();    
                // }
                // elseif($employee->role_name == 'technician')
                // {
                //     $available_badges = Designation::where('role_C',$user_role)->get();    
                // }
                
                //dd($available_badges->all());
            //=======================================================================
            
            
            //=======================================================================
            //=========================== Refer User ================================
            //=======================================================================
                $refer_user = User::where('refer_id',$id)->get();
                $ref_detail = array();
                $refer_working_hours = array();
                if(isset($refer_user[0]))
                {
                    foreach($refer_user as $usr)
                    {
                        $helper_ids[] = $usr->id;
                        //$tech_ids[] = $usr->id;
                    }
                    $p['refer_ids'] = $helper_ids;
                    
                    // Refer User Working Hours 
                    $refer_working_hours = UserSchedule::GetWorkingHours($p)->get();
                    
                    if(isset($refer_working_hours[0]))
                    {
                        $ref_hours = 0;
                        
                        // Refral Hours
                        foreach($refer_working_hours as $ref_w_h)
                        {
                            $ref_detail[$ref_w_h->helper_id]['hours'] = $ref_hours = $ref_hours + $ref_w_h->hours;
                        }
                    
                        foreach($level as $lvl)
                        {
                            if($ref_detail[$ref_w_h->helper_id]['hours'] >= $lvl->hours)
                            {
                                $ref_detail[$ref_w_h->helper_id]['bonus'] = $lvl->bonus;
                            }
                        }
                        
                        // Refral User name
                        foreach($ref_detail as $k => $v)
                        {
                            foreach($refer_user as $usr)
                            {
                                if($k == $usr->id)
                                {
                                    $ref_detail[$k]['refer_user_id'] = $usr->id;
                                    $ref_detail[$k]['refer_user'] = $usr->first_name .' '. $usr->last_name;
                                }
                            }
                        }
                    }
                }
                
            //=======================================================================

            // Get roles information
            $roles = DB::table('roles')->select('id', 'name')->where(['operator' => '1'])->get()->toArray();

            // Get levels information
            $levels = DB::table('levels')->select('id', 'level')->orderBy('level')->get()->toArray();
            $demand_types = DB::table('customer_demand')->select('*')->get();
            foreach ($demand_types as $demand) {
                $rate_data = DB::table('user_demand_rate')->where([
                    'user_id' => $id,
                    'demand_id' => $demand->id
                    ])->select('rate')->get()->first();
                if ($rate_data == null) {
                    $demand->rate = 0;
                } else {
                    $demand->rate = ($rate_data->rate) ? $rate_data->rate : 0;
                }
            }

            // Get scheduled time for a working for the calendar

            $scheduled_time = UserSchedule::where('user_id', $id)->first();

            if (isset($scheduled_time)) {
                $available_days = array();
                if ($scheduled_time->Mon) {
                    array_push($available_days, 1);
                }
                if ($scheduled_time->Tue) {
                    array_push($available_days, 2);
                }
                if ($scheduled_time->Wed) {
                    array_push($available_days, 3);
                }
                if ($scheduled_time->Thu) {
                    array_push($available_days, 4);
                }
                if ($scheduled_time->Fri) {
                    array_push($available_days, 5);
                }
                if ($scheduled_time->Sat) {
                    array_push($available_days, 6);
                }
                if ($scheduled_time->Sun) {
                    array_push($available_days, 7);
                }

                $available_end_time = date('H:i', strtotime($scheduled_time->end_time . $scheduled_time->end_unit));
                $available_start_time = date('H:i', strtotime($scheduled_time->start_time . $scheduled_time->start_unit));

            } else {
                $available_days = [1, 2, 3, 4, 5, 6, 7];
                $available_end_time = '24:00';
                $available_start_time = '00:00';
            }

            // Get assigned times for the calendar
            $field_name = $employee->role_name . '_id';
            $assigned_time = DB::table('job_assigned_users')->where($field_name, $id)->get();
            $booked_times = array();
            if (isset($assigned_time)) {
                foreach($assigned_time as $i) {
                    $item = array();
                    $b = Booking::where('booking_id', $i->booking_id)->first();
                    if (isset($b) && ($b->step == 0)) {
                        $item['title'] = 'booking:' . $b->booking_id;
                        $item['start'] = $b->booking_date . ' ' . date('H:i', strtotime($b->start_time));
                        $item['end'] = $b->booking_date . ' ' . date('H:i', strtotime($b->end_time));
                        array_push($booked_times, $item);
                    }
                }
                $booked_times = json_encode($booked_times);
            }

            return view('admin.providers.edit',compact('roles', 'levels', 'available_badges', 'employee', 'schedule','payment_info','level','weeks','referal','employee_level','my_badges','ref_detail','working_hours','refer_working_hours','last_claim','hours','total_amount', 'demand_types', 'available_days', 'available_start_time', 'available_end_time', 'booked_times'));
            
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
        $user = User::findOrFail($id);
        
            if(isset($request->update_employee))
            {
                $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'mobile' => 'digits_between:6,13',
                'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
                ]);

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
                $role_id = $request->role;
                $level_id = $request->level;
                $updated_level_info = DB::table('levels')->select('name', 'level')->where(['id' => $level_id])->get()->toArray()[0];
                DB::table('user_level')->where(["user_id" => $id])->update(array(
                    "level_id" => $level_id,
                    "level" => $updated_level_info->level,
                    "level_name" => $updated_level_info->name,
                ));
                DB::table('role_user')->where(["user_id" => $id])->update(["role_id" => $role_id]);
                
            }
        
            if($request->update_badge == true)
            {
                $designation = Designation::where('id',$request->id)->first();
                
                $badge['user_id'] = $id;
                $badge['badge_id'] =  $designation->id;
                $badge['badge_name'] =  "'".$designation->name."'";
                
                if($designation->bouns > 0)
                {
                    $badge['bonus'] =  $designation->bouns;    
                }
                else
                {
                    $badge['bonus'] =  0;    
                }
                
                $badge['hours'] = 0;
                $badge['created_at'] =  "'".now()."'";
                $badge['updated_at'] = "'".now()."'";
                
                $values = '';
                foreach($badge as $k => $v)
                {
                    $values .= $v .',' ;
                }
                
                $values = rtrim($values,',');
                
                Designation::UpdateUserBadges($values);
                
                return redirect()->back()->withInput(array('model_open'=>true));
            }
            
            if($request->delete_badge == true)
            {
                $where['user_id'] = $id;
                $where['badge_id'] = $request->id;
                Designation::DeleteUserBadges($where);
                
                return redirect()->back()->withInput(array('model_open'=>true));
            }
            
            if($request->update_claim == true)
            {
                $where['user_id']     = $id;
                $where['role_id'] = User::GetUserRoleByUserId($id)->first()->role_id;
                
                $claim['payment_recieved'] = $request->amount;
                $claim['updated_at'] = now();
                $claim['updated_by'] = $id;
                
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
            User::find($id)->delete();
            // dd($id);
            return back()->with('message', 'Provider deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Provider Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        try {
            $Provider = Provider::findOrFail($id);
            if($Provider->service) {
                $Provider->update(['status' => 'approved']);
                return back()->with('flash_success', "Provider Approved");
            } else {
                return redirect()->route('admin.provider.document.index', $id)->with('flash_error', "Provider has not been assigned a service type!");
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', "Something went wrong! Please try again later.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        
        Provider::where('id',$id)->update(['status' => 'banned']);
        return back()->with('flash_success', "Provider Disapproved");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function request($id){

        try{

            $requests = UserRequests::where('user_requests.provider_id',$id)
                    ->RequestHistory()
                    ->get();

            return view('admin.request.index', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function schedule($id){


            $param['crew'] = $id;
            $schedule = Booking::get_booking($param)->get();
            $calender = Helper::GetCelender(date("Y"),true,true);
            
            // echo '<pre>';
            // print_r($calender);
            // echo '</pre>';
            // die;
            
            $hours = DB::table('booking_form')
            ->where('start_time','<>','')->where('end_time','<>','')->whereRaw('crew like "%'.$id.'%"')
            ->selectRaw('year(booking_date) as year,month(booking_date) as month,weekday(booking_date) as w,DAY(booking_date) as day,group_concat(concat(start_time,"-",end_time)) as slote')
            ->groupBy('booking_date')
            ->get();
            
            $slote = array();
            $index = 1;
            foreach($calender as $month => $value)
            {
                if($month == Intval(date('m')))
                {
                    foreach ($value as $w =>$week) 
                    {
                        foreach ($week as $d =>$day)
                        {
                            $slote[$index]['m'] = $month;
                            $slote[$index]['w'] = $day[2];
                            $slote[$index]['d'] = $day[0];
                            $slote[$index]['s'] = '';
                            foreach ($hours as $h =>$hour)
                            {
                                if($hour->month == $month && $hour->day == $day[0])
                                {
                                    $slote[$index]['m'] = $month;
                                    $slote[$index]['w'] = $day[2];
                                    $slote[$index]['d'] = $day[0];
                                    $slote[$index]['s'] = '';
                                    $slote[$index]['s'] = $hour->slote;
                                }
                            }
                            $index = $index + 1;
                        }    
                    }    
                }
            }
            
            $hours = array('6'=>1,'7'=>2,'8'=>3,'9'=>4,'10'=>5,'11'=>6,'12'=>7,'1'=>8,'2'=>9,'3'=>10,'4'=>11,'5'=>12);
            $mode = array('6'=>'AM','7'=>'AM','8'=>'AM','9'=>'AM','10'=>'AM','11'=>'AM','12'=>'AM','1'=>'AM','2'=>'AM','3'=>'AM','4'=>'AM','5'=>'AM');
            $dhours  = array_flip($hours);
            
            // echo '<pre>';
            // print_r($slote);
            // echo '</pre>';
            // die;
            
            foreach($slote as $k => $time)
            {
                if(!empty($time['s']))
                {
                    $segments = explode(",",$time['s']);
                    
                    $slote[$k]['n'] = array();
                    
                    foreach($segments as $seg)
                    {
                        $s = explode("-",$seg);
                        
                        $time = explode(" ", $s[0]);
                        $h = explode(":", $time[0])[0];
                        $m = explode(":", $time[0])[1];
                        $start_mm = ($hours[$h] * 60) + $m;    
                    
                        $time = explode(" ", $s[1]);
                        $h = explode(":", $time[0])[0];
                        $m = explode(":", $time[0])[1];
                        $end_mm = ($hours[$h] * 60) + $m; 
                        
                        $slote[$k]['n'][]  = $start_mm .'-'. $end_mm;
                    }
                    
                    $slote[$k]['n'] = implode(',',$slote[$k]['n']);
                    
                }
            }
            
            return view('admin.user_schedule.index', compact('schedule','calender','hours','slote'));

    }

    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement($id){

        try{

            $requests = UserRequests::where('provider_id',$id)
                        ->where('status','COMPLETED')
                        ->with('payment')
                        ->get();

            $rides = UserRequests::where('provider_id',$id)->with('payment')->orderBy('id','desc')->paginate(10);
            $cancel_rides = UserRequests::where('status','CANCELLED')->where('provider_id',$id)->count();
            $Provider = Provider::find($id);
            $revenue = UserRequestPayment::whereHas('request', function($query) use($id) {
                                    $query->where('provider_id', $id );
                                })->select(\DB::raw(
                                   'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission' 
                               ))->get();


            $Joined = $Provider->created_at ? '- Joined '.$Provider->created_at->diffForHumans() : '';

            return view('admin.providers.statement', compact('rides','cancel_rides','revenue'))
                        ->with('page',$Provider->first_name."'s Overall Statement ". $Joined);

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Accountstatement($id){

        try{

            $requests = UserRequests::where('provider_id',$id)
                        ->where('status','COMPLETED')
                        ->with('payment')
                        ->get();

            $rides = UserRequests::where('provider_id',$id)->with('payment')->orderBy('id','desc')->paginate(10);
            $cancel_rides = UserRequests::where('status','CANCELLED')->where('provider_id',$id)->count();
            $Provider = Provider::find($id);
            $revenue = UserRequestPayment::whereHas('request', function($query) use($id) {
                                    $query->where('provider_id', $id );
                                })->select(\DB::raw(
                                   'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission' 
                               ))->get();


            $Joined = $Provider->created_at ? '- Joined '.$Provider->created_at->diffForHumans() : '';

            return view('account.providers.statement', compact('rides','cancel_rides','revenue'))
                        ->with('page',$Provider->first_name."'s Overall Statement ". $Joined);

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function set_working_time(Request $request, $id) {
        $temp = UserSchedule::where('user_id', $id)->delete();
        $updates = array(
            'user_id' => $id,
            'start_time' => explode(' ', date('h:i a', strtotime($request->start_time)))[0],
            'start_unit' => strtoupper(explode(' ', date('h:i a', strtotime($request->start_time)))[1]),
            'end_time' => explode(' ', date('h:i a', strtotime($request->end_time)))[0],
            'end_unit' => strtoupper(explode(' ', date('h:i a', strtotime($request->end_time)))[1]),
        );
        foreach ($request->days as $day) {
            switch ($day) {
                case 1:
                    $updates['Mon'] = 1;
                    break;
                case 2:
                    $updates['Tue'] = 1;
                    break;
                case 3:
                    $updates['Wed'] = 1;
                    break;
                case 4:
                    $updates['Thu'] = 1;
                    break;
                case 5:
                    $updates['Fri'] = 1;
                    break;
                case 6:
                    $updates['Sat'] = 1;
                    break;
                case 7:
                    $updates['Sun'] = 1;
                    break;
            }
        }

        UserSchedule::insert($updates);

        return back();

    }
}
