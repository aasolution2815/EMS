<?php

namespace App\Http\Middleware\SuperAdmin;

use Closure;
use Illuminate\Support\Facades\Session;

class SuperAdminMiddleware
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
            $ROLEID = Session::get('RoleId');
            $TIMEZONE = Session::get('TIMEZONE');
            SetTimeZone($TIMEZONE);
            $DATABASENAME = Session::get('DATABASENAME');
            Setthedatabase($DATABASENAME);
            $TODAYDATE = date('Y-m-d');
            $TODAYTIME = date(' H:i:s');
            if ($ROLEID == 1 || $ROLEID == 2) {
                return $next($request);
            } else {
                $USERID = Session::get('USERID');
                $SAVELOGINREPORTS['USER_ID'] = $USERID;
                $SAVELOGINREPORTS['ACTION_DATE'] = $TODAYDATE;
                $SAVELOGINREPORTS['ACTION_TIME'] = $TODAYTIME;
                $SAVELOGINREPORTS['STATUS'] = 'Logout';
                insertRecords($SAVELOGINREPORTS, 'mst_tbl_login_aduit_reports');
                Session::flush();
                return redirect('/')->withErrors(['Invalid Route, Please try again']);
            }

        } else {
            return redirect('/')->withErrors(['Token Expires, Please try again']);
        }
    }
}
