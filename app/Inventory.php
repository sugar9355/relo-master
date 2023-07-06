<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['name','meterial','category_id','equipments', 'storage_price', 'weight_min', 'junk_price_min', 'weight_max', 'junk_price_max', 'width','height','breadth','volume', 'multiplier', 'packing_volume', 'R_A','R_B','R_C','R_D','R_E','ranking_id','ranking_time','stair_windy','stair_narrow', 'stair_wide', 'stair_spiral', 'elevator_passenger', 'elevator_freight', 'elevator_reserved_freight', 'time_0_min','time_0_med','time_0_max','time_1_min','time_1_med','time_1_max','time_2_min','time_2_med','time_2_max','time_3_min','time_3_med','time_3_max','time_4_min','time_4_med','time_4_max','time_5_min','time_5_med','time_5_max','time_6_min','time_6_med','time_6_max', 'wrapping_material', 'wrapping_price', 'wrapping_time', 'wrapping_qty'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'item_id');
    }
    
    public static function GetInventoryItemTime($item_ids,$accuracy)
    {
        $inventoryItemTime = DB::table('inventories');
        
        $inventoryItemTime = $inventoryItemTime->select('id','name','weight','width','height','breadth','volume','R_A','R_B','R_C','R_D','R_E');
        $inventoryItemTime = $inventoryItemTime->addSelect('time_0_min', 'time_0_med', 'time_0_max');  
        $inventoryItemTime = $inventoryItemTime->addSelect('time_1_min', 'time_1_med', 'time_1_max');  
        $inventoryItemTime = $inventoryItemTime->addSelect('time_2_min', 'time_2_med', 'time_2_max');  
        $inventoryItemTime = $inventoryItemTime->addSelect('time_3_min', 'time_3_med', 'time_3_max');  
        $inventoryItemTime = $inventoryItemTime->addSelect('time_4_min', 'time_4_med', 'time_4_max');  
        $inventoryItemTime = $inventoryItemTime->addSelect('time_5_min', 'time_5_med', 'time_5_max');  
        $inventoryItemTime = $inventoryItemTime->addSelect('time_6_min', 'time_6_med', 'time_6_max'); 
        
        if(!empty($item_ids))
        {
            $inventoryItemTime = $inventoryItemTime->whereIn('id',$item_ids);
        }
        
        if(!empty($accuracy))
        {
            if($accuracy == 'not accurate')
            {
                $inventoryItemTime = $inventoryItemTime->select('time','time_med','time_max');
            }
            
            if($accuracy == 'somewhat accurate')
            {
                $inventoryItemTime = $inventoryItemTime->select('time','time_med','time_max');
            }
            
            if($accuracy == 'accurate')
            {
                $inventoryItemTime = $inventoryItemTime->select('time','time_med','time_max');
            }
            
            if($accuracy == 'very accurate')
            {
                $inventoryItemTime = $inventoryItemTime->select('time','time_med','time_max');
            }
        }
        
        $inventoryItemTime = $inventoryItemTime->get();
        
        return $inventoryItemTime;
    }
    
    
    public static function SearchInventoryItems($param = null)
    {
        $inventory = DB::table('inventories');
        
        if(!empty($param['item_search']))
        {
            // $inventory = $inventory->where('name', 'LIKE', '%' . $param['item_search'] . '%');
            $inventory = $inventory->where('name', $param['item_search']);
        }
        if(!empty($param['item_ids']))
        {
            $inventory = $inventory->whereIn('id', explode(',',$param['item_ids']));
        }
        
        $inventory = $inventory->get();
        
        return $inventory;
    }
    
    public static function GetRanking($ranking_id = null)
    {
        $GetRanking = DB::table('ranking');
        
        $GetRanking = $GetRanking->select('ranking_id','alphabet','ranking_name','ranking_time','created_at','updated_at');
        
        if(!empty($ranking_id))
        {
            $GetRanking = $GetRanking->whereIn('ranking_id',$ranking_id);
        }
        
        $GetRanking = $GetRanking->get();
        
        return $GetRanking;
    }
    
    public static function GetQuestion($item_ids)
    {
        $Question = DB::table('questions');
        
        $Question = $Question->whereIn('item_id',$item_ids);
        
        return $Question;
    }
    
    public static function GetInventoryEquipment()
    {
        $equipments = DB::table('equipments')->get();
        
        return $equipments;
    }
    
    public static function GetInventoryQuestion($item_id)
    {
        return DB::table('inventory_questions')->where('item_id',$item_id)->get();
    }
    
    public static function AddInventoryQuestion($data)
    {
        DB::table('inventory_questions')->insert($data);
    }
    
    public static function DeleteInventoryQuestion($where)
    {
        DB::table('inventory_questions')->where($where)->delete();
    }
    
    public static function save_item_image($data)
    {
        return DB::table('inventories')->insertGetId($data);
    }
    
    public static function update_item_image($update,$where)
    {
        DB::table('inventories')->where($where)->update($update);
    }
    
    
    
}


