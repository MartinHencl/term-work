<?php
session_start();
require_once("../class/Vybaveni.php");
require_once("../class/prihlaseni_do_db.php");
?>
<?php
if (isset($_SESSION["ROLE"]) && $_SESSION["ROLE"] === "administrator") {

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["vybaveni_vozu"]))) {
        $vybaveni_vozu_err = "Je potřeba vložit název vybavení.";
    } else {
        $vybaveni_vozu = trim($_POST["vybaveni_vozu"]);
    }

    if (empty($vybaveni_vozu_err)) {
        $sql = "INSERT INTO VYBAVENI (VYBAVENI) VALUES (:vybaveni)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":vybaveni", $param_vybaveni_vozu, PDO::PARAM_STR);

            $param_vybaveni_vozu = $vybaveni_vozu;

            if ($stmt->execute()) {
                header("location: zalozeni_vybaveni.php");
            } else {
                echo "Hups! Nějaká SQL chyba, zkuste to později.";
            }
            unset($stmt);
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
            <h2>Nové vybavení</h2>
            <form accept-charset="utf-8" method="post">
                <div class="form-group <?php echo (!empty($vybaveni_vozu_err)) ? 'has-error' : ''; ?>">
                    <label>Vybavení vozu<span style="color: red;">*</span>: </label>
                    <input type="text" name="vybaveni_vozu" class="form-control" value="" placeholder="Vybavení vozu" autocomplete="off">
                    <span class="help-block"><?php echo $vybaveni_vozu_err; ?></span>
                </div>
                <button type="submit" formaction="<?php echo htmlspecialchars('zalozeni_vybaveni.php'); ?>">Vytvořit nové vybavení vozů</button>
                <button type="reset">Reset</button>
                <p><a href="zalozeni_vozidla.php">Zpátky k založení vozu</a>.</p>
            </form>
            </div>
        </article>

        <article>
            <fieldset style="margin: 10px;">
                <legend><H2>Seznam stávajících vybavení</H2></legend>
                <?php
                foreach ( array_reverse($pole_vybaveni) as $item) {
                    echo ('<label>' . $item->getNazevVybaveni() . '</label><br>' . "\n");
                }
                unset($item);
                ?>
            </fieldset>
        </article>
        <?php
        }
        ?>
    </section>

        <footer>
            <?php
            /*if (isset($prihlaseni_k_databazi_zprava)) {
                echo $prihlaseni_k_databazi_zprava;
                unset($prihlaseni_k_databazi_zprava);
            }*/
            ?>
        </footer>

    </main>
    </body>

    </html>