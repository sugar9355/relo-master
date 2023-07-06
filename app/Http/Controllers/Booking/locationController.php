<?php
namespace App\Http\Controllers\Booking;

use App\Http\Controllers\HomeController;
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

class LocationController extends HomeController
{
	public function update_location(Request $request, $booking_id)
	{
		$location = $request->location;
		
		$dist_time = $this->get_travel_time($location[1]['location'],$location[2]['location']);
		
		$b_update['s_lat'] = $location[1]['lat'];
		$b_update['s_lng'] = $location[1]['lng'];
		$b_update['s_address'] = $location[1]['location'];
		
		$b_update['d_lat'] = $location[2]['lat'];
		$b_update['d_lng'] = $location[2]['lng'];
		$b_update['d_address'] = $location[2]['location'];
		
		$b_update['minutes'] = $dist_time['minutes'];
		$b_update['distance'] = $dist_time['distance'];
		
		$time_H_A = $this->GetHubTime($location[1]['lat'],$location[1]['lng']);
		$time_B_H = $this->GetHubTime($location[2]['lat'],$location[2]['lng']);
		
		if($time_H_A && $time_B_H)
		{
			$b_update['time_from_hub'] = $time_H_A;
			$b_update['time_to_hub']   = $time_B_H;
		}
		
		booking::where('booking_id',$booking_id)->update($b_update);
		
		foreach($request->location as $k => $loc)
		{
			$update['location'] = $loc['location'];
			$update['lat'] = $loc['lat'];
            $update['lng'] = $loc['lng'];
            $update['zip_code'] = $loc['zip_code'];
			booking::update_location($update,$booking_id,$loc['booking_loc_id']);
		}
		
		//return redirect()->to('summary/'.$booking_id);
	}
	
	public function get_travel_time($pickup,$dropoff)
	{
		$pickup = urlencode($pickup);
		$dropoff = urlencode($dropoff);
		
		$key = 'key=AIzaSyBIUaBvvlXdLIxkhAVVqQJC7jhSg98g7NE';
		$url  = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$pickup&destinations=$dropoff&departure_time=now&$key";
		
		$json = json_decode(file_get_contents($url), true);
		
		if($json['rows'][0]['elements'][0]['duration']['text'])
		{
			$dist_time['minutes'] = explode(' ',$json['rows'][0]['elements'][0]['duration']['text'])[0];
			$dist_time['distance'] = explode(' ',$json['rows'][0]['elements'][0]['distance']['text'])[0];
		}
		
		return $dist_time;
	}
	
	function GetHubTime($lat,$lng)
	{		
		//$start_point = '42.320605,-71.079494';		
		$hub = DB::table('hub_locations')->first();
		$start_point = $hub->lat.','.$hub->lng;

		$end_point = $lat .','. $lng;
		
		$origins = 'origins='.$start_point;
		$destination = 'destinations='.$end_point;
		
		$key = 'key=AIzaSyBIUaBvvlXdLIxkhAVVqQJC7jhSg98g7NE';
		
		$url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
		$url .= '&'.$origins.'&'.$destination.'&'.$key;
		
		//echo $url.'<br>'; die;
		// get the json response from url
		$resp = json_decode(file_get_contents($url), true);
		
		if(isset($resp['rows'][0]['elements'][0]['duration']['text']))
		{
			$dist_time = $resp['rows'][0]['elements'][0]['duration']['text'];
			$dist_time = explode(' ',$dist_time);
			return $dist_time[0];
		}
		
		return false;
	}
	
}
