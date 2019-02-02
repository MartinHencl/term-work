<?php
require_once("../class/Vybaveni.php");
function vratVybaveniVozuPodleVozu($pdo, $idVozu)
{
    $pole_vybaveni = array();
    $sql = "SELECT ID_VYBAVENI, VYBAVENI, HODNOTA FROM VYBAVENI
              JOIN VOZIDLO_HAS_VYBAVENI ON VYBAVENI.ID_VYBAVENI = VOZIDLO_HAS_VYBAVENI.VYBAVENI_ID_VYBAVENI
              JOIN VOZIDLO V ON VOZIDLO_HAS_VYBAVENI.VOZIDLO_ID_VOZIDLA = V.ID_VOZIDLA
              WHERE V.ID_VOZIDLA = :idvozidla";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":idvozidla", $param_id_vozidla, PDO::PARAM_INT);
        $param_id_vozidla = $idVozu;
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                for ($i = 0; $i < $pocet_radku; $i++) {
                    $row = $stmt->fetch();
                    $pole_vybaveni[$i] = Vybaveni::vytvorVybaveni($row["ID_VYBAVENI"], $row{"VYBAVENI"});
                    $pole_vybaveni[$i]->setHodnota($row["HODNOTA"]);
                }
                return $pole_vybaveni;
            }
        }
    }
}

?>