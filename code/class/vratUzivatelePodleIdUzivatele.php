<?php
require_once("../class/Uzivatel.php");

function vratUzivatelePodleIdUzivatele($pdo, $idUzivatele)
{
    $sql = "SELECT * FROM UZIVATEL WHERE ID_UZIVATEL = :id_uzivatel";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id_uzivatel", $param_id_uzivatel, PDO::PARAM_INT);
        $param_id_uzivatel = $idUzivatele;
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku = 1) {
                $row = $stmt->fetch();
                $uzivatelNovy = Uzivatel::vytvorUzivatele($row["ID_UZIVATEL"], $row["EMAIL"], $row["JMENO"], $row["PRIJMENI"], $row["ROLE"], $row["TELEFON"]);
                return $uzivatelNovy;
            } else {
                $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pri select uzivatel " . date("Y-m-d-H-i");
            }
        }
    }
}
?>