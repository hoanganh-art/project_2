<?php
session_start();
require_once("../includes/database.php"); // Kết nối đến cơ sở dữ liệu

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}

// Lấy dữ liệu từ form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$position = $_POST['position'] ?? '';
$date_of_birth = $_POST['date_of_birth'] ?? '';
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$address = $_POST['address'] ?? '';

// Kiểm tra dữ liệu
if (empty($name) || empty($email) || empty($phone) || empty($position) || empty($date_of_birth) || empty($password)) {
    echo "Vui lòng điền đầy đủ thông tin!";
    exit();
}

// Thêm nhân viên vào cơ sở dữ liệu
$sql = "INSERT INTO employees (name, email, phone, position, date_of_birth, password, address, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssss', $name, $email, $phone, $position, $date_of_birth, $password, $address);

if ($stmt->execute()) {
    // Chuyển hướng về trang quản lý nhân viên với thông báo thành công
    header("Location: manage_employees.php?success=1");
    exit();
} else {
    echo "Thêm nhân viên thất bại: " . $stmt->error;
}
