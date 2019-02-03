<?php

function vratZnackuVozuPodleIdZnacky($pdo, $idZnacka)
{
    $sql = "SELECT ZNACKA FROM ZNACKA_VOZU WHERE ID_ZNACKA_VOZU = :id_znacka";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id_znacka", $param_id_znacka_vozu, PDO::PARAM_INT);
        $param_id_znacka_vozu = $idZnacka;
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku = 1) {
                $row = $stmt->fetch();
                return $row["ZNACKA"];
            }
        }
    }
}
?>