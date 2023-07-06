<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{

    protected $fillable = ['name', 'type', 'samsara_id', 'overall_height', 'overall_width', 'wheel_base', 'gvw_rating', 'towing_capacity', 'payload_capacity', 'towing_capacity_maximum', 'cargo_length', 'cargo_width', 'title_number', 'year', 'reg_no', 'color', 'fuel_volume', 'fuel_type', 'weight', 'width', 'height', 'breadth', 'mileage', 'volume', 'multiplier', 'packing_volume', 'threshold'];

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function serviceLogs()
    {
        return $this->hasOne(ServiceLog::class)->latest();
    }

    public function stickerLogs()
    {
        return $this->hasMany(StickerLog::class);
    }
	
	public static function GetAvailableTruck($param = null)
	{
		$trucks = DB::table('trucks as t')->select('*','t.id as pk_truck_id');
		$trucks = $trucks->leftJoin('vehicle_schedules as sch', 'sch.truck_id', '=', 't.id');
		
		if($param['created_at'])
		{
			$trucks = $trucks->where('sch.created_at',$param['created_at']);
			$trucks = $trucks->where('sch.end_time','<',$param['start_time']);
		}
		
		if($param['created_at'] == null)
		{
			$trucks = $trucks->where('sch.created_at',$param['created_at']);
		}
		
		
		$trucks = $trucks->limit(4);
		
		return $trucks;
		
		//$trucks = $trucks->whereNotNull('t.truck_id');
		//$trucks = $trucks->where('sch.truck_id',null);
	}
	
	public static function GetAllAvailableTruck($param = null)
	{
		$trucks = DB::table('booking_form')->select('truck_id');
		
		$trucks = $trucks->whereNotNull('truck_id');
		$trucks = $trucks->where('status','Pending');
		
		if(!empty($param['primary_date']))
		{
			$trucks = $trucks->whereRaw('primary_date >= "'.$param['primary_date'] . '"');
		}
		
		$trucks = $trucks->groupBy('truck_id')->get();
		
		$truck_ids = array();
		foreach($trucks as $truck)
		{
			$truck_ids[] = $truck->truck_id;
		}
		
		$available_truck = DB::table('trucks')->select('id','volume');
		
		if(!empty($truck_ids))
		{
			$available_truck = $available_truck->whereNotIn('id',$truck_ids);
		}
		
		if(!empty($param['volume']))
		{
			$available_truck = $available_truck->whereRaw('volume > '.$param['volume']);
		}
		
		$available_truck = $available_truck->first();
		return $available_truck;
		
	}
}
