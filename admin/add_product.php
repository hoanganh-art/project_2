<?php
session_start();
include_once('../includes/database.php');

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}
// Lấy dữ liệu từ form
$name = $_POST['name'] ?? '';
$code = $_POST['code'] ?? '';
$price = $_POST['price'] ?? '';
$original_price = $_POST['original_price'] ?? '';
$category = $_POST['category'] ?? '';
$subcategory = $_POST['subcategory'] ?? '';
$stock = $_POST['stock'] ?? '';
$status = isset($_POST['status']) ? $_POST['status'] : 'active';
$description = $_POST['description'] ?? '';
$image = $_FILES['image']['name'] ?? '';

// Kiểm tra dữ liệu hợp lệ
if (empty($name) || empty($code) || empty($price) || empty($category) || empty($subcategory) || empty($stock)) {
    die("Vui lòng điền đầy đủ thông tin!");
}

// Xử lý upload hình ảnh
if (!empty($image)) {
    $target_dir = "../assets/image_products/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
}

// Thêm dữ liệu vào database
$sql = "INSERT INTO product (name, code, price, original_price, category, subcategory, stock, status, description, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssddsssiss",
    $name,
    $code,
    $price,
    $original_price,
    $category,
    $subcategory,
    $stock,
    $status,
    $description,
    $image
);

if ($stmt->execute()) {
    echo "Thêm sản phẩm thành công!";
    header("Location: manage_products.php");
    exit();
} else {
    echo "Lỗi: " . $stmt->error;
}
?>