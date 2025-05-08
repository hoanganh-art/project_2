<?php
session_start();
require_once('../includes/database.php');

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    $sql = "DELETE FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "product deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting product.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Failed to prepare the SQL statement.";
    }
} else {
    $_SESSION['message'] = "No product ID provided.";
}

header("location: manage_products.php");
exit();
?>