<?php

namespace App\Http\Controllers;

use App\Accuracy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccuracyController extends Controller
{
    
    public function __construct()
    {
	
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		$accuracys = Accuracy::get();
        return view('admin.accuracy.index',compact('accuracys'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {	
        return view('admin.accuracy.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		$accuracy = new Accuracy($request->all());
        $accuracy->save();
        return redirect()->to(route('admin.accuracy.index'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Accuracy $accuracy
     * @return Response
     */
	public function edit(Accuracy $accuracy)
    {
        return view('admin.accuracy.edit', compact('accuracy'));
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Accuracy $accuracy
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //Accuracy::find($id)->update($request->all());
		
		$accuracy['label'] = $request->label;
        $accuracy['min'] = $request->min;
        $accuracy['max'] = $request->max;
        Accuracy::find($id)->update($accuracy);
		
        return redirect()->to(route('admin.accuracy.index'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Accuracy $accuracy
     * @return Response
     */
    public function destroy(Accuracy $accuracy)
    {
       
    }
}
