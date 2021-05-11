<?php

namespace App\Services;

use App\Services\Service;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class implementServices implements Service
{
    /**
     * It is select Function For The  Select Query .
     *
     * @param  mixed $tablename This The Tabel Name of Which We Want Records
     * @param  mixed $whereconditions all The Where Conditions Of Which Records To fetch.
     * @return $All The Data Of The Query.
     */
    public function selectfunction($tablename, $whereconditions)
    {
        $selectfunction = DB::table($tablename)
            ->where($whereconditions)->get();
        return $selectfunction;
    }





    /**
     * AUTHENTICATION It for Finding WHether A Date Is Present In Bwetwen two Dates
     * if Type Is Satart Then It Will Look For Wether Date Is Gertor Then Other Date
     * and If Type Is Less Then It Will Look Wether Date Is less Then Other Dates
     *
     * @param  mixed $FirstDate It Is Todays Date
     * @param  mixed $ChekingDate It Is Other Date Wchich We Have To Che
     * @param  mixed $type Type Of Conditions For What Condition You Require The Data
     * For Finding Data To Be Grater Pass Start In Type And For Lesser Pass End As Type.
     * @return true or False
     */
    public function AUTHENTICATION($FirstDate, $ChekingDate, $type)
    {
        if ($type == 'Start') {
            if ($FirstDate >= $ChekingDate) {
                return 1;
            } else {
                return 0;
            }
        }
        if ($type == 'End') {
            if ($FirstDate <= $ChekingDate) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    /**
     * checkpastDate It will Check That Date Is Passed From The Todays Date Or Not
     *
     * @param  mixed $date It is First Date it Should Be Less Then Second Date.
     * @param  mixed $secondDate It is a Second Date.
     * @return string It will Retrun Message wether Date Passed From today Date.
     */
    public function checkpastDate($date, $secondDate)
    {
        $date = new DateTime($date);
        $now = new DateTime($secondDate);
        if ($date < $now) {
            $message = 'Past';
            // echo 'date is in the past';
        } else {
            $message = 'Future';
        }
        return $message;
    }

    /**
     * codeToTakeBackupofDB THis is To Take Backup for Databse
     *
     * @param  mixed $originalDB It is Name Of The Database
     * @return string It will Return the Sql Query Of The Given Database.
     */
    public function codeToTakeBackupofDB($originalDB)
    {
        Setthedatabase($originalDB);
        $targetTables = [];
        $newLine = "\r\n";
        $queryTables = DB::select("SELECT  table_name FROM information_schema.tables WHERE table_schema = '$originalDB'  ORDER BY table_name");
        $i = 0;
        foreach ($queryTables as $key => $value) {
            $aaryofDetails[$key] = $value;
            $targetTables[] = $aaryofDetails[$i]->table_name;
            $i++;
        }
        $content = '';
        foreach ($targetTables as $table) {
            $tableData = DB::select(DB::raw('SELECT * FROM ' . $table));
            $res1 = (array) DB::select(DB::raw('SHOW CREATE TABLE ' . $table));
            $table123 = "Create Table";
            $res = (array) $res1[0];

            $cnt = 0;
            $content = (!isset($content) ? '' : $content) . $res["Create Table"] . ";" . $newLine . $newLine;
            foreach ($tableData as $row) {
                $subContent = "";
                $firstQueryPart = "";
                if ($cnt == 0 || $cnt % 100 == 0) {
                    $firstQueryPart .= "INSERT INTO {$table} VALUES ";
                    if (count($tableData) > 1) {
                        $firstQueryPart .= $newLine;
                    }

                }

                $valuesQuery = "(";
                foreach ($row as $key => $value) {
                    $valuesQuery .= "'" . $value . "'" . ", ";
                }

                $subContent = $firstQueryPart . rtrim($valuesQuery, ", ") . ")";

                if ((($cnt + 1) % 100 == 0 && $cnt != 0) || $cnt + 1 == count($tableData)) {
                    $subContent .= ";" . $newLine;
                } else {
                    $subContent .= ",";
                }

                $content .= $subContent;
                $cnt++;
            }
            $content .= $newLine;
        }
        return $content;
    }

    /**
     * getAllTimezone This will give all Time Zone
     *
     * @return array  It will Return the All Time Zone with Its Region.
     */
    public function getAllTimezone()
    {
        $zoneIdentifiers = timezone_identifiers_list();
        $zoneLocations = array();

        foreach ($zoneIdentifiers as $zoneIdentifier) {
            $zone = explode('/', $zoneIdentifier);
            $desiredRegions = array(
                'Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific',
            );
            if (in_array($zone[0], $desiredRegions)) {
                if (isset($zone[1]) != '') {
                    $area = str_replace('_', ' ', $zone[1]);
                    if (!empty($zone[2])) {
                        $area = $area . ' (' . str_replace('_', ' ', $zone[2]) . ')';
                    }
                    $zoneLocations[$zone[0]][$zoneIdentifier] = $zone[0] . '/' . $area;
                }
            }
        }

        $selectOptions = "";
        $TIMEZONE = [];

        foreach ($zoneLocations as $zoneRegion => $regionAreas) {
            $REGIONAREA = [];
            // print_r($zoneRegion);
            foreach ($regionAreas as $regionArea => $zoneLabel) {
                $CREATEVALUEARRY = [];
                $currentTimeInZone = new DateTime("now", new DateTimeZone($regionArea));
                $currentTimeDiff = $currentTimeInZone->format('P');
                $selectOptions .= "<option value=\"$regionArea\">(GMT $currentTimeDiff) $zoneLabel</option>\n";
                $LABELE = '( GMT'.  $currentTimeDiff . ') '. $zoneLabel;
                $CREATEVALUEARRY[] = $regionArea;
                $CREATEVALUEARRY[] = $LABELE;
                $REGIONAREA[] = $CREATEVALUEARRY;

            }
            $TIMEZONE[$zoneRegion]= $REGIONAREA;
            // echo "----------------";
        }
        return $TIMEZONE;

    }
}
