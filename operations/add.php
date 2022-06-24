<?php
require "../config.php";
require "../models/mediji.php";

if (isset($_POST['naziv']) && isset($_POST['zemlja']) 
    && isset($_POST['karakter_medija']) && isset($_POST['god_osnivanja'])) {
    $status = Mediji::add($_POST['naziv'], $_POST['zemlja'], $_POST['karakter_medija'], $_POST['god_osnivanja'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}