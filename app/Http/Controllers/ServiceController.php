<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Service;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('service_types')){
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
        $services = Service::orderBy('id', 'desc')->get();
        return view("admin.services.index", compact('services'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("admin.services.create");
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('picture')) {
            $request['image'] = Helper::upload_picture($request->file("picture"));
        }
        
        $services = new Service($request->all());
        $services->save();
        
        return redirect()->to(route("admin.services.index"));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return Response
     */
    public function edit(Service $service)
    {
        return view("admin.services.edit", compact('service'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Service $service
     * @return Response
     */
    public function update(Request $request, Service $service)
    {
        $service->update($request->all());
        return redirect()->to(route("admin.services.index"));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return Response
     * @throws Exception
     */
    public function destroy(Service $service)
    {
        try {
            $imageArray = explode('/', $service->image);
            $imageName = end($imageArray);
            File::delete('./uploads/' . $imageName);
            $service->delete();
            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back();
        }
    }
}
