<?php

namespace App\Http\Controllers;

use Setting;
use DateTime;
use App\Category;
use App\TimeCharges;
use App\PropertyInsurance;
use App\InsuranceCategory;
use App\Inventory;
use App\Question;
use App\Service;
use App\Truck;
use App\Preset;
use App\PeakFactor;
use App\VehicleSchedule;
use App\Booking;
use App\UserMovingRequest;
use Illuminate\Support\Facades\Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Stripe;
use App\Helpers\Helper;
use Mailgun\Mailgun;
use Session;
use Redirect;


class BookingController extends Controller
{
	public function packaging($request,$booking_id)
	{
		$service['step'] = 2;
		$service['user_id'] = Auth::user()->id;
		$service['service_type_id'] = $request->service_type_id;
		$booking_id = $booking = booking::insertGetId($service);
		return redirect()->to('booking/'.$booking_id);
	}
	public function saveRemindlater(Request $request){
	
		DB::table('remind_laters')->insert(
        [
        'booking_id'=>$request->input('booking_id'),
        'email'=>$request->input('email'),
        'reminddate'=>$request->input('dateTime')]
    );
		return redirect()->to('booking');
	}

	public function saveBooking(Request $request){
		 
		$usercheck = DB::table('users')

		->selectRaw('email')
		->where('email',$request->input('email'))

		->get();
		
		if(count($usercheck)>0){
				$template = DB::table('mail_templates')

		->selectRaw('template_id,from_email,template_subject,template')
		->where('template_id','already-user')

		->get();
	$email = $request->input('email');
	$mgClient = Mailgun::create(env('MAIL_GUN_PRIVATE'));
						$domain = env('MAIL_GUN_DOMAIN');
							$params = array(
								'from'    => $template[0]->from_email,
								'to'      => $email,
								'subject' => $template[0]->template_subject,
								'html'    => $template[0]->template."Url for Booking:<a href='".url('booking/'.$request->input('booking_id'))."'>Booking </a>"
							);
						# Make the call to the client.
						$mgClient->messages()->send($domain, $params);
						 Session::flush();
						  Auth::logout();
						 return Redirect::to("/");
		}else{

DB::table('users')->insert(
	[
	'first_name'=>'user',
	'last_name'=>'user',
	'payment_mode'=>'CASH',
	'email'=>$request->input('email'),
	'gender'=>"MALE",
	'password'=>bcrypt(rand()),
	'device_type'=>'android',
	'login_by'=>'manual',
	'wallet_balance'=>'0.00',
	'rating'=>'5',
	'otp'=>0,
	]
);
	$template = DB::table('mail_templates')

		->selectRaw('template_id,from_email,template_subject,template')
		->where('template_id','future-booking')

		->get();
	$passoword = rand();
	$email = $request->input('email');
	$mgClient = Mailgun::create(env('MAIL_GUN_PRIVATE'));
						$domain = env('MAIL_GUN_DOMAIN');
							$params = array(
								'from'    => $template[0]->from_email,
								'to'      => $request->input('email'),
								'subject' => $template[0]->template_subject,
								'html'    => $template[0]->template."Password: ".$passoword." and Url for Booking:<a href='".url('booking/'.$request->input('booking_id'))."'> Booking</a>"
							);

						# Make the call to the client.
							
						$mgClient->messages()->send($domain, $params);
	  Session::flush();
Auth::logout();
	return redirect()->to('/');
		}

}
	
}
