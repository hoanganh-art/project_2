<?php
include('../includes/database.php');

// Kiểm tra session và quyền truy cập
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php');
    exit();
}

// Truy vấn dữ liệu sản phẩm và sắp xếp theo tên tăng dần
$sql = "SELECT * FROM product ORDER BY name ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

// Tạo file Excel với định dạng UTF-8 và phân tách cột bằng dấu phẩy
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=products_export_" . date('Ymd_His') . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen('php://output', 'w');
// Thêm BOM UTF-8 để Excel nhận diện đúng định dạng
fwrite($output, "\xEF\xBB\xBF");
// Xuất tiêu đề cột
fputcsv($output, [
    'STT',
    'Tên sản phẩm',
    'Danh mục',
    'Mô tả',
    'Giá',
    'Số lượng',
    'Trạng thái'
], ',');
// Xuất dữ liệu
$i = 0;
if ($result->num_rows > 0) {
    foreach ($products as $product) {
        fputcsv($output, [
            ++$i,
            $product['name'] ?? '',
            $product['subcategory'] ?? '',
            $product['description'] ?? '',
            $product['price'] ?? '',
            $product['stock'] ?? '0',
            $product['status'] == 'active' ? 'Còn hàng' : 'Hết hàng'
        ], ',');
    }
}
fclose($output);
$conn->close();
exit;
