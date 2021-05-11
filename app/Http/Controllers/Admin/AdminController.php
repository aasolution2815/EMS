<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
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
        return view('Admin.admin-dashboard');
    }

    /**
     * hrisindex It will Display The Form Craetion Page.
     *
     * @param  mixed $request
     * @return view It will Return The View Page.
     */
    public function hrisindex(Request $request)
    {
        return view('Admin.hrisindex');
    }

    /**
     * hrisformlist It will Give You The List Of The Form Created.
     *
     * @param  mixed $request It will Have Token
     * @return Datatabels It will Return All Data in datatabel Format
     */
    public function hrisformlist(Request $request)
    {
        $where[] = ['FLAG', 'Show'];
        $formdata = $this->getservices->selectfunction('mst_tbl_form_hris', $where);
        return Datatables::of($formdata)
            ->addIndexColumn()
            ->addColumn('form_name', function ($query) {
                $formid = Crypt::encrypt($query->FORMID);
                $LINK = url('/hrisshowfield/' . $formid);
                return '<a   href=' . "$LINK" . ' >' . $query->FORM_NAME . '</a>';
            })
            ->addColumn('view_form', function ($query) {
                $formid = Crypt::encrypt($query->FORMID);
                // return '<a   href="' . action('Admin\AdminController@hrisfieldsdisplay', [$formid]) . '" >View</a>';
                return '<a   href="#" >View</a>';
            })
            ->addColumn('action', function ($query) {
                $ENCRYPT_FORM_ID = Crypt::encrypt($query->FORMID);
                $FORM_NAME = $query->FORM_NAME;
                $LINK = url('/SuperAdmin/edit-clients/' . $ENCRYPT_FORM_ID);
                $actionBtn = '<a href="javascript:void(0)" onclick="onedit(' . "'$ENCRYPT_FORM_ID'" . ',event,' . "'$FORM_NAME'" . ')"><i class="feather icon-edit-2 mid_icon"></i></a>';
                // <a href="javascript:void(0)" onclick="deleteClient(' . "'$ENCRYPT_FORM_ID'" . ',event)" ><i class="feather icon-trash mid_icon"></i></a>
                return $actionBtn;
            })
            ->rawColumns(['form_name', 'view_form', 'action'])
            ->make(true);
    }

    /**
     * formsubmit It  Will Submit The Form Into Database
     *
     * @param  mixed $request It Will Have FOrm Details
     * @return string It will return The Form is Created or Not.
     */
    public function formsubmit(Request $request)
    {
        $form_name = $request->formname;
        $USERID = Session::get('USERID');
        $message = '';
        if ($form_name != '') {
            $where[] = ['FLAG', 'Show'];
            $where[] = ['FORM_NAME', $form_name];
            $formdata = $this->getservices->selectfunction('mst_tbl_form_hris', $where);
            if (count($formdata) == 0) {
                $alldata['FORM_NAME'] = $form_name;
                $alldata['DATE'] = date("Y-m-d");
                $alldata['TIME'] = date("H:i:s");
                $alldata['CREATED_BY'] = $USERID;
                try {
                    insertRecords($alldata, 'mst_tbl_form_hris');
                    $message = 'DONE';
                } catch (\Exception $th) {
                    $message = 'Error';
                }
            } else {
                $message = 'Already';
            }
        } else {
            $message = 'Required';
        }
        return $message;
    }

    /**
     * formupdate It Will Update The Form To Database.
     *
     * @param  mixed $request It Will Have FOrm Details
     * @return string  It will return The Form is Updated or Not.
     */
    public function formupdate(Request $request)
    {
        $form_name = $request->formname;
        $heddienId = Crypt::decrypt($request->heddienId);
        $USERID = Session::get('USERID');
        $message = '';
        if ($form_name != '') {
            $where[] = ['FLAG', 'Show'];
            $where[] = ['FORM_NAME', $form_name];
            $formdata = DB::table('mst_tbl_form_hris')
                ->where($where)->where('FORMID', '!=', $heddienId)->get();
            //  $formdata = $this->getservices->selectfunction('mst_tbl_form_hris', $where);
            if (count($formdata) == 0) {
                $alldata['FORM_NAME'] = $form_name;
                $alldata['UPDATED_DATE'] = date("Y-m-d");
                $alldata['UPDATED_TIME'] = date("H:i:s");
                $alldata['UPDATED_BY'] = $USERID;
                try {
                    updateRecords($alldata, 'mst_tbl_form_hris', 'FORMID', $heddienId);
                    // insertRecords($alldata, 'mst_tbl_form_hris');
                    $message = 'DONE';
                } catch (\Exception $th) {
                    $message = 'Error';
                }
            } else {
                $message = 'Already';
            }
        } else {
            $message = 'Required';
        }
        return $message;
    }

    /**
     * hrisshowfield Display form-builder as per form name
     *
     * @param  mixed $id It is Form Id
     * @return view It Will rturn The View Page
     */
    public function hrisshowfield($id)
    {
        $form_id = Crypt::decrypt($id);
        $formdata = DB::table('mst_tbl_form_hris')->where(['FLAG' => 'Show', 'FORMID' => $form_id])->get()->first();
        $fieldsdata = DB::table('mst_tbl_field_hris')->where(['FLAG' => 'Show', 'FORM_ID' => $form_id])->orderBy('SEQUENCES')->get();
        // echo "<pre>";
        // print_r($fieldsdata);
        // return;
        $validation_arr = array(
            '0' => ['v_id' => 0, 'v_name' => 'Alphanumeric Only', 'regex' => '/^[a-zA-Z0-9 ]+$/'],
            '1' => ['v_id' => 1, 'v_name' => 'Numeric Only', 'regex' => '/^[0-9 ]+$/'],
            '2' => ['v_id' => 2, 'v_name' => 'Character Only', 'regex' => '/^[a-zA-Z ]+$/'],
        );
        $field_dependent_data = DB::table('mst_tbl_form_dependent_field')->where(['FLAG' => 'Show'])->get();
        // $feild_value_dd = [];
        $feild_name_dd = [];
        // print_r($field_dependent_data);
        foreach ($field_dependent_data as $field_dependent_data_key => $field_dependent_data_value) {
            $feild_name_dd[] = $field_dependent_data_value->FIELD_NAME;
        }
        $predefinelist_arr = array(
            '0' => ['p_id' => 0, 'p_name' => 'Gender', 'value' => '["Male","Female"]'],
            '1' => ['p_id' => 1, 'p_name' => 'Location', 'value' => '["Mumbai","Nahur","Thane","Pune"]'],
            '2' => ['p_id' => 2, 'p_name' => 'Designation', 'value' => '["Manager","Developer","Tester"]'],
        );
        foreach ($fieldsdata as $key => $value) {

            $Feild_json_data = $value->FEILD_JSON;
            $field_id = "fid" . $value->FEILD_ID;
            $field_json = json_decode($Feild_json_data, true);
            // echo "<pre>";
            if ($field_json['controltype'] == 'textbox' || $field_json['controltype'] == 'textarea') {
                $v_id = $field_json['validation_id'];
                if ($v_id != '') {
                    $field_json['pattern'] = $validation_arr[$v_id]['regex'];
                } else {
                    $field_json['pattern'] = '';
                }

                // print_r( $v_id);
                //
            } else if ($field_json['controltype'] == 'dropdown' || $field_json['controltype'] == 'multipleselection' || $field_json['controltype'] == 'radiobutton' || $field_json['controltype'] == 'checkbox') {

                $predefinelist_id = $field_json['predefinelist_id'];
                // print_r($predefinelist_id);
                // echo "-------";
                if ($predefinelist_id == 'Custom') {
                    $p_id = $field_json['Custom_Field'];
                    $pre_data = str_replace(" ", "_", $p_id);
                } else {
                    $pre_data = $predefinelist_id;
                }
                $field_dependent_data = DB::table('mst_tbl_form_dependent_field')->where(['FLAG' => 'Show', 'FIELD_NAME' => $pre_data])->get();
                if (count($field_dependent_data) > 0) {
                    $filed_name_d = str_replace("_", " ", $field_dependent_data[0]->FIELD_NAME);
                    $field_json['predefinelist_value'] = $field_dependent_data;
                    $field_json['Custom_Field'] = $filed_name_d;
                } else {
                    $field_json['predefinelist_value'] = [];
                    $field_json['Custom_Field'] = '';
                }

                // echo "<pre>";
                // print_r($field_json);
            } else {
                if (!isset($field_json['session_value'])) {
                    $field_json['session_value'] = "";
                }
                if (!isset($field_json['placeholder'])) {
                    $field_json['placeholder'] = "";
                }
                if (!isset($field_json['default_value'])) {
                    $field_json['default_value'] = "";
                }
                if (!isset($field_json['field_length'])) {
                    $field_json['field_length'] = "";
                }
            }
            $fieldsdata[$key]->field_json = json_encode($field_json);
        }
        // print_r($feild_name_dd);
        return view('Admin.hrisfieldpage', compact('formdata', 'fieldsdata', 'validation_arr', 'predefinelist_arr', 'feild_name_dd'));
    }

    /**
     * hrisfield Save fields created in form
     *
     * @param  mixed $request Details Of Feild Is Added
     * @return string Filed Is Credted Or Not.
     */
    public function hrisfield(Request $request)
    {
        $data = $request->post();
        $DynamicTextBox_values = $request->DynamicTextBox;
        unset($data['_token']);
        $alldata['FORM_ID'] = $form_id = $data['formid'];
        $type = $data['type'];
        $fieldkey = $data['fieldkey'];
        unset($data['type']);

        if (!isset($data['required'])) {
            $data['required'] = "";
        }
        if (!isset($data['readonly'])) {
            $data['readonly'] = "";
        }
        if ($data['controltype'] == 'textbox' || $data['controltype'] == 'textarea' || $data['controltype'] == 'number' || $data['controltype'] == 'date' || $data['controltype'] == 'email') {
            if (!isset($data['session_value'])) {
                $data['session_value'] = "";
            }
            if (!isset($data['placeholder'])) {
                $data['placeholder'] = "";
            }
            if (!isset($data['default_value'])) {
                $data['default_value'] = "";
            }
            if (!isset($data['field_length'])) {
                $data['field_length'] = "";
            }
            if (!isset($data['readonly'])) {
                $data['readonly'] = "";
            }
        }
        $alldata['FEILD_JSON'] = json_encode($data);
        if (isset($DynamicTextBox_values)) {
            $control_type = $request->controltype;

            $feild_cptn = str_replace(" ", "_", $request->Custom_Field);
            // $Depend_data['control_type'] = $request->controltype;
            $Depend_data['FIELD_NAME'] = str_replace(" ", "_", $request->Custom_Field);
            $testvalues = implode(",", $request->DynamicTextBox);
            $str_val = rtrim($testvalues, ", ");
            if ($str_val != '') {
                $Depend_data['FIELD_VALUE'] = $str_val;
                $select = DB::table('mst_tbl_form_dependent_field')->where(['FLAG' => 'Show', 'FIELD_NAME' => $feild_cptn])->count();
                if ($select > 0) {
                    $update = DB::table('mst_tbl_form_dependent_field')->where(['FLAG' => 'Show', 'FIELD_NAME' => $feild_cptn])->update($Depend_data);
                } else {
                    $insert = DB::table('mst_tbl_form_dependent_field')->insert($Depend_data);
                }
            }
        }
        $field_caption = $data['field_caption'];
        if ($type == 'update') {
            $update = DB::table('mst_tbl_field_hris')->where(['FLAG' => 'Show', 'FEILD_ID' => $fieldkey])->update(['FEILD_JSON' => $alldata['FEILD_JSON']]);
            // return;
        } else {
            $fieldscount = DB::table('mst_tbl_field_hris')->select('FEILD_ID')->where(['FLAG' => 'Show', 'FORM_ID' => $form_id])->count();
            $sequence = $fieldscount + 1;

            $alldata['SEQUENCES'] = $sequence;
            $alldata['CREATED_DATE'] = date("Y-m-d");
            $alldata['CREATED_TIME'] = date("H:i:s");
            $insert = DB::table('mst_tbl_field_hris')->insert($alldata);
        }

    }
    /**
     * hrisfieldsdelete It Will Delete The Feilds  Of The Form
     *
     * @param  mixed $request Feild Id Which Has to Be Deleted
     * @return string It will return string Wether Feild Is Deleted.
     */
    public function hrisfieldsdelete(Request $request)
    {
        $form_id = $request->formid;
        // print_r($form_id);exit;
        $id = $request->id;

        $get_field_value = DB::table('mst_tbl_field_hris')->where(['FORM_ID' => $form_id, 'FLAG' => 'Show', 'FEILD_ID' => $id])->get()->first();
        $old_index = $get_field_value->SEQUENCES;

        $max = DB::table('mst_tbl_field_hris')->where(['FORM_ID' => $form_id, 'FLAG' => 'Show'])->where('SEQUENCES', '>', $old_index)->max('SEQUENCES');
        $min = DB::table('mst_tbl_field_hris')->where(['FORM_ID' => $form_id, 'FLAG' => 'Show'])->where('SEQUENCES', '>', $old_index)->min('SEQUENCES');
        $decrement_array = array($min, $max);

        $update_sequence = DB::table('mst_tbl_field_hris')->where(['FORM_ID' => $form_id, 'FLAG' => 'Show'])->whereBetween('SEQUENCES', $decrement_array)->decrement('SEQUENCES', 1);

        $field_delete = DB::table('mst_tbl_field_hris')->where(['FORM_ID' => $form_id, 'FLAG' => 'Show', 'FEILD_ID' => $id])->update(['flag' => 'Deleted']);
        return 'Done';
    }

    /**
     * fieldautoids It Will Last id of Feild is Created.
     *
     * @param  mixed $request Form Id
     * @return count Count Of Feilds.
     */
    public function fieldautoids(Request $request)
    {
        $formid = $request->formid;
        $keyscount = DB::table('mst_tbl_field_hris')->where(['FORM_ID' => $formid, 'FLAG' => 'Show'])->get()->count();
        return $keyscount;
    }
    /**
     * predefine_lists It Will Give you All pre Define List Values.
     *
     * @param  mixed $request Predifne Name Whose Vlaue You Reuired
     * @return aary It will return the aaary of list.
     */
    public function predefine_lists(Request $request)
    {
        $postData = $request->predefine_list_value;

        $predf_val = DB::table('mst_tbl_form_dependent_field')->where(['FLAG' => 'Show', 'FIELD_NAME' => $postData])->get()->first();
        // print_r($predf_val);
        // return $predf_val;
        $feild_value = $predf_val->FIELD_VALUE;
        $explode_val = explode(",", $feild_value);
        return $explode_val;
    }
}
