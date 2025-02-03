<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Add Shipment
if (isset($_POST['add_shipment'])) {
    $shipment_name = $_POST['shipment_name'];
    $shipment_description = $_POST['shipment_description'];
    $shipment_weight = $_POST['shipment_weight']; // Weight entered manually by you
    $shipment_origin = $_POST['shipment_origin'];
    $shipment_destination = $_POST['shipment_destination'];
    $shipment_status = $_POST['shipment_status'];

    // Corrected SQL query with shipment fields
    $query = "INSERT INTO tms_shipment (shipment_name, shipment_description, shipment_weight, shipment_origin, shipment_destination, status) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssdsss', $shipment_name, $shipment_description, $shipment_weight, $shipment_origin, $shipment_destination, $shipment_status);
    $stmt->execute();

    if ($stmt) {
        $succ = "Shipment Added Successfully";
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
                        <a href="#">Shipments</a>
                    </li>
                    <li class="breadcrumb-item active">Add Shipment</li>
                </ol>
                <hr>

                <div class="card">
                    <div class="card-header">Add Shipment</div>
                    <div class="card-body">
                        <!-- Add Shipment Form -->
                        <form method="POST">
                            <div class="form-group">
                                <label for="shipmentName">Shipment Name</label>
                                <input type="text" required class="form-control" id="shipmentName" name="shipment_name">
                            </div>

                            <div class="form-group">
                                <label for="shipmentDescription">Shipment Description</label>
                                <textarea required class="form-control" id="shipmentDescription"
                                    name="shipment_description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="shipmentWeight">Shipment Weight (kg)</label>
                                <input type="number" required class="form-control" id="shipmentWeight"
                                    name="shipment_weight" step="0.1" placeholder="Enter weight">
                            </div>

                            <div class="form-group">
                                <label for="shipmentOrigin">Shipment Origin</label>
                                <input type="text" required class="form-control" id="shipmentOrigin"
                                    name="shipment_origin">
                            </div>

                            <div class="form-group">
                                <label for="shipmentDestination">Shipment Destination</label>
                                <input type="text" required class="form-control" id="shipmentDestination"
                                    name="shipment_destination">
                            </div>

                            <div class="form-group">
                                <label for="shipmentStatus">Shipment Status</label>
                                <select class="form-control" name="shipment_status" id="shipmentStatus">
                                    <option>In Transit</option>
                                    <option>Delivered</option>
                                    <option>Pending</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>

                            <button type="submit" name="add_shipment" class="btn btn-primary">Add Shipment</button>
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