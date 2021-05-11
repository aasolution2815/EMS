<?php

namespace App\Http\Controllers;

use App\Model\EmsModel;
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
        if ($ROLEID == 1 || $ROLEID == 2) {

            $databasename = $getSessionDatabseName;
            // Setthedatabase($databasename);
            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */
            $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                ->where(['EMAILID' => $emailId])->where(['FLAG' => 'Show'])->get();
            if (count($loginCredentailDetails) == 0) {
                // return 'TRUE';
                if ($ROLEID == 2) {
                    $sup_client = DB::table('sup_tbl_all_client')
                        ->where(['ADMINEMAILID' => $emailId])->where(['FLAG' => 'Show'])->get();
                } else {
                    $sup_client = DB::table('sup_tbl_superadmin_users')
                        ->where(['SUPEMAILID' => $emailId])->where(['FLAG' => 'Show'])->get();
                }
                // print_r($sup_client);
                if (count($sup_client) == 0) {
                    return 'TRUE';
                } else {
                    return 'FALSE';
                }
            } else {
                return 'FALSE';
            }

        } else {
            // Setthedatabase($getSessionDatabseName);
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
        if ($ROLEID == 1 || $ROLEID == 2) {
            $databasename = $getSessionDatabseName;
            // Setthedatabase($databasename);
            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */

            if ($ROLEID == 2) {
                $GETCLIENTDETAILS = DB::table('sup_tbl_all_client')
                    ->where(['CLIENT_ID' => $DECRYPTID])->first();
                $ADMINEMAILID = $GETCLIENTDETAILS->ADMINEMAILID;
                $sup_client = DB::table('sup_tbl_all_client')
                    ->where(['ADMINEMAILID' => $emailId])->where(['FLAG' => 'Show'])->where('CLIENT_ID', '!=', $DECRYPTID)->get();
            } else {
                $GETCLIENTDETAILS = DB::table('sup_tbl_superadmin_users')
                    ->where(['SUPUSERID' => $DECRYPTID])->first();
                $ADMINEMAILID = $GETCLIENTDETAILS->SUPEMAILID;
                $sup_client = DB::table('sup_tbl_superadmin_users')
                    ->where(['SUPEMAILID' => $emailId])->where(['FLAG' => 'Show'])->where('SUPUSERID', '!=', $DECRYPTID)->get();
                // print_r( $sup_client);
            }

            if (count($sup_client) == 0) {
                // $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                //     ->where(['EMAILID' => $emailId])->get();
                // if (count($loginCredentailDetails) == 0) {
                //     return 'TRUE';
                // } else {
                $GETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $ADMINEMAILID])->where(['FLAG' => 'Show'])->first();
                $USERID = $GETLOGINCREDENTIALDETAILS->USERID;
                $checkdetailsofemailid = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $emailId])->where(['FLAG' => 'Show'])->where('USERID', '!=', $USERID)->get();
                if (count($checkdetailsofemailid) == 0) {
                    return 'TRUE';
                } else {
                    return 'FALSE';
                }
                // }
            } else {
                return 'FALSE';
            }
        } else {
            // Setthedatabase($getSessionDatabseName);
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
        if ($RoleId == '1' || $RoleId == '2') {
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
                if ($ROLEID == '1' || $ROLEID == '2') {
                    $actionBtn = '<a href="javascript:void(0)" onclick="updateModule(' . "'$ENCRYPT_MODULEID'" . ', event)"><i class="feather icon-edit-2 mid_icon"></i></a> <a href="javascript:void(0)" onclick="deleteModuleid(' . "'$ENCRYPT_MODULEID'" . ',event)" ><i class="feather icon-trash mid_icon"></i></a>';
                } else {
                    $actionBtn = '<a href="javascript:void(0)" onclick="updateModule(' . "'$ENCRYPT_MODULEID'" . ', event)"><i class="feather icon-edit-2 mid_icon"></i></a>';
                }
                return $actionBtn;
            })
            ->addColumn('catid', function ($row) {
                $CATEGORY_ID = $row->CATEGORY_ID;
                $CATDETAILS = DB::table('mst_tbl_category')->where(['FLAG' => 'Show', 'CATEGORY_ID' => $CATEGORY_ID])->get();
                if (count($CATDETAILS) > 0) {
                    $CATNAME = $CATDETAILS[0]->CATEGORYNAME;
                } else {
                    $CATNAME = 'N.A';
                }
                return $CATNAME;
            })
            ->rawColumns(['action', 'catid'])
            ->make(true);

    }

    /**
     * dashboard This Will Return To The Dash Board According To Role Id
     *
     * @return view It Will Return View Of Dashboard Page
     */
    public function dashboard()
    {
        $ROLEID = Session::get('RoleId');
        // print_r($ROLEID);
        if ($ROLEID == 1 || $ROLEID == 2) {
            return view('SuperAdmin.superadmin-dashboard');
        } else {
            if ($ROLEID == 3) {
                return view('Admin.admin-dashboard');
            } elseif ($ROLEID == 4) {
                return view('User.user-dashboard');
            } else {
                return redirect('/')->withErrors(['Invalid User, Please try again']);
            }
        }

    }

    /**
     * documentconfigration It will show the Configration For The Documents
     *
     * @return view It will Return View Page for Document Configration.
     */
    public function documentconfigration()
    {
        return view('Comman.documnetconfigration');
    }

    /**
     * savedoconfigration It Will Check Wether Document Name is Given Or Not And Check If Child Doctument is Enable And Child Document Is Given Or Not.
     *
     * @param  mixed $request It Will have all records of Document Or Child Document Details.
     * @return string It will return The Messge Wether Document Is Creted Or Not
     */
    public function savedoconfigration(Request $request)
    {
        $emsmodel = new EmsModel();
        $docname = $request->parentdocname;
        $isparrentdoc = $request->isparrentdoc;
        $childdfilename = $request->childdfilename;
        $description = $request->description;
        $ressponse = '';
        if ($docname == '' || $isparrentdoc == '') {
            $ressponse = 'Mandatory';
        } else {
            $validdocumrent = false;
            if ($isparrentdoc == 'Yes') {
                if (count($childdfilename) > 0) {
                    $validdocumrent = true;
                }
            } else {
                $validdocumrent = true;
            }
            if ($validdocumrent) {
                $data['docname'] = $docname;
                $data['isparrentdoc'] = $isparrentdoc;
                $data['childdfilename'] = $childdfilename;
                $data['description'] = $description;
                $ressponse = $emsmodel->saveSingledocuments($data);
            } else {
                $ressponse = 'NoChild';
            }
        }
        return $ressponse;

    }

    public function getAllDocuments(Request $request)
    {
        $sql = "SELECT GROUP_CONCAT(DISTINCT c0.SUB_DOCUMENT_NAME) SUBDOC_NAME, d.* FROM mst_tbl_document_set d LEFT JOIN mst_tbl_child_doc_details c0 ON FIND_IN_SET(c0.CHILD_DOC_ID, d.CHILD_DOCUMENT_ID) WHERE d.FLAG = 'Show' AND (c0.FLAG = 'Show'|| c0.FLAG IS NULL) GROUP BY d.ID ORDER BY d.ID desc";
        $result = rawSqlQuery($sql);
        // print_r($result);
        $GETMODULEDETAILS = [];
        return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $ROLEID = session('RoleId');
                $DOCID = $row->ID;
                $ENCRYPT_DOCID = Crypt::encrypt($DOCID);
                $actionBtn = '<a href="javascript:void(0)" onclick="updatedocuments(' . "'$ENCRYPT_DOCID'" . ', event)"><i class="feather icon-edit-2 mid_icon"></i></a>';
                //  '<a href="javascript:void(0)" onclick="deleteModuleid(' . "'$ENCRYPT_DOCID'" . ',event)" ><i class="feather icon-trash mid_icon"></i></a>';
                return $actionBtn;
            })
            ->addColumn('ISPARENT_DOCUMENT', function ($row) {
                $rowid = $row->ID;
                $ISPARRENTDOCUMENTS = $row->ISPARENT_DOCUMENT;
                $checked = '';
                if ($ISPARRENTDOCUMENTS == 'Yes') {
                    $checked = 'checked';
                }
                $EncryROW = Crypt::encrypt($rowid);
                $INPUTBOX = '<label class="switch float_right" for="checkbox_' . $rowid . '" >
                <input type="checkbox" id="checkbox_' . $rowid . '" onchange="change_font_event(this,' . "'$EncryROW'" . ')" ' . $checked . ' />
                <div class="slider round"></div>
            </label>';
                // $CATEGORY_ID = $row->ISPARENT_DOCUMENT;
                return $INPUTBOX;
            })
            ->addColumn('childdocuments', function ($row) {
                $ISPARRENTDOCUMENTS = $row->ISPARENT_DOCUMENT;
                if ($ISPARRENTDOCUMENTS == 'Yes') {
                    $allFiles = explode(',', $row->SUBDOC_NAME);
                    if (count($allFiles) > 0) {
                        $div = '<div class="archive">';
                        $htmlfiles = '';
                        foreach ($allFiles as $key => $value) {
                            $htmlfiles = $htmlfiles . '<article class="article tags_ui" style="margin: 0px 5px;border: 1px dashed #000; padding: 7px 10px;border-left: 4px solid #000;
                            background: whitesmoke;><span style="word-break: break-all;">' . $value . '</span>
                            </article>';
                        }

                        $retunfiles = $div . $htmlfiles . '</div>';
                    } else {
                        $retunfiles = 'N.A';
                    }

                    # code...
                } else {
                    $retunfiles = 'N.A';
                }
                return $retunfiles;
            })
            ->rawColumns(['action', 'ISPARENT_DOCUMENT', 'childdocuments'])
            ->make(true);
    }

    public function checkdocuments(Request $request)
    {
        $ID = $request->id;
        $type = $request->type;
        $decryptid = Crypt::decrypt($ID);
        $response = '';
        $where1[] = ['ID', $decryptid];
        $DOCDETAILS = $this->getservices->selectfunction('mst_tbl_document_set', $where1);
        $ISPARENT_DOCUMENT = $DOCDETAILS[0]->ISPARENT_DOCUMENT;
        $CHILD_DOCUMENT_ID = $DOCDETAILS[0]->CHILD_DOCUMENT_ID;
        $CHILDDETAILS = [];
        if ($ISPARENT_DOCUMENT == 'Yes') {
            if ($CHILD_DOCUMENT_ID != '') {
                $CHILD_DOCUMENT_ID = explode(',', $CHILD_DOCUMENT_ID);
                $CHILDDETAILS = DB::table('mst_tbl_child_doc_details')->where(['FLAG' => 'Show'])->whereIn('CHILD_DOC_ID',  $CHILD_DOCUMENT_ID)->get();
            } else {
                $randomstring = '1,2';
                $CHILD_DOCUMENT_ID = explode(',', $randomstring);
                $CHILDDETAILS = DB::table('mst_tbl_child_doc_details')->where(['FLAG' => 'Show'])->whereIn('CHILD_DOC_ID',  $CHILD_DOCUMENT_ID)->get();
            }
        }
        if ($type == 'checkbox') {
            $option = 'showform';
            if ($ISPARENT_DOCUMENT == 'Yes') {
                if ($CHILD_DOCUMENT_ID != '') {
                    $option = 'update';
                    $UPDATED['ISPARENT_DOCUMENT'] = 'No';
                }
            } else {
                if ($CHILD_DOCUMENT_ID != '') {
                    $option = 'update';
                    $UPDATED['ISPARENT_DOCUMENT'] = 'Yes';
                }
            }
            if ($option == 'update') {
                updateRecords($UPDATED, 'mst_tbl_document_set', 'ID', $decryptid);
                $response = 'Updated';
            } else {
                return view('Comman.update-documentconf-popup', compact('type', 'DOCDETAILS', 'CHILDDETAILS', 'ID'));
                # code...
            }
        } else {
            return view('Comman.update-documentconf-popup', compact('type', 'DOCDETAILS', 'CHILDDETAILS', 'ID'));
        }
        return $response;

    }

    public function updateDocuments(Request $request)
    {

        $emsmodel = new EmsModel();
        $docname = $request->parentdocname;
        $isparrentdoc = $request->isparrentdoc;
        $childdfilename = $request->childdfilename;
        $description = $request->description;
        $updateid = $request->updateid;
        $documentID = Crypt::decrypt($updateid);
        $ressponse = '';
            $validdocumrent = false;
            if ($isparrentdoc == 'Yes') {
                if (count($childdfilename) > 0) {
                    $validdocumrent = true;
                }
            } else {
                $validdocumrent = true;
            }
            if ($validdocumrent) {
                $data['docname'] = $docname;
                $data['isparrentdoc'] = $isparrentdoc;
                $data['childdfilename'] = $childdfilename;
                $data['description'] = $description;
                $data['documentID'] = $documentID;
                $ressponse = $emsmodel->updateDocumntsList($data);
            } else {
                $ressponse = 'NoChild';
            }

        return $ressponse;
    }
}
