<?php 
include 'header.php';
include 'koneksi.php';

// Cek apakah ada parameter ID booking yang dikirimkan
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Query untuk mengambil data booking berdasarkan ID
    $sql = "SELECT b.*, t.amount, t.payment_method, t.transaction_status 
            FROM bookings b 
            LEFT JOIN transactions t ON b.booking_id = t.booking_id 
            WHERE b.booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    } else {
        // Jika booking tidak ditemukan
        echo "Booking tidak ditemukan.";
        exit;
    }
} else {
    // Jika tidak ada parameter ID yang dikirimkan
    echo "ID booking tidak ditemukan.";
    exit;
}

// Proses update data booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari form
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $room_id = $_POST['room'];
    $special_request = $_POST['special_request'];

    // Query untuk mendapatkan harga kamar berdasarkan ID
    $price_query = "SELECT price FROM rooms WHERE room_id = ?";
    $price_stmt = $conn->prepare($price_query);
    $price_stmt->bind_param("i", $room_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result();
    $room_price = $price_result->fetch_assoc()['price'];

    // Menghitung jumlah malam
    $checkin_date = new DateTime($checkin);
    $checkout_date = new DateTime($checkout);
    $interval = $checkin_date->diff($checkout_date);
    $nights = $interval->days;
    $amount = $room_price * $nights;

    // Update data booking
    $update_sql = "UPDATE bookings SET check_in = ?, check_out = ?, adults = ?, children = ?, special_request = ?, room_id = ? WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssiisii", $checkin, $checkout, $adults, $children, $special_request, $room_id, $booking_id);

    if ($update_stmt->execute()) {
        // Update transaksi jika ada perubahan jumlah
        $transaction_update_sql = "UPDATE transactions SET amount = ?, transaction_status = 'Pending' WHERE booking_id = ?";
        $transaction_update_stmt = $conn->prepare($transaction_update_sql);
        $transaction_update_stmt->bind_param("di", $amount, $booking_id);
        $transaction_update_stmt->execute();

        // Redirect untuk mengkonfirmasi pembayaran ulang jika jumlah berubah
        header("Location: payment.php?booking_id=" . $booking_id);
        exit();
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}

// Mendapatkan semua tipe kamar
$roomTypes = [];
$sql = "SELECT room_id, room_type, price FROM rooms";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $roomTypes[] = $row;
}
?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Booking Detail</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="booking_list.php">Booking List</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Booking Detail</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Booking Detail Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Booking</h6>
            <h1 class="mb-5">Booking <span class="text-primary text-uppercase">Detail</span></h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <h3>Booking Information</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Check In: <?php echo htmlspecialchars($booking['check_in']); ?></li>
                        <li class="list-group-item">Check Out: <?php echo htmlspecialchars($booking['check_out']); ?></li>
                        <li class="list-group-item">Adults: <?php echo htmlspecialchars($booking['adults']); ?></li>
                        <li class="list-group-item">Children: <?php echo htmlspecialchars($booking['children']); ?></li>
                        <li class="list-group-item">Special Request: <?php echo htmlspecialchars($booking['special_request']); ?></li>
                        <li class="list-group-item">Booking At: <?php echo htmlspecialchars($booking['created_at']); ?></li>
                        <li class="list-group-item">Amount: <?php echo htmlspecialchars($booking['amount']); ?></li>
                        <li class="list-group-item">Payment Method: <?php echo htmlspecialchars($booking['payment_method']); ?></li>
                        <li class="list-group-item">Transaction Status: <?php echo htmlspecialchars($booking['transaction_status']); ?></li>
                    </ul>
                </div>
                <?php if ($booking['transaction_status'] != 'Completed') { ?>
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <a href="payment.php?booking_id=<?php echo htmlspecialchars($booking['booking_id']); ?>" class="btn btn-success w-100 py-3 mt-3">Payment</a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.4s">
                    <h3>Edit Booking</h3>
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating date" id="checkin_date" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" id="checkin" name="checkin" placeholder="Check In" value="<?php echo htmlspecialchars($booking['check_in']); ?>" data-target="#checkin_date" data-toggle="datetimepicker" />
                                    <label for="checkin">Check In</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating date" id="checkout_date" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" id="checkout" name="checkout" placeholder="Check Out" value="<?php echo htmlspecialchars($booking['check_out']); ?>" data-target="#checkout_date" data-toggle="datetimepicker" />
                                    <label for="checkout">Check Out</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select1" name="adults">
                                        <option value="1" <?php if ($booking['adults'] == 1) echo 'selected'; ?>>Adults: 1</option>
                                        <option value="2" <?php if ($booking['adults'] == 2) echo 'selected'; ?>>Adults: 2</option>
                                        <option value="3" <?php if ($booking['adults'] == 3) echo 'selected'; ?>>Adults: 3</option>
                                    </select>
                                    <label for="select1">Select Adults</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select2" name="children">
                                        <option value="0" <?php if ($booking['children'] == 0) echo 'selected'; ?>>Children: 0</option>
                                        <option value="1" <?php if ($booking['children'] == 1) echo 'selected'; ?>>Children: 1</option>
                                        <option value="2" <?php if ($booking['children'] == 2) echo 'selected'; ?>>Children: 2</option>
                                        <option value="3" <?php if ($booking['children'] == 3) echo 'selected'; ?>>Children: 3</option>
                                    </select>
                                    <label for="select2">Select Children</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" id="select3" name="room" onchange="updatePrice(this)">
                                        <?php foreach ($roomTypes as $room) { ?>
                                            <option value="<?php echo $room['room_id']; ?>" data-price="<?php echo $room['price']; ?>" <?php if ($booking['room_id'] == $room['room_id']) echo 'selected'; ?>>
                                                Room Type: <?php echo $room['room_type']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <label for="select3">Select Room Type</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Special Request" id="special_request" name="special_request" style="height: 100px"><?php echo htmlspecialchars($booking['special_request']); ?></textarea>
                                    <label for="special_request">Special Request</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Update Booking</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-12">
                        <a href="booking_cancel.php?booking_id=<?php echo htmlspecialchars($booking['booking_id']); ?>" 
                           class="btn btn-danger w-100 py-3 mt-2" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Cancel Booking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking Detail End -->

<script>
function updatePrice(selectElement) {
    var price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');
    // Here you can handle the price change if needed, for example, display it somewhere in the form
    console.log("Selected Room Price: " + price);
}
</script>

<?php include 'footer.php'; ?>
