<?php
//ob_start(); // predkesovani cele stranky a zobrazeni az najednou
// Include config file
require_once("../class/prihlaseni_do_db.php");

// Define variables and initialize with empty values
$username = $password = $confirm_password = $jmeno = $heslo = $telefon = "";
$username_err = $password_err = $confirm_password_err = $jmeno_err = $heslo_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Je potřeba vložit email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT ID_UZIVATEL FROM UZIVATEL WHERE EMAIL = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "Tento email je již zabrán.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Hups! Nějaká chyba, zkuste to později.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Je potřeba vložit heslo.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Heslo musí mít alespoň 6 znaků.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Je potřeba vložit heslo podruhé.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Heslo se neshoduje.";
        }
    }

    // Ověření jméno
    if (empty(trim($_POST["jmeno"]))) {
        $password_err = "Je potřeba vložit jméno.";
    } else {
        $jmeno = trim($_POST["jmeno"]);
    }

    // Ověření příjmení
    if (empty(trim($_POST["prijmeni"]))) {
        $password_err = "Je potřeba vložit příjmení.";
    } else {
        $prijmeni = trim($_POST["prijmeni"]);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($jmeno_err)&& empty($prijmeni_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO UZIVATEL (EMAIL, HESLO, JMENO, PRIJMENI, ROLE, TELEFON) VALUES (:username, :password, :jmeno, :prijmeni, :role, :telefon)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":jmeno", $param_jmeno, PDO::PARAM_STR);
            $stmt->bindParam(":prijmeni", $param_prijmeni, PDO::PARAM_STR);
            $stmt->bindParam(":role", $param_role, PDO::PARAM_STR);
            $stmt->bindParam(":telefon", $param_telefon, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_jmeno = $jmeno;
            $param_prijmeni = $prijmeni;
            $param_role = "uzivatel";
            if ($telefon != "") {
                $param_telefon = $telefon;
            } else {
                $param_telefon = "";
            }

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: prihlaseni.php");
            } else {
                echo "Hups! Nějaká chyba, zkuste to později.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
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
        <div class="container">
            <img src="../image/mercedes-benz-c-class-vehicle-model-banner.jpg" alt="Banner auto">    <!--  https://www.mercedes-benz-newmarket.ca/about-us/mercedes-benz-c-class-vehicle-model-banner/ -->
        </div>
    </header>

    <nav>
        <?php
        require_once("menu.php");
        ?>
    </nav>

    <section>

        <article>
            <div class="form-wrapper">
                <h2>Registrace</h2>
                <p>Formulář pro založení uživatelského účtu.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Přihlašovací email<span style="color: red;">*</span>: </label>
                        <input type="email" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($jmeno_err)) ? 'has-error' : ''; ?>">
                        <label>Jméno<span style="color: red;">*</span>: </label>
                        <input type="text" name="jmeno" class="form-control" value="<?php echo $jmeno; ?>">
                        <span class="help-block"><?php echo $jmeno_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($prijmeni_err)) ? 'has-error' : ''; ?>">
                        <label>Příjmení<span style="color: red;">*</span>: </label>
                        <input type="text" name="prijmeni" class="form-control" value="<?php echo $prijmeni; ?>">
                        <span class="help-block"><?php echo $prijmeni_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Telefon: </label>
                        <input type="text" name="telefon" class="form-control" value="<?php echo $telefon; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Heslo<span style="color: red;">*</span>: </label>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label>Heslo znovu<span style="color: red;">*</span>: </label>
                        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Odeslat">
                        <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                    <p>Máte již účet? <a href="prihlaseni.php">Přihlaste se</a>.</p>
                </form>
            </div>
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