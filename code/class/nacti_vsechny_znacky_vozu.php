<?php
$sql = "SELECT * FROM ZNACKA_VOZU";
$pole_znacek = array();
if ($stmt = $pdo->prepare($sql)) {
    if ($stmt->execute()) {
        $pocet_radku = $stmt->rowCount();
        if ($pocet_radku > 0) {
            for ($i = 0; $i < $pocet_radku; $i++) {
                $row = $stmt->fetch();
                $pole_znacek[$i] = Znacka::vytvorZnacku($row["ID_ZNACKA_VOZU"], $row{"ZNACKA"});
            }
        unset($i, $row, $stmt, $sql);
        }
    }
}
?>