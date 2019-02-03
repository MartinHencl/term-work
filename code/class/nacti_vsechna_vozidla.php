<?php
$sql = "SELECT * FROM VOZIDLO JOIN ZNACKA_VOZU ON VOZIDLO.ZNACKA_VOZU_ID_ZNACKA_VOZU = ZNACKA_VOZU.ID_ZNACKA_VOZU";
$pole_vozidla = array();
if ($stmt = $pdo->prepare($sql)) {
    if ($stmt->execute()) {
        $pocet_radku = $stmt->rowCount();
        if ($pocet_radku > 0) {
            for ($i = 0; $i < $pocet_radku; $i++) {
                $row = $stmt->fetch();
                $pole_vozidla[$i] = Vozidlo::vytvorVozidlo($row["ID_VOZIDLA"], $row["JMENO"], $row["CENA"], $row["PUVODNI_NAJETO"], $row["ZNACKA_VOZU_ID_ZNACKA_VOZU"]);
            }
            unset($i, $row, $stmt, $sql);
        }
    }
}
?>