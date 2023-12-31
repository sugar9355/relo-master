<?php

use App\PromocodeUsage;
use App\UserRequests;
use App\ServiceType;
use App\User;

function currency($value = '')
{
	if($value == ""){
		return Setting::get('currency')."0.00";
	} else {
		return Setting::get('currency').$value;
	}
}

function distance($value = '')
{
    if($value == ""){
        return "0".Setting::get('distance', 'Km');
    }else{
        return $value.Setting::get('distance', 'Km');
    }
}

function img($img){
	if($img == ""){
		return asset('main/avatar.jpg');
	}else if (strpos($img, 'http') !== false) {
        return $img;
    }else{
		return asset('storage/'.$img);
	}
}

function image($img){
	if($img == ""){
		return asset('main/avatar.jpg');
	}else{
		return asset($img);
	}
}

function promo_used_count($promo_id)
{
	//return PromocodeUsage::where('status','ADDED')->where('promocode_id',$promo_id)->count();
	return PromocodeUsage::where('promocode_id',$promo_id)->count();
}

function Provider_total_requests_count($provider_id)
{
	return UserRequests::where('provider_id',$provider_id)->count();
}

function Provider_accepted_requests_count($provider_id)
{
	return UserRequests::where('status','COMPLETED')->where('provider_id',$provider_id)->count();
}

function total_accepted_jobs_count($param)
{
	return User::GetAcceptedJobs($param)->count();
	
}

function curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($ch);
    curl_close ($ch);
    return $return;
}

function get_all_service_types()
{
	return ServiceType::all();
}

function demo_mode(){
	if(\Setting::get('demo_mode', 0) == 1) {
        return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appdupe.com');
    }
}