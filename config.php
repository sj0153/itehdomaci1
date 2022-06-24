<?php
$host = "localhost";
$db = "wolfz";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_errno) {
    exit("There was an error while trying to connect with database." . $conn->connect_errno);
}