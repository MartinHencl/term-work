<?php
require_once("../class/prihlaseni_do_db.php");
?>
<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo 'Přihlášen jako ' . $_SESSION["JMENO"] . ' ' . $_SESSION["PRIJMENI"] . ' | ' . $_SESSION["ROLE"] . ' | ';
    echo '<a href="../class/odhlaseni_uzivatele.php">Odhlásit se</a>';
} else {
    echo '<a href="../page/prihlaseni.php">Příhlásit se</a>';
}
?>