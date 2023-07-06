<?php

namespace App\Http\Controllers;

use Setting;
use DateTime;
use App\Card;
use App\Category;
use App\InsuranceCategory;
use App\InsuranceDetails;
use App\Inventory;
use App\JunkInsuranceDetails;
use App\JunkLocation;
use App\Location;
use App\Preset;
use App\Question;
use App\Service;
use App\StorageHub;
use App\StorageInsuranceDetails;
use App\StorageLocation;
use App\UserJunkRequest;
use App\UserJunkRequestItem;
use App\UserMovingRequest;
use App\UserMovingRequestItem;
use App\UserStorageRequest;
use App\UserStorageRequestItem;
use App\Truck;
use App\VehicleSchedule;
use App\booking;
use Illuminate\Support\Facades\Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Stripe;

class HomeController extends Controller
{
	public function save_step1($request,$booking_id)
	{
		$service['step'] = 2;
		$service['user_id'] = Auth::user()->id;
		$service['service_type_id'] = $request->service_type_id;
		$booking_id = $booking = booking::insertGetId($service);
		return redirect()->to('booking/'.$booking_id);
	}
	public function save_step2($request,$booking_id)
	{
		$validator = Validator::make($request->all(), 
		[
			'location' => 'required',
		]);
		
		if($validator->fails()) 
		{
			return back()->to('booking/'.$booking_id);
		}
		else
		{
			DB::beginTransaction();
			
				foreach($request->location as $location)
				{
					$data['booking_id'] = $booking_id;
					$data['location'] = $location;
					booking::save_location($data);
				}
				
				$step_update['step'] = 3;
				booking::where('booking_id',$booking_id)->update($step_update);
			
			DB::commit();
			
			return redirect()->to('booking/'.$booking_id);
		}
	}
	public function save_step3($request,$booking_id)
	{
		
		$validator = Validator::make($request->all(), 
		[
			'flexibilty' 		=> 'required',
			'primary_date' 		=> 'required',
			'secondary_date'	=> 'required',
			'start_time' 		=> 'required',
		]);
		
		if($validator->fails()) 
		{
			return back()->withErrors($validator);
		}
		else
		{
			$data['step'] = 4;
			$data['flexibilty'] = $request->flexibilty;
			$data['primary_date'] = $request->primary_date;
			$data['secondary_date'] = $request->secondary_date;
			$data['start_time'] = $request->start_time;
			booking::where('booking_id',$booking_id)->update($data);
			
			return redirect()->to('booking/'.$booking_id);
		}
	}
	public function save_step4($request,$booking_id)
	{
		
		$validator = Validator::make($request->all(), 
		[
			'floor' 		=> 'required',
			'zip_code' 		=> 'required',
			'stair_kind'	=> 'required',
			'stair_type' 	=> 'required',
			'flights' 		=> 'required',
			'parking' 		=> 'required',
		]);
		
		if($validator->fails()) 
		{
			return back()->to('booking/'.$booking_id);
		}
		else
		{
			//dd($request->all());
			DB::beginTransaction();
			
			for($i=0; $i<=1; $i++)
			{
				$data['floor']			= $request->floor[$i];
				$data['zip_code']		= $request->zip_code[$i];
				$data['stair_kind'] 	= $request->stair_kind[$i];
				$data['stair_type'] 	= $request->stair_type[$i];
				$data['flights'] 		= $request->flights[$i];
				$data['parking'] 		= $request->parking[$i];
				$data['walk'] 			= $request->walk[$i];
				$data['comments'] 		= $request->comments[$i];
				
				$booking_location_id 	= $request->booking_location_pk[$i];
				
				booking::update_location($data,$booking_id,$booking_location_id);
			}
			
			$step_update['step'] = 5;
			booking::where('booking_id',$booking_id)->update($step_update);
			
			DB::commit();
			return redirect()->to('booking/'.$booking_id);
		}
	}
	public function save_step5($request,$booking_id)
	{
		$validator = Validator::make($request->all(), 
		[
			'item_id' 		=> 'required',
			'item_name' 	=> 'required',
			'item_image'	=> 'required',
			'quantity' 		=> 'required',
			'similar' 		=> 'required',
			'ranking' 		=> 'required',
			'answer'		=> 'required',
		]);
		
		if($validator->fails()) 
		{
			return back()->to('booking/'.$booking_id);
		}
		else
		{
			 //dd($request->all());
			
			DB::beginTransaction();
			
			$data['item_id']		= $request->item_id;
			$data['item_name']		= $request->item_name;
			$data['item_image'] 	= $request->item_image;
			$data['quantity'] 		= $request->quantity;
			$data['similar'] 		= $request->similar;
			$data['ranking'] 		= $request->ranking;
			$data['booking_id'] 	= $booking_id;
			booking::save_item($data);
			
			foreach($request->answer as $q_id => $val)
			{
				$item_answer['booking_id'] = $booking_id;
				$item_answer['item_id'] = $request->item_id;
				$item_answer['question_id'] = $q_id;
				$item_answer['answer'] = $val;
				booking::save_answer($item_answer);	
			}
			
			DB::commit();
			
			return redirect()->to('booking/'.$booking_id);
		}
	}
	public function save_step6($request,$booking_id)
	{
		
		//dd($request->all());
		
		DB::beginTransaction();
		
		foreach($request->items as $key => $insurance)
		{
			$data['booking_id'] = $booking_id;
			$data['booking_item_id'] = $key;
			$data['insurance_id'] = $request->insurance_type;
			$data['we_pay'] = $insurance['we_pay'];
			$data['you_pay'] = $insurance['you_pay'];
		}
		booking::save_insurance($data);
		
		$step_update['step'] = 7;
		booking::where('booking_id',$booking_id)->update($step_update);
		
		DB::commit();
		
		return redirect()->to('booking/'.$booking_id);
	
	}
	public function save_finish($request,$booking_id)
	{
		$step_update['step'] = 0;
		booking::where('booking_id',$booking_id)->update($step_update);
		
		return redirect()->to('booking/'.$booking_id);
	}
	
