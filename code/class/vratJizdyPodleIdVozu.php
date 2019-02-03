<?php
require_once("../class/Vybaveni.php");
function vratJizdyNajetoPodleIdVozu($pdo, $idVozu)
{
    $sql = "SELECT SUM(NAJETO) NAJETO FROM JIZDY WHERE VOZIDLO_ID_VOZIDLA = :idvozidla";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":idvozidla", $param_id_vozidla, PDO::PARAM_INT);
        $param_id_vozidla = $idVozu;
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row["NAJETO"];
        }
    }
}

?>