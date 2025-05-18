z<?php
session_start();
require_once('../includes/database.php');

$id = intval($_POST['id']);
$quantity = intval($_POST['quantity']);

// Giả sử bảng cart có cột id (product id) và quantity
$sql = "UPDATE cart SET quantity = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $quantity, $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);