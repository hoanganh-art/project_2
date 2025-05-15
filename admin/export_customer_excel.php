<?php
include_once("../includes/database.php");

// Lấy dữ liệu khách hàng
$sql = "SELECT id, name, email, phone, address, created_at, status FROM customer";
$result = $conn->query($sql);

// Tạo file Excel với định dạng UTF-8 và phân tách cột bằng dấu phẩy
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=customers_export_" . date('Ymd_His') . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen('php://output', 'w');

// Thêm BOM UTF-8 để Excel nhận diện đúng định dạng
fwrite($output, "\xEF\xBB\xBF");

// Xuất tiêu đề cột
fputcsv($output, [
    'ID', 
    'Tên khách hàng', 
    'Email', 
    'Số điện thoại', 
    'Địa chỉ', 
    'Ngày đăng ký', 
    'Trạng thái'
], ',');

// Xuất dữ liệu
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['email'],
            "84+".$row['phone'],
            $row['address'],
            $row['created_at'],
            $row['status'] == 'active' ? 'Đang hoạt động' : 'Ngừng hoạt động'
        ], ',');
    }
}

fclose($output);
$conn->close();
exit;
?>