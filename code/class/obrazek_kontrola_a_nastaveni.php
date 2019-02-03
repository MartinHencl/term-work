<?php

$cesta = "../image/" . $vuz->getIdVozidla() . "/";
if (!file_exists($cesta) || !is_dir($cesta)) {
    $prvniSoubor = "../image/mercedes-benz-c-class-vehicle-model-banner.jpg";
} else {
    $soubory = scandir($cesta);
    if (empty($soubory)) {
        $prvniSoubor = "../image/mercedes-benz-c-class-vehicle-model-banner.jpg";
    } else {
        $prvniSoubor = $cesta . $soubory[2];// because [0] = "." [1] = ".."
    }
}
?>