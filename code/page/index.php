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

    <!-- Boční sloupec
    <aside>
    </aside>
    -->

    <section>

        <article>
            <?php
            //phpinfo();
            echo BASE_URL . "<br>";
            echo CURRENT_URL . "<br>";
            echo ROOT_PATH . "<br>";
            ?>

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