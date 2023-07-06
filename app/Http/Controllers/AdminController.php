<?php

namespace App\Http\Controllers;

use App\PercentageSetting;
use App\UserJunkRequest;
use App\UserMovingRequest;
use App\UserStorageRequest;
use App\VehicleSchedule;
use App\VehicleType;
use App\ZoneType;
use App\HubLocation;
use App\Inventory;
use App\Category;
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
use App\Truck;
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

use Twilio\Rest\Client;

use Mailgun\Mailgun;

use Illuminate\Support\Facades\DB;

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
    
    public function PeakFactor(Request $request)
    {
    
    //dd($request->all());
        if (!Helper::authorized('dashboard')) {
            return redirect()->route('admin.profile');
        }
    
        
        $jobs = Booking::get_booking('',array('users'=>true));
        
        if(isset($request->btn_last) || isset($request->btn_next))
        {
            if(isset($request->btn_next))
            {
                $c_date = $request->btn_next;
            }
            if(isset($request->btn_last))
            {
                $c_date = $request->btn_last;
            }
            
            
            $c_date = explode('-',$c_date);
            
            $last_date = date('m-Y', strtotime('-1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));
            
            $last_month = intval(explode('-',$last_date)[0]);
            $last_year = explode('-',$last_date)[1];        
            
            $c_date['last_date'] = $last_month.'-'.$last_year;
            
            
            
            $month = intval(date("m", mktime(0, 0, 0, $c_date[0], 10)));
            $year = $c_date[1];
            $c_date['now_month'] = $month;
            $c_date['now_year'] = $year;
            $c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
            
            $next_date = date('m-Y', strtotime('+1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));
            
            $next_month = intval(explode('-',$next_date)[0]);
            $next_year = explode('-',$next_date)[1];        
            
            $c_date['next_date'] = $next_month.'-'.$next_year;
            
        }
        else
        {    
            $c_date['now_month'] =$month = intval(date('m')); 
            $c_date['now_year'] = $year = date('Y'); 
            $c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
            
            $last_date = date('m-Y', strtotime('-1 month', strtotime(now())));
            
            $c_date['last_month'] = $last_month = intval(explode('-',$last_date)[0]);
            $c_date['last_year'] = $last_year = explode('-',$last_date)[1];        
            
            $c_date['last_date'] = $last_month.'-'.$last_year;
            
            $next_date = date('m-Y', strtotime('+1 month', strtotime(now())));
            
            $c_date['next_month'] = $next_month = intval(explode('-',$next_date)[0]);
            $c_date['next_year'] = $next_year = explode('-',$next_date)[1];        
            
            $c_date['next_date'] = $next_month.'-'.$next_year;
        }

        if(isset($request->truck) && isset($request->btn_search))
        {
            $jobs = $jobs->where('truck_id',$request->truck);
        }
            $jobs = $jobs->whereMonth('primary_date',$month);
            $jobs = $jobs->whereYear('primary_date',$year);
            $jobs = $jobs->get();
        
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
        
        $trucks = Truck::all();
        
        $calender = $this->year2array(date("Y"));
        
        return view('admin.peak_factor', compact('assigned', 'unAssigned', 'completed', 'pending','jobs','trucks','calender','c_date'));

    }

    public function Mailsend(Request $request){



# Instantiate the client.
$mgClient = Mailgun::create('071b09f27a72364b69e0b905f219133e-af6c0cec-677ac568');
$domain = "sandboxfcaa8f256e35459cb6de3f1eb8669b75.mailgun.org";
$params = array(
  'from'    => 'Excited User <aammaann89@sandboxfcaa8f256e35459cb6de3f1eb8669b75.mailgun.org>',
  'to'      => 'aammaann89@gmail.com',
  'subject' => 'Hello',
  'text'    => 'test a mail for schedule_date  Mon, 29 June 2020 23:30:00 -0000',
  "o:deliverytime"=>"Mon, 29 June 2020 23:30:00 -0000"
);

# Make the call to the client.
$mgClient->messages()->send($domain, $params);
echo "<pre>";
print_r($mgClient);

}


    /**

     * Mail.

     *

     * @param \App\Provider $provider

     * @return Response

     */
    public function  cannedsms(Request $request){

        if (!Helper::authorized('dashboard')) {
        
                    return redirect()->route('admin.profile');
        
                }
        $template = DB::table('sms_templales')
        
                    ->selectRaw('id,template_id,template_subject,DATE_FORMAT(createdat,"%d/%M/%Y") as createdat')
        
                    ->get();
                
             return view('admin.cannedsms',compact('template'));
        
        }
        public function  mail(Request $request){
        
        if (!Helper::authorized('dashboard')) {
        
                    return redirect()->route('admin.profile');
        
                }
        $template = DB::table('mail_templates')
        
                    ->selectRaw('id,template_id,from_email,template_subject,DATE_FORMAT(createdat,"%d/%M/%Y") as createdat')
        
                    ->get();
                
             return view('admin.mail',compact('template'));
        
        }
        
        public function saveMailTemplate(Request $request){
        
            if(!$request->has('tid')){
                DB::table('mail_templates')->insert(
                [
                'template_id'=>$request->input('temp_id'),
                'from_email'=>$request->input('fromemail'),
                'template_subject'=>$request->input('subject'),
                'template'=>$request->input('template_value')]
            ); 
            }else{
                DB::table('mail_templates')
                      ->where('id', $request->input('tid'))
                      ->update([
                'template_id'=>$request->input('temp_id'),
                'from_email'=>$request->input('fromemail'),
                'template_subject'=>$request->input('subject'),
                'template'=>$request->input('template_value')]);
            }
           
        }
        
        public function saveSmsTemplate(Request $request){
        
            if(!$request->has('tid')){
                DB::table('sms_templales')->insert(
                [
                'template_id'=>$request->input('temp_id'),
                'template_subject'=>$request->input('subject'),
                'template'=>$request->input('template_value')]
            ); 
            }else{
                DB::table('sms_templales')
                      ->where('id', $request->input('tid'))
                      ->update([
                'template_id'=>$request->input('temp_id'),
                'template_subject'=>$request->input('subject'),
                'template'=>$request->input('template_value')]);
            }
           
        }
        
        public function editMailTemplate($id){
            $template = DB::table('mail_templates')
        
                    ->selectRaw('*')
        
                    ->where('id',$id)
                    
                    ->get();
        
                     return view('admin.edit_mail',compact('template'));
        }
        
        public function editSmsTemplate($id){
            $template = DB::table('sms_templales')
        
                    ->selectRaw('*')
        
                    ->where('id',$id)
                    
                    ->get();
        
                     return view('admin.smsedit',compact('template'));
        }
    
    /**

     * Chat.

     *

     * @param \App\Provider $provider

     * @return Response

     */
  public function chat(Request $request)

    {
 //dd($request->all());

        if (!Helper::authorized('dashboard')) {

            return redirect()->route('admin.profile');

        }


    $chat_list = DB::table('msgs')

            ->selectRaw('*,DATE_FORMAT(createdat,"%d/%M/%Y") as createdat')

            ->skip('0')

            ->take('10')
            
            ->orderBy('updatedat', 'desc')
            ->get();
    $chat_count = DB::table('msgs')

            ->selectRaw('count(*) as count')

            ->get();
    
    return view('admin.sms',compact('chat_list','chat_count'));
    
}

/**

     * Usersearch.

     *

     * @param \App\Provider $provider

     * @return Response

     */

public function userSearch(Request $request){

    if($request->input('user_name')==''){
        if($request->input('offset')===''){
           $chat_list = DB::table('msgs')

            ->selectRaw('*,DATE_FORMAT(createdat,"%d/%M/%Y") as createdat')

            ->skip('0')

            ->take('10')

            ->get();  
            echo 1;
        }else{
            $offset = ($request->input('offset')*10);
            $chat_list = DB::table('msgs')

            ->selectRaw('*,DATE_FORMAT(createdat,"%d/%M/%Y") as createdat')

            ->skip($offset)

            ->take('10')

            ->get();
        }
      
        }else{
            if($request->input['offset']===''){
        $chat_list = DB::table('msgs')

            ->selectRaw('*,DATE_FORMA>T(createdat,"%d/%M/%Y") as createdat')

            ->where('full_name','like','%'.$request->input('user_name').'%')

            ->skip('0')

            ->take('10')

            ->get(); 
            }else{
                $offset = ((int)$request->input['offset']*10)-1;
        $chat_list = DB::table('msgs')

            ->selectRaw('*,DATE_FORMAT(createdat,"%d/%M/%Y") as createdat')

            ->where('full_name','like','%'.$request->input('user_name').'%')

            ->skip($offset)

            ->take('10')

            ->get(); 
            }
          
        }
    
    return response()->json([
    'status' => 200,
    'message' => 'user list',
    'users'=>$chat_list
]); 
}
//to send message via twilio
public function sendMessage(Request $request){

DB::table('msgs')
              ->where('booking_id', $request->input('booking_id'))
              ->update(['count_msg' => 0]);
    try {
    DB::table('msgs')->insert(
        [
        'booking_id'=>$request->input('booking_id'),
        'full_name'=>$request->input('full_name'),
        'phone_number'=>$request->input('phone_number'),
        'message'=>$request->input('message')]
    );
    $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                  ->create($request->input('phone_number'), // to
                           ["body" => $request->input('message'), "from" => "+19384448437"]
                  );
          return response()->json([
    'status' => 200,
    'message' => $request->input('message')
]);        
    die();
    }
    catch(\Exception $e){
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                  ->create($request->input('phone_number'), // to
                           ["body" => $request->input('message'), "from" => env('TWILIO_NUMBER')]
                  );
return response()->json([
    'status' => 200,
    'message' => $request->input('message')
]); 
    }

    }

    
    
    /**
     * Dashboard.
     *
     * @param \App\Provider $provider
     * @return Response
     */
    public function dashboard(Request $request)
    {
    
    //dd($request->all());
        if (!Helper::authorized('dashboard')) {
            return redirect()->route('admin.profile');
        }

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
        
        
        
        if(isset($request->btn_last) || isset($request->btn_next))
        {
            if(isset($request->btn_next))
            {
                $c_date = $request->btn_next;
            }
            if(isset($request->btn_last))
            {
                $c_date = $request->btn_last;
            }
            
            
            $c_date = explode('-',$c_date);
            
            $last_date = date('m-Y', strtotime('-1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));
            
            $last_month = intval(explode('-',$last_date)[0]);
            $last_year = explode('-',$last_date)[1];        
            
            $c_date['last_date'] = $last_month.'-'.$last_year;
            
            
            
            $month = intval(date("m", mktime(0, 0, 0, $c_date[0], 10)));
            $year = $c_date[1];
            $c_date['now_month'] = $month;
            $c_date['now_year'] = $year;
            $c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
            
            $next_date = date('m-Y', strtotime('+1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));
            
            $next_month = intval(explode('-',$next_date)[0]);
            $next_year = explode('-',$next_date)[1];        
            
            $c_date['next_date'] = $next_month.'-'.$next_year;
            
        }
        else
        {    
            $c_date['now_month'] =$month = intval(date('m')); 
            $c_date['now_year'] = $year = date('Y'); 
            $c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
            
            $last_date = date('m-Y', strtotime('-1 month', strtotime(now())));
            
            $c_date['last_month'] = $last_month = intval(explode('-',$last_date)[0]);
            $c_date['last_year'] = $last_year = explode('-',$last_date)[1];        
            
            $c_date['last_date'] = $last_month.'-'.$last_year;
            
            $next_date = date('m-Y', strtotime('+1 month', strtotime(now())));
            
            $c_date['next_month'] = $next_month = intval(explode('-',$next_date)[0]);
            $c_date['next_year'] = $next_year = explode('-',$next_date)[1];        
            
            $c_date['next_date'] = $next_month.'-'.$next_year;
        }
        
        $join['trucks'] = true;
        $join['users'] = true;
        $select['customer'] = true;
        
        $tab = 1;
        if(isset($request->truck) && isset($request->btn_search))
        {
            $param['trucks'] = $request->truck;
            $tab = 1;
        }
        elseif(isset($request->btn_search))
        {
            if(!empty($request->search))
            {
                $param['search']  = $request->search;
            }
            
            $tab = 2;
        }
        elseif(isset($request->btn_reset))
        {
            $param['search']  = '';
            $tab = 2;
        }
        
        if($tab == 1)
        {
            $param['month'] = $month;
            $param['year'] = $year;
        }
        
        
        $jobs = Booking::get_booking($param,$join,$select)->get();
            
        
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
        
        $trucks = Truck::all();
        $calender = $this->year2array(date("Y"));
        $hub = HubLocation::first();

        $bookings_temp = DB::table('booking_form as b')
            ->selectRaw('b.booking_id, b.start_time, b.end_time, b.booking_date, d.dlevel, u.first_name, u.last_name, b.service_type_id')
            ->join('dlevels as d', 'b.dlevel', '=', 'd.id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->where('b.step', '0')
            ->get();

        $zoneTypes = ZoneType::get();

        $bookings = array();
        $shuffle_bookings = array();
        foreach ($bookings_temp as $item) {
            if (isset($item->booking_date)) {
                $array['booking_id'] = $item->booking_id;
                $array['booking_date'] = $item->booking_date;
                $array['start_time'] = $item->start_time;
                $array['end_time'] = $item->end_time;
                $array['dlevel'] = $item->dlevel;
                $array['user_name'] = $item->first_name . ' ' . $item->last_name;
    
                $locations = Booking::get_booking_location($item->booking_id)->toArray();
                $array['pickup']['zip'] = $locations[0]->zip_code;
                $array['dropoff']['zip'] = $locations[1]->zip_code;
                $array['pickup']['color'] = null;
                $array['dropoff']['color'] = null;
                foreach ($zoneTypes as $zoneType) {
                    if (in_array($locations[0]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['pickup']['color'] = $zoneType->color;
                    if (in_array($locations[1]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['dropoff']['color'] = $zoneType->color;
                }

                if (!isset($bookings[$item->booking_date])) {
                    $bookings[$item->booking_date] = array();
                }
                array_push($bookings[$item->booking_date], $array);
            }
            if ($item->service_type_id == 6) {
                $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $item->booking_id)->orderBy('type', 'asc')->get();
                $array['booking_id'] = $item->booking_id;
                $array['dlevel'] = $item->dlevel;
                $array['user_name'] = $item->first_name . ' ' . $item->last_name;

                $locations = Booking::get_booking_location($item->booking_id)->toArray();
                $array['pickup']['zip'] = $locations[0]->zip_code;
                $array['dropoff']['zip'] = $locations[1]->zip_code;
                $array['pickup']['color'] = null;
                $array['dropoff']['color'] = null;
                foreach ($zoneTypes as $zoneType) {
                    if (in_array($locations[0]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['pickup']['color'] = $zoneType->color;
                    if (in_array($locations[1]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['dropoff']['color'] = $zoneType->color;
                }
                foreach ($booking_dates as $date) {
                    if (!isset($shuffle_bookings[$date->date])) {
                        $shuffle_bookings[$date->date] = array();
                    }
                    $array['booking_date'] = $date->date;
                    if ($date->type == 0)
                        array_push($shuffle_bookings[$date->date], $array);
                }
            }
        }

        $date_type = 0;

        return view('admin.dashboard', compact('tab','all', 'assigned', 'unAssigned', 'completed', 'pending','jobs','trucks','calender','c_date','hub', 'bookings', 'shuffle_bookings', 'date_type'));
    }

    function shuffle_show(Request $request) {
        if (!Helper::authorized('dashboard')) {
            return redirect()->route('admin.profile');
        }

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

        $sub_status = "";
        if(isset($request->sub_status)) {
            $sub_status = $request->sub_status;
        }

        if(isset($request->btn_last) || isset($request->btn_next))
        {
            if(isset($request->btn_next))
            {
                $c_date = $request->btn_next;
            }
            if(isset($request->btn_last))
            {
                $c_date = $request->btn_last;
            }

            $c_date = explode('-',$c_date);

            $last_date = date('m-Y', strtotime('-1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));

            $last_month = intval(explode('-',$last_date)[0]);
            $last_year = explode('-',$last_date)[1];

            $c_date['last_date'] = $last_month.'-'.$last_year;

            $month = intval(date("m", mktime(0, 0, 0, $c_date[0], 10)));
            $year = $c_date[1];
            $c_date['now_month'] = $month;
            $c_date['now_year'] = $year;
            $c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 

            $next_date = date('m-Y', strtotime('+1 month', strtotime($c_date[1].'-'.$c_date[0].'-01')));

            $next_month = intval(explode('-',$next_date)[0]);
            $next_year = explode('-',$next_date)[1];        

            $c_date['next_date'] = $next_month.'-'.$next_year;
        }
        else
        {    
            $c_date['now_month'] =$month = intval(date('m')); 
            $c_date['now_year'] = $year = date('Y'); 
            $c_date['now_month_text'] = $month_text = date("F", mktime(0, 0, 0, $month, 10)); 
            
            $last_date = date('m-Y', strtotime('-1 month', strtotime(now())));
            
            $c_date['last_month'] = $last_month = intval(explode('-',$last_date)[0]);
            $c_date['last_year'] = $last_year = explode('-',$last_date)[1];        
            
            $c_date['last_date'] = $last_month.'-'.$last_year;
            
            $next_date = date('m-Y', strtotime('+1 month', strtotime(now())));
            
            $c_date['next_month'] = $next_month = intval(explode('-',$next_date)[0]);
            $c_date['next_year'] = $next_year = explode('-',$next_date)[1];        
            
            $c_date['next_date'] = $next_month.'-'.$next_year;
        }

        $join['trucks'] = true;
        $join['users'] = true;
        $select['customer'] = true;

        $tab = 4;

        $param['month'] = $month;
        $param['year'] = $year;

        $jobs = Booking::get_booking($param,$join,$select)->get();
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

        $trucks = Truck::all();
        $calender = $this->year2array(date("Y"));
        $hub = HubLocation::first();

        $bookings_temp = DB::table('booking_form as b')
            ->selectRaw('b.booking_id, b.start_time, b.end_time, b.status, b.sub_status, b.booking_date, d.dlevel, u.first_name, u.last_name, b.service_type_id')
            ->join('dlevels as d', 'b.dlevel', '=', 'd.id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->where('b.step', '0')
            ->get();

        $zoneTypes = ZoneType::get();

        $bookings = array();
        $shuffle_bookings = array();

        $pending_shuffle_bookings = array();
        $pending_shuffle_bookings_temp = array();
        if($sub_status == '') {
            $pending_shuffle_bookings_temp = DB::table('booking_form as b')
            ->selectRaw('b.booking_id, b.start_time, b.end_time, b.status, b.sub_status, fs.date as booking_date, d.dlevel, u.first_name, u.last_name, b.service_type_id')
            ->join('dlevels as d', 'b.dlevel', '=', 'd.id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->join('booking_form_shuffle as fs', 'b.booking_id', '=', 'fs.booking_id')
            ->where('b.step', '0')
            ->where('b.service_type_id', '6')
            ->whereRaw("MONTH(`fs`.`date`) = ".$month)
            ->get();
        } else {
            $pending_shuffle_bookings_temp = DB::table('booking_form as b')
                ->selectRaw('b.booking_id, b.start_time, b.end_time, b.status, b.sub_status, fs.date as booking_date, d.dlevel, u.first_name, u.last_name, b.service_type_id')
                ->join('dlevels as d', 'b.dlevel', '=', 'd.id')
                ->join('users as u', 'u.id', '=', 'b.user_id')
                ->join('booking_form_shuffle as fs', 'b.booking_id', '=', 'fs.booking_id')
                ->where('b.step', '0')
                ->where('b.service_type_id', '6')
                ->where('b.sub_status', $sub_status)
                ->whereRaw("MONTH(`fs`.`date`) = ".$month)
                ->get();
        }
        foreach ($pending_shuffle_bookings_temp as $item) {
            $array['booking_id'] = $item->booking_id;
            $array['booking_date'] = $item->booking_date;
            $array['start_time'] = $item->start_time;
            $array['end_time'] = $item->end_time;
            $array['dlevel'] = $item->dlevel;
            $array['sub_status'] = $item->sub_status;
            $array['user_name'] = $item->first_name . ' ' . $item->last_name;
            $locations = Booking::get_booking_location($item->booking_id)->toArray();
            $array['pickup']['zip'] = $locations[0]->zip_code;
            $array['dropoff']['zip'] = $locations[1]->zip_code;
            $array['pickup']['color'] = null;
            $array['dropoff']['color'] = null;
            foreach ($zoneTypes as $zoneType) {
                if (in_array($locations[0]->zip_code, explode(',', $zoneType->zip_code)))
                    $array['pickup']['color'] = $zoneType->color;
                if (in_array($locations[1]->zip_code, explode(',', $zoneType->zip_code)))
                    $array['dropoff']['color'] = $zoneType->color;
            }
            array_push($pending_shuffle_bookings, $array);
        }

        foreach ($bookings_temp as $item) {
            if (isset($item->booking_date)) {
                $array['booking_id'] = $item->booking_id;
                $array['booking_date'] = $item->booking_date;
                $array['start_time'] = $item->start_time;
                $array['end_time'] = $item->end_time;
                $array['dlevel'] = $item->dlevel;
                $array['user_name'] = $item->first_name . ' ' . $item->last_name;
    
                $locations = Booking::get_booking_location($item->booking_id)->toArray();
                $array['pickup']['zip'] = $locations[0]->zip_code;
                $array['dropoff']['zip'] = $locations[1]->zip_code;
                $array['pickup']['color'] = null;
                $array['dropoff']['color'] = null;
                foreach ($zoneTypes as $zoneType) {
                    if (in_array($locations[0]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['pickup']['color'] = $zoneType->color;
                    if (in_array($locations[1]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['dropoff']['color'] = $zoneType->color;
                }

                if (!isset($bookings[$item->booking_date])) {
                    $bookings[$item->booking_date] = array();
                }
                array_push($bookings[$item->booking_date], $array);
            }
            if ($item->service_type_id == 6) {
                $booking_dates = DB::table('booking_form_shuffle')->where('booking_id', $item->booking_id)->orderBy('type', 'asc')->get();
                $array['booking_id'] = $item->booking_id;
                $array['dlevel'] = $item->dlevel;
                $array['user_name'] = $item->first_name . ' ' . $item->last_name;
                $array['sub_status'] = $item->sub_status;

                $locations = Booking::get_booking_location($item->booking_id)->toArray();
                $array['pickup']['zip'] = $locations[0]->zip_code;
                $array['dropoff']['zip'] = $locations[1]->zip_code;
                $array['pickup']['color'] = null;
                $array['dropoff']['color'] = null;
                foreach ($zoneTypes as $zoneType) {
                    if (in_array($locations[0]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['pickup']['color'] = $zoneType->color;
                    if (in_array($locations[1]->zip_code, explode(',', $zoneType->zip_code)))
                        $array['dropoff']['color'] = $zoneType->color;
                }
                foreach ($booking_dates as $date) {
                    if (!isset($shuffle_bookings[$date->date])) {
                        $shuffle_bookings[$date->date] = array();
                    }
                    $array['booking_date'] = $date->date;
                    if ($date->type == $request->date_type)
                        array_push($shuffle_bookings[$date->date], $array);
                }
            }
        }

        $date_type = $request->date_type;

        return view('admin.dashboard', compact('tab','all', 'assigned', 'unAssigned', 'completed', 'pending','jobs','trucks','calender','c_date','hub', 'bookings', 'shuffle_bookings', 'date_type', 'sub_status', 'pending_shuffle_bookings'));
    }
    
    function update_sub_status() {
        DB::table('booking_form')
              ->where('booking_id', $_GET['booking_id'])
              ->update(['sub_status' => $_GET['sub_status']]);
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
    
    public function working_hours($id=null,$day=null,$time=null)
    {
        
        if(!empty($id) && !empty($day))
        {
            if($time == 1){ $time = 0; }
            elseif($time == 0){ $time = 1; }
            
            DB::table('working_hours')->where('id',$id)->update(array($day=>$time));
        }
        else
        {
            $weeks = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
            $working_hours = DB::table('working_hours')->get();
            return view('admin.working_hours.index', compact('weeks','working_hours'));    
        }
    }

    public function booking_detail($booking_id, $date, $date_type) {
        // service type data
        $service_type = DB::table('booking_form as b')
            ->selectRaw('s.name, d.dlevel, b.crew_count, b.booking_date, b.time_to_hub, b.time_from_hub')
            ->join('services as s', 'b.service_type_id', '=', 's.id')
            ->join('dlevels as d', 'b.dlevel', '=', 'd.id')
            ->where('b.booking_id', $booking_id)
            ->first();
        // inventory item data
        $items = array();
        $selected_items = Booking::get_booking_items($booking_id);

        $quantity = $weights = $volumes = array();
        $items['total_weight'] = 0;
        $items['total_volume'] = 0;
        foreach ($selected_items as $i) {
            $items['total_weight'] += $i->quantity * $i->weight;
            $items['total_volume'] += $i->quantity * $i->volume;
        }
        $loading_times = Helper::get_loading_time($booking_id, $service_type->crew_count);
        $unloading_times = Helper::get_unloading_time($booking_id, $service_type->crew_count);
        $dis_assembly_times = Helper::get_dis_assembly_time($selected_items, $service_type->crew_count);
        // pick & drop location data
        $booking_location = Booking::get_booking_location($booking_id);
        $array = $booking_location->toArray();
        $out = array_splice($array, 1, 1);
        $length = count($array);
        $booking_location = array_replace($array, array($length => $out[0]));

        $times = array();
        foreach ($booking_location as $k => $l) {
            if (isset($booking_location[$k+1])) {
                $temp = DB::table('booking_form_location')->where(['booking_loc_id' => $booking_location[$k+1]->booking_loc_id])->select('time_from')->first()->time_from;
                if (isset($temp)) {
                    $times[$k+1] = $temp;
                } else {
                    $times[$k+1] = $this->get_directions_info($l->lat, $l->lng, $booking_location[$k+1]->lat, $booking_location[$k+1]->lng, 'time');
                    DB::table('booking_form_location')->where([
                        'booking_loc_id' => $booking_location[$k+1]->booking_loc_id,
                        'booking_id' => $booking_id
                    ])->update([
                        'time_from' => $times[$k+1],
                    ]);
                }
            }
        }
        
        // Getting Assigned Users
        $users_data = DB::table('job_assigned_users')->where('booking_id', $booking_id)->first();

        $crews = DB::table('users as u')
        ->selectRaw('u.id,first_name,last_name,ur.role_id as role,ul.level')
        ->join('role_user as ur', 'ur.user_id', '=', 'u.id')
        ->join('roles as r', 'r.id', '=', 'ur.role_id')
        ->join('user_level as ul', 'ul.user_id', '=', 'u.id')->get();
        $assigned_workers = array();
        foreach ($crews as $c) {
            if (isset($users_data->captain_id) && ($c->id == $users_data->captain_id)) {
                $name = $c->first_name . ' ' . $c->last_name;
                $level = $c->level;
                $designation = 'captain';
                $badges_data = DB::table('user_badges')->where('user_id', $c->id)->select('badge_name')->get();
                $badges = '';
                foreach ($badges_data as $b) {
                    $badges .= $b->badge_name . ', ';
                }
                array_push($assigned_workers, [
                    'name' => $name,
                    'level' => $level,
                    'designation' => $designation,
                    'badges' => rtrim($badges, ", ")
                ]);
            }
            if (isset($users_data->helper_id) && ($c->id == $users_data->helper_id)) {
                $name = $c->first_name . ' ' . $c->last_name;
                $level = $c->level;
                $designation = 'helper';
                $badges_data = DB::table('user_badges')->where('user_id', $c->id)->select('badge_name')->get();
                $badges = '';
                foreach ($badges_data as $b) {
                    $badges .= $b->badge_name . ', ';
                }
                array_push($assigned_workers, [
                    'name' => $name,
                    'level' => $level,
                    'designation' => $designation,
                    'badges' => rtrim($badges, ", ")
                ]);
            }
            if (isset($users_data->technician_id) && ($c->id == $users_data->technician_id)) {
                $name = $c->first_name . ' ' . $c->last_name;
                $level = $c->level;
                $designation = 'technician';
                $badges_data = DB::table('user_badges')->where('user_id', $c->id)->select('badge_name')->get();
                $badges = '';
                foreach ($badges_data as $b) {
                    $badges .= $b->badge_name . ', ';
                }
                array_push($assigned_workers, [
                    'name' => $name,
                    'level' => $level,
                    'designation' => $designation,
                    'badges' => rtrim($badges, ", ")
                ]);
            }
            if (isset($users_data->hauler_id) && ($c->id == $users_data->hauler_id)) {
                $name = $c->first_name . ' ' . $c->last_name;
                $level = $c->level;
                $designation = 'hauler';
                $badges_data = DB::table('user_badges')->where('user_id', $c->id)->select('badge_name')->get();
                $badges = '';
                foreach ($badges_data as $b) {
                    $badges .= $b->badge_name . ', ';
                }
                array_push($assigned_workers, [
                    'name' => $name,
                    'level' => $level,
                    'designation' => $designation,
                    'badges' => rtrim($badges, ", ")
                ]);
            }
            if (isset($users_data->specialist_id) && ($c->id == $users_data->specialist_id)) {
                $name = $c->first_name . ' ' . $c->last_name;
                $level = $c->level;
                $designation = 'specialist';
                $badges_data = DB::table('user_badges')->where('user_id', $c->id)->select('badge_name')->get();
                $badges = '';
                foreach ($badges_data as $b) {
                    $badges .= $b->badge_name . ', ';
                }
                array_push($assigned_workers, [
                    'name' => $name,
                    'level' => $level,
                    'designation' => $designation,
                    'badges' => rtrim($badges, ", ")
                ]);
            }
        }

        // Getting Assigned Truck
        $truck_data = DB::table('booking_form_truck')->where('booking_id', $booking_id)->first();
        $assigned_truck = array();
        $assigned_truck['name'] = $truck_data->truck_name;
        $assigned_truck['volume'] = $truck_data->truck_volume;

        $truck_detail_data = Truck::where('id', $truck_data->truck_id)->first();
        $assigned_truck['type'] = $truck_detail_data->type;
        $assigned_truck['color'] = $truck_detail_data->color;

        $mobi_times = DB::table('booking_form')->where(['booking_id' => $booking_id])->select('time_to_hub', 'time_from_hub','status')->first();

        $personal_detials = DB::table('booking_personal_info')->where(['booking_id' => $booking_id])->select('first_name', 'last_name','phone_number','email')->first();

        // shuffle type price and time range
        $times_shuffle = array();
        $charges = array();
        if ($service_type->name == 'Shuffle') {
            $times_shuffle = DB::table('booking_form_shuffle')->where(array(
                'booking_id' => $booking_id,
                'date' => $date,
                'type' => $date_type
            ))->first();
            $charges = DB::table('booking_form_charges')->where(array(
                'booking_id' => $booking_id
            ))->first();
        }

        return view('admin.booking_detail', compact('booking_id', 'service_type', 'loading_times', 'unloading_times', 'dis_assembly_times', 'items', 'selected_items', 'times', 'mobi_times', 'booking_location', 'assigned_workers', 'assigned_truck','personal_detials', 'times_shuffle', 'charges', 'date', 'date_type'));

    }

    public function booking_items($booking_id, $date, $date_type) {
        $selected_items = Booking::get_booking_items($booking_id);
        $items = Inventory::all();
        $categories = Category::all();
        $ranking = Inventory::GetRanking();

        foreach ($categories as $cat_item) {
            $inventory_items[$cat_item->id]  = array();
            foreach ($items as $item) {
                if ($cat_item->id == $item->category_id) {
                    array_push($inventory_items[$cat_item->id], $item);
                }
            }
        }

        foreach($items as $itm) {
            $item_ids[] = $itm->id;
        }

        $R_temp = DB::table('inventory_dis_assembly')->whereIn('item_id', $item_ids)->get();
        $R = array();
        foreach ($item_ids as $id) {
            foreach ($R_temp as $temp) {
                if ($temp->item_id == $id) {
                    $R[$id][] = $temp;
                }
            }
        }

        $booking_location = Booking::get_booking_location($booking_id);
        $array = $booking_location->toArray();
        $out = array_splice($array, 1, 1);
        $length = count($array);
        $booking_location = array_replace($array, array($length => $out[0]));

        return view('admin.booking_items', compact('booking_id', 'selected_items', 'items', 'ranking', 'R', 'categories', 'inventory_items', 'booking_location', 'date', 'date_type'));
    }

    public function items_quantity(Request $request, $booking_id) {
        if(isset($request->action) && $request->action == "+")
        { 
            if($request->quantity > 0) {
                $update_item['quantity']  = $request->quantity + 1;
                $where['booking_item_id'] = $request->booking_item_id;
                $booking_item_id = Booking::update_item($update_item, $where);
            }
        }
        elseif(isset($request->action) && $request->action == "-")
        { 
            if($request->quantity > 1)
            {
                $update_item['quantity']  = $request->quantity - 1;
                $where['booking_item_id'] = $request->booking_item_id;
                $booking_item_id = Booking::update_item($update_item,$where);
            }
        }

        $selected_items = Booking::get_booking_items($booking_id);

        return view('admin.includes.selected_items', compact('selected_items', 'booking_id'));
    }

    public function delete_item($booking_id, $booking_item_id) {
        Booking::delete_item(array('booking_item_id'=>$booking_item_id));
        $selected_items = Booking::get_booking_items($booking_id);

        return view('admin.includes.selected_items', compact('selected_items', 'booking_id'));
    }

    public function add_item(Request $request, $booking_id) {

        DB::beginTransaction();

        $booking_truck = Booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();

        $inventory = Inventory::where(array('id'=>$request->item_id))->first();

        $data['item_id'] = $inventory->id;
        $data['truck_id'] = $booking_truck->truck_id;
        $data['item_name'] = $inventory->name;
        $data['item_image'] = isset($inventory->item_image) ? $inventory->item_image : 0;
        $data['file_path'] = $inventory->file_path;
        $data['quantity'] = $request->quantity;
        $data['breadth'] = $inventory->breadth;
        $data['height'] = $inventory->height;
        $data['width'] = $inventory->width;
        $data['volume'] = $inventory->width * $inventory->height * $inventory->breadth;
        $data['weight'] = $inventory->weight;
        $data['similar'] = $inventory->similar;

        if(isset($request->ranking) && !empty($request->ranking))  {
            $data['ranking'] = $request->ranking;
        } else {
            $data['ranking'] = null;
        }

        $data['pick_up_loc_id'] = $request->pick_up_loc_id;
        $data['drop_off_loc_id'] = $request->drop_off_loc_id;
        $data['booking_id'] = $booking_id;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $data['booking_item_id'] = $booking_item_id = Booking::save_item($data);

        if ($request->hasFile('picture') && !empty($booking_item_id)) {
            $this->upload_picture($request, $booking_id, $booking_item_id);
        }

        $num_worker = DB::table('booking_form')->where(['booking_id' => $booking_id])->select('crew_count')->first()->crew_count;
        $drop_off_time = 0;
        $pick_up_time = 0;
        if ($inventory->stair_kind == "stairs") {
            $times = Helper::get_flight_times($inventory->item_id, $num_worker, $inventory->flights, 1);
            $stair_factor = Helper::get_stair_time_factor($inventory->item_id, $num_worker, $inventory->stair_type);
            if (!isset($times)) {
                $drop_off_time = 0;
            } else {
                $drop_off_time = ($times->time_min + $times->time_med + $times->time_max) * $stair_factor * $inventory->quantity / 3;
            }
            $times2 = Helper::get_flight_times($inventory->item_id, $num_worker, $inventory->flights, 0);
            if (!isset($times2)) {
                $pick_up_time = 0;
            } else {
                $pick_up_time = ($times2->time_min + $times2->time_med + $times2->time_max) * $stair_factor * $inventory->quantity / 3;
            }
        } else if ($inventory->stair_kind == "elevator" || $inventory->stair_kind == "both") {
            $times = Helper::get_elevator_times($inventory->item_id, $num_worker, $inventory->floor_num, 1);
            $times2 = Helper::get_elevator_times($inventory->item_id, $num_worker, $inventory->floor_num, 0);
            if (count($times) == 0) {
                $drop_off_time = 0;
            } else {
                if ($inventory->evelator_type == 'reserved_freight') {
                    $time = json_decode(json_encode($times), true)[0]['rs_freight_time'];
                    $delay = json_decode(json_encode($times), true)[0]['rs_freight_delay'];
                } else {
                    $time = json_decode(json_encode($times), true)[0][$inventory->evelator_type . '_time'];
                    $delay = json_decode(json_encode($times), true)[0][$inventory->evelator_type . '_delay'];
                }
                $drop_off_time = ($time + $delay) * $inventory["quantity"];
            }
            if (count($times2) == 0) {
                $pick_up_time = 0;
            } else {
                if ($inventory->evelator_type == 'reserved_freight') {
                    $time = json_decode(json_encode($times2), true)[0]['rs_freight_time'];
                    $delay = json_decode(json_encode($times2), true)[0]['rs_freight_delay'];
                } else {
                    $time = json_decode(json_encode($times2), true)[0][$inventory->evelator_type . '_time'];
                    $delay = json_decode(json_encode($times2), true)[0][$inventory->evelator_type . '_delay'];
                }
                $pick_up_time = ($time + $delay) * $inventory["quantity"];
            }
        } else if ($inventory->stair_kind == 'groundfloor') {
            $times = Helper::get_bulkhead_times($inventory->item_id, $num_worker, $inventory->step_num, 1);
            $times2 = Helper::get_bulkhead_times($inventory->item_id, $num_worker, $inventory->step_num, 0);
            if (!isset($times)) {
                $drop_off_time = 0;
            } else {
                $drop_off_time = ($times->groundfloor_time + $times->groundfloor_delay) * $inventory->quantity;
            }
            if (!isset($times2)) {
                $pick_up_time = 0;
            } else {
                $pick_up_time = ($times2->groundfloor_time + $times2->groundfloor_delay) * $inventory->quantity;
            }
        } else if ($inventory->stair_kind == 'bulkhead') {
            $times = Helper::get_bulkhead_times($inventory->item_id, $num_worker, $inventory->step_num, 1);
            $times2 = Helper::get_bulkhead_times($inventory->item_id, $num_worker, $inventory->step_num, 0);
            if (!isset($times)) {
                $drop_off_time = 0;
            } else {
                $drop_off_time = ($times->bulkhead_time + $times->bulkhead_delay) * $inventory->quantity;
            }
            if (!isset($times2)) {
                $pick_up_time = 0;
            } else {
                $pick_up_time = ($times2->bulkhead_time + $times2->bulkhead_delay) * $inventory->quantity;
            }
        } else if ($inventory->stair_kind == 'entrance') {
            $times = Helper::get_bulkhead_times($inventory->item_id, $num_worker, $inventory->step_num, 1);
            $times2 = Helper::get_bulkhead_times($inventory->item_id, $num_worker, $inventory->step_num, 0);
            if (!isset($times)) {
                $drop_off_time = 0;
            } else {
                $drop_off_time = ($times->en_steps_time + $times->en_steps_delay) * $inventory->quantity;
            }
            if (!isset($times2)) {
                $pick_up_time = 0;
            } else {
                $pick_up_time = ($times2->en_steps_time + $times2->en_steps_delay) * $inventory->quantity;
            }
        }

        $truck_schedule = VehicleSchedule::where('booking_id',$booking_id)->where('truck_id',$data['truck_id'])->first();
        if(isset($truck_schedule->id)) {
            $p['booking_id'] = $booking_id;
            $booking_items = Booking::get_booking_items($p);

            $item_total_volume = 0;
            foreach($booking_items as $item_volume) {
                $item_total_volume = $item_total_volume + ($item_volume->volume * $item_volume->quantity);
            }

            if($item_total_volume < $booking_truck->volume) {
                $moving_time = $pick_up_time + $drop_off_time;
                $vehicle_sch['end_time'] = date('g:i A', strtotime("+{$moving_time} minutes", strtotime($truck_schedule->end_time)));
                VehicleSchedule::where('truck_id',$data['truck_id'])->update($vehicle_sch);
            }
        }

        DB::commit();

        $selected_items = Booking::get_booking_items($booking_id);

        return view('admin.includes.selected_items', compact('selected_items', 'booking_id'));

    }

    public static function upload_picture($request, $booking_id, $booking_item_id) {

        $ext = ltrim(strstr($_FILES['picture']['name'], '.'), '.');

        $data['booking_id']         = $booking_id;
        $data['booking_item_id']    = $booking_item_id;
        $data['file_name']          = $_FILES['picture']['name'];
        $data['file_size']          = $_FILES['picture']['size'];
        $data['file_type']          = $_FILES['picture']['type'];
        $data['extension']          = $ext;
        $data['status']  = 1;
        $data['created_at'] = time();
        $data['updated_at'] = time();
        $file_id = Booking::save_item_image($data);

        $file_name = $booking_id.'-'.$booking_item_id.'-'.$file_id;

        if ($file_id) {
            $path = public_path() . "/uploads/booking";

            $target_file = $path.'/'. $file_name . "." . $ext;

            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                $update['file_path'] = "/uploads/booking/".$file_name. "." . $ext;

                $where['booking_item_id'] = $booking_item_id;
                Booking::update_item_image($update,$where);
                return true;
            } else {
                return false;
            }
        }
    }

    public function booking_locations($booking_id) {
        // TODO: editing location info
        dd($booking_id);
    }

    // Return directions time or distance value with google maps api
    public function get_directions_info($origin_lat, $origin_lng, $des_lat, $des_lng, $info_type) {
        $key = 'AIzaSyBIUaBvvlXdLIxkhAVVqQJC7jhSg98g7NE';
        $api_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
        $url = $api_url . '&origins=' . $origin_lat . ',' . $origin_lng . '&destinations=' . $des_lat . ',' . $des_lng . '&key=' . $key;
        $res = json_decode(file_get_contents($url), true);

        if ($info_type == 'time') {
            if (isset($res['rows'][0]['elements'][0]['duration']['value'])) {
                return $res['rows'][0]['elements'][0]['duration']['value'] / 3600;
            } else {
                return 0;
            }
        } else if ($info_type == 'distance') {
            if (isset($res['rows'][0]['elements'][0]['distance']['value'])) {
                return $res['rows'][0]['elements'][0]['distance']['value'] / 1609.34;
            } else {
                return 0;
            }
        }
    }

    // Get Distance Radius Value
    public function get_radius() {
        return Setting::get('distance_radius');
    }

    // Set Distance Radius Value
    public function set_radius(Request $request) {
        Setting::set('distance_radius', $request->distance_radius);
        Setting::save();
        return redirect()->back();
    }

    public function get_inventoryType(){
        $categories = DB::table('categories')

            ->selectRaw('id,name')

            ->get();
        $item_wieght = DB::table('item_weights')

            ->selectRaw('id,name,min,max,category_json')

            ->get();

        $item_dimension = DB::table('item_dimensions')

            ->selectRaw('id,name,length,width,height,category_json')

            ->get();

        $item_category_creations = DB::table('item_category_creations')

            ->selectRaw('category_id,type')

            ->get();

        $wiehtcate = DB::table('item_category_creations')

            ->select('category_id')

            ->where('type',1)

            ->get();

        $dimensioncate = DB::table('item_category_creations')

            ->select('category_id')

            ->where('type',2)

            ->get();

        $wieght= array();
        $dimension = array();

        foreach($wiehtcate as $key){
         array_push($wieght,$key->category_id);
        }

        foreach($dimensioncate as $keys){
            array_push($dimension,$keys->category_id); 
        }
        $wieght = json_encode($wieght);
        $dimensions = json_encode($dimension);

        return view('admin.inventory_creation', compact('categories','item_wieght','item_dimension','item_category_creations','wieght','dimensions'));
    }

    public function inventoryCreation(Request $request){
        
       
        //for weight
        $categories = $request->input('categories');
        $weightid = $request->input('weightid');
        $item_name = $request->input('item_name');
        $min = $request->input('min');
        $max = $request->input('max');

        foreach ($weightid as $key => $value) {
            # code...
            DB::table('item_weights')
              ->where('id', $weightid[$key])
              ->update([
        'name'=>$item_name[$key],
        'min'=>$min[$key],
        'max'=>$max[$key],
        'category_json'=>json_encode($categories[$key+1])
    ]);
        }



        //for dimension

        $categories_big = $request->input('categories_big');
        $dimensionid = $request->input('dimensionid');
        $item_name_big = $request->input('item_name_big');
        $length = $request->input('length');
        $height = $request->input('height');
        


        foreach ($dimensionid as $keys => $values) {
            # code...
            DB::table('item_dimensions')
              ->where('id', $dimensionid[$keys])
              ->update([
        'name'=>$item_name_big[$keys],
        'length'=>$length[$keys],
        'height'=>$height[$keys],
        'category_json'=>json_encode($categories_big[$keys+1])
    ]);
        }
 
       
        return redirect()->route('admin.create_inventory_type');
    }

    public function changeStatus(Request $request){
        
         DB::table('booking_form')
              ->where('booking_id', $request->input('booking_id'))
              ->update([
        'status'=>$request->input('bookingstatus')]);
               DB::table('booking_notify')
              ->where('booking_id', $request->input('booking_id'))
              ->update([
        'status'=>0]);
      
                $mgClient = Mailgun::create(env('071b09f27a72364b69e0b905f219133e-af6c0cec-677ac568'));
                            $domain = env('MAIL_GUN_DOMAIN');
                                $params = array(
                                    'from'    => $request->input('frommail'),
                                    'to'      => $request->input('tomail'),
                                    'subject' => $request->input('mailsubject'),
                                    'html'    => $request->input('mailtemplate') 
                                );

                            # Make the call to the client.
                            $mgClient->messages()->send($domain, $params);
                            
              return redirect()->back();
    }
    public function TextDefined(){
            $textdefine = DB::table('text_define')

            ->selectRaw('*')
            
            ->orderBy('id')->get();

             return view('admin.textdefine.index',compact('textdefine'));
    }

    public function TextDefinedsave(Request $request){
        DB::table('text_define')
              ->where('id', $request->input('textid'))
              ->update([
        'color'=>$request->input('color'),
        'font_size'=>$request->input('fontsize'),
        'name'=>$request->input('textname')]);

        DB::table('text_define')->where('id', $request->text_id_flexible)->update([
            'color' => $request->color_flexible,
            'font_size' => $request->font_size_flexible,
            'name' => $request->text_name_flexible
        ]);

        DB::table('text_define')->where('id', $request->text_id_unflexible)->update([
            'color' => $request->color_unflexible,
            'font_size' => $request->font_size_unflexible,
            'name' => $request->text_name_unflexible
        ]);
        return redirect()->back();
    }

    public function bulkMail(){


             return view('admin.bulkmail');
    }

    public function getEmail(Request $request){

        $bookings_temp = DB::table('booking_form as b')
            ->selectRaw('p.email as email,p.first_name as first_name,p.last_name as last_name')
            ->join('booking_personal_info as p', 'p.booking_id', '=', 'b.booking_id')
            ->where('b.status', $request->input('status'))
            ->get();
        $options = '';
        foreach ($bookings_temp as $key => $value) {
            # code...
            $options .="<option value='".$bookings_temp[$key]->email."'>".$bookings_temp[$key]->email."</option>";
        }

       return response()->json( array('status'=>200,'data'=>$options));
    }

    public function sendbulkMail(Request $request){
        $email  = implode(',', $request->email);
        $mgClient = Mailgun::create(env('MAIL_GUN_PRIVATE'));
            $domain = env('MAIL_GUN_DOMAIN');
                $params = array(
                    'from'    => $request->input('fromemail'),
                    'to'      => $email,
                    'subject' => $request->input('subject'),
                    'html'    => $request->input('mailtemplate') 
                );

            # Make the call to the client.
            $mgClient->messages()->send($domain, $params);
            return redirect()->back();
    }

    public function price_update($booking_id, Request $request) {
        DB::table('booking_form_charges')->where(array(
            'booking_id' => $booking_id
        ))->update(array(
            'total_charges' => $request->updated_total_price,
            'status' => 1
        ));

        return redirect()->back();
    }
}
