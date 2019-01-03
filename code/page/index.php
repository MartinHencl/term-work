<?php
    session_start();
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
            require_once("../class/prihlaseni_do_db.php");
        ?>
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo 'Přihlášen jako ' . $_SESSION["JMENO"] . ' ' . $_SESSION["PRIJMENI"] . ' | ';
            echo '<a href="odhlaseni.php">Odhlásit se</a>';
        } else {
            echo '<a href="prihlaseni.php">Příhlásit se</a>';
        }
        ?>
    </div>
    <header>
        <div class="container" >
            <img src="../image/mercedes-benz-c-class-vehicle-model-banner.jpg" alt="Banner auto"  >    <!--  https://www.mercedes-benz-newmarket.ca/about-us/mercedes-benz-c-class-vehicle-model-banner/ -->
        </div>
    </header>

    <nav>
        <?php
            require_once("menu.php");
        ?>
    </nav>

    <!-- Boční sloupec
    <aside>
    </aside>
    -->

    <section>

        <article>
        </article>

        <article>
        </article>

    </section>

    <footer>
        <?php
            echo $prihlaseni_k_databazi_zprava;
        ?>
    </footer>

</main>

</body>

</html>