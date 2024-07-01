<?php
session_start();
include 'koneksi.php'; // Pastikan file ini memiliki koneksi database yang benar

// Periksa apakah pengguna telah login
if (!isset($_SESSION['guest_id'])) {
    header("Location: sign_in.php");
    exit();
}

$current_guest_id = $_SESSION['guest_id'];

// Periksa apakah formulir telah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Validasi data (minimal memastikan tidak ada input yang kosong)
    if (empty($name) || empty($email) || empty($phone)) {
        echo "All fields except password are required.";
        exit();
    }

    // Mulai query pembaruan
    $query = "UPDATE guests SET name = ?, email = ?, phone = ?";
    $types = "sss";
    $params = [$name, $email, $phone];

    // Jika password diisi, tambahkan ke query
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", password = ?";
        $types .= "s";
        $params[] = $hashed_password;
    }

    $query .= " WHERE guest_id = ?";
    $types .= "i";
    $params[] = $current_guest_id;

    // Persiapkan dan jalankan statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
        // Redirect to the profile page or any other appropriate page
        header("Location: profile.php");
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>
