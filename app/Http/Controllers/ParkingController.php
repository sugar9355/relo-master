<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Imports\ZoneImport;
use App\Parking;
use App\Exports\zoneExport;
//use App\Imports\zoneImport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel;

class ParkingController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('parking')){
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
        $parking = Parking::orderBy('id', 'desc')->get();
        return view('admin.parking.index', compact('parking'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.parking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $parking = new Parking($request->all());
        $parking->save();
        return redirect()->to(route('admin.parking.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Parking $parking
     * @return Response
     */
    public function edit(Parking $parking)
    {
        return view('admin.parking.edit', compact('parking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Parking $parking
     * @return Response
     */
    public function update(Request $request, Parking $parking)
    {
        $parking->update($request->all());
        $parking->save();
        return redirect()->to(route('admin.parking.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Parking $parking
     * @return Response
     */
    public function destroy(Parking $parking)
    {
        try {
            $parking->delete();
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
