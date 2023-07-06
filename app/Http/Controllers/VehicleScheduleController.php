<?php

namespace App\Http\Controllers;

use App\VehicleSchedule;
use App\Booking;
use App\Truck;
use App\UserMovingRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VehicleScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        $param['limit'] = 10;
        $vehicleSchedules = VehicleSchedule::GetAllTrucksSchedule($param);
        $vehicles = Truck::get();

        return view('admin.vehicle_schedule.index', compact('vehicleSchedules', 'vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.vehicle_schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $vehicleSchedule = new VehicleSchedule($request->all());
        $vehicleSchedule->save();
        return redirect()->to(route('admin.vehicle_schedule.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehicleSchedule $vehicleSchedule
     * @return Response
     */
    public function edit(VehicleSchedule $vehicleSchedule)
    {
        $param['vehicle_schedule_id'] = $vehicleSchedule->id;
        $vehicleSchedule = VehicleSchedule::GetAllTrucksSchedule($param);
        $vehicleSchedule = $vehicleSchedule[0];
        
        return view('admin.vehicle_schedule.edit', compact('vehicleSchedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param VehicleSchedule $vehicleSchedule
     * @return Response
     */
    public function update(Request $request, VehicleSchedule $vehicleSchedule)
    {
        
        $vehicleScheduleUpdate['assigned_on'] = $request->assigned_on;
        $vehicleScheduleUpdate['start_time'] = $request->start_time;
        $vehicleScheduleUpdate['end_time'] = $request->end_time;
        
        VehicleSchedule::where('id',$vehicleSchedule->id)->update($vehicleScheduleUpdate);
        
        return redirect()->to(route('admin.vehicle_schedule.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VehicleSchedule $vehicleSchedule
     * @return Response
     * @throws Exception
     */
    public function destroy(VehicleSchedule $vehicleSchedule)
    {
        try{
            $vehicleSchedule->delete();
            return redirect()->back();
        }catch (Exception $exception){
            return redirect()->back();
        }
    }

    // Show vehicle scheduling be calendar
    public function vehicle_calendar($id) {
        $booking_ids = DB::table('booking_form_truck')->where('truck_id', $id)->get();
        $booked_times = array();
        foreach($booking_ids as $booking_info) {
            $booking = Booking::where('booking_id', $booking_info->booking_id)->first();
            $item = array();
            if (isset($booking) && ($booking->step == 0)) {
                $item['title'] = 'booking-' . $booking->id;
                $item['start'] = $booking->booking_date . ' ' . date('H:i', strtotime($booking->start_time));
                $item['end'] = $booking->booking_date . ' ' . date('H:i', strtotime($booking->end_time));
                array_push($booked_times, $item);
            }
        }

        $booked_times = json_encode($booked_times);

        return view('admin.vehicle_schedule.calendar', compact('booked_times'));
    }
}
