<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\NotificationSchedules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Validator;

class NotificationScheduleController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('notification_schedules')){
            return abort(404);
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $notificationSchedules = NotificationSchedules::orderBy('id', 'DESC')->get();
        return view('admin.notificationSchedule.index', compact('notificationSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.notificationSchedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'days' => 'required|unique:notification_schedules',
            'message' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return view('admin.notificationSchedule.create')
                ->withErrors($validator)
                ->with('inputs', Input::all());
        }

        $newSchedule = new NotificationSchedules($request->all());
        $newSchedule->save();

        return redirect()->route('admin.notification_schedule.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $notificationSchedules = NotificationSchedules::find($id);
        return view('admin.notificationSchedule.edit', compact('notificationSchedules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $notificationSchedules = NotificationSchedules::where('id', '=', $id)->first();

        $rules = [
            'days' => 'required|unique:notification_schedules,days,'.$notificationSchedules->id,
            'message' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){

            return view('admin.notificationSchedule.edit', compact('notificationSchedules'))
                ->withErrors($validator);
        }

        NotificationSchedules::find($id)->update($request->all());

        return redirect()->route('admin.notification_schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        NotificationSchedules::find($id)->delete();
        return redirect()->back();
    }
}
