<?php
require_once __DIR__ . '/../generic/modelo.php';

$managementFiles = new FilesUpload;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
    $results = $managementFiles->upload($_FILES['photos'], 'leagues/' . 1);

    foreach($results as $message) {
        echo $message . '<br>';
    }
}