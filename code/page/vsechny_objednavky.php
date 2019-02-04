<?php
session_start();
require_once("../class/prihlaseni_do_db.php");
require_once("../class/Objednavka.php");
require_once("../class/Uzivatel.php");
require_once("../class/Vozidlo.php");
require_once("../class/enum_stavy_objednavky.php");

require_once("../class/vratVuzPodleID.php");
require_once ("../class/vratUzivatelePodleIdUzivatele.php");
require_once ("../class/vratCelkovouCenu.php");
?>
<!DOCTYPE html>

<html lang="cs">

<head>
    <?php
    require_once("./stejne_casti/head.php");
    ?>
</head>

<body>

<main>

    <div id="login-top">
        <?php
        require_once("./stejne_casti/login_top.php");
        ?>
    </div>
    <header>
        <div class="container">
            <img src="../image/mercedes-benz-c-class-vehicle-model-banner.jpg" alt="Banner auto">
        </div>
    </header>

    <nav>
        <?php
        require_once("./stejne_casti/menu.php");
        ?>
    </nav>

    <section>

        <article>
            <?php

            ?>
        </article>

        <article>
            <fieldset style="margin: 10px;">
                <legend>Seznam všech objednávek</legend>
                <table style="width:100%">
                    <tr>
                        <th>ID objednávky</th>
                        <th>Vozidlo</th>
                        <th>Příjmení Jméno</th>
                        <th>Datum vzniku</th>
                        <th>Datum začátku</th>
                        <th>Datu konce</th>
                        <th>Stav objednávky</th>
                        <th>Cena</th>
                        <?php
                        if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator")) {
                            echo ('<th > Ovládání</th >');
                        }
                        ?>
                    </tr>
                    <?php
                    require_once("../class/nacti_vsechny_objednavky.php");
                    if (!empty($pole_objednavky)) {
                        $objednavka = new Objednavka();
                        foreach ($pole_objednavky as $objednavka) {
                            $vuz = vratVuzPodleIdVozu($pdo, $objednavka->getIdVozu());
                            $uzivatel = vratUzivatelePodleIdUzivatele($pdo, $objednavka->getIdUzivatel());
                            if ($objednavka->getStav() == "objednano") {
                                echo '<tr style="background-color: LightSalmon;">' . "\n";
                            } else if ($objednavka->getStav() == "schvaleno") {
                                echo '<tr style="background-color: LemonChiffon;">' . "\n";
                            } else if ($objednavka->getStav() == "vyzvednuto") {
                                echo '<tr style="background-color: Lavender;">' . "\n";
                            } else if ($objednavka->getStav() == "vraceno") {
                                echo '<tr style="background-color: Gainsboro;">' . "\n";
                            }
                            echo sprintf('<td>%s</td>' . "\n", $objednavka->getIdObjednavky());
                            echo sprintf('<td>%s %s</td>' . "\n", $vuz->getZnackaVozuString(), $vuz->getJmenoVozu());
                            echo sprintf('<td>%s %s</td>' . "\n", $uzivatel->getJmeno(), $uzivatel->getPrijmeni());
                            echo sprintf('<td>%s</td>' . "\n", $objednavka->getDatumVzniku());
                            echo sprintf('<td>%s</td>' . "\n", $objednavka->getDatumZacatku());
                            echo sprintf('<td>%s</td>' . "\n", $objednavka->getDatumKonce());
                            echo sprintf('<td>%s</td>' . "\n", $objednavka->getStav());
                            echo sprintf('<td>%s</td>' . "\n", vratCelkovouCenu($objednavka->getDatumZacatku(), $objednavka->getDatumKonce(), $vuz->getCena()));
                            if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator")) {
                                echo('<td>');
                                echo('<form accept-charset="utf-8" method="post">' . "\n");
                                echo sprintf('<input type="hidden" name="id_objednavka" value="%s">', $objednavka->getIdObjednavky());
                                echo sprintf('<input type="hidden" name="stav_objednavka" value="%s">', $objednavka->getStav());
                                if ($objednavka->getStav() == "objednano") {
                                    echo('<button type="submit" formaction="../class/zmenit_stav_jizdy.php" >Schvátlit</button>' . "\n");
                                } else if ($objednavka->getStav() == "schvaleno") {
                                    echo('<button type="submit" formaction="../class/zmenit_stav_jizdy.php" >Předat vůz</button>' . "\n");
                                } else if ($objednavka->getStav() == "vyzvednuto") {
                                    echo sprintf('<input type="number" name="ujete_km" class="vybaveni_hodnota" value="" placeholder="Ujeto [km]">');
                                    echo('<button type="submit" formaction="../class/zmenit_stav_jizdy.php" >Přijmout vůz</button>' . "\n");
                                }
                                echo('<button type="submit" formaction="../class/smazat_jizdu.php" >Smazat</button>' . "\n");
                                echo('</form>' . "\n");
                                echo('</td>' . "\n");
                            }
                            echo ('</tr>' . "\n");
                        }
                        unset($objednavka);
                    }
                    ?>
                </table>
            </fieldset>
            <?php
            if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator")) {
            echo ('<form accept - charset = "utf-8" method = "post" >' . "\n");
                echo ('<button type = "submit" formaction = "../class/exportDoJson.php" > Export do JSON </button >'  . "\n");
                echo ('<button type = "submit" formaction = "../class/importJson.php" > Import JSON </button >' . "\n");
            echo ('</form >' . "\n");
            }
            ?>
        </article>

    </section>

    <footer>
        <?php
/*
        if (isset($_SESSION["ERROR"])) {
            echo ($_SESSION["ERROR"] . " | ");
            unset($_SESSION["ERROR"]);
        }
        if (isset($prihlaseni_k_databazi_zprava)) {
            echo $prihlaseni_k_databazi_zprava;
            unset($prihlaseni_k_databazi_zprava);
        }*/
        ?>
    </footer>

</main>

</body>

</html>