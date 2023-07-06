<?php

namespace App\Http\Controllers;

use App\InsuranceCategory;
use App\StorageInsuranceDetails;
use App\StorageLocation;
use App\UserJunkRequest;
use App\UserMovingRequest;
use App\UserStorageRequest;
use App\UserStorageRequestItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class HomeControllerBackup extends Controller
{
    
    protected $UserAPI;
    
    /**
     * Create a new controller instance.
     *
     * @param UserApiController $UserAPI
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $Response = $this->UserAPI->request_status_check()->getData();
        
        if (empty($Response->data)) {
            $services = $this->UserAPI->services();
            return view('user.dashboard', compact('services'));
        } else {
            return view('user.ride.waiting')->with('request', $Response->data[0]);
        }
    }
    
    /**
     * Show the application profile.
     *
     * @return Response
     */
    public function profile()
    {
        return view('user.account.profile');
    }
    
    /**
     * Show the application profile.
     *
     * @return Response
     */
    public function edit_profile()
    {
        return view('user.account.edit_profile');
    }
    
    /**
     * Update profile.
     *
     * @param Request $request
     * @return Response
     */
    public function update_profile(Request $request)
    {
        return $this->UserAPI->update_profile($request);
    }
    
    /**
     * Show the application change password.
     *
     * @return Response
     */
    public function change_password()
    {
        return view('user.account.change_password');
    }
    
    /**
     * Change Password.
     *
     * @return Response
     */
    public function update_password(Request $request)
    {
        return $this->UserAPI->change_password($request);
    }
    
    /**
     * Trips.
     *
     * @return Response
     */
    public function trips()
    {
        list($trips, $storageTrips, $junkTrips) = $this->UserAPI->trips();
        
        return view('user.ride.trips', compact('trips', 'storageTrips', 'junkTrips'));
    }
    
    /**
     * Payment.
     *
     * @return Response
     */
    public function payment()
    {
        $cards = (new Resource\CardResource)->index();
        return view('user.account.payment', compact('cards'));
    }
    
    
    /**
     * Wallet.
     *
     * @return Response
     */
    public function wallet(Request $request)
    {
        $cards = (new Resource\CardResource)->index();
        return view('user.account.wallet', compact('cards'));
    }
    
    /**
     * Promotion.
     *
     * @return Response
     */
    public function promotions_index(Request $request)
    {
        $promocodes = $this->UserAPI->promocodes();
        return view('user.account.promotions', compact('promocodes'));
    }
    
    /**
     * Add promocode.
     *
     * @return Response
     */
    public function promotions_store(Request $request)
    {
        return $this->UserAPI->add_promocode($request);
    }
    
    /**
     * Upcoming Trips.
     *
     * @return Response
     */
    public function upcoming_trips()
    {
        list($trips, $storageTrips, $junkTrips) = $this->UserAPI->upcoming_trips();
        return view('user.ride.upcoming', compact('trips', 'storageTrips', 'junkTrips'));
    }
    
    
    public function showTrip($type, $id)
    {
		
        if ($type == 'junk') {
            $request = UserJunkRequest::with('userMovingRequestItems', 'locations', 'User')->findOrFail($id);
            return view('user.ride.junk_request', compact('request'));
        }
        
        if ($type == 'storage') {
            $request = UserStorageRequest::with('userMovingRequestItems', 'locations', 'User')->findOrFail($id);
            return view('user.ride.storage_request', compact('request'));
        }
        
        $request = UserMovingRequest::with('userMovingRequestItems', 'locations', 'User')->findOrFail($id);
        return view('user.ride.request', compact('request'));
    }
    
    public function getStorageItems($id)
    {
        $items = UserStorageRequestItem::where('user_storage_request_id', '=', $id)->get();
        try {
            $view = view('user.ride.modal_content', compact('items', 'id'));
            $html = $view->render();
            return response()->json(['html' => $html], 200);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 200);
        }
//        return response()->json($items, 200);
    }
    
    public function storeReturnStorageRequest($id)
    {
        $requestObject = UserStorageRequest::with('userMovingRequestItems', 'locations', 'insuranceDetails')->find($id);
        $requestObject->drop = 1;
        $requestObject->save();
        
        $storageRequest = $requestObject->toArray();
        $storageRequest['status'] = "Pending";
        $storageRequest['booking_date'] = $storageRequest['drop_date'];
        $storageRequest['parent_id'] = $storageRequest['id'];
        unset($storageRequest['min']);
        unset($storageRequest['vehicle_schedule']);
        unset($storageRequest['vehicle_type']);
        unset($storageRequest['charge_deposit']);
        unset($storageRequest['deposit']);
        unset($storageRequest['receipt_url']);
        unset($storageRequest['max']);
        unset($storageRequest['created_at']);
        unset($storageRequest['id']);
        unset($storageRequest['updated_at']);
        unset($storageRequest['quotation']);
        $storageRequest['junk_removal'] = json_encode([]);
        $cartItems = $storageRequest['user_moving_request_items'];
        unset($storageRequest['user_moving_request_items']);
        $locations = $storageRequest['locations'];
        unset($storageRequest['locations']);
        $insuranceDetails = $storageRequest['insurance_details'];
        unset($storageRequest['insurance_details']);
        $newStorageRequest = new UserStorageRequest($storageRequest);
        $newStorageRequest->save();
        $locationId = $newStorageRequest->id;
        
        foreach ($cartItems as $cart) {
            $itemOptions = json_decode($cart['options']);
            $itemOptions->pickup = "";
            $cartOptions = [
                'user_storage_request_id' => $locationId,
                'name'                    => $cart['name'],
                'options'                 => json_encode($itemOptions),
                'price'                   => 0
            ];
            $newCartItem = new UserStorageRequestItem($cartOptions);
            $newCartItem->save();
        }
        
        foreach ($locations as $location) {
            array_splice($location, 0, 1);
            array_splice($location, count($location) - 2, 2);
            $location['user_storage_request_id'] = $locationId;
            $newLocation = new StorageLocation($location);
            $newLocation->save();
        }
        
        foreach ($insuranceDetails as $insuranceDetail) {
            array_splice($insuranceDetail, 0, 1);
            array_splice($insuranceDetail, count($insuranceDetail) - 2, 2);
            $insuranceDetail['user_storage_request_id'] = $locationId;
            $newInsuranceDetail = new StorageInsuranceDetails($insuranceDetail);
            $newInsuranceDetail->save();
        }
        
        return redirect()->back();
    }
    
}
