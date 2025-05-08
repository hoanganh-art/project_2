<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}

include('../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $sql = "UPDATE employees SET 
            name = ?, 
            email = ?, 
            phone = ?, 
            position = ?, 
            date_of_birth = ?, 
            address = ?, 
            status = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $name, $email, $phone, $position, $date_of_birth, $address, $status, $id);
    
    if ($stmt->execute()) {
        header("Location: manage_employees.php?success=1");
    } else {
        header("Location: manage_employees.php?error=1");
    }
    exit();
}

header("Location: manage_employees.php");
?>