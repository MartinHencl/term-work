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
            </tr>
            <?php
            require_once("../class/nacti_vsechny_objednavky.php");
            if (!empty($pole_objednavky)) {
                $objednavka = new Objednavka();
                foreach ($pole_objednavky as $objednavka) {
                    $vuz = vratVuzPodleIdVozu($pdo, $objednavka->getIdVozu());
                    $uzivatel = vratUzivatelePodleIdUzivatele($pdo, $objednavka->getIdUzivatel());
                    echo '<tr>' . "\n";
                    echo sprintf('<td>%s</td>' . "\n", $objednavka->getIdObjednavky());
                    echo sprintf('<td>%s %s</td>' . "\n", $vuz->getZnackaVozuString(), $vuz->getJmenoVozu());
                    echo sprintf('<td>%s %s</td>' . "\n", $uzivatel->getJmeno(), $uzivatel->getPrijmeni());
                    echo sprintf('<td>%s</td>' . "\n", $objednavka->getDatumVzniku());
                    echo sprintf('<td>%s</td>' . "\n", $objednavka->getDatumZacatku());
                    echo sprintf('<td>%s</td>' . "\n", $objednavka->getDatumKonce());
                    echo sprintf('<td>%s</td>' . "\n", $objednavka->getStav());
                    echo sprintf('<td>%s</td>' . "\n", vratCelkovouCenu($objednavka->getDatumZacatku(), $objednavka->getDatumKonce(), $vuz->getCena()));
                    echo('</tr>' . "\n");
                }
                unset($objednavka);
            }
            ?>
        </table>
    </fieldset>
</article>