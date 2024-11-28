<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure; //custom
use Illuminate\Http\Request;
use Session; //custom

//custom

class checkStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Session::has('userId') || Session::has('userId') == null) {
            return redirect()->route('studentlogOut');
        } else {
            $user = Student::where('status', 1)->where('id', currentUserId())->exists();
            if (! $user) {
                return redirect()->route('studentlogOut');
            } else {
                return $next($request);
            }
        }

        return redirect()->route('studentlogOut');
    }
}
