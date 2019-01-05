<?php
    echo "<a href='index.php'>Úvodní stránka</a>\n";
    echo "<a href='index.php?vyber=2'>Nabídka automobilů</a>\n";
    echo "<a href='index.php?vyber=3'>Rezervace &amp; cena</a>\n";
    echo "<a href='index.php?vyber=3'>Podmínky</a>\n";
    echo "<a href='index.php?vyber=3'>Kontakt a pobočky</a>\n";

    if ($_SESSION["ROLE"] == "uzivatel") {
        echo "<a href='index.php?vyber=3'>Moje objednávky</a>\n";
    }
    if ($_SESSION["ROLE"] == "administrator") {
        echo "<a href='index.php?vyber=3'>Všechny objednávky</a>\n";
        echo "<a href='seznam_uzivatelu.php'>Seznam uživatelů</a>\n";
    }
?>