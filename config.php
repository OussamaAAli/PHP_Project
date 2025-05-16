<?php


$server = "localhost";
$username = "root";
$password = "";
$database = "php_hotel";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("<script>alert('Connection failed.')</script>");
}

?>