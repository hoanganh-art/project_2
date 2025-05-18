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
// $image = $_FILES['image']['name'] ?? '';

// Kiểm tra dữ liệu hợp lệ
if (empty($name) || empty($code) || empty($price) || empty($category) || empty($subcategory) || empty($stock)) {
    die("Vui lòng điền đầy đủ thông tin!");
}

// Xử lý upload hình ảnh

if (isset($_FILES['image']) && $_FILES['image']['name'] === UPLOAD_ERR_OK) {
    $uploadDir = '../assets/product/';
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Kiểm tra định dạng file

    if (in_array($fileExtension, $allowedExtensions)) {
        // Đặt tên file mới để tránh trùng lặp
        $newFileName = uniqid('product', true) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
            chmod($uploadDir, 0755);
        }

        // Di chuyển file vào thư mục đích
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $image = $destPath; // <-- Corrected line
        } else {
            echo "Lỗi khi lưu file.";
            exit();
        }
    } else {
        echo "Định dạng file không hợp lệ!";
        exit();
    }
}
// if (!empty($image)) {
//     $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
//     $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
//     if (!in_array($file_ext, $allowed_types)) {
//         die("Định dạng hình ảnh không hợp lệ!");
//     }
//     if ($_FILES['image']['size'] > 2 * 1024 * 1024) { // 2MB
//         die("Kích thước hình ảnh vượt quá giới hạn cho phép!");
//     }
//     $new_image_name = uniqid('img_', true) . '.' . $file_ext;
//     $target_dir = "../assets/image_products/";
//     $target_file = $target_dir . $new_image_name;
//     if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
//         die("Lỗi khi tải lên hình ảnh!");
//     }
//     $image = $new_image_name;
// }

// Thêm dữ liệu vào database
$sql = "INSERT INTO product (name, code, price, original_price, category, subcategory, stock, status, description, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssddssssss",
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
    echo "Thêm sản phẩm thành công! Trạng thái: " . $status;
    header("Location: manage_products.php");
    exit();
} else {
    echo "Lỗi: " . $stmt->error;
}
