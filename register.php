<?php
// ===============================================
// Registers a new user (server-side validation + insert)
// ===============================================
require_once "config/db.php";

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$phone    = trim($_POST['phone'] ?? '');

// --- Server-side validation ---
if ($name === '' || strlen($name) < 3) {
    send_json(["success" => false, "message" => "Name must be at least 3 characters."]);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    send_json(["success" => false, "message" => "Enter a valid email address."]);
}
if (strlen($password) < 6) {
    send_json(["success" => false, "message" => "Password must be at least 6 characters."]);
}
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    send_json(["success" => false, "message" => "Enter a valid 10-digit phone number."]);
}

// Check duplicate email
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    send_json(["success" => false, "message" => "This email is already registered."]);
}

// Hash password and insert
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed, $phone);

if ($stmt->execute()) {
    send_json(["success" => true, "message" => "Registration successful! Please login."]);
} else {
    send_json(["success" => false, "message" => "Registration failed: " . $conn->error]);
}
?>
