<?php



// TAK PINDAH JADI 1 DI SIGN_IN.PHP



session_start();
include 'koneksi.php';

// Cek koneksi ke database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cek apakah pengguna sudah login menggunakan cookie
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
    $result = mysqli_query($conn, "SELECT * FROM guests WHERE email='$email'");
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            header("Location: index.php");
            exit;
        }
    }
}

// Cek apakah pengguna sudah login menggunakan session
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

// Proses autentikasi login
if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Query untuk mencari pengguna dengan email yang sesuai
    $result = mysqli_query($conn, "SELECT * FROM guests WHERE email='$email'");
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;

            // Redirect ke halaman utama setelah login berhasil
            header("Location: index.php");
            exit;
        } else {
            // Jika password tidak cocok, set flag error
            $error = true;
        }
    } else {
        // Jika email tidak ditemukan, set flag error
        $error = true;
    }
}
?>
