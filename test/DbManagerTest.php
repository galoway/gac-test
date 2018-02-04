<?php
namespace Test;

require "/home/vagrant/gac-test/manager/DbManager.php";

use PHPUnit\Framework\TestCase;
use Manager\DbManager;
use mysqli;

final class DbManagerTest extends TestCase {

    public function testDbConnection() {
        $dbManager = new DbManager();
        $this->assertInstanceOf(mysqli::class, $dbManager->dbAdapter) ;
    }
}