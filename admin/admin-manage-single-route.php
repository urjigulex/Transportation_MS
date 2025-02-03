<?php
// Include the database connection file
include('vendor/inc/config.php');

// Fetch and process form data (if applicable)
if (isset($_POST['update_route'])) {
    $route_name = $_POST['route_name'];
    $route_start = $_POST['route_start'];
    $route_end = $_POST['route_end'];
    $route_distance = $_POST['route_distance'];
    $route_status = $_POST['route_status'];
    $route_id = $_GET['route_id'];

    // Update query
    $update_query = "UPDATE tms_route SET route_name = ?, start_point = ?, end_point = ?, distance = ?, status = ? WHERE route_id = ?";
    $stmt_update = $mysqli->prepare($update_query);
    $stmt_update->bind_param('sssssi', $route_name, $route_start, $route_end, $route_distance, $route_status, $route_id);

    if ($stmt_update->execute()) {
        $succ = "Route updated successfully!";
    } else {
        $err = "Failed to update route. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <!-- Start Navigation Bar -->
    <?php include("vendor/inc/nav.php"); ?>
    <!-- End Navigation Bar -->

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

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Routes</a>
                    </li>
                    <li class="breadcrumb-item active">Update Route</li>
                </ol>
                <hr>

                <div class="card">
                    <div class="card-header">
                        Update Route
                    </div>
                    <div class="card-body">
                        <!-- Update Route Form -->
                        <?php
                        $route_id = $_GET['route_id'];
                        $ret = "SELECT * FROM tms_route WHERE route_id = ?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $route_id);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>

                        <form method="POST">
                            <div class="form-group">
                                <label for="routeName">Route Name</label>
                                <input type="text" value="<?php echo $row->route_name; ?>" required class="form-control"
                                    id="routeName" name="route_name">
                            </div>

                            <div class="form-group">
                                <label for="routeStart">Route Start</label>
                                <input type="text" value="<?php echo $row->start_point; ?>" required
                                    class="form-control" id="routeStart" name="route_start">
                            </div>

                            <div class="form-group">
                                <label for="routeEnd">Route End</label>
                                <input type="text" value="<?php echo $row->end_point; ?>" required class="form-control"
                                    id="routeEnd" name="route_end">
                            </div>

                            <div class="form-group">
                                <label for="routeDistance">Route Distance (km)</label>
                                <input type="number" value="<?php echo $row->distance; ?>" required class="form-control"
                                    id="routeDistance" name="route_distance" step="0.1"
                                    placeholder="Enter the distance">
                            </div>

                            <div class="form-group">
                                <label for="routeStatus">Route Status</label>
                                <select class="form-control" name="route_status" id="routeStatus">
                                    <option value="Active" <?php if ($row->status == 'Active') echo 'selected'; ?>>
                                        Active</option>
                                    <option value="Inactive" <?php if ($row->status == 'Inactive') echo 'selected'; ?>>
                                        Inactive</option>
                                </select>
                            </div>

                            <button type="submit" name="update_route" class="btn btn-primary">Update Route</button>
                        </form>

                        <?php } ?>

                    </div>
                </div>
                <hr>

                <!-- Sticky Footer -->
                <?php include("vendor/inc/footer.php"); ?>

            </div>
        </div>
    </div>

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