<?php
session_start();
include 'header.php'; // Pastikan file header.php sesuai dengan struktur situs Anda
?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Payment Successful</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Payment Successful</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Payment Success Message Start -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="card-title">Payment Successful</h2>
                    <p class="card-text">Your payment has been successfully processed.</p>
                    <a href="index.php" class="btn btn-primary">Back to Home</a>
                    <a href="profile.php" class="btn btn-secondary">Go to Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Payment Success Message End -->

<?php include 'footer.php'; // Pastikan file footer.php sesuai dengan struktur situs Anda ?>
