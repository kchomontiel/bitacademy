<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Session; //added
use Symfony\Component\HttpFoundation\Response; //added

class isSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Session::has('userId') || Session::has('userId') == null || ! Session::has('roleIdentity')) {
            return redirect()->route('logOut');
        } else {
            $user = User::findOrFail(currentUserId());
            app()->setLocale($user->language); //language
            if (! $user) {
                return redirect()->route('logOut');
            } elseif (currentUser() != 'superadmin') {
                return redirect()->back()->with('danger', 'Access Denied');
            } else {
                return $next($request);
            }
        }

        return redirect()->route('logOut');
    }
}
