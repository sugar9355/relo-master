<?php

namespace App\Http\Controllers;

use App\FuelLog;
use App\ServiceLog;
use App\StickerLog;
use Illuminate\Http\Request;
use App\Truck;

class LogsController extends Controller
{
    public function index()
    {
        $vehicles = Truck::orderBy('created_at', 'desc')->get();
        return view('admin.logs.index', compact('vehicles'));
    }

    public function search(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'vehicle' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->to(Route('admin.logs.index'))
                ->withErrors($validator);
        }

        $serviceCheck = false;
        $stickerCheck = false;
        $logs = "";
        $vehicleId = $request->get('vehicle');
        $category = $request->get('category');
        if ($category == 'fuel'){
            $logs = FuelLog::whereTruckId($vehicleId)->get();
        }
        if ($category == 'service'){
            $serviceCheck = true;
            $logs = ServiceLog::whereTruckId($vehicleId)->get();
        }
        if ($category == 'sticker'){
            $stickerCheck = true;
            $logs = StickerLog::whereTruckId($vehicleId)->get();
        }
        $vehicles = Truck::orderBy('created_at', 'desc')->get();
        return view('admin.logs.index', compact('vehicles', 'logs', 'serviceCheck', 'stickerCheck'));

    }
}
