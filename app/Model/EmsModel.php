<?php

namespace App\Model;

use App\Services\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EmsModel extends Model
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
     * Authtentication It Is For The Authentication Purpose
     *
     * @param  mixed $username Username By Which Authentication Need To Be Done
     * @param  mixed $userPasword Password By Which Authentication Will be Done
     * @return $return It Will Return that wether user is Valid Or Not
     */
    public function Authtentication($username, $userPasword)
    {
        try {
            $where[] = ['EMAILID', $username];
            $loginCredentailDetails = $this->getservices->selectfunction('sup_tbl_login_credential', $where);
            // print_r($loginCredentailDetails);
            // print_r(Crypt::decrypt($loginCredentailDetails[0]->AUTHENTICATION_START));
            // date_default_timezone_set('Asia/Kolkata');
            $getTodaysDateToAuthenticate = date("Y-m-d");
            $returnmessage = '';
            if (count($loginCredentailDetails) > 0) {
                $RoleId = $loginCredentailDetails[0]->ROLEID;
                if ($RoleId == 1) {
                    $Password = $loginCredentailDetails[0]->USERPASSWORD;
                    $getDecryptPassword = Crypt::decrypt($Password);
                    $databasename = Config::get('database.connections.' . Config::get('database.default'));
                    if ($userPasword == $getDecryptPassword) {
                        $USERID = $loginCredentailDetails[0]->USERID;
                        $CLIENTID = $loginCredentailDetails[0]->CLIENTID;
                        $USERNAME = $loginCredentailDetails[0]->USERNAME;
                        $EMAILID = $loginCredentailDetails[0]->EMAILID;
                        $getPrefix = $loginCredentailDetails[0]->PREFIX;
                        $ZONE = $loginCredentailDetails[0]->PREFIX;
                        $START = $loginCredentailDetails[0]->AUTHENTICATION_START;
                        $END = $loginCredentailDetails[0]->AUTHENTICATION_END;
                        Session::put('RoleId', $RoleId);
                        Session::put('USERID', 1);
                        Session::put('CLIENTID', $CLIENTID);
                        Session::put('USERNAME', $USERNAME);
                        Session::put('Name', 'Super Admin');
                        Session::put('EMAILID', $EMAILID);
                        Session::put('DATABASENAME', $databasename['database']);
                        Session::put('LOGO', '');
                        Session::put('TIMEZONE', 'Asia/Kolkata');
                        Session::put('PROFILE', '');
                        $ENCRYPTROLEID = Crypt::encrypt($RoleId);
                        $returnmessage = $ENCRYPTROLEID;
                    } else {
                        $returnmessage = 'NotMatch';
                    }
                } else if ($RoleId == 2) {
                    $where1[] = ['SUPEMAILID', $username];
                    $where1[] = ['FLAG', 'Show'];
                    $loginCredentailDetails = $this->getservices->selectfunction('sup_tbl_superadmin_users', $where1);
                    if (count($loginCredentailDetails) > 0) {
                        $Password = $loginCredentailDetails[0]->SUPPASSWORD;
                        $getDecryptPassword = Crypt::decrypt($Password);
                        if ($userPasword == $getDecryptPassword) {
                            $returnmessage = 'Check';
                        } else {
                            $returnmessage = 'NotMatch';
                        }
                    } else {
                        $returnmessage = 'NotFound';
                    }
                } else {
                    $USERID = $loginCredentailDetails[0]->USERID;
                    $CLIENTID = $loginCredentailDetails[0]->CLIENTID;
                    $USERNAME = $loginCredentailDetails[0]->USERNAME;
                    $EMAILID = $loginCredentailDetails[0]->EMAILID;
                    $getPrefix = $loginCredentailDetails[0]->PREFIX;
                    $ZONE = $loginCredentailDetails[0]->PREFIX;
                    $START = $loginCredentailDetails[0]->AUTHENTICATION_START;
                    $END = $loginCredentailDetails[0]->AUTHENTICATION_END;
                    $TIMEZONE = $loginCredentailDetails[0]->TIMEZONE;
                    $FLAG = $loginCredentailDetails[0]->FLAG;
                    SetTimeZone($TIMEZONE);
                    $databasename = Config::get('database.connections.' . Config::get('database.default'));
                    $getdynamicdatabsename = $getPrefix . '_management';
                    DB::disconnect('dynamicsql');
                    Setthedatabase($getdynamicdatabsename);
                    $selectwhere[] = ['EMAILID', $username];
                    $getuserDetails = $this->getservices->selectfunction('mst_tbl_users', $selectwhere);
                    $FLAGCONDITION[] = ['FLAG', 'Show'];
                    $componydetails = $this->getservices->selectfunction('mst_tbl_company_information', $FLAGCONDITION);
                    $LOGO = '';
                    if (count($componydetails) > 0) {
                        $LOGO = $componydetails[0]->COMPANYLOGO;
                    }
                    $Password = $getuserDetails[0]->PASSWORDS;
                    $ADMINRIGHTS = $getuserDetails[0]->ADMINRIGHTS;
                    $PROFILEPICTURE = $getuserDetails[0]->PROFILEPICTURE;
                    $FULLNAME = $getuserDetails[0]->FULLNAME;
                    $USERIDSOFUSER = $getuserDetails[0]->USERID;

                    $getDecryptPassword = Crypt::decrypt($Password);
                    if ($userPasword == $getDecryptPassword) {
                        $AUTHENTICATION_START = Crypt::decrypt($START);
                        $AUTHENTICATION_END = Crypt::decrypt($END);
                        $getAuthentications1 = $this->getservices->AUTHENTICATION($getTodaysDateToAuthenticate, $AUTHENTICATION_START, 'Start');
                        if ($getAuthentications1 == 1) {
                            $getAuthentications2 = $this->getservices->AUTHENTICATION($getTodaysDateToAuthenticate, $AUTHENTICATION_END, 'End');
                            if ($getAuthentications2 == 1) {
                                if ($FLAG == 'Show' || $FLAG == 'Stop') {
                                    if ($FLAG == 'Stop') {
                                        $returnmessage = 'Stop';
                                    } else {
                                        Session::put('USERID', $USERIDSOFUSER);
                                        Session::put('CLIENTID', $CLIENTID);
                                        Session::put('USERNAME', $USERNAME);
                                        Session::put('EMAILID', $EMAILID);
                                        Session::put('TIMEZONE', $ZONE);
                                        Session::put('PREFIX', $getPrefix);
                                        Session::put('DATABASENAME', $getdynamicdatabsename);
                                        Session::put('ORIGNALDATABASENAME', $databasename['database']);
                                        Session::put('LOGO', $LOGO);
                                        Session::put('TIMEZONE', $TIMEZONE);
                                        Session::put('PROFILE', $PROFILEPICTURE);
                                        Session::put('Name', $FULLNAME);
                                        $TODAYDATE = date('Y-m-d');
                                        $TODAYTIME = date(' H:i:s');
                                        $SAVELOGINREPORTS['USER_ID'] = $USERIDSOFUSER;
                                        $SAVELOGINREPORTS['ACTION_DATE'] = $TODAYDATE;
                                        $SAVELOGINREPORTS['ACTION_TIME'] = $TODAYTIME;
                                        $SAVELOGINREPORTS['STATUS'] = 'Login';
                                        if ($RoleId == 4) {
                                            if ($ADMINRIGHTS == 'Yes') {
                                                $returnmessage = 'Both';
                                            } else {
                                                Session::put('RoleId', $RoleId);
                                                $ENCRYPTROLEID = Crypt::encrypt($RoleId);
                                                insertRecords($SAVELOGINREPORTS, 'mst_tbl_login_aduit_reports');
                                                $returnmessage = $ENCRYPTROLEID;
                                            }
                                        } else {
                                            Session::put('RoleId', $RoleId);
                                            insertRecords($SAVELOGINREPORTS, 'mst_tbl_login_aduit_reports');
                                            $ENCRYPTROLEID = Crypt::encrypt($RoleId);
                                            $returnmessage = $ENCRYPTROLEID;
                                        }
                                    }

                                    # code...
                                } else {
                                    $returnmessage = 'NotFound';
                                }
                            } else {
                                $returnmessage = 'Expire';
                            }
                        } else {
                            $returnmessage = 'NotStarted';
                        }

                    } else {
                        $returnmessage = 'NotMatch';
                    }
                }
            } else {
                $returnmessage = 'NotFound';
            }
            return $returnmessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
            return 'Error';
        }

    }

    /**
     * saveClient . This Function Will Save The Client Details In To
     * sup_tbl_client, login_credentail, mst_tbl_user,company_info table.
     * and Create The Database Related To Its Prefix
     * @param  mixed $data It Is Havling Client Datas
     * @return void It Will Return The The Message That Client Is Creted
     */
    public function saveClient($data)
    {
        try {
            $company_name = $data['COMPANYNAME'];
            $admin_name = $data['ADMINNAME'];
            $contatct_info = $data['ADMINMOB_NO'];
            $admin_emailid = $data['ADMINEMAILID'];
            $client_prefix = $data['CLIENTPREFIX'];
            $encrypt_password = $data['PASSWORDS'];
            $empcode_format = $data['EMP_CODE'];
            $encryptStartDate = $data['AUTHENTICATION_START'];
            $encryptDate = $data['AUTHENTICATION'];
            $user_lmit = $data['USER_LIMITS'];
            $timestamp = $data['CREATED_AT'];
            $databsename = $client_prefix . '_management';
            $originalDB = $data['DATABASENAME'];
            $companylogo = $data['COMPANYLOGO'];
            $type = $data['AUTHENTICATION_TYPE'];
            $no_of_days = $data['AUTHENTICATION_NUMBER'];
            $LOCATION = $data['LOCATION'];
            $WEBSITE = $data['WEBSITE'];
            $TIMEZONE = $data['TIMEZONE'];
            $responsemessage = '';
            DB::beginTransaction();
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
            $db = DB::select($query, [$databsename]);
            if (empty($db)) {
                /** Check Wether Email Id Is Prsent In The Login Table
                 * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
                 */
                $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $admin_emailid])->get();
                if (count($loginCredentailDetails) == 0) {
                    $sup_client = DB::table('sup_tbl_all_client')
                        ->where(['ADMINEMAILID' => $admin_emailid])->get();
                    if (count($sup_client) == 0) {
                        $checkClientprefix = DB::table('sup_tbl_all_client')->where(['CLIENTPREFIX' => $client_prefix])->get()->count();
                        if ($checkClientprefix == 0) {

                            try {
                                /** Save Records In sup_tbl_all_clients */
                                $SUPDETAILS['COMPANYNAME'] = $company_name;
                                $SUPDETAILS['ADMINNAME'] = $admin_name;
                                $SUPDETAILS['ADMINMOBILENO'] = $contatct_info;
                                $SUPDETAILS['ADMINEMAILID'] = $admin_emailid;
                                $SUPDETAILS['CLIENTPREFIX'] = $client_prefix;
                                $SUPDETAILS['PASSWORDS'] = $encrypt_password;
                                $SUPDETAILS['EMPCODE'] = $empcode_format;
                                $SUPDETAILS['AUTHENTICATION_TYPE'] = $type;
                                $SUPDETAILS['AUTHENTICATION_NUMBER'] = $no_of_days;
                                $SUPDETAILS['AUTHENTICATION_START'] = $encryptStartDate;
                                $SUPDETAILS['AUTHENTICATION_END'] = $encryptDate;
                                $SUPDETAILS['CREATED_AT'] = $timestamp;
                                $SUPDETAILS['USERLIMITS'] = $user_lmit;
                                $SUPDETAILS['COMPNAYLOGO'] = $companylogo;
                                $SUPDETAILS['LOCATION'] = $LOCATION;
                                $SUPDETAILS['TIMEZONE'] = $TIMEZONE;
                                $SUPDETAILS['WEBSITE'] = $WEBSITE;

                                $CLIENTID = insertRecords($SUPDETAILS, 'sup_tbl_all_client');
                                /** Save Records In sup_tbl_login_credential*/
                                $LOGINCREDENTIALS['CLIENTID'] = $CLIENTID;
                                $LOGINCREDENTIALS['EMAILID'] = $admin_emailid;
                                $LOGINCREDENTIALS['ROLEID'] = '3';
                                $LOGINCREDENTIALS['CREATED_AT'] = $timestamp;
                                $LOGINCREDENTIALS['AUTHENTICATION_START'] = $encryptStartDate;
                                $LOGINCREDENTIALS['AUTHENTICATION_END'] = $encryptDate;
                                $LOGINCREDENTIALS['PREFIX'] = $client_prefix;
                                $LOGINCREDENTIALS['TIMEZONE'] = $TIMEZONE;
                                $userId = insertRecords($LOGINCREDENTIALS, 'sup_tbl_login_credential');
                                try {
                                    DB::statement('Create database ' . $databsename);
                                    $tables = DB::select("SELECT  table_name FROM information_schema.tables WHERE table_schema = '$originalDB' and TABLE_NAME NOT LIKE 'sup_%' ORDER BY table_name");
                                    $i = 0;
                                    foreach ($tables as $key => $value) {
                                        $aaryofDetails[$key] = $value;
                                        $tablesname = $aaryofDetails[$i]->table_name;
                                        DB::statement('Create Table ' . $databsename . '.' . $tablesname . ' Like ' . $originalDB . '.' . $tablesname);
                                        $i++;
                                    }
                                    try {
                                        DB::disconnect('dynamicsql');
                                        /** Save Records In The mst_tbl_users */
                                        $USERDETAILS['FULLNAME'] = $admin_name;
                                        $USERDETAILS['MOBLIENO'] = $contatct_info;
                                        $USERDETAILS['EMAILID'] = $admin_emailid;
                                        $USERDETAILS['PASSWORDS'] = $encrypt_password;
                                        $USERDETAILS['EMPCODE'] = $empcode_format;
                                        $USERDETAILS['CREATED_AT'] = $timestamp;
                                        $USERDETAILS['ROLEID'] = '3';
                                        Setthedatabase($databsename);
                                        // Config::set('database.connections.mysql.database', $databsename);
                                        $userId = insertRecords($USERDETAILS, 'mst_tbl_users');
                                        /** Save Records In The mst_tbl_company_information */
                                        $COMPONYINFO['COMPANYLOGO'] = $companylogo;
                                        $COMPONYINFO['COMPANYNAME'] = $company_name;
                                        $COMPONYINFO['WEBSITE'] = $WEBSITE;
                                        $COMPONYINFO['COMPANYLOCATION'] = $LOCATION;
                                        $COMPONYINFO['TIMEZONE'] = $TIMEZONE;
                                        $COMPANYID = insertRecords($COMPONYINFO, 'mst_tbl_company_information');
                                        if ($COMPANYID > 0) {

                                            // Config::set('database.connections.mysql.database', $originalDB);
                                            // Config::set('database.default', 'mysql');
                                            $responsemessage = 'DONE';
                                        }
                                        DB::commit();

                                    } catch (\Exception $e) {
                                        $Errors = $e->getMessage();
                                        DB::rollback();
                                        $responsemessage = 'Error1->' . $Errors;
                                    }
                                } catch (\Exception $e) {
                                    $Errors = $e->getMessage();
                                    DB::rollback();
                                    $responsemessage = 'ErrorInDB->' . $Errors;
                                }
                            } catch (\Exception $e) {
                                $Errors = $e->getMessage();
                                DB::rollback();
                                $responsemessage = 'Error2' . $Errors;
                            }
                        } else {
                            $responsemessage = 'DBPRESENT';
                        }
                    } else {
                        $responsemessage = 'EMAILPRESENT';
                    }
                } else {
                    $responsemessage = 'EMAILPRESENT';
                }
            } else {
                $responsemessage = 'DBPRESENT';
            }
            Setthedatabase($originalDB);
            return $responsemessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
            DB::rollback();
            return 'Error3->' . $Errors;
        }

    }

    /**
     * saveClient . This Function Will Save The Client Details In To
     * sup_tbl_client, login_credentail, mst_tbl_user,company_info table.
     * and Create The Database Related To Its Prefix
     * @param  mixed $data It Is Havling Client Datas
     * @return void It Will Return The The Message That Client Is Creted
     */
    public function UpdateClient($data)
    {
        try {
            $company_name = $data['COMPANYNAME'];
            $admin_name = $data['ADMINNAME'];
            $contatct_info = $data['ADMINMOB_NO'];
            $admin_emailid = $data['ADMINEMAILID'];
            $CLIENT_ID = $data['CLIENT_ID'];
            $encrypt_password = $data['PASSWORDS'];
            $empcode_format = $data['EMP_CODE'];
            $encryptStartDate = $data['AUTHENTICATION_START'];
            $encryptDate = $data['AUTHENTICATION'];
            $user_lmit = $data['USER_LIMITS'];
            $timestamp = $data['UPDATED_AT'];
            // $databsename = $client_prefix . '_management';
            $originalDB = $data['DATABASENAME'];
            $companylogo = $data['COMPANYLOGO'];
            $type = $data['AUTHENTICATION_TYPE'];
            $no_of_days = $data['AUTHENTICATION_NUMBER'];
            $LOCATION = $data['LOCATION'];
            $WEBSITE = $data['WEBSITE'];
            $TIMEZONE = $data['TIMEZONE'];
            $responsemessage = '';

            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */
            $GETCLIENTDETAILS = DB::table('sup_tbl_all_client')->where(['CLIENT_ID' => $CLIENT_ID])->first();
            $ADMINEMAILID = $GETCLIENTDETAILS->ADMINEMAILID;
            $CLIENTPREFIX = $GETCLIENTDETAILS->CLIENTPREFIX;
            $CLIENTDATABASENAME = $CLIENTPREFIX . '_management';
            $sup_client = DB::table('sup_tbl_all_client')->where(['ADMINEMAILID' => $admin_emailid])->where('CLIENT_ID', '!=', $CLIENT_ID)->get();
            if (count($sup_client) == 0) {
                $validationType = 'FALSE';
                $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $admin_emailid])->get();
                if (count($loginCredentailDetails) == 0) {
                    $validationType = 'TRUE';
                } else {
                    $GETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                        ->where(['EMAILID' => $ADMINEMAILID])->first();
                    $USERID = $GETLOGINCREDENTIALDETAILS->USERID;
                    $checkdetailsofemailid = DB::table('sup_tbl_login_credential')
                        ->where(['EMAILID' => $admin_emailid])->where('USERID', '!=', $USERID)->get();
                    if (count($checkdetailsofemailid) == 0) {
                        $validationType = 'TRUE';
                    } else {
                        $validationType = 'FALSE';
                    }
                }
                // echo $validationType;
                // return;
                if ($validationType == 'TRUE') {
                    try {
                        /** Update Records In sup_tbl_all_clients */
                        $SUPDETAILS['COMPANYNAME'] = $company_name;
                        $SUPDETAILS['ADMINNAME'] = $admin_name;
                        $SUPDETAILS['ADMINMOBILENO'] = $contatct_info;
                        $SUPDETAILS['ADMINEMAILID'] = $admin_emailid;
                        $SUPDETAILS['PASSWORDS'] = $encrypt_password;
                        $SUPDETAILS['EMPCODE'] = $empcode_format;
                        $SUPDETAILS['AUTHENTICATION_TYPE'] = $type;
                        $SUPDETAILS['AUTHENTICATION_NUMBER'] = $no_of_days;
                        $SUPDETAILS['AUTHENTICATION_START'] = $encryptStartDate;
                        $SUPDETAILS['AUTHENTICATION_END'] = $encryptDate;
                        $SUPDETAILS['UPDATED_AT'] = $timestamp;
                        $SUPDETAILS['USERLIMITS'] = $user_lmit;
                        $SUPDETAILS['COMPNAYLOGO'] = $companylogo;
                        $SUPDETAILS['LOCATION'] = $LOCATION;
                        $SUPDETAILS['TIMEZONE'] = $TIMEZONE;
                        $SUPDETAILS['WEBSITE'] = $WEBSITE;

                        $UPDATE1 = updateRecords($SUPDETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENT_ID);
                        if ($UPDATE1 == 'Done') {
                            /** Fetch The Login Credential Detils */
                            $FETCHGETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                                ->where(['EMAILID' => $ADMINEMAILID])->first();
                            $FETChUSERID = $FETCHGETLOGINCREDENTIALDETAILS->USERID;
                            /** Update Records In sup_tbl_login_credential*/
                            $LOGINCREDENTIALS['CLIENTID'] = $CLIENT_ID;
                            $LOGINCREDENTIALS['EMAILID'] = $admin_emailid;
                            $LOGINCREDENTIALS['ROLEID'] = '3';
                            $LOGINCREDENTIALS['UPDATED_AT'] = $timestamp;
                            $LOGINCREDENTIALS['AUTHENTICATION_START'] = $encryptStartDate;
                            $LOGINCREDENTIALS['AUTHENTICATION_END'] = $encryptDate;
                            $LOGINCREDENTIALS['TIMEZONE'] = $TIMEZONE;
                            $UPDATE2 = updateRecords($LOGINCREDENTIALS, 'sup_tbl_login_credential', 'USERID', $FETChUSERID);
                            if ($UPDATE2 == 'Done') {
                                DB::disconnect('dynamicsql');
                                Setthedatabase($CLIENTDATABASENAME);
                                /** Update Records In The mst_tbl_users */
                                $USERDETAILS['FULLNAME'] = $admin_name;
                                $USERDETAILS['MOBLIENO'] = $contatct_info;
                                $USERDETAILS['EMAILID'] = $admin_emailid;
                                $USERDETAILS['PASSWORDS'] = $encrypt_password;
                                $USERDETAILS['EMPCODE'] = $empcode_format;
                                $USERDETAILS['UPDATED_AT'] = $timestamp;
                                $USERDETAILS['ROLEID'] = '3';
                                $UPDATE3 = updateRecords($USERDETAILS, 'mst_tbl_users', 'EMAILID', $ADMINEMAILID);
                                if ($UPDATE3 == 'Done') {
                                    /** Update  Records In The mst_tbl_company_information if Not Prsent Then Add it*/
                                    $COMPANYDETAILS = DB::table('mst_tbl_company_information')->where(['FLAG' => 'Show'])->get();
                                    $COMPONYINFO['COMPANYLOGO'] = $companylogo;
                                    $COMPONYINFO['COMPANYNAME'] = $company_name;
                                    $COMPONYINFO['WEBSITE'] = $WEBSITE;
                                    $COMPONYINFO['COMPANYLOCATION'] = $LOCATION;
                                    $COMPONYINFO['TIMEZONE'] = $TIMEZONE;
                                    if (count($COMPANYDETAILS) > 0) {
                                        $COMPANY_ID = $COMPANYDETAILS[0]->COMPANY_ID;
                                        $UPDATE4 = updateRecords($COMPONYINFO, 'mst_tbl_company_information', 'COMPANY_ID', $COMPANY_ID);
                                        if ($UPDATE4 == 'Done') {
                                            $responsemessage = 'DONE';
                                        } else {
                                            $responsemessage = 'Error' . $UPDATE4;
                                        }
                                    } else {
                                        $COMPANYID = insertRecords($COMPONYINFO, 'mst_tbl_company_information');
                                        $responsemessage = 'DONE';
                                    }

                                } else {
                                    $responsemessage = 'Error5' . $UPDATE3;
                                }

                            } else {
                                $responsemessage = 'Error4' . $UPDATE2;
                            }
                        } else {
                            $responsemessage = 'Error3' . $UPDATE1;
                        }
                    } catch (\Exception $e) {
                        $Errors = $e->getMessage();
                        $responsemessage = 'Error2' . $Errors;
                    }
                } else {
                    $responsemessage = 'EMAILPRESENT';
                }

            } else {
                $responsemessage = 'EMAILPRESENT';
            }
            return $responsemessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
            return 'Error3->' . $Errors;
        }

    }

    /**
     * DeleteTheClient This Will Delete The Client And Drop The Database Of The Client And Take The Backup Of The Databse.
     *
     * @param  mixed $ClientID This Is The Client Id of Which We Have To Delete The Client.
     * @return string It will return with a String Wether Cilent Delete Or Not.
     */
    public function DeleteTheClient($ClientID)
    {
        try {
            $TODAYDATE = date('Y-m-d');
            $DECRYPTCLIENTID = Crypt::decrypt($ClientID);
            /** Get Details From The Client Id from sup_all_client*/
            $CLIENTDETAILS = DB::table('sup_tbl_all_client')->where(['CLIENT_ID' => $DECRYPTCLIENTID])->first();
            /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_all_client */
            $DETAILS['FLAG'] = 'Delete';
            $UPDATE1 = updateRecords($DETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $DECRYPTCLIENTID);
            if ($UPDATE1 == 'Done') {
                /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_login_credential */
                $UPDATE2 = updateRecords($DETAILS, 'sup_tbl_login_credential', 'CLIENTID', $DECRYPTCLIENTID);
                if ($UPDATE2 == 'Done') {
                    $GETPREFIX = $CLIENTDETAILS->CLIENTPREFIX;
                    $DBNAME = $GETPREFIX . '_management';
                    $FILENAME = $GETPREFIX . '/' . $GETPREFIX . 'management-backup-' . $TODAYDATE . '.sql'; // File name By Which Backup Will Created
                    $FILEPATH = "DATABASEBACKUP/" . $FILENAME;
                    $CONTENT = $this->getservices->codeToTakeBackupofDB($DBNAME);
                    Storage::put($FILEPATH, $CONTENT); // This Will Create The SQL file If not prsent.
                    DB::statement('DROP DATABASE `' . $DBNAME . '`'); // To Drop The Database.
                    $responsemessage = 'DONE';
                } else {
                    $responsemessage = 'Error3->' . $UPDATE2;
                }

            } else {
                $responsemessage = 'Error2->' . $UPDATE1;
            }
            return $responsemessage;
        } catch (\Exception $th) {
            $Errors = $th->getMessage();
            return 'Error1->' . $Errors;
        }

    }

    /**
     * StopServices It will Stop The Service Of The Client And Its Users
     *
     * @param  $data It is An aary That Content Client Id And Sttsts To Updates
     * @return string It will return The Message That User Delted Succesfuly;
     */
    public function StopServices($data)
    {
        try {
            $CLIENTID = $data['CLIENT_ID'];
            $FLAG = $data['FLAG'];
            $UPDATEDETAILS['FLAG'] = $FLAG;
            /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_all_client */
            $UPDATE1 = updateRecords($UPDATEDETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENTID);
            if ($UPDATE1 == 'Done') {
                /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_login_credential */
                $UPDATE2 = updateRecords($UPDATEDETAILS, 'sup_tbl_login_credential', 'CLIENTID', $CLIENTID);
                if ($UPDATE2 == 'Done') {
                    $responsemessage = 'DONE';
                } else {
                    $responsemessage = 'Error3->' . $UPDATE2;
                }
            } else {
                $responsemessage = 'Error2->' . $UPDATE1;
            }
            return $responsemessage;
        } catch (\Exception $th) {
            $Errors = $th->getMessage();
            return 'Error1->' . $Errors;
        }

    }

    /**
     * updateLicens It will Update The Licenes of Client
     *
     * @param  mixed $data It Is Data Of Which Client To Be Update
     * @return string It Will Return The String That Client Updated or Not
     */
    public function updateLicens($data)
    {
        try {
            $CLIENTID = $data['clientids'];
            $user_lmit = $data['user_lmit'];
            $type = $data['type'];
            $no_of_days = $data['no_of_days'];
            $startdate = $data['startdate'];
            $expiry_date = $data['expiry_date'];
            /** Update Client Details sup_tbl_all_clllients */
            $ClientDETAILS['USERLIMITS'] = $user_lmit;
            $ClientDETAILS['AUTHENTICATION_TYPE'] = $type;
            $ClientDETAILS['AUTHENTICATION_NUMBER'] = $no_of_days;
            $ClientDETAILS['AUTHENTICATION_START'] = $startdate;
            $ClientDETAILS['AUTHENTICATION_END'] = $expiry_date;
            /** This Will Update The Sup_tbl_all_clinet */
            $UPDATE1 = updateRecords($ClientDETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENTID);
            if ($UPDATE1 == 'Done') {
                /** Update In Login Credentails Tabel sup_tbl_login_credentials */
                $LOGINDETAILS['AUTHENTICATION_START'] = $startdate;
                $LOGINDETAILS['AUTHENTICATION_END'] = $expiry_date;
                $UPDATE2 = updateRecords($LOGINDETAILS, 'sup_tbl_login_credential', 'CLIENTID', $CLIENTID);
                if ($UPDATE2 == 'Done') {
                    $responsemessage = 'DONE';
                } else {
                    $responsemessage = 'Error3->' . $UPDATE2;
                }

            } else {
                $responsemessage = 'Error2->' . $UPDATE1;
            }
            return $responsemessage;
        } catch (\Exception $th) {
            $Errors = $th->getMessage();
            return 'Error1->' . $Errors;
        }
        # code...
    }

    /**
     * savesuperadmins It will Save all records Of Superadmin To The Rquired Tabel
     *
     * @param  mixed $data It will Have Data That is essintail To Create
     * @return string That Superadmin Crated Or Not.
     */
    public function savesuperadmins($data)
    {
        try {
            $admin_name = $data['admin_name'];
            $admin_emailid = $data['admin_emailid'];
            $time_zone = $data['time_zone'];
            $logo = $data['logo'];
            $encryptuid = $data['encryptuid'];
            $encrypt_password = $data['encrypt_password'];
            $responsemessage = '';
            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */
            $loginCredentailDetails = DB::table('sup_tbl_login_credential')
                ->where(['EMAILID' => $admin_emailid, 'FLAG' => 'Show'])->get();
            if (count($loginCredentailDetails) == 0) {
                $sup_client = DB::table('sup_tbl_superadmin_users')
                    ->where(['SUPEMAILID' => $admin_emailid, 'FLAG' => 'Show'])->get();
                if (count($sup_client) == 0) {
                    try {
                        /** Save Records In sup_tbl_superadmin_users */
                        $SUPDETAILS['Name'] = $admin_name;
                        $SUPDETAILS['SUPEMAILID'] = $admin_emailid;
                        $SUPDETAILS['TIMEZONE'] = $time_zone;
                        $SUPDETAILS['LOGO'] = $logo;
                        $SUPDETAILS['UNIQUE_ID'] = $encryptuid;
                        $SUPDETAILS['SUPPASSWORD'] = $encrypt_password;
                        insertRecords($SUPDETAILS, 'sup_tbl_superadmin_users');
                        $LOGINDETAILS['EMAILID'] = $admin_emailid;
                        $LOGINDETAILS['ROLEID'] = 2;
                        $LOGINDETAILS['TIMEZONE'] = $time_zone;
                        $LOGINDETAILS['CLIENTID'] = 0;
                        insertRecords($LOGINDETAILS, 'sup_tbl_login_credential');
                        $responsemessage = 'DONE';
                    } catch (\Exception $e) {
                        $Errors = $e->getMessage();
                        $responsemessage = 'Error2' . $Errors;
                    }

                } else {
                    $responsemessage = 'EMAILPRESENT';
                }
            } else {
                $responsemessage = 'EMAILPRESENT';
            }
            return $responsemessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
            return 'Error';
        }

    }

    /**
     * updatesuperadmins It will update all records Of Superadmin To The Rquired Tabel
     *
     * @param  mixed $data It will Have Data That is essintail To update
     * @return string That Superadmin Updated Or Not.
     */
    public function updatesuperadmins($data)
    {
        try {
            $admin_name = $data['admin_name'];
            $admin_emailid = $data['admin_emailid'];
            $time_zone = $data['time_zone'];
            $logo = $data['logo'];
            $encryptuid = $data['encryptuid'];
            $encrypt_password = $data['encrypt_password'];
            $SUPUSERID = $data['SUPUSERID'];
            $responsemessage = '';
            /** Check Wether Email Id Is Prsent In The Login Table
             * If Its Count Is Greter Then 1 Then Email Is InValid  else Email Is  Valid.
             */
            $SUPERADMINDETAILS = DB::table('sup_tbl_superadmin_users')->where(['SUPUSERID' => $SUPUSERID])->first();
            $ADMINEMAILID = $SUPERADMINDETAILS->SUPEMAILID;
            $sup_client = DB::table('sup_tbl_superadmin_users')
                ->where(['SUPEMAILID' => $admin_emailid])->where(['FLAG' => 'Show'])->where('SUPUSERID', '!=', $SUPUSERID)->get();
            if (count($sup_client) == 0) {
                $GETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $ADMINEMAILID, 'FLAG' => 'Show'])->first();
                $USERID = $GETLOGINCREDENTIALDETAILS->USERID;
                $checkdetailsofemailid = DB::table('sup_tbl_login_credential')
                    ->where(['EMAILID' => $admin_emailid, 'FLAG' => 'Show'])->where('USERID', '!=', $USERID)->get();
                if (count($checkdetailsofemailid) == 0) {
                    try {
                        /** Save Records In sup_tbl_superadmin_users */
                        $SUPDETAILS['Name'] = $admin_name;
                        $SUPDETAILS['SUPEMAILID'] = $admin_emailid;
                        $SUPDETAILS['TIMEZONE'] = $time_zone;
                        $SUPDETAILS['LOGO'] = $logo;
                        $SUPDETAILS['UNIQUE_ID'] = $encryptuid;
                        $SUPDETAILS['SUPPASSWORD'] = $encrypt_password;
                        $UPDATE1 = updateRecords($SUPDETAILS, 'sup_tbl_superadmin_users', 'SUPUSERID', $SUPUSERID);
                        if ($UPDATE1 == 'Done') {
                            $LOGINDETAILS['EMAILID'] = $admin_emailid;
                            $LOGINDETAILS['ROLEID'] = 2;
                            $LOGINDETAILS['TIMEZONE'] = $time_zone;
                            // $LOGINDETAILS['CLIENTID'] = 0;
                            $UPDATE2 = updateRecords($LOGINDETAILS, 'sup_tbl_login_credential', 'USERID', $USERID);
                            if ($UPDATE2 == 'Done') {
                                $responsemessage = 'DONE';
                            } else {
                                return 'Error4';
                            }
                        } else {
                            return 'Error3';
                        }

                    } catch (\Exception $e) {
                        $Errors = $e->getMessage();
                        $responsemessage = 'Error2' . $Errors;
                    }
                } else {
                    $responsemessage = 'EMAILPRESENT';
                }
            } else {
                $responsemessage = 'EMAILPRESENT';
            }

            return $responsemessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
            return 'Error';
        }

    }

    /**
     * DeleteTheSUperAdmin This Will Delete The SuperAdmin.
     *
     * @param  mixed $SUPID This Is The SUPID Id of Which We Have To Delete The Super admin.
     * @return string It will return with a String Wether SuperAdmin Delete Or Not.
     */
    public function DeleteTheSUperAdmin($SUPID)
    {
        try {
            $TODAYDATE = date('Y-m-d');
            $DECRYPTSUPID = Crypt::decrypt($SUPID);
            /** Get Details From The Supadmin Id from sup_tbl_superadmin_users*/
            $GETCLIENTDETAILS = DB::table('sup_tbl_superadmin_users')->where(['SUPUSERID' => $DECRYPTSUPID])->first();
            $ADMINEMAILID = $GETCLIENTDETAILS->SUPEMAILID;
            /** Get Details From The User Id from sup_tbl_login_credential*/
            $GETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                ->where(['EMAILID' => $ADMINEMAILID])->first();
            $USERID = $GETLOGINCREDENTIALDETAILS->USERID;
            /** This Is Update Function Which Will Delete All SuperAdmin Details By Updating Flag in sup_tbl_superadmin_users */
            $DETAILS['FLAG'] = 'Delete';
            $UPDATE1 = updateRecords($DETAILS, 'sup_tbl_superadmin_users', 'SUPUSERID', $DECRYPTSUPID);
            if ($UPDATE1 == 'Done') {
                /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_login_credential */
                $UPDATE2 = updateRecords($DETAILS, 'sup_tbl_login_credential', 'USERID', $USERID);
                if ($UPDATE2 == 'Done') {
                    $responsemessage = 'DONE';
                } else {
                    $responsemessage = 'Error3->' . $UPDATE2;
                }

            } else {
                $responsemessage = 'Error2->' . $UPDATE1;
            }
            return $responsemessage;
        } catch (\Exception $th) {
            $Errors = $th->getMessage();
            return 'Error1->' . $Errors;
        }

    }

    /**
     * AuthtenticateSuperadmin It Is For The Authentication Purpose of Super Admin
     *
     * @param  mixed $username Email By Which Superadmin Need  Need To Be Find
     * @param  mixed $uid IT wil Be The UID of The SuperAdmin Users
     * @return $return It Will Return that wether Super Aadmin  is Valid Or Not
     */
    public function AuthtenticateSuperadmin($username, $uid)
    {
        try {
            $SAVELOGINREPORTS = [];
            $where[] = ['SUPEMAILID', $username];
            $loginCredentailDetails = $this->getservices->selectfunction('sup_tbl_superadmin_users', $where);
            if (count($loginCredentailDetails) > 0) {
                $UID = $loginCredentailDetails[0]->UNIQUE_ID;
                $decryptUID = Crypt::decrypt($UID);
                if ($uid == $decryptUID) {
                    $databasename = Config::get('database.connections.' . Config::get('database.default'));
                    $RoleId = 2;
                    $USERNAME = $loginCredentailDetails[0]->USERNAME;
                    $Name = $loginCredentailDetails[0]->Name;
                    $SUPEMAILID = $loginCredentailDetails[0]->SUPEMAILID;
                    $TIMEZONE = $loginCredentailDetails[0]->TIMEZONE;
                    SetTimeZone($TIMEZONE);
                    $TODAYDATE = date('Y-m-d');
                    $TODAYTIME = date(' H:i:s');
                    $LOGO = $loginCredentailDetails[0]->LOGO;
                    $SUPUSERID = $loginCredentailDetails[0]->SUPUSERID;
                    Session::put('RoleId', $RoleId);
                    Session::put('USERID', $SUPUSERID);
                    Session::put('CLIENTID', '');
                    Session::put('USERNAME', $USERNAME);
                    Session::put('Name', $Name);
                    Session::put('EMAILID', $SUPEMAILID);
                    Session::put('DATABASENAME', $databasename['database']);
                    Session::put('LOGO', $LOGO);
                    Session::put('TIMEZONE', $TIMEZONE);
                    Session::put('PROFILE', '');

                    $SAVELOGINREPORTS['SUP_USER_ID'] = $SUPUSERID;
                    $SAVELOGINREPORTS['SUP_ACTION_DATE'] = $TODAYDATE;
                    $SAVELOGINREPORTS['SUP_ACTION_TIME'] = $TODAYTIME;
                    $SAVELOGINREPORTS['STATUS'] = 'Login';
                    insertRecords($SAVELOGINREPORTS, 'sup_login_aduit_reports');
                    $ENCRYPTROLEID = Crypt::encrypt($RoleId);
                    $returnmessage = $ENCRYPTROLEID;
                } else {
                    $returnmessage = 'Invalid';
                }
            } else {
                $returnmessage = 'NotFound';
            }
            return $returnmessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
            // print_r($Errors);
            return 'Error';
        }

    }

    /**
     * saveSingledocuments It will Check Wetehr Document Name Is Allready Exits Or Not if Not Then Addd documents And Then Check Wether is Chid Document is Enable Or Not If Yes Then Create Child DOcuments And Add That Child In Documents set Table
     *
     * @param  mixed $data It will Have The Details of the Documents That need To Bee Created.
     * @return string It will Return String That Documents arre-> Created | Already | Error
     */
    public function saveSingledocuments($data)
    {
        try {
            DB::beginTransaction();
            $TIMESATAMP = date('Y:m:d H:i:s');
            $USERID = Session::get('USERID');
            $DOCUMENTNAME = $data['docname'];
            $ISPARENTDOCMUENT = $data['isparrentdoc'];
            $CHILDETAILS = $data['childdfilename'];
            $DESCRIPTION = $data['description'];
            $DOCUMENTARRY['DOCUMENT_SET_NAME'] = $DOCUMENTNAME;
            $DOCUMENTARRY['ISPARENT_DOCUMENT'] = $ISPARENTDOCMUENT;
            $DOCUMENTARRY['DOCUMENT_DESCRIPTION'] = $DESCRIPTION;
            $DOCUMENTARRY['CREATED_BY'] = $USERID;
            $DOCUMENTARRY['CREATED_DATE'] = $TIMESATAMP;

            $where[] = ['DOCUMENT_SET_NAME', $DOCUMENTNAME];
            $where[] = ['FLAG', 'Show'];
            $message = '';
            $document_set = $this->getservices->selectfunction('mst_tbl_document_set', $where);
            if (count($document_set) == 0) {
                $DOCUMENTSETID = insertRecords($DOCUMENTARRY, 'mst_tbl_document_set');
                if ($ISPARENTDOCMUENT == 'Yes') {
                    $CHILDIDS = [];
                    foreach ($CHILDETAILS as $key => $value) {
                        $where1[] = ['SUB_DOCUMENT_NAME', $value['documentname']];
                        $where1[] = ['FLAG', 'Show'];
                        $where1[] = ['DOCUMENT_SET_ID', $DOCUMENTSETID];
                        $childdoc_set = $this->getservices->selectfunction('mst_tbl_child_doc_details', $where1);
                        if (count($childdoc_set) == 0) {
                            $CHILDDOCUMENTAARY['SUB_DOCUMENT_NAME'] = $value['documentname'];
                            $CHILDDOCUMENTAARY['SUB_DOCUMENT_DESCRIPTION'] = $value['description'];
                            $CHILDDOCUMENTAARY['DOCUMENT_SET_ID'] = $DOCUMENTSETID;
                            $CHILDDOCUMENTAARY['CREATED_AT'] = $TIMESATAMP;
                            $CHILDDOCUMENTAARY['CREATED_BY'] = $USERID;
                            $CHILDIDS[] = insertRecords($CHILDDOCUMENTAARY, 'mst_tbl_child_doc_details');
                            $CHILDDOCUMENTAARY = [];
                        } else {
                            continue;
                        }
                    }
                    if (count($CHILDIDS) > 0) {
                        $IMPLODEIDS = implode(',', $CHILDIDS);
                        $UPDATEDRECORDS['CHILD_DOCUMENT_ID'] = $IMPLODEIDS;
                    } else {
                        $UPDATEDRECORDS['ISPARENT_DOCUMENT'] = 'No';
                    }
                    updateRecords($UPDATEDRECORDS, 'mst_tbl_document_set', 'ID', $DOCUMENTSETID);
                }
                DB::commit();
                $message = 'Done';
            } else {
                $message = 'Already';
            }
        } catch (\Exception $th) {
            DB::rollback();
            $message = 'Error';
        }

        return $message;
    }

    /**
     * updateDocumntsList It Will First Check Wether Doc Name is Already Exits or Not If Not Then It Will Update The Document Set And Then Check ParentChild Mode If Yes Then It Will Delete Old File And Insert New And Updated The Child Documents Id In The Doc Tabel.
     *
     * @param  mixed $data It will have Doc ID, Child Documents, ParentChild Mode, Document Mode, Descriptions
     * @return string It will return Error | Done| Already
     */
    public function updateDocumntsList($data)
    {
        try {
            DB::beginTransaction();
            $TIMESATAMP = date('Y:m:d H:i:s');
            $USERID = Session::get('USERID');
            $DOCUMENTNAME = $data['docname'];
            $ISPARENTDOCMUENT = $data['isparrentdoc'];
            $CHILDETAILS = $data['childdfilename'];
            $DESCRIPTION = $data['description'];
            $DOCID = $data['documentID'];
            if ($DOCUMENTNAME != '') {
                $DOCUMENTARRY['DOCUMENT_SET_NAME'] = $DOCUMENTNAME;
            }
            if ($DESCRIPTION != '') {
                $DOCUMENTARRY['DOCUMENT_DESCRIPTION'] = $DESCRIPTION;
            }
            $DOCUMENTARRY['ISPARENT_DOCUMENT'] = $ISPARENTDOCMUENT;
            $DOCUMENTARRY['UPDATED_BY'] = $USERID;
            $DOCUMENTARRY['UPDATED_TIME'] = $TIMESATAMP;
            $message = '';
            if ($DOCUMENTNAME != '') {
                $document_set = DB::table('mst_tbl_document_set')->where(['DOCUMENT_SET_NAME' => $DOCUMENTNAME, 'FLAG' => 'Show'])->where('ID', '!=', $DOCID)->get();
            } else {
                $document_set = [];
            }
            if (count($document_set) == 0) {
                $DOCUMENTSETID = updateRecords($DOCUMENTARRY, 'mst_tbl_document_set', 'ID', $DOCID);
                if ($DOCUMENTSETID == 'Done') {
                    if ($ISPARENTDOCMUENT == 'Yes') {
                        $where2[] = ['DOCUMENT_SET_ID', $DOCID];
                        $oldfiles_set = $this->getservices->selectfunction('mst_tbl_child_doc_details', $where2);
                        foreach ($oldfiles_set as $key => $value) {
                            // print_r($value);
                            $CHILD_DOCUMENT_ID = $value->CHILD_DOC_ID;
                            // print_r($CHILD_DOCUMENT_ID);
                            DB::table('mst_tbl_child_doc_details')->where('CHILD_DOC_ID', $CHILD_DOCUMENT_ID)->delete();
                        }
                        $CHILDIDS = [];
                        foreach ($CHILDETAILS as $key => $value) {
                            $where1[] = ['SUB_DOCUMENT_NAME', $value['documentname']];
                            $where1[] = ['FLAG', 'Show'];
                            $where1[] = ['DOCUMENT_SET_ID', $DOCID];
                            $childdoc_set = $this->getservices->selectfunction('mst_tbl_child_doc_details', $where1);
                            if (count($childdoc_set) == 0) {
                                $CHILDDOCUMENTAARY['SUB_DOCUMENT_NAME'] = $value['documentname'];
                                $CHILDDOCUMENTAARY['SUB_DOCUMENT_DESCRIPTION'] = $value['description'];
                                $CHILDDOCUMENTAARY['DOCUMENT_SET_ID'] = $DOCID;
                                $CHILDDOCUMENTAARY['CREATED_AT'] = $TIMESATAMP;
                                $CHILDDOCUMENTAARY['CREATED_BY'] = $USERID;
                                $CHILDIDS[] = insertRecords($CHILDDOCUMENTAARY, 'mst_tbl_child_doc_details');
                                $CHILDDOCUMENTAARY = [];
                            } else {
                                continue;
                            }
                        }
                        if (count($CHILDIDS) > 0) {
                            $IMPLODEIDS = implode(',', $CHILDIDS);
                            $UPDATEDRECORDS['CHILD_DOCUMENT_ID'] = $IMPLODEIDS;
                        } else {
                            $UPDATEDRECORDS['ISPARENT_DOCUMENT'] = 'No';
                        }
                        updateRecords($UPDATEDRECORDS, 'mst_tbl_document_set', 'ID', $DOCID);
                    }
                    DB::commit();
                    $message = 'Done';
                } else {
                    DB::rollback();
                    $message = 'Error';
                }
            } else {
                $message = 'Already';
            }
        } catch (\Exception $th) {
            DB::rollback();
            print_r($th->getMessage());
            $message = 'Errossr';
        }

        return $message;
    }



}
