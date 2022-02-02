<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class isAdmin extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function redirectTo($request)
    {
        // dd($this->getGuard());
        if (! $request->ajax()) {
            // dd($request);
            return route('admin.login');
        }
        
    }
}