<?php

namespace App\Http\Controllers;


use App\Role;
use App\Level;
use App\Designation;
use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('levels')){
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
        $levels = Level::orderBy('id', 'desc')->get();
		
		foreach($levels as $lvl)
		{
			$lvl_ids[] = $lvl->id;
		}
		$designation = Level::GetLevelsFactors(array('level_ids'=>$lvl_ids))->get();
		
        return view('admin.level.index', compact('levels','designation'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$roles = Role::get();
		$designation = Level::GetLevelFactors()->get();
		$designation_type = Designation::GetBadgesType();
		
		return view('admin.level.create', compact('designation','designation_type','roles'));
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
            'name'  => 'required|unique:levels',
            'bonus' => 'required',
			'ref_bonus' => 'required',
            'level' => 'required|unique:levels',
        ]);
		
        DB::beginTransaction();
		
			$insert['name'] = $request->name;
			$insert['bonus'] = $request->bonus;
			$insert['ref_bonus'] = $request->ref_bonus;
			$insert['level'] = $request->level;
			$insert['hours'] = $request->hours;
			
			$level_id = Level::insertGetId($insert);
			
			$lvl_factor = $request->lvl_factor;
			
			Level::DeleteLevelFactors(array('level_id'=>$level_id));
			
			foreach($lvl_factor as $key => $factor)
			{
				if(isset($factor['check']) && $factor['check'] == 1)
				{
					if(isset($request->role_A) || isset($request->role_B)  || isset($request->role_C))
					{
						$param['factor_id'] = $key;
						$param['level_id'] = $level_id;
						//$param['factor_value'] = $factor['value'];
						$param['role_A'] = isset($request->role_A) ? $request->role_A : 0;
						$param['role_B'] = isset($request->role_B) ? $request->role_B : 0;
						$param['role_C'] = isset($request->role_C) ? $request->role_C : 0;
						$param['created_at'] = time();
						$param['updated_at'] = time();
						
						Level::SaveLevelFactors($param);	
					}
				}
			}
		DB::commit();
        
        return redirect()->route('admin.level.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Level $level
     * @return Response
     */
    public function edit(Level $level)
    {
		$roles = Role::get();
		$designation = Level::GetLevelFactors(array('level_id'=>$level->id))->get();
		
		$designation_type = Designation::GetBadgesType();
		
		$role_check = array();
		foreach($designation as $d)
		{
			if(isset($d->lf_role_A) && $d->lf_role_A == 4)
			{
				$role_check['role_A'] = 4;
			}
			
			if(isset($d->lf_role_B) && $d->lf_role_B == 5)
			{
				$role_check['role_B'] = 5;
			}
			
			if(isset($d->lf_role_C) && $d->lf_role_C == 6)
			{
				$role_check['role_C'] = 6;
			}
		}
		
        return view('admin.level.edit', compact('level','designation','designation_type','roles','role_check'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Level $level
     * @return Response
     */
    public function update(Request $request, Level $level)
    {
		//dd($request->all());
        $request->validate([
            'name'  => 'required',
            'bonus' => 'required',
			'ref_bonus' => 'required',
            'level' => 'required'
        ]);
		
		DB::beginTransaction();
		
			$update['name'] = $request->name;
			$update['bonus'] = $request->bonus;
			$update['ref_bonus'] = $request->ref_bonus;
			$update['level'] = $request->level;
			$update['hours'] = $request->hours;
			$where['id'] = $level->id;
			
			$level->update($update,$where);
			
			$lvl_factor = $request->lvl_factor;
			
			Level::DeleteLevelFactors(array('level_id'=>$level->id));
			
			foreach($lvl_factor as $key => $factor)
			{
				if(isset($factor['check']) && $factor['check'] == 1)
				{
					if(isset($request->role_A) || isset($request->role_B)  || isset($request->role_C))
					{
						$param['factor_id'] = $key;
						$param['level_id'] = $level->id;
						//$param['factor_value'] = $factor['value'];
						$param['role_A'] = isset($request->role_A) ? $request->role_A : 0;
						$param['role_B'] = isset($request->role_B) ? $request->role_B : 0;
						$param['role_C'] = isset($request->role_C) ? $request->role_C : 0;
						$param['created_at'] = time();
						$param['updated_at'] = time();
						
						Level::SaveLevelFactors($param);	
					}
				}
			}
			
		DB::commit();
		
        return redirect()->route('admin.level.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Level $level
     * @return Response
     */
    public function destroy(Level $level)
    {
        try{
            $level->delete();
            return redirect()->back();
        }catch (Exception $exception){
            return redirect()->back();
        }
    }
}
