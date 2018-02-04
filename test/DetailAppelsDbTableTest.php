<?php
namespace Test;

require "/home/vagrant/gac-test/dbTable/DetailAppelsDbTable.php";

use DbTable\DetailAppelsDbTable;
use PHPUnit\Framework\TestCase;

final class DetailAppelsDbTableTest extends TestCase {

    public function testClearTable() {
        $dbTable = new DetailAppelsDbTable();
        $this->assertTrue($dbTable->clearTable());
    }

    public function testIsEmpty() {
        $dbTable = new DetailAppelsDbTable();
        $this->assertTrue($dbTable->isEmpty());
    }

    public function testInsertDataAppel() {
        $dbTable = new DetailAppelsDbTable();
        $date = new \DateTime();
        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => $date->format("Y-m-d"),
            'heure' => $date->format("H:i:s"),
            'duree' => '00:13:11',
            'type' => 1
        );
        $result = $dbTable->insertDataAppel($data);
        $this->assertTrue($result);

        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => false,
            'heure' => $date->format("H:i:s"),
            'duree' => '00:13:11',
            'type' => 1
        );
        $result = $dbTable->insertDataAppel($data);
        $this->assertTrue($result);

        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => $date->format("Y-m-d"),
            'heure' => false,
            'duree' => '00:13:11',
            'type' => 1
        );
        $result = $dbTable->insertDataAppel($data);
        $this->assertTrue($result);
    }

    public function testInsertDataSms() {
        $dbTable = new DetailAppelsDbTable();
        $date = new \DateTime();
        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => $date->format("Y-m-d"),
            'heure' => $date->format("H:i:s"),
            'type' => 2
        );
        $result = $dbTable->insertDataSMS($data);
        $this->assertTrue($result);

        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => false,
            'heure' => $date->format("H:i:s"),
            'type' => 2
        );
        $result = $dbTable->insertDataSMS($data);
        $this->assertTrue($result);

        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => $date->format("Y-m-d"),
            'heure' => false,
            'type' => 2
        );
        $result = $dbTable->insertDataSMS($data);
        $this->assertTrue($result);
    }

    public function testInsertDataData() {
        $dbTable = new DetailAppelsDbTable();
        $date = new \DateTime();
        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => $date->format("Y-m-d"),
            'heure' => $date->format("H:i:s"),
            'volume' => 15,
            'type' => 3
        );
        $result = $dbTable->insertDataData($data);
        $this->assertTrue($result);

        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => false,
            'heure' => $date->format("H:i:s"),
            'volume' => 15,
            'type' => 3
        );
        $result = $dbTable->insertDataData($data);
        $this->assertTrue($result);

        $data = array(
            'compte_facture' => 12345,
            'num_facture' => 12345,
            'num_abonne' => 12345,
            'date' => $date->format("Y-m-d"),
            'heure' => false,
            'volume' => 15,
            'type' => 3
        );
        $result = $dbTable->insertDataData($data);
        $this->assertTrue($result);
    }

    public function testGetTotalSms() {
        $dbTable = new DetailAppelsDbTable();
        $result = $dbTable->getTotalSms();
        $this->assertEquals(3, $result);
    }

    public function testGetVolumeBySub() {
        $dbTable = new DetailAppelsDbTable();
        $result = $dbTable->getTotalVolumeBySub();
        $this->assertEquals(12345, $result[0]['num_abonne']);
        $this->assertEquals(45, $result[0]['totalvolume']);
    }

    public function testGetTimeCall() {
        $dbTable = new DetailAppelsDbTable();
        $result = $dbTable->getTimeCall("2012-02-15");
        $this->assertEquals("00:26:22", $result);
    }

}