<?php
session_start();
require_once('../includes/database.php');

if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);

    // Prepare the SQL statement to delete the employee
    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $employee_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Employee deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting employee.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Failed to prepare the SQL statement.";
    }
} else {
    $_SESSION['message'] = "No employee ID provided.";
}

// Redirect to the employees list page
header("Location: manage_employees.php");
exit();
?>