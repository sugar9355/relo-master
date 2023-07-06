<?php

namespace App\Http\Controllers;

use Setting;
use DateTime;
use App\Category;
use App\TimeCharges;
use App\Accuracy;
use App\PropertyInsurance;
use App\InsuranceCategory;
use App\Inventory;
use App\Question;
use App\Service;
use App\Truck;
use App\Dlevel;
use App\Preset;
use App\PeakFactor;
use App\VehicleSchedule;
use App\Booking;
use App\Role;
use App\UserMovingRequest;
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
use App\Helpers\Helper;

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
			return back()->withErrors($validator);
		}
		else
		{
			DB::beginTransaction();
			
				booking::delete_location($booking_id);
			
				foreach($request->location as $k => $location)
				{
					if($k == 0)
					{
						$step_update['s_address'] = $location;
						
						$data['location'] = $location;	
						$data['lat'] = $request->s_lat;
						$data['lng'] = $request->s_lng;
					}
					if($k > 0)
					{
						$step_update['d_address'] = $location;
						
						$data['location'] = $location;	
						$data['lat'] = $request->d_lat;
						$data['lng'] = $request->d_lng;
					}
					
					$data['booking_id'] = $booking_id;
					$data['location'] = $location;
					booking::save_location($data);
				}
				
				$way_points = array();
				if(isset($request->waypoints))
				{
					foreach($request->waypoints as $k => $loc)
					{
						$way_points[$k]['booking_id'] = $booking_id;
						$way_points[$k]['location'] = $loc['location'];
						$way_points[$k]['lat'] = $loc['lat'];
						$way_points[$k]['lng'] = $loc['lng'];
					}
				}
				
				booking::save_location($way_points);
				
				$step_update['s_lat'] = $request->s_lat;
				$step_update['s_lng'] = $request->s_lng;
				$step_update['d_lat'] = $request->d_lat;
				$step_update['d_lng'] = $request->d_lng;
				
				$step_update['time_from_hub'] = str_replace("mins","",$this->GetHubTime($request->s_lat,$request->s_lng));
				$step_update['time_to_hub']   = str_replace("mins","",$this->GetHubTime($request->d_lat,$request->d_lng));
				
				$step_update['distance'] = $request->distance;
				$step_update['minutes'] = $request->minutes;
				
				$step_update['step'] = 3;
				booking::where('booking_id',$booking_id)->update($step_update);
			
			DB::commit();
			
			return redirect()->to('booking/'.$booking_id);
		}
	}
	public function save_step3($request,$booking_id)
	{
		//dd($request);
		booking::delete_booking_dates($booking_id);
		
		foreach($request->booking_date as $k => $booking_date)
		{
			if(!empty($booking_date['date']) && !empty($booking_date['start_time']) && !empty($booking_date['end_time']))
			{
			
				$date = date('Y-m-d',strtotime($booking_date['date']));
				
				if($k == 0)
				{
					$data['step'] = 4;
					$data['flexibilty'] = 'SS';
					$data['primary_date'] = $date;
					$data['booking_date'] = $date;
					$data['start_time'] = '9:00 AM';
					booking::where('booking_id',$booking_id)->update($data);
				}
				
				if($k == 1)
				{
					$data['step'] = 4;
					$data['flexibilty'] = 'SS';	
					$data['secondary_date'] = $date;
					booking::where('booking_id',$booking_id)->update($data);
				}
	
				$dates['booking_id'] 	 = $booking_id;
				$dates['booking_date'] 	 = $date;
				$dates['start_time'] 	 = $booking_date['start_time'];
				$dates['end_time'] 		 = $booking_date['end_time'];
				$dates['status'] 		 = 1;
				$dates['created_at'] 	 = now();
				$dates['updated_at'] 	 = now();
				
				booking::save_booking_dates($dates);
			}
		}
		
		return redirect()->to('booking/'.$booking_id);
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
			session()->put("msg", 'Please Enter Complusory Information');
			return back()->withErrors($validator);
		}
		else
		{
			DB::beginTransaction();
			
			for($i=0; $i<=1; $i++)
			{
				$data['floor']			= $request->floor[$i];
				$data['zip_code']		= $request->zip_code[$i];
				$data['stair_kind'] 	= $request->stair_kind[$i];
				$data['stair_type'] 	= isset($request->stair_type[$i]) ? $request->stair_type[$i] : null;
				$data['flights'] 		= isset($request->flights[$i]) ? $request->flights[$i] : null;
				$data['parking'] 		= isset($request->parking[$i]) ? $request->parking[$i] : null;
				$data['walk'] 			= $request->walk[$i];
				$data['walk_time'] 		= $request->walk_min[$i] + $request->walk_sec[$i];
				$data['walk_min'] 		= $request->walk_min[$i];
				$data['walk_sec'] 		= $request->walk_sec[$i];
				if(isset($request->walk_time[$i]) && !empty($request->walk_time[$i]))
				{
					$data['walk_time'] = $request->walk_time[$i];
				}
				else
				{
					$data['walk_time'] = 0;
				}
				
				$data['comments'] 		= isset($request->comments[$i]) ? $request->comments[$i] : '';
				
				$booking_location_id 	= $request->booking_location_pk[$i];
				
				booking::update_location($data,$booking_id,$booking_location_id);
			}
			
			$step_update['step'] = 5;
			booking::where('booking_id',$booking_id)->update($step_update);
			
			DB::commit();
			return redirect()->to('booking/'.$booking_id);
		}
	}
	

	public function save_step5($request,$booking_id) // Shop
	{
		
		DB::beginTransaction();
		
		$booking_truck = booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();
		
		$inventory = Inventory::where(array('id'=>$request->item_id))->first();
		
		$data['item_id']		 = $inventory->id;
		$data['truck_id']		 = $booking_truck->truck_id;
		$data['item_name']		 = $inventory->name;
		$data['item_image'] 	 = isset($inventory->item_image) ? $inventory->item_image : 0;
		$data['file_path'] 		 = $inventory->file_path;
		$data['quantity'] 		 = 1;
		$data['breadth'] 		 = $inventory->breadth;
		$data['height'] 		 = $inventory->height;
		$data['width'] 		 	 = $inventory->width;
		$data['volume'] 		 = $inventory->width * $inventory->height * $inventory->breadth;
		$data['weight'] 		 = $inventory->weight;
		$data['similar'] 		 = $inventory->similar;
		
		if(isset($request->ranking) && !empty($request->ranking))
		{
			$data['ranking'] = $request->ranking;
		}
		else
		{
			$data['ranking'] = null;
		}		
		
		$data['pick_up_loc_id']  = $request->pick_up_loc_id;
		$data['drop_off_loc_id'] = $request->drop_off_loc_id;
		$data['booking_id'] 	 = $booking_id;
		$data['created_at'] 	 = now();
		$data['updated_at'] 	 = now();
		$data['booking_item_id'] = $booking_item_id = booking::save_item($data);
		
		$update_item['pick_up_time']  = $this->item_moving_time($request,$data,'pick_up');
		$update_item['drop_off_time'] = $this->item_moving_time($request,$data,'drop_off');
		$where['booking_item_id'] = $booking_item_id;
		$booking_item_id = booking::update_item($update_item,$where);
		
		if(isset($request->answer))
		{
			foreach($request->answer as $q_id => $val)
			{
				$item_answer['booking_id'] = $booking_id;
				$item_answer['item_id'] = $request->item_id;
				$item_answer['question_id'] = $q_id;
				$item_answer['answer'] = $val;
				booking::save_answer($item_answer);	
			}
		}
		
		if ($request->hasFile('picture')) 
		{
			$this->upload_picture($request,$booking_id,$booking_item_id);
		}	

		$truck_schedule = VehicleSchedule::where('booking_id',$booking_id)->where('truck_id',$data['truck_id'])->first();
		
		if(isset($truck_schedule->id))
		{
			$p['booking_id'] = $booking_id;
			$booking_items = booking::get_booking_items($p);
			
			
			$item_total_volume = 0;
			foreach($booking_items as $item_volume)
			{
				$item_total_volume = $item_total_volume + ($item_volume->volume * $item_volume->quantity);
			}
			
			if($item_total_volume < $booking_truck->volume)
			{
				$moving_time = $update_item['pick_up_time'] + $update_item['drop_off_time'];
				$vehicle_sch['end_time'] = date('g:i A', strtotime("+{$moving_time} minutes", strtotime($truck_schedule->end_time)));
				VehicleSchedule::where('truck_id',$data['truck_id'])->update($vehicle_sch);
			}
		}
		
		DB::commit();
		
		return redirect()->to('booking/'.$booking_id);
	}
	
	public function save_step6($request,$booking_id)
	{
		
		//dd($request->all());
		
		DB::beginTransaction();
		
		$insuranceCategories = InsuranceCategory::all();
		
		booking::delete_insurance($booking_id);
		
		if(isset($insuranceCategories[0]))
		{
			foreach($request->items as $key => $insurance)
			{
				$data['booking_id'] = $booking_id;
				$data['booking_item_id'] = $key;
				$data['insurance_id'] = $insurance['insurance'];
				
				foreach($insuranceCategories as $k => $ins)
				{
					if($ins->id == $insurance['insurance'])
					{
						$data['insurance_type'] = $ins->name;
						$data['ratio'] = $ins->ratio;
						
						if($insurance['you_pay'] > 0)
						{
						$data['we_pay'] = ($insurance['you_pay'] * explode(':',$ins->ratio)[1]);
						$data['you_pay'] = $insurance['you_pay'];
						}
						else
						{
							$data['we_pay'] = 0;
							$data['you_pay'] = 0;	
						}
						
					}
				}
				
				booking::save_insurance($data);
			}
			//dd($request->property_items);
			// foreach($request->property_items as $key => $property)
			// {
				// $prop_data['booking_id'] = $booking_id;
				// $prop_data['name'] = $property['name'];
				// $prop_data['insurance_id'] = $property['insurance'];
				
				// foreach($insuranceCategories as $k => $ins)
				// {
					// if($ins->id == $property['insurance'])
					// {
						// $prop_data['insurance_type'] = $ins->name;
						// $prop_data['ratio'] = $ins->ratio;
						
						// if($property['you_pay'] > 0)
						// {
							// $prop_data['we_pay'] = ($property['you_pay'] * explode(':',$ins->ratio)[1]);
							// $prop_data['you_pay'] = $property['you_pay'];
						// }
						// else
						// {
							// $prop_data['we_pay'] = 0;
							// $prop_data['you_pay'] = 0;
						// }
						
					// }
				// }
				
				// booking::save_property_insurance($prop_data);
			// }
			
		}
		
		
		$step_update['step'] = 7;
		booking::where('booking_id',$booking_id)->update($step_update);
		
		DB::commit();
		
		return redirect()->to('booking/'.$booking_id);
	
	}
	
	public function save_finish($request,$booking_id)
	{
		DB::beginTransaction();
		
		if(isset($request->items))
		{
			foreach($request->items as $key => $items)
			{
				$update_items['pakaging'] = isset($items['pakaging']) ? $items['pakaging'] : 0;
				$update_items['junk_removal'] = isset($items['junk_removal']) ? $items['junk_removal'] : 0;
				$where_items['booking_item_id'] = $key;
				booking::update_item($update_items,$where_items);
			}
		}
		
		//$step_update['accuracy'] = $request->accuracy;
		$step_update['step'] = 8;	
		booking::where('booking_id',$booking_id)->update($step_update);
		
		DB::commit();
		
		return redirect()->to('summary/'.$booking_id);
	}
	
	public function checkout($request,$booking_id)
	{
	
		DB::beginTransaction();
		
			$step_update['step'] = 0;	
			booking::where('booking_id',$booking_id)->update($step_update);
			
		DB::commit();
		
		$this->get_available_truck($booking_id);
		
		return redirect()->to('dashboard');
	}
	
	
	
	public function dashboard(Request $request,$booking_id=null)
    {
		if (!Auth::User()) 
		{
            return redirect()->to('showLoginForm/');
		}
		
		$page="dashboard";
		
		$user = Auth::User()->find(Auth::User()->id);
		//dd($user->first_name);
		
		if($booking_id == null)
		{
			$user_bookings = booking::where('user_id',Auth::User()->id)->where('step',0)->get();
			
			$booking_ids = '';
			foreach($user_bookings as $booking)
			{
				$booking_ids .= $booking->booking_id .',';	
			}	
			
			$booking_ids = rtrim($booking_ids,',');
			
			$booking_items = booking::get_booking_items_count($booking_ids);
			
			$item_count = array();		
			foreach($booking_items as $k => $v)
			{
				$item_count[$v->booking_id] = $v->count;
			}	
		}
		else
		{
			$booking = booking::where('booking_id',$booking_id)->where('step',0);
			$booking = $booking->first();
			
			$join['booking_form_insurance'] = true;
			$selected_items = booking::get_booking_items($booking_id,$join);
			
		}
		
		return view('booking.dashboard', compact('page','user','booking_id','user_bookings','booking','item_count'));
	}
	
	public function payment(Request $request,$booking_id = null)
    {
		
		$page = 'dashboard';
		return view('booking.payment',compact('page'));	
		
	}
	
	public function summary(Request $request,$booking_id = null,$step = null)
    {
		if(!empty($booking_id))
		{
			$booking = array();
			$services = Service::all();
			
			$booking = booking::where('booking_id',$booking_id)->first();
			$booking_location = booking::get_booking_location($booking_id);
			
			$calender = Helper::GetCelender(date("Y"));
			$demand = PeakFactor::GetCustomerDemand();
				
			$c_date['now_year'] = date('Y'); 
			$peak = PeakFactor::where('year',$c_date['now_year'])->get();
			$booking_dates = booking::get_booking_dates($booking_id);
				
			foreach ($calender as $month => $value) 
			{
				foreach ($value as $k =>$week) 
				{				
					foreach($week as $week_k =>  $day) 
					{
						$calender[$month][$k][$week_k] = array($day,'N');
						foreach($peak as $p) 
						{
							if($p->month == $month && $p->day == $day && $p->value > 0)
							{
								if($p->value >= $demand[0]->high)
								{
									$calender[$month][$k][$week_k][1] = 'high';
								}
								if($p->value < $demand[0]->high &&  $p->value > $demand[0]->low)
								{
									$calender[$month][$k][$week_k][1] = 'moderate';
								}
								if($p->value <= $demand[0]->low)
								{
									$calender[$month][$k][$week_k][1] = 'low';
								}
								
							}
						}
					}						
				}
			}
				
			$time_charges = TimeCharges::get();
			
			$items = Inventory::all();

			$selected_items = booking::get_booking_items($booking_id);
				
			$booking_item_answers = booking::get_booking_item_answers($booking_id);

			$selected_item_answers = array();
			foreach($booking_item_answers as $answers)
			{
				$selected_item_answers[$answers->question_id] = $answers;
			}
				

			// Get Ranking
			$ranking = Inventory::GetRanking();

			foreach($items as $itm)
			{
				$item_ids[] = $itm->id;
			}
				
			$item_images = booking::get_item_images(array('booking_id'=>$booking_id))->get();

			$question = Question::whereIn('item_id',$item_ids)->get();
									
			foreach($items as $k => $item)
			{
				$items[$k]->question = false;
				foreach($question as $q)
				{
					if($q->item_id == $item->id)
					{
						$items[$k]->question = true;
						break;
					}
				}
			}
				
			$presets = Preset::all();
			$equipments = Inventory::GetInventoryEquipment();
			$categories = Category::orderBy('created_at', 'desc')->get();
				
			$booking_form_truck = booking::get_booking_truck(array('booking_id'=>$booking_id))->get();
			
			$join['booking_form_insurance_left'] = true;
			$join['inventories'] = true;
			$selected_items = booking::get_booking_items($booking_id,$join);
			
			$accuracy = Accuracy::get();
			$accuracy_value = 0;
			foreach($accuracy as $accu)
			{
				if($accu->id == $booking->accuracy)
				{
					$accuracy_value = $accu->value;
				}
			}
			
			$inventory_time = 0;
			foreach($selected_items as $item)
			{
				 $inventory_time = $inventory_time + $item->pick_up_time + $item->drop_off_time;
			}
			
			$result = $this->difficulty_level($selected_items,$booking_location);
			$average_crew_rates = $result[0];
			$crew = $result[1];
			
			$hourly_time = ($inventory_time + $booking->minutes) * ($average_crew_rates / 60);
			$mileage_time = ($inventory_time + $booking->minutes) * ($booking_form_truck[0]->mileage / 60);
			
			$booking->total_rate = $hourly_time + $mileage_time;
			$booking->min = ($hourly_time + $mileage_time) - $accuracy_value;
			$booking->max = ($hourly_time + $mileage_time) + $accuracy_value;
			
			$insuranceCategories = InsuranceCategory::all();
			$PropertyInsurance = PropertyInsurance::all();
			
			return view('booking.summary',compact('services','booking','booking_location','booking_dates','booking_form_truck','categories','equipments','presets','question','item_images','ranking','items','selected_items','time_charges','calender','insuranceCategories','PropertyInsurance','hourly_time','mileage_time','crew'));
		
		}
	}
	
	public function booking(Request $request,$booking_id = null,$step = null)
    {
		//dd($request->all());
		if (!Auth::User()) 
		{
            return redirect()->to('showLoginForm/');
        }
		$booking = array();
		$services = Service::all();
		
		$this->btn_save_step($booking_id,$step);
		
		if(isset($request->btn_new_truck))
		{
			$this->create_booking_truck($request,$booking_id);
			return redirect()->to('booking/'.$booking_id);
		}
		
		
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
				
				if(isset($request->update_quantity))
				{
					$param['quantity'] = $request->quantity;
					$where['booking_item_id'] = $request->booking_item_id;
					
					if($request->truck_limit == 'close' && $request->quantity > $request->quantity_limit)
					{
						return redirect()->to('booking/'.$booking_id);
					}					
					else
					{
						
						Booking::update_quantity($param,$where);
					
						$booking_truck = booking::get_booking_truck(array('booking_id'=>$booking_id,'status'=>1))->first();
						$truck_schedule = VehicleSchedule::where('booking_id',$booking_id)->where('truck_id',$request->truck_id)->first();
			
						if(isset($truck_schedule->id))
						{
							$p['booking_id'] = $booking_id;
							$booking_items = booking::get_booking_items($p);
							
							
							$item_total_volume = 0;
							foreach($booking_items as $item_volume)
							{
								$item_total_volume = $item_total_volume + ($item_volume->volume * $item_volume->quantity);
							}
							
							if($item_total_volume < $booking_truck->volume)
							{
								$moving_time = $update_item['pick_up_time'] + $update_item['drop_off_time'];
								$vehicle_sch['end_time'] = date('g:i A', strtotime("+{$moving_time} minutes", strtotime($truck_schedule->end_time)));
								VehicleSchedule::where('truck_id',$data['truck_id'])->update($vehicle_sch);
							}
						}
					}
					
					return redirect()->to('booking/'.$booking_id);
				}
				elseif(isset($request->create_item))
				{
					$this->add_new_item($request,$booking_id);
					return redirect()->to('booking/'.$booking_id);
				}
				else
				{
					return $this->save_step5($request,$booking_id);	
				}
			}
			if($request->btn_submit == 6)
			{
				return $this->save_step6($request,$booking_id);
			}
			if($request->btn_submit == 'preview')
			{
				return $this->save_finish($request,$booking_id);
			}
			
			if($request->btn_submit == 'checkout')
			{
				return $this->checkout($request,$booking_id);
			}
			
			
		}		
		elseif($request->btn_delete == 5)
		{
			return $this->delete_item($request,$booking_id);
		}
		else
		{
			if(!empty($booking_id))
			{
				$booking = booking::where('booking_id',$booking_id);
				$booking = $booking->first();
				
				//dd($booking);
				
				if($booking->step == 1)
				{
					return view('booking.services', compact('services','booking'));		
				}
				elseif($booking->step == 2)
				{
					$booking_location = booking::get_booking_location($booking_id);
					return view('booking.map', compact('services','booking','booking_location'));		
				}
				elseif($booking->step == 3)
				{
					$calender = Helper::GetCelender(date("Y"));
					$demand = PeakFactor::GetCustomerDemand();
					//dd($demand);
					$c_date['now_year'] = date('Y'); 
					$peak = PeakFactor::where('year',$c_date['now_year'])->get();
					$booking_dates = booking::get_booking_dates($booking_id);
					
					foreach ($calender as $month => $value) 
					{
						foreach ($value as $k =>$week) 
						{				
							foreach($week as $week_k =>  $day) 
							{
								$calender[$month][$k][$week_k] = array($day,'N');
								foreach($peak as $p) 
								{
									if($p->month == $month && $p->day == $day && $p->value > 0)
									{
										if($p->value >= $demand[0]->high)
										{
											$calender[$month][$k][$week_k][1] = 'high';
										}
										if($p->value < $demand[0]->high &&  $p->value > $demand[0]->low)
										{
											$calender[$month][$k][$week_k][1] = 'moderate';
										}
										if($p->value <= $demand[0]->low)
										{
											$calender[$month][$k][$week_k][1] = 'low';
										}
										
									}
								}
							}						
						}
					}
					// echo '<pre>';
					// print_r($calender);
					// echo '</pre>';
					
					$time_charges = TimeCharges::get();
					
					
				return view('booking.date_time', compact('services','booking','booking_dates','calender','peak','time_charges'));		
				}
				elseif($booking->step == 4)
				{
					$booking_location = booking::get_booking_location($booking_id);
					return view('booking.location', compact('services','booking','booking_location'));		
				}
				elseif($booking->step == 5)
				{
					$search = $truck = null;
					if($request->btn_preset == true)
					{
						$param['item_ids'] = $request->btn_preset;
						$items = Inventory::SearchInventoryItems($param);
					}
					elseif($request->btn_search == true)
					{
						$search = $param['item_search'] = $request->item_search;
						$items = Inventory::SearchInventoryItems($param);
					}
					else
					{
						$items = Inventory::all();
					}

					$booking_location = booking::get_booking_location($booking_id);
					
					$selected_items = booking::get_booking_items($booking_id);
					
					$booking_item_answers = booking::get_booking_item_answers($booking_id);

					$selected_item_answers = array();
					foreach($booking_item_answers as $answers)
					{
						$selected_item_answers[$answers->question_id] = $answers;
					}
					

					// Get Ranking
					$ranking = Inventory::GetRanking();

					foreach($items as $itm)
					{
						$item_ids[] = $itm->id;
					}
					
					$item_images = booking::get_item_images(array('booking_id'=>$booking_id))->get();

					$question = Question::whereIn('item_id',$item_ids)->get();
										
					foreach($items as $k => $item)
					{
						$items[$k]->question = false;
						foreach($question as $q)
						{
							if($q->item_id == $item->id)
							{
								$items[$k]->question = true;
								break;
							}
						}
					}
					
					$presets = Preset::orderBy('created_at', 'desc')->get();
					$equipments = Inventory::GetInventoryEquipment();
					$categories = Category::orderBy('created_at', 'desc')->get();
					
					$booking_truck_exist = booking::get_booking_truck(array('booking_id'=>$booking_id))->count();
					
					// dd($booking_truck_exist);
					$available_trucks = $this->get_truck_availability($request,$booking);
					 //dd($available_trucks[0]->id);
					if($booking_truck_exist == 0 && isset($available_trucks[0]))
					{
						$truck_add['booking_id'] = $booking_id;
						$truck_add['truck_id'] = $available_trucks[0]->id;
						$truck_add['truck_name'] = $available_trucks[0]->name;
						$truck_add['item_ids'] = 0;
						$truck_add['truck_volume'] = $available_trucks[0]->volume;
						$truck_add['item_volume'] = 0;
						$truck_add['status'] = 1;
						$truck_add['created_at'] = now();
						$truck_add['updated_at'] = now();
						booking::add_booking_truck($truck_add);	
						
						$vehicle_sch['booking_id']	= $booking_id;
						$vehicle_sch['user_id']		= $booking->user_id;
						$vehicle_sch['truck_id']	= $available_trucks[0]->id;
						$vehicle_sch['assigned_on']	= now();
						$vehicle_sch['start_time']	= $booking->start_time;
						$vehicle_sch['end_time']	= date('g:i A', strtotime("+{$booking->minutes} minutes", strtotime($booking->start_time)));
						$vehicle_sch['created_at']	= now();
						$vehicle_sch['updated_at']	= now();
						
						VehicleSchedule::insert($vehicle_sch);
						
					}
					
					$booking_form_truck = booking::get_booking_truck(array('booking_id'=>$booking_id))->get();
					//echo 1; return ;
					//dd($booking_form_truck);
					
					$accuracy = Accuracy::get();
					
					return view('booking.shop', compact('services','booking','booking_location','items','item_images','selected_items','selected_item_answers','question','ranking','presets','equipments','categories','search','available_trucks','booking_form_truck','accuracy'));
				}
				elseif($booking->step == 6)
				{
					$join['booking_form_insurance_left'] = true;
					$selected_items = booking::get_booking_items($booking_id,$join);
					$insuranceCategories = InsuranceCategory::all();
					$PropertyInsurance = PropertyInsurance::all();
					return view('booking.insurance', compact('services','booking','selected_items','insuranceCategories','PropertyInsurance'));
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
				elseif($booking->step == 8)
				{
					return redirect()->to('summary/'.$booking_id);
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
	
	public function delete_item($request,$booking_id) // Delete Items
	{
		booking::delete_item(array('booking_item_id'=>$request->booking_item_id));
		return redirect()->to('booking/'.$booking_id);
	}
	
	function get_truck_availability($request,$booking)
	{
		$param['created_at'] = $booking->primary_date;
		$param['start_time'] = $booking->start_time;
		$truck_count = Truck::GetAvailableTruck($param)->count();
		if($truck_count > 0)
		{
			$trucks = Truck::GetAvailableTruck($param)->get();
		}
		else
		{
			//$p['created_at'] = null;
			$trucks = Truck::get();
		}
		
		return $trucks;
	}
	
	function get_available_truck($booking_id)
	{
		$booking = booking::where('booking_id',$booking_id)->first();
		
		$result = $this->calculate_job_time($booking);
		
		$total_job_time = $result[0];
		$total_volume 	= $result[1];
		$total_weight 	= $result[2];
		
		// Get All Assigned Trucks Of date Current or greater then job date
		$v_param['primary_date'] = $booking->primary_date;
		$v_param['start_time'] = $booking->start_time;
		$v_param['over_all_minutes']  = $total_job_time;
		
		$job_start_time = new DateTime($v_param['primary_date'].' '.$v_param['start_time']);
		$job_end_time   = new DateTime($v_param['primary_date'].' '.$v_param['start_time']);
		$job_end_time->modify("+{$v_param['over_all_minutes']} minutes");
		
		$assigned_truck = Booking::whereNotNull('truck_id')->where('booking_date',$booking->booking_date)->where('status','Pending')->get();
		
		if(isset($assigned_truck[0]))
		{
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
				$invalid_trucks[$key] = $volume;
			}
			
			foreach($assigned_truck as  $key => $time)
			{
				if(!in_array($time->truck_id,$invalid_trucks))
				{
					$start_time = new DateTime($time->primary_date.' '.$time->start_time);
					$end_time = new DateTime($time->primary_date.' '.$time->end_time);
					
					// Prevoius job time
					if( $end_time < $job_start_time )
					{
						$valid_trucks_arr[$time->truck_id]['truck_id'] = $time->truck_id;
						$valid_trucks_arr[$time->truck_id]['left_d_lat'] = $time->d_lat;
						$valid_trucks_arr[$time->truck_id]['left_d_lng'] = $time->d_lng;
						$valid_trucks_arr[$time->truck_id]['start_time'] = $time->start_time;
						$valid_trucks_arr[$time->truck_id]['end_time'] = $time->end_time;
						$valid_trucks_arr[$time->truck_id]['primary_date'] = $time->primary_date;
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
					
					$valid_trucks_arr[$time->truck_id]['job_lat'] = $booking->s_lat;
					$valid_trucks_arr[$time->truck_id]['job_lng'] = $booking->s_lng;

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
					
					$start_time = new DateTime($valid_truck['primary_date'].' '.$valid_truck['start_time']);
					$end_time = new DateTime($valid_truck['primary_date'].' '.$valid_truck['end_time']);
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
			$t_param['primary_date'] = $v_param['primary_date'];
			$available_trucks = Truck::GetAllAvailableTruck($t_param);
			//echo 123; return;
			
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
		//$req_update['exp_end_time'] = $req_update['end_time'];
		
		$req_update['items_volume'] = $total_volume;
		$req_update['items_weight'] = $total_weight;
		
		$req_update['over_all_minutes'] = $v_param['over_all_minutes'];
		
		Booking::where('booking_id',$booking->booking_id)->update($req_update);
		
		$start_time = session()->get("dateDetails")['time'];
		
		$vehicle_sch['booking_id']	= $booking_id;
		$vehicle_sch['user_id']		= $booking->user_id;
		$vehicle_sch['truck_id']	= $truck_id;
		$vehicle_sch['assigned_on']	= now();
		$vehicle_sch['start_time']	= $start_time;
		$vehicle_sch['created_at']	= now();
		$vehicle_sch['updated_at']	= now();
		
		VehicleSchedule::insert($vehicle_sch);
		
		$job['booking_id'] = $booking_id;
		$job['user_id'] = Auth::user()->id;
		$job['created_at'] = time();
		$job['updated_at'] = time();
		$job['created_by'] = Auth::user()->id;
		$job['updated_by'] = Auth::user()->id;
		
		UserMovingRequest::AddAssignedJobUsers($job);
	}

	public function calculate_job_time($booking)
	{
		
		// Get Ranking
		$ranking = array();
		$ranking_obj = Inventory::GetRanking();
		foreach($ranking_obj as $r_k=>$r_v){$ranking[$r_v->ranking_id] = $r_v;}
		
		$booking_items = booking::get_inventory_booking_items($booking->booking_id);
		$location = booking::get_booking_location($booking->booking_id);
		//dd($location);
		//dd($booking_items);
		$total_volume = 0;
		$total_weight = 0;
		$total_item_move_time = 0;
		
		foreach($booking_items as $k => $item)
		{
			// Get Volume Inventory Items
			$total_volume = $total_volume + $item->volume;
			$total_weight = $total_weight + $item->weight; 
			
			foreach($location as $loc)
			{
				// Get Total Number Of Stairs of Pick and Drop location
				$flight_no = $loc->flights;
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
				
				$total_item_move_time = $total_item_move_time + $avg_time;
				
				// If Stairs type is windy helper take less time  
				if($loc->stair_type == 'windy')
				{
					$total_item_move_time = $total_item_move_time + $item->stair_windy;
				}
				
				// If Stairs type is narrow helper take more time 
				if($loc->stair_type == 'narrow')
				{
					$total_item_move_time = $total_item_move_time + $item->stair_narrow;
				}
				
				//3. Calculate Assembling / Disassembling Items Time
				if(isset($item->ranking))
				{
					if($ranking[$item->ranking]->alphabet == "A")
					{
						$total_item_move_time = $total_item_move_time + $item->R_A;
					}
					elseif($ranking[$item->ranking]->alphabet == "B")
					{
						$total_item_move_time = $total_item_move_time + $item->R_B;
					}
					elseif($ranking[$item->ranking]->alphabet == "C")
					{
						$total_item_move_time = $total_item_move_time + $item->R_C;
					}
					elseif($ranking[$item->ranking]->alphabet == "D")
					{
						$total_item_move_time = $total_item_move_time + $item->R_D;
					}
					elseif($ranking[$item->ranking]->alphabet == "E")
					{
						$total_item_move_time = $total_item_move_time + $item->R_E;
					}
				}
			}
		}
		
		// echo '<pre>';
		// print($total_item_move_time);
		// echo '</pre>';
		// die;
		// echo '<pre>56';
		// print($booking->minutes);
		// echo '</pre>';
		// die;
		
		if($booking->minutes > 0)
		{
			$total_job_time = $booking->minutes + $total_item_move_time;	
		}
		else
		{
			$total_job_time = 0 + $total_item_move_time;	
		}
		
		// print_r($total_job_time);
		// die;
		return array($total_job_time,$total_volume,$total_weight);
		
	}
	
	public function add_new_item($request,$booking_id)
	{
		DB::beginTransaction();
		
			$item = new Inventory;
			$item->name = $request->get('name');
			$item->category_id = $request->get('category');
			$item->weight = $request->get('weight');
			$item->width = $request->get('width');
			$item->height = $request->get('height');
			$item->breadth = $request->get('breadth');
			$item->volume = $item->width * $item->height * $item->breadth;
			
			$item->ranking_id = $request->get('ranking');
			
			$item->equipments = implode(',',$request->get('equipments'));
			
			$item->stair_windy = $request->get('stair_time_windy');
			$item->stair_narrow = $request->get('stair_time_narrow');
			$item->stair_wide = $request->get('stair_time_wide');
			$item->stair_spiral = $request->get('stair_time_spiral');
			$item->elevator_passenger = $request->get('elevator_time_passenger');
			$item->elevator_freight = $request->get('elevator_time_freight');
			$item->elevator_reserved_freight = $request->get('elevator_time_rs_freight');
			
			$item->R_A = $request->get('R_A');
			$item->R_B = $request->get('R_B');
			$item->R_C = $request->get('R_C');
			$item->R_D = $request->get('R_D');
			$item->R_E = $request->get('R_E');
			
			$item->time_0_min = $request->time_0_min;
			$item->time_0_med = $request->time_0_med;
			$item->time_0_max = $request->time_0_max;
			$item->time_1_min = $request->time_1_min;
			$item->time_1_med = $request->time_1_med;
			$item->time_1_max = $request->time_1_max;
			$item->time_2_min = $request->time_2_min; 
			$item->time_2_med = $request->time_2_med; 
			$item->time_2_max = $request->time_2_max; 
			$item->time_3_min = $request->time_3_min; 
			$item->time_3_med = $request->time_3_med; 
			$item->time_3_max = $request->time_3_max; 
			$item->time_4_min = $request->time_4_min; 
			$item->time_4_med = $request->time_4_med; 
			$item->time_4_max = $request->time_4_max;
			$item->time_5_min = $request->time_5_min;
			$item->time_5_med = $request->time_5_med; 
			$item->time_5_max = $request->time_5_max; 
			$item->time_6_min = $request->time_6_min; 
			$item->time_6_med = $request->time_6_med; 
			$item->time_6_max = $request->time_6_max; 
			
			//dd($item);
			$item->save();
			$item_id = $item->id;
		
		if ($request->hasFile('picture')) 
		{
			$this->upload_picture($request,$booking_id,$booking_item_id);
		}		
			
		DB::commit();
	}

	public static function create_booking_truck($request,$booking_id)
    {
		$new_truck = explode(',',$request->btn_new_truck);
		
		$truck_add['booking_id'] = $booking_id;
		$truck_add['truck_id'] = $new_truck[0]; // truck id
		$truck_add['truck_name'] = $new_truck[1];// truck name
		$truck_add['item_ids'] = 0;
		$truck_add['truck_volume'] = $new_truck[2];// truck volume
		$truck_add['item_volume'] = 0;
		$truck_add['status'] = 1;
		$truck_add['created_at'] = now();
		$truck_add['updated_at'] = now();
		
		$update['status'] = 0;
		booking::update_truck_availability($booking_id,$update);
		
		booking::add_booking_truck($truck_add);
		
		$booking = booking::where('booking_id',$booking_id)->first();
		$end_time = date('g:i A', strtotime("+{$booking->minutes} minutes", strtotime($booking->start_time)));
		
		$vehicle_sch['booking_id']	= $booking_id;
		$vehicle_sch['user_id']		= $booking->user_id;
		$vehicle_sch['truck_id']	= $new_truck[0];
		$vehicle_sch['assigned_on']	= now();
		$vehicle_sch['start_time']	= $booking->start_time;
		$vehicle_sch['end_time']	= $end_time;
		$vehicle_sch['created_at']	= now();
		$vehicle_sch['updated_at']	= now();
		
		VehicleSchedule::insert($vehicle_sch);
		
	}
	public static function upload_picture($request,$booking_id,$booking_item_id)
    {
		
		$ext = ltrim(strstr($_FILES['picture']['name'], '.'), '.');
		
		$data['booking_id']		 = $booking_id;
		$data['booking_item_id']	 = $booking_item_id;
		$data['file_name'] 	 	= $_FILES['picture']['name'];
		$data['file_size'] 		 = $_FILES['picture']['size'];
		$data['file_type'] 		 = $_FILES['picture']['type'];
		$data['extension'] 		 = $ext;
		$data['status']  = 1;
		$data['created_at'] = time();
		$data['updated_at'] = time();
		$file_id = booking::save_item_image($data);
		
        $file_name = $booking_id.'-'.$booking_item_id.'-'.$file_id;
		
        if ($file_id) 
		{
			
			//$path = public_path() . "/uploads/booking/".$booking_id;
			// if(!dir($path))
			// {
				// mkdir($path);	
			// }
			
			$path = public_path() . "/uploads/booking";
			
			$target_file = $path.'/'. $file_name . "." . $ext;
			
			if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) 
			{
				$update['file_path'] = "/uploads/booking/".$file_name. "." . $ext;
				
				$where['booking_item_id'] = $booking_item_id;
				booking::update_item_image($update,$where);
				return true;
			} 
			else 
			{
				return false;
			}
			
			
        }
    }
	
	public function packaging(Request $request,$booking_id)
	{
		if(isset($request->booking_id) && isset($request->booking_item_id))
		{
		
			if(isset($request->packaging))
			{
				$update_items['pakaging'] = 1;
				$where_items['booking_item_id'] = $request->booking_item_id;
				$where_items['booking_id'] = $request->booking_id;
				booking::update_item($update_items,$where_items);
			}
		}
		
	}
	
	public function accuracy(Request $request,$booking_id)
	{
		$data['accuracy'] = $request->accuracy;
		$where['booking_id'] = $booking_id;
		booking::update_accuracy($data,$where);
	}
	
	public function quantity(Request $request,$booking_id)
	{
		if(isset($request->action) && $request->action == "+")
		{ 
			if($request->quantity > 0)
			{
				$update_item['quantity']  = $request->quantity + 1;
				$where['booking_item_id'] = $request->booking_item_id;
				$booking_item_id = booking::update_item($update_item,$where);
			}
			//return true;
			//return redirect()->to('booking/'.$booking_id);
		}
		elseif(isset($request->action) && $request->action == "-")
		{ 
			if($request->quantity > 1)
			{
				$update_item['quantity']  = $request->quantity - 1;
				$where['booking_item_id'] = $request->booking_item_id;
				$booking_item_id = booking::update_item($update_item,$where);
			}
			//return true;
			//return redirect()->to('booking/'.$booking_id);
		}
		
	}
	
	public function difficulty_level($selected_items,$booking_location)
	{
		$difficulty = Dlevel::orderBy('dlevel','ASC')->get();
		
		foreach($difficulty as $k => $v){$difficulty[$k]->dlevel = explode('-',$v->dlevel)[1];}
		
		// echo '<pre>';
		// print_r($selected_items);
		// echo '</pre>';
		// die;
		
		$level = array();
		foreach($difficulty as $k => $lvl)
		{
		
			$level[$k]['id'] = $lvl->id;
			$level[$k]['dlevel'] = $lvl->dlevel;
			$level[$k]['flights'] = 0;
			$level[$k]['stairs_type'] = 0;
			$level[$k]['elevator'] = 0;
			
			foreach($booking_location as $loc)
			{
				if($lvl->stairs >= $loc->flights && $loc->flights > 0 && $lvl->stairs > 0)
				{
					if($level[$k]['flights'] == 0){$level[$k]['flights'] = $loc->flights;}else{$level[$k]['flights'] = isset($level[$k]['flights']) ? $level[$k]['flights'].','.$loc->flights : $loc->flights;}
				}
				
				if($lvl->stairs_type == $loc->stair_type)
				{
					if($level[$k]['stairs_type'] == 0){$level[$k]['stairs_type'] = $loc->stair_type;}else{$level[$k]['stairs_type'] = $level[$k]['stairs_type'].','.$loc->stair_type;}
				}
				
				if(in_array($loc->evelator_type,explode(',',$lvl->elevator)))
				{
					if($level[$k]['elevator'] == 0){$level[$k]['elevator'] = $loc->inventory_elevator;}else{$level[$k]['elevator'] = $level[$k]['elevator'].','.$loc->inventory_elevator;}
				}
			}
			
			foreach($selected_items as $item)
			{
				if(in_array($item->item_name,explode(',',$lvl->items)))
				{
					$level[$k]['item_name'] = isset($level[$k]['item_name']) ? $level[$k]['item_name'].','.$item->item_name : $item->item_name;
				}
				
				if($item->hoisting == $lvl->hoisting && $lvl->hoisting > 0)
				{
					$level[$k]['hoisting'] = isset($level[$k]['hoisting']) ? $level[$k]['hoisting'].','.$item->hoisting : $item->hoisting;
				}
				
				if(in_array($item->ranking_id,explode(',',$lvl->ranking)) && $lvl->ranking > 0)
				{
					$level[$k]['ranking'] = isset($level[$k]['ranking']) ? $level[$k]['ranking'].','.$item->ranking_id : $item->ranking_id;
				}
			}
		}
		
		$this->printer($selected_items,$level);
		
		foreach($difficulty as $k => $d)
		{
			if($d->dlevel == $level[$k]['dlevel'])
			{
				if($level[$k]['stairs_type'] > 0 || $level[$k]['elevator'] > 0)
				{
					$confirm_level[$d->id][] = 'stairs';
				}
				if(isset($level[$k]['flights']) && $level[$k]['flights'] > 0)
				{
					$confirm_level[$d->id][] = 'flights';
				}
				if(isset($level[$k]['hoisting']) && count(explode(',',$level[$k]['hoisting'])) > 0)
				{
					$confirm_level[$d->id][] = 'hoisting';
				}
				if(isset($level[$k]['ranking']) && count(explode(',',$level[$k]['ranking'])) > 0)
				{
					$confirm_level[$d->id][] = 'ranking';
				}
			}
		}
		
		// echo '<pre>';
		// print_r($confirm_level);
		// echo '</pre>';
		
		$count = 0;
		foreach($confirm_level as $k => $c)
		{
			if(count($c) > $count)
			{
				$count = count($c);
				$dlevel_id = $k;
			}
		}
		
		// echo '<pre>';
		// echo 'count: ' . $count . ' dlevel_id: ' . $dlevel_id;
		// echo '</pre>';
		
		if(isset($dlevel_id) && $dlevel_id > 0)
		{
			$combination = Dlevel::GetCrewCombination(array('dlevel'=> $dlevel_id ))->get();
			$hourly_rate = Role::where('hourly_rate','<>','')->select('id','name','hourly_rate')->get();
			
			foreach($combination as $k => $comb)
			{
				$total_hourly_rate = 0;
				
				foreach($hourly_rate as $rate)
				{
					if(in_array($rate->id,explode(',',$comb->roles)))
					{
						$total_hourly_rate = $total_hourly_rate + $rate->hourly_rate; 
						$combination[$k]->rate = isset($combination[$k]->rate) ? $combination[$k]->rate.','.$rate->hourly_rate : $rate->hourly_rate;
					}
				}
				
				$total_crew_rates[] = $combination[$k]->total_rate = $total_hourly_rate;
			}
			
		}
		else
		{
			echo '<font color="red"> Difficulty Level not Found</font>';
		}
		
		if(isset($combination))
		{
			// echo '<pre>';
			// print_r($combination);
			// echo '</pre>';
			
			$average_crew_rates = array_sum($total_crew_rates) / count($total_crew_rates);
			
			// echo '<pre>';
			// print_r($total_crew_rates);
			// echo '</pre>';
			
			
		}
		else
		{
			echo '<font color="red"> Crew Combination not Found</font>';
		}
		
		return array($average_crew_rates,$combination);
		
	}
	
	public function printer($selected_items,$level)
	{
		echo '<style>#customers {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;} #customers td, #customers th {border: 1px solid #ddd;padding: 8px;} #customers tr:nth-child(even){background-color: #f2f2f2;} #customers tr:hover {background-color: #ddd;} #customers th {padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white;}</style>';
				
		$s_items = '<table id="customers" class="table table-bordered table-striped">';
		$s_items.= '<tr><th>Item</th><th>flights</th><th>stairs_type</th><th>hoisting</th><th>elevator</th><th>ranking</th></tr>';
		foreach($selected_items as $item)
		{
			$s_items.= '<tr><td>'.$item->name.'</td><td>'.$item->flights.'</td><td>'.$item->stair_type.'</td><td>'.$item->hoisting.'</td><td>'.$item->evelator_type.'</td><td>'.$item->inventory_ranking.'</td></tr>';
		}
		$s_items.= '</table>';
		
		$s_lvl =  '<table id="customers" class="table table-bordered table-striped">';
		$s_lvl .= '<tr><th>Id</th><th>Dlevel</th><th>Item</th><th>flights</th><th>stairs_type</th><th>hoisting</th><th>elevator</th><th>ranking</th><th>Match</th><th>Count</th></tr>';
		
		foreach($level as $lvl)
		{
			$s_lvl .= '<tr>';
			$s_lvl .= isset($lvl['id']) ? '<td>'.$lvl['id'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['dlevel']) ? '<td>'.$lvl['dlevel'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['item_name']) ? '<td>'.$lvl['item_name'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['flights']) ? '<td>'.$lvl['flights'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['stairs_type']) ? '<td>'.$lvl['stairs_type'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['hoisting']) ? '<td>'.$lvl['hoisting'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['elevator']) ? '<td>'.$lvl['elevator'].'</td>' : '<td></td>';
			$s_lvl .= isset($lvl['ranking']) ? '<td>'.$lvl['ranking'].'</td>' : '<td></td>';
			
			$match = 0;
			$match_itm = array();
			
			if($lvl['stairs_type'] > 0 || $lvl['elevator'] > 0)
			{
				$match_itm[] = 'stairs';
				$match = $match + 1;
			}
			if(isset($lvl['flights']) && count(explode(',',$lvl['flights'])) > 0 && ($lvl['flights'] > 0))
			{
				$match_itm[] = 'flights';
				$match = $match + 1;
			}
			if(isset($lvl['hoisting']) && count(explode(',',$lvl['hoisting'])) > 0)
			{
				$match_itm[] = 'hoisting';
				$match = $match + 1;
			}
			if(isset($lvl['ranking']) && count(explode(',',$lvl['ranking'])) > 0)
			{
				$match_itm[] = 'ranking';
				$match = $match + 1;
			}
			
			$s_lvl .= '<td>'.implode('<br>',$match_itm).'</td>';
			$s_lvl .= '<td>'.$match.'</td>';
			$s_lvl .= '</tr>';
		}
		$s_lvl .= '</table>';
		
		// echo $s_items;
		// echo $s_lvl;
		
	}
	
	public function item_moving_time($request,$item,$action)
	{
		
		$inventory = Inventory::where('id',$item['item_id'])->first();
		
		if($action == 'pick_up')
		{
			$loc = DB::table('booking_form_location')->where('booking_loc_id',$item['pick_up_loc_id'])->first();
		}
		if($action == 'drop_off')
		{
			$loc = DB::table('booking_form_location')->where('booking_loc_id',$item['drop_off_loc_id'])->first();
		}
			
		// Get Total Number Of Stairs of Pick Or Drop location
		$flight_no = $loc->flights;
		if($flight_no == 0)
		{
			$avg_time = ($inventory->time_0_min + $inventory->time_0_med + $inventory->time_0_max)/3;
		}
		if($flight_no == 1)
		{
			$avg_time = ($inventory->time_1_min + $inventory->time_1_med+ $inventory->time_1_max)/3;
		}
		if($flight_no == 2)
		{
			$avg_time = ($inventory->time_2_min +$inventory->time_2_med +$inventory->time_2_max)/3;
		}
		if($flight_no == 3)
		{
			$avg_time = ($inventory->time_3_min+ $inventory->time_3_med +$inventory->time_3_max)/3;
		}
		if($flight_no == 4)
		{
			$avg_time = ($inventory->time_4_min +$inventory->time_4_med +$inventory->time_4_max)/3;
		}
		if($flight_no == 5)
		{
			$avg_time = ($inventory->time_5_min +$inventory->time_5_med +$inventory->time_5_max)/3;
		}
		if($flight_no == 6)
		{
			$avg_time = ($inventory->time_6_min + $inventory->time_6_med +$inventory->time_6_max)/3;
		}
		
		// If Stairs type is windy helper take less time  
		if($loc->stair_type == 'windy')
		{
			$avg_time = $avg_time + $inventory->stair_windy;
		}
		
		// If Stairs type is narrow helper take more time 
		if($loc->stair_type == 'narrow')
		{
			$avg_time = $avg_time + $inventory->stair_narrow;
		}
		
		$avg_time = $avg_time + $item['ranking'];
		
		return $avg_time;
	}
	
	
	function GetHubTime($lat,$lng)
	{
		$start_point = '24.887107,67.154963';
		$end_point = $lat .','. $lng;
		
		$origins = 'origins='.$start_point;
		$destination = 'destinations='.$end_point;
		
		$key = 'key=AIzaSyBIUaBvvlXdLIxkhAVVqQJC7jhSg98g7NE';
		
		$url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial';
		$url .= '&'.$origins.'&'.$destination.'&'.$key;
		
		// get the json response from url
		$resp = json_decode(file_get_contents($url), true);
		
		if($resp['rows'][0]['elements'][0]['duration']['text'])
		{
			$dist_time = $resp['rows'][0]['elements'][0]['duration']['text'];
		}
		
		return $dist_time;
		
	}

}
