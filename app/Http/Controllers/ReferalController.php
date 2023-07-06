<?php

namespace App\Http\Controllers;

use App\Referal;
use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReferalController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('referals')){
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
        $referals = Referal::orderBy('id', 'desc')->get();
        return view('admin.referal.index', compact('referals'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.referal.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'bonus' => 'required',
            'level' => 'required'
        ]);
        
        $newReferal = new Referal($request->all());
       
        $newReferal->save();
        
        return redirect()->route('admin.referal.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Referal $referal
     * @return Response
     */
    public function edit(Referal $referal)
    {
        return view('admin.referal.edit', compact('referal'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Referal $referal
     * @return Response
     */
    public function update(Request $request, Referal $referal)
    {
        $request->validate([
            'name'  => 'required',
            'bonus' => 'required',
            'level' => 'required'
        ]);
    
        $referal->update($request->all());
        
        $referal->save();
    
        return redirect()->route('admin.referal.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Referal $referal
     * @return Response
     */
    public function destroy(Referal $referal)
    {
        try{
            $referal->delete();
            return redirect()->back();
        }catch (Exception $exception){
            return redirect()->back();
        }
    }
}
