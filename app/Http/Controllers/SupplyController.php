<?php

namespace App\Http\Controllers;

use App\Supply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class SupplyController extends Controller
{
    public function __construct() {
        if (!Helper::authorized('rworker')){
            return abort(404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplies = Supply::get();
        return view('admin.supply.index', compact('supplies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supply.create');
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
            'name' => 'required',
            'cost' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $new_supply = new Supply();
            $new_supply->name = $request->name;
            $new_supply->cost = $request->cost;

            $new_supply->save();

            return redirect()->to(route('admin.supply.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        return view('admin.supply.edit', compact('supply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'cost' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $new_supply['name'] = $request->name;
            $new_supply['cost'] = $request->cost;

            $supply->update($new_supply);

            return redirect()->to(route('admin.supply.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();
        
        return redirect()->back();
    }
}
