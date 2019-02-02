<?php
require_once("../class/prihlaseni_do_db.php");

if (empty(trim($_POST["id_vozu"]))) {
    header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
} else {
    $id_vozidla = trim($_POST["id_vozu"]);
}

$sql1 = "DELETE FROM VOZIDLO_HAS_VYBAVENI WHERE VOZIDLO_ID_VOZIDLA = :idVozu";
$sql2 = "DELETE FROM VOZIDLO WHERE ID_VOZIDLA = :idVozu";

try {
    $stmt = $pdo->prepare($sql1);
    $stmt->bindParam(":idVozu", $param_id_vozu, PDO::PARAM_INT);
    $param_id_vozu = $id_vozidla;
    if ($stmt->execute()) {
        $stmt = $pdo->prepare($sql2);
        $stmt->bindParam(":idVozu", $param_id_vozu, PDO::PARAM_INT);
        $param_id_vozu = $id_vozidla;
        if ($stmt->execute()) {
            header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
            //  OK
        }
    } else {
        // uz ne tolik OK
        header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
    }
} catch (PDOException $e)
{
    echo "\nPDO::errorInfo():\n";
    print_r($pdo->errorInfo());
    echo $e->getMessage();
    die();
}
?>