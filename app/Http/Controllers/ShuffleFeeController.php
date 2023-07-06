<?php

namespace App\Http\Controllers;

use App\ShuffleFee;
use App\FixedTime;
use App\Inventory;
use Illuminate\Http\Request;

class ShuffleFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parking_times = FixedTime::select('id', 'parking')->get();
        $ranking = Inventory::GetRanking();
        $shuffle_fees = ShuffleFee::first();
        return view('admin.shuffle_fee.index', compact('parking_times', 'ranking', 'shuffle_fees'));
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
        $fees = array();
        $fees['base_rate'] = isset($request->base_rate) ? $request->base_rate : null;
        $fees['charge_cb_ft'] = isset($request->charge_cb_ft) ? $request->charge_cb_ft : null;
        $fees['curbside_fee'] = isset($request->curbside_fee) ? $request->curbside_fee : null;
        $fees['parking_situations'] = isset($request->parking_situations) ? implode(',', $request->parking_situations) : null;
        $fees['parking_fees'] = isset($request->parking_fees) ? json_encode($request->parking_fees) : null;
        $fees['vol_min'] = isset($request->vol_min) ? json_encode($request->vol_min) : null;
        $fees['vol_max'] = isset($request->vol_max) ? json_encode($request->vol_max) : null;
        $fees['long_walk_fee'] = isset($request->long_walk_fee) ? json_encode($request->long_walk_fee) : null;
        $fees['dis_assem_fee'] = isset($request->dis_assem_fee) ? json_encode($request->dis_assem_fee) : null;
        $fees['survival_kit'] = isset($request->survival_kit) ? $request->survival_kit : null;
        $fees['supplies_kit'] = isset($request->supplies_kit) ? $request->supplies_kit : null;

        ShuffleFee::orderBy('id')->limit(1)->delete();
        ShuffleFee::insert($fees);
        return redirect()->to(route('admin.shuffle_fee.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShuffleFee  $shuffleFee
     * @return \Illuminate\Http\Response
     */
    public function show(ShuffleFee $shuffleFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShuffleFee  $shuffleFee
     * @return \Illuminate\Http\Response
     */
    public function edit(ShuffleFee $shuffleFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShuffleFee  $shuffleFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShuffleFee $shuffleFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShuffleFee  $shuffleFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShuffleFee $shuffleFee)
    {
        //
    }
}
