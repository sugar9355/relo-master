<?php

namespace App\Http\Controllers;

use App\Room;
use App\StorageHub;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StorageHubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $storageHubs = StorageHub::orderBy('id', 'DESC')->get();
        return view('admin.storage_hub.index', compact('storageHubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.storage_hub.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request['time'] = ($request->get('time')) ?: 0;
        
        $newStorageHub = new StorageHub($request->all());
        $newStorageHub->save();
        
        $roomNames = $request->get('room_name');
        $roomsSqFeet = $request->get('room_sq');
    
        $this->storeRooms($roomNames, $newStorageHub, $roomsSqFeet);
    
        return redirect()->route('admin.storage_hub.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function edit($id)
    {
        $storageHub = StorageHub::with('rooms')->find($id);
        return view('admin.storage_hub.edit', compact('storageHub'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $storageHub = StorageHub::with('rooms')->find($id);
        $storageHub->update($request->all());
        
        $this->removeStorageHubRooms($storageHub);
        
        $roomNames = $request->get('room_name');
        $roomsSqFeet = $request->get('room_sq');
    
        $this->storeRooms($roomNames, $storageHub, $roomsSqFeet);
    
        return redirect()->route('admin.storage_hub.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param StorageHub $id
     * @return void
     */
    public function destroy($id)
    {
        try{
            $storageHub = StorageHub::with('rooms')->find($id);
            $this->removeStorageHubRooms($storageHub);
            $storageHub->delete();
            return redirect()->back();
        }catch (\Exception $exception){
            return redirect()->back();
        }
    }
    
    /**
     * @param $roomNames
     * @param StorageHub $newStorageHub
     * @param $roomsSqFeet
     */
    public function storeRooms($roomNames, StorageHub $newStorageHub, $roomsSqFeet)
    {
        foreach ($roomNames as $index => $roomName) {
            $newRoomOptions = [
                'storage_hub_id' => $newStorageHub->id,
                'name'           => $roomName,
                'sq_feet'        => $roomsSqFeet[$index]
            ];
            
            $newRoom = new Room($newRoomOptions);
            $newRoom->save();
        }
    }
    
    /**
     * @param $storageHub
     */
    public function removeStorageHubRooms($storageHub)
    {
        foreach ($storageHub->rooms as $room) {
            $room->delete();
        }
    }
    
}
