<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    
    protected $fillable = [
        'designation_id',
		'video_name',
		'description',
        'file',
    ];
	
	
	
	public static function save_description($data)
	{
		DB::table('videos')->insert($data);
	}
}
