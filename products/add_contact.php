<?php
session_start();
require_once('../includes/database.php'); 

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}

// Lấy dữ liệu từ form
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Thêm dữ liệu vào database
$sql = "INSERT INTO contact (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
    if ($stmt->execute()) {
        header("Location: contact.php");
        exit;
        // echo "Thêm liên hệ thành công!";
    } else {
        echo "Lỗi khi thêm liên hệ: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Lỗi truy vấn: " . $conn->error;
}
?>