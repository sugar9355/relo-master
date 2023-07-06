<?php

namespace App\Http\Controllers;

use App\Flag;
use App\Helpers\Helper;
use App\Inventory;
use App\Category;
use App\ZoneType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FlagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flags = Flag::get();
        $zones_temp = ZoneType::get();
        $categories_temp = Category:: get();
        $items_temp = Inventory::get();

        $zones = array();
        foreach ($zones_temp as $item) {
            $zones[$item->id] = $item->name;
        }
        $categories = array();
        foreach ($categories_temp as $item) {
            $categories[$item->id] = $item->name;
        }
        $items = array();
        foreach ($items_temp as $item) {
            $items[$item->id] = $item->name;
        }
        return view('admin.flag.index', compact('zones', 'flags', 'categories', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Inventory::get();
        $categories = Category::get();
        $zones = ZoneType::get();
        $max_num_flights = DB::table('time_flights')->max('num_flights');

        return view('admin.flag.create', compact('items', 'categories', 'zones', 'max_num_flights'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conditions' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $new_flag = new Flag();
            $new_flag->color = $request->color;
            $new_flag->conditions = isset($request->conditions) ? implode(',', $request->conditions) : null;
            $new_flag->categories = isset($request->categories) ? implode(',', $request->categories) : null;
            $new_flag->items = isset($request->items) ? implode(',', $request->items) : null;
            $new_flag->num_flights = isset($request->num_flights) ? $request->num_flights : null;
            $new_flag->type_flights = isset($request->type_flights) ? $request->type_flights : null;
            $new_flag->zones = isset($request->zones) ? implode(',', $request->zones) : null;
            $new_flag->addresses = isset($request->addresses) ? implode('--', $request->addresses) : null;
            $new_flag->apt = isset($request->apt) ? implode(',', $request->apt) : null;
            $new_flag->reason_title = isset($request->reason_title) ? $request->reason_title : null;
            $new_flag->description = isset($request->description) ? $request->description : null;

            $new_flag->save();

            return redirect()->to(route('admin.flag.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flag  $flag
     * @return \Illuminate\Http\Response
     */
    public function show(Flag $flag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flag  $flag
     * @return \Illuminate\Http\Response
     */
    public function edit(Flag $flag)
    {
        $items = Inventory::get();
        $categories = Category::get();
        $zones = ZoneType::get();
        $max_num_flights = DB::table('time_flights')->max('num_flights');

        return view('admin.flag.edit', compact('items', 'categories', 'zones', 'max_num_flights', 'flag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flag  $flag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flag $flag)
    {
        $validator = Validator::make($request->all(), [
            'conditions' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $new_flag['color'] = $request->color;
            $new_flag['conditions'] = isset($request->conditions) ? implode(',', $request->conditions) : null;
            $new_flag['categories'] = isset($request->categories) ? implode(',', $request->categories) : null;
            $new_flag['items'] = isset($request->items) ? implode(',', $request->items) : null;
            $new_flag['num_flights'] = isset($request->num_flights) ? $request->num_flights : null;
            $new_flag['type_flights'] = isset($request->type_flights) ? $request->type_flights : null;
            $new_flag['zones'] = isset($request->zones) ? implode(',', $request->zones) : null;
            $new_flag['addresses'] = isset($request->addresses) ? implode('--', $request->addresses) : null;
            $new_flag['apt'] = isset($request->apt) ? implode(',', $request->apt) : null;
            $new_flag['reason_title'] = isset($request->reason_title) ? $request->reason_title : null;
            $new_flag['description'] = isset($request->description) ? $request->description : null;

            $flag->update($new_flag);

            return redirect()->to(route('admin.flag.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flag  $flag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flag $flag)
    {
        $flag->delete();
        
        return redirect()->back();
    }
}