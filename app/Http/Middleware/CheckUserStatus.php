<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\UserPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \auth()->user();
        if ($user->status != 'active' ){
            if(Auth::check()){
                auth()->user()->tokens()->delete();
                $response = [
                    'success'=> false,
                    'message'=> "User is suspended by Amdin"
                ];
            }

            return response()->json($response);
        }
        return $next($request);
    }
}
