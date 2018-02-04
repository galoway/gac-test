<?php

namespace DbTable;

require "./manager/DbManager.php";

use Manager\DbManager;

class DetailAppelsDbTable {
    const tableName = "detail_appels";
    const colCompteF = "compte_facture";
    const colNumF = "num_facture";
    const colNumA = "num_abonne";
    const colDate = "date";
    const colDuree = "duree";
    const colVolume = "volume";
    const colType = "type";
    const colHeure = 'heure';
    const type_appel = 1;
    const type_sms = 2;
    const type_data = 3;

    public $dbManager;

    public function __construct(DbManager $dbManager = null) {
        if(is_null($dbManager)) {
            $this->dbManager = new DbManager();
        } else {
            $this->dbManager = $dbManager;
        }
    }

    public function isEmpty() {
        $sql = "SELECT * FROM ".self::tableName;
        $result = $this->dbManager->query($sql);
        if($result) {
            $result = $result->fetch_all();
            if(!empty($result)){
                return false;
            }
        }
        return true;
    }

    public function clearTable() {
        $sql = "TRUNCATE TABLE `".self::tableName."`";
        return $this->dbManager->query($sql);
    }

    public function insertDataSMS($data) {
        $sql = "INSERT INTO ".self::tableName." (`".self::colCompteF."`, `".self::colNumF."`, `".self::colNumA."`, 
        `".self::colDate."`, `".self::colHeure."`, `".self::colType."`)
VALUES (".$data[self::colCompteF].",".$data[self::colNumF].",".$data[self::colNumA].",";
        if($data[self::colDate] === false) {
            $sql = $sql."NULL,";
        } else {
            $sql = $sql."'".$data[self::colDate]."',";
        }
        if($data[self::colHeure] === false) {
            $sql = $sql."NULL,";
        } else {
            $sql = $sql."'".$data[self::colHeure]."',";
        }
        $sql = $sql.$data[self::colType].")";
        return $this->dbManager->query($sql);
    }

    public function insertDataAppel($data) {
        $sql = "INSERT INTO ".self::tableName." (`".self::colCompteF."`, `".self::colNumF."`, `".self::colNumA."`, 
        `".self::colDate."`, `".self::colHeure."`, `".self::colDuree."`, `".self::colType."`)
VALUES (".$data[self::colCompteF].",".$data[self::colNumF].",".$data[self::colNumA].",";
        if($data[self::colDate] === false) {
            $sql = $sql."NULL,";
        } else {
            $sql = $sql."'".$data[self::colDate]."',";
        }
        if($data[self::colHeure] === false) {
            $sql = $sql."NULL,";
        } else {
            $sql = $sql."'".$data[self::colHeure]."',";
        }
        $sql = $sql."'".$data[self::colDuree]."',".$data[self::colType].")";
        return $this->dbManager->query($sql);
    }

    public function insertDataData($data) {
        $sql = "INSERT INTO ".self::tableName." (`".self::colCompteF."`, `".self::colNumF."`, `".self::colNumA."`, 
        `".self::colDate."`, `".self::colHeure."`, `".self::colVolume."`, `".self::colType."`)
VALUES (".$data[self::colCompteF].",".$data[self::colNumF].",".$data[self::colNumA].",";
        if($data[self::colDate] === false) {
            $sql = $sql."NULL,";
        } else {
            $sql = $sql."'".$data[self::colDate]."',";
        }
        if($data[self::colHeure] === false) {
            $sql = $sql."NULL,";
        } else {
            $sql = $sql."'".$data[self::colHeure]."',";
        }
        $sql = $sql.$data[self::colVolume].",".$data[self::colType].")";
        return $this->dbManager->query($sql);
    }

    public function getTimeCall($date) {
        $sql = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `".self::colDuree."` ) ) ) AS totaltime FROM ".self::tableName." WHERE type = ".self::type_appel." AND date >= '".$date."' GROUP BY ".self::colNumA;
        $result = $this->dbManager->query($sql);
        if($result) {
            $result = $result->fetch_array();
            return $result['totaltime'];
        }
        return "00:00:00";
    }

    public function getTotalSms() {
        $sql = "SELECT COUNT(*) AS totalsms FROM ".self::tableName." WHERE type = ".self::type_sms;
        $result = $this->dbManager->query($sql);
        if($result) {
            $result = $result->fetch_array();
            return $result['totalsms'];
        }
        return 0;
    }

    public function getTotalVolumeBySub($top = 10) {
        $sql = "SELECT ".self::colNumA.", SUM(".self::colVolume.") totalvolume FROM ".self::tableName." WHERE ".self::colType." = ".self::type_data." 
        AND (".self::colHeure." < '08:00:00' OR ".self::colHeure." > '18:00:00') 
        GROUP BY ".self::colNumA." ORDER BY totalvolume DESC LIMIT ".$top;

        $result = $this->dbManager->query($sql);
        if($result) {
            while($row = $result->fetch_assoc())
            {
                $rows[] = $row;
            }
            return $rows;
        }
        return null;
    }
}