<?php
require_once('../includes/database.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized access']));
}

$response = ['status' => 'error', 'message' => 'Invalid request'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $original_price = $_POST['original_price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $category = $_POST['category'] ?? '';
        $subcategory = $_POST['subcategory'] ?? '';
        $code = $_POST['code'] ?? '';
        $status = $_POST['status'] ?? 'active';
        $description = $_POST['description'] ?? '';
        $current_image = $_POST['current_image'] ?? '';

        // Xử lý upload ảnh mới
        $image = $current_image;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = '../assets/image_products/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Xóa ảnh cũ nếu có
                if (!empty($current_image)) {
                    $oldImagePath = $uploadDir . $current_image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $image = $fileName;
            }
        }

        // Cập nhật sản phẩm
        $sql = "UPDATE product SET 
                name = ?, 
                price = ?, 
                original_price = ?, 
                stock = ?, 
                category = ?, 
                subcategory = ?, 
                code = ?, 
                status = ?, 
                description = ?, 
                image = ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddsssssssi", $name, $price, $original_price, $stock, $category, $subcategory, $code, $status, $description, $image, $id);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Product updated successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Database error: ' . $conn->error];
        }
    }
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>