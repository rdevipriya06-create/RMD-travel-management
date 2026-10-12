<?php
// ===============================================
// Saves a contact/enquiry form submission
// Called from submitEnquiry() in the frontend
// ===============================================
require_once "config/db.php";

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '') send_json(["success" => false, "message" => "Name is required."]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) send_json(["success" => false, "message" => "Enter a valid email."]);
if (!preg_match('/^[0-9]{10}$/', $phone)) send_json(["success" => false, "message" => "Enter a valid 10-digit phone number."]);
if (strlen($message) < 5) send_json(["success" => false, "message" => "Please write a proper message."]);

$stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

if ($stmt->execute()) {
    send_json(["success" => true, "message" => "Your enquiry has been submitted successfully!"]);
} else {
    send_json(["success" => false, "message" => "Submission failed: " . $conn->error]);
}
?>
