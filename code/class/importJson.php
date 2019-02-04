<?php
session_start();
require_once("../class/prihlaseni_do_db.php");
require_once("../class/Objednavka.php");

if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator")) {
    $str = '../page/results.json';
    $json = json_decode(file_get_contents($str), true);
    //echo '<pre>' . print_r($json, true) . '</pre>';
    $pocet = count($json['JIZDY']);
    for ($i = 0; $i < $pocet; $i++) {
        $id_jizdy = $json['JIZDY'][$i]["ID_JIZDY"];
        $datumVzniku = $json['JIZDY'][$i]["DATUM_VZNIKU"];
        $datumZacatku = $json['JIZDY'][$i]["DATUM_ZACATKU"];
        $datumKonce = $json['JIZDY'][$i]["DATUM_KONCE"];
        $stav = $json['JIZDY'][$i]["STAV"];
        $idUzivatel = $json['JIZDY'][$i]["UZIVATEL_ID_UZIVATEL"];
        $idVozu = $json['JIZDY'][$i]["VOZIDLO_ID_VOZIDLA"];
        $novaObjednavka = Objednavka::vytvorObjednavku($id_jizdy, $datumVzniku, $datumZacatku, $datumKonce, $stav, $idUzivatel, $idVozu);

        $sql = 'INSERT INTO JIZDY
                  (ID_JIZDY, DATUM_VZNIKU, DATUM_ZACATKU, DATUM_KONCE, STAV, UZIVATEL_ID_UZIVATEL, VOZIDLO_ID_VOZIDLA)
                  VALUES (:id_jizdy, :datumVzniku, :datumZacatku, :datumKonce, :stav, :idUzivatele, :idVozu);';
        //VALUES ("2019-02-03", "2019-02-03", "2019-02-05", 0, "objednano", 2, 5);';

        if ($stmt = $pdo->prepare($sql)) {
            $param_id_jizdy = $id_jizdy;
            $param_datumVzniku = $datumVzniku;
            $param_datumZacatku = $datumZacatku;
            $param_datumKonce = $datumKonce;
            $param_stav = $stav;
            $param_idPrihlasenehoUzivatele = $idUzivatel;
            $param_idVybranehoVozu = $idVozu;

            $stmt->bindParam(":id_jizdy", $param_id_jizdy, PDO::PARAM_INT);
            $stmt->bindParam(":datumVzniku", $param_datumVzniku, PDO::PARAM_STR);
            $stmt->bindParam(":datumZacatku", $param_datumZacatku, PDO::PARAM_STR);
            $stmt->bindParam(":datumKonce", $param_datumKonce, PDO::PARAM_STR);
            $stmt->bindParam(":stav", $param_stav, PDO::PARAM_STR);
            $stmt->bindParam(":idUzivatele", $param_idPrihlasenehoUzivatele, PDO::PARAM_INT);
            $stmt->bindParam(":idVozu", $param_idVybranehoVozu, PDO::PARAM_INT);

            if ($stmt->execute()) {
                continue; // OK
            } else {
                $_SESSION["ERROR"] = $_SESSION["ERROR"] . "; Chyba SQL pridavani do Jizdy " . date("Y-m-d-H-i");;
            }
        }
    }
    header("Location: http://localhost/term-work/code/page/vsechny_objednavky.php");
}

?>