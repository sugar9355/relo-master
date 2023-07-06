<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Imports\ZoneImport;
use App\ZoneType;
use App\Flag;
use App\Exports\zoneExport;
//use App\Imports\zoneImport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel;

class ZoneTypeController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('zone_type')){
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
        $zoneTypes = ZoneType::orderBy('id', 'desc')->get();

        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('zones', explode(',', $f->conditions))) {
                $flags[$f->id] = $f->color;
            }
        }

        return view('admin.zone_type.index', compact('zoneTypes', 'flags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('zones', explode(',', $f->conditions))) {
                array_push($flags, $f);
            }
        }
        return view('admin.zone_type.create', compact('flags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $zoneType = new ZoneType();
        $zoneType->name = $request->name;
        $zoneType->zip_code = isset($request->zip_code) ? implode(',', $request->zip_code) : null;
        $zoneType->flag = $request->flag;
        $zoneType->color = $request->color;
        $zoneType->sh_price = $request->sh_price;
        $zoneType->save();
        return redirect()->to(route('admin.zone_type.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ZoneType $zoneType
     * @return Response
     */
    public function edit(ZoneType $zoneType)
    {
        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('zones', explode(',', $f->conditions))) {
                array_push($flags, $f);
            }
        }
        return view('admin.zone_type.edit', compact('zoneType', 'flags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ZoneType $zoneType
     * @return Response
     */
    public function update(Request $request, ZoneType $zoneType)
    {
        $zoneType['name'] = $request->name;
        $zoneType['zip_code'] = isset($request->zip_code) ? implode(',', $request->zip_code) : null;
        $zoneType['flag'] = $request->flag;
        $zoneType['color'] = $request->color;
        $zoneType['sh_price'] = $request->sh_price;
        $zoneType->update();
        return redirect()->to(route('admin.zone_type.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ZoneType $zoneType
     * @return Response
     */
    public function destroy(ZoneType $zoneType)
    {
        try {
            $zoneType->delete();
            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back();
        }
    }

    public function zoneImport(Request $request, Excel $excel)
    {
        $excel->import(new ZoneImport(), $request->file('file'));

        return redirect()->back();
    }

    public function zoneExport(Excel $excel)
    {
        return $excel->download(new ZoneExport(), 'Zone.xlsx');
    }


}
