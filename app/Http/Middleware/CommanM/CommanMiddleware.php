<?php

namespace App\Http\Middleware\CommanM;

use Closure;
use Illuminate\Support\Facades\Session;

class CommanMiddleware
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

        if (Session::has('RoleId')) {
            $TIMEZONE = Session::get('TIMEZONE');
            SetTimeZone($TIMEZONE);
            $DATABASENAME = Session::get('DATABASENAME');
            Setthedatabase($DATABASENAME);
            return $next($request);
        } else {
            return redirect('/')->withErrors(['Token Expires, Please try again']);
        }
    }
}
