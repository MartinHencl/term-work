<?php
session_start();
require_once("../class/prihlaseni_do_db.php");

$znacka_err = $jmeno_err = $spz_err = $puvodni_najeto_err = "";
$znacka = $jmeno_vozu = $spz = $puvodni_najeto = $spotreba = $dojezd = $foto_vozu = $vybaveni = "";
?>

<?php
if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {

    $sql = "SELECT * FROM ZNACKA_VOZU";
    $pole_znacek = array();
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                $row = $stmt->fetch();
                ZALOZI TRIDU ZNACKY A TU PLNIT
            }
        }
    }
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

            <article>
                <div class="form-wrapper">

                    <h2>Nové vozidlo</h2>
                    <form accept-charset="utf-8" method="post">
                        <div class="form-group <?php echo (!empty($znacka_err)) ? 'has-error' : ''; ?>">
                            <label>Značka<span style="color: red;">*</span>: </label> <br>
                            <select name="znacky_vozy" style="width: 170px">
                                <option value="volvo">Volvo</option>
                                <option value="saab">Saab</option>
                                <option value="opel">Opel</option>
                                <option value="audi">Audi</option>
                            </select>
                            <label>Pro novou značku: </label>
                            <input type="text" name="znacka_nova" value="<?php echo $znacka; ?>" placeholder="Napište novou značku">
                            <span class="help-block"><?php echo $znacka_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jmeno_err)) ? 'has-error' : ''; ?>">
                            <label>Jméno vozu<span style="color: red;">*</span>: </label>
                            <input type="text" name="jmeno_vozu" class="form-control" value="<?php echo $jmeno_vozu; ?>" placeholder="Jméno vozu">
                            <span class="help-block"><?php echo $jmeno_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($spz_err)) ? 'has-error' : ''; ?>">
                            <label>SPZ<span style="color: red;">*</span>: </label>
                            <input type="text" name="jmeno" class="form-control" value="<?php echo $spz; ?>" placeholder="12345">
                            <span class="help-block"><?php echo $spz_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($puvodni_najeto_err)) ? 'has-error' : ''; ?>">
                            <label>Najeto původní<span style="color: red;">*</span>: </label>
                            <input type="number" name="puvodni_najeto" class="form-control" value="<?php echo $puvodni_najeto; ?>" placeholder="0">
                            <span class="help-block"><?php echo $puvodni_najeto_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Spotřeba [l/100 km]: </label>
                            <input type="number" name="spotreba" class="form-control" value="<?php echo $spotreba; ?>" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label>Dojezd na nádrž [km]: </label>
                            <input type="number" name="spotreba" class="form-control" value="<?php echo $dojezd; ?>" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label>Foto vozu: </label>
                            <input type="file" name="foto_vozu" class="form-control" value="<?php echo $foto_vozu; ?>">
                        </div>
                        <div class="form-group">
                            <label>Vybavení: </label> <br>
                            <select name="vybaveni" style="width: 170px" size="2" multiple>
                                <option value="diesel">Diesel</option>
                                <option value="benzin">Benzín</option>
                            </select>
                            <label>Pro nové vybavení: </label>
                            <input type="text" name="vybaveni_nove" value="<?php echo $vybaveni; ?>" placeholder="Napište nové vybavení">

                        </div>
                        <button type="submit" formaction="<?php echo htmlspecialchars('zalozeni_vozidla.php'); ?>">Vytvořit nový vůz</button>
                        <button type="reset">Reset</button>
                    </form>
                </div>
            </article>

            <article>
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
}
?>