<?php

namespace App\Http\Controllers;

use App\Model\EmsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthenticationController extends Controller
{
    /**
     * Display a Login Screen
     *
     * @return \Illuminate\Http\Response It Returan Response As A View Page
     */
    public function LoginScreen()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * This is For The Authentication Of The User
     *
     * @param  \Illuminate\Http\Request  $request it Contatin Username ANd Password
     * @return \Illuminate\Http\Response It Will Return Wethere Username exit Or
     *  Not And CHeck For Valid Password
     */
    public function CheckLogin(Request $request)
    {
        $model = new EmsModel();
        $user_name = $request->username;
        $user_Password = $request->userPassword;
        $response = $model->Authtentication($user_name, $user_Password);
        return $response;
    }

    /**
     * This is For The Authentication Of The SuperAdmin User
     *
     * @param  \Illuminate\Http\Request  $request it Contatin UID ANd Email ID
     * @return \Illuminate\Http\Response It Will Return Wethere Valid User Or Not
     */
    public function CheckUID(Request $request)
    {
        $model = new EmsModel();
        $uid = $request->uid;
        $emailid = $request->emailid;
        if ($uid != '') {
            $response = $model->AuthtenticateSuperadmin($emailid, $uid);
        } else {
            $response = 'Required';
        }
        return $response;
    }

    /**
     * Logout It will Logout The Screen;
     *
     * @return stinrg It Will Return Wether System Logout Succesfuly Or Not
     */
    public function Logout()
    {
        $model = new EmsModel();
        $TODAYDATE = date('Y-m-d');
        $TODAYTIME = date(' H:i:s');
        $ROLEID = Session::get('RoleId');
        if ($ROLEID == 1) {
        } elseif ($ROLEID == 2) {
            $SUPUSERID = Session::get('USERID');
            $SAVELOGINREPORTS['SUP_USER_ID'] = $SUPUSERID;
            $SAVELOGINREPORTS['SUP_ACTION_DATE'] = $TODAYDATE;
            $SAVELOGINREPORTS['SUP_ACTION_TIME'] = $TODAYTIME;
            $SAVELOGINREPORTS['STATUS'] = 'Logout';
            insertRecords($SAVELOGINREPORTS, 'sup_login_aduit_reports');
        } else {
            $USERID = Session::get('USERID');
            $SAVELOGINREPORTS['USER_ID'] = $USERID;
            $SAVELOGINREPORTS['ACTION_DATE'] = $TODAYDATE;
            $SAVELOGINREPORTS['ACTION_TIME'] = $TODAYTIME;
            $SAVELOGINREPORTS['STATUS'] = 'Logout';
            insertRecords($SAVELOGINREPORTS, 'mst_tbl_login_aduit_reports');
            # code...
        }
        Session::flush();
        return Redirect::to("/")->with('success_message', 'You have successfully logged out');
        // ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
