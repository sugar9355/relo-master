<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class JobAssignedUser extends Model
{
    
    protected $fillable = [ ];
	protected $table = 'user_badges';
	
	public static function UpdateUserBadges($badge)
	{
		$column = 'user_id, badge_id, badge_name, bonus, ref_bonus, level, hours, created_at, updated_at';
		
		DB::select('INSERT IGNORE INTO user_badges ('.$column.') VALUES ('.$badge.') on duplicate key update updated_at = "'.now().'"');
		
	}
	
	public static function UpdateUserLevel($level)
	{
		$column = 'user_id, level_id, level_name, bonus, ref_bonus, level, hours, created_at, updated_at';
		
		DB::select('INSERT IGNORE INTO user_level ('.$column.') VALUES ('.$level.') on duplicate key update updated_at = "'.now().'"');
		
	}
	
	
}
