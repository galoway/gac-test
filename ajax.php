<?php
require "./dbTable/DetailAppelsDbTable.php";
require "./manager/ImportManager.php";
require_once "./vendor/autoload.php";

use DbTable\DetailAppelsDbTable;
use Manager\ImportManager;


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'clear':
            $dbTable = new DetailAppelsDbTable();
            $dbTable->clearTable();
            break;
        case 'import':
            $importManager = new ImportManager();
            try {
                $importManager->launchImport();
            } catch (\Box\Spout\Common\Exception\IOException $e) {
            } catch (\Box\Spout\Common\Exception\UnsupportedTypeException $e) {
            } catch (\Box\Spout\Reader\Exception\ReaderNotOpenedException $e) {
            }
            break;
    }
}