<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\User; //custom
use Closure;
use Illuminate\Http\Request; //custom
use Session; //custom

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Session::has('userId') || Session::has('userId') == null) {
            return redirect()->route('logOut');
        } else {
            $user = User::where('status', 1)->where('id', currentUserId())->first();
            if (! $user) {
                return redirect()->route('logOut');
            } elseif ($user->full_access == '1') {
                return $next($request);
            } else {
                $auto_accept = ['POST', 'PUT'];
                if (in_array($request->route()->methods[0], $auto_accept)) {
                    return $next($request);
                } else {
                    if (Permission::where('role_id', $user->role_id)->where('name', $request->route()->getName())->exists()) {
                        return $next($request);
                    } else {
                        \Toastr::warning("You don't have permission to access this page");

                        return redirect()->back();
                    }
                }
            }
        }

        return redirect()->route('logOut');
    }
}
