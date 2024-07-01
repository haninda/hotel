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
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement to insert into guests table
$sql = "INSERT INTO guests (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";

if ($conn->query($sql) === TRUE) {
    header('Location: sign_in.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<?php
// Melakukan koneksi database
$servername = "localhost";
$username = "id22362582_svthotel";
$password = "SVTHotel17$";
$dbname = "id22362582_hotel"; // Sesuaikan dengan nama database Anda

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
