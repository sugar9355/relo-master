<?php

namespace App\Http\Middleware;

use App\Model;
use App\User;
use Closure;

class Captain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $device_id = $request->device_id;
		
        $exist = User::where('device_id',$device_id)->get();
		
        if (empty($exist[0])) 
		{
			 return response()->json(['error' => 'User Not Found'], 500);
        }
       
        return $next($request);
    }
}
