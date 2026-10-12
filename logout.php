<?php
session_start();
require_once "config/db.php";
session_unset();
session_destroy();
send_json(["success" => true, "message" => "Logged out successfully."]);
?>
