<?php
session_start(); // Pastikan session dimulai sebelum memproses data

include 'koneksi.php'; // Sertakan file koneksi

// Pastikan user telah login atau memiliki sesi yang sesuai sebelum memproses pembaruan booking
if (!isset($_SESSION['guest_id'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Validasi bahwa data yang diterima dari form POST sesuai dan tidak kosong
if (
    isset($_POST['booking_id']) &&
    !empty($_POST['booking_id']) &&
    isset($_POST['booking_name']) &&
    !empty($_POST['booking_name']) &&
    isset($_POST['booking_email']) &&
    !empty($_POST['booking_email']) &&
    isset($_POST['checkin']) &&
    !empty($_POST['checkin']) &&
    isset($_POST['checkout']) &&
    !empty($_POST['checkout']) &&
    isset($_POST['adults']) &&
    !empty($_POST['adults']) &&
    isset($_POST['children']) &&
    !empty($_POST['children']) &&
    isset($_POST['room_type']) &&
    !empty($_POST['room_type']) &&
    isset($_POST['special_request']) // Special request bisa kosong, jadi tidak perlu cek empty
) {
    // Ambil data dari form POST
    $booking_id = $_POST['booking_id'];
    $booking_name = $_POST['booking_name'];
    $booking_email = $_POST['booking_email'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $room_type = $_POST['room_type'];
    $special_request = $_POST['special_request'];

    // Sanitasi dan validasi input bisa ditambahkan di sini jika diperlukan
    
    // Siapkan query SQL untuk update data booking menggunakan prepared statements
    $sql_update_booking = "UPDATE bookings 
                           SET name = ?, email = ?, check_in = ?, check_out = ?, adults = ?, children = ?, room_type = ?, special_request = ? 
                           WHERE booking_id = ?";
    $stmt_update_booking = $conn->prepare($sql_update_booking);
    $stmt_update_booking->bind_param("ssssssssi", $booking_name, $booking_email, $checkin, $checkout, $adults, $children, $room_type, $special_request, $booking_id);

    // Eksekusi statement
    if ($stmt_update_booking->execute()) {
        // Jika berhasil diupdate, arahkan kembali ke halaman detail booking
        header("Location: booking_detail.php?booking_id=" . $booking_id);
        exit();
    } else {
        // Jika gagal update, beri feedback error
        echo "Error updating booking: " . $stmt_update_booking->error;
    }

    // Tutup statement
    $stmt_update_booking->close();
} else {
    // Jika data yang diterima tidak lengkap atau tidak sesuai, beri pesan error
    echo "Error: All fields are required.";
}

// Tutup koneksi database
$conn->close();
?>
