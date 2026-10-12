<?php
// ===============================================
// Retrieves booking records, optionally filtered by email
// Called to populate "My Booking" section
// ===============================================
require_once "config/db.php";

$email = isset($_GET['email']) ? trim($_GET['email']) : "";

if ($email !== "") {
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE customer_email = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
}

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

send_json(["success" => true, "bookings" => $bookings]);
?>
