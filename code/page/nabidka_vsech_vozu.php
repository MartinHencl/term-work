<?php
session_start();
require_once("../class/prihlaseni_do_db.php");
require_once("../class/Vozidlo.php");
require_once("../class/nacti_vsechna_vozidla.php");
require_once("../class/vratZnackuPodleID.php");
require_once("../class/vratVybaveniPodleVozu.php");
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
            <img src="../image/mercedes-benz-c-class-vehicle-model-banner.jpg" alt="Banner auto">    <!--  https://www.mercedes-benz-newmarket.ca/about-us/mercedes-benz-c-class-vehicle-model-banner/ -->
        </div>
    </header>

    <nav>
        <?php
        require_once("./stejne_casti/menu.php");
        ?>
    </nav>

    <section>

        <?php
        if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {
            ?>
            <article>
                <fieldset style="margin: 10px;">
                    <legend>Přidat nové vozidlo</legend>
                    <form>
                        <button type="submit" formaction="<?php echo htmlspecialchars('zalozeni_vozidla.php'); ?>">Vložit nový vůz</button>
                    </form>
                </fieldset>
            </article>
            <?php
        }
        ?>
        <h2>Nabídka všech vozidel</h2>

        <?php
        foreach ($pole_vozidla as $vuz) {
            echo('<article>' . "\n");
            echo('<div class="form-wrapper">' . "\n");
            echo('<div class="form-group">' . "\n");
            echo sprintf('<h3>%s %s</h3>' . "\n", vratZnackuVozuPodleVozu($pdo, $vuz->getZnackaVozuIdZnackaVozu()), $vuz->getJmeno());
            echo('</div>' . "\n");
            echo('<div class="form-group">' . "\n");
            echo('<img class="form-image" src="../image/mercedes-benz-c-class-vehicle-model-banner.jpg" alt="mercedes">' . "\n");
            echo('</div>' . "\n");
            echo('<div class="form-group">' . "\n");
            echo sprintf('<label>%s %s</label>' . "\n", vratZnackuVozuPodleVozu($pdo, $vuz->getZnackaVozuIdZnackaVozu()), $vuz->getJmeno());
            echo('</div>' . "\n");
            echo('<div class="form-group">' . "\n");
            echo sprintf('<label>Cena pronájmu [Kč/den]: %s</label>' . "\n", $vuz->getCena());
            echo('</div>' . "\n");
            echo('<div class="form-group">' . "\n");
            echo sprintf('<label>Najeto: %d km </label>' . "\n", $vuz->getPuvodniNajeto());
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
                echo('<form accept-charset="utf-8" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post"> ' . "\n");
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
                echo('<input type="submit" value="Rezervace na datum">' . "\n");
                echo('</div>' . "\n");
                if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {
                    echo('<div class="form-group">' . "\n");
                    echo('<input type="submit" formaction="/upravit_vozidlo.php" value="Upravit vůz">');
                    echo('<input type="submit" formaction="../class/smazat_vozidlo.php" value="Smazat vozidlo">' . "\n");
                    echo('</div>' . "\n");
                }
                echo('</form>' . "\n");
            }
            echo('</div>' . "\n");
            echo('</article>' . "\n");
        }
        ?>

    </section>

    <footer>
        <?php
        if (isset($prihlaseni_k_databazi_zprava)) {
            echo $prihlaseni_k_databazi_zprava;
            unset($prihlaseni_k_databazi_zprava);
        }
        ?>
    </footer>

</main>

</body>

</html>