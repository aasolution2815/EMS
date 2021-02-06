<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Model\EmsModel;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class SuperAdminController extends Controller
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
     * Display a  View Page  Dashboard.
     *
     * @return \Illuminate\Http\Response It Will Return The View Page
     */
    public function showDashboard()
    {
        return view('SuperAdmin.superadmin-dashboard');
    }

    /**
     * Display a View Page For Client Creation.
     *
     * @return \Illuminate\Http\Response It Will Return The View Page
     */
    public function showClientCreation()
    {
        $getallDeualtImage = DB::table('mst_tbl_all_defualtimages')->where(['FLAG' => 'Show'])->get();
        if (count($getallDeualtImage) > 0) {
            $images = $getallDeualtImage[0]->COMPNAYLOGO;
        } else {
            $images = '';
        }
        return view('SuperAdmin.client-creation', compact('images'));
    }

    /**
     * This is For The Save The Client And Into Database
     *
     * @param  \Illuminate\Http\Request  $request it Contatin Client Details.
     * @return \Illuminate\Http\Response It Will Return Wethere Client Already  exit Or
     *  Not if Not Then Add it
     */
    public function saveClientCreation(Request $request)
    {
        $emsmodel = new EmsModel();
        $company_name = $request->company_name;
        $admin_name = $request->admin_name;
        $admin_emailid = $request->admin_emailid;
        $user_password = $request->user_password;
        $empcode_format = $request->empcode_format;
        $client_prefix = $request->client_prefix;
        $contatct_info = $request->contatct_info;
        $user_lmit = $request->user_lmit;
        $no_of_days = $request->no_of_days;
        $type = $request->type;
        $startdate = $request->startdate;
        $expiry_date = $request->expiry_date;
        $logo = $request->logo;
        $getSessionDatabseName = Session::get('DATABASENAME');
        $timestamp = date('Y-m-d H:i:s');
        $encryptStartDate = Crypt::encrypt($startdate);
        $encryptDate = Crypt::encrypt($expiry_date);
        $encrypt_password = Crypt::encrypt($user_password);
        $data['COMPANYNAME'] = $company_name;
        $data['ADMINNAME'] = $admin_name;
        $data['ADMINMOB_NO'] = $contatct_info;
        $data['ADMINEMAILID'] = $admin_emailid;
        $data['CLIENTPREFIX'] = $client_prefix;
        $data['PASSWORDS'] = $encrypt_password;
        $data['EMP_CODE'] = $empcode_format;
        $data['AUTHENTICATION_NUMBER'] = $no_of_days;
        $data['AUTHENTICATION_TYPE'] = $type;
        $data['AUTHENTICATION_START'] = $encryptStartDate;
        $data['AUTHENTICATION'] = $encryptDate;
        $data['USER_LIMITS'] = $user_lmit;
        $data['CREATED_AT'] = $timestamp;
        $data['DATABASENAME'] = $getSessionDatabseName;
        $data['COMPANYLOGO'] = $logo;
        $response = $emsmodel->saveClient($data);
        return $response;
    }

    /**
     * Display a View Page For All Client Created.
     *
     * @return \Illuminate\Http\Response It Will Return The View Page
     */
    public function showClientCreated()
    {
        return view('SuperAdmin.show-clients');
    }

    /**
     * Display a View Page For All Client Created.
     *
     * @return \Illuminate\Http\Response It Will Return The View Page
     */
    public function showClientToStop()
    {
        // $date = '2020-12-30';
        // $encryptdate = Crypt::encrypt($date);
        // print_r($encryptdate);
        return view('SuperAdmin.force-clients');
    }

    /**
     * getallClients This Function is For Geting cilent Data In Datatabel.
     *
     * @param  mixed $request It is Having Type of Request Which Request To be Excute.
     * @return Datatables  It Will Retrun The Datatabel.
     */
    public function getallClients(Request $request)
    {
        $TYPEOFREQUEST = $request->type;
        if ($TYPEOFREQUEST == 'all-client') {
            $data = DB::table('sup_tbl_all_client')->where(['FLAG' => 'Show'])->get();
        } else {
            $data = DB::table('sup_tbl_all_client')->where('FLAG', '!=', 'Delete')->get();
        }

        return Datatables::of($data, $TYPEOFREQUEST)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($TYPEOFREQUEST) {
                $CLIENT_ID = $row->CLIENT_ID;
                $ENCRYPT_CLIENT_ID = Crypt::encrypt($CLIENT_ID);
                // print_r($TYPEOFREQUEST);
                if ($TYPEOFREQUEST == 'all-client') {
                    $LINK = url('/SuperAdmin/edit-clients/' . $ENCRYPT_CLIENT_ID);
                    $actionBtn = '<a href=' . "$LINK" . '><i class="feather icon-edit-2 mid_icon"></i></a> <a href="javascript:void(0)" onclick="deleteClient(' . "'$ENCRYPT_CLIENT_ID'" . ',event)" ><i class="feather icon-trash mid_icon"></i></a>';
                } else {
                    $FLAG = $row->FLAG;
                    if ($FLAG == 'Show') {
                        $icondetails = 'fa fa-pause';
                        $Actiontobedone = 'Stop';
                    } else {
                        $icondetails = 'fa fa-play';
                        $Actiontobedone = 'Show';
                    }

                    $actionBtn = '<a href="javascript:void(0)" onclick="stoporservices(' . "'$ENCRYPT_CLIENT_ID'" . ',' . "'$Actiontobedone'" . ',event)" ><i class="' . $icondetails . '"></i></a>';
                }
                return $actionBtn;
            })
            ->addColumn('companylogo', function ($row) {
                $src = $row->COMPNAYLOGO;
                $companylogo = '<img src="' . $src . '" alt="Avatar" class="avatar">';
                return $companylogo;
            })
            ->addColumn('expirydate', function ($row) {
                $src = $row->AUTHENTICATION_END;
                $decryptdate = Crypt::decrypt($src);
                $formateDate = date('d/m/Y ', strtotime($decryptdate));
                $getdate = $formateDate;
                return $getdate;
            })
            ->addColumn('noofdayspending', function ($row) {
                $todaydate = date('Y-m-d ');
                $src = $row->AUTHENTICATION_END;
                $decryptdate = Crypt::decrypt($src);
                $formateDate = date('Y-m-d ', strtotime($decryptdate));
                $date1 = date_create($todaydate);
                $date2 = date_create($formateDate);
                $diff = date_diff($date1, $date2);
                $getdiffrence = $diff->format("%R%a");
                if ($getdiffrence > 0) {
                    $days = $getdiffrence;
                } else {
                    $days = 0;
                }
                return $days;
            })
            ->addColumn('mode', function ($row) {
                $todaydate = date('Y-m-d ');
                $src = $row->AUTHENTICATION_END;
                $decryptdate = Crypt::decrypt($src);
                $formateDate = date('Y-m-d ', strtotime($decryptdate));
                $date1 = date_create($todaydate);
                $date2 = date_create($formateDate);
                $diff = date_diff($date1, $date2);
                $getdiffrence = $diff->format("%R%a");

                if ($getdiffrence > 0) {
                    $days = $getdiffrence;
                } else {
                    $days = 0;
                }
                $getnoofdays = abs($getdiffrence);
                if ($days == 0) {
                    $modes = 'Expired';
                } elseif ($days >= 1 && $days <= 30) {
                    $modes = 'Soon';
                } else {
                    $modes = 'Latter';
                }
                return $modes;
            })

            ->rawColumns(['action', 'companylogo', 'expirydate', 'noofdayspending', 'mode'])
            ->make(true);

    }

    /**
     * Display the Edit Form Of Client Creation.
     *
     * @param  int  $id It is a Encrypt Id of Client Creation.
     * @return \Illuminate\Http\Response It will Return The View Page For Edit Page Of Client Creation.
     */
    public function showEditClientCreationForm($id)
    {
        $DECRYPT_CLIENTID = Crypt::decrypt($id);
        $GETDETAILS = DB::table('sup_tbl_all_client')->where(['CLIENT_ID' => $DECRYPT_CLIENTID])->first();
        $AUTHENTICATION_START = $GETDETAILS->AUTHENTICATION_START;
        $AUTHENTICATION_END = $GETDETAILS->AUTHENTICATION_END;
        $ADMINEMAILID = $GETDETAILS->ADMINEMAILID;
        $CLIENTPREFIX = $GETDETAILS->CLIENTPREFIX;
        $CLIENTDATABASENAME = $CLIENTPREFIX . '_management';
        $this->getservices->Setthedatabase($CLIENTDATABASENAME);
        $GETUSERDETAILS = DB::table('mst_tbl_users')->where(['EMAILID' => $ADMINEMAILID])->first();
        $getSessionDatabseName = Session::get('DATABASENAME');
        $this->getservices->Setthedatabase($getSessionDatabseName);
        $PASSWORDS = $GETUSERDETAILS->PASSWORDS;
        $DECRYPT_PASSWORDS = Crypt::decrypt($PASSWORDS);
        $DECRYPT_AUTHENTICATION_START = Crypt::decrypt($AUTHENTICATION_START);
        $DECRYPT_AUTHENTICATION_END = Crypt::decrypt($AUTHENTICATION_END);
        $GETDETAILS->AUTHENTICATION_START = $DECRYPT_AUTHENTICATION_START;
        $GETDETAILS->AUTHENTICATION_END = $DECRYPT_AUTHENTICATION_END;
        $GETDETAILS->PASSWORDS = $DECRYPT_PASSWORDS;
        $todaysData = date('Y-m-d');
        $SERVICETIME = $this->getservices->checkpastDate($DECRYPT_AUTHENTICATION_START, $todaysData);
        return view('SuperAdmin.edit-client-creation', compact('SERVICETIME', 'GETDETAILS', 'id'));
    }

    /**
     * This is For The Update The Client Details.
     *
     * @param  \Illuminate\Http\Request  $request it Contatin Client Details.
     * @return \Illuminate\Http\Response It will Return The Message That Client Updated Or Not
     */
    public function updateClientCreation(Request $request)
    {
        // print_r('sfdbfhdf');exit;
        $emsmodel = new EmsModel();
        $company_name = $request->company_name;
        $admin_name = $request->admin_name;
        $admin_emailid = $request->admin_emailid;
        $user_password = $request->user_password;
        $empcode_format = $request->empcode_format;
        $clientid = $request->clientid;
        $contatct_info = $request->contatct_info;
        $user_lmit = $request->user_lmit;
        $no_of_days = $request->no_of_days;
        $type = $request->type;
        $startdate = $request->startdate;
        $expiry_date = $request->expiry_date;
        $logo = $request->logo;
        $getSessionDatabseName = Session::get('DATABASENAME');
        $timestamp = date('Y-m-d H:i:s');
        $encryptStartDate = Crypt::encrypt($startdate);
        $encryptDate = Crypt::encrypt($expiry_date);
        $encrypt_password = Crypt::encrypt($user_password);
        $decrypt_clientid = Crypt::decrypt($clientid);
        $data['COMPANYNAME'] = $company_name;
        $data['ADMINNAME'] = $admin_name;
        $data['ADMINMOB_NO'] = $contatct_info;
        $data['ADMINEMAILID'] = $admin_emailid;
        $data['CLIENT_ID'] = $decrypt_clientid;
        $data['PASSWORDS'] = $encrypt_password;
        $data['EMP_CODE'] = $empcode_format;
        $data['AUTHENTICATION_NUMBER'] = $no_of_days;
        $data['AUTHENTICATION_TYPE'] = $type;
        $data['AUTHENTICATION_START'] = $encryptStartDate;
        $data['AUTHENTICATION'] = $encryptDate;
        $data['USER_LIMITS'] = $user_lmit;
        $data['UPDATED_AT'] = $timestamp;
        $data['DATABASENAME'] = $getSessionDatabseName;
        $data['COMPANYLOGO'] = $logo;
        $response = $emsmodel->UpdateClient($data);
        return $response;
    }

    /**
     * This Will Stop The Servivces of The Client
     *
     * @param  \Illuminate\Http\Request  $request It is The Client Id and The Status To be Change
     * @return \Illuminate\Http\Response
     */
    public function stopServices(Request $request)
    {
        $deleteModel = new EmsModel();
        $ClientID = Crypt::decrypt($request->clientid);
        $Actiondetails = $request->Actiondetails;
        $data['CLIENT_ID'] = $ClientID;
        $data['FLAG'] = $Actiondetails;
        $response = $deleteModel->StopServices($data);
        return $response;

    }

    /**
     * Display a View Page For Update Licenes
     *
     * @return \Illuminate\Http\Response It Will Return The View Page
     */
    public function showUpdateLicences()
    {
        $data = DB::table('sup_tbl_all_client')->where(['FLAG' => 'Show'])->get();
        return view('SuperAdmin.update-clients-license', compact('data'));
    }

    /**
     * getClientDetails It will Give The Client Details
     *
     * @param  mixed $request It Will Contain The Client Id
     * @return json It will Return The Json of the Client Id
     */
    public function getClientDetails(Request $request)
    {
        $clientids = $request->clientids;
        $Details = DB::table('sup_tbl_all_client')->where(['CLIENT_ID' => $clientids])->first();
        $DecryptStartSatrtDate = Crypt::decrypt($Details->AUTHENTICATION_START);
        $Details->AUTHENTICATION_START = $DecryptStartSatrtDate;
        $DecryptStartEndDate = Crypt::decrypt($Details->AUTHENTICATION_END);
        $Details->AUTHENTICATION_END = $DecryptStartEndDate;
        return response()->json($Details);
    }

    /**
     * updateLicences It will Give String Clinet Updated Or not
     *
     * @param  mixed $request Data pass By The Users
     * @return string It will Return The message That Licinces Updated Ot=r Not
     */
    public function updateLicences(Request $request)
    {
        $updatedetails = new EmsModel();
        $encryptstartDate = Crypt::encrypt($request->startdate);
        $encryptEndDate = Crypt::encrypt($request->expiry_date);
        $data['clientids'] = $request->clientids;
        $data['user_lmit'] = $request->user_lmit;
        $data['type'] = $request->type;
        $data['no_of_days'] = $request->no_of_days;
        $data['startdate'] = $encryptstartDate;
        $data['expiry_date'] = $encryptEndDate;
        $response = $updatedetails->updateLicens($data);
        return $response;

    }

    /**
     * deleteClient THis Is To Delete The Client.
     *
     * @param  mixed $request It Is Having Client Is
     * @return string It WIll return That Wether Client Deletd Or Not.
     */
    public function deleteClient(Request $request)
    {
        $CLIENTID = $request->clientid;
        $deleteclients = new EmsModel();
        $response = $deleteclients->DeleteTheClient($CLIENTID);
        return $response;
    }

    /**
     * savemodulesData It will Check The Url Is Already Present Or No if Not Then Add The Module
     *
     * @param  mixed $request Module Data
     * @return string It Will Return Wether Module Aaded, ALredy Exits, Or Error.
     */
    public function savemodulesData(Request $request)
    {
        $saveModules = new EmsModel();
        $moduleid = $request->moduleid;
        $module_url = $request->module_url;
        $module_cat = $request->module_cat;
        $module_description = $request->module_description;
        $ValidateURL = DB::table('sup_tbl_module')->where(['Flag' => 'Show'])->where(['MODULELINK' => $module_url])->get();
        if (count($ValidateURL) > 0) {
            $response = 'Already';
        } else {
            $data['MODULENAME'] = $moduleid;
            $data['MODULELINK'] = $module_url;
            $data['CATEGORY_ID'] = $module_cat;
            $data['MODULEDESCRIPTION'] = $module_description;
            $saverecord = $saveModules->insertRecords($data, 'sup_tbl_module');
            if ($saverecord > 0) {
                $response = 'DONE';
            } else {
                $response = $saverecord;
            }

        }
        return $response;

    }

    /**
     * deleteModules This Will Delete Records of Modules
     *
     * @param  mixed $request Module Id
     * @return string IT wiill return the Module Id
     */
    public function deleteModules(Request $request)
    {
        $deleteModules = new EmsModel();
        $moduleId = $request->moduleId;
        $DECRYPT_MODULEId = Crypt::decrypt($moduleId);
        $DELETEMODULE['Flag'] = 'Deleted';
        $DELETRECORDS = $deleteModules->updateRecords($DELETEMODULE, 'sup_tbl_module', 'MODULEID', $DECRYPT_MODULEId);
        if ($DELETRECORDS == 'Done') {
            $response = 'DONE';
        } else {;
            $response = $DELETRECORDS;
        }
        return $response;

    }

    public function showallClients()
    {
        return view('SuperAdmin.show-all-clients');
    }

    /**
     * getallClients This Function is For Geting cilent Data In Datatabel.
     *
     * @param  mixed $request It is Having Type of Request Which Request To be Excute.
     * @return Datatables  It Will Retrun The Datatabel.
     */
    public function allClients(Request $request)
    {
        $data = DB::table('sup_tbl_all_client')->where('FLAG', '!=', 'Delete')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $CLIENT_ID = $row->CLIENT_ID;
                $ENCRYPT_CLIENT_ID = Crypt::encrypt($CLIENT_ID);
                $LINK = url('/SuperAdmin/asgin-modules/' . $ENCRYPT_CLIENT_ID);
                $actionBtn = '<a href=' . "$LINK" . '>Assgin</a>';
                return $actionBtn;
            })
            ->addColumn('companylogo', function ($row) {
                $src = $row->COMPNAYLOGO;
                $companylogo = '<img src="' . $src . '" alt="Avatar" class="avatar">';
                return $companylogo;
            })
            ->addColumn('expirydate', function ($row) {
                $src = $row->AUTHENTICATION_END;
                $decryptdate = Crypt::decrypt($src);
                $formateDate = date('d/m/Y ', strtotime($decryptdate));
                $getdate = $formateDate;
                return $getdate;
            })
            ->addColumn('noofdayspending', function ($row) {
                $todaydate = date('Y-m-d ');
                $src = $row->AUTHENTICATION_END;
                $decryptdate = Crypt::decrypt($src);
                $formateDate = date('Y-m-d ', strtotime($decryptdate));
                $date1 = date_create($todaydate);
                $date2 = date_create($formateDate);
                $diff = date_diff($date1, $date2);
                $getdiffrence = $diff->format("%R%a");
                if ($getdiffrence > 0) {
                    $days = $getdiffrence;
                } else {
                    $days = 0;
                }
                return $days;
            })
            ->addColumn('mode', function ($row) {
                $todaydate = date('Y-m-d ');
                $src = $row->AUTHENTICATION_END;
                $decryptdate = Crypt::decrypt($src);
                $formateDate = date('Y-m-d ', strtotime($decryptdate));
                $date1 = date_create($todaydate);
                $date2 = date_create($formateDate);
                $diff = date_diff($date1, $date2);
                $getdiffrence = $diff->format("%R%a");

                if ($getdiffrence > 0) {
                    $days = $getdiffrence;
                } else {
                    $days = 0;
                }
                $getnoofdays = abs($getdiffrence);
                if ($days == 0) {
                    $modes = 'Expired';
                } elseif ($days >= 1 && $days <= 30) {
                    $modes = 'Soon';
                } else {
                    $modes = 'Latter';
                }
                return $modes;
            })

            ->rawColumns(['action', 'companylogo', 'expirydate', 'noofdayspending', 'mode'])
            ->make(true);

    }

    /**
     * Display the Module Form Of Client Creation.
     *
     * @param  int  $id It is a Encrypt Id of Client Creation.
     * @return \Illuminate\Http\Response It will Return The View Page For Assging Module.
     */
    public function showModulesPage($id)
    {
        $DECRYPT_CLIENTID = Crypt::decrypt($id);
        $GETDETAILS = DB::table('sup_tbl_all_client')->where(['CLIENT_ID' => $DECRYPT_CLIENTID])->first();
        $CATEGORYDETAILS = DB::table('mst_tbl_category')->where(['FLAG' => 'Show'])->get();
        $MODULESDETAILS = DB::table('sup_tbl_module')->where(['FLAG' => 'Show'])->get();
        // echo "<pre>";
        $DETAILS = [];
        $ALREADYASSGINEDMODULES = [];
        for ($i = 0; $i < count($CATEGORYDETAILS); $i++) {
            $modules = [];
            $CATID = $CATEGORYDETAILS[$i]->CATEGORY_ID;
            $GETMODULES = DB::table('sup_tbl_module')->where(['Flag' => 'Show', 'CATEGORY_ID' => $CATID])->get();
            for ($j = 0; $j < count($GETMODULES); $j++) {
                $modules[] = $GETMODULES[$j];
            }
            $DETAILS[$CATID] = $modules;
            # code...
        }
        $ASSIGNEDMODULE = $GETDETAILS->ASSIGNEDMODULE;

        if ($ASSIGNEDMODULE == '' || $ASSIGNEDMODULE == null) {
            $ALREADYASSGINEDMODULES = [];
        } else {
            $EXPLOADEDATA = explode(',', $ASSIGNEDMODULE);
            if (count($EXPLOADEDATA) > 0) {
                $ASSGINEDDETAILS = DB::table('sup_tbl_assigned_module')->whereIn('ASSGINMODULEID', $EXPLOADEDATA)->get();
                if (count($ASSGINEDDETAILS) > 0) {
                    for ($as = 0; $as < count($ASSGINEDDETAILS); $as++) {
                        $RIGHTSAARY = [];
                        $RIGHTSAARY['IMPORT'] = $ASSGINEDDETAILS[$as]->IMPORT;
                        $RIGHTSAARY['WRITE'] = $ASSGINEDDETAILS[$as]->WRITE;
                        $RIGHTSAARY['DELETE'] = $ASSGINEDDETAILS[$as]->DELETE;
                        $RIGHTSAARY['ADD'] = $ASSGINEDDETAILS[$as]->ADD;
                        $RIGHTSAARY['EXPORT'] = $ASSGINEDDETAILS[$as]->EXPORT;
                        $RIGHTSAARY['VIEW'] = $ASSGINEDDETAILS[$as]->VIEW;
                        $RIGHTSAARY['UPDATEIMPORT'] = $ASSGINEDDETAILS[$as]->UPDATEIMPORT;
                        $ALREADYASSGINEDMODULES[$ASSGINEDDETAILS[$as]->MODULE_ID] = $RIGHTSAARY;

                    }
                } else {
                    $ALREADYASSGINEDMODULES = [];
                }
            } else {
                $ALREADYASSGINEDMODULES = [];
            }

        }
        return view('SuperAdmin.module_assign', compact('GETDETAILS', 'id', 'CATEGORYDETAILS', 'DETAILS', 'ALREADYASSGINEDMODULES'));
        // print_r($DETAILS);

    }

    /**
     * assginClients It WIl Assign Modules To Clients.
     *
     * @param  mixed $request It will Have Module Selected Arry , Category Selceted Aary , And Data To Store the Module Aary.
     * @return string It will Return Wether Module Assgined Or Not To The CLient.
     */
    public function assginClients(Request $request)
    {
        try {
            $message = 'Empty';
            $ASSGINMODEL = new EmsModel();
            /** For Catgory */
            if (isset($request->GETCATIEGORIS)) {
                $CATDATA = $request->GETCATIEGORIS;
            } else {
                $CATDATA = [];
            }

            /** For Module Data */
            if (isset($request->GETMODULES)) {
                $MODDATA = $request->GETMODULES;
            } else {
                $MODDATA = [];
            }

            /** This Data  */
            if (isset($request->obj)) {
                $obj = $request->obj;
                $decodeJsonAarray = json_decode($obj, true);
            } else {
                $decodeJsonAarray = [];
            }

            /** Decrypt Client id */
            $ECRYPTCLIENTID = $request->CLIENTID;
            $MODULESAARY = $MODDATA;
            $GETCATIEGORIS = $CATDATA;
            $CLIENTID = Crypt::decrypt($ECRYPTCLIENTID);
            $USERDATABASENAME = Session::get('DATABASENAME');
            /** Change The Database Now As It Has To Be Save In The CLient Database. */
            $CLIENTDETAILS = DB::table('sup_tbl_all_client')->where(['CLIENT_ID' => $CLIENTID])->first();
            $PERFIX = $CLIENTDETAILS->CLIENTPREFIX;
            $DATABSENAME = $PERFIX . '_management';
            if (count($GETCATIEGORIS) > 0) {
                $ASSIGNEDARRY = [];
                $ALLASSIGNEDMODUELEARRY = [];
                $ASIGNMODULEDATAARRY = [];
                $MODULEDATAARRY = [];
                for ($i = 0; $i < count($GETCATIEGORIS); $i++) {
                    $CATID = $GETCATIEGORIS[$i];
                    $GETMODULEARRY = $MODULESAARY[$i];
                    for ($k = 0; $k < count($GETMODULEARRY); $k++) {
                        $ASIGNMODULEDATA = [];
                        $MODULEDATA = [];
                        $MODID = $GETMODULEARRY[$k];

                        /** Assgin Module Aary Which Belong To Super Admin to See Which Module Is Given To Whoom */
                        $ASIGNMODULEDATA['CLIENTID'] = $CLIENTID;
                        $ASIGNMODULEDATA['MODULE_ID'] = $MODID;
                        $ASIGNMODULEDATA['IMPORT'] = $decodeJsonAarray[$CATID][$MODID]['Import'];
                        $ASIGNMODULEDATA['WRITE'] = $decodeJsonAarray[$CATID][$MODID]['Write'];
                        $ASIGNMODULEDATA['DELETE'] = $decodeJsonAarray[$CATID][$MODID]['Delete'];
                        $ASIGNMODULEDATA['ADD'] = $decodeJsonAarray[$CATID][$MODID]['Add'];
                        $ASIGNMODULEDATA['EXPORT'] = $decodeJsonAarray[$CATID][$MODID]['Export'];
                        $ASIGNMODULEDATA['VIEW'] = $decodeJsonAarray[$CATID][$MODID]['View'];
                        $ASIGNMODULEDATA['UPDATEIMPORT'] = $decodeJsonAarray[$CATID][$MODID]['UpdateImport'];
                        $ASIGNMODULEDATA['Flag'] = 'Show';
                        $ASIGNMODULEDATAARRY[] = $ASIGNMODULEDATA;


                        $MODULESDETAILS = DB::table('sup_tbl_module')->where(['FLAG' => 'Show', 'MODULEID' => $MODID])->get();
                        if (count($MODULESDETAILS) > 0) {
                            $MODULENAME = $MODULESDETAILS[0]->MODULENAME;
                            $MODULELINK = $MODULESDETAILS[0]->MODULELINK;
                            $MODULEDESCRIPTION = $MODULESDETAILS[0]->MODULEDESCRIPTION;
                            $CATEGORY_ID = $MODULESDETAILS[0]->CATEGORY_ID;

                            /** Asgin Module To CLient Which Has Been Given To Client  */
                            $MODULEDATA['MODULENAME'] = $MODULENAME;
                            $MODULEDATA['MODULELINK'] = $MODULELINK;
                            $MODULEDATA['MODULEDESCRIPTION'] = $MODULEDESCRIPTION;
                            $MODULEDATA['CATEGORY_ID'] = $CATEGORY_ID;
                            $MODULEDATA['CLIENT_MODULE_ID'] = $MODID;
                            $MODULEDATA['IMPORT'] = $decodeJsonAarray[$CATID][$MODID]['Import'];
                            $MODULEDATA['WRITE'] = $decodeJsonAarray[$CATID][$MODID]['Write'];
                            $MODULEDATA['DELETE'] = $decodeJsonAarray[$CATID][$MODID]['Delete'];
                            $MODULEDATA['ADD'] = $decodeJsonAarray[$CATID][$MODID]['Add'];
                            $MODULEDATA['EXPORT'] = $decodeJsonAarray[$CATID][$MODID]['Export'];
                            $MODULEDATA['VIEW'] = $decodeJsonAarray[$CATID][$MODID]['View'];
                            $MODULEDATA['UPDATEIMPORT'] = $decodeJsonAarray[$CATID][$MODID]['UpdateImport'];
                            $MODULEDATA['Flag'] = 'Show';
                            $MODULEDATAARRY[] = $MODULEDATA;
                        }

                    }
                }
                $ALREADYASSGINEDMODULES = $CLIENTDETAILS->ASSIGNEDMODULE;
                /** Check If Module is Already Assinged Or Not If Yes Then Update The Module And If Not Create Module */
                if ($ALREADYASSGINEDMODULES != '' || $ALREADYASSGINEDMODULES != null) {
                    /** Update Records */
                    $EXPLOADEDATA = explode(',', $ALREADYASSGINEDMODULES);
                    if (count($ASIGNMODULEDATAARRY) > 0) {
                        for ($as = 0; $as < count($ASIGNMODULEDATAARRY); $as++) {
                            $GETMODID = $ASIGNMODULEDATAARRY[$as]['MODULE_ID'];
                            $ASSGINEDDETAILS = DB::table('sup_tbl_assigned_module')->where(['CLIENTID' => $CLIENTID, 'MODULE_ID' => $GETMODID])->get();
                            /** If Module Id Is Present In The Record Then Update Else Insert in  sup_tbl_assigned_module*/
                            if (count($ASSGINEDDETAILS) > 0) {
                                /** Update sup_tbl_assigned_module Data of Module Id */
                                $ASSIGNEDID = $ASSGINEDDETAILS[0]->ASSGINMODULEID;
                                $ASSGINMODEL->updateRecords($ASIGNMODULEDATAARRY[$as], 'sup_tbl_assigned_module', 'ASSGINMODULEID', $ASSIGNEDID);
                                $UPDATEDASSINEDID = $ASSIGNEDID;
                            } else {
                                /** Insert New Records In  sup_tbl_assigned_module*/
                                $UPDATEDASSINEDID = $ASSGINMODEL->insertRecords($ASIGNMODULEDATAARRY[$as], 'sup_tbl_assigned_module');
                            }
                            $ASSIGNEDARRY[] = $UPDATEDASSINEDID; // Save All Id In One AARAY And Update The ASSIGNEDMODULE in sup_tbl_all_client
                        }
                        if (count($ASSIGNEDARRY) > 0) {
                            $IMPLODEDATA = implode(',', $ASSIGNEDARRY);

                            /** Assgin All  Assgined Module Id To Client  */
                            $CLIDETUPDATEDATA['ASSIGNEDMODULE'] = $IMPLODEDATA;
                            $ASSGINMODEL->updateRecords($CLIDETUPDATEDATA, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENTID);
                            $FLAGDAT['Flag'] = 'Delete';
                            $ASSGINMODEL->multiUpdateRecords($FLAGDAT, 'sup_tbl_assigned_module', 'ASSGINMODULEID', $ASSIGNEDARRY, 'whereNotIn');
                            if (count($MODULEDATAARRY) > 0) {

                                $this->getservices->Setthedatabase($DATABSENAME);

                                for ($mo = 0; $mo < count($MODULEDATAARRY); $mo++) {
                                    $GETCLIENTMODID = $MODULEDATAARRY[$mo]['CLIENT_MODULE_ID'];
                                    $ASSGINEDMODULEDETAILS = DB::table('mst_tbl_module')->where(['CLIENT_MODULE_ID' => $GETCLIENTMODID])->get();
                                    /** Check Module Id Already Exits in  mst_tbl_module  if Present then Update Else Insert */
                                    if (count($ASSGINEDMODULEDETAILS) > 0) {
                                        /** Update mst_tbl_module  */
                                        $CLIENT_MODULE_ID = $ASSGINEDMODULEDETAILS[0]->CLIENT_MODULE_ID;
                                        $ASSGINMODEL->updateRecords($MODULEDATAARRY[$mo], 'mst_tbl_module', 'CLIENT_MODULE_ID', $CLIENT_MODULE_ID);
                                        $UPDATEDASSINEDMODULEID = $CLIENT_MODULE_ID;
                                    } else {
                                         /** Insert mst_tbl_module  */
                                        $UPDATEDASSINEDMODULEID =$ASSGINMODEL->insertRecords($MODULEDATAARRY[$mo], 'mst_tbl_module');
                                    }
                                    $ALLASSIGNEDMODUELEARRY[] = $UPDATEDASSINEDMODULEID; // Save All Id In One AARAY
                                }
                                $DATADONE['Flag'] = 'Delete';
                                $ASSGINMODEL->multiUpdateRecords($DATADONE, 'mst_tbl_module', 'CLIENT_MODULE_ID', $ALLASSIGNEDMODUELEARRY, 'whereNotIn');
                                $message = 'Update';
                            } else {
                                $message = 'Empty';
                            }
                        }
                    } else {
                        $message = 'Empty';
                    }

                } else {
                    /** New Record */
                    /** Save The Records into sup_tbl_assigned_module  For Client */
                    if (count($ASIGNMODULEDATAARRY) > 0) {
                        for ($cl = 0; $cl < count($ASIGNMODULEDATAARRY); $cl++) {
                            $ASSIGNEDARRY[] = $ASSGINMODEL->insertRecords($ASIGNMODULEDATAARRY[$cl], 'sup_tbl_assigned_module');
                        }
                        if (count($ASSIGNEDARRY) > 0) {
                            $IMPLODEDATA = implode(',', $ASSIGNEDARRY);
                            /** Assgin All  Assgined Module Id To Client  */
                            $CLIDETUPDATEDATA['ASSIGNEDMODULE'] = $IMPLODEDATA;
                            $ASSGINMODEL->updateRecords($CLIDETUPDATEDATA, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENTID);
                            if (count($MODULEDATAARRY) > 0) {
                                $this->getservices->Setthedatabase($DATABSENAME);
                                for ($mo = 0; $mo < count($MODULEDATAARRY); $mo++) {
                                    $ASSGINMODEL->insertRecords($MODULEDATAARRY[$mo], 'mst_tbl_module');
                                }
                                $message = 'Done';
                            } else {
                                $message = 'Empty';
                            }
                        }
                    } else {
                        $message = 'Empty';
                    }
                }

                // print_r($ASIGNMODULEDATAARRY);

            } else {
                $message = 'Empty';
            }
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }
        return $message;

    }

}
