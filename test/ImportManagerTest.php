<?php
namespace Test;

require "/home/vagrant/gac-test/manager/ImportManager.php";
require "/home/vagrant/gac-test/dbTable/DetailAppelsDbTable.php";



use DbTable\DetailAppelsDbTable;
use Manager\ImportManager;
use PHPUnit\Framework\TestCase;

class ImportManagerTest extends TestCase {

    public function testFormatDate() {
        $importManager = new ImportManager();
        $result = $importManager->formatDate("09/02/2012");
        $this->assertEquals("2012-02-09", $result);

        $result = $importManager->formatDate("");
        $this->assertFalse($result);
    }

    public function testFormatHour() {
        $importManager = new ImportManager();
        $result = $importManager->formatHour("14:45:12");
        $this->assertEquals("14:45:12", $result);

        $result = $importManager->formatHour("");
        $this->assertFalse($result);

        $result = $importManager->formatHour("error");
        $this->assertFalse($result);
    }

    public function testLauchImport() {
        $importManager = new ImportManager();
        $dbTable = new DetailAppelsDbTable();

        $dbTable->clearTable();

        $count = $importManager->launchImport();
        $sql = "SELECT COUNT(*) FROM detail_appels";
        $result = $dbTable->dbManager->query($sql)->fetch_row();

        $this->assertEquals($count, $result[0]);
    }
}