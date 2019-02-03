<?php
    echo "<a href='../page/index.php'>Úvodní stránka</a>\n";
    echo "<a href='../page/nabidka_vsech_vozu.php'>Nabídka automobilů</a>\n";
    //echo "<a href='../index.php?vyber=3'>Rezervace &amp; cena</a>\n";
    //echo "<a href='index.php?vyber=3'>Podmínky</a>\n";
    //echo "<a href='index.php?vyber=3'>Kontakt a pobočky</a>\n";

    if ($_SESSION["ROLE"] == "uzivatel") {
        echo "<a href='../page/vsechny_objednavky.php'>Moje objednávky</a>\n";
    }
    if ($_SESSION["ROLE"] == "administrator") {
        echo "<a href='../page/vsechny_objednavky.php'>Všechny objednávky</a>\n";
        echo "<a href='../page/seznam_uzivatelu.php'>Seznam uživatelů</a>\n";
    }
?>