<?php

namespace App\Http\Controllers;

use App\Helper\HelperFunctions;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class GodEyeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!Helper::authorized('godeye')){
            return abort(404);
        }
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy', 'disapprove']]);
    }

    public function index()
    {
        return view('admin.godeye.index');
    }

    public function status($status)
    {
        $providers = HelperFunctions::getAllVehiclesLocation();
        $newArray = ['locations' => [], 'providers' => []];
        if ($providers == false) {
            return response()->json(['data' => $newArray, 200]);
        }
        $i = 0;
        foreach ($providers->vehicles as $key => $value) {
            if ($status == 'ALL') {
                if ($i == 0) {
                    $newArray = ['locations' => [], 'providers' => []];
                }
                $newArray =  $this->pushIntoArray($value, $newArray);
                $i++;
            }

            if ($status == 'true') {
                if ($i == 0) {
                    $newArray = ['locations' => [], 'providers' => []];
                }
                if ($value->onTrip == true) {
                    $newArray = $this->pushIntoArray($value, $newArray);
                }
                $i++;
            }
            if ($status == 'false') {
                if ($i == 0) {
                    $newArray = ['locations' => [], 'providers' => []];
                }
                if ($value->onTrip == false) {
                    $newArray = $this->pushIntoArray($value, $newArray);
                }
                $i++;
            }
        }
        $newArray = json_decode(json_encode($newArray),1);
        $newArray['locations'] = array_values(array_unique($newArray['locations'], SORT_REGULAR));
        $newArray['providers'] = array_values(array_unique($newArray['providers'], SORT_REGULAR));

        /*echo '<pre>';
        print_r($newArray);
        echo '</pre>';
        die;*/

        return response()->json(['data' => $newArray], 200);
    }

    /**
     * @param $value
     * @param array $newArray
     * @return array
     */
    private function pushIntoArray($value, array $newArray)
    {
        $provider = $value;
        array_push($newArray['providers'], $provider);
        $location = [
            'name' => $value->name,
            'lat' => $value->latitude,
            'lng' => $value->longitude,
            'car_image' => '/asset/img/marker-car.png'
        ];
        array_push($newArray['locations'], $location);
        return $newArray;
    }


}
