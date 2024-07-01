<?php
// Melakukan koneksi database
include "koneksi.php";

// Mengambil data dari tabel rooms
$query_rooms = mysqli_query($conn, "SELECT * FROM rooms ORDER BY room_id ASC");

// Check if the query was successful
if (!$query_rooms) {
    die("Query failed: " . mysqli_error($conn));
}

// Mengambil data dari tabel services
$query_services = mysqli_query($conn, "SELECT * FROM services ORDER BY services_id ASC");

// Check if the query was successful
if (!$query_services) {
    die("Query failed: " . mysqli_error($conn));
}

include 'header.php';
?>

<!-- Carousel Start -->
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">Luxury Living</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown">Discover A Brand Luxurious Hotel</h1>
                                <a href="room.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Our Rooms</a>
                                <a href="booking.php" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Book A Room</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">Luxury Living</h6>
                                <h1 class="display-3 text-white mb-4 animated slideInDown">Discover A Brand Luxurious Hotel</h1>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Our Rooms</a>
                                <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Book A Room</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->



        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">About Us</h6>
                        <h1 class="mb-4">Welcome to <span class="text-primary text-uppercase">SVT Hotel</span></h1>
                        <h5 class="mb-2">Kemewahan dan Kenyamanan di Jantung Kota</h5>
                        <p class="mb-4">Mengundang anda untuk merasakan perpaduan sempurna antara kenyamanan modern dan keanggunan klasik di jantung kota. Terletak strategis di tengah pusat bisnis dan hiburan, hotel kami menawarkan akses mudah ke berbagai destinasi utama sambil tetap menjadi oase ketenangan dan kemewahan.</p>
                        <!-- <a class="btn btn-primary py-3 px-5 mt-2" href="">Explore More</a> -->
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Room Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Our Rooms</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Rooms</span></h1>
                </div>
                <div class="row g-4">
                    <?php while ($data = mysqli_fetch_array($query_rooms)) { ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="room-item shadow rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="img/room-1.jpg" alt="">
                                <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">Rp<?php echo number_format($data['price'], 0, ',', '.'); ?>/Night</small>

                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0"><?php echo $data['room_type']; ?></h5>
                                    <div class="ps-2">
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i><?php echo $data['bed']; ?> Bed</small>
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i><?php echo $data['bath']; ?> Bath</small>
                                    <?php if ($data['wifi'] == 1) { ?>
                                        <small class="border-end me-3 pe-3"><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                    <?php } ?>
                                </div>
                                <p class="text-body mb-3"><?php echo $data['description']; ?></p>
                                <div class="d-flex justify-content-between">
                                <a href="booking.php?room_id=<?php echo htmlspecialchars($data['room_id']); ?>" ;
                                class="btn btn-sm btn-dark rounded py-2 px-4">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Room End -->

        <!-- Service Start -->
        <div class="container-xxl py-5 my-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Our Services</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Services</span></h1>
                </div>
                <div class="row g-4">
                    <?php while ($data = mysqli_fetch_array($query_services)) { ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <?php 
                                    // Menentukan kelas ikon berdasarkan services_id
                                    switch ($data['services_id']) {
                                        case 1:
                                            $icon_class = 'fa fa-hotel fa-2x text-primary';
                                            break;
                                        case 2:
                                            $icon_class = 'fa fa-utensils fa-2x text-primary';
                                            break;
                                        case 3:
                                            $icon_class = 'fa fa-spa fa-2x text-primary';
                                            break;
                                        case 4:
                                            $icon_class = 'fa fa-swimmer fa-2x text-primary';
                                            break;
                                        case 5:
                                            $icon_class = 'fa fa-glass-cheers fa-2x text-primary';
                                            break;
                                        case 6:
                                            $icon_class = 'fa fa-dumbbell fa-2x text-primary';
                                            break;
                                        default:
                                            $icon_class = 'fa fa-concierge-bell fa-2x text-primary'; // Ikon default
                                            break;
                                    }
                                    ?>
                                    <i class="<?php echo htmlspecialchars($icon_class); ?>"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php echo htmlspecialchars($data['services_name']); ?></h5>
                            <p class="text-body mb-0" style="text-align: justify;"><?php echo htmlspecialchars($data['services_desc']); ?></p>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Service End -->

<?php include 'footer.php';?>
