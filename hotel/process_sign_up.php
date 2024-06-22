<?php
include 'koneksi.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement to insert into guests table
$sql = "INSERT INTO guests (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";

if ($conn->query($sql) === TRUE) {
    header('Location: sign_in.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
