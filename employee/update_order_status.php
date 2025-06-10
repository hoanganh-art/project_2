<?php
header('Content-Type: application/json');
require_once('../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($order_id > 0 && in_array($status, ['pending', 'processing', 'shipped', 'completed', 'cancelled'])) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $order_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
    echo json_encode(['success' => false, 'error' => 'Invalid input or database error']);
    exit;
}
echo json_encode(['success' => false, 'error' => 'Invalid request method']);
exit;