<?php
require_once  __DIR__ . "/../generic/modelo.php";

$fileManager = new FilesUpload();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
    $resultado = $fileManager->upload($_FILES['photos'], 'img/' . 2);

    foreach($resultado as $message) {
        echo $message . '<br>';
    }
}