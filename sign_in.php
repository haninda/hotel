<?php
// session_start();
include 'header.php'; 
include 'koneksi.php';
// error_reporting(E_ALL); // Uncomment for debugging purposes

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is already logged in using cookies
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
    $result = mysqli_query($conn, "SELECT * FROM guests WHERE email='$email'");
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            header("Location: index.php");
            exit;
        }
    }
}

// Check if user is already logged in using session
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

// Process login authentication
if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Query to find user with matching email
    $result = mysqli_query($conn, "SELECT * FROM guests WHERE email='$email'");
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            header("Location: index.php");
            exit;
        }
    }

    // Set error flag if authentication fails
    $error = true;
}
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
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
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
