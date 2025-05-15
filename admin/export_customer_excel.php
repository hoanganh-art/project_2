<?php
include_once("../includes/database.php");

// Lấy dữ liệu khách hàng
$sql = "SELECT id, name, email, phone FROM customer";
$result = $conn->query($sql);

// Tạo file Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=customers_export_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");


echo "\xEF\xBB\xBF"; // Thêm BOM UTF-8 để Excel nhận diện đúng định dạng
// Xuất tiêu đề cột
echo "ID\t | Tên | \tEmail |\tSố điện thoại\n";

// Xuất dữ liệu
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Đảm bảo không có tab hoặc xuống dòng trong dữ liệu
        $id = str_replace(["\t", "\n", "\r"], ' ', $row['id']);
        $name = str_replace(["\t", "\n", "\r"], ' ', $row['name']);
        $email = str_replace(["\t", "\n", "\r"], ' ', $row['email']);
        $phone = str_replace(["\t", "\n", "\r"], ' ', $row['phone']);
        // Không cần dấu ngoặc kép
        echo "$id \t$name\t$email\t$phone\n";
    }
}

$conn->close();
exit;
?>