<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Helpers\Helper;
use App\Permission;
use App\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('roles')){
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
        $roles = Role::where('operator',1)->get();
        return view('admin.roles.index', compact('roles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $newRole = new Role($request->all());
        $newRole->save();
        return redirect()->route('admin.role.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $demand_types = DB::table('customer_demand')->select('*')->get();
        foreach ($demand_types as $demand) {
            $rate_data = DB::table('role_demand_rate')->where([
                'role_id' => $role->id,
                'demand_id' => $demand->id
                ])->select('rate')->get()->first();
            if ($rate_data == null) {
                $demand->rate = 0;
            } else {
                $demand->rate = ($rate_data->rate) ? $rate_data->rate : 0;
            }
        }
        $role->charging_customer = ($role->charging_customer) ? $role->charging_customer : 0;
        return view('admin.roles.edit', compact('role', 'demand_types'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        $role->save();
        $demand_rates = json_decode($request->demand_rates, true);
        DB::table('role_demand_rate')->where([
            'role_id' => $role->id,
        ])->delete();
        foreach ($demand_rates as $rate) {
            DB::table('role_demand_rate')->insert([
                'role_id' => $role->id,
                'demand_id' => $rate['demand_id'],
                'rate' => $rate['rate'],
            ]);
        }
        // echo '<pre>';
        // print_r($request->toArray());
        // echo '</pre>';
        // exit;
        return redirect()->route('admin.role.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
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
        $rolePermission = Role::find($id)->permissions;
        $permissions = Permission::all();
        return view('admin.roles.assign.permission', compact('id', 'rolePermission', 'permissions'));
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
        $role = Role::with('permissions')->find($id);
        
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
