<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'material', 'weight_min', 'junk_price_min', 'weight_max', 'junk_price_max', 'width', 'height', 'breadth', 'volume', 'multiplier', 'packing_volume', 'storage_price', 'time_o_min','time_o_med','time_o_max','time_1_min','time_1_med','time_1_max','time_2_min','time_2_med','time_2_max','time_3_min','time_3_med','time_3_max','time_4_min','time_4_med','time_4_max','time_5_min','time_5_med','time_5_max','time_6_min','time_6_med','time_6_max', 'wrapping_material', 'wrapping_qty', 'wrapping_time', 'wrapping_price'];
    
    public static function AddQuestion($data)
    {
        DB::table('category_questions')->insert($data);
    }
    
    public static function GetQuestion($category_id=null)
    {
        return DB::table('category_questions')->get();
    }
    
    public static function GetCategoryQuestion($category_id=null)
    {
        return DB::table('category_questions')->where('category_id',$category_id)->get();
    }
    
    public static function save_category($data)
    {
        return DB::table('categories')->insertGetId($data);
    }
    
    public static function update_category($update,$where)
    {
        DB::table('categories')->where('id',$where)->update($update);
    }
    
    
    
}
