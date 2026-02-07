<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "ecommerce"; 

// Change this to 3309 to match your XAMPP
$port = "3309"; 

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>