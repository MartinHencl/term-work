<?php
require_once("../class/prihlaseni_do_db.php");

if (empty(trim($_POST["id_objednavka"]))) {
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Prazdna promenna id_objednavka " . date("Y-m-d-H-i");
    header('Location: http://localhost/term-work/code/page/vsechny_objednavky.php');
    die();
} else {
    $id_objednavka = trim($_POST["id_objednavka"]);
}

$sql = "DELETE FROM JIZDY WHERE ID_JIZDY = :id_jizdy";

if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":id_jizdy", $param_id_jizdy, PDO::PARAM_INT);
    $param_id_jizdy = $id_objednavka;
    if ($stmt->execute()) {
        header('Location: http://localhost/term-work/code/page/vsechny_objednavky.php');
    } else {
        $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pri mazani objednavky/jizdy " . date("Y-m-d-H-i");
    }
} else {
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pri mazani objednavky/jizdy " . date("Y-m-d-H-i");
    /*echo "\nPDO::errorInfo():\n";
    print_r($pdo->errorInfo());
    echo $e->getMessage();
    die();*/
}

?>