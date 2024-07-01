<?php
session_start();
include 'koneksi.php';

// Check if user is not logged in, redirect to sign_in.php
if (!isset($_SESSION['guest_id'])) {
    header("Location: sign_in.php");
    exit();
}

// Validate and sanitize input data
$guest_id = $_SESSION['guest_id'];
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

try {
    // Begin transaction
    $conn->begin_transaction();

    // Update guest details
    $sql = "UPDATE guests SET name = ?, email = ?, phone = ? WHERE guest_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $phone, $guest_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update guest details");
    }

    // Update password if provided
    if (!empty($password)) {
        $sql = "UPDATE guests SET password = ? WHERE guest_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $password, $guest_id); // Directly bind the plaintext password
        if (!$stmt->execute()) {
            throw new Exception("Failed to update password");
        }
    }

    // Commit transaction
    $conn->commit();
    header("Location: profile.php?update=success");
} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();
    header("Location: profile.php?update=error");
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
