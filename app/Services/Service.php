<?php

namespace App\Services;

interface Service
{

    /**
     * Abbstract Class of The Select Function.
     *
     * @param  mixed $tablename Tabel name of The Query
     * @param  mixed $whereconditions Aarry of all Where Conditions;
     * @return void
     */
    public function selectfunction($tablename, $whereconditions);

    /**
     * Abbstract Class  For Seting The Dataabse.
     *
     * @param  mixed $databasename Databsename By Wich We Have To Set Database
     * @return void
     */
    // public function Setthedatabase($databasename);

    /**
     * Abbstract Class  For Finding Date is Greater or lesser.
     *
     * @param  mixed $AUthenticationStart It is Date 1
     * @param  mixed $AUthenticationEnd It is Date 2
     * @param  mixed $type It is The Type That What You Want Greater Or Lesser
     * @return void
     */
    public function AUTHENTICATION($AUthenticationStart,$AUthenticationEnd,$type);



    /**
     * checkpastDate It will Check That Date Is Passed From The Todays Date Or Not
     *
     * @param  mixed $date It is First Date it Should Be Less Then Second Date.
     * @param  mixed $secondDate It is a Second Date.
    * @return string It will Retrun Message wether Date Passed From today Date.
     */
    public function checkpastDate($date, $seconddate);


     /**
     * codeToTakeBackupofDB THis is To Take Backup for Databse
     *
     * @param  mixed $originalDB It is Name Of The Database
     * @return string It will Return the Sql Query Of The Given Database.
     */
    public function codeToTakeBackupofDB($originalDB);


    /**
     * getAllTimezone This will give all Time Zone
     *
     *  @return array  It will Return the All Time Zone with Its Region.
     */
    public function getAllTimezone();





}
