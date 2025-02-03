<?php
include('../usr/vendor/inc/config.php');
include('../usr/vendor/inc/checklogin.php');
$secretKey = 'CHASECK_TEST-hfr3typcekR3tE4Bp5W8fIFQBYI12sE3';

// Handle the callback response after Chapa processes the payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $responseData = json_decode(file_get_contents('php://input'), true);

    // Check if the payment was successful
    if ($responseData['status'] === 'success' && $responseData['data']['status'] === 'successful') {
        // Payment was successful, now create the booking record in the database

        $u_id = $_SESSION['u_id'];
        $u_car_type = $_SESSION['u_car_type'];
        $u_car_regno = $_SESSION['u_car_regno'];
        $u_car_price = $_SESSION['u_car_price'];
        $u_car_bookdate = $_SESSION['u_car_bookdate'];
        $u_car_book_status = 'Confirmed'; // Set status to confirmed after payment

        // Insert booking data into tms_user table
        $query = "INSERT INTO tms_user (u_id, u_car_type, u_car_regno, u_car_price, u_car_bookdate, u_car_book_status)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('issdss', $u_id, $u_car_type, $u_car_regno, $u_car_price, $u_car_bookdate, $u_car_book_status);

        if ($stmt->execute()) {
            // Booking was successful, redirect or show success message
            header("Location: payment_success.php");
            exit();
        } else {
            // Handle errors, booking failed
            echo "Error processing your booking.";
        }
    } else {
        echo "Payment was not successful.";
    }
}
?>
