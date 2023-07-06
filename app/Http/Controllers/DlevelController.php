<?php

namespace App\Http\Controllers;

use App\Dlevel;
use App\Level;
use App\Role;
use App\Helpers\Helper;
use App\Inventory;
use App\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DlevelController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('dlevels')){
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
        $dlevels = Dlevel::orderBy('dlevel', 'desc')->get();
        
        
        if(isset($dlevels[0]))
        {
            foreach($dlevels as $dlevel)
            {
                $dlevel_ids[] = $dlevel->dlevel_id;
            }
            
            $param['dlevel_ids'] = $dlevel_ids;
            
            $crew = Dlevel::GetCrewCombination()->get();
            
            $roles = Role::get();
        }
        
        return view('admin.dlevel.index', compact('dlevels','crew','roles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $items = Inventory::get();
        $categories = Category::get();
        $ranking = Inventory::GetRanking();
        $roles = Role::where('operator',1)->get();
        $levels = Level::orderBy('level', 'desc')->get();

        // Getting max flights number
        $max_flights_num = DB::table('inventory_time_flights')->max('num_flights');

        return view('admin.dlevel.create', compact('items','ranking','categories','roles','levels', 'max_flights_num'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        
        $newDlevel = new Dlevel();
        
        $newDlevel->dlevel      = 'Level-'.$request->dlevel;
        $newDlevel->hoisting    = $request->hoisting;
        $newDlevel->weight       = $request->weight;
        $newDlevel->wei_min = $request->wei_min;
        $newDlevel->wei_max = $request->wei_max;

        // Additional fields
        if (isset($request->groundfloor)) {
            $newDlevel->groundfloor = implode(',', $request->groundfloor);
        } else {
            $newDlevel->groundfloor = 0;
        }

        if (isset($request->bulkhead)) {
            $newDlevel->bulkhead = implode(',', $request->bulkhead);
        } else {
            $newDlevel->bulkhead = 0;
        }

        if (isset($request->entrance)) {
            $newDlevel->entrance = implode(',', $request->entrance);
        } else {
            $newDlevel->entrance = 0;
        }

        if(isset($request->stairs))
        {
            $newDlevel->stairs   = implode(',', $request->stairs);
        }
        else
        {
            $newDlevel->stairs  = 0;
        }
        
        if(isset($request->stairs_type))
        {
            $newDlevel->stairs_type   = implode(',', $request->stairs_type);
        }
        else
        {
            $newDlevel->stairs_type  = 0;
        }
        if(isset($request->elevator))
        {
            $newDlevel->elevator   = implode(',', $request->elevator);
        }
        else
        {
            $newDlevel->elevator  = 0;
        }
        if(isset($request->ranking))
        {
            $newDlevel->ranking    = implode(',', $request->ranking);
        }
        else
        {
            $newDlevel->ranking  = 0;
        }
        if(isset($request->category))
        {
            $newDlevel->category   = implode(',', $request->category);
        }
        else
        {
            $newDlevel->category = 0;
        }
        if(isset($request->items))
        {
            $newDlevel->items  = implode(',', $request->items);
        }
        else
        {
            $newDlevel->items  = 0;
        }
        
        $newDlevel->save();
        
        // if(isset($request->roles) && isset($request->level) && $request->dlevel > 0)
        // {
            // $roles = $request->roles;
            // $levels = $request->level;
            
            // foreach($roles as $k => $role)
            // {
                
                // $combination['dlevel_id'] = $newDlevel->id;
                // $combination['crew_ratio'] = $newDlevel->crew_ratio;
                // $combination['roles'] = implode(',', $roles[$k]);
                // $combination['levels'] = implode(',', $levels[$k]);
                // $combination['created_at'] = now();
                // $combination['updated_at'] = now();
                // //print_r($combination);
                // Dlevel::AddCrewCombination($combination);
            // }
        // }
        
        //$newCategory->time = $request->get('time');
        
        return redirect()->to(route('admin.dlevel.index'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Dlevel $dlevel
     * @return Response
     */
    public function AddCrew(Request $request,$id)
    {
    
        $dlevel = Dlevel::where('id',$id)->first();
        
        if(isset($request->add_crew))
        {
            if(isset($request->roles) && isset($request->level) && $dlevel->id > 0)
            {
                if(isset($request->crew_ratio) && $request->crew_ratio > 0)
                {    
                    $crew_ratio = $request->crew_ratio;
                }
                else
                {
                    $crew_ratio = 1;
                }
                $combination['dlevel_id'] = $dlevel->id;
                $combination['crew_ratio'] = $crew_ratio;
                $combination['roles'] = implode(',', $request->roles);
                $combination['levels'] = implode(',', $request->level);
                $combination['created_at'] = now();
                $combination['updated_at'] = now();
                //print_r($combination);
                Dlevel::AddCrewCombination($combination);
                
                return redirect()->to(route('admin.AddCrew',$id));
            }
        }
    
        $control['count'] = 1;
        if(isset($request->add_control))
        {
            $control['count'] = $request->add_control + 1;
        }

        $roles = Role::where('operator',1)->get();
        $levels = Level::orderBy('level', 'desc')->get();
        
        if(isset($request->roles))
        {
            $control['roles'] = $request->roles;
        }
        if(isset($request->level))
        {
            $control['level'] = $request->level;
        }
        
        // echo '<pre>';
        // print_r($control);
        // echo '</pre>';
        // die;
        
        $crew = Dlevel::GetCrewCombination(array('dlevel'=> $id ))->get();
        
        return view('admin.dlevel.add_crew', compact('dlevel','roles','levels','crew','control'));
    }
    
    public function edit(Request $request,Dlevel $dlevel)
    {    
            $items = Inventory::get();
            $ranking = Inventory::GetRanking();
            $categories = Category::get();
            $roles = Role::where('operator',1)->get();
            $levels = Level::orderBy('level', 'desc')->get();
            
            $crew = Dlevel::GetCrewCombination(array('dlevel'=> $dlevel->id ))->get();
            
            $range = array(0=>0,10=>1,20=>2,30=>3,40=>4,50=>5,60=>6,70=>7,80=>8,90=>9,100=>10);

            // Getting max flights number
            $max_flights_num = DB::table('inventory_time_flights')->max('num_flights');

            return view('admin.dlevel.edit', compact('dlevel', 'items','ranking','categories','range','roles','levels','crew', 'max_flights_num'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Dlevel $dlevel
     * @return Response
     */
    public function update(Request $request, Dlevel $dlevel)
    {
    
        //dd($request->all());
        $newDlevel['dlevel']         = 'level-'.$request->dlevel;
        $newDlevel['weight']         = $request->weight;
        $newDlevel['hoisting']       = $request->hoisting;
        $newDlevel['wei_min']       = $request->wei_min;
        $newDlevel['wei_max']       = $request->wei_max;
        
        // Additional fields
        if (isset($request->groundfloor)) {
            $newDlevel['groundfloor'] = implode(',', $request->groundfloor);
        } else {
            $newDlevel['groundfloor'] = 0;
        }

        if (isset($request->bulkhead)) {
            $newDlevel['bulkhead'] = implode(',', $request->bulkhead);
        } else {
            $newDlevel['bulkhead'] = 0;
        }

        if (isset($request->entrance)) {
            $newDlevel['entrance'] = implode(',', $request->entrance);
        } else {
            $newDlevel['entrance'] = 0;
        }

        if(isset($request->stairs))
        {
            $newDlevel['stairs']  = implode(',', $request->stairs);
            
        }
        else
        {
            $newDlevel['stairs']  = 0;
        }
        
        if(isset($request->stairs_type))
        {
            $newDlevel['stairs_type']   = implode(',', $request->stairs_type);
        }
        else
        {
            $newDlevel['stairs_type']  = 0;
        }
        if(isset($request->elevator))
        {
            $newDlevel['elevator']   = implode(',', $request->elevator);
        }
        else
        {
            $newDlevel['elevator']  = 0;
        }
        if(isset($request->ranking))
        {
            $newDlevel['ranking']    = implode(',', $request->ranking);
        }
        else
        {
            $newDlevel['ranking']  = 0;
        }
        if(isset($request->category))
        {
            $newDlevel['category']   = implode(',', $request->category);;
        }
        else
        {
            $newDlevel['category'] = 0;
        }
        if(isset($request->items))
        {
            $newDlevel['items']  = implode(',', $request->items);
        }
        else
        {
            $newDlevel['items']  = 0;
        }
        
        
        $dlevel->update($newDlevel);

        if(isset($request->roles) && isset($request->level) && $request->dlevel > 0)
        {
            $roles = $request->roles;
            $levels = $request->level;
            
            foreach($roles as $k => $role)
            {
                
                $combination['dlevel_id'] = $dlevel->id;
                $combination['roles'] = implode(',', $roles[$k]);
                $combination['levels'] = implode(',', $levels[$k]);
                $combination['created_at'] = now();
                $combination['updated_at'] = now();
                //print_r($combination);
                Dlevel::AddCrewCombination($combination);
            }
        }
        
        return redirect()->to(route('admin.dlevel.index'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Dlevel $dlevel
     * @return Response
     */
    public function destroy(Request $request,Dlevel $dlevel)
    {
        if(isset($request->btn_delete_crew))
        {
            Dlevel::DeleteCrewCombination(array('pk_id'=>$request->delete_crew));
        }
        elseif(isset($request->delete_dlevel))
        {
            try 
            {
                Dlevel::DeleteCrewCombination(array('dlevel_id'=>$dlevel->id));
                $dlevel->delete();
                
                return redirect()->back();
            } 
            catch (Exception $exception) 
            {
                return redirect()->back();
            }
        }
        
        return redirect()->back();
    }

    public function edit_crews($dlevel_id, $c_c_id) {
        $c_c_data = DB::table('crew_combination')->where([
            'id' => $c_c_id
        ])->first();
        $all_roles = Role::where('operator', 1)->get();
        $all_levels = Level::orderBy('level', 'desc')->get();

        return view('admin.dlevel.edit_crews', compact('c_c_data', 'all_roles', 'all_levels'));
    }

    public function save_crew_updates(Request $request) {
        $roles = implode(',', $request->roles);
        $levels = implode(',', $request->levels);
        DB::table('crew_combination')->where('id', $request->c_c_id)->update(array(
            'roles' => $roles,
            'levels' => $levels
        ));
        return redirect()->to(route('admin.dlevel.index'));
    }
}
