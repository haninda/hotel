<?php include 'header.php';?>

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
                        <li class="list-group-item">Name: John Doe</li>
                        <li class="list-group-item">Email: john.doe@example.com</li>
                        <li class="list-group-item">Check In: 2024-07-01</li>
                        <li class="list-group-item">Check Out: 2024-07-05</li>
                        <li class="list-group-item">Adults: 2</li>
                        <li class="list-group-item">Children: 1</li>
                        <li class="list-group-item">Room Type: Deluxe Room</li>
                    </ul>
                </div>
                <div class="wow fadeInUp mt-4" data-wow-delay="0.4s">
                    <h3>Payment Summary</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Room Price: $200 per night</li>
                        <li class="list-group-item">Number of Nights: 4</li>
                        <li class="list-group-item">Subtotal: $800</li>
                        <li class="list-group-item">Tax (10%): $80</li>
                        <li class="list-group-item"><strong>Total: $880</strong></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <h3>Payment Details</h3>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Card Holder Name">
                                    <label for="name">Card Holder Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="card_number" placeholder="Card Number">
                                    <label for="card_number">Card Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="expiry_date" placeholder="Expiry Date (MM/YY)">
                                    <label for="expiry_date">Expiry Date (MM/YY)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cvv" placeholder="CVV">
                                    <label for="cvv">CVV</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="billing_address" placeholder="Billing Address">
                                    <label for="billing_address">Billing Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Email">
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

<?php include 'footer.php';?>
