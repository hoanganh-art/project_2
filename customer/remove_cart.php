<?php

session_start();
require_once('../includes/database.php');

$id = intval($_POST['id']);

// Xóa sản phẩm khỏi giỏ hàng (bảng cart)
$sql = "DELETE FROM cart WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
