<?php
$servername = "localhost";
$username = "flowershop";
$password = "rIZza01*";
$db = "flower_db";


$connect = new mysqli($servername, $username, $password, $db);


if($connect->connect_error) {
    die("Error!" . $connect->$connect_error);
}

echo "Connected!";

?>
