<?php

namespace App\Http\Controllers;

use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
class CommonController extends Controller
{
    /**
     * This Will Create The New Insatnce.
     *
     * @return void
     */
    protected $getservices;

    /**
     * This Will Call The Service Implemented Methoad As Model Is Called
     *
     * @param  mixed $service The Methoad To be Called.
     * @return void
     */

    public function __construct()
    {
        $service = App::make('App\Services\Service');
        $this->getservices = $service;
    }
    /**
     * It Will Check Email Ready Exits Or Not
     *
     * @param  \Illuminate\Http\Request  $request It Is a Email Id That To be Cheked
     * @return \Illuminate\Http\Response It Will return true If Email is Valid.
     */
    public function getVaildEmailId(Request $request)
    {
        $ROLEID = Session::get('RoleId');
        $getSessionDatabseName = Session::get('DATABASENAME');
        $emailId = $request->emailId;
        if ($ROLEID == 1) {
            $databasename = $getSessionDatabseName;
            $this->getservices->Setthedatabase($databasename);
            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */
            $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                ->where(['EMAILID' => $emailId])->get();
            if (count($loginCredentailDetails) == 0) {
                // return 'TRUE';
                $sup_client = DB::table('sup_tbl_all_client')
                    ->where(['ADMINEMAILID' => $emailId])->get();
                if (count($sup_client) == 0) {
                    return 'TRUE';
                } else {
                    return 'FALSE';
                }
            } else {
                return 'FALSE';
            }

        } else {
            $this->getservices->Setthedatabase($getSessionDatabseName);
            return $getSessionDatabseName;
        }

    }

    /**
     * It Will Check Email Ready Exits Or Not and Also See Itsholud be not That Id Which Need To update
     *
     * @param  \Illuminate\Http\Request  $request It Is a Email Id That To be Cheked
     * @return \Illuminate\Http\Response It Will return true If Email is Valid.
     */
    public function getVaildEmailIdforEdit(Request $request)
    {

        $ROLEID = Session::get('RoleId');
        $getSessionDatabseName = Session::get('DATABASENAME');
        $emailId = $request->emailId;
        $id = $request->encryptid;
        $DECRYPTID = Crypt::decrypt($id);
        if ($ROLEID == 1) {
            $databasename = $getSessionDatabseName;
            $this->getservices->Setthedatabase($databasename);
            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */
            $GETCLIENTDETAILS = DB::table('sup_tbl_all_client')
                ->where(['CLIENT_ID' => $DECRYPTID])->first();
            $ADMINEMAILID = $GETCLIENTDETAILS->ADMINEMAILID;
            $sup_client = DB::table('sup_tbl_all_client')
                ->where(['ADMINEMAILID' => $emailId])->where('CLIENT_ID', '!=', $DECRYPTID)->get();
            if (count($sup_client) == 0) {
                $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $emailId])->get();
                if (count($loginCredentailDetails) == 0) {
                    return 'TRUE';
                } else {
                    $GETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                        ->where(['EMAILID' => $ADMINEMAILID])->first();
                    $USERID = $GETLOGINCREDENTIALDETAILS->USERID;
                    $checkdetailsofemailid = DB::table('sup_tbl_login_credential')
                        ->where(['EMAILID' => $emailId])->where('USERID', '!=', $USERID)->get();
                    if (count($checkdetailsofemailid) == 0) {
                        return 'TRUE';
                    } else {
                        return 'FALSE';
                    }
                }
            } else {
                return 'FALSE';
            }
        } else {
            $this->getservices->Setthedatabase($getSessionDatabseName);
            return $getSessionDatabseName;
        }

    }

    /**
     * Show the form and DataTabel of Modules.
     *
     * @return \Illuminate\Http\Response It will Return The View Page
     */
    public function showModulePatch()
    {
        $CATDETAilS = DB::table('mst_tbl_category')->where(['Flag' => 'Show'])->get();
        return view('Comman.showmodules', compact('CATDETAilS'));
    }

    /**
     * It Wiil Return mst_tbl_modules data if Role Id is 2 or 3 And Acction Buttorn Arcording To That and it will Return sup_tbl_module for Role Id 1
     *
     * @param  \Illuminate\Http\Request  $request It Will Have All Session Value
     * @return \Illuminate\Http\Response It will Return The Datatabel
     */
    public function getAllmodules(Request $request)
    {
        $RoleId = session('RoleId');
        if ($RoleId == '1') {
            $tabelname = 'sup_tbl_module';
        } else {
            $tabelname = 'mst_tbl_module';
        }
        $GETMODULEDETAILS = DB::table($tabelname)->where(['Flag' => 'Show'])->orderBy('MODULEID', 'desc')->get();
        return Datatables::of($GETMODULEDETAILS)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $ROLEID = session('RoleId');
                $MODULEID = $row->MODULEID;
                $ENCRYPT_MODULEID = Crypt::encrypt($MODULEID);
                // print_r($TYPEOFREQUEST);
                if ($ROLEID  == '1') {
                    $actionBtn = '<a href="javascript:void(0)" onclick="updateModule(' . "'$ENCRYPT_MODULEID'" . ', event)"><i class="feather icon-edit-2 mid_icon"></i></a> <a href="javascript:void(0)" onclick="deleteModuleid(' . "'$ENCRYPT_MODULEID'" . ',event)" ><i class="feather icon-trash mid_icon"></i></a>';
                } else {
                    $actionBtn = '<a href="javascript:void(0)" onclick="deleteModuleid(' . "'$ENCRYPT_MODULEID'" . ', event)"><i class="feather icon-edit-2 mid_icon"></i></a>';
                }
                return $actionBtn;
            })
            ->addColumn('catid', function ($row) {
                $CATEGORY_ID = $row->CATEGORY_ID;
                $CATDETAILS = DB::table('mst_tbl_category')->where(['FLAG' => 'Show', 'CATEGORY_ID' => $CATEGORY_ID])->get();
                if (count($CATDETAILS) > 0 ) {
                   $CATNAME =  $CATDETAILS[0]->CATEGORYNAME;
                } else {
                    $CATNAME = 'N.A';
                }
                return $CATNAME;
            })
            ->rawColumns(['action', 'catid'])
            ->make(true);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
