<?php
session_start();
require_once('../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Cập nhật session cart_items
    $_SESSION['cart_items'] = array_map(function ($item) use ($input) {
        foreach ($input as $updatedItem) {
            if ($item['cart_id'] == $updatedItem['cart_id']) {
                $item['quantity'] = $updatedItem['quantity'];
            }
        }
        return $item;
    }, $_SESSION['cart_items']);

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);
?>