<?php
// ===============================================
// Search / filter packages by destination or name
// Called from searchDestination() in the frontend
// ===============================================
require_once "config/db.php";

$keyword = isset($_GET['q']) ? trim($_GET['q']) : "";

if ($keyword === "") {
    send_json(["success" => false, "message" => "Please enter a search term."]);
}

$stmt = $conn->prepare(
    "SELECT id, name, destination, duration, price, description
     FROM packages
     WHERE name LIKE ? OR destination LIKE ?"
);

$like = "%" . $keyword . "%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();

$packages = [];
while ($row = $result->fetch_assoc()) {
    $packages[] = $row;
}

send_json(["success" => true, "count" => count($packages), "results" => $packages]);
?>
