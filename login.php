<?php
// ===============================================
// Logs a user in, starts a PHP session
// ===============================================
session_start();
require_once "config/db.php";

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    send_json(["success" => false, "message" => "Enter a valid email address."]);
}
if (strlen($password) < 6) {
    send_json(["success" => false, "message" => "Password must be at least 6 characters."]);
}

$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    send_json(["success" => false, "message" => "No account found with this email."]);
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    send_json(["success" => false, "message" => "Incorrect password."]);
}

// Store session
$_SESSION['user_id']   = $user['id'];
$_SESSION['user_name'] = $user['name'];

send_json(["success" => true, "message" => "Login successful! Welcome " . $user['name']]);
?>
