<?php
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

if (!function_exists('SetTimeZone')) {

    /**
     * SetTimeZone It for The Seting The Time Zone
     *
     * @param  mixed $zone It Is Zone Which Has To Be Set
     * @return void
     */
    function SetTimeZone($zone)
    {
        date_default_timezone_set($zone);
    }
}

if (!function_exists('Setthedatabase')) {

    /**
     * For Seting The Dataabse.
     *
     * @param  mixed $databasename Databsename By Wich We Have To Set Database
     * @return void
     */
    function Setthedatabase($databasename)
    {
        DB::disconnect('mysql');
        Config::set('database.connections.dynamicsql.database', $databasename);
        Config::set('database.default', 'dynamicsql');
    }
}

if (!function_exists('insertRecords')) {

    /**
     * This Function is to Save the Details
     * and Send Response
     * @param $data \Illuminate\Http\Request  $data will Have All Data To insert.
     * @param $tablename \Illuminate\Http\Request  $tablename Tabel Name.
     * @return \Illuminate\Http\Response Return The Id Of The Record Inserted.
     */
    function insertRecords($data, $tablename)
    {
        $insert = DB::table($tablename)->insertGetId($data);
        return $insert;
    }
}

if (!function_exists('updateRecords')) {

    /**
     * updateRecords It Will Update The Details
     *
     * @param  mixed $data It is a Data That Is Updated.
     * @param  mixed $tablename tabel which Need To Be Update
     * @param  mixed $uniquecloumn Unique Column name By Which row Will Update (It is Primary Key);
     * @param  mixed $uniquecloumnvalue Unique Column Value .(It is Primary Key Value);
     * @return string It Will return Messgge that Record is Updated Or Send That Error Founded.
     */
    function updateRecords($data, $tablename, $uniquecloumn, $uniquecloumnvalue)
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
}

if (!function_exists('multiUpdateRecords')) {
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
    function multiUpdateRecords($data, $tablename, $uniquecloumn, $uniquecloumnvalue, $type)
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
}

if (!function_exists('rawSqlQuery')) {
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
        function rawSqlQuery($sql)
        {
            $queryDetalis = DB::select($sql);
            return $queryDetalis;
        }
    }



