<?php
//ob_start(); // predkesovani cele stranky a zobrazeni az najednou
session_start();
// Include config file
require_once("../class/Uzivatel.php");
require_once("../class/prihlaseni_do_db.php");

// Define variables and initialize with empty values
$username = $password = $confirm_password = $jmeno = $telefon = "";
$username_err = $password_err = $confirm_password_err = $jmeno_err = $heslo_err = "";
$editace = false;
$infoZpravy = "";

if (isset($_SESSION["EDITACE"]) && $_SESSION["EDITACE"] === 1 && isset($_GET["id_uzivatel"])) {
    $editace = true;
    $infoZpravy = $infoZpravy . " editace";
} else {
    $editace = false;
    $infoZpravy = $infoZpravy . " zadna editace";
}
if ($_SESSION["ROLE"] == "administrator") {
    if (isset($_GET["id_uzivatel"])) {
        $_SESSION["EDITACE"] = 1;
        $editace = true;
        $sql = "SELECT * FROM UZIVATEL WHERE ID_UZIVATEL = :userid";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userid", $param_userid, PDO::PARAM_INT);

            // Set parameters
            $param_userid = trim($_GET["id_uzivatel"]);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $uzivatel = Uzivatel::vytvorUzivatele($row["ID_UZIVATEL"], $row["EMAIL"], $row["JMENO"], $row["PRIJMENI"], $row["ROLE"], $row["TELEFON"]);
                $username = $uzivatel->email;
                $jmeno = $uzivatel->jmeno;
                $prijmeni = $uzivatel->prijmeni;
                $telefon = $uzivatel->telefon;
                $role = $uzivatel->role;
                unset($stmt, $row); // break the reference with the last element
            }
        }
    }
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if ($editace == true) {
        $username = trim($_POST["username"]);
    } else {
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
    }

    // Ověření jméno
    if (empty(trim($_POST["jmeno"]))) {
        $jmeno_err = "Je potřeba vložit jméno.";
    } else {
        $jmeno = trim($_POST["jmeno"]);
    }

    // Ověření příjmení
    if (empty(trim($_POST["prijmeni"]))) {
        $prijmeni_err = "Je potřeba vložit příjmení.";
    } else {
        $prijmeni = trim($_POST["prijmeni"]);
    }

    if ($editace != true) {
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
    }

    if (!empty(trim($_POST["role"]))) {
        $role = $_POST["role"];
    }

    if (!empty(trim($_POST["telefon"]))) {
        $telefon = $_POST["telefon"];
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($jmeno_err) && empty($prijmeni_err)) {

        if ($editace == true) {
            $sql = "UPDATE UZIVATEL SET JMENO = :jmeno, PRIJMENI = :prijmeni, ROLE = :role, TELEFON = :telefon WHERE EMAIL = :username";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":jmeno", $param_jmeno, PDO::PARAM_STR);
                $stmt->bindParam(":prijmeni", $param_prijmeni, PDO::PARAM_STR);
                $stmt->bindParam(":role", $param_role, PDO::PARAM_STR);
                $stmt->bindParam(":telefon", $param_telefon, PDO::PARAM_STR);

                $param_jmeno = $jmeno;
                $param_prijmeni = $prijmeni;
                $param_role = $role;
                $param_telefon = $telefon;

                if ($stmt->execute()) {
                    // Redirect to login page
                    header("location: seznam_uzivatelu.php");
                    unset($_SESSION["EDITACE"]);
                } else {
                    echo "Hups! Nějaká chyba, zkuste to později.";
                }
                // Close statement
                unset($stmt);
            }
        } else {
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
                if ($_SESSION["ROLE"] == "administrator") {
                    $param_role = $role;
                } else {
                    $param_role = "uzivatel";
                }
                $param_telefon = $telefon;

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
    }

    // Close connection
    unset($pdo);
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

        <article>
            <div class="form-wrapper">
                <h2>Registrace</h2>
                <p>Formulář pro založení uživatelského účtu.</p>
                <form accept-charset="utf-8" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Přihlašovací email<span style="color: red;">*</span>: </label>
                        <input type="email" name="username" class="form-control" value="<?php echo $username; ?>" <?php if ((isset($editace)) && ($editace == true)) { echo ('readonly');} ?> >
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
                    <?php
                    if ($_SESSION["ROLE"] == "administrator") {
                        ?>
                        <div class="form-group">
                            <label>Role: </label>
                            <select name="role">
                                <?php
                                if (isset($role) && ($role == "administrator")) {
                                    echo('<option value="administrator" selected>Administrátor</option>' . "\n");
                                    echo('<option value="uzivatel" >Uživatel</option>' . "\n");
                                } else {
                                    echo('<option value="administrator">Administrátor</option>' . "\n");
                                    echo('<option value="uzivatel" selected>Uživatel</option>' . "\n");
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group <?php echo (!empty($telefon_err)) ? 'has-error' : ''; ?>">
                        <label>Telefon: </label>
                        <input type="text" name="telefon" class="form-control" value="<?php echo $telefon; ?>">
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Heslo<span style="color: red;">*</span>: </label>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" <?php if ((isset($editace)) && ($editace == true)) { echo ('readonly');} ?> >
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label>Heslo znovu<span style="color: red;">*</span>: </label>
                        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" <?php if ((isset($editace)) && ($editace == true)) { echo ('readonly');} ?> >
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <?php
                        if ((isset($editace)) && ($editace == true)) {
                            echo('<input type="submit" class="btn btn-edit" value="Editovat">' . "\n");
                            echo('<input type="reset" class="btn btn-default" value="Reset">' . "\n");
                        } else {
                            echo('<input type="submit" class="btn btn-primary" value="Založit">' . "\n");
                            echo('<input type="reset" class="btn btn-default" value="Reset">' . "\n");
                            echo('<p>Máte již účet? <a href="prihlaseni.php">Přihlaste se</a>.</p>' . "\n");
                        }
                        ?>
                    </div>
                </form>
            </div>
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