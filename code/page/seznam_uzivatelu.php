<?php
session_start();
require_once("../class/Uzivatel.php");

require_once("../class/prihlaseni_do_db.php");

$sql = "SELECT ID_UZIVATEL, EMAIL, JMENO, PRIJMENI, ROLE, TELEFON FROM UZIVATEL";

if ($stmt = $pdo->prepare($sql)) {
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        $pocet_radku = $stmt->rowCount();
        if ($pocet_radku > 0) {
            $pole_uzivatelu = array();
            for ($i = 0; $i < $pocet_radku; $i++) {
                $row = $stmt->fetch();
                $uzivatel = Uzivatel::vytvorUzivatele($row["ID_UZIVATEL"], $row["EMAIL"], $row["JMENO"], $row["PRIJMENI"], $row["ROLE"], $row["TELEFON"]);
                //print_r($uzivatel);
                $pole_uzivatelu[$i] = $uzivatel;
            }
            unset($i, $pocet_radku, $stmt, $row); // break the reference with the last element
        }
    }
}

?>
    <!DOCTYPE html>

    <html lang="cs">

    <head>
        <?php
        require_once("head.php");
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
            require_once("menu.php");
            ?>
        </nav>

        <section>
            <article>
                NOV7 UCET
            </article>

            <article>
                <fieldset style="margin: 10px;">
                    <legend>Seznam všech uživatelů</legend>
                    <table style="width:100%">
                        <tr>
                            <th>ID</th>
                            <th>Email (login)</th>
                            <th>Jméno</th>
                            <th>Příjmení</th>
                            <th>Role</th>
                            <th>Telefon</th>
                            <th>Úpravy</th>
                        </tr>
                        <?php
                        $uzivatel = new Uzivatel();
                        foreach ($pole_uzivatelu as $uzivatel) {
                            echo '<tr>' . "\n";
                            echo '<td>' . $uzivatel->getIdUzivatel() . '</td>' . "\n";
                            echo '<td>' . $uzivatel->getEmail() . '</td>' . "\n";
                            echo '<td>' . $uzivatel->getJmeno() . '</td>' . "\n";
                            echo '<td>' . $uzivatel->getPrijmeni() . '</td>' . "\n";
                            echo '<td>' . $uzivatel->getRole() . '</td>' . "\n";
                            echo '<td>' . $uzivatel->getTelefon() . '</td>' . "\n";
                            echo '</tr>' . "\n";
                        }
                        unset($uzivatel); // break the reference with the last element
                        ?>
                    </table>
                </fieldset>
            </article>


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
<?php
require_once("../class/odhlaseni_od_db.php")
?>