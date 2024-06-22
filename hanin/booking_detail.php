<?php include 'header.php';?>
<!-- HALO -->
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Booking Detail</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
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
                        <li class="list-group-item">Booking ID: 1</li>
                        <li class="list-group-item">Name: John Doe</li>
                        <li class="list-group-item">Email: john.doe@example.com</li>
                        <li class="list-group-item">Check In: 2024-07-01</li>
                        <li class="list-group-item">Check Out: 2024-07-05</li>
                        <li class="list-group-item">Adults: 2</li>
                        <li class="list-group-item">Children: 1</li>
                        <li class="list-group-item">Room Type: Deluxe Room</li>
                        <li class="list-group-item">Special Request: None</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.4s">
                    <h3>Edit Booking</h3>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_name" placeholder="Booking Name" value="John Doe">
                                    <label for="booking_name">Booking Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="booking_email" placeholder="Booking Email" value="john.doe@example.com">
                                    <label for="booking_email">Booking Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating date" id="checkin_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="checkin" placeholder="Check In" value="2024-07-01" data-target="#checkin_date" data-toggle="datetimepicker" />
                                    <label for="checkin">Check In</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating date" id="checkout_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="checkout" placeholder="Check Out" value="2024-07-05" data-target="#checkout_date" data-toggle="datetimepicker" />
                                    <label for="checkout">Check Out</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select1">
                                        <option value="1" selected>Adults: 2</option>
                                        <option value="2">Adults: 1</option>
                                        <option value="3">Adults: 3</option>
                                    </select>
                                    <label for="select1">Select Adults</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select2">
                                        <option value="1" selected>Children: 1</option>
                                        <option value="2">Children: 2</option>
                                        <option value="3">Children: 3</option>
                                    </select>
                                    <label for="select2">Select Children</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" id="select3">
                                        <option value="1" selected>Room Type: Deluxe Room</option>
                                        <option value="2">Room Type: Suite</option>
                                        <option value="3">Room Type: Standard Room</option>
                                    </select>
                                    <label for="select3">Select Room Type</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Special Request" id="message" style="height: 100px">None</textarea>
                                    <label for="message">Special Request</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Save Changes</button>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-danger w-100 py-3 mt-3" type="button">Cancel Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking Detail End -->

<?php include 'footer.php';?>

