<?php

namespace App\Http\Controllers;

use App\Opportunity;
use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OpportunityController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('Opportunitys')){
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
        $Opportunitys = Opportunity::orderBy('id', 'desc')->get();
        return view('admin.opportunity.index', compact('Opportunitys'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.opportunity.create');
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
            'name'  => 'required|unique:job_opportunity',
            'hourly_rate' => 'required',
			'role' => 'required|in:captain,helper,technician',
			//'validaity' => 'required',
			'description' => 'required',
            
        ]);
	    
        $newOpportunity = new Opportunity($request->all());
        $newOpportunity->save();
        
        return redirect()->route('admin.opportunity.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Opportunity $Opportunity
     * @return Response
     */
    public function edit(Opportunity $Opportunity)
    {
        return view('admin.opportunity.edit', compact('Opportunity'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Opportunity $Opportunity
     * @return Response
     */
    public function update(Request $request, Opportunity $Opportunity)
    {
        $request->validate([
            'name'  => 'required',
            'hourly_rate' => 'required',
            'role' => 'required|in:captain,helper,technician',
			//'validaity' => 'required',
			'description' => 'required',

        ]);
    
        $Opportunity->update($request->all());
        $Opportunity->save();
    
        return redirect()->route('admin.opportunity.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Opportunity $Opportunity
     * @return Response
     */
    public function destroy(Opportunity $Opportunity)
    {
        try{
            $Opportunity->delete();
            return redirect()->back();
        }catch (Exception $exception){
            return redirect()->back();
        }
    }
}
