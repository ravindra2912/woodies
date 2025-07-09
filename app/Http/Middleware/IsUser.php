<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		if(isset(Auth::user()->id) && !empty(Auth::user()->id) && Auth::user()->role_id != '1'){
            return $next($request);
        }
        else{
            if($request->ajax()){
                return response()->json(['success' => false, 'message' => 'Un-Authenticated Access', 'data' => array() ]);
            }else{
                return redirect()->route('home');
            }
        }
    }
}
