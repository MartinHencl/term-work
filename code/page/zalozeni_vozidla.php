<?php
session_start();
require_once("../class/Znacka.php");
require_once("../class/Vybaveni.php");
require_once("../class/prihlaseni_do_db.php");

$znacka_err = $jmeno_err = $cena_err = $puvodni_najeto_err = "";
$znacka = $jmeno_vozu = $cena = $puvodni_najeto = $foto_vozu = "";
$pole_vybaveni_vybranych = array();

if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {

    require_once ("../class/nacti_vsechny_znacky_vozu.php");

    require_once ("../class/nacti_vsechna_vybaveni.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["znacky_vozy"]))) {
            $znacka_err = "Je potřeba vložit značku.";
        } else {
            $znacka = trim($_POST["znacky_vozy"]);
        }
        if (empty(trim($_POST["jmeno_vozu"]))) {
            $jmeno_err = "Je potřeba vložit jméno vozu.";
        } else {
            $jmeno_vozu = trim($_POST["jmeno_vozu"]);
        }
        if (empty(trim($_POST["cena"]))) {
            $cena_err = "Je potřeba vložit cenu pronájmu vozu.";
        } else {
            $cena = trim($_POST["cena"]);
        }
        if (empty(trim($_POST["puvodni_najeto"]))) {
            $puvodni_najeto_err = "Je potřeba vložit původní najeté kilometry vozu.";
        } else {
            $puvodni_najeto = trim($_POST["puvodni_najeto"]);
        }
        /*if (!empty(trim($_POST["foto_vozu"]))) {

                        $foto_vozu = $_POST["foto_vozu"];
                        $name = $_FILES['foto_vozu']['name'];
                        $size = $_FILES['foto_vozu']['size'];
                        $type = $_FILES['foto_vozu']['type'];
                        $tmp_name = $_FILES['foto_vozu']['tmp_name'];

                        $dir = "../image/autoID";
                        if (!file_exists($dir) || !is_dir($dir)) {
                            mkdir($dir);
                        }
                    }*/
        if (!empty($_POST["vybaveni_checklist"])) {
            foreach ($_POST["vybaveni_checklist"] as $item_checked) {
                if (!empty(trim($_POST["vybaveni_" . $item_checked]))) {
                    $pole_vybaveni_vybranych[$item_checked] = trim($_POST["vybaveni_" . $item_checked]);
                } else {
                    $pole_vybaveni_vybranych[$item_checked] = "null";
                }
            }
            unset($item_checked);
        }

        if (empty($znacka_err) && empty($jmeno_err) && empty($cena_err) && empty($puvodni_najeto_err)) {
            $sql = "INSERT INTO VOZIDLO (JMENO, CENA, PUVODNI_NAJETO, ZNACKA_VOZU_ID_ZNACKA_VOZU) VALUES (:jmeno, :cena, :najeto, :znacka)";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":jmeno", $param_jmeno, PDO::PARAM_STR);
                $stmt->bindParam(":cena", $param_cena, PDO::PARAM_INT);
                $stmt->bindParam(":najeto", $param_najeto, PDO::PARAM_STR);
                $stmt->bindParam(":znacka", $param_znacka, PDO::PARAM_STR);

                $param_jmeno = $jmeno_vozu;
                $param_cena = $cena;
                $param_najeto = $puvodni_najeto;
                $param_znacka = $znacka;

                if ($stmt->execute()) {
                    $last_id = $pdo->lastInsertId();
                    if (!empty($pole_vybaveni_vybranych)) {
                        foreach ($pole_vybaveni_vybranych as $key=>$item) {
                            $sql = "INSERT INTO VOZIDLO_HAS_VYBAVENI (VOZIDLO_ID_VOZIDLA, VYBAVENI_ID_VYBAVENI, HODNOTA) VALUES (:idVozidla, :idVybaveni, :hodnota)";
                            if ($stmt = $pdo->prepare($sql)) {
                                $stmt->bindParam(":idVozidla", $param_idVozidla, PDO::PARAM_INT);
                                $stmt->bindParam(":idVybaveni", $param_idVybaveni, PDO::PARAM_INT);
                                $stmt->bindParam(":hodnota", $param_hodnota, PDO::PARAM_STR);
                                $param_idVozidla = $last_id;
                                $param_idVybaveni = $key;
                                $param_hodnota = $item;
                                if ($stmt->execute()) {
                                    // ok nic nepsat
                                } else {
                                    echo "Hups! Nějaká chyba v tabulce vazeb, zkuste to později.";
                                }
                            }
                        }
                    }
                    header('Location: http://localhost/term-work/code/page/nabidka_vsech_vozu.php');
                    exit;
                } else {
                    echo "Hups! Nějaká chyba v novem vozidlu, zkuste to později.";
                }
            }
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
            <?php
            if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {
            ?>
            <article>
                <div class="form-wrapper">

                    <h2>Nové vozidlo</h2>
                    <form accept-charset="utf-8" method="post" enctype="multipart/form-data">
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
                            </select>
                            <p><a href="zalozeni_znacky.php">Vytvořit novou značku</a>.</p>
                        </div>
                        <div class="form-group <?php echo (!empty($jmeno_err)) ? 'has-error' : ''; ?>">
                            <label>Jméno vozu<span style="color: red;">*</span>: </label>
                            <input type="text" name="jmeno_vozu" class="form-control" value="<?php echo $jmeno_vozu; ?>" placeholder="Jméno vozu">
                            <span class="help-block"><?php echo $jmeno_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cena_err)) ? 'has-error' : ''; ?>">
                            <label>Cena pronájmu [Kč/den]<span style="color: red;">*</span>: </label>
                            <input type="text" name="cena" class="form-control" value="<?php echo $cena; ?>" placeholder="123">
                            <span class="help-block"><?php echo $cena_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($puvodni_najeto_err)) ? 'has-error' : ''; ?>">
                            <label>Najeto původní<span style="color: red;">*</span>: </label>
                            <input type="number" name="puvodni_najeto" class="form-control" value="<?php echo $puvodni_najeto; ?>" placeholder="0">
                            <span class="help-block"><?php echo $puvodni_najeto_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Vybavení: </label> <br>
                            <?php
                            if (!empty($pole_vybaveni)) {
                                for ($i = 0; $i < count($pole_vybaveni); $i++) {
                                    echo('<div class="label_checkbox">' . "\n");
                                    echo sprintf('<label><input type="checkbox" name="vybaveni_checklist[]" value=%s>%s</label><label class="vybaveni_hodnota_label">Hodnota: <input type="text" name="vybaveni_%s" class="vybaveni_hodnota"></label></div> <br>' . "\n", $pole_vybaveni[$i]->getIdVybaveni(), $pole_vybaveni[$i]->getNazevVybaveni(), $pole_vybaveni[$i]->getIdVybaveni());
                                }
                            }
                            ?>
                            <p><a href="zalozeni_vybaveni.php">Vytvořit nové vybavení</a>.</p>
                        </div>
                        <br>
                        <button type="submit" formaction="<?php echo htmlspecialchars('zalozeni_vozidla.php'); ?>">Vytvořit nový vůz</button>
                        <button type="reset">Reset</button>
                        <p>Zpátky na <a href="nabidka_vsech_vozu.php">seznam všech vozů</a>.</p>
                    </form>
                </div>
            </article>

            <article>
            </article>
                    <?php
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