<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Add Route
if (isset($_POST['add_route'])) {
    $route_name = $_POST['route_name'];
    $route_start = $_POST['route_start'];
    $route_end = $_POST['route_end'];
    $route_status = $_POST['route_status'];
    $route_distance = $_POST['route_distance'];  // Distance entered manually by you

    // Corrected SQL query with distance field
    $query = "INSERT INTO tms_route (route_name, start_point, end_point, distance, status) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssis', $route_name, $route_start, $route_end, $route_distance, $route_status);
    $stmt->execute();

    if ($stmt) {
        $succ = "Route Added Successfully";
    } else {
        $err = "Please Try Again Later";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <!-- Start Navigation Bar -->
    <?php include("vendor/inc/nav.php"); ?>
    <!-- Navigation Bar -->

    <div id="wrapper">
        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php"); ?>
        <!-- End Sidebar -->

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                <script>
                setTimeout(function() {
                    swal("Success!", "<?php echo $succ; ?>!", "success");
                }, 100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                <script>
                setTimeout(function() {
                    swal("Failed!", "<?php echo $err; ?>!", "error");
                }, 100);
                </script>
                <?php } ?>

                <!-- Breadcrumbs -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Routes</a>
                    </li>
                    <li class="breadcrumb-item active">Add Route</li>
                </ol>
                <hr>

                <div class="card">
                    <div class="card-header">Add Route</div>
                    <div class="card-body">
                        <!-- Add Route Form -->
                        <form method="POST">
                            <div class="form-group">
                                <label for="routeName">Route Name</label>
                                <input type="text" required class="form-control" id="routeName" name="route_name">
                            </div>
                            <div class="form-group">
                                <label for="routeStart">Route Start</label>
                                <input type="text" required class="form-control" id="routeStart" name="route_start">
                            </div>
                            <div class="form-group">
                                <label for="routeEnd">Route End</label>
                                <input type="text" required class="form-control" id="routeEnd" name="route_end">
                            </div>
                            <div class="form-group">
                                <label for="routeDistance">Route Distance (km)</label>
                                <input type="number" required class="form-control" id="routeDistance"
                                    name="route_distance" step="0.1" placeholder="Enter the distance">
                            </div>
                            <div class="form-group">
                                <label for="routeStatus">Route Status</label>
                                <select class="form-control" name="route_status" id="routeStatus">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" name="add_route" class="btn btn-primary">Add Route</button>
                        </form>

                        <!-- End Form -->
                    </div>
                </div>
                <hr>

                <!-- Sticky Footer -->
                <?php include("vendor/inc/footer.php"); ?>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="vendor/js/sb-admin.min.js"></script>

    <!-- Sweet Alert -->
    <script src="vendor/js/swal.js"></script>
</body>

</html>