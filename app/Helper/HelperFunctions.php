<?php


namespace App\Helper;


class HelperFunctions
{
    public static function getAllVehicles()
    {
        $url = 'https://api.samsara.com/v1/fleet/list?access_token=xT08we4CRqfbHRtBMGQEgJBCbpJBHk';

        $contents = file_get_contents($url);

        if($contents !== false){
            return json_decode($contents);
        }
        return false;
    }

    public static function getAllVehiclesLocation()
    {
        $url = 'https://api.samsara.com/v1/fleet/locations?access_token=xT08we4CRqfbHRtBMGQEgJBCbpJBHk';

        $contents = file_get_contents($url);

        if($contents !== false){
            return json_decode($contents);
        }
        return false;
    }

}
