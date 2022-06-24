<?php

require "../config.php";
require "../models/mediji.php";

if(isset($_POST['id'])) {
    $myArray = Mediji::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}