	public function booking(Request $request,$booking_id = null,$step = null)
    {
		//dd($request->all());
		if (!Auth::User()) 
		{
            return redirect()->to('showLoginForm/');
        }
		
		$services = Service::all();
		
		$this->btn_save_step($booking_id,$step);	
		
		if(isset($request->btn_submit))
		{
			if($request->btn_submit == 1)
			{
				return $this->save_step1($request,$booking_id);
			}
			if($request->btn_submit == 2)
			{
				return $this->save_step2($request,$booking_id);
			}
			if($request->btn_submit == 3)
			{
				return $this->save_step3($request,$booking_id);
			}
			if($request->btn_submit == 4)
			{	
				return $this->save_step4($request,$booking_id);
			}
			if($request->btn_submit == 5)
			{
				return $this->save_step5($request,$booking_id);
			}
			if($request->btn_submit == 6)
			{
				return $this->save_step6($request,$booking_id);
			}
			if($request->btn_submit == 'finish')
			{
				return $this->save_finish($request,$booking_id);
			}
			
		}
		else
		{
			if(!empty($booking_id))
			{
				$booking = booking::where('booking_id',$booking_id);
				$booking = $booking->first();
				
				if($booking->step == 1)
				{
					return view('booking.services', compact('services','booking'));		
				}
				elseif($booking->step == 2)
				{
					return view('booking.map', compact('services','booking'));		
				}
				elseif($booking->step == 3)
				{
					return view('booking.date_time', compact('services','booking'));		
				}
				elseif($booking->step == 4)
				{
					$booking_location = booking::get_booking_location($booking_id);
					return view('booking.location', compact('services','booking','booking_location'));		
				}
				elseif($booking->step == 5)
				{
					$items = Inventory::all();
					
					$selected_items = booking::get_booking_items($booking_id);
					$selected_item_answers = booking::get_booking_item_answers($booking_id);

					// Get Ranking
					$ranking = Inventory::GetRanking();

					foreach($items as $itm)
					{
						$item_ids[] = $itm->id;
					}

					$question = Question::whereIn('item_id',$item_ids)->get();
					
					$presets = Preset::all();
					$distanceAndMinutes = session()->get("mapLocationDetails");
					
					return view('booking.shop', compact('services','booking','items','selected_items','question','ranking'));
				}
				elseif($booking->step == 6)
				{
					$selected_items = booking::get_booking_items($booking_id);
					$insuranceCategories = InsuranceCategory::all();
					return view('booking.insurance', compact('services','booking','selected_items','insuranceCategories'));
				}
				elseif($booking->step == 7)
				{
					$items = Inventory::all();
					
					$selected_items = booking::get_booking_items($booking_id);
					$selected_item_answers = booking::get_booking_item_answers($booking_id);

					// Get Ranking
					$ranking = Inventory::GetRanking();

					foreach($items as $itm)
					{
						$item_ids[] = $itm->id;
					}

					$question = Question::whereIn('item_id',$item_ids)->get();
					
					$presets = Preset::all();
					$distanceAndMinutes = session()->get("mapLocationDetails");
					
					return view('booking.checkout', compact('services','booking','items','selected_items','question','ranking'));
				}
			}
			else
			{
				return view('booking.services', compact('services','booking'));	
			}
		}
    }
	
	
	
	public function btn_save_step($booking_id,$step)
	{
		if(!empty($step))
		{
			$step_update['step'] = $step;
			booking::where('booking_id',$booking_id)->update($step_update);
			return redirect()->to('booking/'.$booking_id);
		}
	}
	

    // public function services()
    // {
        // $selected = session()->get('serviceType')['serviceType'];
        // $dataSelected = null;
        // if (!is_null($selected)){
            // $dataSelected = Service::where('name', '=', $selected)->first();
            // $dataSelected = $dataSelected->type;
        // }
        // $services = Service::all();
        // return view("services", compact('services', 'selected', 'dataSelected'));
    // }

    public function storeService(Request $request)
    {
        $service = Service::where('name', '=', $request->get('serviceType'))->first();
        session()->put("storage", 0);
        session()->put("junk", 0);
        if ($service->type == "Storage")
            session()->put("storage", 1);

        if ($service->type == "Junk Removal")
            session()->put('junk', 1);

        session()->put("serviceType", $request->only('serviceType'));
        return redirect()->to('map');
    }

    public function showMap()
    {
		
        $junk = session()->get("junk");
        $mapDetails = session()->get('mapLocationDetails');
        if (!$junk) {
            return view('map', compact('mapDetails'));
        }
        return view('junkMap', compact('mapDetails'));
    }

    public function insurance()
    {
        $insuranceCategories = InsuranceCategory::all();
        return view('insurance', compact('insuranceCategories'));
    }

    public function storeInsurance(Request $request)
    {
        $typeId = $request->get("insurance_type");
        $ratioArray = [];
        foreach (Cart::content() as $item) {
            $index = $typeId . "_" . $item->id;
            $ratioArray[] = implode(":", $request->get($index));
        }
        $insurance = [
            "type"  => $typeId,
            "ratio" => $ratioArray
        ];
        session()->put("insurance", $insurance);
        return redirect()->to("cart");
    }

    public function storeTempLocation(Request $request)
    {
        unset($request['_token']);
        session()->put("locationDetails", $request->all());
        return redirect()->to('shop');
    }

    public function storeTempMapLocation(Request $request)
    {
        unset($request['_token']);
        session()->put("mapLocationDetails", $request->all());
        return redirect()->to('date');
    }

    public function showDate()
    {
        return view("date");
    }

    public function location()
    {
        $locationDetail = json_decode(json_encode(session()->get("locationDetails")));
        $storageHubs = false;

        if (session()->get("storage") == 1) {
            $storageHubs = StorageHub::all();
        }

        $services = Service::all();
        $mapDetails = session()->get('mapLocationDetails');
        $locationPoints = [];

        if (!is_null($mapDetails)) {
            $locationPoints[] = $mapDetails['start'];
            if (isset($mapDetails['waypoints'])) {
                $locationPoints = array_merge($locationPoints, $mapDetails['waypoints']);
            }
            if (isset($mapDetails['end'])) $locationPoints[] = $mapDetails['end'];
        }

        return view('index', compact("services", 'locationDetail', 'locationPoints', 'storageHubs'));
    }

    public function storeTempDate(Request $request)
    {
        $dateType = $request->get("date_type");
        unset($request['_token']);
        $unSetIndex = "time_0";
        if (Str::endsWith($dateType, "F")) {
            $unSetIndex = "time";
        }
        unset($request[$unSetIndex]);
        session()->put("dateDetails", $request->all());
        $storage = session()->get("storage");
        if ($storage) {
            return redirect()->to("drop_date");
        }
        return redirect()->to('location');
    }

    public function showDropDate()
    {
        $storage = session()->get("storage");
        if (!$storage) {
            return redirect()->to('location');
        }
        return view("drop-date");
    }

    public function storeTempDropDate(Request $request)
    {
        $dateType = $request->get("date_type");
        unset($request['_token']);
        $unSetIndex = "time_0";
        if (Str::endsWith($dateType, "F")) {
            $unSetIndex = "time";
        }
        unset($request[$unSetIndex]);
        session()->put("dropDateDetails", $request->all());
        return redirect()->to('location');
    }

