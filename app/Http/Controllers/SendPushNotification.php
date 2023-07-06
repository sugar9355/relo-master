<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ProviderDevice;
use Exception;
use Log;
use Setting;

class SendPushNotification extends Controller
{
	/**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function RideAccepted($request){

    	return $this->sendPushToUser($request->user_id, trans('api.push.request_accepted'));
    }

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */
    public function user_schedule($user){

        return $this->sendPushToUser($user, trans('api.push.schedule_start'));
    }

    /**
     * New Incoming request
     *
     * @return void
     */
    public function provider_schedule($provider){

        return $this->sendPushToProvider($provider, trans('api.push.schedule_start'));

    }

    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function UserCancellRide($request){

        return $this->sendPushToProvider($request->provider_id, trans('api.push.user_cancelled'));
    }


    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */
    public function ProviderCancellRide($request){

        return $this->sendPushToUser($request->user_id, trans('api.push.provider_cancelled'));
    }

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */
    public function Arrived($request){

        return $this->sendPushToUser($request->user_id, trans('api.push.arrived'));
    }

     /**
     * Driver Arrived at your location.
     *
     * @return void
     */
    public function Dropped($request){

        Log::info( trans('api.push.dropped').Setting::get('currency').$request->payment->total.' by '.$request->payment_mode);

        return $this->sendPushToUser($request->user_id, trans('api.push.dropped').Setting::get('currency').$request->payment->total.' by '.$request->payment_mode);
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */
    public function ProviderNotAvailable($user_id){

        return $this->sendPushToUser($user_id,trans('api.push.provider_not_available'));
    }

    /**
     * New Incoming request
     *
     * @return void
     */
    public function IncomingRequest($provider){

        return $this->sendPushToProvider($provider, trans('api.push.incoming_request'));

    }
    

    /**
     * Driver Documents verfied.
     *
     * @return void
     */
    public function DocumentsVerfied($provider_id){

        return $this->sendPushToProvider($provider_id, trans('api.push.document_verfied'));
    }


    /**
     * Money added to user wallet.
     *
     * @return void
     */
    public function WalletMoney($user_id, $money){

        return $this->sendPushToUser($user_id, $money.' '.trans('api.push.added_money_to_wallet'));
    }

    /**
     * Money charged from user wallet.
     *
     * @return void
     */
    public function ChargedWalletMoney($user_id, $money){

        return $this->sendPushToUser($user_id, $money.' '.trans('api.push.charged_from_wallet'));
    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToUser($user_id, $push_message){

    	try{

	    	$user = User::findOrFail($user_id);

            if($user->device_token != ""){

                \Log::info('sending push for user : '. $user->first_name);

    	    	if($user->device_type == 'ios'){

    	    		return \PushNotification::app('IOSUser')
    		            ->to($user->device_token)
    		            ->send($push_message);

    	    	}elseif($user->device_type == 'android'){
    	 
                        define( 'API_ACCESS_KEY', 'AIzaSyCuUjSzoY9I9igTauEWdL6NP5lVeIb066w' );
                        $registrationIds = array( $user->device_token );
                        $msg = array
                        (
                         'message'  => $push_message
                        );
                        $fields = array
                        (
                         'registration_ids'  => $registrationIds,
                         'data'              => $msg
                        );
                         
                        $headers = array
                        (
                         'Authorization: key=' . API_ACCESS_KEY,
                         'Content-Type: application/json'
                        );
                         
                        $ch = curl_init();
                        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
                        curl_setopt( $ch,CURLOPT_POST, true );
                        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                        $result = curl_exec($ch );
                        curl_close( $ch );
                        return $result;
       
    	    		return \PushNotification::app('AndroidUser')
    		            ->to($user->device_token)
    		            ->send($push_message);

    	    	}
            }

    	} catch(Exception $e){
    		return $e;
    	}

    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */
    public function sendPushToProvider($provider_id, $push_message){
    	try{

	    	$provider = ProviderDevice::where('provider_id',$provider_id)->with('provider')->first();

            if($provider->token != ""){
                
                \Log::info('sending push for provider : '. $provider->provider->first_name);

            	if($provider->type == 'ios'){

            		return \PushNotification::app('IOSProvider')
        	            ->to($provider->token)
        	            ->send($push_message);

            	}elseif($provider->type == 'android'){
            	  
                     define( 'API_ACCESS_KEYS', 'AIzaSyCuUjSzoY9I9igTauEWdL6NP5lVeIb066w' );
                    
                    $registrationIds_p = array( $provider->token );
                   
                    $msg_p = array
                    (
                     'message'  => $push_message
                    );
                     
                    $fields_p = array
                    (
                     'registration_ids'  => $registrationIds_p,
                     'data'              => $msg_p
                    );
                      
                    $headers_p = array
                    (
                     'Authorization: key=' . API_ACCESS_KEYS,
                     'Content-Type: application/json'
                    );
                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers_p );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields_p ) );
                    $result = curl_exec($ch );
                    curl_close( $ch );
                    return $result;
                    
            		return \PushNotification::app('AndroidProvider')
        	            ->to($provider->token)
        	            ->send($push_message);

            	}
            }

    	} catch(Exception $e){
    		return $e;
    	}

    }

}
