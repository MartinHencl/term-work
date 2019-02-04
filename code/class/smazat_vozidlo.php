<?php
require_once("../class/prihlaseni_do_db.php");

if (empty(trim($_POST["id_vozu"]))) {
    header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
} else {
    $id_vozidla = trim($_POST["id_vozu"]);
}
/* Begin a transaction, turning off autocommit */
$pdo->beginTransaction();

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
        $pdo->rollBack();
        header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
    }
} catch (PDOException $e)
{
    $pdo->rollBack();
    session_start();
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; PDO::errorInfo() " . date("Y-m-d-H-i") . ": ";
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . " " . $e->getMessage();
    //echo "\nPDO::errorInfo():\n";
    //print_r($pdo->errorInfo());
    //echo $e->getMessage();
    header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
    die();
}
?>