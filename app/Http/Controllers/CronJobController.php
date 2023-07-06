<?php

namespace App\Http\Controllers;


use App\JobAssignedUser;
use App\Designation;
use App\UserSchedule;
use App\Opportunity;
use App\Level;
use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CronJobController extends Controller
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
	
	public function AssignBadges()
    {
		$level = Level::get();
		$badges_res = Designation::select('id','name','level')->get();
		
		$badges = array();
		foreach($badges_res as $badge_val)
		{
			$badges[$badge_val->level]['badge_name'] = $badge_val->name;
			$badges[$badge_val->level]['badge_id'] = $badge_val->id;
		}
		
		//=======================================================================
		// 						Captain Working Hours
		//=======================================================================
		
			$c_param['status'] = 'Completed';
			$c_param['captain'] = 1;
			$working_hours = UserSchedule::CalculateWorkingHours($c_param)->get();
			
			foreach($working_hours as $captain)
			{
				foreach($level as $lvl)
				{
					if($captain->hours >= $lvl->hours)
					{
						$badge['user_id'] = $captain->captain_id;
						$badge['badge_id'] =  $badges[$lvl->level]['badge_id'];
						$badge['badge_name'] =  "'".$badges[$lvl->level]['badge_name']."'";
						$badge['bonus'] =  $lvl->bonus;
						$badge['ref_bonus'] =  $lvl->ref_bonus;
						$badge['level'] = $lvl->level ;
						$badge['hours'] = $captain->hours;
						$badge['created_at'] =  "'".now()."'";
						$badge['updated_at'] = "'".now()."'";
						
						$values = '';
						foreach($badge as $k => $v)
						{
							$values .= $v .',' ;
						}
						
						$values = rtrim($values,',');
						
						JobAssignedUser::UpdateUserBadges($values);
					}
				}
			}
			
		//=======================================================================
		// 						Helper Working Hours
		//=======================================================================
		
			$c_param['status'] = 'Completed';
			$c_param['helper'] = 1;
			$working_hours = UserSchedule::CalculateWorkingHours($c_param)->get();
			
			foreach($working_hours as $captain)
			{
				foreach($level as $lvl)
				{
					if($captain->hours >= $lvl->hours)
					{
						$badge['user_id'] = $captain->helper_id;
						$badge['badge_id'] =  $badges[$lvl->level]['badge_id'];
						$badge['badge_name'] =  "'".$badges[$lvl->level]['badge_name']."'";
						$badge['bonus'] =  $lvl->bonus;
						$badge['ref_bonus'] =  $lvl->ref_bonus;
						$badge['level'] = $lvl->level ;
						$badge['hours'] = $captain->hours;
						$badge['created_at'] =  "'".now()."'";
						$badge['updated_at'] = "'".now()."'";
						
						$values = '';
						foreach($badge as $k => $v)
						{
							$values .= $v .',' ;
						}
						
						$values = rtrim($values,',');
						
						JobAssignedUser::UpdateUserBadges($values);
					}
				}
			}
			
		//=======================================================================
		// 						Technician Working Hours
		//=======================================================================
		
			$c_param['status'] = 'Completed';
			$c_param['technician'] = 1;
			$working_hours = UserSchedule::CalculateWorkingHours($c_param)->get();
			
			foreach($working_hours as $captain)
			{
				foreach($level as $lvl)
				{
					if($captain->hours >= $lvl->hours)
					{
						$badge['user_id'] = $captain->technician_id;
						$badge['badge_id'] =  $badges[$lvl->level]['badge_id'];
						$badge['badge_name'] =  "'".$badges[$lvl->level]['badge_name']."'";
						$badge['bonus'] =  $lvl->bonus;
						$badge['ref_bonus'] =  $lvl->ref_bonus;
						$badge['level'] = $lvl->level ;
						$badge['hours'] = $captain->hours;
						$badge['created_at'] =  "'".now()."'";
						$badge['updated_at'] = "'".now()."'";
						
						$values = '';
						foreach($badge as $k => $v)
						{
							$values .= $v .',' ;
						}
						
						$values = rtrim($values,',');
						
						JobAssignedUser::UpdateUserBadges($values);
					}
				}
			}
			
		//=======================================================================	
		
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
