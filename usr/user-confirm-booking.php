<?php 
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  $secretKey = 'CHASECK_TEST-hfr3typcekR3tE4Bp5W8fIFQBYI12sE3';
  check_login();
  $aid = $_SESSION['u_id'];

  // Fetch the logged-in user's data (first name, last name, email)
  $u_id = $_SESSION['u_id'];
  $query = "SELECT u_fname, u_lname, u_email FROM tms_user WHERE u_id = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('i', $u_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  
  // Add Booking
  if (isset($_POST['book_vehicle'])) {
    $u_car_type = $_POST['u_car_type'];
    $u_car_regno = $_POST['u_car_regno'];
    $u_car_price = $_POST['u_car_price'];
    $u_car_bookdate = $_POST['u_car_bookdate'];
    $u_car_book_status = $_POST['u_car_book_status'];

    // Insert a new booking record into the database
    $query = "UPDATE tms_user SET u_car_type = ?, u_car_regno = ?, u_car_price = ?, u_car_bookdate = ?, u_car_book_status = ? WHERE u_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssi', $u_car_type, $u_car_regno, $u_car_price, $u_car_bookdate, $u_car_book_status, $u_id);
    if ($stmt->execute()) {
        $succ = "Booking Submitted Successfully!";
    } else {
        $err = "Error! Please Try Again.";
    }

    // Validate inputs
    $amount = $_POST['u_car_price']; // Price from the vehicle info

    if (!is_numeric($amount) || $amount <= 0) {
        die("Invalid amount.");
    }

    // Proceed to Chapa API (use the second code)
    $txRef = uniqid('tx_'); // Unique transaction reference
    $data = [
        'amount' => $amount,
        'currency' => 'ETB',
        'email' => $user['email'],  // Using email from the database
        'first_name' => $user['first_name'],  // Using first name from the database
        'last_name' => $user['last_name'],  // Using last name from the database
        'tx_ref' => $txRef,
        'callback_url' => 'http://localhost/transport/payment/payment_callback.php',
        'return_url' => 'http://localhost/transport/payment/payment_success.php',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.chapa.co/v1/transaction/initialize");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $secretKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if ($responseData && $responseData['status'] === 'success') {
        header('Location: ' . $responseData['data']['checkout_url']);
        exit();
    } else {
        echo 'Payment initiation failed.';
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

<body id="page-top">
 <!--Start Navigation Bar-->
  <?php include("vendor/inc/nav.php");?>
  <!--Navigation Bar-->

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include("vendor/inc/sidebar.php");?>
    <!--End Sidebar-->
    <div id="content-wrapper">

      <div class="container-fluid">
      <?php if(isset($succ)) {?>
                        <!--This code for injecting an alert-->
        <script>
                    setTimeout(function () 
                    { 
                        swal("Success!","<?php echo $succ;?>!","success");
                    },
                        100);
        </script>

        <?php } ?>
        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
        <script>
                    setTimeout(function () 
                    { 
                        swal("Failed!","<?php echo $err;?>!","Failed");
                    },
                        100);
        </script>

        <?php } ?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="user-dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item">Vehicle</li>
          <li class="breadcrumb-item ">Book Vehicle</li>
          <li class="breadcrumb-item active">Confirm Booking</li>
        </ol>
        <hr>
        <div class="card">
        <div class="card-header">
          Confirm Booking
        </div>
        <div class="card-body">
          <!--Add User Form-->
          <?php
            $aid=$_GET['v_id'];
            $ret="select * from tms_vehicle where v_id=?";
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('i',$aid);
            $stmt->execute() ;//ok
            $res=$stmt->get_result();
            //$cnt=1;
            while($row=$res->fetch_object())
        {
        ?>
   <form method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Vehicle Category</label>
    <input type="text" value="<?php echo $row->v_category; ?>" readonly class="form-control" name="u_car_type">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Vehicle Registration Number</label>
    <input type="text" value="<?php echo $row->v_reg_no; ?>" readonly class="form-control" name="u_car_regno">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Price</label>
    <input type="text" value="<?php echo $row->v_price; ?>" readonly class="form-control" name="u_car_price">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Booking Date</label>
    <input type="date" class="form-control" id="exampleInputEmail1" name="u_car_bookdate" required>
  </div>
  <div class="form-group" style="display:none">
    <label for="exampleInputEmail1">Book Status</label>
    <input type="text" value="Pending" class="form-control" id="exampleInputEmail1" name="u_car_book_status">
  </div>
  <!-- Remove these input fields as we are getting data from the database -->
  <div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" name="first_name" value="<?php echo $user['u_fname']; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" name="last_name" value="<?php echo $user['u_lname']; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" value="<?php echo $user['u_email']; ?>" readonly>
  </div>
  <button type="submit" name="book_vehicle" class="btn btn-primary">Confirm Booking</button>
</form>


          <!-- End Form-->
        <?php }?>
        </div>
      </div>
       
      <hr>
     

      <!-- Sticky Footer -->
      <?php include("vendor/inc/footer.php");?>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="admin-logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="vendor/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="vendor/js/demo/datatables-demo.js"></script>
  <script src="vendor/js/demo/chart-area-demo.js"></script>
 <!--INject Sweet alert js-->
 <script src="vendor/js/swal.js"></script>

</body>

</html>
