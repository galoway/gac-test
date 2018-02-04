<?php
require "./dbTable/DetailAppelsDbTable.php";
require_once "./vendor/autoload.php";

use DbTable\DetailAppelsDbTable;

$dbTable = new DetailAppelsDbTable();
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="button.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="loader" style="display: none;">
        <img src="loader.gif">
    </div>
    <?php if($dbTable->isEmpty()) :?>
        <button id="import" class="button" type="button">Importer le csv</button>
    <?php else :
        $totalSms = $dbTable->getTotalSms();
        $volumeDatas = $dbTable->getTotalVolumeBySub();
        $dureeAppel = $dbTable->getTimeCall("2012-02-15")?>
        <button id="clear" class="button" type="button">Vider la base</button>
        <h1>Durée totale réelle des appels effectués après le 15/02/2012 (inclus) :</h1>
        <p style='color: red;font-size:36px;'>"<?= $dureeAppel ?>"</p>
        <h1>Quantité totale de SMS envoyés par l'ensemble des abonnés :</h1>
        <p style='color: red;font-size:36px;'>"<?= $totalSms ?>"</p>

        <h1>TOP 10 des volumes data facturés en dehors de la tranche horaire 8h00-
            18h00, par abonné :</h1>

        <table>
            <tr>
                <th>Numéro abonné</th>
                <th>Volume data</th>
            </tr>
            <?php foreach ($volumeDatas as $volumeData):?>
                <tr>
                    <td><?= $volumeData['num_abonne'] ?></td>
                    <td><?= $volumeData['totalvolume'] ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif;?>
</body>


