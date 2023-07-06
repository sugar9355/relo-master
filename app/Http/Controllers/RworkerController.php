<?php

namespace App\Http\Controllers;

use App\Rworker;
use App\Helpers\Helper;
use App\Inventory;
use App\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RworkerController extends Controller
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
        $rworkers = Rworker::select('*')->get();

        return view('admin.rworker.index', compact('rworkers'));
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

        return view('admin.rworker.create', compact('items', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $new_rworkers = new Rworker();
        $new_rworkers->num_crews = $request->num_crews;
        $new_rworkers->weight = $request->weight;
        $new_rworkers->wei_min = $request->wei_min;
        $new_rworkers->wei_max = $request->wei_max;
        $new_rworkers->vol_min = $request->vol_min;
        $new_rworkers->vol_max = $request->vol_max;
        $new_rworkers->volume = $request->volume;
        $new_rworkers->categories = isset($request->categories) ? implode(',', $request->categories) : 0;
        $new_rworkers->items = isset($request->items) ? implode(',', $request->items) : 0;

        $new_rworkers->save();

        return redirect()->to(route('admin.rworker.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rworker  $rworker
     * @return \Illuminate\Http\Response
     */
    public function show(Rworker $rworker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rworker  $rworker
     * @return \Illuminate\Http\Response
     */
    public function edit(Rworker $rworker)
    {
        $items = Inventory::get();
        $categories = Category::get();

        return view('admin.rworker.edit', compact('items', 'categories', 'rworker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rworker  $rworker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rworker $rworker)
    {
        $new_rworkers['num_crews'] = $request->num_crews;
        $new_rworkers['weight'] = $request->weight;
        $new_rworkers['wei_min'] = $request->wei_min;
        $new_rworkers['wei_max'] = $request->wei_max;
        $new_rworkers['vol_min'] = $request->vol_min;
        $new_rworkers['vol_max'] = $request->vol_max;
        $new_rworkers['volume'] = $request->volume;
        $new_rworkers['categories'] = isset($request->categories) ? implode(',', $request->categories) : 0;
        $new_rworkers['items'] = isset($request->items) ? implode(',', $request->items) : 0;

        $rworker->update($new_rworkers);
        return redirect()->to(route('admin.rworker.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rworker  $rworker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rworker $rworker, Request $request)
    {
        $rworker->delete();
        
        return redirect()->back();
    }
}