<?php
$sql = "SELECT * FROM VYBAVENI";
$pole_vybaveni = array();
if ($stmt = $pdo->prepare($sql)) {
    if ($stmt->execute()) {
        $pocet_radku = $stmt->rowCount();
        if ($pocet_radku > 0) {
            for ($i = 0; $i < $pocet_radku; $i++) {
                $row = $stmt->fetch();
                $pole_vybaveni[$i] = Vybaveni::vytvorVybaveni($row["ID_VYBAVENI"], $row{"VYBAVENI"});
            }
            unset($i, $row, $stmt, $sql);
        }
    }
}
?>