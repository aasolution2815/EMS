<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class MainsuperadminMiddleware
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
            if ($ROLEID == 1) {
                return $next($request);
            } else {
                $TODAYDATE = date('Y-m-d');
                $TODAYTIME = date(' H:i:s');
                if ($ROLEID == 2) {
                    $SUPUSERID = Session::get('USERID');
                    $SAVELOGINREPORTS['SUP_USER_ID'] = $SUPUSERID;
                    $SAVELOGINREPORTS['SUP_ACTION_DATE'] = $TODAYDATE;
                    $SAVELOGINREPORTS['SUP_ACTION_TIME'] = $TODAYTIME;
                    $SAVELOGINREPORTS['STATUS'] = 'Logout';
                    insertRecords($SAVELOGINREPORTS, 'sup_login_aduit_reports');
                    # code...
                } else {
                    $USERID = Session::get('USERID');
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

        // print_r(Session::has('RoleId'));

    }
}
