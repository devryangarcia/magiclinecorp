<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('LoggedUser')) {
            $user = User::find(session()->get('LoggedUser'));
            if($user->status=='deactivated'){
            Auth::logout();
            
            $request->session()->put('Reason', 'Your account has been deactivated');
            return redirect()->route('logout');
            }
        }

        return $next($request);
    }
}
