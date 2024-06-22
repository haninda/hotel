<?php
// Melakukan koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel3"; // Sesuaikan dengan nama database Anda

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
