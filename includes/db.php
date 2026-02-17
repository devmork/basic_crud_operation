<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "seams_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Database connection failed. Please check your configuration.");
}

mysqli_set_charset($conn, "utf8mb4");
?>