<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['booking_id',' step',' user_id',' s_lat',' s_lng',' d_lat',' d_lng',' distance',' minutes',' s_address',' d_address',' service_type_id',' primary_date',' secondary_date',' start_time',' end_time',' booking_date',' zonetype',' packaging',' accuracy',' created_at',' updated_at'];
	protected $table = 'booking_form';
	
	public static function BookingColumns()
	{
		return DB::getSchemaBuilder()->getColumnListing('booking_form');
	}
	
	public static function get_booking($param=null,$join=null,$select=null)
	{
		$booking = DB::table('booking_form as b')->selectRaw('*');
		
		if(isset($select['customer']))
		{
			$booking = $booking->selectRaw(' (select concat(first_name," ",last_name) from users where b.captain_id = id ) as customer  ');
		}
		
		if(isset($join['users']))
		{
			$booking = $booking->join('users as u', 'u.id', '=', 'b.user_id');
		}
		
		if(isset($join['trucks']))
		{
			$booking = $booking->join('trucks as t', 't.id', '=', 'b.truck_id');
		}
		
		if(isset($param['booking_id']))
		{
			$booking = $booking->where('booking_id',$booking_id);
		}
		
		if(isset($param['truck_id']))
		{
			$booking = $booking->where('truck_id',$param['truck_id']);
		}
		
		if(isset($param['month']))
		{
			$booking = $booking->whereMonth('primary_date',$param['month']);
		}
		if(isset($param['year']))
		{
			$booking = $booking->whereYear('primary_date',$param['year']);
		}
		
		
		if(isset($param['search']))
		{
			$search =  ' b.start_time like "%'.$param["search"].'%" or ';
			$search .=  'b.primary_date like "%'.$param["search"].'%" or ';
			$search .=  ' concat(u.first_name," ",u.last_name) like "%'.$param["search"].'%" or ';
			$search .=  ' t.name like "%'.$param["search"].'%" ';
			$booking = $booking->whereRaw($search);
		}
		
		return  $booking;
	}
	
	public static function get_booking_form($booking_id)
	{
		return  DB::table('booking_form as b')->selectRaw('*,t.name as truck_name,t.type as truck_type,t.volume as truck_volume')
		->leftJoin('trucks as t', 't.id', '=', 'b.truck_id')
		->where('booking_id',$booking_id)->first();
	}
	
	
	public static function save_location($data)
	{
		DB::table('booking_form_location')->insert($data);
	}
	
	public static function save_booking_dates($data)
	{
		DB::table('booking_form_dates')->insert($data);
	}
	
	public static function delete_booking_dates($booking_id=null,$booking_date=null)
	{
		$date = DB::table('booking_form_dates');
		
		if(!empty($booking_date))
		{	
			$date = $date->where('booking_date',$booking_date);
		}
		
		$date->where('booking_id',$booking_id)->delete();
	}
	
	public static function delete_location($booking_id)
	{
		DB::table('booking_form_location')->where('booking_id',$booking_id)->delete();
	}
	
	public static function update_quantity($update,$where)
	{
		DB::table('booking_form_items')->where($where)->update($update);
	}
	
	
	
	public static function update_location($data,$booking_id,$booking_location_id)
	{
		DB::table('booking_form_location')
		->where('booking_id',$booking_id)
		->where('booking_loc_id',$booking_location_id)
		->update($data);
	}
	
	public static function save_item($data)
	{
		return DB::table('booking_form_items')->insertGetId($data);
	}

	public static function save_item_image($data)
	{
		return DB::table('booking_form_item_file')->insertGetId($data);
	}
	
	public static function update_item_image($update,$where)
	{
		DB::table('booking_form_item_file')->where($where)->update($update);
	}
	
	public static function get_item_images($param)
	{
		$image = DB::table('booking_form_item_file');
		
		if(isset($param['booking_id']))
		{
			$image = $image->where('booking_id',$param['booking_id']);
		}
		
		return  $image;
	}	
	
	
	public static function get_booking_truck($param)
	{
		$truck = DB::table('booking_form_truck as bt');
		
		$truck = $truck->join('trucks as t', 't.id', '=', 'bt.truck_id');
		
		if(isset($param['booking_id']))
		{
			$truck = $truck->where('booking_id',$param['booking_id']);
		}
		
		if(isset($param['status']))
		{
			$truck = $truck->where('status',$param['status']);
		}
		
		return $truck;
		
	}
	
	
	public static function update_truck_availability($booking_id,$data)
	{
		DB::table('booking_form_truck')->where('booking_id',$booking_id)->update($data);
	}
	
	public static function add_booking_truck($data)
	{
		DB::table('booking_form_truck')->insert($data);
	}
	
	public static function update_booking_truck($data,$where)
	{
		DB::table('booking_form_truck')->where($where)->update($data);
	}
	
	public static function update_item($data,$where)
	{
		DB::table('booking_form_items')->where($where)->update($data);
	}
	
	public static function update_accuracy($data,$where)
	{
		DB::table('booking_form')->where($where)->update($data);
	}
	
	public static function save_insurance($data)
	{
		DB::table('booking_form_insurance')->insert($data);
	}
	
	public static function update_insurance($update,$where)
	{
		DB::table('booking_form_insurance')->where($where)->update($update);
	}
	
	public static function save_property_insurance($data)
	{
		DB::table('booking_form_property_insurance')->insert($data);
	}
	
	public static function delete_insurance($booking_id)
	{
		return DB::table('booking_form_insurance')->where('booking_id',$booking_id)->delete();
	}
	
	public static function save_answer($data)
	{
		DB::table('booking_form_item_answer')->insert($data);
	}
	
	public static function get_booking_location($booking_id)
	{
		return DB::table('booking_form_location')->where('booking_id',$booking_id)->get();
	}
	
	// public static function get_booking_insurance($booking_id)
	// {
		// return DB::table('booking_form_insurance')->where('booking_id',$booking_id)->get();
	// }
	
	public static function get_booking_dates($booking_id)
	{
		return DB::table('booking_form_dates')->where('booking_id',$booking_id)->get();
	}
	
	public static function get_booking_items($booking_id,$join=null)
	{
		$items = DB::table('booking_form_items as i')->select('*','i.booking_item_id as pk_booking_item_id');
		
		if(!empty($join['booking_form_insurance_left']))
		{
			$items = $items->leftJoin('booking_form_insurance as is', 'is.booking_item_id', '=', 'i.booking_item_id');
		}
		if(!empty($join['booking_form_insurance']))
		{
			$items = $items->join('booking_form_insurance as is', 'is.booking_item_id', '=', 'i.booking_item_id');
		}
		
		if(!empty($join['inventories']))
		{
		
			$items = $items->join('inventories as ivn', 'ivn.id', '=', 'i.item_id');
			$items = $items->join('booking_form_location as p_loc', 'i.pick_up_loc_id' ,'=', 'p_loc.booking_loc_id');
			$items = $items->join('booking_form_location as d_loc', 'i.drop_off_loc_id','=', 'd_loc.booking_loc_id');
			$items = $items->addSelect('ivn.ranking_id as inventory_ranking');
		}
		
		$items = $items->where('i.booking_id',$booking_id)->get();
		
		return $items;
	}
	
	public static function get_booking_items_count($booking_ids)
	{
		return DB::select('select count(item_id) as count, `booking_id` from booking_form_items where booking_id in ('.$booking_ids.') group by booking_id');
	}
	
	public static function get_inventory_booking_items($booking_id)
	{
		$item =  DB::table('booking_form_items as b')->select('*');
		
		// $item = $item->selectRaw('round(((time_0_min+time_0_med+time_0_max)/3)) as avg_time_0, ');
		// $item = $item->selectRaw('round(((time_1_min+time_1_med+time_1_max)/3)) as avg_time_1');
		// $item = $item->selectRaw('round(((time_2_min+time_2_med+time_2_max)/3)) as avg_time_2');
		// $item = $item->selectRaw('round(((time_3_min+time_3_med+time_3_max)/3)) as avg_time_3');
		// $item = $item->selectRaw('round(((time_4_min+time_4_med+time_4_max)/3)) as avg_time_4');
		// $item = $item->selectRaw('round(((time_5_min+time_5_med+time_5_max)/3)) as avg_time_5');
		// $item = $item->selectRaw('round(((time_6_min+time_6_med+time_6_max)/3)) as avg_time_6');
		
		$item = $item->join('inventories as i', 'i.id', '=', 'b.item_id');
		$item = $item->where('b.booking_id',$booking_id);
		$item = $item->get();
		return $item;
	}
	
	public static function get_booking_item($booking_item_id)
	{
		$item =  DB::table('booking_form_items as b')->select('*');
		$item = $item->join('inventories as i', 'i.id', '=', 'b.item_id');
		$item = $item->where('b.booking_item_id',$booking_item_id);
		$item = $item->first();
		return $item;
	}
	
	public static function get_inventory_insurance_booking_items($booking_id)
	{
		$item =  DB::table('booking_form_items as b')->select('*');
		$item = $item->join('inventories as i', 'i.id', '=', 'b.item_id');
		$item = $item->leftJoin('booking_form_insurance as bi', 'bi.booking_item_id', '=', 'b.item_id');
		$item = $item->where('b.booking_id',$booking_id);
		$item = $item->get();
		return $item;
	}
	
	public static function get_booking_item_answers($booking_id)
	{
		return DB::table('booking_form_item_answer')->where('booking_id',$booking_id)->get();
	}
	
	public static function get_booking_insurance($booking_id)
	{
		return DB::table('booking_form_insurance as b')
		->join('insurance_categories as i', 'i.id', '=', 'b.insurance_id')
		->join('booking_form_items as itm', 'itm.booking_item_id', '=', 'b.booking_item_id')
		->where('b.booking_id',$booking_id)->get();
	}
	
	public static function delete_item($booking_item_id)
	{
		return DB::table('booking_form_items')->where('booking_item_id',$booking_item_id)->delete();
	}
	
	
}
