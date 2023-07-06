<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Helpers\Helper;
use App\Role;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SystemUserController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('system_users')) {
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
        $systemUsers = Admin::orderBy("id", 'desc')->where('id', '>', 1)->get();
        return view("admin.system_users.index", compact('systemUsers'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.system_users.create', compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|unique:system_users,email|email|max:255',
            'mobile'     => 'digits_between:6,13',
            'password'   => 'required|min:6|confirmed',
            'role'       => 'required',
        ]);
        try {
            
            $user = $request->all();
            
            $user['name'] = $user['first_name'] . " " . $user['last_name'];
            $user['password'] = Hash::make($user['password']);
            
            $newUser = new Admin($user);
            $newUser->save();
            $newUser->assignRole($request->get('role'));
            
            return back()->with('flash_success', 'User Details Saved Successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Admin $systemUser
     * @return Response
     */
    public function edit(Admin $systemUser)
    {
        return view("admin.system_users.edit", compact('systemUser'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Admin $systemUser
     * @return Response
     */
    public function update(Request $request, Admin $systemUser)
    {
        $request['name'] = $request->get('first_name') . " " . $request->get("last_name");
        
        $systemUser->update($request->all());
        $systemUser->save();
        
        return redirect()->route('admin.system_user.index')->with('flash_success', 'User Updated Successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Admin $systemUser
     * @return Response
     */
    public function destroy(Admin $systemUser)
    {
        try {
            $systemUser->delete();
            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back();
        }
    }
    
}
