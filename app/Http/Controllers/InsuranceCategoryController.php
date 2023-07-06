<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\InsuranceCategory;
use App\Designation;
use Illuminate\Http\Request;

class InsuranceCategoryController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('insurance_categories')){
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
		$designations = Designation::get();
        $insuranceCategories = InsuranceCategory::orderBy('id', 'DESC')->get();
        return view('admin.insurance.index', compact('insuranceCategories','designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$designations = Designation::get();
        return view('admin.insurance.create',compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['ratio'] = implode(':', $request['ratio']);
        
        $newInsuranceCategory = new InsuranceCategory($request->all());
        $newInsuranceCategory->save();

        return redirect()->route('admin.insurance.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InsuranceCategory  $insuranceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insuranceCategory = InsuranceCategory::find($id);
		$designations = Designation::get();
        return view('admin.insurance.edit', compact('insuranceCategory','designations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsuranceCategory  $insuranceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['ratio'] = implode(':', $request['ratio']);
        InsuranceCategory::find($id)->update($request->all());
        return redirect()->route('admin.insurance.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsuranceCategory  $insuranceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InsuranceCategory::find($id)->delete();
        return redirect()->back();
    }
}
