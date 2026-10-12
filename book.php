<?php
// ===============================================
// Confirms a booking -> validates + inserts into MySQL
// Called from confirmBooking() in the frontend
// ===============================================
require_once "config/db.php";

$package     = trim($_POST['package'] ?? '');
$travelDate  = $_POST['travelDate'] ?? '';
$name        = trim($_POST['name'] ?? '');
$email       = trim($_POST['email'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$persons     = (int)($_POST['persons'] ?? 0);
$roomType    = $_POST['roomType'] ?? '';
$roomPrice   = (float)($_POST['roomPrice'] ?? 0);
$foodPlan    = $_POST['foodPlan'] ?? '';
$foodPrice   = (float)($_POST['foodPrice'] ?? 0);
$specialReq  = trim($_POST['specialRequest'] ?? '');
$packagePrice = (float)($_POST['packagePrice'] ?? 0);

// --- Server-side validation ---
if ($package === '') send_json(["success" => false, "message" => "Please select a tour package."]);
if ($travelDate === '' || strtotime($travelDate) < strtotime(date('Y-m-d'))) {
    send_json(["success" => false, "message" => "Please select a valid future travel date."]);
}
if (strlen($name) < 3) send_json(["success" => false, "message" => "Enter your full name."]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) send_json(["success" => false, "message" => "Enter a valid email."]);
if (!preg_match('/^[0-9]{10}$/', $phone)) send_json(["success" => false, "message" => "Enter a valid 10-digit phone number."]);
if ($persons < 1 || $persons > 20) send_json(["success" => false, "message" => "Persons must be between 1 and 20."]);
if ($roomType === '') send_json(["success" => false, "message" => "Please select a room."]);
if ($foodPlan === '') send_json(["success" => false, "message" => "Please select a food plan."]);

$total = ($packagePrice * $persons) + ($roomPrice * $persons) + ($foodPrice * $persons);
$bookingRef = "RMD-" . rand(1000, 9999);

$stmt = $conn->prepare(
    "INSERT INTO bookings
     (booking_ref, customer_name, customer_email, customer_phone, package_name, travel_date,
      persons, room_type, room_price, food_plan, food_price, special_request, total_amount, status)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed')"
);

$stmt->bind_param(
    "ssssssisdsdsd",
    $bookingRef, $name, $email, $phone, $package, $travelDate,
    $persons, $roomType, $roomPrice, $foodPlan, $foodPrice, $specialReq, $total
);

if ($stmt->execute()) {
    send_json([
        "success" => true,
        "message" => "Booking confirmed! ID: $bookingRef",
        "booking" => [
            "id" => $bookingRef,
            "package" => $package,
            "date" => $travelDate,
            "persons" => $persons,
            "total" => $total
        ]
    ]);
} else {
    send_json(["success" => false, "message" => "Booking failed: " . $conn->error]);
}
?>
