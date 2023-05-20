<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InactivityTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $timeout = 30 * 60 * 1000; // 30 minutes in milliseconds
        
        $script = <<<JS
            <script>
                var timer = setTimeout(function() {
                    window.location.href = '/lockscreen';
                }, $timeout);
                document.addEventListener('mousemove', function() {
                    clearTimeout(timer);
                    timer = setTimeout(function() {
                        window.location.href = '/lockscreen';
                    }, $timeout);
                });
            </script>
        JS;
        
        // Add the JavaScript to the response
        $response = $next($request);
        $response->setContent($response->getContent() . $script);
        
        // Check if the user is already authenticated
        if (!$request->session()->get('isUnlocked')) {
            // If not, redirect to the lockscreen
            return redirect('/lockscreen');
        }
        
        return $response;
    }
}
