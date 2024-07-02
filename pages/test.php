<?php
// $server = "localhost";
// $username = "root";
// $password = "";
// $dbname = "tmkn";

$server = "sql110.infinityfree.com";
$username = "if0_36809232";
$password = "nJxBSD8H2mO";
$dbname = "if0_36809232_Tamakan";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// Test a simple query
$sql = "SELECT 1";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Query executed successfully";
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
