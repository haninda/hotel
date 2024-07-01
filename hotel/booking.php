<?php
session_start();
include 'header.php';
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['guest_id'])) {
    header("Location: sign_in.php");
    exit();
}

function getRoomTypes($conn) {
    $sql = "SELECT room_id, room_type, price FROM rooms WHERE availability = TRUE";
    $result = $conn->query($sql);

    $roomTypes = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roomTypes[$row['room_id']] = array(
                'room_type' => $row['room_type'],
                'price' => $row['price']
            );
        }
    }
    return $roomTypes;
}

$name = $email = $checkin = $checkout = $adults = $children = $room_id = $special_request = $price_per_night = $amount = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guest_id = $_SESSION['guest_id'];
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $checkin = new DateTime($_POST['checkin']);
    $checkout = new DateTime($_POST['checkout']);
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $room_id = $_POST['room'];
    $special_request = filter_input(INPUT_POST, 'special_request', FILTER_SANITIZE_STRING);

    $today = new DateTime();
    $today->setTime(0, 0);

    if ($checkin < $today) {
        $_SESSION['error'] = 'Check-in date cannot be before today.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if ($checkout < $checkin) {
        $_SESSION['error'] = 'Check-out date cannot be before today.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $price_per_night = (double)$_POST['price'];
    if (!is_numeric($price_per_night)) {
        $_SESSION['error'] = 'Failed to parse room price.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $interval = $checkin->diff($checkout);
    $nights = $interval->days;
    if ($nights <= 0) {
        $_SESSION['error'] = 'Check-out date must be later than check-in date.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    $amount = $nights * $price_per_night;

    $checkin_str = $checkin->format('Y-m-d');
    $checkout_str = $checkout->format('Y-m-d');

    $sql = "INSERT INTO bookings (guest_id, room_id, check_in, check_out, adults, children, special_request) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = "Prepare failed: " . $conn->error;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->bind_param("iississ", $guest_id, $room_id, $checkin_str, $checkout_str, $adults, $children, $special_request);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        $_SESSION['booking_id'] = $booking_id;

        $payment_method = "Credit Card";
        $transaction_status = "Pending";

        $sql = "INSERT INTO transactions (booking_id, guest_id, amount, payment_method, transaction_status) 
        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $_SESSION['error'] = "Prepare failed: " . $conn->error;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        $stmt->bind_param("iidss", $booking_id, $guest_id, $amount, $payment_method, $transaction_status);

        if ($stmt->execute()) {
            $_SESSION['transaction_id'] = $stmt->insert_id;
            setcookie('booking_id', $_SESSION['transaction_id'], time() + (86400 * 30), "/");

            header("Location: payment.php?transaction_id=" . $_SESSION['transaction_id']);
            exit();
        } else {
            $_SESSION['error'] = "Failed to insert transaction: " . $stmt->error;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

    } else {
        $_SESSION['error'] = "Failed to insert booking: " . $stmt->error;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$roomTypes = getRoomTypes($conn);
?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Booking</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Booking Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Room Booking</h6>
            <h1 class="mb-5">Book A <span class="text-primary text-uppercase">Luxury Room</span></h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="row g-3">
                    <!-- Your images here -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("errorMessage").innerText = "' . $_SESSION['error'] . '";
                                document.getElementById("errorButton").click();
                            });
                            </script>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" id="checkin" name="checkin" placeholder="Check In" min="<?php echo date('Y-m-d'); ?>" required>
                                    <label for="checkin">Check In</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" id="checkout" name="checkout" placeholder="Check Out" required>
                                    <label for="checkout">Check Out</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select1" name="adults" required>
                                        <option value="1">Adult 1</option>
                                        <option value="2">Adult 2</option>
                                        <option value="3">Adult 3</option>
                                    </select>
                                    <label for="select1">Select Adult</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select2" name="children" required>
                                        <option value="0">No Children</option>
                                        <option value="1">Child 1</option>
                                        <option value="2">Child 2</option>
                                        <option value="3">Child 3</option>
                                    </select>
                                    <label for="select2">Select Child</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" id="select3" name="room" required onchange="updatePrice(this)">
                                        <option value="" disabled selected>Select A Room</option>
                                        <?php foreach ($roomTypes as $room_id => $room_data): ?>
                                            <option value="<?php echo $room_id; ?>" data-price="<?php echo $room_data['price']; ?>"><?php echo $room_data['room_type']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" id="price" name="price" value="">
                                    <label for="select3">Select A Room</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Special Request" id="special_request" name="special_request" style="height: 100px"></textarea>
                                    <label for="special_request">Special Request</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Book Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->

<!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#errorModal" style="display:none;" id="errorButton">
    Launch error modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="errorModalLabel">Error</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="errorMessage">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>


<script>
function updatePrice(selectElement) {
    var price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');
    document.getElementById('price').value = price;
}
</script>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        var checkin = document.getElementById('checkin').value;
        var checkout = document.getElementById('checkout').value;
        var today = new Date().toISOString().split('T')[0];

        if (checkin < today) {
            event.preventDefault();
            alert('Tanggal check-in tidak boleh sebelum hari ini.');
        }

        if (checkout <= checkin) {
            event.preventDefault();
            alert('Tanggal checkout harus setelah tanggal check-in.');
        }
    });
});
</script>
