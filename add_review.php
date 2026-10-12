<?php
// ===============================================
// Saves a traveler review
// Called from submitReview() in the frontend
// ===============================================
require_once "config/db.php";

$name    = trim($_POST['name'] ?? '');
$rating  = (int)($_POST['rating'] ?? 0);
$comment = trim($_POST['comment'] ?? '');

if ($name === '') send_json(["success" => false, "message" => "Name is required."]);
if ($rating < 1 || $rating > 5) send_json(["success" => false, "message" => "Please select a rating."]);
if (strlen($comment) < 5) send_json(["success" => false, "message" => "Please write a proper comment."]);

$stmt = $conn->prepare("INSERT INTO reviews (name, rating, comment) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $rating, $comment);

if ($stmt->execute()) {
    send_json(["success" => true, "message" => "Thank you $name! Your $rating★ review has been submitted."]);
} else {
    send_json(["success" => false, "message" => "Submission failed: " . $conn->error]);
}
?>
