<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('LoggedUser') && ($request->path() !='login')){
            return redirect('login')->with('fail','You must be logged in');
        }

        if(session()->has('LoggedUser') && ($request->path() == 'login') ){
            return back();
        }
        // check if the user has a valid cookie
        if ($request->cookie('user_id') && !Auth::check()) {
            // attempt to log in the user using the user_id cookie
            $user = User::find($request->cookie('user_id'));

            if ($user) {
                Auth::login($user);
            } else {
                return redirect()->route('login');
            }
        }
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat 01 Jan 1990 00:00:00 GMT');
    }
}
