<?php
require_once("../class/prihlaseni_do_db.php");

if (empty(trim($_POST["id_objednavka"]))) {
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Prazdna promenna id_objednavka " . date("Y-m-d-H-i");
    header('Location: http://localhost/term-work/code/page/vsechny_objednavky.php');
    die();
} else {
    $id_objednavka = trim($_POST["id_objednavka"]);
}

if (empty(trim($_POST["stav_objednavka"]))) {
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Prazdna promenna stav_objednavka " . date("Y-m-d-H-i");
    header('Location: http://localhost/term-work/code/page/vsechny_objednavky.php');
    die();
} else {
    $stav_objednavka = trim($_POST["stav_objednavka"]);
    if ($stav_objednavka == "objednano") {
        $stav_objednavka = "schvaleno";
        $najeto = 0;
    } else if ($stav_objednavka == "schvaleno") {
        $stav_objednavka = "vyzvednuto";
        $najeto = 0;
    } else if ($stav_objednavka == "vyzvednuto") {
        if (empty(trim($_POST["ujete_km"]))) {
            $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Prazdna promenna ujete_km " . date("Y-m-d-H-i");
            header('Location: http://localhost/term-work/code/page/vsechny_objednavky.php');
            die();
        } else {
            $stav_objednavka = "vraceno";
            $najeto = trim($_POST["ujete_km"]);
        }
    } else if ($stav_objednavka == "vraceno") {
        $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba pokus o spatnou zmenu stavu objednavky/jizdy " . date("Y-m-d-H-i");
    }
}

$sql = "UPDATE JIZDY SET STAV = :stav , NAJETO = :najeto WHERE ID_JIZDY = :id_jizdy";

if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":stav", $param_stav, PDO::PARAM_STR);
    $stmt->bindParam(":najeto", $param_najeto, PDO::PARAM_INT);
    $stmt->bindParam(":id_jizdy", $param_id_jizdy, PDO::PARAM_INT);
    $param_stav = $stav_objednavka;
    $param_najeto = $najeto;
    $param_id_jizdy = $id_objednavka;
    if ($stmt->execute()) {
        header('Location: http://localhost/term-work/code/page/vsechny_objednavky.php');
    } else {
        $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pri zmene stavu objednavky/jizdy " . date("Y-m-d-H-i");
    }
} else {
    $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pri zmene stavu objednavky/jizdy " . date("Y-m-d-H-i");
    /*echo "\nPDO::errorInfo():\n";
    print_r($pdo->errorInfo());
    echo $e->getMessage();
    die();*/
}
?>