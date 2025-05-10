<?php
session_start();
include '../includes/database.php';

// Kiểm tra phương thức HTTP
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: index.php?error=empty");
    exit();
}

// Hàm kiểm tra khách hàng
function checkCustomer($email, $password, $conn) {
    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        if (password_verify($password, $customer['password'])) {
            $_SESSION['user'] = [
                'id' => $customer['id'],
                'name' => $customer['name'],
                'email' => $customer['email'],
                'phone' => $customer['phone'],
                'address' => $customer['address'],
                'avatar' => $customer['avatar'],
                'gender' => $customer['gender'],
                'detailed_address' => $customer['detailed_address'],
                'role' => 'customer'
            ];
            header("Location: ../index.php");
            exit();
        }
    }
}

// Hàm kiểm tra nhân viên
function checkEmployee($email, $password, $conn) {
    $sql = "SELECT * FROM employees WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        if (password_verify($password, $employee['password'])) {
            $_SESSION['user'] = [
                'id' => $employee['id'],
                'name' => $employee['name'],
                'email' => $employee['email'],
                'phone' => $employee['phone'],
                'address' => $employee['address'],
                'position' => $employee['position'],
                'status' => $employee['status'],
                'created_at' => $employee['created_at'],
                'date_of_birth' => $employee['date_of_birth'],
                'avatar' => $employee['avatar'],
                'role' => 'employees'
            ];
            header("Location: ../employee/dashboard.php");
            exit();
        }
    }
}

// Hàm kiểm tra admin
function checkAdmin($email, $password, $conn) {
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user'] = [
                'id' => $admin['id'],
                'name' => $admin['name'],
                'email' => $admin['email'],
                'phone' => $admin['phone'],
                'avatar' => $admin['avatar'],
                'gender' => $admin['gender'],
                'address' => $admin['address'],
                'status' => $admin['status'],
                'created_at' => $admin['created_at'],
                'role' => 'admin'
            ];
            header("Location: ../admin/dashboard.php");
            exit();
        }
    }
}

// Gọi các hàm kiểm tra
checkCustomer($email, $password, $conn);
checkEmployee($email, $password, $conn);
checkAdmin($email, $password, $conn);

// Nếu không khớp
header("Location: index.php?error=invalid");
exit();