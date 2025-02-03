<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Update Shipment
if (isset($_POST['update_shipment'])) {
    $shipment_id = $_GET['shipment_id'];
    $shipment_name = $_POST['shipment_name'];
    $shipment_description = $_POST['shipment_description'];
    $shipment_weight = $_POST['shipment_weight']; // Weight entered manually by you
    $shipment_origin = $_POST['shipment_origin'];
    $shipment_destination = $_POST['shipment_destination'];
    $shipment_status = $_POST['shipment_status'];

    // Update SQL query for shipment table
    $query = "UPDATE tms_shipment 
              SET shipment_name=?, shipment_description=?, shipment_weight=?, shipment_origin=?, shipment_destination=?, status=? 
              WHERE shipment_id=?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssdsssi', $shipment_name, $shipment_description, $shipment_weight, $shipment_origin, $shipment_destination, $shipment_status, $shipment_id);
    $stmt->execute();

    if ($stmt) {
        $succ = "Shipment Updated Successfully";
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
                <!-- Success Alert -->
                <script>
                setTimeout(function() {
                    swal("Success!", "<?php echo $succ; ?>!", "success");
                }, 100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                <!-- Error Alert -->
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
                    <li class="breadcrumb-item active">Manage Shipment</li>
                </ol>
                <hr>

                <div class="card">
                    <div class="card-header">
                        Update Shipment
                    </div>
                    <div class="card-body">
                        <!-- Fetch shipment details -->
                        <?php
                        $shipment_id = $_GET['shipment_id'];
                        $ret = "SELECT * FROM tms_shipment WHERE shipment_id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $shipment_id);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>
                        <!-- Update Shipment Form -->
                        <form method="POST">
                            <div class="form-group">
                                <label for="shipmentName">Shipment Name</label>
                                <input type="text" value="<?php echo $row->shipment_name; ?>" required
                                    class="form-control" id="shipmentName" name="shipment_name">
                            </div>

                            <div class="form-group">
                                <label for="shipmentDescription">Shipment Description</label>
                                <textarea required class="form-control" id="shipmentDescription"
                                    name="shipment_description"><?php echo $row->shipment_description; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="shipmentWeight">Shipment Weight (kg)</label>
                                <input type="number" required class="form-control" id="shipmentWeight"
                                    name="shipment_weight" step="0.1" value="<?php echo $row->shipment_weight; ?>"
                                    placeholder="Enter weight">
                            </div>

                            <div class="form-group">
                                <label for="shipmentOrigin">Shipment Origin</label>
                                <input type="text" required class="form-control" id="shipmentOrigin"
                                    name="shipment_origin" value="<?php echo $row->shipment_origin; ?>">
                            </div>

                            <div class="form-group">
                                <label for="shipmentDestination">Shipment Destination</label>
                                <input type="text" required class="form-control" id="shipmentDestination"
                                    name="shipment_destination" value="<?php echo $row->shipment_destination; ?>">
                            </div>

                            <div class="form-group">
                                <label for="shipmentStatus">Shipment Status</label>
                                <select class="form-control" name="shipment_status" id="shipmentStatus">
                                    <option <?php if ($row->status == 'In Transit') echo 'selected'; ?>>In Transit
                                    </option>
                                    <option <?php if ($row->status == 'Delivered') echo 'selected'; ?>>Delivered
                                    </option>
                                    <option <?php if ($row->status == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option <?php if ($row->status == 'Cancelled') echo 'selected'; ?>>Cancelled
                                    </option>
                                </select>
                            </div>

                            <button type="submit" name="update_shipment" class="btn btn-primary">Update
                                Shipment</button>
                        </form>
                        <?php } ?>
                        <!-- End Form -->
                    </div>
                </div>

                <hr>

                <!-- Sticky Footer -->
                <?php include("vendor/inc/footer.php"); ?>

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