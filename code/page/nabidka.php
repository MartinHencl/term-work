<?php
session_start();
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
        require_once ("./stejne_casti/login_top.php");
        ?>
    </div>
    <header>
        <div class="container" >
            <img src="../image/mercedes-benz-c-class-vehicle-model-banner.jpg" alt="Banner auto"  >    <!--  https://www.mercedes-benz-newmarket.ca/about-us/mercedes-benz-c-class-vehicle-model-banner/ -->
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