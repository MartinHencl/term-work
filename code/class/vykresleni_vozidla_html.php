<?php
require_once("vratJizdyPodleIdVozu.php");
echo('<article>' . "\n");
    echo('<div class="form-wrapper">' . "\n");
        echo('<div class="form-group">' . "\n");
            echo sprintf('<h3>%s %s</h3>' . "\n", vratZnackuVozuPodleIdZnacky($pdo, $vuz->getZnackaVozuIdZnackaVozu()), $vuz->getJmenoVozu());
            echo('</div>' . "\n");
        echo('<div class="form-group">' . "\n");
            require("../class/obrazek_kontrola_a_nastaveni.php");
            echo sprintf('<img class="form-image" src="%s" alt="%s">' . "\n", $prvniSoubor, $vuz->getJmenoVozu());
            echo('</div>' . "\n");
        echo('<div class="form-group">' . "\n");
            echo sprintf('<label>%s %s</label>' . "\n", vratZnackuVozuPodleIdZnacky($pdo, $vuz->getZnackaVozuIdZnackaVozu()), $vuz->getJmenoVozu());
            echo('</div>' . "\n");
        echo('<div class="form-group">' . "\n");
            echo sprintf('<label>Cena pronájmu [Kč/den]: %s</label>' . "\n", $vuz->getCena());
            echo('</div>' . "\n");
        echo('<div class="form-group">' . "\n");
            echo sprintf('<label>Najeto: %d km </label>' . "\n", ($vuz->getPuvodniNajeto() + vratJizdyNajetoPodleIdVozu($pdo, $vuz->getIdVozidla())));
            echo('</div>' . "\n");
        foreach (vratVybaveniVozuPodleVozu($pdo, $vuz->getIdVozidla()) as $item) {
        echo('<div class="form-group">' . "\n");
            if ($item->getHodnota() == "null") {
            echo sprintf('<label>%s</label>' . "\n", $item->getNazevVybaveni());
            } else {
            echo sprintf('<label>%s: %s</label>' . "\n", $item->getNazevVybaveni(), $item->getHodnota());
            }
            echo('</div>' . "\n");
        }
        if (isset($_SESSION["ROLE"]) && ($_SESSION["ROLE"] === "administrator" || $_SESSION["ROLE"] === "uzivatel")) {
        echo('<form accept-charset="utf-8" method="post"> ' . "\n");
        echo sprintf('<input type="hidden" name="id_vozu" value="%d">' . "\n", $vuz->getIdVozidla());
        echo('<div class="form-group">' . "\n");
            echo('<label>Na kdy auto chcete: </label> ' . "\n");
            echo('<input type="date" name="datum_na_kdy" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '">' . "\n");
            echo('</div>' . "\n");
        echo('<div class="form-group">' . "\n");
            echo('<label>Do kdy auto chcete: </label>' . "\n");
            echo('<input type="date" name="datum_do_kdy" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '">' . "\n");
            echo('</div>' . "\n");
        /*echo('<div class="form-group">' . "\n");
            echo('<label>Výsledná cena: XXX Kč</label>' . "\n");
            echo('</div>' . "\n");*/
        echo('<div class="form-group">' . "\n");
            echo('<input type="submit" formaction="../class/vlozeni_objednani_vozu.php" value="Rezervace na datum">' . "\n");
            echo('</div>' . "\n");
        if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {
        echo('<div class="form-group">' . "\n");
            //echo('<input type="submit" formaction="../page/upravit_vozidlo.php" value="Upravit vůz">');
            echo('<input type="submit" formaction="../class/smazat_vozidlo.php" value="Smazat vozidlo">' . "\n");
            echo('</div>' . "\n");
        }
        echo('</form>' . "\n");
        }
        echo('</div>' . "\n");
    echo('</article>' . "\n");
?>