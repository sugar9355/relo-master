<?php

namespace App\Http\Controllers;

use App\HubLocation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HubLocationController extends Controller
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
       
       $hublocation = HubLocation::first();;
        return view('admin.hublocation.index', compact('hublocation'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.hublocation.create', compact('hublocation'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $newHubLocationController = new HubLocationController($request->all());
        $newHubLocationController->save();
        return redirect()->route('admin.hublocation.index', compact('hublocation'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param HubLocationController $role
     * @return Response
     */
    public function edit(HubLocationController $hublocation)
    {
       
        $hublocation = HubLocation::first();
        return view('admin.hublocation.edit', compact('hublocation'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param HubLocationController $role
     * @return Response
     */
    public function update(Request $request,  $id)
    {
   
        $update['address'] = $request->address;
        $update['lat'] = $request->lat;
        $update['lng'] = $request->lng;
        HubLocation::where('id', $id)->update($update);
       
      
    
        return redirect()->route('admin.dashboard');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param HubLocationController $role
     * @return Response
     */
    public function destroy(HubLocationController $hublocation)
    {
        try {
            $hublocation->delete();
            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back();
        }
    }
    
    /**
     * Show the form for giving permission to role.
     *
     * @param $id
     * @return Response
     */
    public function assign($id)
    {
        $rolePermission = HubLocationController::find($id)->permissions;
        $permissions = Permission::all();
        return view('admin.hublocation.assign.permission', compact('id', 'rolePermission', 'permissions'));
    }
    
    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function assignPermission(Request $request, $id)
    {
        $assignedPermission = $request->all();
        $permissions = Permission::all();
        $role = HubLocationController::with('permissions')->find($id);
        
        foreach ($permissions as $permission) {
            if (isset($assignedPermission[$permission->name])) {
                $role->removePermissionTo($permission);
                $role->givePermissionTo($permission);
            }else{
                $role->removePermissionTo($permission);
            }
        }
        
        return redirect()->route('admin.role.assign', $id);
    }
    
    
}
