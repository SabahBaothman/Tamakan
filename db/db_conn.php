<?php
// $server = "sql110.infinityfree.com";
// $username = "if0_36809232";
// $password = "nJxBSD8H2mO";
// $dbname = "if0_36809232_Tamakan";

$server = "localhost";
$username = "root";
$password = "";
$dbname = "tmkn";

$conn =  mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {

    echo "Connection failed!";
}

?>