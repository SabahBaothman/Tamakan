<?php
// $server = "sql110.infinityfree.com";
// $username = "if0_36809232";
// $password = "nJxBSD8H2mO";
// $dbname = "if0_36809232_Tamakan";

$server = "localhost";
$username = "root";
$password = "";
$dbname = "tmkn";


$conn = new mysqli($server, $username, $password, $dbname);

// $conn =  mysqli_connect($server, $username, $password, $dbname, $port);

if (!$conn) {

    echo "Connection failed!";
}

?>