	public function AddInventoryItems(Request $request)
    {
		//dd($request->all());
		
		$validator = Validator::make($request->all(), [
			'item_id' => 'required',
			'quantity' => 'required',
			'ranking' => 'required'
		]);
		
		if($validator->fails()) 
		{
			return redirect()->to('shop/'.$request->item_id);
		}
		else
		{
			$item[$request->item_id]['item_name'] = $request->item_name;
			$item[$request->item_id]['item_image'] = $request->item_image;
			$item[$request->item_id]['quantity'] = $request->quantity;
			$item[$request->item_id]['similar'] = $request->similar;
			$item[$request->item_id]['ranking'] = $request->ranking;
			$item[$request->item_id]['price'] = 0;
			$item[$request->item_id]['options'] = $request->answer;
			
			if($request->session()->exists('InventoryItems'))
			{
				$items = session()->get("InventoryItems");
				$items = array_merge($items,$item);	
				$request->session()->put('InventoryItems', $items);
			}
			else
			{
				$request->session()->put('InventoryItems', $items);
			}
			
			$items = session()->get("InventoryItems");
			
		}
		
		
		return redirect()->to('shop');
	}

    public function shop($item_id=null)
    {
		
		
		$junk = session()->get("junk");
		
		$items = Inventory::all();
		
		// Get Ranking
		$ranking = Inventory::GetRanking();
		
		foreach($items as $itm)
		{
			$item_ids[] = $itm->id;
		}
		
		$question = Question::whereIn('item_id',$item_ids)->get();
		
        if (!$junk) 
		{
            $presets = Preset::all();
            
            if (Cart::count() > 0) 
			{
                $cart = Cart::content();
                return view('shop', compact('presets', 'items','item_id', 'cart','ranking','question'));
            }
            $distanceAndMinutes = session()->get("mapLocationDetails");
            return view('shop', compact('presets', 'items','item_id', 'distanceAndMinutes','ranking','question'));
        }

        $presets = Preset::all();
        
        if (Cart::count() > 0) 
		{
            $cart = Cart::content();
            return view('junkShop', compact('presets', 'items','item_id', 'cart','ranking','question'));
        }
        $distanceAndMinutes = session()->get("mapLocationDetails");
        return view('junkShop', compact('presets', 'items','item_id', 'distanceAndMinutes','ranking','question'));

    }

    public function addPreSetCart($id)
    {
        $preset = Preset::find($id);
        $itemIds = explode(',', $preset->item_ids);
        $items = Inventory::whereIn('id', $itemIds)->get();
        return response()->json([
            'title'  => $preset->name,
            'data'   => $items,
            'status' => 200
        ], 200);
    }

    public function addToCart(Request $request, $id)
    {
		$ajax = $request->get("ajax");
		$ranking = $request->get("ranking");
		
		if($ajax == true)
		{
			$ranking_arr = session()->get("ranking");
			$ranking_arr['ranking_'.$id] = $ranking;
			session()->put("ranking", $ranking_arr);
		}
		else
		{
			$junk = $request->get("junk");
			if ($junk > 0) {
				if (is_null(session()->get("junk_items"))) {
					session()->put("junk_items", []);
				}
				$junk_items = session()->get("junk_items");
				$junk_items[] = ["id" => $id, "qty" => $junk];
				session()->put("junk_items", $junk_items);
			}

			$cart = Cart::content();
			
			$cartRowId = $cart->search(function ($cartItem) use ($id) {
				return $cartItem->id == $id;
			});

			if ($cartRowId) {
				$response = $this->update($request, $cartRowId);
				return $response;
			}

			$item = Inventory::find($id);
			$options[] = $request->get('options');
			$qty = $request->get("qty");
			for ($i = 0; $i < $qty; $i++) {
				$options[] = $request->get('options');
			}
			
			Cart::add($item->id, $item->name, $qty, 0, $options);
			return $this->getSuccessResponse();
		}
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::get($id);
        $qty = $cart->qty + $request->get('qty');
        $options = $cart->options;
        if ($request->get('options') == []) {
            $options[] = $options[count($cart->options) - 1];
        } else {
            $options[] = $request->get('options');
        }
        Cart::update($id, $qty);
        Cart::update($id, array(
            'options' => $options
        ));

        return $this->getSuccessResponse();
    }

    /**
     * @return JsonResponse
     */
    public function getSuccessResponse()
    {
        return response()->json([
            'code'    => '200',
            'message' => 'Success',
            'data'    => json_encode(Cart::content()),
        ], 200);
    }

    public function removeToCart(Request $request, $id)
    {

        $cart = Cart::content();
        $cartRowId = $cart->search(function ($cartItem) use ($id) {
            return $cartItem->id == $id;
        });
        $cart = Cart::get($cartRowId);
        $cartOptions = json_decode($cart->options);
        unset($cartOptions[count($cartOptions) - 1]);
        $qty = $request->get('qty');
        if ($qty <= 0) {
            Cart::remove($cartRowId);
            return $this->getSuccessResponse();
        }

        Cart::update($cartRowId, $qty);
        cart::update($cartRowId, [
            'options' => $cartOptions
        ]);

        return $this->getSuccessResponse();
    }

    public function getQuestions($id, $itemIds)
    {
		
		// Get Ranking
		$ranking = Inventory::GetRanking();
		
        $item = Inventory::find($id);
        $image = $item->image;
        $name = $item->name;
        $question = Question::with('answers')->whereItemId($id)->get();
        $locations = session()->get("mapLocationDetails");
        $tempLocations = $locations;
        $filteredLocation[] = $tempLocations['start'];
		
        if (isset($tempLocations['waypoints'])) 
		{
            foreach ($tempLocations['waypoints'] as $tempLocation) 
			{
                $filteredLocation[] = $tempLocation;
            }
        }
		
        if (isset($tempLocations['end'])) $filteredLocation[] = $tempLocations['end'];
		
        // $itemNames = Category::whereRaw('FIND_IN_SET(?,item_ids)', $name)->first()->item_ids;
        // $itemNames = explode(',', $itemNames);
		// $items = Inventory::whereIn("name", $itemNames)->whereNotIn('id', $itemIds)->get();
		
        $cart = Cart::content();
        $itemIds = array_map('intval', json_decode($itemIds));
        foreach ($cart as $cartItem) 
		{
            Arr::add($itemIds, count($itemIds), $cartItem->id);
        }
        $itemIds = array_unique($itemIds);
        $key = array_search($id, $itemIds);
        unset($itemIds[$key]);
        $itemIds = array_values($itemIds);
        
        return response()->json([
            'code'    => '200',
            'message' => 'Success',
            'data'    => [
                "image"     => $image,
                "questions" => $question,
                "locations" => $filteredLocation,
                //"items"     => $items,
                "item"      => $item,
				"ranking" 	=> $ranking
            ],
        ], 200);
    }

