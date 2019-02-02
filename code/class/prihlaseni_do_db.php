<?php
    /*define('DB_SERVER', 'localhost:3036');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'rootpassword');
    define('DB_DATABASE', 'database');*/

    define('DB_SERVER', 'db');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'docker');
    define('DB_DATABASE', 'term_db');
    define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);
    define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . parse_url($_SERVER["REQUEST_URI"]));
    define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']."/");
    define("PDF_UPLOADS", DOC_ROOT."uploads/");

    //$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_USERNAME, DB_PASSWORD );
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

if(!$pdo) {
    //echo "Connection error: " . mysqli_error();
    $prihlaseni_k_databazi_zprava = "Connection error: "; // . mysqli_error();
    exit();
} else {
    //echo "Prihlaseni OK ";
    $prihlaseni_k_databazi_zprava = "Prihlaseni k DB OK ";
}
?>