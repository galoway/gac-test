<?php
namespace Manager;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use DbTable\DetailAppelsDbTable;


class ImportManager {
    private $filePath = "./tickets_appels_201202.csv";


    /**
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    public function launchImport() {
        $reader = ReaderFactory::create(Type::CSV);
        $reader->setFieldDelimiter(';');
        $reader->open($this->filePath);
        $count = 0;
        $dbTable = new DetailAppelsDbTable();
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $line => $row) {
                // les 3 première lignes du fichier ne sont pas utile, SKIP
                if($line <= 3) {
                    continue;
                }
                $data[DetailAppelsDbTable::colCompteF] = $row[0];
                $data[DetailAppelsDbTable::colNumF] = $row[1];
                $data[DetailAppelsDbTable::colNumA] = $row[2];
                $data[DetailAppelsDbTable::colDuree] = $row[5];
                $data[DetailAppelsDbTable::colVolume] = $row[6];
                $data['type_detail'] = $row[7];

                $data[DetailAppelsDbTable::colDate] = $this->formatDate($row[3]);
                $data[DetailAppelsDbTable::colHeure] = $this->formatHour($row[4]);
                if(stripos($data['type_detail'], "appel") !== false) {
                    $data[DetailAppelsDbTable::colType] = DetailAppelsDbTable::type_appel;
                    $dbTable->insertDataAppel($data);
                } elseif (stripos($data['type_detail'], "sms") !== false) {
                    $data[DetailAppelsDbTable::colType] = DetailAppelsDbTable::type_sms;
                    $dbTable->insertDataSMS($data);
                } else {
                    $data[DetailAppelsDbTable::colType] = DetailAppelsDbTable::type_data;
                    $data[DetailAppelsDbTable::colVolume] = intval($data[DetailAppelsDbTable::colVolume]);
                    $dbTable->insertDataData($data);
                }
                $count++;
            }
        }
        return $count;
    }

    public function formatDate($dt) {

        $date = \DateTime::createFromFormat("d/m/Y", $dt);

        if($date === false) {
            return false;
        }
        $dateFormated = $date->format("Y-m-d");
        return $dateFormated;
    }

    public function formatHour($ht) {
        $hour = \DateTime::createFromFormat("H:i:s", $ht);

        if($hour === false) {
            return false;
        }
        $hourFormated = $hour->format("H:i:s");
        return $hourFormated;
    }
}