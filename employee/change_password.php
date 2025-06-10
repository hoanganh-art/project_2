<?php
session_start();
require_once("../includes/database.php"); // Kết nối đến cơ sở dữ liệu

// Kiểm tra phương thức HTTP
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}

$password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (isset($_SESSION['user']['id'])) {
    $userId = $_SESSION['user']['id'];

    // Kiểm tra mật khẩu cũ
    $sql = "SELECT password FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        if ($new_password === $confirm_password) {
            // Cập nhật mật khẩu mới
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE employees SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $new_hashed_password, $userId);

            if ($stmt->execute()) {
                header('Location: account.php?success=1');
                exit();
            } else {
                header('Location: account.php?success=0');
                exit();
            }
        } else {
            header('Location: account.php?success=0');
            exit();
        }
    } else {
        header('Location: account.php?success=0');
        exit();
    }
} else {
    header('Location: account.php?success=0');
    exit();
}
?>