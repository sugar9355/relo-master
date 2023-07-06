<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Dlevel extends Model
{
    protected $fillable = ['dlevel', 'items','stairs','stairs_type','hoisting','elevator','ranking','category','weight', 'wei_min', 'wei_max', 'groundfloor', 'bulkhead', 'entrance'];
    
    
    public static function AddCrewCombination($data)
    {
        DB::table('crew_combination')->insert($data);
    }
    
    public static function DeleteCrewCombination($param=null)
    {
        $crew = DB::table('crew_combination');
        
        if(!empty($param['pk_id']))
        {
            $crew = $crew->where('id',$param['pk_id']);
        }
        if(!empty($param['dlevel_id']))
        {
            $crew = $crew->where('dlevel_id',$param['dlevel_id']);
        }
        
        $crew = $crew->delete();
    }
    
    public static function GetCrewCombination($param=null,$join=null,$select=null)
    {
        $crew = DB::table('crew_combination');
        
        if(!empty($param['dlevel']))
        {
            $crew = $crew->where('dlevel_id',$param['dlevel']);
        }
    
        return $crew;
        
        //->whereIn('dlevel_id',$param['dlevel_ids']);
    }
    
    
}