    public function checkoutShow()
    {
        session()->put("link", "/cart");

        $location = null;
        if (!Auth::User()) {
            $location = "login";
        }
        $junk = session()->get("junk");
        if (!$junk) {
            $items = Inventory::all();
            $junkItems = session()->get("junk_items");
            return view('checkout', compact('items', 'location', 'junkItems'));
        }

        $items = Inventory::all();
        $junkItems = session()->get("junk_items");
        return view('junkCheckout', compact('items', 'location', 'junkItems'));
    }

    public function updateJunk($index, $qty)
    {
        $junk_items = session()->get("junk_items");
        $junk_items[$index]['qty'] = $qty;
        session()->put("junk_items", $junk_items);
        return response()->json([], 200);
    }

    public function addJunk($id)
    {
        $junk_items = session()->get("junk_items");
        $junk_items[] = ['id' => $id, "qty" => 0];
        $index = count($junk_items) - 1;
        session()->put("junk_items", $junk_items);
        return response()->json(["name" => Inventory::find($id)->name, "index" => $index], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function checkout(Request $request)
    {
		
		DB::beginTransaction();
		
        $storage = session()->get("storage");
        if ($storage) {
            return $this->checkoutStorage($request);
        }
        $junk = session()->get("junk");
        if ($junk) {
            return $this->checkoutJunk();
        }
		
        $cartItems = Cart::content();
        $services = session()->get("serviceType");
        $mapOptions = session()->get("mapLocationDetails");
        $insuranceDetails = session()->get("insurance");
        $dateOptions = session()->get("dateDetails");
        $dateOptions = $this->refineDateOptions($dateOptions);
        $locationOptions = session()->get("locationDetails");
        $mapOptions = $this->refineMapOptions($mapOptions);
        $userMovingRequest = array_merge($mapOptions, $dateOptions, $services);
        $userMovingRequest['user_id'] = Auth::user()->id;
        $userMovingRequest['zonetype'] = $locationOptions['zip_code'][0] . ',' . end($locationOptions['zip_code']);
        $userMovingRequest['packaging'] = $request->get('packaging');
        $userMovingRequest['junk_removal'] = json_encode(session()->get("junk_items"));
        $userMovingRequest['accuracy'] = $request->get('accuracy');
        $location = new UserMovingRequest($userMovingRequest);
        $location->save();
        $request_id = $locationId = $location->id;
		
        foreach ($cartItems as $cart) {
            $options = json_decode($cart->options);
            for ($i = 0; $i < $cart->qty; $i++) {
                $requestItem = new UserMovingRequestItem();
                $requestItem->user_moving_request_id = $locationId;
                $requestItem->name = $cart->name;
                $requestItem->options = json_encode($options[$i]);
				
				if(isset(session()->get("ranking")["ranking_".$cart->id]))
				{
					$requestItem->ranking_id = session()->get("ranking")["ranking_".$cart->id];	
				}
				else
				{
					$requestItem->ranking_id = 0;		
				}
                $requestItem->price = $cart->price;
                $requestItem->save();
            }
        }

        foreach ($locationOptions['floor'] as $index => $floor) 
		{
            $newLocationOption = [
                'user_moving_request_id' => $locationId,
                'floor'                  => $floor,
                'zip_code'               => $locationOptions['zip_code'][$index],
                'location_question1'     => $locationOptions['location_question1'][$index],
                'detail_address'         => $locationOptions['detail_address'][$index],
                'location_note'          => $locationOptions['parking_' . $index],
                'location_question2'     => $locationOptions['walk_' . $index],
            ];

            if ($locationOptions['type_' . $index] == 'Both') {
                $newLocationOption['stair_type'] = $locationOptions['stair_type_' . $index];
                $newLocationOption['flight'] = $locationOptions['flight'][$index];
                //$newLocationOption['elevator_type'] = $locationOptions['elevator_type_' . $index];
            }

            if ($locationOptions['type_' . $index] == 'Elevator') {
                //$newLocationOption['elevator_type'] = $locationOptions['elevator_type_' . $index];
            }

            if ($locationOptions['type_' . $index] == 'Stairs') {
                $newLocationOption['stair_type'] = $locationOptions['stair_type_' . $index];
                $newLocationOption['flight'] = $locationOptions['flight'][$index];
            }
            $newLocation = new Location($newLocationOption);
            $newLocation->save();
        }

        $i = 0;
        foreach ($cartItems as $cartItem) {
            $newInsuranceOption = [
                'user_moving_request_id' => $locationId,
                'insurance_type'         => InsuranceCategory::find($insuranceDetails['type'])->name,
                'category_name'          => $cartItem->name,
                'qty'                    => $cartItem->qty,
                'ratio'                  => $insuranceDetails['ratio'][$i]
            ];

            $newInsuranceDetail = new InsuranceDetails($newInsuranceOption);
            $newInsuranceDetail->save();
            $i++;
        }
		
		//================================================
		//================================================
		
			$result = $this->calculate_job_time($request,$userMovingRequest,$locationOptions);
			
			// Get Available Time Of Already Assigned Truck
			// Get Available Truck Fall in Lat Lng Set Parameters By Admin 
			$truck_id = $this->get_available_truck($result,$mapOptions,$request_id,$userMovingRequest);
		
		//================================================
		//================================================
		
        // session()->remove("serviceType");
        // session()->remove("mapLocationDetails");
        // session()->remove("dateDetails");
        // session()->remove("locationDetails");
        // session()->remove("insurance");
		// session()->remove("ranking");
        // Cart::destroy();
		
		DB::commit();
		
		echo 123;
		return;
        return redirect()->to('thank-you');
    }
	
	
	function get_available_truck($result,$mapOptions,$request_id,$userMovingRequest)
	{
		$total_job_time = explode('.',$result[0])[0];
		$total_volume 	= $result[1];
		$total_weight 	= $result[2];
		
		// Get All Assigned Trucks Of date Current or greater then job date
		$v_param['prefer_date'] = session()->get("dateDetails")['prefer_date'];
		$v_param['start_time'] = session()->get("dateDetails")['time'];
		$v_param['over_all_minutes']  = $total_job_time = $total_job_time + $mapOptions['minutes'];
		
		$job_start_time = new DateTime($v_param['prefer_date'].' '.$v_param['start_time']);
		$job_end_time   = new DateTime($v_param['prefer_date'].' '.$v_param['start_time']);
		$job_end_time->modify("+{$total_job_time} minutes");
		//$job_end_time->modify("+40 minutes");
		
		$assigned_truck = UserMovingRequest::GetAllAssignedTrucks($v_param);
		
		if(isset($assigned_truck[0]))
		{
			// echo 123;
			// return;
			// echo '<pre>';
			// print_r($assigned_truck);
			// echo '</pre>';
			// die;
			
			$truck_ids = array();
			$invalid_trucks = array();
			
			foreach($assigned_truck as $key => $time)
			{
				$start_time = new DateTime($time->prefer_date.' '.$time->start_time);
				$end_time = new DateTime($time->prefer_date.' '.$time->end_time);
			
				if( ($job_start_time <= $start_time  &&  $start_time <= $job_end_time) ||  ($job_start_time <= $end_time  &&  $end_time <= $job_end_time) )
				{
					// Don't Include Truck 
					$invalid_trucks[$time->id] = $time->truck_id;
				}
				$truck_ids[] = $time->truck_id;
			}
			
			$truck_volumes = Truck::whereIn('id',$truck_ids)->where('volume','<',$total_volume)->pluck('volume','id as truck_id');
			
			foreach($truck_volumes as  $key => $volume)
			{
				$invalid_trucks[$volume->truck_id] = $volume->truck_id;
			}
		
			foreach($assigned_truck as  $key => $time)
			{
				if(!in_array($time->truck_id,$invalid_trucks))
				{
					$start_time = new DateTime($time->prefer_date.' '.$time->start_time);
					$end_time = new DateTime($time->prefer_date.' '.$time->end_time);
					
					// Prevoius job time
					if( $end_time < $job_start_time )
					{
						$valid_trucks_arr[$time->truck_id]['truck_id'] = $time->truck_id;
						$valid_trucks_arr[$time->truck_id]['left_d_lat'] = $time->d_lat;
						$valid_trucks_arr[$time->truck_id]['left_d_lng'] = $time->d_lng;
						$valid_trucks_arr[$time->truck_id]['start_time'] = $time->start_time;
						$valid_trucks_arr[$time->truck_id]['end_time'] = $time->end_time;
						$valid_trucks_arr[$time->truck_id]['prefer_date'] = $time->prefer_date;
					}
					
					// Next job time
					if( $start_time > $job_end_time )
					{
						// $valid_trucks_arr[$time->truck_id]['truck_id'] = $time->truck_id;
						// $valid_trucks_arr[$time->truck_id]['right_s_lat'] = $time->s_lat;
						// $valid_trucks_arr[$time->truck_id]['right_s_lng'] = $time->s_lng;
						// $valid_trucks_arr[$time->truck_id]['start_time'] = $time->start_time;
						// $valid_trucks_arr[$time->truck_id]['end_time'] = $time->end_time;
					}
					
					$valid_trucks_arr[$time->truck_id]['job_lat'] = $mapOptions['s_lat'];
					$valid_trucks_arr[$time->truck_id]['job_lng'] = $mapOptions['s_lng'];

				}
			}
			
			if(!empty($valid_trucks_arr))
			{
				$valid_trucks_dist = array();
				foreach($valid_trucks_arr as  $k => $truck)
				{
					if(!empty($truck['truck_id']) && !empty($truck['left_d_lat']) && !empty($truck['left_d_lng']))
					{
						$start_point = $truck['left_d_lat'] .','. $truck['left_d_lng'];
						$end_point = $truck['job_lat'] .','. $truck['job_lng'];
						
						$origins = 'origins='.$start_point;
						$destination = 'destinations='.$end_point;
						
						$key = 'key='. Setting::get('map_key');
						
						$url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
						$url .= '&'.$origins.'&'.$destination.'&'.$key;
						
						// get the json response from url
						$resp = json_decode(file_get_contents($url), true);
						
						if($resp['rows'][0]['elements'][0]['duration']['text'])
						{
							$valid_trucks_arr[$k]['dist_time'] = $resp['rows'][0]['elements'][0]['duration']['text'];
							$valid_trucks_dist[$k] = $resp['rows'][0]['elements'][0]['duration']['text'];
						}
					}
				}
				
				//dd($valid_trucks_dist);
				// Get smaller number
				
				if(!empty($valid_trucks_dist))
				{
					$dist_time = 0;
					foreach($valid_trucks_dist as  $key => $travel_time)
					{
						if($dist_time == 0)
						{
							$dist_time = $travel_time;
						}
						
						if($travel_time <= $dist_time)
						{
							$valid_truck = $valid_trucks_arr[$key];
						}
					}
					
					//dd($valid_trucks_dist_time);
					
					$start_time = new DateTime($valid_truck['prefer_date'].' '.$valid_truck['start_time']);
					$end_time = new DateTime($valid_truck['prefer_date'].' '.$valid_truck['end_time']);
					$end_time->modify($valid_truck['dist_time']);
					
					if( ($job_start_time <= $start_time  &&  $start_time <= $job_end_time) ||  ($job_start_time <= $end_time  &&  $end_time <= $job_end_time))
					{
						// Time Exceeded of prevoius job
						$valid_truck = null;
					}
				}
			}
		}	
		
		if(isset($valid_truck) && $valid_truck != null)
		{
			$truck_id = $valid_truck['truck_id'];
		}
		else
		{
			// Assign One Available Truck which Volume is Greater than Request Items Volume
			$t_param['volume'] = $total_volume;
			$t_param['prefer_date'] = $v_param['prefer_date'];
			$available_trucks = Truck::GetAllAvailableTruck($t_param);
			
			if(!empty($available_trucks))
			{
				$truck_id = $available_trucks->id;	
			}
			else
			{
				$truck_id = 0;	
			}
		}
			
		// Insert Truck Id into Request
		if(isset($truck_id))
		{
			$req_update['truck_id'] = $truck_id;
		}
		
		$req_update['start_time'] = $v_param['start_time'];
		$req_update['end_time'] = date('g:i A', strtotime("+{$total_job_time} minutes", strtotime($v_param['start_time'])));
		$req_update['exp_end_time'] = $req_update['end_time'];
		
		$req_update['volume'] = $total_volume;
		$req_update['weight'] = $total_weight;
		
		$req_update['over_all_minutes'] = $v_param['over_all_minutes'];
		
		UserMovingRequest::where('id',$request_id)->update($req_update);
		
		$start_time = session()->get("dateDetails")['time'];
		VehicleSchedule::insert(array('request_id'=>$request_id,'user_id'=>$userMovingRequest['user_id'],'truck_id'=>$truck_id,'assigned_on'=>now(),'start_time'=>$start_time,'created_at'=>now(),'updated_at'=>now()));
		
		$job['booking_id'] = $request_id;
		$job['user_id'] = Auth::user()->id;
		$job['created_at'] = time();
		$job['updated_at'] = time();
		$job['created_by'] = Auth::user()->id;
		$job['updated_by'] = Auth::user()->id;
		
		UserMovingRequest::AddAssignedJobUsers($job);
	}

	public function calculate_job_time($request,$userMovingRequest,$locationOptions)
	{
		
		// Get Ranking
		$ranking = Inventory::GetRanking();
		
		// 1.  Calculate Travelling Distance time
		$travel_dist_time = session()->get("mapLocationDetails")['minutes'];
		
		// 2. Calculate Inventory Items moving time
		$cartItems = Cart::content();
		$item_ids = array();
		
		// Get total Number Items
		foreach ($cartItems as $cart)
		{
			for ($i = 0; $i < $cart->qty; $i++) 
			{
				$item_ids[] = $cart->id;
			}
		}
		
		// Get Item Moving Time
		$items_moving_time = Inventory::GetInventoryItemTime($item_ids,$userMovingRequest['accuracy']);
		
		$total_volume = 0;
		$total_weight = 0;
		$total_item_move_time = 0;
		
		foreach ($cartItems as $cart)
		{
			// If One Or More then One Item
			if($cart->qty > 0)
			{
				foreach($items_moving_time as $k => $item)
				{
					if($item->id == $cart->id)
					{
						
						// Get Volume Inventory Items
						$total_volume = $total_volume + $item->volume;
						$total_weight = $total_weight + $item->weight; 
						
						if( count($locationOptions['flight']) > 0)
						{
							for($j=0; $j<count($locationOptions['flight']); $j++)
							{
								// Get Total Number Of Stairs of Pick and Drop location
								
								$flight_no = explode('to',$locationOptions['flight'][$j]);
								
								$flight_no = $flight_no[1];
								
								
								if($flight_no == 0)
								{
									$avg_time = ($item->time_0_min + $item->time_0_med + $item->time_0_max)/3;
								}
								if($flight_no == 1)
								{
									$avg_time = ($item->time_1_min + $item->time_1_med + $item->time_1_max)/3;
								}
								if($flight_no == 2)
								{
									$avg_time = ($item->time_2_min + $item->time_2_med + $item->time_2_max)/3;
								}
								if($flight_no == 3)
								{
									$avg_time = ($item->time_3_min + $item->time_3_med + $item->time_3_max)/3;
								}
								if($flight_no == 4)
								{
									$avg_time = ($item->time_4_min + $item->time_4_med + $item->time_4_max)/3;
								}
								if($flight_no == 5)
								{
									$avg_time = ($item->time_5_min + $item->time_5_med + $item->time_5_max)/3;
								}
								if($flight_no == 6)
								{
									$avg_time = ($item->time_6_min + $item->time_6_med + $item->time_6_max)/3;
								}
								
								
								
								
								// If Stairs type is windy helper take less time  
								if( strtolower($locationOptions['stair_type_'.$j]) == 'windy' )
								{
									if($item->stair_windy != null && $item->stair_windy != '' && $item->stair_windy > 0)
									{
										$total_item_move_time = $total_item_move_time + $avg_time + $item->stair_windy;	
									}
									else
									{
										$total_item_move_time = $total_item_move_time + $avg_time;	
									}
								}
								
								// If Stairs type is narrow helper take more time 
								if( strtolower($locationOptions['stair_type_'.$j]) == 'narrow' )
								{
									if($item->stair_narrow != null && $item->stair_narrow != '' && $item->stair_narrow > 0)
									{
										$total_item_move_time = $total_item_move_time + $avg_time + $item->stair_narrow;	
									}
									else
									{
										$total_item_move_time = $total_item_move_time + $avg_time;	
									}
								}
		
								//3. Calculate Assembling / Disassembling Items Time

								if(isset(session()->get("ranking")["ranking_".$cart->id]))
								{
									$ranking_id = session()->get("ranking")["ranking_".$cart->id];
									
									foreach($ranking as $rnk_k => $rank)
									{
										
										if ($rank->ranking_id == $ranking_id)
										{
											$prop = 'R_'.$rank->alphabet;
											$total_item_move_time = $total_item_move_time + $item->$prop;
											//echo $item->$prop .' - '. $ranking_id . ' - ' .$rank->alphabet;
											break;
										}
									}
								}
								
							}
						}
					}
				}
			}
		}
		
		// 4. Calculate Accuracy Level
		
		
		// 5. Calculate Walking Time
		
		$total_job_time = $travel_dist_time + $total_item_move_time;
		
		return array($total_job_time,$total_volume,$total_weight);
		
	}

    public function checkoutStorage(Request $request)
    {
        $cartItems = Cart::content();
        $services = session()->get("serviceType");
        $mapOptions = session()->get("mapLocationDetails");
        $insuranceDetails = session()->get("insurance");
        $dateOptions = session()->get("dateDetails");
        $dateOptions = $this->refineDateOptions($dateOptions);
        $dropDateOptions = session()->get("dropDateDetails");
        $dropDateOptions = $this->refineDateOptions($dropDateOptions, "drop_");
        $locationOptions = session()->get("locationDetails");
        $mapOptions = $this->refineMapOptions($mapOptions);
        $userMovingRequest = array_merge($mapOptions, $dateOptions, $dropDateOptions, $services);
        $userMovingRequest['user_id'] = Auth::user()->id;
        $userMovingRequest['zonetype'] = $locationOptions['zip_code'][0] . ',' . end($locationOptions['zip_code']);
        $userMovingRequest['packaging'] = $request->get('packaging');
        $userMovingRequest['requested_hub'] = $locationOptions['storageHub'];
        $userMovingRequest['junk_removal'] = json_encode(session()->get("junk_items"));
        $userMovingRequest['accuracy'] = $request->get('accuracy');
        $location = new UserStorageRequest($userMovingRequest);
        $location->save();
        $locationId = $location->id;

        foreach ($cartItems as $cart) {
            $options = json_decode($cart->options);
            for ($i = 0; $i < $cart->qty; $i++) {
                $requestItem = new UserStorageRequestItem();
                $requestItem->user_storage_request_id = $locationId;
                $requestItem->name = $cart->name;
                $requestItem->options = json_encode($options[$i]);
                $requestItem->price = $cart->price;
                $requestItem->save();
            }
        }

        foreach ($locationOptions['floor'] as $index => $floor) {
            $newLocationOption = [
                'user_storage_request_id' => $locationId,
                'floor'                   => $floor,
                'zip_code'                => $locationOptions['zip_code'][$index],
                'location_question1'      => $locationOptions['location_question1'][$index],
                'detail_address'          => $locationOptions['detail_address'][$index],
                'location_note'           => $locationOptions['parking_' . $index],
                'location_question2'      => $locationOptions['walk_' . $index],
            ];

            if ($locationOptions['type_' . $index] == 'Both') {
                $newLocationOption['stair_type'] = $locationOptions['stair_type_' . $index];
                $newLocationOption['flight'] = $locationOptions['flight'][$index];
                $newLocationOption['elevator_type'] = $locationOptions['elevator_type_' . $index];
            }

            if ($locationOptions['type_' . $index] == 'Elevator') {
                $newLocationOption['elevator_type'] = $locationOptions['elevator_type_' . $index];
            }

            if ($locationOptions['type_' . $index] == 'Stairs') {
                $newLocationOption['stair_type'] = $locationOptions['stair_type_' . $index];
                $newLocationOption['flight'] = $locationOptions['flight'][$index];
            }
            $newLocation = new StorageLocation($newLocationOption);
            $newLocation->save();
        }

        $i = 0;
        foreach ($cartItems as $cartItem) {
            $newInsuranceOption = [
                'user_storage_request_id' => $locationId,
                'insurance_type'          => InsuranceCategory::find($insuranceDetails['type'])->name,
                'category_name'           => $cartItem->name,
                'qty'                     => $cartItem->qty,
                'ratio'                   => $insuranceDetails['ratio'][$i]
            ];

            $newInsuranceDetail = new StorageInsuranceDetails($newInsuranceOption);
            $newInsuranceDetail->save();
            $i++;
        }

        session()->remove("serviceType");
        session()->remove("mapLocationDetails");
        session()->remove("dateDetails");
        session()->remove("locationDetails");
        session()->remove("insurance");
        Cart::destroy();

        return redirect()->to('thank-you');
    }

    public function checkoutJunk()
    {
        $cartItems = Cart::content();
        $services = session()->get("serviceType");
        $mapOptions = session()->get("mapLocationDetails");
        /*$insuranceDetails = session()->get("insurance");*/
        $dateOptions = session()->get("dateDetails");
        $dateOptions = $this->refineDateOptions($dateOptions);
        $locationOptions = session()->get("locationDetails");
        $mapOptions = $this->refineMapOptions($mapOptions);
        $userMovingRequest = array_merge($mapOptions, $dateOptions, $services);
        $userMovingRequest['user_id'] = Auth::user()->id;
        $userMovingRequest['zonetype'] = $locationOptions['zip_code'][0] . ',' . end($locationOptions['zip_code']);
        $userMovingRequest['packaging'] = "N/A";
        $userMovingRequest['junk_removal'] = "All";
        $userMovingRequest['accuracy'] = "N/A";
        $location = new UserJunkRequest($userMovingRequest);
        $location->save();
        $locationId = $location->id;
        foreach ($cartItems as $cart) {
            $options = json_decode($cart->options);
            for ($i = 0; $i < $cart->qty; $i++) {
                $requestItem = new UserJunkRequestItem();
                $requestItem->user_junk_request_id = $locationId;
                $requestItem->name = $cart->name;
                $requestItem->options = json_encode($options[$i]);
                $requestItem->price = $cart->price;
                $requestItem->save();
            }
        }

        foreach ($locationOptions['floor'] as $index => $floor) {
            $newLocationOption = [
                'user_junk_request_id' => $locationId,
                'floor'                => $floor,
                'zip_code'             => $locationOptions['zip_code'][$index],
                'location_question1'   => $locationOptions['location_question1'][$index],
                'detail_address'       => $locationOptions['detail_address'][$index],
                'location_note'        => $locationOptions['parking_' . $index],
                'location_question2'   => $locationOptions['walk_' . $index],
            ];

            if ($locationOptions['type_' . $index] == 'Both') {
                $newLocationOption['stair_type'] = $locationOptions['stair_type_' . $index];
                $newLocationOption['flight'] = $locationOptions['flight'][$index];
                $newLocationOption['elevator_type'] = $locationOptions['elevator_type_' . $index];
            }

            if ($locationOptions['type_' . $index] == 'Elevator') {
                $newLocationOption['elevator_type'] = $locationOptions['elevator_type_' . $index];
            }

            if ($locationOptions['type_' . $index] == 'Stairs') {
                $newLocationOption['stair_type'] = $locationOptions['stair_type_' . $index];
                $newLocationOption['flight'] = $locationOptions['flight'][$index];
            }
            $newLocation = new JunkLocation($newLocationOption);
            $newLocation->save();
        }

        /*$i = 0;
        foreach ($cartItems as $cartItem) {
            $newInsuranceOption = [
                'user_junk_request_id' => $locationId,
                'insurance_type'       => InsuranceCategory::find($insuranceDetails['type'])->name,
                'category_name'        => $cartItem->name,
                'qty'                  => $cartItem->qty,
                'ratio'                => $insuranceDetails['ratio'][$i]
            ];

            $newInsuranceDetail = new JunkInsuranceDetails($newInsuranceOption);
            $newInsuranceDetail->save();
            $i++;
        }*/

        session()->remove("serviceType");
        session()->remove("mapLocationDetails");
        session()->remove("dateDetails");
        session()->remove("locationDetails");
        session()->remove("insurance");
        Cart::destroy();

        return redirect()->to('thank-you');
    }

    public function thankYou()
    {
        return view('thanks');
    }

    public function testPay($amount)
    {
        $StripeCharge = $amount * 100;

        $Card = Card::where('user_id', \Auth::user()->id)->first();
        if ($Card == null) return false;

        Stripe::setApiKey("sk_test_4Ohg7zn7KTy0iePA3h7pWNVA00qHYegdlu");

        $Charge = Charge::create(array(
            "amount"        => $StripeCharge,
            "currency"      => "usd",
            "customer"      => Auth::user()->stripe_cust_id,
            "card"          => $Card->card_id,
            "description"   => "Payment Charge for " . Auth::user()->email,
            "receipt_email" => Auth::user()->email
        ));

        return $Charge['receipt_url'];

    }

    public function bookNow($type, $id)
    {
        $UserMovingRequest = UserMovingRequest::find($id);

        if ($type == 'storage') {
            $UserMovingRequest = UserStorageRequest::find($id);
        }

        if ($type == 'junk') {
            $UserMovingRequest = UserJunkRequest::find($id);
        }

        $deposit = $UserMovingRequest->charge_deposit;
        $receiptUrl = $this->testPay($deposit);
        if ($receiptUrl == false) return redirect()->to('payment');
        $UserMovingRequest->update([
            'deposit'     => $deposit,
            'status'      => 'UNASSIGNED',
            'receipt_url' => $receiptUrl
        ]);

        return redirect()->back();
    }

    /**
     * @param $mapOptions
     * @return array
     */
    private function refineMapOptions($mapOptions)
    {
        $mapOptions['s_address'] = $mapOptions['start'];
        if (isset($mapOptions['end'])) $mapOptions['d_address'] = $mapOptions['end'];
        unset($mapOptions['start']);
        if (isset($mapOptions['end'])) unset($mapOptions['end']);
        if (isset($mapOptions['waypoints'])) {
            $mapOptions['waypoints'] = json_encode($mapOptions['waypoints']);
            $mapOptions['way_point_lats'] = json_encode($mapOptions['way_point_lats']);
            $mapOptions['way_points_lngs'] = json_encode($mapOptions['way_points_lngs']);
        } else {
            $mapOptions['way_points_lngs'] = $mapOptions['way_point_lats'] = $mapOptions['waypoints'] = json_encode([]);
        }
        return $mapOptions;
    }

    /**
     * @param $dateOptions
     * @param null $prefix
     * @return array
     */
    private function refineDateOptions($dateOptions, $prefix = null)
    {
        //anytime   =  8 to 6
        //morning   =  8 to 12
        //afternoon =  11 to 4
        //evening   =  4 to 6
        if ($dateOptions['date_type'] == "FF") {
            $dateOptions = $this->setFlexibleDateFlexibleTime($dateOptions);
        }
        if ($dateOptions['date_type'] == "SF") {
            $dateOptions = $this->setSpecificDateFlexibleTime($dateOptions);
        }
        if ($dateOptions['date_type'] == "FS") {
            $dateOptions = $this->setFlexibleDateSpecificTime($dateOptions);
        }
        if ($dateOptions['date_type'] == "SS") {
            $dateOptions = $this->setSpecificDateSpecificTime($dateOptions);
        }
        if (!is_null($prefix)) {
            $newDateOption = [];
            foreach ($dateOptions as $key => $dateOption) {
                $myIndex = $prefix . $key;
                $newDateOption[$myIndex] = $dateOption;
            }
            $dateOptions = $newDateOption;
        }
        return $dateOptions;
    }

    public function setFlexibleDateFlexibleTime($dateOptions)
    {
        $date = $dateOptions['prefer_date'];
        $dateOptions['booking_date'] = $date;
        $preferTimeArray = [];
        $prefer_time = $dateOptions['time_0'];
        foreach ($prefer_time as $value) {
            if ($value == "Anytime") {
                $preferTimeArray[] = "8:00 AM to 6:00 PM";
            }
            if ($value == "Morning") {
                $preferTimeArray[] = "8:00 AM to 12:00 PM";
            }
            if ($value == "Afternoon") {
                $preferTimeArray[] = "12:00 PM to 4:00 PM";
            }
            if ($value == "Evening") {
                $preferTimeArray[] = "4:00 PM to 6:00 PM";
            }
        }
        $dateOptions['prefer_time'] = json_encode($preferTimeArray);
        unset($dateOptions['time_0']);

        $secondaryDateArray = explode(",", $dateOptions['date']);
        $flexTimeArray = [];
        foreach ($secondaryDateArray as $index => $value) {
            $newTimeArray = [];
            $timeArray = $dateOptions['time_' . ($index + 1)];
            unset($dateOptions['time_' . ($index + 1)]);
            foreach ($timeArray as $time) {
                if ($time == "Anytime") {
                    $newTimeArray[] = "8:00 AM to 6:00 PM";
                }
                if ($time == "Morning") {
                    $newTimeArray[] = "8:00 AM to 12:00 PM";
                }
                if ($time == "Afternoon") {
                    $newTimeArray[] = "12:00 PM to 4:00 PM";
                }
                if ($time == "Evening") {
                    $newTimeArray[] = "4:00 PM to 6:00 PM";
                }
            }
            $flexTimeArray[] = $newTimeArray;
        }
        $dateOptions['time'] = json_encode($flexTimeArray);
        return $dateOptions;
    }

    public function setSpecificDateFlexibleTime($dateOptions)
    {
        $date = $dateOptions['date'];
        $dateOptions['booking_date'] = $date;
        $prefer_time = $dateOptions['time_0'];
        foreach ($prefer_time as $value) {
            if ($value == "Anytime") {
                $preferTimeArray[] = "8:00 AM to 6:00 PM";
            }
            if ($value == "Morning") {
                $preferTimeArray[] = "8:00 AM to 12:00 PM";
            }
            if ($value == "Afternoon") {
                $preferTimeArray[] = "12:00 PM to 4:00 PM";
            }
            if ($value == "Evening") {
                $preferTimeArray[] = "4:00 PM to 6:00 PM";
            }
        }
        unset($dateOptions['time_0']);
        unset($dateOptions['prefer_time']);
        unset($dateOptions['prefer_date']);
        $dateOptions['time'] = json_encode($preferTimeArray);
        return $dateOptions;
    }

    public function setSpecificDateSpecificTime($dateOptions)
    {
        $date = $dateOptions['date'];
        $dateOptions['booking_date'] = $date;
        $time = $dateOptions['time'];
        $dateOptions['start_time'] = $time;
        $dateOptions['end_time'] = $time;
        return $dateOptions;
    }

    public function setFlexibleDateSpecificTime($dateOptions)
    {
        $date = $dateOptions['date'];
        $dateOptions['booking_date'] = $date;
        if (Str::startsWith($dateOptions['date_type'], "F")) {
            $dateOptions['booking_date'] = $dateOptions["prefer_date"];
        }
        $time = $dateOptions['time'];
        $dateOptions['start_time'] = $time;
        $dateOptions['end_time'] = $time;
        return $dateOptions;
    }

    public function getRatio($id)
    {
        return response()->json(["ratio" => InsuranceCategory::find($id)->ratio], 200);
    }

    public function getItemsByCategoryId($id)
    {
        $nameList = [];
        $cart = Cart::content();
        foreach ($cart as $item) {
            $nameList[] = $item->name;
        }

        $itemsList = Category::find($id)->item_ids;

        $itemsList = explode(",", $itemsList);
        $itemsList = array_values(array_intersect($itemsList, $nameList));
        return response()->json($itemsList, 200);
    }


}
