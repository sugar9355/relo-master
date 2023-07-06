<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Inventory;
use App\Material;
use Illuminate\Http\Request;
use Storage;

class MaterialController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('Materials')){
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
    
        $materials = Material::orderBy('created_at', 'desc')->get();
        
        foreach($materials as $k => $material)
        {
            $materials[$k]->items = Inventory::whereIn('id',explode(',',$material->item_ids))->select('name')->get();
        }
        return view('admin.material.index', compact('materials','colors'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $items = Inventory::get();
        return view('admin.material.create', compact('items'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        
        $material = new Material;
        $material->name = $request->get('name');
        $material->price = $request->get('price');
        $material->qty = $request->get('qty');
        
        $material->save();
        return redirect()->to(route('admin.material.index'));
        
    }
    
    public function show(material $material)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Material $material
     * @return mixed
     */
    public function edit(material $material)
    {
        try {
            $items = Inventory::get();
            return view('admin.material.edit', compact('material', 'items'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    
    public function update(Request $request, material $material)
    {
        
        $material->update($request->all());
        
        return redirect()->to(route('admin.material.index'));
    }
    
    public function destroy(material $material)
    {
        $material->delete();
        return redirect()->back();
    }
    
}
