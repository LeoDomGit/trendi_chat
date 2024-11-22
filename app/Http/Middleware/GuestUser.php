<?php

namespace App\Http\Middleware;

use App\Models\GuestUser as ModelsGuestUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestUser
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
        if(!$request->has('device_id')){
            return response()->json(['status'=>'error','message'=>'device_id is required'],401);
        }
        $deviceId = $request->input('device_id');

        $user = ModelsGuestUser::firstOrCreate(
            ['device_id' => $deviceId], // Search for the device_id
            ['name' => 'Guest User']   // Default attributes for a new guest user
        );
        Auth::login($user);

        return $next($request);
    }
}
