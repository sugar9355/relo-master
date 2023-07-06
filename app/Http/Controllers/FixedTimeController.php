<?php

namespace App\Http\Controllers;

use App\FixedTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FixedTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parking_times = FixedTime::get();
        $additional_times = DB::table('fixed_add_times')->get();
        return view('admin.fixed_time.index', compact('parking_times', 'additional_times'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->parking_time as $id => $time) {
            FixedTime::where([
                'id' => $id
            ])->update([
                'time' => $time
            ]);
        }

        DB::table('fixed_add_times')->delete();
        foreach ($request->add_name as $i => $name) {
            DB::table('fixed_add_times')->insert([
                'name' => $name,
                'time' => $request->add_time[$i]
            ]);
        }
        return redirect()->to(route('admin.fixed_time.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FixedTime  $fixedTime
     * @return \Illuminate\Http\Response
     */
    public function show(FixedTime $fixedTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FixedTime  $fixedTime
     * @return \Illuminate\Http\Response
     */
    public function edit(FixedTime $fixedTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FixedTime  $fixedTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FixedTime $fixedTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FixedTime  $fixedTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixedTime $fixedTime)
    {
        //
    }
}
