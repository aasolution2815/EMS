<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Support\Facades\Session;

class UserMiddleware
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
            $USERID = Session::get('USERID');
            if ($ROLEID == 4) {
                return $next($request);
            } else {
                if ($ROLEID == 1 || $ROLEID == 2) {
                    $SAVELOGINREPORTS['USER_ID'] = $USERID;
                    $SAVELOGINREPORTS['ACTION_DATE'] = $TODAYDATE;
                    $SAVELOGINREPORTS['ACTION_TIME'] = $TODAYTIME;
                    $SAVELOGINREPORTS['STATUS'] = 'Logout';
                    insertRecords($SAVELOGINREPORTS, 'sup_login_aduit_reports');
                } else {
                    $SAVELOGINREPORTS['USER_ID'] = $USERID;
                    $SAVELOGINREPORTS['ACTION_DATE'] = $TODAYDATE;
                    $SAVELOGINREPORTS['ACTION_TIME'] = $TODAYTIME;
                    $SAVELOGINREPORTS['STATUS'] = 'Logout';
                    insertRecords($SAVELOGINREPORTS, 'mst_tbl_login_aduit_reports');
                }
                Session::flush();
                return redirect('/')->withErrors(['Invalid Route, Please try again']);
            }
        } else {
            return redirect('/')->withErrors(['Token Expires, Please try again']);
        }
    }
}
