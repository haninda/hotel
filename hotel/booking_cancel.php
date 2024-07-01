<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi.php sudah menyediakan koneksi ke database

// Validasi bahwa data yang diterima dari GET atau POST sesuai dan tidak kosong
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Mulai transaksi untuk memastikan operasi bersifat atomic
    $conn->begin_transaction();

    try {
        // Hapus data transaksi berdasarkan booking_id
        $sql_delete_transaction = "DELETE FROM transactions WHERE booking_id=?";
        $stmt_delete_transaction = $conn->prepare($sql_delete_transaction);
        $stmt_delete_transaction->bind_param("i", $booking_id);
        $stmt_delete_transaction->execute();
        $stmt_delete_transaction->close();

        // Hapus data pembayaran berdasarkan transaction_id yang terkait
        $sql_get_transaction_id = "SELECT transaction_id FROM transactions WHERE booking_id=?";
        $stmt_get_transaction_id = $conn->prepare($sql_get_transaction_id);
        $stmt_get_transaction_id->bind_param("i", $booking_id);
        $stmt_get_transaction_id->execute();
        $result_get_transaction_id = $stmt_get_transaction_id->get_result();

        if ($result_get_transaction_id->num_rows > 0) {
            $transaction_id = $result_get_transaction_id->fetch_assoc()["transaction_id"];
            $stmt_get_transaction_id->close();

            // Hapus data pembayaran berdasarkan transaction_id
            $sql_delete_payment = "DELETE FROM payments WHERE transaction_id=?";
            $stmt_delete_payment = $conn->prepare($sql_delete_payment);
            $stmt_delete_payment->bind_param("i", $transaction_id);
            $stmt_delete_payment->execute();
            $stmt_delete_payment->close();
        }

        // Hapus data booking berdasarkan booking_id
        $sql_delete_booking = "DELETE FROM bookings WHERE booking_id=?";
        $stmt_delete_booking = $conn->prepare($sql_delete_booking);
        $stmt_delete_booking->bind_param("i", $booking_id);
        $stmt_delete_booking->execute();
        $stmt_delete_booking->close();

        // Commit transaksi jika berhasil
        $conn->commit();

        // Beri feedback kepada pengguna bahwa booking berhasil dibatalkan
        header("Location: profile.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();

        // Beri pesan error kepada pengguna
        echo "Error canceling booking: " . $e->getMessage();
    }

    // Tutup koneksi database
    $conn->close();
} else {
    // Jika data yang diterima tidak lengkap atau tidak sesuai, beri pesan error
    echo "Error: Booking ID not found.";
}
?>
