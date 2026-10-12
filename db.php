<?php
// ===============================================
// RMD - Reach More Destinations
// Database connection (MySQLi)
// ===============================================

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";          // set your MySQL password here
$DB_NAME = "rmd_travel";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");

// Common helper to send JSON responses back to the frontend
function send_json($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}
?>
