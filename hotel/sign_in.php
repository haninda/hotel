<?php
session_start();
include 'koneksi.php';

// Check for cookies and set session if valid
if (isset($_COOKIE['email']) && isset($_COOKIE['pass'])) {
    $email = $_COOKIE['email'];
    $pass = $_COOKIE['pass'];
    $result = mysqli_query($conn, "SELECT * FROM guests WHERE email='$email' AND password='$pass'");
    if (mysqli_num_rows($result) === 1) {
        $guest = mysqli_fetch_assoc($result);
        $_SESSION['guest_id'] = $guest['guest_id'];
        header("Location: index.php");
        exit();
    }
}

// Check session
if (isset($_SESSION['guest_id'])) {
    header("Location: index.php");
    exit();
}

// Authenticate login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $result = mysqli_query($conn, "SELECT * FROM guests WHERE email='$email' AND password='$pass'");
    if (mysqli_num_rows($result) === 1) {
        $guest = mysqli_fetch_assoc($result);
        $_SESSION['guest_id'] = $guest['guest_id'];
        header("Location: index.php");
        exit();
    }
    $error = true;
}

include 'header.php';
?>

<!-- Page Header -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
    <!-- Header content here -->
</div>

<!-- Sign In Form -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Sign In</h2>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            Invalid email or password.
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="pass" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="login">Sign In</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Don't have an account yet? <a href="sign_up.php">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
