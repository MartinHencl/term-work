<?php
//ob_start(); // predkesovani cele stranky a zobrazeni az najednou
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Include config file
require_once("../class/prihlaseni_do_db.php");

// Define variables and initialize with empty values
$username = $password = $id = $hashed_password = $jmeno = $prijmeni = $role = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Je potřeba vložit email.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Je potřeba vložit heslo.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT ID_UZIVATEL, EMAIL, HESLO, JMENO, PRIJMENI, ROLE FROM UZIVATEL WHERE EMAIL = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["ID_UZIVATEL"];
                        $username = $row["EMAIL"];
                        $hashed_password = $row["HESLO"];
                        $jmeno = $row["JMENO"];
                        $prijmeni = $row["PRIJMENI"];
                        $role = $row["ROLE"];

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["ID_UZIVATEL"] = $id;
                            $_SESSION["EMAIL"] = $username;
                            $_SESSION["JMENO"] = $jmeno;
                            $_SESSION["PRIJMENI"] = $prijmeni;
                            $_SESSION["ROLE"] = $role;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "Zadané heslo není správně.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "Žádný takový účet není.";
                }
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
        require_once ("./stejne_casti/login_top.php");
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
            <h2>Přihlášení</h2>
                <p>Formulář pro přihlášení:</p>
                <form accept-charset="utf-8" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Uživatelské jméno (email): </label>
                        <input type="email" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Heslo: </label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Přihlásit se">
                    </div>
                    <p>Nemáte účet? <a href="zalozeni_uctu.php">Založte si ho</a>.</p>
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