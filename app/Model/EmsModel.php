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
     * This Function is to Save the Details
     * and Send Response
     * @param $data \Illuminate\Http\Request  $data will Have All Data To insert.
     * @param $tablename \Illuminate\Http\Request  $tablename Tabel Name.
     * @return \Illuminate\Http\Response Return The Id Of The Record Inserted.
     */
    public function insertRecords($data, $tablename)
    {
        $insert = DB::table($tablename)->insertGetId($data);
        return $insert;
    }

    /**
     * updateRecords It Will Update The Details
     *
     * @param  mixed $data It is a Data That Is Updated.
     * @param  mixed $tablename tabel which Need To Be Update
     * @param  mixed $uniquecloumn Unique Column name By Which row Will Update (It is Primary Key);
     * @param  mixed $uniquecloumnvalue Unique Column Value .(It is Primary Key Value);
     * @return string It Will return Messgge that Record is Updated Or Send That Error Founded.
     */
    public function updateRecords($data, $tablename, $uniquecloumn, $uniquecloumnvalue)
    {

        try {
            DB::table($tablename)->where($uniquecloumn, $uniquecloumnvalue)->update($data);
            $message = 'Done';
        } catch (\Exception $th) {
            $ERROR = $th->getMessage();
            $message = $ERROR;
            //throw $th;
        }

        return $message;
    }

    /**
     * multiUpdateRecords It Will Update MultiRecords Based On WhereIn And WherenotIn
     *
     * @param  mixed $data The Data Wich need to Be Updated
     * @param  mixed $tablename Tabel On Wich Data is Updated
     * @param  mixed $uniquecloumn Unique Column name By Which row Will Update (It is Primary Key);
     * @param  mixed $uniquecloumnvalue Unique Column Value .(It is Primary Key) But It is Aary Of Values
     * @param  mixed $type It will tell Wether We have To Aplly WhereIn OR WherNOtIn Condition.
     * @return string It Will return Messgge that Record is Updated Or Send That Error Founded.
     */
    public function multiUpdateRecords($data, $tablename, $uniquecloumn, $uniquecloumnvalue,$type)
    {
        try {
            DB::table($tablename)->$type($uniquecloumn, $uniquecloumnvalue)->update($data);
            $message = 'Done';
        } catch (\Exception $th) {
            $ERROR = $th->getMessage();
            $message = $ERROR;
            //throw $th;
        }
        return $message;
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
            // print_r(Crypt::decrypt($loginCredentailDetails[0]->AUTHENTICATION_START));
            // date_default_timezone_set('Asia/Kolkata');
            $getTodaysDateToAuthenticate = date("Y-m-d");
            $returnmessage = '';
            if (count($loginCredentailDetails) > 0) {
                $RoleId = $loginCredentailDetails[0]->ROLEID;
                $USERID = $loginCredentailDetails[0]->USERID;
                $CLIENTID = $loginCredentailDetails[0]->CLIENTID;
                $USERNAME = $loginCredentailDetails[0]->USERNAME;
                $EMAILID = $loginCredentailDetails[0]->EMAILID;
                $getPrefix = $loginCredentailDetails[0]->PREFIX;
                $ZONE = $loginCredentailDetails[0]->PREFIX;
                $START = $loginCredentailDetails[0]->AUTHENTICATION_START;
                $END = $loginCredentailDetails[0]->AUTHENTICATION_END;
                if ($RoleId == 1) {
                    $Password = $loginCredentailDetails[0]->USERPASSWORD;
                    $getDecryptPassword = Crypt::decrypt($Password);
                    $databasename = Config::get('database.connections.' . Config::get('database.default'));
                    if ($userPasword == $getDecryptPassword) {
                        Session::put('RoleId', $RoleId);
                        Session::put('USERID', $USERID);
                        Session::put('CLIENTID', $CLIENTID);
                        Session::put('USERNAME', $USERNAME);
                        Session::put('EMAILID', $EMAILID);
                        Session::put('DATABASENAME', $databasename['database']);
                        $returnmessage = $RoleId;
                    } else {
                        $returnmessage = 'NotMatch';
                    }
                } else {
                    $databasename = Config::get('database.connections.' . Config::get('database.default'));
                    $getdynamicdatabsename = $getPrefix . '_management';
                    $this->getservices->Setthedatabase($getdynamicdatabsename);
                    $selectwhere[] = ['EMAILID', $username];
                    $getuserDetails = $this->getservices->selectfunction('mst_tbl_users', $selectwhere);
                    $Password = $getuserDetails[0]->PASSWORDS;
                    $ADMINRIGHTS = $getuserDetails[0]->ADMINRIGHTS;
                    $getDecryptPassword = Crypt::decrypt($Password);
                    if ($userPasword == $getDecryptPassword) {
                        $AUTHENTICATION_START = Crypt::decrypt($START);
                        $AUTHENTICATION_END = Crypt::decrypt($END);
                        $getAuthentications1 = $this->getservices->AUTHENTICATION($getTodaysDateToAuthenticate, $AUTHENTICATION_START, 'Start');
                        if ($getAuthentications1 == 1) {
                            $getAuthentications2 = $this->getservices->AUTHENTICATION($getTodaysDateToAuthenticate, $AUTHENTICATION_END, 'End');
                            if ($getAuthentications2 == 1) {
                                Session::put('USERID', $USERID);
                                Session::put('CLIENTID', $CLIENTID);
                                Session::put('USERNAME', $USERNAME);
                                Session::put('EMAILID', $EMAILID);
                                Session::put('TIMEZONE', $ZONE);
                                Session::put('PREFIX', $getPrefix);
                                Session::put('DATABASENAME', $getdynamicdatabsename);
                                Session::put('ORIGNALDATABASENAME', $databasename['database']);
                                if ($RoleId == 3) {
                                    if ($ADMINRIGHTS == 'Yes') {
                                        $returnmessage = 'Both';
                                    } else {
                                        Session::put('RoleId', $RoleId);
                                        $returnmessage = $RoleId;
                                    }
                                } else {
                                    Session::put('RoleId', $RoleId);
                                    $returnmessage = $RoleId;
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
            return 'Error' . $Errors;
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
            $responsemessage = '';

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

                                $CLIENTID = $this->insertRecords($SUPDETAILS, 'sup_tbl_all_client');
                                /** Save Records In sup_tbl_login_credential*/
                                $LOGINCREDENTIALS['CLIENTID'] = $CLIENTID;
                                $LOGINCREDENTIALS['EMAILID'] = $admin_emailid;
                                $LOGINCREDENTIALS['ROLEID'] = '2';
                                $LOGINCREDENTIALS['CREATED_AT'] = $timestamp;
                                $LOGINCREDENTIALS['AUTHENTICATION_START'] = $encryptStartDate;
                                $LOGINCREDENTIALS['AUTHENTICATION_END'] = $encryptDate;
                                $LOGINCREDENTIALS['PREFIX'] = $client_prefix;
                                $userId = $this->insertRecords($LOGINCREDENTIALS, 'sup_tbl_login_credential');
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
                                        /** Save Records In The mst_tbl_users */
                                        $USERDETAILS['FULLNAME'] = $admin_name;
                                        $USERDETAILS['MOBLIENO'] = $contatct_info;
                                        $USERDETAILS['EMAILID'] = $admin_emailid;
                                        $USERDETAILS['PASSWORDS'] = $encrypt_password;
                                        $USERDETAILS['EMPCODE'] = $empcode_format;
                                        $USERDETAILS['CREATED_AT'] = $timestamp;
                                        $USERDETAILS['ROLEID'] = '2';
                                        DB::disconnect('mysql');
                                        Config::set('database.connections.mysql.database', $databsename);
                                        $userId = $this->insertRecords($USERDETAILS, 'mst_tbl_users');
                                        /** Save Records In The mst_tbl_company_information */
                                        $COMPONYINFO['COMPANYLOGO'] = $companylogo;
                                        $COMPONYINFO['COMPANYNAME'] = $company_name;
                                        $COMPANYID = $this->insertRecords($COMPONYINFO, 'mst_tbl_company_information');
                                        if ($COMPANYID > 0) {
                                            Config::set('database.connections.mysql.database', $originalDB);
                                            Config::set('database.default', 'mysql');
                                            $responsemessage = 'DONE';
                                        }

                                    } catch (\Exception $e) {
                                        $Errors = $e->getMessage();
                                        $responsemessage = 'Error1->' . $Errors;
                                    }
                                } catch (\Exception $e) {
                                    $Errors = $e->getMessage();
                                    $responsemessage = 'ErrorInDB->' . $Errors;
                                }
                            } catch (\Exception $e) {
                                $Errors = $e->getMessage();
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
            return $responsemessage;
        } catch (\Exception $e) {
            $Errors = $e->getMessage();
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

                        $UPDATE1 = $this->updateRecords($SUPDETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENT_ID);
                        if ($UPDATE1 == 'Done') {
                            /** Fetch The Login Credential Detils */
                            $FETCHGETLOGINCREDENTIALDETAILS = DB::table('sup_tbl_login_credential')
                                ->where(['EMAILID' => $ADMINEMAILID])->first();
                            $FETChUSERID = $FETCHGETLOGINCREDENTIALDETAILS->USERID;
                            /** Update Records In sup_tbl_login_credential*/
                            $LOGINCREDENTIALS['CLIENTID'] = $CLIENT_ID;
                            $LOGINCREDENTIALS['EMAILID'] = $admin_emailid;
                            $LOGINCREDENTIALS['ROLEID'] = '2';
                            $LOGINCREDENTIALS['UPDATEDAT'] = $timestamp;
                            $LOGINCREDENTIALS['AUTHENTICATION_START'] = $encryptStartDate;
                            $LOGINCREDENTIALS['AUTHENTICATION_END'] = $encryptDate;
                            $UPDATE2 = $this->updateRecords($LOGINCREDENTIALS, 'sup_tbl_login_credential', 'USERID', $FETChUSERID);
                            if ($UPDATE2 == 'Done') {
                                $this->getservices->Setthedatabase($CLIENTDATABASENAME);
                                /** Update Records In The mst_tbl_users */
                                $USERDETAILS['FULLNAME'] = $admin_name;
                                $USERDETAILS['MOBLIENO'] = $contatct_info;
                                $USERDETAILS['EMAILID'] = $admin_emailid;
                                $USERDETAILS['PASSWORDS'] = $encrypt_password;
                                $USERDETAILS['EMPCODE'] = $empcode_format;
                                $USERDETAILS['UPDATED_AT'] = $timestamp;
                                $USERDETAILS['ROLEID'] = '2';
                                $UPDATE3 = $this->updateRecords($USERDETAILS, 'mst_tbl_users', 'EMAILID', $ADMINEMAILID);
                                if ($UPDATE3 == 'Done') {
                                    /** Update  Records In The mst_tbl_company_information if Not Prsent Then Add it*/
                                    $COMPANYDETAILS = DB::table('mst_tbl_company_information')->where(['FLAG' => 'Show'])->get();
                                    $COMPONYINFO['COMPANYLOGO'] = $companylogo;
                                    $COMPONYINFO['COMPANYNAME'] = $company_name;
                                    if (count($COMPANYDETAILS) > 0) {
                                        $COMPANY_ID = $COMPANYDETAILS[0]->COMPANY_ID;
                                        $UPDATE4 = $this->updateRecords($COMPONYINFO, 'mst_tbl_company_information', 'COMPANY_ID', $COMPANY_ID);
                                        if ($UPDATE4 == 'Done') {
                                            $responsemessage = 'DONE';
                                        } else {
                                            $responsemessage = 'Error' . $UPDATE4;
                                        }
                                    } else {
                                        $COMPANYID = $this->insertRecords($COMPONYINFO, 'mst_tbl_company_information');
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
            $UPDATE1 = $this->updateRecords($DETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $DECRYPTCLIENTID);
            if ($UPDATE1 == 'Done') {
                /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_login_credential */
                $UPDATE2 = $this->updateRecords($DETAILS, 'sup_tbl_login_credential', 'CLIENTID', $DECRYPTCLIENTID);
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
            $UPDATE1 = $this->updateRecords($UPDATEDETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENTID);
            if ($UPDATE1 == 'Done') {
                /** This Is Update Function Which Will Delete All Client Details By Updating Flag in sup_tbl_login_credential */
                $UPDATE2 = $this->updateRecords($UPDATEDETAILS, 'sup_tbl_login_credential', 'CLIENTID', $CLIENTID);
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
            $UPDATE1 = $this->updateRecords($ClientDETAILS, 'sup_tbl_all_client', 'CLIENT_ID', $CLIENTID);
            if ($UPDATE1 == 'Done') {
                /** Update In Login Credentails Tabel sup_tbl_login_credentials */
                $LOGINDETAILS['AUTHENTICATION_START'] = $startdate;
                $LOGINDETAILS['AUTHENTICATION_END'] = $expiry_date;
                $UPDATE2 = $this->updateRecords($LOGINDETAILS, 'sup_tbl_login_credential', 'CLIENTID', $CLIENTID);
                if ($UPDATE2 == 'Done') {
                    $responsemessage = 'DONE';
                }else {
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
}
