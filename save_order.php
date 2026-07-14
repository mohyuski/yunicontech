<?php
header("Content-Type: application/json");
require "db_connect.php";

// Get JSON data sent from script.js
$data = json_decode(file_get_contents("php://input"), true);

$name           = isset($data['name']) ? trim($data['name']) : '';
$phone          = isset($data['phone']) ? trim($data['phone']) : '';
$address        = isset($data['address']) ? trim($data['address']) : '';
$product_name   = isset($data['product_name']) ? trim($data['product_name']) : '';
$product_price  = isset($data['product_price']) ? trim($data['product_price']) : '';
$payment_method = isset($data['payment_method']) ? trim($data['payment_method']) : 'Cash on Delivery';

// Basic validation
if (empty($name) || empty($phone) || empty($address)) {
    echo json_encode([
        "status"  => "error",
        "message" => "Name, phone and address are required"
    ]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO orders (name, phone, address, product_name, product_price, payment_method)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssssss", $name, $phone, $address, $product_name, $product_price, $payment_method);

if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Order placed successfully"
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => "Failed to save order: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
