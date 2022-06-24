<?php

require "../config.php";
require "../models/mediji.php";

if (isset($_POST['idM']) && isset($_POST['nazivM']) && isset($_POST['zemljaM'])
    && isset($_POST['karakter_medija']) && isset($_POST['god_osnivanjaM'])) {

    $status = Mediji::update($_POST['idM'], $_POST['nazivM'], $_POST['zemljaM'], $_POST['karakter_medija'], $_POST['god_osnivanjaM'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}