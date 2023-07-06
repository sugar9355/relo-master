<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Inventory;
use App\Preset;
use App\Supply;
use Illuminate\Http\Request;
use Storage;

class PresetController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('presets')){
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
        $presets = Preset::orderBy('created_at', 'desc')->get();

        foreach($presets as $k => $preset)
        {
            $presets[$k]->items = Inventory::whereIn('id',explode(',',$preset->item_ids))->select('name', 'id')->get();
        }
        return view('admin.preset.index', compact('presets'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $items = Inventory::get();
        $supplies = Supply::get();
        return view('admin.preset.create', compact('items', 'supplies'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $item_ids = implode(',', $request->get('item_ids'));

        $quantities = '';
        foreach ($request->get('item_ids') as $id) {
            $quantities .= $request->all()['quantity_' . $id] . ',';
        }
        $preset = new Preset;
        $preset->name = $request->get('name');
        if ($request->hasFile('picture')) {
            $preset->image = Helper::upload_picture($request->picture);
        }
        $preset->item_ids = $item_ids;
        $preset->item_quantity = $quantities;
        $preset->supply = (isset($request->supply)) ? $request->supply : null;
        $preset->time = (isset($request->time)) ? $request->time : null;
        $preset->save();
        return redirect()->to(route('admin.preset.index'));
        
    }
    
    public function show(Preset $preset)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Preset $preset
     * @return mixed
     */
    public function edit(Preset $preset)
    {
        try {
            $items = Inventory::get();
            $supplies = Supply::get();
            return view('admin.preset.edit', compact('preset', 'items', 'supplies'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    
    public function update(Request $request, Preset $preset)
    {
        $item_ids = implode(',', $request->get('item_ids'));

        $quantities = '';
        foreach ($request->get('item_ids') as $id) {
            $quantities .= $request->all()['quantity_' . $id] . ',';
        }
        $preset->name = $request->get('name');
        if ($request->hasFile('picture')) {
            Storage::delete($preset->image);
            $preset->image = Helper::upload_picture($request->picture);
        }
        $preset->item_ids = $item_ids;
        $preset->item_quantity = $quantities;
        $preset->supply = (isset($request->supply)) ? $request->supply : null;
        $preset->time = (isset($request->time)) ? $request->time : null;
        $preset->save();
        
        return redirect()->to(route('admin.preset.index'));
    }
    
    public function destroy(Preset $preset)
    {
        $preset->delete();
        return redirect()->back();
    }
    
}