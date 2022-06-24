<?php
require "../config.php";
require "../models/mediji.php";

if(isset($_POST['id'])) {
    $status = Mediji::deleteById($_POST['id'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}