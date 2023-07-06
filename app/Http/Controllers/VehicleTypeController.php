<?php

namespace App\Http\Controllers;

use App\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::orderBy('created_at', 'desc')->get();
        return view('admin.vehicle_type.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('admin.vehicle_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'abbreviation' => 'required|unique:vehicle_types',
            'color' => 'required',
            'width' => 'required',
            'height' => 'required',
            'breadth' => 'required',
            'add_charges' => 'required',
        ]);

        $vehicleType = new VehicleType($request->all());
        $vehicleType->volume = $request->width * $request->height * $request->breadth;
        $vehicleType->save();
        return redirect()->to(route('admin.vehicleType.index'));
    }

    public function edit(VehicleType $vehicleType)
    {
        try {
            return view('admin.vehicle_type.edit', compact('vehicleType'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'name' => 'required',
            'abbreviation' => 'required|unique:vehicle_types,abbreviation,'.$vehicleType->id,
            'color' => 'required',
            'width' => 'required',
            'height' => 'required',
            'breadth' => 'required',
            'add_charges' => 'required',
        ]);

        $vehicleType->name = $request->get('name');
        $vehicleType->abbreviation = $request->get('abbreviation');
        $vehicleType->color = $request->get('color');
        $vehicleType->add_charges = $request->get('add_charges');
        $vehicleType->width = $request->get('width');
        $vehicleType->height = $request->get('height');
        $vehicleType->breadth = $request->get('breadth');
        $vehicleType->volume = $request->width * $request->height * $request->breadth;
        $vehicleType->save();
        return redirect()->to(route('admin.vehicleType.index'));
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return redirect()->back();
    }
}
