<?php
namespace Manager;

use mysqli;

class DbManager {
    private $servername = "localhost";
    private $username = "homestead";
    private $password = "secret";
    private $dbname = "homestead";
    public $dbAdapter = false;

    /**
     * DbManager constructor.
     */
    public function __construct() {
        $this->dbAdapter = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function query($sql) {
        $result = $this->dbAdapter->query($sql);
        return $result;
    }
}