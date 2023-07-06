<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Worker;
use App\WorkerDevice;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Exception;

class WorkerController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('workers')){
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
        $providers = Worker::with('device')
            ->orderBy('id', 'DESC')->get();
        
        return view('admin.workers.index', compact('providers'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.workers.create');
    }
    
    public function status($id)
    {
        
        try {
            $worker = Worker::findOrFail($id);
            $message = 'Disapproved';
            $status = 'banned';
            
            if ($worker->status === 'banned'){
                $status = 'approved';
                $message = 'Approved';
            }
            
            $worker->update(['status' => $status]);
            return back()->with('flash_success', "Provider ".$message);
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', "Something went wrong! Please try again later.");
        }
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
            'email'      => 'required|unique:providers,email|email|max:255',
            'mobile'     => 'digits_between:6,13',
            'avatar'     => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password'   => 'required|min:6|confirmed',
        ]);
        
        try {
            
            $worker = $request->all();
            
            $worker['password'] = Hash::make($request->get('password'));
            if ($request->hasFile('avatar')) {
                $worker['avatar'] = Helper::upload_picture($request->avatar);
            }

			DB::beginTransaction();            

            $worker = new Worker($worker);
            $worker->save();

			$update['user_id'] = $worker->id;

			$update['Mon'] = $request->monday;
			$update['Tue'] = $request->tuesday;
			$update['Wed'] = $request->wednesday;
			$update['Thu'] = $request->thursday;
			$update['Fri'] = $request->friday;
			$update['time'] = $request->hours.''.$request->unit;

			$update['created_at'] = time();
			$update['update_at'] = time();
			$update['created_by'] = 1;
			$update['update_by'] = 1;

			UserSchedule::create($update);
			
			DB::commit();

            
            return back()->with('flash_success', 'Worker Details Saved Successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Worker Not Found');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Worker $worker
     * @return Response
     */
    public function edit(Worker $worker)
    {
        return view('admin.workers.edit', compact('worker'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Worker $worker
     * @return Response
     */
    public function update(Request $request, Worker $worker)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);
    
        //try {

			DB::beginTransaction();
        
        
            if($request->hasFile('avatar')) {
                if($worker->avatar) {
                    File::delete('/uploads/'.$worker->avatar);
                }
                
                $worker->avatar = Helper::upload_picture($request->avatar);
            }
        
            $worker->first_name = $request->first_name;
            $worker->last_name = $request->last_name;
            $worker->mobile = $request->mobile;
            $worker->save();

			$update['user_id'] = $worker->id;
			
			$schedule = UserSchedule::where('user_id',$update['user_id'])->first();
			
			$update['Mon'] = $request->monday;
			$update['Tue'] = $request->tuesday;
			$update['Wed'] = $request->wednesday;
			$update['Thu'] = $request->thursday;
			$update['Fri'] = $request->friday;
			$update['time'] = $request->hours.''.$request->unit;

			$update['created_at'] = time();
			$update['update_at'] = time();
			$update['created_by'] = 1;
			$update['update_by'] = 1;
			
			if(!empty($schedule))
			{
				UserSchedule::where('user_id',$update['user_id'])->update($update);
			}
			else
			{
				UserSchedule::create($update);
			}
			
			DB::commit();
        
            return redirect()->route('admin.worker.index')->with('flash_success', 'Provider Updated Successfully');
        // }
    
        // catch (ModelNotFoundException $e) {
            // return back()->with('flash_error', 'Provider Not Found');
        // }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Worker $worker
     * @return Response
     */
    public function destroy(Worker $worker)
    {
        try{
            $id = $worker->id;
            $worker->delete();
            $workerDevice = WorkerDevice::where('worker_id', '=', $id)->firstOrFail();
            $workerDevice->delete();
            return redirect()->back();
        }catch (Exception $exception){
            return redirect()->back();
        }
    }
    
}
