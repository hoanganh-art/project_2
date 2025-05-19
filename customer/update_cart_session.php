<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartItems = json_decode(file_get_contents('php://input'), true);
    if (is_array($cartItems)) {
        $_SESSION['cart_items'] = $cartItems;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
    }
    exit;
}
?>