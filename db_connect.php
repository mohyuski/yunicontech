<?php
// ==============================================
// Database Connection Settings
// (XAMPP default settings - change if needed)
// ==============================================

$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "yunicon_tech";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    header("Content-Type: application/json");
    die(json_encode([
        "status"  => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}
?>
