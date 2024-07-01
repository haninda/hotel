<?php
session_start();
include 'koneksi.php'; // Ensure this file contains a valid database connection

// Check if user is not logged in, redirect to sign_in.php
if (!isset($_SESSION['guest_id'])) {
    header("Location: sign_in.php");
    exit();
}

$current_guest_id = $_SESSION['guest_id'];

// Query untuk mengambil booking_id berdasarkan guest_id yang login saat ini
$sql_bookings = mysqli_query($conn, "SELECT booking_id FROM bookings WHERE guest_id = $current_guest_id");

$guest_bookings = [];
while ($row = mysqli_fetch_assoc($sql_bookings)) {
    $bookings[] = $row;
}

// Fetch guest details from database based on session guest_id
$guest_id = $_SESSION['guest_id'];
$sql_guest = "SELECT * FROM guests WHERE guest_id = ?";
$stmt_guest = $conn->prepare($sql_guest);
$stmt_guest->bind_param("i", $guest_id);
$stmt_guest->execute();
$guest = $stmt_guest->get_result()->fetch_assoc();

// Include header.php to maintain consistency
include 'header.php';

?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Guest Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Profile Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Profile</h6>
            <h1 class="mb-5">Your <span class="text-primary text-uppercase">Profile</span></h1>
        </div>
        <div class="row g-5">
            <!-- Profile Details -->
            <div class="col-lg-4">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <h3>Profile Details</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Name: <?php echo htmlspecialchars($guest['name']); ?></li>
                        <li class="list-group-item">Email: <?php echo htmlspecialchars($guest['email']); ?></li>
                        <li class="list-group-item">Phone: <?php echo htmlspecialchars($guest['phone']); ?></li>
                    </ul>
                    <a href="sign_out.php" class="btn btn-danger w-100 mt-3">Sign Out</a>
                </div>
            </div>
            <!-- Update Profile -->
            <div class="col-lg-8">
                <div class="wow fadeInUp" data-wow-delay="0.4s">
                    <h3>Update Profile</h3>
                    <form action="update_profile.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($guest['name']); ?>">
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($guest['email']); ?>">
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Your Phone" value="<?php echo htmlspecialchars($guest['phone']); ?>">
                                    <label for="phone">Your Phone</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                                    <label for="password">New Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-5 mt-5">
            <!-- Booking Details -->
            <div class="col-12">
                <div class="wow fadeInUp" data-wow-delay="0.6s">
                    <h3>Booking Details</h3>
                    <?php if (count($bookings) > 0): 
                        ?>
                        <ul class="list-group">
                            <?php foreach ($bookings as $booking): ?>
                            <li class="list-group-item">
                                Booking #
                                <a href="booking_detail.php?booking_id=<?php echo htmlspecialchars($booking['booking_id']); ?>" class="btn btn-primary btn-sm float-end">View Details</a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No bookings made yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Profile End -->

<?php include 'footer.php'; ?>
