<?php
// ===============================================
// Updates an existing booking's travel date / persons / status
// Demonstrates: UPDATE operation
// ===============================================
require_once "config/db.php";

$bookingRef = trim($_POST['booking_ref'] ?? '');
$travelDate = $_POST['travelDate'] ?? '';
$persons    = (int)($_POST['persons'] ?? 0);
$status     = trim($_POST['status'] ?? '');

if ($bookingRef === '') {
    send_json(["success" => false, "message" => "Booking reference is required."]);
}

// Build dynamic update depending on what was sent
$fields = [];
$types  = "";
$values = [];

if ($travelDate !== '') {
    if (strtotime($travelDate) < strtotime(date('Y-m-d'))) {
        send_json(["success" => false, "message" => "Travel date cannot be in the past."]);
    }
    $fields[] = "travel_date = ?";
    $types .= "s";
    $values[] = $travelDate;
}

if ($persons > 0) {
    $fields[] = "persons = ?";
    $types .= "i";
    $values[] = $persons;
}

if ($status !== '') {
    $fields[] = "status = ?";
    $types .= "s";
    $values[] = $status;
}

if (empty($fields)) {
    send_json(["success" => false, "message" => "Nothing to update."]);
}

$types .= "s";
$values[] = $bookingRef;

$sql = "UPDATE bookings SET " . implode(", ", $fields) . " WHERE booking_ref = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$values);

if ($stmt->execute()) {
    send_json(["success" => true, "message" => "Booking updated successfully."]);
} else {
    send_json(["success" => false, "message" => "Update failed: " . $conn->error]);
}
?>
