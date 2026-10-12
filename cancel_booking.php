<?php
// ===============================================
// Cancels (deletes) a booking record
// Called from cancelBooking() in the frontend
// ===============================================
require_once "config/db.php";

$bookingRef = trim($_POST['booking_ref'] ?? '');

if ($bookingRef === '') {
    send_json(["success" => false, "message" => "Booking reference is required."]);
}

$stmt = $conn->prepare("DELETE FROM bookings WHERE booking_ref = ?");
$stmt->bind_param("s", $bookingRef);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        send_json(["success" => true, "message" => "Booking cancelled successfully."]);
    } else {
        send_json(["success" => false, "message" => "Booking not found."]);
    }
} else {
    send_json(["success" => false, "message" => "Cancellation failed: " . $conn->error]);
}
?>
