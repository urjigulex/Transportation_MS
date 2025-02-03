<?php
session_start();
include('vendor/inc/config.php'); // Configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Usr-login'])) {
  $u_email = trim($_POST['u_email']);
  $u_pwd = $_POST['u_pwd'];

  // Check if email and password match in the database
  $stmt = $mysqli->prepare("SELECT u_id, u_email FROM tms_user WHERE u_email = ? AND u_pwd = ?");
  $stmt->bind_param('ss', $u_email, $u_pwd);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    // Bind results
    $stmt->bind_result($u_id, $u_email_db);
    $stmt->fetch();

    // Start session and log user details
    $_SESSION['u_id'] = $u_id;
    $_SESSION['login'] = $u_email_db;

    // Log user IP and optional location
    $uip = $_SERVER['REMOTE_ADDR'];
    $city = "Unknown"; // Replace with a geolocation API for accurate data
    $country = "Unknown";

    // Log user activity
    $log_stmt = $mysqli->prepare("INSERT INTO userLog (u_id, u_email, u_ip, u_city, u_country) VALUES (?, ?, ?, ?, ?)");
    $log_stmt->bind_param('issss', $u_id, $u_email_db, $uip, $city, $country);
    $log_stmt->execute();

    // Redirect to dashboard
    header("Location: user-dashboard.php");
    exit;
  } else {
    $error = "Invalid email or password.";
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Transport Management System - Client Login</title>

    <!-- Custom fonts and styles -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <!-- Display Sweet Alert on Error -->
                <?php if (isset($error)) { ?>
                <script>
                setTimeout(function() {
                    swal("Failed!", "<?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>", "error");
                }, 100);
                </script>
                <?php } ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="u_email" id="inputEmail" class="form-control"
                                placeholder="Email address" required autofocus>
                            <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="u_pwd" id="inputPassword" class="form-control"
                                placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <input type="submit" name="Usr-login" class="btn btn-primary btn-block" value="Login">
                </form>

                <div class="text-center">
                    <a class="d-block small mt-3" href="usr-register.php">Register an Account</a>
                    <a class="d-block small" href="usr-forgot-password.php">Forgot Password?</a>
                    <a class="d-block small" href="../index.php">Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/js/swal.js"></script>
</body>

</html>