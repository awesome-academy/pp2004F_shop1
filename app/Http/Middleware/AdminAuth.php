<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
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
        if ($request->is('admin*') || $request->is('admin/*')) {
            if ( (!\Auth::check() || (\Auth::check() && ! \Auth::user()->isAdmin())) && !$request->is('admin/login')) {
                return redirect()->route('admin.login')
                    ->withPermission('You dont have permission to access');
            }
        }
        return $next($request);
    }
}
