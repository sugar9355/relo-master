<?php

namespace App\Http\Controllers;

use App\Role;
use App\Level;
use App\Designation;
use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DesignationController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('designations')){
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
        $badge_factors = Designation::GetBadgesFactor();
        $badge_types = Designation::GetBadgesType();
        $level = Level::get();
        $roles = Role::get();

        $join['level'] = true;
        $badge_level = Level::GetLevelsFactors(null,$join)->get();
        $designations = Designation::orderBy('id', 'desc')->get();

        return view('admin.designation.index', compact('designations','level','badge_types','badge_factors','badge_level','roles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::whereBetween('id', [4, 8])->get();
        $badge_factors = Designation::GetBadgesFactor();
        $badge_types = Designation::GetBadgesType();
        $level = Level::get();
        // $roles = Role::get();
        return view('admin.designation.create', compact('level','badge_types','badge_factors','roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'  => 'required|unique:designations',
            'options' => 'required',
            'badge_type' => 'required',
            'roles' => 'required',
        ]);

        $insert['name'] = $request->name;
        $insert['bonus'] = isset($request->bonus) ? $request->bonus : null;
        $insert['badge_type'] = $request->badge_type;
        $insert['options'] = isset($request->options) ? implode(',', $request->options) : null;
        $insert['wei_min'] = isset($request->wei_min) ? $request->wei_min : null;
        $insert['wei_max'] = isset($request->wei_max) ? $request->wei_max : null;
        $insert['weight'] = !empty($request->weight) ? $request->weight : null;
        $insert['volumetric_capacity_min'] = isset($request->volumetric_capacity_min) ? $request->volumetric_capacity_min : null;
        $insert['volumetric_capacity_max'] = isset($request->volumetric_capacity_max) ? $request->volumetric_capacity_max : null;
        $insert['volumetric_capacity'] = !empty($request->volumetric_capacity) ? $request->volumetric_capacity : null;
        $insert['insurance_amount_min'] = isset($request->insurance_amount_min) ? $request->insurance_amount_min : null;
        $insert['insurance_amount_max'] = isset($request->insurance_amount_max) ? $request->insurance_amount_max : null;
        $insert['insurance_amount'] = !empty($request->insurance_amount) ? $request->insurance_amount : null;
        $insert['dis_assembly'] = isset($request->dis_assembly) ? implode(',', $request->dis_assembly) : null;
        $insert['hoisting'] = isset($request->hoisting) ? $request->hoisting : null;
        $insert['stairs'] = isset($request->stairs) ? implode(',', $request->stairs) : null;
        $insert['roles'] = isset($request->roles) ? implode(',', $request->roles) : null;
        $insert['description'] = isset($request->description) ? $request->description : null;

        $newDesignation = new Designation($insert);
        $newDesignation->save();

        if($request->hasFile('file')) {
            $this->upload_image($request, $newDesignation->id);
        }

        return redirect()->route('admin.designation.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Designation $designation
     * @return Response
     */
    // public function edit(Request $request, $id)
    // {
    //     $param['id'] = $id;
    //     $designation = Designation::GetBadge($param);
    //     $badge_factors = Designation::GetBadgesFactor();
    //     $badge_types = Designation::GetBadgesType();
        
    //     $levels = Level::get();
    //     return view('admin.designation.edit', compact('designation','levels','badge_types','badge_factors'));
    // }

    public function edit(Designation $designation) {
        $roles = Role::whereBetween('id', [4, 8])->get();
        $badge_factors = Designation::GetBadgesFactor();
        $badge_types = Designation::GetBadgesType();
        $level = Level::get();

        return view('admin.designation.edit', compact('level','badge_types','badge_factors','roles', 'designation'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Designation $designation
     * @return Response
     */
    public function update(Request $request, Designation $designation)
    {
        if (isset($_FILES['file']['name'])) 
        {
            $this->upload_image($request,$designation->id);
        }
        else {
            $update['name'] = $request->name;
            $update['bonus'] = isset($request->bonus) ? $request->bonus : null;
            $update['badge_type'] = $request->badge_type;
            $update['options'] = isset($request->options) ? implode(',', $request->options) : null;
            $update['wei_min'] = isset($request->wei_min) ? $request->wei_min : null;
            $update['wei_max'] = isset($request->wei_max) ? $request->wei_max : null;
            $update['weight'] = !empty($request->weight) ? $request->weight : null;
            $update['volumetric_capacity_min'] = isset($request->volumetric_capacity_min) ? $request->volumetric_capacity_min : null;
            $update['volumetric_capacity_max'] = isset($request->volumetric_capacity_max) ? $request->volumetric_capacity_max : null;
            $update['volumetric_capacity'] = !empty($request->volumetric_capacity) ? $request->volumetric_capacity : null;
            $update['insurance_amount_min'] = isset($request->insurance_amount_min) ? $request->insurance_amount_min : null;
            $update['insurance_amount_max'] = isset($request->insurance_amount_max) ? $request->insurance_amount_max : null;
            $update['insurance_amount'] = !empty($request->insurance_amount) ? $request->insurance_amount : null;
            $update['dis_assembly'] = isset($request->dis_assembly) ? implode(',', $request->dis_assembly) : null;
            $update['hoisting'] = isset($request->hoisting) ? $request->hoisting : null;
            $update['stairs'] = isset($request->stairs) ? implode(',', $request->stairs) : null;
            $update['roles'] = isset($request->roles) ? implode(',', $request->roles) : null;
            $update['description'] = isset($request->description) ? $request->description : null;

            $where['id'] = $designation->id;
        }

        $designation->where($where)->update($update);
    
        return redirect()->route('admin.designation.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Designation $designation
     * @return Response
     */
    public function destroy(Designation $designation)
    {
        try{
            $designation->delete();
            return redirect()->back();
        }catch (Exception $exception){
            return redirect()->back();
        }
    }

    /**
     * Upload image for badges
     * 
     * @param Badge_id $id
     * @param Request $request
     */
    function upload_image($request, $id) {
        $ext = ltrim(strstr($_FILES['file']['name'], '.'), '.');
        $path = public_path() . "/uploads/badges";

        $file_name = $id . '_' . $request->name . '.' . $ext;
        $target_file = $path.'/'. $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            $update['image_path']     = "/uploads/badges/" . $file_name;
            // $update['file_name']     = $_FILES['file']['name'];
            // $update['file_size']     = $_FILES['file']['size'];
            // $update['file_type']     = $_FILES['file']['type'];
            // $update['extension']     = $ext;
            $where['id'] = $id;
            Designation::UpdateBadges($update, $where);
            return true;
        } 
        else 
        {
            return false;
        }
    }
}
