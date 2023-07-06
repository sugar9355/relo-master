<?php

namespace App\Http\Controllers;

use App\Designation;
use App\Helpers\Helper;
use App\Video;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('designation_videos')){
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
        $videos = Video::orderBy('id', 'desc')->get();
        return view('admin.video.index', compact('videos'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $designations = Designation::all();
        return view('admin.video.create', compact('designations'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		
        // $request->validate([
            // 'designation_id' => 'required',
            // 'video'          => 'required|mimes:mp4'
        // ]);
        
        // $video = $request->file('video');
        
        // $fileName = md5($video->getClientOriginalName() . time()) . '.' . $video->getClientOriginalExtension();
        // $video->move('./uploads/video/', $fileName);
        // $request['file'] = $fileName;
        // $request['designation_id'] = json_encode($request->get('designation_id'));
        
        $newVideo = new Video($request->all());
        $newVideo->save();
		
		// $video['description'] = $request->editor;
		// $video['created_at'] = now();
		// $video['updated_at'] = now();
		//Video::save_description($video);
        
        return redirect()->route('admin.video.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return Response
     */
    public function show(Video $video)
    {
        return view('admin.video.view', compact('video'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Video $video
     * @return Response
     */
    public function edit(Video $video)
    {
        $designations = Designation::all();
        return view("admin.video.edit", compact('video', 'designations'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Video $video
     * @return Response
     */
    public function update(Request $request, Video $video)
    {
        // $request->validate([
            // 'designation_id' => 'required',
        // ]);
        
        //$request['designation_id'] = json_encode($request['designation_id']);
        $video->update($request->all());
        
        return redirect()->route('admin.video.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Video $video
     * @return Response
     */
    public function destroy(Video $video)
    {
        try{
            File::delete('./uploads/video/'.$video->file);
            $video->delete();
            return redirect()->back();
        }catch (Exception $exception){
            dd($exception->getMessage());
        }
    }
}
