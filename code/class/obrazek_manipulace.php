<?php
if ($_FILES['foto_vozu']['size'] != 0 && $_FILES['foto_vozu']['error'] == 0) {
    $name = $_FILES['foto_vozu']['name'];
    $size = $_FILES['foto_vozu']['size'];
    $type = $_FILES['foto_vozu']['type'];
    $tmp_name = $_FILES['foto_vozu']['tmp_name'];

    $dir = "../image/" . $last_id;
    if (!file_exists($dir) || !is_dir($dir)) {
        mkdir($dir);
    }
    move_uploaded_file($tmp_name, $dir . "/" . $name);
}
?>