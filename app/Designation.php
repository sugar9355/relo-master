<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    
    protected $fillable = [
        'name',
        'bonus',
        'badge_type',
        'options',
        'wei_min',
        'wei_max',
        'weight',
        'volumetric_capacity_min',
        'volumetric_capacity_max',
        'volumetric_capacity',
        'insurance_amount_min',
        'insurance_amount_max',
        'insurance_amount',
        'dis_assembly',
        'hoisting',
        'stairs',
        'roles',
        'image_path',
        'description',
    ];
    
    protected $table =  'designations';
    
    
    public static function GetUserAssignedBadges($param = null)
    {
        return DB::table('user_badges')->selectRaw('*')->where('user_id',$param['user_id']);
    }
    
    
    public static function GetBadgesType($param = null)
    {
        return DB::table('designation_type')->get();
    }
    
    public static function GetBadgesFactor($param = null)
    {
        return DB::table('designation_factors')->get();
    }
    
    public static function GetBadge($param = null)
    {
        $badge =  DB::table('designation_factors');
        
        if(!empty($param['factor_id']))
        {
            $badge = $badge->where('factor_id',$param['factor_id']);
        }
        
        $badge = $badge->first();
        
        return $badge;
        
    }
    
    public static function GetUserBadgeByRole($param = null)
    {
        $badge =  DB::table('user_badges as b');
        
        if(!empty($param['badge_ids']))
        {
            $badge = $badge->whereIn('b.badge_id',$param['badge_ids']);
        }
        
        if(!empty($param['captain_ids']))
        {
            $badge = $badge->whereIn('b.user_id',$param['captain_ids']);
        }
        
        //$badge = $badge->groupBy('b.user_id');
        $badge = $badge->get();
        
        return $badge;
        
    }
    
    public static function UpdateBadges($update,$where)
    {
        DB::table('designations')->where($where)->update($update);
    }
    
    public static function DeleteUserBadges($where)
    {
        DB::table('user_badges')->where($where)->delete();
    }
    
    public static function UpdateUserBadges($badge)
    {
        $column = 'user_id, badge_id, badge_name, bonus, hours, created_at, updated_at';
        
        DB::select('INSERT IGNORE INTO user_badges ('.$column.') VALUES ('.$badge.') on duplicate key update updated_at = "'.now().'"');
        
    }
}
