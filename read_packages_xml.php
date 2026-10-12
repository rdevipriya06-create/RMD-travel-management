<?php
// ===============================================
// Reads xml/packages.xml and returns package list as JSON
// Demonstrates: reading / parsing XML data
// ===============================================
require_once "config/db.php";

$xmlFile = __DIR__ . "/xml/packages.xml";

if (!file_exists($xmlFile)) {
    send_json(["success" => false, "message" => "packages.xml not found"]);
}

$xml = simplexml_load_file($xmlFile);

$packages = [];

foreach ($xml->package as $pkg) {
    $features = [];
    foreach ($pkg->features->feature as $f) {
        $features[] = (string)$f;
    }

    $packages[] = [
        "name"        => (string)$pkg->name,
        "destination" => (string)$pkg->destination,
        "duration"    => (string)$pkg->duration,
        "price"       => (float)$pkg->price,
        "features"    => $features
    ];
}

send_json(["success" => true, "packages" => $packages]);
?>
