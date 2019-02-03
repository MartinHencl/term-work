<?php
if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator")) {
    $sql = "SELECT ID_JIZDY, DATE_FORMAT(DATUM_VZNIKU, '%Y-%m-%d') DATUM_VZNIKU, DATE_FORMAT(DATUM_ZACATKU, '%Y-%m-%d') DATUM_ZACATKU, DATE_FORMAT(DATUM_KONCE, '%Y-%m-%d') DATUM_KONCE, STAV, NAJETO, UZIVATEL_ID_UZIVATEL, VOZIDLO_ID_VOZIDLA FROM JIZDY";
    $pole_objednavky = array();
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                for ($i = 0; $i < $pocet_radku; $i++) {
                    $row = $stmt->fetch();
                    $pole_objednavky[$i] = Objednavka::vytvorObjednavku($row["ID_JIZDY"], $row["DATUM_VZNIKU"], $row["DATUM_ZACATKU"], $row["DATUM_KONCE"], $row["STAV"], $row["UZIVATEL_ID_UZIVATEL"], $row["VOZIDLO_ID_VOZIDLA"]);
                }
                unset($i, $row, $stmt, $sql);
            }
        }
    }
} else {
    $sql = "SELECT ID_JIZDY, DATE_FORMAT(DATUM_VZNIKU, '%Y-%m-%d') DATUM_VZNIKU, DATE_FORMAT(DATUM_ZACATKU, '%Y-%m-%d') DATUM_ZACATKU, DATE_FORMAT(DATUM_KONCE, '%Y-%m-%d') DATUM_KONCE, STAV, NAJETO, UZIVATEL_ID_UZIVATEL, VOZIDLO_ID_VOZIDLA FROM JIZDY WHERE UZIVATEL_ID_UZIVATEL = :id_uzivatel";
    $pole_objednavky = array();
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id_uzivatel", $param_id_uzivatel, PDO::PARAM_INT);
        $param_id_uzivatel = $_SESSION["ID_UZIVATEL"];
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                for ($i = 0; $i < $pocet_radku; $i++) {
                    $row = $stmt->fetch();
                    $pole_objednavky[$i] = Objednavka::vytvorObjednavku($row["ID_JIZDY"], $row["DATUM_VZNIKU"], $row["DATUM_ZACATKU"], $row["DATUM_KONCE"], $row["STAV"], $row["UZIVATEL_ID_UZIVATEL"], $row["VOZIDLO_ID_VOZIDLA"]);
                }
                unset($i, $row, $stmt, $sql);
            }
        }
    }
}
?>