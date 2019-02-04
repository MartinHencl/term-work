<?php
session_start();
require_once("../class/prihlaseni_do_db.php");
require_once("../class/Vozidlo.php");
require_once("../class/enum_stavy_objednavky.php");

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    $idPrihlasenehoUzivatele = $_SESSION["ID_UZIVATEL"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idVybranehoVozu = $_POST["id_vozu"];
        $datumVzniku = date("Y-m-d");
        $datumZacatku = $_POST["datum_na_kdy"];
        $datumKonce = $_POST["datum_do_kdy"];

        $sql = 'INSERT INTO JIZDY
                  (DATUM_VZNIKU, DATUM_ZACATKU, DATUM_KONCE, STAV, UZIVATEL_ID_UZIVATEL, VOZIDLO_ID_VOZIDLA)
                  VALUES (:datumVzniku, :datumZacatku, :datumKonce, :stav, :idUzivatele, :idVozu);';
                //VALUES ("2019-02-03", "2019-02-03", "2019-02-05", 0, "objednano", 2, 5);';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":datumVzniku", $param_datumVzniku, PDO::PARAM_STR);
            $stmt->bindParam(":datumZacatku", $param_datumZacatku, PDO::PARAM_STR);
            $stmt->bindParam(":datumKonce", $param_datumKonce, PDO::PARAM_STR);
            $stmt->bindParam(":stav", $param_stav, PDO::PARAM_STR);
            $stmt->bindParam(":idUzivatele", $param_idPrihlasenehoUzivatele, PDO::PARAM_INT);
            $stmt->bindParam(":idVozu", $param_idVybranehoVozu, PDO::PARAM_INT);

            $param_datumVzniku = $datumVzniku;
            $param_datumZacatku = $datumZacatku;
            $param_datumKonce = $datumKonce;
            $param_stav = StavObjednavky::getObjednano()->getText();
            $param_idPrihlasenehoUzivatele = $idPrihlasenehoUzivatele;
            $param_idVybranehoVozu = $idVybranehoVozu;

            if ($stmt->execute()) {
                header("Location: http://localhost/term-work/code/page/vsechny_objednavky.php");
            } else {
                $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pridavani do Jizdy " . date("Y-m-d-H-i");;
            }
        } else {
            $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pridavani do Jizdy " . date("Y-m-d-H-i");;
        }
    }
}
?>