<?php
session_start(); // Pastikan session_start() sudah dijalankan jika menggunakan session
include 'koneksi.php'; // File untuk koneksi ke database
include 'header.php';
// Tampilkan semua error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
   
// Ambil transaction_id dari GET parameter atau cookie
if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];
    setcookie('transaction_id', $transaction_id, time() + (86400 * 30), "/"); // Atur cookie dengan transaction_id
} elseif (isset($_COOKIE['transaction_id'])) {
    $transaction_id = $_COOKIE['transaction_id'];
} else {
    echo "Transaction ID not found.";
    exit();
}
// echo "Transaction ID: " . $transaction_id . "<br>";
   
// Query database untuk detail transaksi berdasarkan transaction_id
$sql_transaction = "SELECT * FROM transactions WHERE transaction_id = ?";
$stmt_transaction = $conn->prepare($sql_transaction);
$stmt_transaction->bind_param("i", $transaction_id);
$stmt_transaction->execute();
$result_transaction = $stmt_transaction->get_result();
   
if ($result_transaction === false || $result_transaction->num_rows === 0) {
    echo "Transaction data not found.";
    exit();
}
   
$transaction = $result_transaction->fetch_assoc();
$booking_id = $transaction['booking_id']; // Ambil booking_id dari hasil transaksi
   
// Query database untuk detail booking berdasarkan booking_id
$sql_booking = "SELECT b.*, g.name, g.email 
                FROM bookings b
                JOIN guests g ON b.guest_id = g.guest_id
                WHERE b.booking_id = ?";
$stmt_booking = $conn->prepare($sql_booking);
$stmt_booking->bind_param("i", $booking_id);
$stmt_booking->execute();
$result_booking = $stmt_booking->get_result();
   
if ($result_booking === false || $result_booking->num_rows === 0) {
    echo "Booking data not found.";
    exit();
}
   
$booking = $result_booking->fetch_assoc();
// print_r($booking); // Uncomment for debugging
   
$guest_name = $booking['name'];
$guest_email = $booking['email'];
$check_in = $booking['check_in']; // Sesuaikan dengan nama kolom yang ada di tabel
$check_out = $booking['check_out']; // Sesuaikan dengan nama kolom yang ada di tabel
$adults = $booking['adults']; // Sesuaikan dengan nama kolom yang ada di tabel
$children = $booking['children']; // Sesuaikan dengan nama kolom yang ada di tabel
$room_id = $booking['room_id']; // Sesuaikan dengan nama kolom yang ada di tabel
   
$amount = $transaction['amount'];
$payment_method = $transaction['payment_method'];
$transaction_status = $transaction['transaction_status'];

// Process form submission for payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $card_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_STRING);
    $expiry_date = filter_input(INPUT_POST, 'expiry_date', FILTER_SANITIZE_STRING);
    $cvv = filter_input(INPUT_POST, 'cvv', FILTER_SANITIZE_STRING);
    $billing_address = filter_input(INPUT_POST, 'billing_address', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Validate required fields
    if (empty($name) || empty($card_number) || empty($expiry_date) || empty($cvv) || empty($billing_address) || empty($email)) {
        echo "All fields are required.";
        exit();
    }

    // Prepare and execute payment insertion
    $sql_insert_payment = "INSERT INTO payments (transaction_id, booking_id, guest_id, payment_date, amount, payment_method, payment_status, created_at) 
                           VALUES (?, ?, ?, NOW(), ?, ?, 'Success', NOW())";
    $stmt_insert_payment = $conn->prepare($sql_insert_payment);
    if (!$stmt_insert_payment) {
        echo "Prepare failed: " . $conn->error;
        exit();
    }

    // Bind parameters and execute insertion
    $guest_id = $_SESSION['guest_id']; // Assuming guest_id is stored in session
    
    $stmt_insert_payment->bind_param("iiiss", $transaction_id, $booking_id, $guest_id, $amount, $payment_method);
    if (!$stmt_insert_payment->execute()) {
        echo "Execute failed: " . $stmt_insert_payment->error;
        exit();
    }

    // Update transaction status to 'Completed'
    $sql_update_transaction = "UPDATE transactions SET transaction_status = 'Completed' WHERE transaction_id = ?";
    $stmt_update_transaction = $conn->prepare($sql_update_transaction);
    if (!$stmt_update_transaction) {
        echo "Prepare failed: " . $conn->error;
        exit();
    }
    $stmt_update_transaction->bind_param("i", $transaction_id);
    if (!$stmt_update_transaction->execute()) {
        echo "Execute failed: " . $stmt_update_transaction->error;
        exit();
    }

    // Redirect to payment success page
    header("Location: payment_success.php");
    exit();
}
?>
   
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Payment & Transaction Summary</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="booking.php">Booking</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Payment</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->
   
<!-- Transaction Summary & Payment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Transaction & Payment</h6>
            <h1 class="mb-5">Your <span class="text-primary text-uppercase">Transaction Summary</span> & <span class="text-primary text-uppercase">Make A Payment</span></h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <h3>Booking Details</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Name: <?php echo htmlspecialchars($guest_name); ?></li>
                        <li class="list-group-item">Email: <?php echo htmlspecialchars($guest_email); ?></li>
                        <li class="list-group-item">Check In: <?php echo htmlspecialchars($check_in); ?></li>
                        <li class="list-group-item">Check Out: <?php echo htmlspecialchars($check_out); ?></li>
                        <li class="list-group-item">Adults: <?php echo htmlspecialchars($adults); ?></li>
                        <li class="list-group-item">Children: <?php echo htmlspecialchars($children); ?></li>
                    </ul>
                    <h3>Payment Details</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Amount: Rp<?php echo number_format($amount, 0, ',', '.'); ?></li>
                        <li class="list-group-item">Payment Method: <?php echo htmlspecialchars($payment_method); ?></li>
                        <li class="list-group-item">Transaction Status: <?php echo htmlspecialchars($transaction_status); ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <!-- <h3>Payment Details</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Amount: <?php echo htmlspecialchars($amount); ?></li>
                        <li class="list-group-item">Payment Method: <?php echo htmlspecialchars($payment_method); ?></li>
                        <li class="list-group-item">Transaction Status: <?php echo htmlspecialchars($transaction_status); ?></li>
                    </ul> -->
                    <h3 class="mt-5">Make a Payment</h3>
                    <form action="" method="POST">
                        <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking_id); ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Card Holder Name" required>
                                    <label for="name">Card Holder Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Card Number" required>
                                    <label for="card_number">Card Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="Expiry Date (MM/YY)" required>
                                    <label for="expiry_date">Expiry Date (MM/YY)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" required>
                                    <label for="cvv">CVV</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="billing_address" name="billing_address" placeholder="Billing Address" required>
                                    <label for="billing_address">Billing Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Pay Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Transaction Summary & Payment End -->

<?php include 'footer.php'; ?>
