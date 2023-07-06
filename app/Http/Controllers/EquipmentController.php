<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Inventory;
use App\Equipment;
use Illuminate\Http\Request;
use Storage;

class EquipmentController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('Equipments')){
            return abort(404);
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
		
		$colors = array("danger","success","blue","indigo","brown");
	
        $equipments = Equipment::orderBy('created_at', 'desc')->get();
		
		foreach($equipments as $k => $equipment)
		{
			$equipments[$k]->items = Inventory::whereIn('id',explode(',',$equipment->item_ids))->select('name')->get();
		}
        return view('admin.equipment.index', compact('equipments','colors'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $items = Inventory::get();
        return view('admin.equipment.create', compact('items'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        
        $equipment = new Equipment($request->all());
        $equipment->save();
        return redirect()->to(route('admin.equipment.index'));
        
    }
    
    public function show(equipment $equipment)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Equipment $equipment
     * @return mixed
     */
    public function edit(equipment $equipment)
    {
        try {
            $items = Inventory::get();
            return view('admin.equipment.edit', compact('equipment', 'items'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    
    public function update(Request $request, equipment $equipment)
    {
        
        $equipment->update($request->all());
        
        return redirect()->to(route('admin.equipment.index'));
    }
    
    public function destroy(equipment $equipment)
    {
        $equipment->delete();
        return redirect()->back();
    }
    
}
