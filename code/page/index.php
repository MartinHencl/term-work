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
                <h2>Vítejte na stránkách autopůjčovny. Ceny vozů začínají již od 250,- Kč na den!</h2>
                <p>Jsme společnost, která nabízí levný a dostupný pronájem vozů všech kategorií.</p>
                <p>Působíme ve městěch Mladá Boleslav, Liberec, Česká Lípa, Jičín a Praha. </p>
                <p>Máme co nabídnout! Působíme ve městěch Mladá Boleslav, Liberec, Česká Lípa, Jičín a Praha. </p>
            </div>
        </article>

        <article>
        </article>

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