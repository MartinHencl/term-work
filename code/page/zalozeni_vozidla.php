<?php
session_start();
require_once("../class/Znacka.php");
require_once("../class/Vybaveni.php");
require_once("../class/prihlaseni_do_db.php");

$znacka_err = $jmeno_err = $spz_err = $puvodni_najeto_err = "";
$znacka = $jmeno_vozu = $spz = $puvodni_najeto = $spotreba = $dojezd = $vybaveni = $foto_vozu = "";
?>

<?php
if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {

    $sql = "SELECT * FROM ZNACKA_VOZU";
    $pole_znacek = array();
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                for ($i = 0; $i < $pocet_radku; $i++) {
                    $row = $stmt->fetch();
                    $pole_znacek[$i] = Znacka::vytvorZnacku($row["ID_ZNACKA_VOZU"], $row{"ZNACKA"});
                }
                unset($i, $row, $stmt, $sql);
            }
        }
    }

    $sql = "SELECT * FROM VYBAVENI";
    $pole_vybaveni = array();
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            $pocet_radku = $stmt->rowCount();
            if ($pocet_radku > 0) {
                for ($i = 0; $i < $pocet_radku; $i++) {
                    $row = $stmt->fetch();
                    $pole_vybaveni[$i] = Vybaveni::vytvorVybaveni($row["ID_VYBAVENI"], $row{"VYBAVENI"});
                }
                unset($i, $row, $stmt, $sql);
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
                                <?php
                                if (!empty($pole_znacek)) {
                                    foreach ($pole_znacek as $item) {
                                        echo '<option value="' . $item->getIdZnacky() . '">' . $item->getZnacka() . '</option>';
                                    }
                                    unset($item);
                                }
                                ?>
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
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
                            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
                            <label>Vybavení: </label> <br>
                            <input type="text" name="vybaveni_nove" id="vybaveni_nove" list="vybaveni-list" value="<?php echo $vybaveni; ?>" placeholder="Napište nové vybavení">
                            <datalist id="vybaveni-list">
                                <?php
                                if (!empty($pole_vybaveni)) {
                                    foreach ($pole_vybaveni as $item) {
                                        echo '<option value="' . $item->getNazev() . '"> \n"';
                                    }
                                    unset($item);
                                }
                                ?>
                                <option value="Benzin">
                                <option value="Diesel">
                                <option value="Airbag">
                            </datalist>
                            <label>Pro více vybavení: čárka a mezera</label>
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

    <script>
        var datalist = jQuery('datalist');
        var options = jQuery('datalist option');
        var optionsarray = jQuery.map(options ,function(option) {
            return option.value;
        });
        var input = jQuery('input[list]');
        var inputcommas = (input.val().match(/,/g)||[]).length;
        var separator = ',';

        function filldatalist(prefix) {
            if (input.val().indexOf(separator) > -1 && options.length > 0) {
                datalist.empty();
                for (i=0; i < optionsarray.length; i++ ) {
                    if (prefix.indexOf(optionsarray[i]) < 0 ) {
                        datalist.append('<option value="'+prefix+optionsarray[i]+'">');
                    }
                }
            }
        }
        input.bind("change paste keyup",function() {
            var inputtrim = input.val().replace(/^\s+|\s+$/g, "");
            //console.log(inputtrim);
            var currentcommas = (input.val().match(/,/g)||[]).length;
            //console.log(currentcommas);
            if (inputtrim != input.val()) {
                if (inputcommas != currentcommas) {
                    var lsIndex = inputtrim.lastIndexOf(separator);
                    var str = (lsIndex != -1) ? inputtrim.substr(0, lsIndex)+", " : "";
                    filldatalist(str);
                    inputcommas = currentcommas;
                }
                input.val(inputtrim);
            }
        });
    </script>
    </body>

    </html>
    <?php
}
?>