<?php
session_start();
require_once('../includes/database.php');

if (!isset($_SESSION['user']['id'])) {
    header('Location: ../login.php');
    exit;
}

$customer_id = $_SESSION['user']['id'];
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Lấy danh sách sản phẩm từ đơn hàng cũ
$sql = "SELECT product_id, quantity, color, size FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $color = $row['color'];
    $size = $row['size'];

    // Kiểm tra sản phẩm đã có trong giỏ chưa (theo cả color và size)
    $check = $conn->prepare("SELECT id FROM cart WHERE customer_id = ? AND product_id = ? AND color = ? AND size = ?");
    $check->bind_param("iiss", $customer_id, $product_id, $color, $size);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        // Nếu đã có, cập nhật số lượng
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE customer_id = ? AND product_id = ? AND color = ? AND size = ?");
        $update->bind_param("iiiss", $quantity, $customer_id, $product_id, $color, $size);
        $update->execute();
    } else {
        // Nếu chưa có, thêm mới vào giỏ
        $insert = $conn->prepare("INSERT INTO cart (customer_id, product_id, quantity, color, size) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iiiss", $customer_id, $product_id, $quantity, $color, $size);
        $insert->execute();
    }
}

// Chuyển hướng sang trang giỏ hàng
header('Location: cart1.php?reorder=success');
exit;
?>