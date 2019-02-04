<?php
session_start();
require_once("../class/prihlaseni_do_db.php");

if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator")) {
    $sql = "SELECT ID_JIZDY, DATE_FORMAT(DATUM_VZNIKU, '%Y-%m-%d') DATUM_VZNIKU, DATE_FORMAT(DATUM_ZACATKU, '%Y-%m-%d') DATUM_ZACATKU, DATE_FORMAT(DATUM_KONCE, '%Y-%m-%d') DATUM_KONCE, STAV, NAJETO, UZIVATEL_ID_UZIVATEL, VOZIDLO_ID_VOZIDLA FROM JIZDY";
    $objednavky_vsechny = array();
    $pole_objednavky = array();
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                for ($i = 0; $i < $pocet_radku; $i++) {
                    $row = $stmt->fetch();
                    $id_jizdy = $row["ID_JIZDY"];
                    $datumVzniku = $row["DATUM_VZNIKU"];
                    $datumZacatku = $row["DATUM_ZACATKU"];
                    $datumKonce = $row["DATUM_KONCE"];
                    $stav = $row["STAV"];
                    $idUzivatel = $row["UZIVATEL_ID_UZIVATEL"];
                    $idVozu = $row["VOZIDLO_ID_VOZIDLA"];
                    $pole_objednavky[$i] = array('ID_JIZDY' => $id_jizdy, 'DATUM_VZNIKU' => $datumVzniku, 'DATUM_ZACATKU' => $datumZacatku, 'DATUM_KONCE' => $datumKonce, 'STAV' => $stav, 'UZIVATEL_ID_UZIVATEL' => $idUzivatel, 'VOZIDLO_ID_VOZIDLA' =>$idVozu);
                }
                unset($i, $row, $stmt, $sql);
                $objednavky_vsechny['JIZDY'] = $pole_objednavky;

                $fp = fopen('../page/results.json', 'w');
                fwrite($fp, json_encode($objednavky_vsechny));
                fclose($fp);

                header("Location: http://localhost/term-work/code/page/vsechny_objednavky.php");
            }
        }
    }
}

?>