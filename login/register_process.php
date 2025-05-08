<?php
session_start();
include '../includes/database.php';

// Kiểm tra phương thức HTTP
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

// Kiểm tra dữ liệu
if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($phone) || empty($address)) {
    header("Location: register.php?error=empty");
    exit();
}

if ($password !== $confirm_password) {
    header("Location: register.php?error=password_mismatch");
    exit();
}

// Kiểm tra email đã tồn tại chưa
$sql = "SELECT id FROM customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: register.php?error=email_exists");
    exit();
}

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Thêm khách hàng mới
$sql = "INSERT INTO customer (name, email, password, phone, address, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);

if ($stmt->execute()) {
    header("Location: register.php?success=1");
} else {
    header("Location: register.php?error=database");
}
exit();
?>