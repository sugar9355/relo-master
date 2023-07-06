<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\FuelLog;
use App\Helper\HelperFunctions;
use App\Helpers\Helper;
use App\ServiceLog;
use App\StickerLog;
use App\Truck;
use App\VehicleDocument;
use App\VehicleType;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    public function __construct()
    {
        if (!Helper::authorized('vehicle')){
            return abort(404);
        }
    }
    
    public function index()
    {
        $vehiclesPetrolArray = $this->getSamSaraPetrolArray();
        $vehicles = Truck::with('serviceLogs')->orderBy('created_at', 'desc')->get();
        return view('admin.vehicle.index', compact('vehicles', 'vehiclesPetrolArray'));
    }

    public function create()
    {
        //$samSaraVehicles = $this->getSamSaraVehicles();
		$samSaraVehicles = array();
        $vehicleTypes = VehicleType::orderBy('created_at', 'desc')->get();
        return view('admin.vehicle.create', compact('vehicleTypes', 'samSaraVehicles'));
    }

    public function store(Request $request)
    {
        $vehicle = new Truck($request->all());
		
		if($vehicle->name == '')
		{
			$vehicleType = VehicleType::where('name',$vehicle->type)->first();
			$vehicle_name = $vehicleType->abbreviation .'-'. $vehicle->fuel_type .'-'. $vehicle->year .'-'. $vehicle->reg_no;
			$vehicle->name = $vehicle_name;
			$vehicle->color = $vehicleType->color;
		}
		
        $vehicle->save();
        return redirect()->to(route('admin.vehicle.index'));
    }

    public function edit(Truck $vehicle)
    {
		$range = array(0=>0,10=>1,20=>2,30=>3,40=>4,50=>5,60=>6,70=>7,80=>8,90=>9,100=>10);
        $vehicleTypes = VehicleType::orderBy('created_at', 'desc')->get();
        $demand_types = DB::table('customer_demand')->select('*')->get();
        $demand_rates = DB::table('vehicle_demand_rate')->where(['vehicle_id' => $vehicle->id])->select('*')->get();
        foreach ($demand_types as $demand) {
            $rate_data = DB::table('vehicle_demand_rate')->where([
                'vehicle_id' => $vehicle->id,
                'demand_id' => $demand->id
                ])->select('rate', 'reservation_fee')->get()->first();
            if ($rate_data == null) {
                $demand->rate = 0;
                $demand->reservation_fee = 0;
            } else {
                $demand->rate = ($rate_data->rate) ? $rate_data->rate : 0;
                $demand->reservation_fee = ($rate_data->reservation_fee) ? $rate_data->reservation_fee : 0;
            }
        }
        return view('admin.vehicle.edit', compact('vehicle','vehicleTypes','range', 'demand_types'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        Truck::find($id)->update($request->all());
        $demand_rates = json_decode($request->demand_rates, true);
        DB::table('vehicle_demand_rate')->where([
            'vehicle_id' => $id,
        ])->delete();
        foreach ($demand_rates as $rate) {
            DB::table('vehicle_demand_rate')->insert([
                'vehicle_id' => $id,
                'demand_id' => $rate['demand_id'],
                'rate' => $rate['rate'],
                'reservation_fee' => $rate['reservation_fee'],
            ]);
        }
        return redirect()->to(route('admin.vehicle.index'));
    }

    public function destroy(Truck $vehicle, Request $request)
    {
        $vehicle->delete();
        return redirect()->back();
    }

    /*public function fuel($id)
    {
        return view('admin.vehicle.create_fuel', compact('id'));
    }

    public function storeFuel(Request $request, $id)
    {
        $fuelLog = new FuelLog();
        $fuelLog->truck_id = $id;
        $fuelLog->from = $request->fuel_date;
        $fuelLog->to = $request->fuel_due_date;
        $fuelLog->save();


        return redirect()->to(route('admin.vehicle.index'));
    }*/

    public function document($id)
    {
        return view('admin.vehicle.create_document', compact('id'));
    }

    public function storeDocument(Request $request, $id)
    {
        try{
            $request['truck_id'] = $id;
            if ($request->hasFile('file')) {
                $request['image'] = Helper::upload_picture($request->file);
            }
            $vehicleDocument = new VehicleDocument($request->all());
            $vehicleDocument->save();
            return true;
        }catch (\Exception $e){
            return $e;
        }
    }

    public function documentView()
    {
        $vehicles = Truck::orderBy('created_at', 'desc')->get();
        return view('admin.vehicle.view_document',compact('vehicles'));
    }
    public function searchDocument(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'vehicle' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->to(Route('admin.vehicle.documentView'))
                ->withErrors($validator);
        }
        $vehicleDocuments = VehicleDocument::all();
        $vehicles = Truck::orderBy('created_at', 'desc')->get();
        return view('admin.vehicle.view_document',compact('vehicles', 'vehicleDocuments'));
    }

    public function service($id)
    {
        // $currentMiles = null;
        // $samSaraId = Truck::find($id)->samsara_id;
        // $samSaraVehiclesArray = $this->getSamSaraVehicles();
        // foreach ($samSaraVehiclesArray as $samSaraVehicleArray){
            // if ($samSaraVehicleArray->id == $samSaraId){
                // $currentMiles = $samSaraVehicleArray->odometerMeters / 1609.344;
            // }
        // }
        return view('admin.vehicle.create_service', compact('id', 'currentMiles'));
    }

    public function storeService(Request $request, $id)
    {
        $request['truck_id'] = $id;
        $serviceLog = new ServiceLog($request->all());
        $serviceLog->save();

        return redirect()->to(route('admin.vehicle.index'));
    }


    public function sticker($id)
    {
        return view('admin.vehicle.create_sticker', compact('id'));
    }

    public function storeSticker(Request $request, $id)
    {
        $request['truck_id'] = $id;
        $stickerLog = new StickerLog($request->all());
        $stickerLog->save();

        return redirect()->to(route('admin.vehicle.index'));
    }

    /**
     * @return mixed
     */
    public function getSamSaraVehicles()
    {
        // $samSaraVehicles = HelperFunctions::getAllVehicles();
        // $samSaraVehicles = $samSaraVehicles->vehicles;
		$samSaraVehicles = array();
        return $samSaraVehicles;
    }

    public function getSamSaraPetrolArray()
    {
        $petrolArray = [];
        $samSaraVehicles = $this->getSamSaraVehicles();
        foreach ($samSaraVehicles as $samSaraVehicle){
            $petrolArray[$samSaraVehicle->id] = $samSaraVehicle->fuelLevelPercent;
        }
        return $petrolArray;
    }
}
