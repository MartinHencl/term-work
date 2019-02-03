<?php
require_once("../class/vratZnackuPodleID.php");
function vratVuzPodleIdVozu($pdo, $idVozu)
{
    $sql = "SELECT * FROM VOZIDLO WHERE ID_VOZIDLA = :id_vozu";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id_vozu", $param_id_vozu, PDO::PARAM_INT);
        $param_id_vozu = $idVozu;
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku = 1) {
                $row = $stmt->fetch();
                $vozidloNove = Vozidlo::vytvorVozidlo($row["ID_VOZIDLA"], $row["JMENO"], $row["CENA"], $row["PUVODNI_NAJETO"], $row["ZNACKA_VOZU_ID_ZNACKA_VOZU"]);
                $vozidloNove->setZnackaVozuString(vratZnackuVozuPodleIdZnacky($pdo, $vozidloNove->getZnackaVozuIdZnackaVozu()));
                return $vozidloNove;
            } else {
                $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pri select vozidla " . date("Y-m-d-H-i");
            }
        }
    }
}
?>