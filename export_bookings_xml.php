<?php
// ===============================================
// Creates an XML file from current MySQL booking records
// Demonstrates: creation of a relevant XML file
// ===============================================
require_once "config/db.php";

$result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");

$xml = new SimpleXMLElement("<bookings/>");

while ($row = $result->fetch_assoc()) {
    $booking = $xml->addChild("booking");
    $booking->addChild("booking_ref", htmlspecialchars($row['booking_ref']));
    $booking->addChild("customer_name", htmlspecialchars($row['customer_name']));
    $booking->addChild("customer_email", htmlspecialchars($row['customer_email']));
    $booking->addChild("package_name", htmlspecialchars($row['package_name']));
    $booking->addChild("travel_date", $row['travel_date']);
    $booking->addChild("persons", $row['persons']);
    $booking->addChild("total_amount", $row['total_amount']);
    $booking->addChild("status", $row['status']);
}

$xmlFile = __DIR__ . "/xml/bookings_export.xml";
$xml->asXML($xmlFile);

// Offer the file for download
header("Content-Type: application/xml");
header("Content-Disposition: attachment; filename=bookings_export.xml");
echo $xml->asXML();
exit;
?>
